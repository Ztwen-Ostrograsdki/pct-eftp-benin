<?php

namespace App\Livewire\Partials;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\CartManager;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    use Toast, Confirm;

    public $total_items = 0;

    protected $listeners = [
        'LiveLogoutUserEvent' => 'logout',
        'LiveNotificationDispatchedToAdminsSuccessfullyEvent' => 'newNotification',

    ];

    public function mount()
    {
        $this->total_items = count(CartManager::getAllCartItemsFromCookies());
    }

    #[On('UpdateCartItemsCounter')]
    public function updateCartItemsCounter($counter)
    {
        $this->total_items = $counter;
    }

    public function clearCart()
    {
        $carts_items = CartManager::clearCartItemsFromCookies();

        $this->dispatch('UpdateCartItemsCounter', count($carts_items));

    }

    
    public function render()
    {
        return view('livewire.partials.navbar');
    }

    public function newNotification($user = null)
    {
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
}
