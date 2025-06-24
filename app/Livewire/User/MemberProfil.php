<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\BlockUserEvent;
use App\Events\InitProcessToSendSimpleMailMessageToUsersEvent;
use App\Events\MemberCreationOrUpdatingManagerEvent;
use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Helpers\Services\EmailTemplateBuilder;
use App\Helpers\Tools\ModelsRobots;
use App\Helpers\Tools\SpatieManager;
use App\Jobs\JobToSendSimpleMailMessageTo;
use App\Mail\YourCardMemberIsReadyMail;
use App\Models\Member;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

class MemberProfil extends Component
{
    use Toast, Confirm, ListenToEchoEventsTrait;
    
    public $user;

    public $member;

    public $counter = 0;

    public function mount($identifiant)
    {
        if($identifiant){

            $user = getUser($identifiant, 'identifiant');

            if($user){

                $this->user = $user;

                if($user->member) 

                    $this->member = $user->member;

                else 
                    return abort(403, "Accès non authorisé");
            }

            if(!$user) return abort(404, "La page est introuvable");
        }
    }

    public function render()
    {
        return view('livewire.user.member-profil');
    }


    public function demandeToGetMyCard()
    {
        $member = $this->member;

        $user = $member->user;

        $admins = ModelsRobots::getAllAdmins(['members-manager'], 10);

        $message_to_admins = "DEMANDE DE CARTE DE MEMBRE : " . $user->getFullName() . " vient de faire la demande de sa carte de membre";

        Notification::sendNow($admins, new RealTimeNotificationGetToUser($message_to_admins));

        $receivers_details = [];

        foreach($admins as $admin){

            $receivers_details[] = [
                'email' => $admin->email,
                'full_name' => $admin->getFullName(),
                'message' => $message_to_admins,
                'file_to_attach' => null,
                'lien' => null

            ];

        }

        InitProcessToSendSimpleMailMessageToUsersEvent::dispatch($receivers_details);

        return $this->toast("Votre demande a été envoyée avec succès aux différentes organes en charge!", 'success');
    }

    public function downloadMyCard()
    {
        
        $member = $this->member;

        $user = $member->user;

        $has_card = $member->card();

        if($user->id != auth_user()->id){

            return $this->toast("Vous n'êtes pas authorisé à télécharger la carte de membre d'un autre membre!", 'info');

        }

        if($has_card){

            if($has_card->isPrintable()){

                if(!$has_card->max_print_attempt()){

                    $path = $has_card->status;

                    $up = $has_card->total_print + 1;

                    $now = Carbon::now();

                    if(__isConnectedToInternet()){

                        $association = env('APP_NAME');

                        $lien = route('user.profil', ['identifiant' => $user->identifiant]);

                        $html = EmailTemplateBuilder::render('member-card', [
                            'name' => $user->getFullName(true),
                            'poste' => $user->getMemberRoleName(),
                            'association' => $association,
                            'lien' => $lien,
                            'email' => $user->email,
                            'identifiant' => $user->identifiant
                        ]);

                        $sent = Mail::to($user->email)->send(new YourCardMemberIsReadyMail($user, $path, $html));

                        if($sent){

                            $message_to_user = "Veuillez vérifier votre boite mail: votre carte vous a été envoyée par couriel!";

                            Notification::sendNow([$user], new RealTimeNotificationGetToUser($message_to_user));

                            $this->member->update(['card_sent_by_mail' => true]);
                        
                            $has_card->update(['card_sent_by_mail' => true]);

                            $has_card->update(['total_print' => $up, 'last_print_date' => $now]);
                        }
                    
                    }
                    else{

                        $message_to_user = "Veuillez vous connecter à internet pour télécharger votre carte!";

                        Notification::sendNow([$user], new RealTimeNotificationGetToUser($message_to_user));

                    }

                }
                else{

                    return $this->toast("Vous avez déjà atteint le nombre maximal d'impressions de votre carte de membre!", 'info');
                }

            }
            else{

                return $this->toast("Cette carte ne peut être imprimée, Veuillez contacter les administrateurs!", 'info');


            }
        }
    }

    public function confirmedUserIdentification()
    {
        SpatieManager::ensureThatUserCan(['users-manager']);

        $user = $this->user;

        $user_id = $this->user->id;

        if($user){

            if($user->confirmed_by_admin) return $this->toast("Cet utilisateur est déjà identifié", 'success');

            $options = ['event' => 'confirmedTheUserIdentification', 'data' => ['user_id' => $user_id]];

            $this->confirm("Confirmation l'indentification de " . $user->getFullName(true), "Cette action est irréversible", $options);
        }

    }

    #[On('confirmedTheUserIdentification')]
    public function onConfirmationTheUserIdentification($data)
    {

        if($data){

            $user_id = $data['user_id'];

            $user = User::find($user_id);

            $user = $user->confirmedThisUserIdentification();

            if($user){

                $message = "L'identification a été confirmée avec success!";

                $this->toast($message, 'success');

                session()->flash('success', $message);

            }
            else{

                $this->toast( "L'opération a échoué! Veuillez réessayer!", 'error');

            }
        }

    }


    public function confirmedUserBlockOrUnblocked()
    {

        SpatieManager::ensureThatUserCan(['users-manager']);

        $user = $this->user;

        if($user->isMaster()){

            return $this->toast( "Vous ne pouvez pas effectuer une telle opération sur cet utilisateur!", 'error');
    
        }

        $user_id = $this->user->id;

        if($user){

            if($user->blocked){

                $since = $user->__getDateAsString($user->blocked_at, 3, true);

                $t = "Confirmez le déblocage de " . $user->getFullName();

                $r = "Vous étes sur le point de débloquer cet utilisateur bloqué depuis " . $since;
            }
            else{

                $t = "Confirmez le blocage de " . $user->getFullName();

                $r = "Vous étes sur le point de bloquer cet utilisateur";

            }

            $options = ['event' => 'confirmedTheUserBlockOrUnblocked', 'data' => ['user_id' => $user_id]];

            $this->confirm($t, $r, $options);
        }

    }

    #[On('confirmedTheUserBlockOrUnblocked')]
    public function onConfirmationTheUserBlockOrUnblocked($data)
    {
        $action = true;

        if($data){

            $user_id = $data['user_id'];

            $user = User::find($user_id);


            if($user->blocked) $action = false;

            if($action == false){

                $user = $user->userBlockerOrUnblockerRobot($action);

                if($user){

                    $message = "Le processus de blocage a été lancé avec success!";
    
                    if(!$action) $message = "Le processus de déblocage a été lancé avec success!" ;
    
                    $this->toast($message, 'success');
    
                    session()->flash('success', $message);
    
                }
                else{
    
                    $this->toast( "L'opération a échoué! Veuillez réessayer!", 'error');
    
                }
            }
            else{

                $dispatched = BlockUserEvent::dispatch($user, auth_user());

                $this->toast( "L'opération a été lancée!", 'success');
            }
            
        }

    }


    public function confirmedUserEmailVerification()
    {
        SpatieManager::ensureThatUserCan(['users-manager']);

        $user = $this->user;

        $user_id = $this->user->id;

        if($user){

            $t = "Confirmez l'addresse mail de " . $user->getFullName();

            $r = "Vous étes sur le point de confirmer l'addresse mail de cet utilisateur";


            $options = ['event' => 'confirmedTheUserEmailVerification', 'data' => ['user_id' => $user_id]];

            $this->confirm($t, $r, $options);
        }

    }

    #[On('confirmedTheUserEmailVerification')]
    public function onConfirmationTheUserEmailVerification($data)
    {
        if($data){

            $user_id = $data['user_id'];

            $user = User::find($user_id);

            $verified = $user->markAsVerified();

            if($verified){

                $message = "L'utilisateur a été confirmé avec success!";

                $this->toast($message, 'success');

                session()->flash('success', $message);

            }
            else{

                $this->toast( "La confirmation a échoué! Veuillez réessayer!", 'error');

            }
        }

    }

    public function editRole($member_id = null)
    {
        SpatieManager::ensureThatUserCan(['members-manager', 'postes-manager']);

        $member_id = $this->member->id;

        $this->dispatch('OpenMemberModalForEditEvent', $member_id);
    }

    public function resetMemberRoleToNull()
    {
        SpatieManager::ensureThatUserCan(['members-manager', 'postes-manager']);

        $user = $this->user;

        $member = $user->member;

        if($member){

            $name = $user->getFullName();

            $html = "<h6 class='font-semibold text-base text-orange-400 py-0 my-0'>
                            <p>Voulez-vous vraiment Réinitialiser le poste de  </p>
                            <p class='text-sky-600 py-0 my-0 font-semibold'> Mr/Mme {$name} </p>
                    </h6>";

            $noback = "<p class='text-orange-600 letter-spacing-2 py-0 my-0 font-semibold'> Cette action est réversible! </p>";

            $options = ['event' => 'confirmedMemberRoleReseting', 'confirmButtonText' => 'Validé', 'cancelButtonText' => 'Annulé', 'data' => ['member_id' => $member->id]];

            $this->confirm($html, $noback, $options);
            
        }
        else{

            $this->toast( "La suppression ne peut être effectuée: Membre inconnu! Veuillez vérifier les données et réessayer!", 'warning');
        }
    }



    #[On('confirmedMemberRoleReseting')]
    public function onConfirmationMemberRoleReseting($data)
    {
        if($data){

            $member_id = $data['member_id'];

            $member = Member::find($member_id);

            if($member){

                $admin = auth_user();

                $user = $member->user;

                $data = ['role_id' => null];

                $dispatched = MemberCreationOrUpdatingManagerEvent::dispatch($admin, $user, $data, $member);

                if($dispatched){

                    $this->reset();

                    $this->toast("Le proccessus a été lancé!", 'success');

                    
                }

            }
            else{

                $this->toast( "Erreur membre introuvabel!", 'error');
            }

        }

    }

    #[On('UserProfilUpdated')]
    public function reloadData()
    {
        $this->counter = rand(3, 133);
    }

    #[On('LiveUserMemberProfilHasBeenCreatedEvent')]
    public function reloadDataForMember()
    {
        $this->counter = getRand();
    }

    #[On('LiveUpdatedUserProfilEvent')]
    public function reloadDataForUser()
    {
        $this->counter = getRand();
    }
}
