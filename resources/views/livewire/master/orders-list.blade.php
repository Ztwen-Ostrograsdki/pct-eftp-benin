<div>
    <section class="py-14 font-poppins dark:bg-gray-800 lg:w-4/6 xl:w-4/6 2xl:w-4/6 w-11/12 mx-auto p-2 m-2">
        <div class="w-full px-4 mx-auto">
          <div class="w-full mx-auto">
            <div class="text-left w-full">
              <div class="relative flex flex-col">
                <div>
                    <div class="text-4xl flex gap-x-2 text-gray-600 uppercase">
                      <h1>
                        <strong>
                            <span class="fas fa-cart-arrow-down"></span>
                            <span>Les commandes</span>
                        </strong>
                      </h1>

                      @if(session()->has('new_order'))
                        <h6 class="border shadow-lg shadow-green-400 border-white text-green-800 ml-3 px-3 opacity-65 bg-green-300 text-center text-xl">
                            {{ session('new_order') }}
                        </h6>
                      @endif
                    </div>
                </div>
                <div class="w-full mx-auto">
                    @if(auth()->user()->profil_photo)
                        <a wire:navigate class="rounded-full p-0 m-0 px-3 mb-2 mx-auto flex items-center justify-end" href="#">
                        <span class="text-green-600 text-center"> 
                            <img class="h-10 w-10 text-center border mx-auto rounded-full m-0 p-0 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1" src="{{ url('storage', auth()->user()->profil_photo) }}" alt="Photo de profil">
                            <b>{{ auth()->user()->pseudo }}</b> <br>
                            <small class="text-green-600">Vous êtes connecté</small>
                        </span>
                        </a>
                    @endif
                </div>
                <h4 class="text-2xl font-bold dark:text-gray-200"> 
                    Les <span class="text-blue-500"> Commandes</span> 
                    <span class="text-blue-300 ml-3 text-base lowercase @if($search  && strlen($search) >= 3) hidden @endif ">
                      <span class="fas fa-quote-left"></span>
                      {{ config('app.order_status')[$sectionned] }}
                      <span class="fas fa-quote-right"></span>
                    </span>
                    <span class="text-gray-400 float-right text-sm "> {{ numberZeroFormattor($orders->total(), true) }} commandes trouvées</span>
                </h4>
                <div class="flex w-full mt-2 mb-6 overflow-hidden rounded">
                  <div class="flex-1 h-2 bg-blue-200"></div>
                  <div class="flex-1 h-2 bg-blue-400"></div>
                  <div class="flex-1 h-2 bg-blue-500"></div>
                  <div class="flex-1 h-2 bg-blue-600"></div>
                  <div class="flex-1 h-2 bg-blue-700"></div>
                  <div class="flex-1 h-2 bg-blue-800"></div>
                </div>
              </div>
              @if(count($orders))
              <p class="mb-12 text-base text-gray-500">
                De nouvelles commandes sont disponibles
              </p>
              @endif
            </div>
          </div>
      
          <div class="grid gap-2 gap-y-2">
            <div class="py-3 px-2 bg-white rounded-md shadow dark:bg-gray-900 ">
              <div class="w-full grid ">
                <form class="w-full mx-auto">   
                  <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Rechercher</label>
                  <div class="relative">
                      <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                          </svg>
                      </div>
                      <input wire:model.live="search" type="text" id="default-search" class="cursive text-cursive block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Entrer un mot clé: article, date, status, montant, catégorie,..." required />
                      <span class="text-white cursor-pointer absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Rechercher</span>
                  </div>
              </form>
              </div>
            </div>

            <div class="py-3 px-2 bg-white rounded-md shadow dark:bg-gray-900">
              <div class="w-full grid">
                <form action="w-full">
                  <select  class="bg-transparent text-white py-3 w-full px-2" wire:model.live='sectionned' id="user_orders_section">
                    @foreach ($order_status as $key => $sec)
                      <option class="bg-gray-700" value="{{$key}}">{{ $sec }}</option>
                    @endforeach
                  </select>
                </form>
              </div>
            </div>
            
            @if(count($orders))
            
            @foreach ($orders as $key => $order)
              @livewire('master.order-profil', ['order' => $order])
            @endforeach
            @elseif($search)
              <div>
                <h4 class="text-gray-400 text-xl animate-pulse text-center">
                  <strong>Désolée aucune résultat trouvé avec 
                    <b class="text-red-600 underline">
                      {{ $search }}
                    </b>
                  </strong>
                </h4>
              </div>
            @else
              <div>
                <h4 class="text-gray-400 text-xl animate-pulse text-center">
                  <strong>Aucune commande <span class="text-warning-600"> {{ config('app.order_status')[$sectionned] }} </span> en cours...</strong>
                </h4>
              </div>
            @endif
            <div>
              {{$orders->links()}}
            </div>
          </div>
        </div>
      </section>
</div>
