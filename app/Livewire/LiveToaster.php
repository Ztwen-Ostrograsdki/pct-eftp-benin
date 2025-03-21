<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class LiveToaster extends Component
{
    public $counter = 1;

    public $toasters_data = [];

    public function render()
    {
        if(session()->has('toasters')){

            $this->toasters_data = (array)json_decode(session('toasters'));

        }

        return view('livewire.live-toaster');
    }


    #[On("LiveToasterMessagesEvent")]
    public function getToasters(array $toaster_data = [])
    {
        $data = [];

        if(session()->has('toasters')){

            $data = json_decode(session('toasters'));

            $data[$toaster_data['name']] = [
                'name' => $toaster_data['name'],
                'type' => $toaster_data['type'],
                'message' => $toaster_data['message'],
                'icon' => $toaster_data['icon'],

            ];

        }
        else{

            $data[$toaster_data['name']] = (array)$toaster_data;

        }

        session()->put('toasters', json_encode($data));

        $this->toasters_data = $data;

        $this->counter = getRandom();
    }


    public function deleteNotification($name)
    {

        
        if(session()->has('toasters')){

            $data = (array)json_decode(session('toasters'));

            if(isset($data[$name])){

                unset($data[$name]);

            }

            if(count($data) > 0){

                session()->put('toasters', json_encode($data));

            }
            else{
                session()->forget('toasters');
            }

            $this->counter = getRandom();

        }
    }
}

