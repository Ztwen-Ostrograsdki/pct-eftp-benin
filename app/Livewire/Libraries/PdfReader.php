<?php

namespace App\Livewire\Libraries;

use App\Models\Epreuve;
use Livewire\Component;

class PdfReader extends Component
{

    public $uuid;

    public $securePdfUrl;

    public function mount($uuid)
    {
        $this->uuid = $uuid;
    }

    public function render()
    {
        $epreuve = Epreuve::where('uuid', $this->uuid)->firstOrFail(); 

        $url = route('epreuve.secure', $this->uuid); // lien vers le PDF sécurisé
    
        return view('livewire.libraries.pdf-reader', [
            'pdf_url' => $url,
            'epreuve' => $epreuve,
        ]);
    }

   
}


