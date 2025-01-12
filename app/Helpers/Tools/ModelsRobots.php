<?php
namespace App\Helpers\Tools;

use App\Models\FedapayTransaction;
use App\Models\Order;
use App\Models\User;
use App\Notifications\NotifyAdminThatBlockedUserTriedToLoginToUnblockThisUserAccount;
use App\Notifications\NotifyAdminThatNewUserSubscribedToConfirmThisUserAccount;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ModelsRobots{

    public $model;

    public function __construct($model = null) {

        $this->model = $model;
    }

    public static function getUserAdmins($pluckindColumn = 'id', $except = null)
    {
        $admins = User::where('ability', 'admin')
                      ->orWhere('ability', 'master')
                      ->orWhere('id', 1)
                      ->pluck($pluckindColumn)
                      ->toArray();

        return count($admins) ? $admins : [1];
    }

    public static function getAllAdmins()
    {
        $admins = User::where('ability', 'admin')
                      ->orWhere('ability', 'master')
                      ->orWhere('id', 1)
                      ->get();

        return $admins;
    }


    public static function makeUserIdentifySequence()
    {
        return Str::upper(Str::random(18));
    }



    public static function synchronyzeOrderWithTransaction(Order $order)
    {
        $data = [];

        return 1;

        FedaPay::setApiKey(env('MY_FEDA_SECRET_KEY'));

        FedaPay::setEnvironment('sandbox');

        if($order){

            DB::transaction(function () use($data, $order) {

                $local_db_feda_transaction = FedapayTransaction::where('transaction_id', $order->FEDAPAY_TRANSACTION_ID)
                                                  ->whereNotNull('token')
                                                  ->where('user_id', auth_user()->id)
                                                  ->first();
                if($local_db_feda_transaction){

                    $fedapay_transaction_id = $local_db_feda_transaction->transaction_id;
    
                    if($fedapay_transaction_id){

                        $feda_transaction = Transaction::retrieve($fedapay_transaction_id);

                        if($feda_transaction){

                            if($feda_transaction->status == 'approved'){

                                $data = [
                                    'status' => $feda_transaction->status,
                                    'mobile_operator' => $feda_transaction->mode,
                                    'transaction_key' => $feda_transaction->transaction_key,
                                    'payment_status' => $feda_transaction->status,
                                    'amount' => $feda_transaction->amount,
                                    'reference' => $feda_transaction->reference,
                                ];
                            }

                            if($data && $data !== []){

                                $order->update(['payment_status' => 'payed', 'status' => 'approved']);

                                $local_db_feda_transaction->update($data);
                            }

                        }


                    }

                }
            });

        }
    }

    public static function notificationToConfirmUnconfirmedUser(User $user)
    {
        if($user && !$user->confirmed_by_admin){

            $admins = self::getAllAdmins();

            foreach($admins as $admin){

                $admin->notify(new NotifyAdminThatNewUserSubscribedToConfirmThisUserAccount($user));

            }

        }
    }
    
    public static function notificationThatBlockedUserTriedToLogin(User $user, $title, $object, $content)
    {
        if($user && !$user->blocked){

            $admins = self::getAllAdmins();

            foreach($admins as $admin){

                $admin->notify(new NotifyAdminThatBlockedUserTriedToLoginToUnblockThisUserAccount($user, $title, $object, $content));

            }

        }
    }





}