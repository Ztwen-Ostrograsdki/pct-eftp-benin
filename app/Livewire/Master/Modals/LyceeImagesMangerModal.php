<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Models\Lycee;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class LyceeImagesMangerModal extends Component
{

    use WithFileUploads, Toast;

    public $user;

    public array $images = [];

    public $lycee_id;

    public $lycee;

    protected $rules = [
        'images' => 'required|array|max:3', // max 5 images
        'images.*' => 'image|max:2048',     // chaque fichier = image de 2MB max
    ];

    public $counter = 0;

    public $modal_name = '#lycee-images-manager-modal';
    
    public function render()
    {
        return view('livewire.master.modals.lycee-images-manger-modal');
    }

    public function save()
    {
        $this->validate();

        if($this->images && count($this->images) <= 3){

            $images = $this->images;

            $images_paths = [];

            $root = storage_path("app/public/lyceesImages");

            if(!File::isDirectory($root)) File::makeDirectory($root, 0777, true, true);

            if(File::isDirectory($root)){

                foreach($images as $image){

                    $extension = $image->extension();

                    $file_name = Str::slug($this->lycee->name) . '-' . getdate()['year'].''.getdate()['mon'].''.getdate()['mday'].''.getdate()['hours'].''.getdate()['minutes'].''.getdate()['seconds']. '' .  Str::random(6);

                    $save = $image->storeAs("lyceesImages/", $file_name . '.' . $extension, ['disk' => 'public']);

                    if($save){

                        $images_paths[] = "lyceesImages/" . $file_name . '.' . $extension;
                    }
                    else{

                        $this->toast("Une erreure est survenue, veuillez réessayer", 'error', 5000);
                    }
                }

                if(count($images_paths) == count($this->images)){

                    $images_to_remoove = [];

                    $images_to_DB = [];

                    $updated = false;

                    $images_saving = $images_paths;

                    $olders_images = (array)$this->lycee->images;

                    if(!$olders_images || count($images_saving) == 3){

                        $images_to_remoove = $olders_images;

                        $images_to_DB = $images_saving;

                    }
                    else{

                        if(count($images_saving) == 2){

                            $images_to_DB = $images_saving;

                            if(count($olders_images) == 3){

                                $images_to_remoove[] = $olders_images[0];

                                $images_to_remoove[] = $olders_images[1];

                                $images_to_DB[] = $olders_images[2];

                            }
                            elseif(count($olders_images) == 2){

                                $images_to_remoove[] = $olders_images[0];

                                $images_to_DB[] = $olders_images[1];

                            }
                            elseif(count($olders_images) == 1){

                                $images_to_remoove = [];

                                $images_to_DB[] = $olders_images[0];


                            }

                        }
                        elseif(count($images_saving) == 1){

                            $images_to_DB = $images_saving;

                            if(count($olders_images) == 3){

                                $images_to_remoove[] = $olders_images[0];

                                $images_to_DB[] = $olders_images[1];

                                $images_to_DB[] = $olders_images[2];

                            }
                            elseif(count($olders_images) == 2){

                                $images_to_remoove[] = [];

                                $images_to_DB[] = $olders_images[0];

                                $images_to_DB[] = $olders_images[1];

                            }
                            elseif(count($olders_images) == 1){

                                $images_to_remoove = [];

                                $images_to_DB[] = $olders_images[0];


                            }

                        }


                    }

                    if($images_to_DB){

                        $updated = $this->lycee->update(['images' => $images_to_DB]);

                        if($images_to_remoove){

                            foreach($images_to_remoove as $im_path){

                                $path = storage_path().'/app/public/' . $im_path;

                                File::delete($path);

                            }

                        }


                    }

                    if($updated){

                        $this->toast("Les images de " . $this->lycee->name . " ont été mises à jour avec succès!", 'success', 5000);

                        $this->hideModal();

                    }


                }
                else{

                    foreach($images_paths as $p){

                        $path = storage_path().'/app/public/' . $p;

                        File::delete($path);

                    }

                    $this->toast("Une erreure est survenue, veuillez réessayer", 'error', 5000);
                }

            }
            else{

                $this->toast("Erreure de stockage: Le dossier est introuvable, veuillez réessayer", 'error', 5000);
            }
        }
        else{

            $this->toast("Veuillez choisir au plus trois images", 'error', 5000);
        }
    }

    #[On('ManageLyceeImagesEvent')]
    public function openModal($lycee_id = null)
    {
        $this->lycee_id = $lycee_id;

        $lycee = Lycee::find($this->lycee_id);

        if($lycee){

            $this->lycee = $lycee;

            $this->dispatch('OpenModalEvent', $this->modal_name);

        }

    }

    public function updatedImages()
    {
        $this->resetErrorBag();
    }

    public function removeImage($index)
    {
        unset($this->images[$index]);

        $this->images = array_values($this->images); 
    }


    public function hideModal($modal_name = null)
    {
        
        $this->reset();

        $this->dispatch('HideModalEvent', $this->modal_name);
    }

    
}
