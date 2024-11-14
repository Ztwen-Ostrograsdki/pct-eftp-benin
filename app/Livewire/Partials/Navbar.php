<?php

namespace App\Livewire\Partials;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    use Toast, Confirm;
    
    public function render()
    {
        return view('livewire.partials.navbar');
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
