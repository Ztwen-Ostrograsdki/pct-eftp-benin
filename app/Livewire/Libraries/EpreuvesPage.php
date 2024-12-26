<?php

namespace App\Livewire\Libraries;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Models\Book;
use Livewire\Component;
use Livewire\WithPagination;

class EpreuvesPage extends Component
{
    use Toast, Confirm, WithPagination;

    public $carts_items = [];

    public $image_indexes = [];

    public $current_index = 0;


    public $selected_filiars = [];

    public $selected_promotions = [];

    public $selected_classes = [];

    public $on_sale;

    public $is_active;

    public $step = 10000;

    public $price_range = 5000;

    public $min_price = 0;

    public $max_price = 90000000;

    public $counter = 0;



    public function render()
    {
        $query = Book::query()->where('is_active', 1);

        foreach($query->get() as $p){

            if($this->current_index == $p->id){

                $images = $p->images;

                $current = $this->image_indexes[$p->id]['current'];

                if($current + 1 < count($images)){

                    $index = $current + 1;
                }
                else{
                    $index = 0;
                }

                $this->image_indexes[$p->id] = [
                    'index' => $index, 
                    'current' => $index
                ];

            }
            else{
                if(isset($this->image_indexes[$p->id]) && $this->image_indexes[$p->id]['index'] !== 0){
                    $this->image_indexes[$p->id] = [
                        'index' => $this->image_indexes[$p->id]['index'], 
                        'current' => $this->image_indexes[$p->id]['index']
                    ];
                }
                else{
                    $this->image_indexes[$p->id] = [
                        'index' => 0, 
                        'current' => 0
                    ];
                }
               
            }
           
        }

        return view('livewire.libraries.epreuves-page', 
            [
                'books' => $query->paginate(6),
            ]
        );
    }
}
