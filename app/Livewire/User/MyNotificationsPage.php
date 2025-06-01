<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\BlockUserEvent;
use App\Events\NotificationsDeletingEvent;
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
        
        $user = auth_user();

        $search = null;

        if($this->search && strlen($this->search) >= 2){

            $search = $this->search;
            
        }

        $notif_sections = ['unread' => "Non lues", 'read' => "Lues"];

        $my_notifications = [];

        $data = [];

        if($this->sectionned == 'read') {

            $data = User::find(auth_user()->id)->readNotifications;
        }
        elseif($this->sectionned == 'unread') {

            $data = User::find(auth_user()->id)->unreadNotifications;
        }

        foreach($data as $notif){

            $my_notifications[] = $notif;

        }

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


   

    public function deleteNotification($notif_id)
    {
        
        $notif =  User::find(auth_user()->id)->notifications()->where('id', $notif_id)->first();

        if($notif){

            if($notif->read_at){

                $notif->delete();

                $message = "La notification a été supprimée avec success!";
        
                $this->toast($message, 'success');


            }
            else{

                $notif->markAsRead();

                $message = "La notification a été marquée comme lue et envoyée dans la section des notifications lues avec success!";
        
                $this->toast($message, 'success');

            }

            $this->counter = getRandom();

        }
       
    }

    public function deleteAllNotifications()
    {
        $user = auth_user();


        if($user){

            if($this->sectionned == 'read'){

                $notifs =  User::find(auth_user()->id)->readNotifications;

                foreach($notifs as $notif){

                    $notif->delete();

                }


            }
            elseif($this->sectionned == 'unread'){

                $notifs =  User::find(auth_user()->id)->unreadNotifications;

                foreach($notifs as $notif){

                    $notif->delete();

                }

            }

            $this->counter = getRandom();

            
        }
       
    }


    public function deleteNotificationsLL($section = null)
    {
        $user = auth_user();

        $my_notifications = User::find($user->id)->getMyIncommingNotifications(null, null, $this->sectionned);

        if($my_notifications){

            NotificationsDeletingEvent::dispatch($user, $my_notifications);

        }
    }



    public function deleteNotifications($section = null)
    {

        $user = auth_user();

        $my_notifications = User::find($user->id)->getMyIncommingNotifications(null, null, $this->sectionned);

        if(count($my_notifications)){

            $notif_sections = config('app.notifications_sections');

            $sec = $notif_sections[$this->sectionned];

            $options = ['event' => 'confirmedDeleteNotifications', 'data' => ['user_id' => $user->id]];

            $this->confirm("Vous êtes sur le point de supprimer toutes les notifications " . $sec, "Cette action est irréversible", $options);
        }

    }

    #[On('confirmedDeleteNotifications')]
    public function onConfirmationDeleteNotifications($data)
    {

        if($data){

            $user_id = $data['user_id'];

            $user = User::find($user_id);

            $my_notifications = $user->getMyIncommingNotifications(null, null, $this->sectionned);

            if(count($my_notifications)){

                NotificationsDeletingEvent::dispatch($user, $my_notifications);

                $this->toast( "L'opération a été lancé!", 'success');

            }
            else{

                $this->toast( "L'opération a échoué! Veuillez réessayer!", 'error');
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


    #[On('LiveNotificationsDeletedSuccessfullyEvent')]
    public function reloadData()
    {
        $this->counter = getRandom();
    }

}
