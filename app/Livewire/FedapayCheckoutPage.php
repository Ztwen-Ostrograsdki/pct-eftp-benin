<?php

namespace App\Livewire;

use App\Events\InitFedaPayCheckoutEvent;
use App\Helpers\CartManager;
use App\Helpers\Tools\ModelsRobots;
use App\Models\FedapayTransaction;
use App\Models\Order;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Finalisation du processus de payement")]
class FedapayCheckoutPage extends Component
{
    public $token;

    public $identifiant;

    public $transaction;

    public $FEDAtransaction;

    public $transactionID;

    public $carts_items = [];

    public $grand_total;

    public $shipping_price = 1000;

    public $taxe = 0;

    public $counter = 0;

    public $transaction_status_expired = true;


    public function render()
    {
        $title = 'order_identifiant' . auth_user()->id;

        $order_identifiant =  session($title);

        $feda_transaction = Transaction::retrieve($this->transactionID);

        if($feda_transaction){

            if($feda_transaction->status == 'canceled' || $feda_transaction->status == 'expired' || $feda_transaction->status == 'approved'){
                
                $this->transaction_status_expired = true;
            }
            elseif($feda_transaction->status == 'pending'){

                $this->transaction_status_expired = false;

            }
            if($feda_transaction->status == 'approved'){

                $order = Order::where('identifiant', $order_identifiant)->first();
                
                if($order){

                    ModelsRobots::synchronyzeOrderWithTransaction($order);
                }
                
            }
        }

        return view('livewire.fedapay-checkout-page', [
            'order_identifiant' => $order_identifiant,
            'feda_transaction' => $feda_transaction
        ]);
    }

    public function mount($identifiant, $transactionID, $token)
    {

        FedaPay::setApiKey(env('MY_FEDA_SECRET_KEY'));

        FedaPay::setEnvironment('sandbox'); 
        
        $this->identifiant = $identifiant;

        $this->transactionID = $transactionID;
        
        $this->token = $token;

        $this->carts_items = CartManager::getAllCartItemsFromCookies();

        $this->grand_total = CartManager::getComputedGrandTotalValue($this->carts_items);


        $local_db_feda_transaction = FedapayTransaction::where('transaction_id', $transactionID)
                                              ->where('token', $token)
                                              ->where('user_id', auth_user()->id)
                                              ->first();
        

        if($local_db_feda_transaction){

            $this->transaction = $local_db_feda_transaction;

        }
        else{
            return abort(404);
        }

        

    }


    public function checkout()
    {
        InitFedaPayCheckoutEvent::dispatch(auth_user(), $this->transaction);
    }



    public function cancelCheckout()
    {
        return to_route('user.cart', ['identifiant' => auth_user()->identifiant]);
    }
}
