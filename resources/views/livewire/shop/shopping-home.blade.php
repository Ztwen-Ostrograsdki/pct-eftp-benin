<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="py-2 bg-gray-800 border rounded-lg w-full my-2">
        <div class="w-full px-2">
          <h4 class="py-3 xs:text-xs lg:text-base">
                <span class="text-green-600">
                    Bienvenue
                </span>
                <span class="text-green-500">
                    à la
                </span>
                <span class="text-green-400 ml-2">
                    Librairie
                </span>

                <span class="text-green-200 ml-2">
                    des Physiciens 
                </span>
            </h4>
        </div>
    </div>
    <section class="py-3 bg-gray-50 font-poppins dark:bg-gray-800 rounded-lg">
      <div class="px-4 mx-auto max-w-7xl lg:py-6 md:px-6">
        <div class="grid lg:grid-cols-4  mb-24 -mx-3">
          <div class="pr-2 sm:col-span-4 xs:col-span-4 lg:col-span-1 grid md:grid-cols-4 lg:grid-cols-4 xs:grid-cols-4 sm:grid-cols-4 lg:block xs:text-xs lg:text-base">
            <div class="p-4 mb-5 xs:col-span-2 sm:col-span-2 lg:col-span-1 bg-white border border-gray-200 dark:border-gray-900 dark:bg-gray-900">
              <h2 class="xs:text-sm lg:text-base font-bold dark:text-gray-400"> Par Promotion</h2>
              <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
              <ul>
                @foreach(getPromotions(true) as $p_id => $promo)
                <li class="mb-4">
                  <label for="" class="flex items-center dark:text-gray-400 ">
                    <input type="checkbox" class="w-4 h-4 mr-2">
                    <span class="">{{ $promo->name }}</span>
                  </label>
                </li>
                @endforeach
              </ul>
            </div>
            <div class="p-4 mb-5 xs:col-span-2 sm:col-span-2 lg:col-span-1 bg-white border border-gray-200 dark:border-gray-900 dark:bg-gray-900">
              <h2 class="xs:text-sm lg:text-base font-bold dark:text-gray-400">Par Filières</h2>
              <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
              <ul>
                @foreach(getFiliars(true) as $f_id => $fil)
                <li class="mb-4">
                  <label for="" class="flex items-center dark:text-gray-300">
                    <input type="checkbox" class="w-4 h-4 mr-2">
                    <span class=" dark:text-gray-400">{{ $fil->name }}</span>
                  </label>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
          <div class="w-full xs:col-span-4 sm:col-span-4 lg:col-span-3 lg:grid-cols-4">
            <div class="px-3 mb-4">
              <div class="items-center justify-between hidden px-3 py-2 bg-gray-100 sm:flex dark:bg-gray-900 rounded-lg shadow-2">
                <div class="flex items-center w-2/5 justify-between py-2">
                  <select name="" id="" class="block w-full text-base px-3 bg-gray-100 border-none cursor-pointer dark:text-gray-400 dark:bg-gray-900">
                    <option class="py-4" value="">Trier par classe</option>
                    @foreach (getClasses(true) as $c_id => $cl)
                      <option class="py-4 px-3" value="{{$cl->id}}"> {{ $cl->name }} </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
              
            <div class="grid xs:grid-cols-4 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-4 gap-2"
              @foreach($books as $book)
              <div class="w-full px-3 xs:col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-2">
                <div @if(array_key_exists($book->id, $carts_items)) title="Vous avez ajouté cet document au panier"  @endif class="border @if(array_key_exists($book->id, $carts_items)) shadow-md transition-shadow shadow-green-600 opacity-65 hover:opacity-100 @endif transition-opacity border-gray-300 dark:border-gray-700">
                  <div class="relative bg-gray-200">
                    <a href="{{route('book.details', ['identifiant' => $book->identifiant, 'slug' => $book->slug])}}" class="">
                      @if(isset($book->images) && count($book->images) > 0 )
                      <img src="{{url('storage', $book->images[$image_indexes[$book->id]['index']]) }}" alt="{{$book->name}}" class="object-cover w-full h-56 mx-auto ">
                      @else
                      <div class="object-cover w-full h-56 mx-auto flex justify-center bg-gray-600">
                          <b class="text-gray-500 text-center text-lg mt-32">Aucune image</b>
                      </div>
                      @endif
                    </a>
                  </div>
                  <div class="p-3 lg:text-base sm:text-xs xs:text-xs">
                    <div class="flex items-center justify-between gap-2 mb-2">
                      <h3 class="flex w-full justify-between font-medium dark:text-gray-400">
                        <span>{{$book->name}}</span>
                        @if(count($book->images) > 1)
                        <img wire:click='reloadImageIndex({{$book->id}})' title="Recharger une autre image" class="w-5 h-5 hover:animate-spin cursor-pointer float-right" src="{{url('images/icons/refresh.ico')}}"/>
                        @endif
                      </h3>
                    </div>
                    <p class="text-lg ">
                      <span class="text-green-600 dark:text-green-600">
                        {{Number::currency($book->price, 'CFA')}}
                      </span>
                      
                    </p>
                  </div>
                  <div class="flex justify-center p-4 border-t border-gray-300 dark:border-gray-700">
  
                    <a title="Ajouter cet article au panier" wire:click.prevent="addToCart({{$book->id}})" href="#" class="text-gray-500 flex items-center space-x-2 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-300">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 h-4 bi bi-cart3 @if(array_key_exists($book->id, $carts_items)) text-green-600 @endif" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"></path>
                      </svg>
                      @if(array_key_exists($book->id, $carts_items))
                      <span wire:click="addToCart({{$book->id}})" wire:loading.remove wire:target="addToCart({{$book->id}})">
                        <b> ({{ $carts_items[$book->id]['quantity'] }}) </b>
                        Ajouter encore au panier
                      </span>
                      @else
                      <span wire:loading.remove wire:target="addToCart({{$book->id}})">Ajouter au panier</span>
                      @endif
                      <span wire:loading wire:target="addToCart({{$book->id}})">Ajout en cours ...</span>
                    </a>
  
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            </div>
            <!-- pagination start -->
            <div class="flex justify-end mt-6">
                {{$books->links()}} 
            </div>
            <!-- pagination end -->
          </div>
        </div>
      </div>
    </section>
  
  </div>