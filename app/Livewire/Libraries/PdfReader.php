<?php

namespace App\Livewire\Libraries;

use App\Models\Epreuve;
use App\Models\EpreuveResponse;
use App\Models\SupportFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class PdfReader extends Component
{

    public $uuid;

    public $type;

    public $the_file;

    public $secureUrl;

    public function mount($uuid, $type)
    {
        $this->uuid = $uuid;

        $the_file = null;

        $type = $this->type;
        
        if($type == 'e'){

            $the_file = Epreuve::where('uuid', $uuid)->first();

            if(!$the_file || !Storage::disk('local')->exists($the_file->path)){

                return abort(404);

            }
        }
        elseif($type == 'f'){

            $the_file = SupportFile::where('uuid', $uuid)->first();

            if(!$the_file || !Storage::disk('local')->exists($the_file->path)){

                return abort(404);

            }
        }
        elseif($type == 'er'){

            $the_file = EpreuveResponse::where('uuid', $uuid)->first();

            if(!$the_file || !Storage::disk('local')->exists($the_file->path)){

                return abort(404);

            }
        }

        if($the_file){

            $this->the_file = $the_file;

            if(Storage::disk('local')->exists($the_file->path)){

                $this->secureUrl = route('file.reader.secure', ['uuid' => $this->uuid, 'type' => $this->type]);

            }
            else{

                return abort(404);
            }

        }
        else{
            return abort(404);
        }
    }

    public function render()
    {
        return view('livewire.libraries.pdf-reader');
    }

   
}


