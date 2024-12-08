<?php

namespace App\Livewire\User;

use App\Helpers\CartManager;
use Dotenv\Util\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Mon Panier d'achat")]
class CartPage extends Component
{
    public $carts_items = [];

    public $grand_total;

    public $shipping_price = 1000;

    public $taxe = 0;

    public $counter = 0;

    public $identifiant;

    public function mount($identifiant)
    {
        if($identifiant) $this->identifiant = $identifiant;

        $this->carts_items = CartManager::getAllCartItemsFromCookies();

        $this->grand_total = CartManager::getComputedGrandTotalValue($this->carts_items);
    }

    public function render()
    {
        return view('livewire.user.cart-page');
    }

    public function incrementQuantity(int $product_id)
    {
        $this->carts_items = CartManager::incrementItemQuantityToCart($product_id);

        $this->grand_total = CartManager::getComputedGrandTotalValue($this->carts_items);

    }

    public function decrementQuantity(int $product_id)
    {
        $this->carts_items = CartManager::decrementItemQuantityFromCart($product_id);

        $this->grand_total = CartManager::getComputedGrandTotalValue($this->carts_items);

    }

    public function deleteItem(int $product_id)
    {
        $this->carts_items = CartManager::removeCartItem($product_id);

        $this->grand_total = CartManager::getComputedGrandTotalValue($this->carts_items);

        $this->dispatch('UpdateCartItemsCounter', count($this->carts_items));

    }

    public function clearCart()
    {
        $this->carts_items = CartManager::clearCartItemsFromCookies();

        $this->dispatch('UpdateCartItemsCounter', count($this->carts_items));

        $this->grand_total = CartManager::getComputedGrandTotalValue($this->carts_items);

    }

    #[On('UpdateCartItemsCounter')]
    public function updateCartItemsCounter($counter)
    {
        $this->carts_items = CartManager::getAllCartItemsFromCookies();

        $this->grand_total = CartManager::getComputedGrandTotalValue($this->carts_items);
    }

    public function checkoutCart()
    {
        return to_route('user.checkout', ['identifiant' => auth_user()->identifiant]);
    }
    
}
