<?php

namespace App\Livewire;

use App\Helpers\CartManager;
use App\Models\Book;
use Livewire\Component;

class BookDetailsPage extends Component
{
    public $identifiant;

    public $slug;

    public $book;

    public $carts_items = [];

    public $quantity = 1;

    public function mount($identifiant,  $slug)
    {
        if($identifiant && $slug){

            $this->identifiant = $identifiant;

            $this->slug = $slug;

            $book = Book::where('identifiant', $identifiant)->where('slug', $slug)->where('is_active', 1)->firstOrFail();

            if($book) $this->book = $book;
        }
    }
    public function render()
    {
        return view('livewire.book-details-page');
    }


    public function increaseQuantity()
    {
        $this->quantity++;
    }

    public function decreaseQuantity()
    {
        $this->quantity > 1 ? $this->quantity-- : $this->quantity = 1;
    }

    public function addToCart(int $book_id)
    {
        $total_items = CartManager::addItemToCart($book_id, $this->quantity);

        $this->dispatch('UpdateCartItemsCounter', $total_items);
        
    }
}
