<div>
    @if($order)
        <div class="py-6 bg-white rounded-md shadow dark:bg-gray-900">
          <div class="flex items-center ml-2 px-2 text-xs gap-x-1 cursor-pointer hover:text-blue-500">
            <span class="fas fa-circle"></span>
            <span class="fas fa-circle"></span>
            <span class="fas fa-circle"></span>
          </div>
          <div class="flex flex-wrap items-center justify-between pb-4 mb-6 space-x-2 border-b dark:border-gray-700">
            <div class="flex items-center px-6 mb-2 md:mb-0 ">
              <div class="flex mr-2 rounded-full">
                <a title="Charger le profil de {{ $order->user->getFullName() }}" href="{{ route('user.profil', ['identifiant' => $order->user->identifiant]) }}">
                    @if($order->user->profil_photo)
                        <img src="{{ url('storage', $order->user->profil_photo) }}" alt="" class="object-cover w-12 h-12 rounded-full">
                    @else
                        <div class="border rounded-full border-gray-600 w-10 h-10 flex justify-center">
                            <span class="fa fa-user text-lg mt-1" ></span>
                        </div>
                    @endif
                </a>
            </div>
              <div>
                <a title="Charger le profil de la commande {{ $order->identifiant }}" href="{{ route('user.checkout.success', ['identifiant' => $order->identifiant]) }}">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-300">
                        ID Commande: {{ $order->identifiant }}
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Effectuée par {{ $order->user->getFullName() }}
                    </p>
                </a>
              </div>
              
            </div>
            
            <div class="flex gap-x-2">
              <p class="px-6 text-base font-medium text-gray-600 dark:text-gray-400 flex flex-col"> 
                <span class="text-green-500">
                  Montant brut de la commande : {{ Number::currency($order->grand_total, $order->currency) }}
                </span>
                <span class="text-gray-300">
                    <span>
                      <span>Payé par : {{ config('app.payments_methods')[$order->payment_method] }}</span>
                      <span class="text-green-700">(Payé) <span class="fas fa-check text-green-600"></span> </span>
                    </span>
                </span> 
                <span class="flex flex-col">
                  <span>
                    <span> Méthode:</span>
                    <span>{{ config('app.shipping_methods')[$order->shipping_method] }}</span>
                  </span>
  
                  <span>
                    <span>Status:</span>
                    <span class="text-orange-400">{{ config('app.order_status')[$order->status] }}</span>
                  </span>
                </span>
              </p>
            </div>
          </div>
          <div class="flex flex-col px-6 mb-6 text-base text-gray-500 dark:text-gray-400">
            <div class="flex flex-col items-start justify-start">
              <div class="w-full flex justify-between p-2">
                <div class="">
                  <p class="text-lg font-semibold text-left text-blue-400">
                    <span>
                        Acheteur :
                    </span>
                    <span>
                        {{ auth_user()->getFullName() }}
                    </span>
                  </p>
                  <p class="text-lg font-semibold leading-4 text-left text-blue-600">
                      <span>
                          Receveur :
                      </span>
                      <span>
                          {{ $order->address->getFullName() }}
                      </span>
                  </p>
                </div>
                <div>
                    <div>
                      @if($order->shipping_date)
                      <span class="text-green-500">
                        Livré le {{ $order->__getDateAsString($order->shipping_date, 3) }} 
                      </span>
                      @else
                        <span class="text-red-400">
                          Pas encore livré
                        </span>
                      @endif
                    </div>
                    <h4 class="text-orange-400 animate-pulse text-center shadow-2 shadow-green-400 px-2 letter-spacing-2">
                      {{ $order->getIsCompletedStatusMessage() }}
                    </h4>
                </div>
              </div>
              <div class="flex p-2 justify-between w-full">
                <div class="flex gap-x-2">
                  <strong>Adresse de livraison: </strong>
                  <span class="text-sm mt-1  text-gray-600 dark:text-gray-400">{{ $order->address->state }}, {{ $order->address->city }}</span>
                  <span class="text-sm mt-1 text-gray-600 dark:text-gray-400">{{ $order->address->street_address }}</span>
                </div>
                <p class="text-sm cursor-pointer dark:text-gray-400">Contact: <span class="letter-spacing-2">{{ $order->address->phone }}</span> </p>
              </div>
            </div>
            <div class="my-2 p-2 border rounded-lg bg-gray-900">
              <h4 class="text-spacing-2 text-orange-700">
                <strong>
                  Détails sur les documents achétés
                </strong>
              </h4>
              <div class="flex gap-2 my-2 shadow-sm ">
                @foreach ($order->items as $item)
                  <div class="border rounded-lg p-3 cursor-pointer opacity-55 hover:opacity-100">
                    <div>
                      <div class="flex-shrink-0 flex gap-x-2">
                        <img alt="{{$item->book->name}}" class="w-12 h-12 rounded" src="{{url('storage', $item->book->images[0])}}">
                        </img>
                        <h4 class="text-success-600">{{ $item->book->name }} </h4>
                      </div>
                      <h4> Prix unitaire: {{ Number::currency($item->unit_amount, $order->currency) }} </h4>
                      <h4> Quantité achetée: {{ numberZeroFormattor($item->quantity) }} </h4>
                      <h4> Montant cumulé: {{ Number::currency($item->total_amount, $order->currency) }} </h4>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="flex flex-col w-full">
              <h2 class="mb-2 text-xl font-semibold text-gray-700 dark:text-gray-400 text-center underline letter-spacing-2">Détails Tarifs: Taxe et Réduction</h2>
              <div class="flex flex-col items-center justify-center w-full pb-4 space-y-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between w-full">
                  <p class="text-base leading-4 text-gray-800 dark:text-gray-400">Total brut</p>
                  <p class="text-base leading-4 text-orange-300">{{ Number::currency($order->grand_total, $order->currency) }}</p>
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
              <div class="flex items-center justify-between w-full mt-2">
                <p class="text-base font-semibold leading-4 text-gray-800 dark:text-gray-400">Total</p>
                <p class="text-base font-semibold leading-4 text-orange-600">{{ Number::currency($order->getTotalAmountWithTaxAndShipping(true), $order->currency) }}</p>
              </div>
            </div>
        </div>
          
          <div class="flex flex-wrap justify-between pt-4 border-t dark:border-gray-700">
            <div class="flex px-6 mb-2 md:mb-0">
              <h2 class="text-sm text-gray-500 dark:text-gray-400">
                <span class="fas fa-clock text-blue-500"></span>
                Commande soumise le : 
                <span class="font-semibold text-gray-600 dark:text-gray-300"> 
                    {{ $order->__getDateAsString($order->created_at, 3, true) }} 
                </span>
              </h2>
            </div>
            <div class="flex items-center px-6 space-x-1 text-sm font-medium text-gray-500 dark:text-gray-400">
              <div class="flex items-center">
                <div class="flex gap-x-2 mr-3 text-sm text-gray-700 dark:text-gray-400">
                    
                  <div>
                    <span wire:click="deleteOrder({{$order->id}})" class="border cursor-pointer bg-red-300 text-red-700 hover:bg-red-400 px-3 py-2 rounded ">
                        <span class="fas fa-eye"></span>
                        <span wire:loading.remove wire:target='deleteOrder({{$order->id}})'>Masquer</span>
                        <span wire:loading wire:target='deleteOrder({{$order->id}})' class="">Traitement en cours...</span>
                        <span wire:loading wire:target='deleteOrder({{$order->id}})' class="fas fa-rotate animate-spin"></span>
                    </span>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
        </div>
    @endif
</div>
