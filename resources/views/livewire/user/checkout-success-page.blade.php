<div class="w-full mx-auto bg-transparent">
    @if($order)
    <h5 class="justify-center max-w-6xl px-4 py-4 my-4 mx-auto border rounded-full dark:border-white letter-spacing-2 bg-gray-900 lg:text-lg md:text-base sm:text-sm xs:text-xs text-gray-200">
      <span>Page Profil de la commande <span class="text-yellow-500 float-right">{{ $order->identifiant }}</span></span>
    </h5>
    <div class="mx-auto items-center font-poppins bg-transparent border border-green-700 lg:text-lg md:text-base sm:text-sm xs:text-xs">
        <div class="justify-center flex-1 max-w-6xl px-4 py-4 my-4 mx-auto border rounded-md dark:border-white bg-gray-900 md:py-10 md:px-10">
          <div>
            <h1 class="px-4 mb-8  tracking-wide text-green-500 ">
              Merci! Votre commande a été reçue 

              <span class="text-orange-500 float-right">
                ID:
                <span>
                  {{ $order->identifiant }}
                </span>
              </span>
              
              <hr class="my-3">
            </h1>
              
            <div class="flex border-b border-gray-200 dark:border-gray-700  items-stretch justify-start w-full h-full px-4 mb-8 md:flex-row xl:flex-col md:space-x-6 lg:space-x-8 xl:space-x-0">
              <div class="flex justify-between w-full">
                <div class="flex items-center justify-center pb-6 space-x-4 md:justify-start w-full">
                  <div class="flex flex-col items-start justify-start space-y-2">
                    <p class="  leading-4 text-left text-blue-400">
                        <span>
                            Acheteur :
                        </span>
                        <span>
                            {{ auth_user()->getFullName() }}
                        </span>
                    </p>
                    <p class="  leading-4 text-left text-blue-600">
                        <span>
                            Receveur :
                        </span>
                        <span>
                            {{ $address->getFullName() }}
                        </span>
                    </p>
                    <p class=" leading-4 text-gray-600 dark:text-gray-400">{{ $address->state }}, {{ $address->city }}</p>
                    <p class=" leading-4 text-gray-600 dark:text-gray-400">{{ $address->street_address }}</p>
                    <p class=" leading-4 cursor-pointer dark:text-gray-400">Contact: {{ $address->phone }}</p>
                  </div>
                </div>

                <div>
                  @if($order->approved)
                  <h4 class="text-success-600 animate-pulse letter-spacing-2 ">
                      Déjà approuvée par les admins
                  </h4>
                  @endif
                  @if($order->status !== 'delivered')
                  <h4 class="text-orange-500 animate-pulse letter-spacing-2">
                      {{ $order->getIsCompletedStatusMessage() }}
                  </h4>
                  @else
                  <h4 class="text-yellow-400 p-2 shadow-3 shadow-green-400 rounded-xl letter-spacing-2 ">
                    <strong>
                      {{ $order->getIsCompletedStatusMessage() }}
                      <span class="fa fa-check"></span>
                    </strong>
                  </h4>
                  @endif
                </div>
              </div>
            </div>
            <div class="flex items-center pb-4 mb-10 border-b border-gray-200 dark:border-gray-700">
              
              <div class="w-full px-4 mb-4">
                <p class="mb-2  leading-5 text-gray-600 dark:text-gray-400 ">
                  Date de soumission: </p>
                <p class="text-base  leading-4 text-gray-800 dark:text-gray-400">
                  {{ $order->__getDateAsString($order->created_at, 3, true) }} 
                </p>
              </div>
              <div class="w-full px-4 mb-4">
                <p class="mb-2 leading-5 text-gray-800 dark:text-gray-400 ">
                  Total Brut: </p>
                <p class=" leading-4 text-blue-600 dark:text-gray-400">
                  {{ Number::currency($order->getTotalAmountWithTaxAndShipping(false), $order->currency) }}
                </p>
              </div>
              <div class="w-full px-4 mb-4">
                <p class="mb-2  leading-5 text-gray-600 dark:text-gray-400 ">
                  Méthode de payement: </p>
                <p class=" leading-4 text-gray-800 dark:text-gray-400 ">
                  {{ config('app.payments_methods')[$order->payment_method] }}
                </p>
              </div>
            </div>
            <div class="px-4 mb-10">
              <div class="flex flex-col items-stretch justify-center w-full space-y-4 md:flex-row md:space-y-0 md:space-x-8">
                <div class="flex flex-col w-full space-y-6 ">
                  <h2 class="mb-2   text-gray-700 dark:text-gray-400">Détails de la commande</h2>
                  <div class="flex flex-col items-center justify-center w-full pb-4 space-y-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between w-full">
                      <p class="text-base leading-4 text-gray-800 dark:text-gray-400">Total brut</p>
                      <p class="text-base leading-4 text-gray-600 dark:text-gray-400">{{ Number::currency($order->grand_total, $order->currency) }}</p>
                    </div>
                    <div class="flex items-center justify-between w-full">
                      <p class="text-base leading-4 text-gray-800 dark:text-gray-400">Réduction
                      </p>
                      <p class="text-base leading-4 text-gray-600 dark:text-gray-400"> {{ numberZeroFormattor($order->discount) }} % </p>
                    </div>
                    <div class="flex items-center justify-between w-full">
                      <p class="text-base leading-4 text-gray-800 dark:text-gray-400">Coût expédition</p>
                      <p class="text-base leading-4 text-gray-600 dark:text-gray-400"> {{ Number::currency($order->shipping_price, $order->currency) }} </p>
                    </div>
                    <div class="flex items-center justify-between w-full">
                      <p class="text-base leading-4 text-gray-800 dark:text-gray-400">Taxe: </p>
                      <p class="text-base leading-4 text-gray-600 dark:text-gray-400"> {{ Number::currency($order->tax, $order->currency) }} </p>
                    </div>
                  </div>
                  <div class="flex items-center justify-between w-full">
                    <p class="text-base  leading-4 text-gray-800 dark:text-gray-400">Total</p>
                    <p class="text-base  leading-4 text-gray-600 dark:text-gray-400">{{ Number::currency($order->getTotalAmountWithTaxAndShipping(true), $order->currency) }}</p>
                  </div>
                </div>
                <div class="flex flex-col w-full px-2 space-y-4 md:px-8 ">
                  
                  <div class="flex items-start justify-between w-full">
                    <div class="flex items-center justify-center space-x-2">
                      <div class="w-8 h-8">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-6 h-6 text-blue-600 dark:text-blue-400 bi bi-truck" viewBox="0 0 16 16">
                          <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z">
                          </path>
                        </svg>
                      </div>
                      <div class="flex flex-col items-center justify-start">
                        <p class="text-lg  leading-6 text-gray-800 dark:text-gray-400">
                          Livraison par : 
                          <span class=" font-normal"></span>
                          <span class="text-green-600">
                            {{ config('app.shipping_methods')[$order->shipping_method] }}
                          </span>
                          <br>
                          @if($order->shipping_date)
                          <span class="text-green-500">
                            Livré le {{ $order->__getDateAsString($order->shipping_date, 3) }} 
                          </span>
                          @else
                            <span class="text-red-400">
                              Pas encore livré
                            </span>
                          @endif
                        </p>
                      </div>
                    </div>
                    <p class="text-lg  leading-6 text-gray-800 dark:text-gray-400"></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex items-center justify-start gap-4 px-4 mt-6 ">
              <a href="{{route('shopping.home')}}" class="w-full text-center px-4 py-2 text-blue-500 border border-blue-500 rounded-md md:w-auto hover:text-white hover:bg-blue-600 dark:border-gray-700 ">
                Retour au shopping
              </a>
              <a href="{{route('user.orders', ['identifiant' => auth_user()->identifiant])}}" class="w-full text-center px-4 py-2 bg-blue-500 rounded-md text-gray-50 md:w-auto dark:text-gray-300 hover:bg-blue-600">
                Voir mes commandes
              </a>
            </div>
          </div>
          @if(__isAdminAs())
          <div class="w-full mx-auto p-2 my-2 border-t border-gray-500">
            <div class="w-full mx-auto flex gap-2 justify-end my-2">
              @if(!$order->deleted_at)
              <div>
                <span wire:click="deleteOrder({{$order->id}})" class="border cursor-pointer bg-red-300 text-red-700 hover:bg-red-400 px-3 py-2 rounded ">
                    <span class="fas fa-trash"></span>
                    <span wire:loading.remove wire:target='deleteOrder({{$order->id}})'>Supprimer</span>
                    <span wire:loading wire:target='deleteOrder({{$order->id}})' class="">Suppresion en cours...</span>
                    <span wire:loading wire:target='deleteOrder({{$order->id}})' class="fas fa-rotate animate-spin"></span>
                </span>
              </div>
              @endif
              @if($order->approved)
                @if(!$order->shipping_date)
                <div>
                  <span wire:click="shippedOrder({{$order->id}})" class="border cursor-pointer bg-green-300 text-green-700 hover:bg-green-400 px-3 py-2 rounded ">
                      <span class="fas fa-check"></span>
                      <span wire:loading.remove wire:target='shippedOrder({{$order->id}})'>Marquer Livrée</span>
                      <span wire:loading wire:target='shippedOrder({{$order->id}})' class="">Traitement en cours...</span>
                      <span wire:loading wire:target='shippedOrder({{$order->id}})' class="fas fa-rotate animate-spin"></span>
                  </span>
                </div>
                @endif

                @if(!$order->shipping_date && !$order->completed)
                <div>
                  <span wire:click="completedOrder({{$order->id}})" class="border cursor-pointer bg-blue-300 text-blue-700 hover:bg-blue-400 px-3 py-2 rounded ">
                      <span class="fas fa-filter"></span>
                      <span wire:loading.remove wire:target='completedOrder({{$order->id}})'>Marquer commande Traitée</span>
                      <span wire:loading wire:target='completedOrder({{$order->id}})' class="">Traitement en cours...</span>
                      <span wire:loading wire:target='completedOrder({{$order->id}})' class="fas fa-rotate animate-spin"></span>
                  </span>
                </div>
                @endif
              @endif
            </div>
        </div>
        <div class="w-full mx-auto p-2 cursor-pointer flex my-1 justify-end">
          @if(auth_user() && $order->user_id == auth_user()->id)
            <div class="w-full mx-auto">
              @if($order->approved && !in_array($order->status, ['procecced', 'delivered', 'approved']))
              <span wire:click='initOrderCheckout' wire:loading.class='opacity-50' wire:target='initOrderCheckout' class="cursor-pointer py-1 px-4 inline-flex justify-center items-center gap-x-2  border bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-gray-950 hover:bg-green-700 disabled:opacity-50 disabled:pointer-events-none">
                <span wire:loading wire:target='initOrderCheckout'>
                  <span class="fa animate-spin fa-rotate float-end mt-2"></span>
                  <span class="mx-2">Processus de payement en cours... </span>
                </span>
                <span wire:loading.remove wire:target='initOrderCheckout'>
                  <span class="">
                    Procéder au payement de cette commande N° {{ $order->identifiant }}
                  </span>
                </span>
            </span>
              @endif
            </div>
            @endif
            @if(__isAdminAs())
              @if(!$order->approved)
                <span wire:click='approveOrder' wire:loading.class='opacity-50' wire:target='approveOrder' class="cursor-pointer py-1 px-4 inline-flex justify-center items-center gap-x-2  border bg-yellow-500 mt-4 w-full p-3 rounded-lg text-lg text-gray-900 hover:bg-yellow-700 disabled:opacity-50 disabled:pointer-events-none">
                    <span wire:loading wire:target='approveOrder'>
                      <span class="fa animate-spin fa-rotate float-end mt-2"></span>
                      <span class="mx-2">Validation en cours... </span>
                    </span>
                    <span wire:loading.remove wire:target='approveOrder'>
                      <span class="">
                        Approuver cette commande N° {{ $order->identifiant }}
                      </span>
                    </span>
                </span>
              @endif
            @endif
        </div>
        @endif
      </div>
    </div>
    @endif
</div>