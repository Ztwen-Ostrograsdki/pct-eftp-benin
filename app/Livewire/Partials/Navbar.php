<?php

namespace App\Livewire\Partials;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\Communique;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    use Toast, Confirm;

    public $counter = 0;

    protected $listeners = [
        'LiveLogoutUserEvent' => 'logout',
        'LiveNotificationDispatchedToAdminsSuccessfullyEvent' => 'newNotification',
        'LiveIHaveNewNotificationEvent' => 'newNotification',

    ];

    public function mount()
    {

    }

    

    #[On('LiveYourMessageHasBeenLikedBySomeoneToTheUserEvent')]
    public function reloadMessagesForLikes($liker_data = null)
    {
        $this->counter = getRandom();

        $data_liker = new User($liker_data);

        $liker = $data_liker->getFullName();

        $this->toast("$liker a aimé votre message!", 'success');
    }

    #[On('LiveForumChatSubjectHasBeenValidatedByAdminsEvent')]
    public function forumChatSubjectValidated($user = null)
    {
        $this->counter = getRandom();

        $user = new User($user);

        $name = $user->getFullName();

        $this->toast("Un nouveau sujet de discussion a été publié sur le forum par $name", 'success');
    }
    
    #[On('LiveForumChatSubjectHasBeenValidatedByAdminsEvent')]
    public function forumChatSubjectSubmitted($user = null)
    {
        $this->counter = getRandom();

        $user = new User($user);

        $name = $user->getFullName();

        $this->toast("Un nouveau sujet de discussion a été publié sur le forum par $name", 'success');
    }
    
    #[On('LiveUpdateLawEcosystemEvent')]
    public function reloadLawData()
    {
        $this->counter = getRandom();
    }
    
    #[On('LiveNewMessageHasBeenSentIntoForum')]
    public function newMessageIntoForum()
    {
        $this->counter = getRandom();
    }

   
    
    public function render()
    {
        $communiques = Communique::where('hidden', false)->get();

        return view('livewire.partials.navbar', compact('communiques'));
    }

    public function newNotification($user = null)
    {
        $this->counter = getRandom();

        $this->toast("Vous avez reçu une nouvelle notification!!!");
    }


    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        $this->toast("Vous avez été déconneté avec succès!!!");

        return redirect(route('login'));

    }

    public function deleteProfilPhoto($path = null)
    {

        $profil_photo = auth_user()->profil_photo;

        $path = storage_path().'/app/public/' . $profil_photo;

        return File::delete($path);
        
    }

    #[On("LiveToasterMessagesEvent")]
    public function getToasters()
    {
        $this->counter = getRandom();
    }
    
    
    #[On("LiveNewLiveNotificationEvent")]
    public function realodToaster()
    {
        $this->counter = getRandom();
    }
}
