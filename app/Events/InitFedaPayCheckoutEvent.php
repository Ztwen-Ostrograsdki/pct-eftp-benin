<?php

namespace App\Events;

use App\Models\FedapayTransaction;
use App\Models\User;
use FedaPay\Transaction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InitFedaPayCheckoutEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $local_db_feda_transaction;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, FedapayTransaction $local_db_feda_transaction)
    {
        $this->user = $user;

        $this->local_db_feda_transaction = $local_db_feda_transaction;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.Models.User.' . $this->user->id),
        ];
    }


    public function broadcastWith(): array
    {
        return [
            'user' => $this->user,
            'local_db_feda_transaction' => $this->local_db_feda_transaction,
            'transaction_id' => $this->local_db_feda_transaction->transaction_id
        ];
    }
}
