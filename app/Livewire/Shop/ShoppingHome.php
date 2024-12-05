<?php

namespace App\Livewire\Shop;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Helpers\CartManager;
use App\Models\Book;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title("Boutique")]
class ShoppingHome extends Component
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


    public function mount($c = null, $b = null) 
    {
        $this->carts_items = CartManager::getAllCartItemsFromCookies();
    }

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

        return view('livewire.shop.shopping-home', 
            [
                'books' => $query->paginate(6),
            ]
        );
    }

    public function addToCart(int $book_id)
    {
        $total_items = CartManager::addItemToCart($book_id);

        $name = Book::find($book_id)->name;

        $message = "Le document $name a été ajouté au panier";

        $this->toast($message, 'success', 5000);

        $this->dispatch('UpdateCartItemsCounter', $total_items);
        
    }

    public function reloadImageIndex($book_id)
    {
        if($this->current_index !== $book_id){

            $this->current_index = $book_id;
        } 
    }

    #[On('UpdateCartItemsCounter')]
    public function updateCartItemsCounter($counter = null)
    {
        $this->carts_items = CartManager::getAllCartItemsFromCookies();
    }
}
