<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-2xl font-semibold border my-2 p-2 bg-gray-800 rounded-lg text-gray-400 mb-4 w-full">Panier d'achat <span class="float-right text-gray-400">{{ count($carts_items) > 0 ? numberZeroFormattor($carts_items) . ' article(s) ' : ' Aucun article ' }} ajouté{{ count($carts_items) > 1 ? 's' : '' }}</span> </h1>
    <div class="container mx-auto px-4">
      <div class="flex flex-col text-gray-400 md:flex-row gap-4">
        <div class="md:w-3/4">
          <div class="bg-gray-900 overflow-x-auto rounded-lg border shadow-md p-6 mb-4">
            @if (count($carts_items))
            <table class="w-full">
              <thead class="border-b">
                <tr class=" text-gray-300">
                  <th class="text-left font-semibold p-2">Article</th>
                  <th class="text-left font-semibold">Prix</th>
                  <th class="font-semibold text-center">Quantité</th>
                  <th class="text-left font-semibold">Total</th>
                  <th class="text-left font-semibold">Action</th>
                </tr>
              </thead>
              <tbody>
                
                @forelse ($carts_items as $item)
                <tr class="shadow my-2 hover:bg-slate-500" wire:key='{{ $item['book_id'] }}'>
                  <td class="py-4">
                    <div class="flex items-center pl-3">
                      <a href="{{route('book.details', ['identifiant' => $item['identifiant'], 'slug' => $item['slug']])}}">
                        <img class="h-16 w-16 mr-4 border" src="{{url('storage', $item['image'])}}" alt="{{ $item['name'] }}">
                      </a>
                      <a href="{{route('book.details', ['identifiant' => $item['identifiant'], 'slug' => $item['slug']])}}">
                        <span class="font-semibold">{{ $item['name'] }}</span>
                      </a>
                    </div>
                  </td>
                  <td class="py-4"><b>{{ Number::currency($item['unit_amount'], 'CFA') }}</b></td>
                  <td class="py-4">
                    <div class="flex items-center">
                      <button wire:click='decrementQuantity({{$item['book_id']}})' class="border rounded-md hover:bg-orange-500 py-2 px-4 mr-2">-</button>
                      <span class="text-center w-8"> {{ $item['quantity'] >= 10 ? $item['quantity'] : '0' . $item['quantity']  }} </span>
                      <button wire:click='incrementQuantity({{$item['book_id']}})' class="border rounded-md hover:bg-green-600 py-2 px-4 ml-2">+</button>
                    </div>
                  </td>
                  <td class="py-4 "> <b>{{ Number::currency($item['total_amount'], 'CFA') }}</b></td>
                  <td><button wire:click='deleteItem({{$item['book_id']}})' class="bg-slate-500 text-gray-800 border-2 rounded-lg px-3 py-1 border-dark hover:bg-red-500 hover:text-white hover:border-red-700">Supprimer</button></td>
                </tr>
                @empty
                  
                @endforelse
                <!-- More product rows -->
              </tbody>
            </table>
            @else
            <div class="w-full my-8 bg-red-400 rounded-full py-3 border flex justify-center">
              <b class="text-red-800 text-2xl text-center">Oupps, votre panier est vide!!!</b>
            </div>
            <div class="md">
              <a class=" w-full mt-10" href="{{route('shopping.home')}}">
                <h3 class="bg-blue-500 hover:bg-green-600 text-white text-2xl rounded-3xl text-center py-4 mt-4 w-full">
                  <b>Faite un tout à la Librairie maintenant</b>
                </h3>
              </a>
            </div>
            @endif
          </div>
        </div>
        @if (count($carts_items))
        <div class="md:w-1/4">
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

            <a href="#" wire:click='checkoutCart' wire:loading.class='opacity-50' wire:target='checkoutCart' class="cursor-pointer py-1 px-4 inline-flex justify-center items-center gap-x-2 font-semibold border bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
              <span wire:loading wire:target='checkoutCart'>
                <span class="fa animate-spin fa-rotate float-end mt-2"></span>
                <span class="mx-2">Traitement en cours </span>
              </span>
              <span wire:loading.remove wire:target='checkoutCart'>Soumettre l'achat</span>
            </a>

            <span wire:click='clearCart' class="cursor-pointer bg-red-600 block text-center text-white py-2 px-4 border hover:bg-red-700 rounded-lg mt-4 w-full">Vider le panier</span>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>