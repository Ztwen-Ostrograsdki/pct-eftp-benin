<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\BlockUserEvent;
use App\Helpers\Services\EmailTemplateBuilder;
use App\Mail\YourCardMemberIsReadyMail;
use App\Models\User;
use App\Notifications\RealTimeNotificationGetToUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

class MemberProfil extends Component
{
    use Toast, Confirm;
    
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

    public function downloadMyCard()
    {
        $member = $this->member;

        $has_card = $member->card();

        if($has_card){

            if($has_card->isPrintable()){

                if(!$has_card->max_print_attempt()){

                    $user = $member->user;

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

        $user = $this->user;

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

                BlockUserEvent::dispatch($user);

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
            
        }

    }


    public function userBlockedSuccessfully($user)
    {
        
        if($user && $user['blocked']){

            $message = "L'utilisateur a été bloqué avec success!";

            $this->toast($message, 'success');

            session()->flash('success', $message);

        }
        else{

            $this->toast( "L'opération a échoué! Veuillez réessayer!", 'error');

        }
    }

    public function confirmedUserEmailVerification()
    {

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
        $member_id = $this->member->id;

        $this->dispatch('OpenMemberModalForEditEvent', $member_id);
    }

    public function removeUserFormMembers($member_id = null)
    {
        if(!__isAdminAs()) return abort(403, "Vous n'êtes pas authorisé!");

        $member = $this->member;

        if($member){

            $options = ['event' => 'confirmedMemberRetrieving'];

            $this->confirm("Confirmation de la suppression ou du retrait de " . $member->user->getFullName(true) . " de la liste des membres!", "Cette action est irréversible", $options);
        }
        else{

            $this->toast( "La suppression ne peut être effectuée: Membre inconnu! Veuillez vérifier les données et réessayer!", 'warning');
        }
    }

    #[On('confirmedMemberRetrieving')]
    public function onConfirmationMemberRetrieving()
    {
        $del = $this->member->delete();

        if($del){

            $message = "La suppression est terminée.";

            $this->toast($message, 'success');

            $this->dispatch("UpdatedMemberList");

        }
        else{

            $this->toast( "La suppression a échoué! Veuillez réessayer!", 'error');

        }

    }

    #[On('UserProfilUpdated')]
    public function reloadData()
    {
        $this->counter = rand(3, 133);
    }
}
