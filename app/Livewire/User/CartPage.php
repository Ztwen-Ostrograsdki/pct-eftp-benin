<?php

namespace App\Livewire\User;

use App\Helpers\CartManager;
use Dotenv\Util\Str;
use FedaPay\Customer;
use FedaPay\FedaPay;
use FedaPay\Transaction;
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

        $user = auth_user();

        FedaPay::setApiKey(env('MY_FEDA_SECRET_KEY'));

        FedaPay::setEnvironment('sandbox'); //or setEnvironment('live');
        /* Créer un client */

        $exists = false;

        if($user->FEDAPAY_ID){

            $exists = Customer::retrieve($user->FEDAPAY_ID);
        }

        if(!$exists){
            $c = Customer::create(
                array(
                    "firstname" => $user->firstname,
                    "lastname" => $user->lastname,
                    "email" => $user->email,
                    "phone_number" => [
                        "number" => $user->contacts,
                        "country" => 'bj' // 'bj' Benin code
                    ]
                )
            );
    
            if($c){
                $user->update(['FEDAPAY_ID' => $c->id]);
            }
        }

        if($user->FEDAPAY_ID){
            $transaction = Transaction::create([
                'description' => 'Payment for order #1234',
                'amount' => 100,
                'currency' => ['iso' => 'XOF'],
                'callback_url' => url('user.checkout', ['identifiant' => auth_user()->identifiant]),
                'mode' => 'mtn',
                'customer' => ['id' => $user->FEDAPAY_ID]
            ]);

            $token = $transaction->generateToken();
            
            return to_route('feda.checkout.proccess', ['token' => $token]);
        }


        

        //return to_route('user.checkout', ['identifiant' => auth_user()->identifiant]);
    }
    
}
