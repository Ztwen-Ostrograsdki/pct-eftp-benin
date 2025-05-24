<?php

namespace App\Livewire\Partials;

use Illuminate\Support\Carbon;
use Livewire\Component;

class Footer extends Component
{
    public function render()
    {
        Carbon::setLocale('fr');
        
        $date = ucfirst(Carbon::now()->translatedFormat("F Y"));

        return view('livewire.partials.footer', ['date' => $date]);
    }
}
