<?php

namespace App\Livewire\User;

use Akhaled\LivewireSweetalert\Confirm;
use Akhaled\LivewireSweetalert\Toast;
use App\Events\InitiateNewOrderEvent;
use App\Helpers\CartManager;
use App\Models\Order;
use FedaPay\Customer;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title("Validation de la commande et de l'addresse de reception")]
class CheckoutPage extends Component
{
    public $identifiant;

    use WithFileUploads, Toast, Confirm;

    public $carts_items = [];

    public $grand_total;

    public $shipping_amount = 1000;

    public $order_id;

    public $taxe = 0;

    public $counter = 0;

    public $user_id;

    #[Validate('required|string|min:3|max:255')]
    public $first_name;

    #[Validate('required|string|min:3|max:255')]
    public $last_name;

    #[Validate('required|string|min:3|max:255')]
    public $street_address;

    #[Validate('required|string|min:3|max:255')]
    public $city;

    #[Validate('required|string|min:3|max:255')]
    public $state;

    #[Validate('string|between:4, 12')]
    public $zip_code;

    #[Validate('required|string|min:3|max:255')]
    public $phone;

    public $images = [];

    #[Validate('required')]
    public $payment_method;

    #[Validate('required')]
    public $shipping_method;

    #[Validate('required')]
    public $currency = 'cfa';

    #[Validate('string')]
    public $notes = '';


    #[On('UpdateCartItemsCounter')]
    public function updateCartItemsCounter($counter)
    {
        $this->carts_items = CartManager::getAllCartItemsFromCookies();

        $this->grand_total = CartManager::getComputedGrandTotalValue($this->carts_items);
    }


    public function mount()
    {
        $this->carts_items = CartManager::getAllCartItemsFromCookies();

        $this->grand_total = CartManager::getComputedGrandTotalValue($this->carts_items);
    }
    
    public function render()
    {
        $payments_methods = config('app.payments_methods');

        $shipping_methods = config('app.shipping_methods');

        $currencies = config('app.currencies');

        return view('livewire.user.checkout-page', 
            [
                'payments_methods' => $payments_methods,
                'shipping_methods' => $shipping_methods,
                'currencies' => $currencies,
            ]
        );
    }

    public function updateFirstName($name)
    {
        
    }

    public function checkout()
    {

        $this->resetErrorBag();

        $this->validate(
            [
                'images' => 'array|max:5', 
                'images.*' => 'image|mimes:jpeg,png,jpg|max:4000',
            ]
        );
        
        $this->validate();

        $address_data = [];

        $order_data = [];

        $user = auth_user();

        $title = 'order_identifiant' . $user->id;

        $order_identifiant = Str::random(15);

        session()->put($title, $order_identifiant);

        $order_data = [
            'user_id' => $user->id,
            'grand_total' => $this->grand_total,
            'identifiant' =>$order_identifiant,
            'payment_method' => $this->payment_method,
            'currency' => $this->currency,
            'shipping_amount' => $this->shipping_amount,
            'shipping_method' => $this->shipping_method,
            'notes' => $this->notes,
        ];

        $the_images = [];

        $images_banks = [];

        if($this->images){

            foreach($this->images as $image){

                $extension = $image->extension();

                $file_name = getdate()['year'].''.getdate()['mon'].''.getdate()['mday'].''.getdate()['hours'].''.getdate()['minutes'].''.getdate()['seconds']. '' .  Str::random(20);

                $db_name = 'address/' . $file_name . '.' . $extension;

                $the_images[] = $db_name;

                $images_banks[$file_name] = $image;
            }
        }

        $address_data = [
            'order_id' => null,
            'first_name' => Str::upper($this->first_name),
            'last_name' => Str::ucwords($this->last_name),
            'phone' => $this->phone,
            'street_address' => $this->street_address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
        ];

        $data = [
            'items' => $this->carts_items, 
            'order' => $order_data, 
            'address' => $address_data,
            'address_images' => $images_banks,
            'order_identifiant' => $order_identifiant,
        ];

        
        InitiateNewOrderEvent::broadcast($user, $data);
        
    }

    #[On('LiveNewOrderHasBeenCreatedSuccessfullyEvent')]
    public function orderCompleted($order)
    {
        $this->toast("La commande a été soumise avec succès. Veuillez attendre l'approbation pour procéder au payement", 'success');

        $ord = Order::where('identifiant', $order)->first();

        if($ord){

            self::clearCart();

            return to_route('user.checkout.success', ['identifiant' => $ord->identifiant]);

        }

    }

    #[On('LiveOrderCreationHasBeenFailedEvent')]
    public function orderFailed($data = [])
    {
        $this->toast("Une erreure est survenue : La commande n'a pas pu être soumise", 'error');

        return false;
    }

    public function clearCart()
    {
        $this->carts_items = CartManager::clearCartItemsFromCookies();

        $this->dispatch('UpdateCartItemsCounter', count($this->carts_items));

        $this->grand_total = CartManager::getComputedGrandTotalValue($this->carts_items);

    }
}

