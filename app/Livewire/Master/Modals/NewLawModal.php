<?php

namespace App\Livewire\Master\Modals;

use Akhaled\LivewireSweetalert\Toast;
use App\Models\Law;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class NewLawModal extends Component
{
    public function render()
    {
        return view('livewire.master.modals.new-law-modal');
    }
    use Toast;

    #[Validate('required|string|unique:laws')]
    public $name;

    public $description;

    public $editing_law = null;

    public $modal_name = "#law-manager-modal";

    public $counter = 2;


    public function insert()
    {
        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'slug' => Str::slug($this->name),
        ];

        if($this->editing_law){

            $existed_name = Law::where('name', $this->name)->where('id', '<>', $this->editing_law->id)->first();

            if($existed_name){

                $this->addError('name', "cette loi existe déjà!");

                return $this->toast("Cette loi existe déjà", 'info');
            }
            else{

                $validated = $this->validate([
                    'name' => "required|string",
                ]);

                $updated = $this->editing_law->update($data);

                if($updated){

                    $this->toast("La loi a été mise à jour avec succès!", 'success');
    
                    $this->reset();
    
                    $this->hideModal();
    
                }
                else{
                    $this->toast("L'insertion a échoué", 'error');
                }

            }
        }
        else{
            $this->validate();

            $data['identifiant'] = Str::random();

            $created = Law::create($data);

            if($created){

                $this->toast("Nouvelle loi créée avec succès!", 'success');

                $this->reset();

                $this->hideModal();

            }
            else{
                $this->toast("L'insertion a échoué", 'error');
            }
        }
    }

    #[On('OpenLawManagerModal')]
    public function openModal($law_id = null)
    {
        $this->reset();

        if($law_id){

            $law = Law::find($law_id);

            if($law){

                $this->editing_law = $law;

                $this->description = $law->description;

                $this->name = $law->name;

            } 

        }

        $this->dispatch('OpenModalEvent', $this->modal_name);
    }


    public function hideModal($modal_name = null)
    {
        $this->dispatch('HideModalEvent', $this->modal_name);
    }

}
