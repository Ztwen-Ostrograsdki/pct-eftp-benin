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

    public $counter = 1;

    public $sectionned = 'unread';

    public $search = '';

    protected $listeners = [
        'LiveIHaveNewNotificationEvent' => 'reloadNotificationsData',
        'LiveNotificationDispatchedToAdminsSuccessfullyEvent' => 'reloadNotificationsData',
        'LiveUserHasBeenBlockedSuccessfullyEvent' => 'userUnBlockedSuccessfully',
    ];


    public function render()
    {
        if(session()->has('my-notification-section')){

            $this->sectionned = session('my-notification-section');

        }
        
        $user = Auth::user();

        $search = null;

        if($this->search && strlen($this->search) >= 2){

            $search = $this->search;
            
        }

        $notif_sections = config('app.notifications_sections');

        $my_notifications = User::find($user->id)->getMyIncommingNotifications(null, $search, $this->sectionned);

        return view('livewire.user.my-notifications-page', compact('my_notifications', 'notif_sections'));
    }

    public function updatedSearch($search)
    {
        $this->search = $search;
    }

    public function updatedSectionned($sectionned)
    {
        $this->sectionned = $sectionned;

        session()->put('my-notification-section', $sectionned);
    }

    public function reloadNotificationsData($user = null)
    {
        $this->toast("Vous avez reçu une nouvelle notification!!!");
    }


   

    public function markAsRead($notif_id)
    {
        $notif = ENotification::find($notif_id);

        $user = auth_user();

        if($notif){

            $seen_by = $notif->seen_by;

            if(!in_array($user->id, $seen_by)){

                $seen_by[] = $user->id;

                $notif->update(['seen_by' => $seen_by]);

                $message = "La notification a été marquée comme lue et envoyée dans la section des notifications lues avec success!";
        
                $this->toast($message, 'success');
        
                $this->counter = rand(3, 65);
            }
        }

       
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
