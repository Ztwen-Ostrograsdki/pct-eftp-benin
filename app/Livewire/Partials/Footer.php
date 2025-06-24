<?php

namespace App\Livewire\Partials;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\NewsLetterSubscribers;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Footer extends Component
{
    use Toast, Confirm;

    #[Validate('required|email|unique:news_letter_subscribers,email')]
    public $subscriber_mail;


    public function render()
    {
        Carbon::setLocale('fr');
        
        $date = ucfirst(Carbon::now()->translatedFormat("F Y"));

        return view('livewire.partials.footer', ['date' => $date]);
    }


    public function subscribeTo()
    {
        $this->resetErrorBag();

        $this->validate();

        $news_letter_created = NewsLetterSubscribers::create(['email' => $this->subscriber_mail, 'is_active' => true]);

        if($news_letter_created){

            $this->toast("Votre soubscription à la newsletter a été envoyée!", 'success');

            $this->resetErrorBag();

            $this->reset();

        }

    }
}
