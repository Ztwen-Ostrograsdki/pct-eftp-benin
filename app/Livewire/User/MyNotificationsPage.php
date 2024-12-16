<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\BlockUserEvent;
use App\Models\ENotification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Mes Notifications")]
class MyNotificationsPage extends Component
{
    use Confirm, Toast;

    public $sectionned = null;

    public $search = '';

    protected $listeners = [
        'LiveNotificationDispatchedToAdminsSuccessfullyEvent' => 'newNotifications',
        'LiveUserHasBeenBlockedSuccessfullyEvent' => 'userUnBlockedSuccessfully',
    ];


    public function render()
    {
        $user = Auth::user();

        $search = null;

        if($this->search && strlen($this->search) >= 2){

            $search = $this->search;
            
        }

        $notif_sections = config('app.notifications_sections');

        $my_notifications = $user->getMyIncommingNotifications(null, $search, $this->sectionned);

        return view('livewire.user.my-notifications-page', compact('my_notifications', 'notif_sections'));
    }

    public function updatedSearch($search)
    {
        $this->search = $search;
    }

    public function updatedSectionned($sectionned)
    {
        $this->sectionned = $sectionned;
    }

    public function newNotification($user = null)
    {
        $this->toast("Vous avez reçu une nouvelle notification!!!");
    }


    public function confirmedUserUnblocked($notif_id)
    {
        $notif = ENotification::find($notif_id);

        if($notif){

            $user = $notif->user;

        }
        else{

            $this->toast( "L'opération a échoué! Veuillez réessayer!", 'error');

        }

        if($user){

            if($user->blocked){

                $since = $user->__getDateAsString($user->blocked_at, 3, true);

                $t = "Confirmez le déblocage de " . $user->getFullName();

                $r = "Vous étes sur le point de débloquer cet utilisateur bloqué depuis " . $since;
            }

            $options = ['event' => 'confirmedTheUserUnblocked', 'data' => ['notif_id' => $notif_id]];

            $this->confirm($t, $r, $options);
        }

    }

    #[On('confirmedTheUserUnblocked')]
    public function onConfirmationTheUserUnblocked($data)
    {
        if($data){

            $user = null;

            $notif = null;

            $act = null;

            $notif_id = $data['notif_id'];

            $notif = ENotification::find($notif_id);

            if($notif) $user = $notif->user;

            if($user) $act = $user->userBlockerOrUnblockerRobot(false);

            if($act){

                $message = "Le processus de déblocage a été lancé avec success!";

                $this->toast($message, 'success');

                to_flash('success', $message);

                $this->deleteNotif($notif_id);

            }
            else{

                $this->toast( "L'opération a échoué! Veuillez réessayer!", 'error');

            }
        }

    }

    public function markAsRead($notif_id)
    {
        $notif = ENotification::find($notif_id);

        $user = auth_user();

        if($notif){

            $seen_by = $notif->seen_by;

            $seen_by[] = $user->id;
        }

        $notif->update(['seen_by' => $seen_by]);

        $message = "La notification a été marquée comme lue et envoyée dans la section des notifications lues avec success!";

        $this->toast($message, 'success');
    }


    public function deleteNotif($notif_id)
    {
        $notif = ENotification::find($notif_id);

        $notif->delete();

        $message = "La notification a été supprimée avec success!";

        $this->toast($message, 'success');
    }
    
    public function sendEmailTo($notif_id)
    {
        $notif = ENotification::find($notif_id);

        if($notif) $user = $notif->user;

        if(!$notif) return $this->toast("Envoie de mail en cours...", 'success');

        if($user){

            $message = "Envoie de mail en cours...";

            $this->toast($message, 'success');

        }

        
    }


    public function userUnBlockedSuccessfully($user)
    {
        
        if($user && !$user['blocked']){

            $message = "L'utilisateur a été débloqué avec success!";

            $this->toast($message, 'success');

            to_flash('success', $message);

        }
        else{

            $this->toast( "L'opération a échoué! Veuillez réessayer!", 'error');

        }
    }

}
