<?php

namespace App\Livewire\User;

use App\Helpers\CartManager;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title("Validation payment")]
class CheckoutPage extends Component
{
    public $identifiant;

    use WithFileUploads;

    public $carts_items = [];

    public $grand_total;

    public $shipping_amount = 1000;

    public $order_id;

    public $taxe = 0;

    public $counter = 0;

    public $user_id;

    #[Validate('required|string|min:3|max:255')]
    public $address;

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

    #[Validate('string|betweEn:4, 12')]
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
        return to_route('user.checkout.success', ['identifiant' => auth_user()->identifiant]);
        
        $this->validate(['images' => 'array|max:5', 'images.*' => 'image|mimes:jpeg,png,jpg|max:4000']);
        
        $this->validate();

        $address_data = [];

        $order_data = [];


        $order_data = [
        'user_id' => $this->user,
        'grand_total' => $this->grand_total,
        'payment_method' => $this->payment_method,
        'currency' => $this->currency,
        'shipping_amount' => $this->shipping_amount,
        'shipping_method' => $this->shipping_method,
        'notes' => $this->notes,

        ];


        //Create the order firstly

        //$order = Order::create($order_data);

        //Create the address then

        $address_data = [
            'order_id',
            'first_name',
            'last_name',
            'phone',
            'images',
            'image',
            'street_address',
            'city',
            'state',
            'zip_code',
        ];

        //Address::create($address_data);

        return to_route('user.checkout.success', ['identifiant' => auth_user()->identifiant]);
    }
}

