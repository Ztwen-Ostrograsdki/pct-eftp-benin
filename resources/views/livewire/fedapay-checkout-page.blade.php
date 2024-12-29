<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
  <div class="border mx-auto rounded-r-lg p-2 shadow-lg shadow-gray-600 bg-gray-700 text-gray-400">
    <h4 class="text-center text-lg border-b py-2">
      <strong>
        Validation du payement de la commande <span class="text-orange-500">N° {{ $order_identifiant }}</span> 
      </strong>
    </h4>

    <div class="mx-auto p-4">
      <h4 class="p-2 text-yellow-400 text-2xl">
        @if (count($carts_items))
        <div class="">
          <div class="bg-gray-900 border rounded-3xl shadow-md p-6">
            <h2 class="text-lg font-semibold mb-4">Facture</h2>
            <hr class="my-2 text-slate-800 bg-slate-500">
            <div class="flex justify-between mb-2">
              <span>Sous total</span>
              <span>
                <b>{{ Number::currency($grand_total, 'CFA') }}</b>
              </span>
            </div>
            <div class="flex justify-between mb-2">
              <span>Taxes</span>
              <span>{{ $taxe }}</span>
            </div>
            <div class="flex justify-between mb-2">
              <span>Prix de livraison</span>
              <span>{{ $shipping_price }}</span>
            </div>
            <hr class="my-2">
            <div class="flex justify-between mb-2">
              <span class="font-semibold">Total</span>
              <span class="font-semibold">
                <b>{{ Number::currency(($grand_total + $taxe + $shipping_price), 'CFA') }}</b>
              </span>
            </div>

          </div>
        </div>
        @endif
      </h4>

      @if($transaction_status_expired == false)
        <div class="grid grid-cols-2 gap-x-4 p-3">
          <button wire:click='cancelCheckout' wire:loading.class='opacity-50' wire:target='cancelCheckout' class="cursor-pointer py-1 px-4 inline-flex justify-center items-center gap-x-2 font-semibold border bg-red-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-red-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
            <span wire:loading wire:target='cancelCheckout'>
              <span class="fa animate-spin fa-rotate float-end mt-2"></span>
              <span class="mx-2">Annulation en cours </span>
            </span>
            <span wire:loading.remove wire:target='cancelCheckout'>Annuler le payement</span>
          </button>
            
          <button id="pay-btn"
              data-transaction-id="{{$transactionID}}"
              wire:loading.class='opacity-50' wire:target='checkout' class="cursor-pointer py-1 px-4 inline-flex justify-center items-center gap-x-2 font-semibold border bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
            <span wire:loading wire:target='checkout'>
              <span class="fa animate-spin fa-rotate float-end mt-2"></span>
              <span class="mx-2">Confirmation du payement en cours </span>
            </span>
            <span wire:loading.remove wire:target='checkout'>Valider le payement</span>
          </button>

        </div>
      @else
        @if($feda_transaction->status == 'approved')
          <h5 class="text-center py-3 text-green-800 border bg-green-300 text-xl rounded-2xl">Cette transaction a déjà été traité.</h5>
        @else
          <h5 class="text-center py-3 text-red-800 border bg-red-300 text-xl rounded-2xl">La transaction a déjà expiré. Veuillez reprendre la procédure</h5>
        @endif
      @endif
    </div>
  </div>

</div>
