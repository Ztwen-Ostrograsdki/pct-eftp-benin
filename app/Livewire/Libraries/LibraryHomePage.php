<?php

namespace App\Livewire\Libraries;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use Livewire\Component;
use Livewire\WithPagination;

class LibraryHomePage extends Component
{
    use Toast, Confirm, WithPagination;

    public $counter = 0;



    public function render()
    {
        

        return view('livewire.libraries.library-home-page', 
            
        );
    }

   
}
