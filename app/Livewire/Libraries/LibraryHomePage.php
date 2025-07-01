<?php

namespace App\Livewire\Libraries;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\Epreuve;
use App\Models\SupportFile;
use Livewire\Component;
use Livewire\WithPagination;

class LibraryHomePage extends Component
{
    use Toast, Confirm, WithPagination;

    public $counter = 0;



    public function render()
    {
        $simple_epreuves = Epreuve::where('epreuves.authorized', true)
                         ->where('epreuves.is_exam', false)
                         ->where('epreuves.hidden', false)->count();
        
        $exam_epreuves = Epreuve::where('epreuves.authorized', true)
                         ->where('epreuves.is_exam', true)
                         ->where('epreuves.hidden', false)->count();
        
        $support_files = SupportFile::where('authorized', true)
                         ->where('hidden', false)->count();
        

        return view('livewire.libraries.library-home-page', 
            compact('simple_epreuves', 'exam_epreuves', 'support_files')
            
        );
    }

   
}
