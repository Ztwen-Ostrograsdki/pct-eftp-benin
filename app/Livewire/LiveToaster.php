<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class LiveToaster extends Component
{
    public $counter = 6;

    public $toasters_data = [];

    public function render()
    {
        return view('livewire.live-toaster');
    }


    #[On("LiveToasterMessagesEvent")]
    public function getToasters(array $toaster_data = [])
    {
        $data = [];

        if(session()->has('toasters')){

            $data = json_decode(session('toasters'));

            if(!isset($data[$toaster_data['name']])){

                $data[$toaster_data['name']] = [
                    'name' => $toaster_data['name'],
                    'type' => $toaster_data['type'],
                    'message' => $toaster_data['message'],
                    'icon' => $toaster_data['icon'],
    
                ];

            }

        }
        else{

            $data[$toaster_data['name']] = $toaster_data;

        }

        session()->put('toasters', json_encode($data));

        $this->toasters_data = $data;

        $this->counter = getRandom();
    }
}

