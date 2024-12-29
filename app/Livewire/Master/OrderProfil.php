<?php

namespace App\Livewire\Master;

use Akhaled\LivewireSweetalert\Toast;
use App\Events\ApproveOrderEvent;
use App\Helpers\Tools\ModelsRobots;
use App\Models\FedapayTransaction;
use App\Models\Order;
use App\Models\User;
use FedaPay\Customer;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class OrderProfil extends Component
{
    use Toast;
    
    public $order;

    public $address;

    public function render()
    {
        $order = $this->order;

        if($order){

            $this->address = $order->address;

        }

        self::synchronyzeOrderWithTransaction();

        return view('livewire.master.order-profil');
    }

    public function synchronyzeOrderWithTransaction()
    {
        ModelsRobots::synchronyzeOrderWithTransaction($this->order);
    }

    public function deleteOrder($order_id)
    {
        
    }
    
    public function approveOrder()
    {
        ApproveOrderEvent::dispatch($this->order);
    }

    public function initOrderCheckout($order_id = null)
    {
        if($this->order->id){

            $order_identifiant = $this->order->identifiant;

            $order_id = $this->order->id;

            $user = auth_user();

            FedaPay::setApiKey(env('MY_FEDA_SECRET_KEY'));

            FedaPay::setEnvironment('sandbox'); //or setEnvironment('live');
            /* Créer un client */

            $exists = false;

            if($user->FEDAPAY_ID && $user->FEDAPAY_ID !== null){

                $exists = Customer::retrieve($user->FEDAPAY_ID);

            }

            if(!$user->FEDAPAY_ID || !$exists){

                $customer = Customer::create(
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
        
                if($customer){

                    User::find(auth_user()->id)->update(['FEDAPAY_ID' => $customer->id]);
                }
            }

            if($user->FEDAPAY_ID){

                $title = 'order_identifiant' . $user->id;

                session()->put($title, $order_identifiant);

                $description = "Payement de la commande N° " . $order_identifiant;

                $amount = $this->order->grand_total + $this->order->shipping_price + $this->order->tax;

                $callback_url = url('user.checkout.success', ['identifiant' => $this->order->identifiant]);

                $transaction = Transaction::create([
                    'description' => $description,
                    'amount' => $amount,
                    'currency' => ['iso' => 'XOF'],
                    'callback_url' => $callback_url,
                    'customer' => ['id' => $user->FEDAPAY_ID]
                ]);

                if($transaction){

                    $token = $transaction->generateToken();

                    $url_data = [
                        'identifiant' => $user->identifiant,
                        'transactionID' => $transaction->id,
                        'token' => $token->token
                    ];

                    $feda = [
                        'description' => $description,
                        'amount' => $amount,
                        'callback_url' => $callback_url,
                        'customer_id' => $user->FEDAPAY_ID,
                        'token' => $token->token,
                        'user_id' => $user->id,
                        'receipt_email' => $user->email,
                        'payment_status' => $transaction->status,
                        'transaction_id' => $transaction->id,
                        'reference' => $transaction->reference,
                        'operation' => "payment",
                        'order_identifiant' => $order_identifiant,
                        'order_id' => $order_id,
                    ];

                    $feda_transaction_created = FedapayTransaction::create($feda);

                    $this->order->update(['FEDAPAY_TRANSACTION_ID' => $transaction->id]);

                    if($feda_transaction_created){

                        return to_route('feda.checkout.proccess', 
                            $url_data
                        );
                        
                    }
                }

            }

        }
        else{

            $this->toast("Cette commande est inconnue, veuillez vérifier votre réquête!", 'warning');
        }
    }


    #[On('LiveTheOrderApprovedSuccessfullyEvent')]
    public function orderApproved($order_identifiant)
    {
        $this->toast("Votre commande N° ". $order_identifiant. " a été approuvée avec succès. Vous pouvez procéder au payement", 'success');
    }
    
    #[On('LiveTheOrderApprovedSuccessfullyEventForAdmin')]
    public function orderApprovedForAdmins($order_identifiant)
    {
        $this->toast("La commande N° ". $order_identifiant. " a été approuvée avec succès.", 'success');
    }
}
