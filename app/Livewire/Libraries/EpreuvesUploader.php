<?php

namespace App\Livewire\Libraries;

use Livewire\Component;

class EpreuvesUploader extends Component
{
    public $pendingFile;

    public $targets_files = [];

    public $tables = [
        "1er Devoir du Second semestre" => "150 Mb"

    ];

    public function mount()
    {
        
    }

    public function render()
    {
        return view('livewire.libraries.epreuves-uploader');
    }

    
}
