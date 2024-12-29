<header class="flex z-50 sticky top-0 flex-wrap md:justify-start md:flex-nowrap w-full bg-white text-sm py-3 md:py-0 dark:bg-gray-800 shadow-md">
    <nav class="max-w-[85rem] w-full mx-auto px-4 md:px-6 lg:px-8" aria-label="Global">
      <div class="relative md:flex md:items-center md:justify-between">
        <div class="flex items-center justify-between">
          <a class="flex-none text-xl font-semibold dark:text-white dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/" aria-label="Brand">{{ config('app.name') }}</a>
          <div class="md:hidden">
            <button type="button" class="hs-collapse-toggle flex justify-center items-center w-9 h-9 text-sm font-semibold rounded-lg border border-gray-200 text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-collapse="#navbar-collapse-with-animation" aria-controls="navbar-collapse-with-animation" aria-label="Toggle navigation">
              <svg class="hs-collapse-open:hidden flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" x2="21" y1="6" y2="6" />
                <line x1="3" x2="21" y1="12" y2="12" />
                <line x1="3" x2="21" y1="18" y2="18" />
              </svg>
              <svg class="hs-collapse-open:block hidden flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" />
              </svg>
            </button>
          </div>
        </div>
  
        <div id="navbar-collapse-with-animation" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:block">
          <div class="overflow-hidden overflow-y-auto max-h-[75vh] [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-slate-700 dark:[&::-webkit-scrollbar-thumb]:bg-slate-500">
            <div class="flex flex-col gap-x-0 mt-5 divide-y divide-dashed divide-gray-200 md:flex-row md:items-center md:justify-end md:gap-x-7 md:mt-0 md:ps-7 md:divide-y-0 md:divide-solid dark:divide-gray-700">
  
              <a wire:navigate class=" hover:text-gray-500 font-medium {{request()->is('/') ? 'text-blue-600' : 'text-gray-400' }} py-3 md:py-6 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="/" aria-current="page">Acceuil</a>
              
              <a class="font-medium text-gray-400 hover:text-gray-500 py-3 md:py-6 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">
                L'association
              </a>

              <a wire:navigate class="font-medium hover:text-gray-500 py-3 md:py-6 {{request()->route()->named('master.users.list') ? 'text-blue-600' : 'text-gray-400' }} dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{route('master.users.list')}}">
                Les utilisateurs
              </a>

              <a wire:navigate class="font-medium hover:text-gray-500 py-3 md:py-6 {{request()->route()->named('master.orders.list') ? 'text-blue-600' : 'text-gray-400' }} dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{route('master.orders.list')}}">
                Les commandes
              </a>

              <a wire:navigate id="my-tooltip" title="Télécharger des épreuves" class="transition duration-150 ease-in-out dark:focus:text-primary-500 dark:active:text-primary-600 font-medium text-gray-400 hover:text-gray-500 py-3 md:py-6  dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{route('library.home')}}">
                Bibliothèque
              </a>
  
              <a href="{{route('shopping.home')}}" wire:navigate class="font-medium hover:text-gray-500 py-3 md:py-6 {{request()->route()->named('shopping.home') ? 'text-blue-600' : 'text-gray-400' }}  dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                Librairie
              </a>
              @if(auth_user() && count(auth()->user()->getNotifications()))
              <a href="{{route('user.notifications')}}" wire:navigate class="font-medium hover:text-gray-500 py-3 md:py-6 {{request()->route()->named('user.notifications') ? 'text-blue-600' : 'text-gray-400' }} dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                Notifications
                <span class="py-0.5 ml-1 px-1.5 rounded-full text-xs font-medium bg-blue-50 border border-blue-200 text-blue-600">
                  {{ count(auth()->user()->getNotifications()) }}
                </span>
              </a>
              @endif
              
              @if(auth_user() && $total_items && $total_items > 0)
              <a wire:navigate class="font-medium flex items-center hover:text-gray-500 py-3 md:py-6 {{request()->route()->named('shopping.cart') ? 'text-blue-600' : 'text-gray-400' }} dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{route('user.cart', ['identifiant' => auth_user()->identifiant])}}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="flex-shrink-0 w-5 h-5 mr-1">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                <span class="mr-1">Panier</span> <span class="py-0.5 px-1.5 rounded-full text-xs font-medium bg-blue-50 border border-blue-200 text-blue-600">
                  {{ $total_items }}
                </span>
              </a>
              @endif
              
              @guest
              <div class="pt-3 md:pt-0">
                <a wire:navigate class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 " href="{{route('login')}}">
                  <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                  </svg>
                  Connecter
                </a>
              </div>
              @endguest
  
              @auth
              <div class="hs-dropdown [--strategy:static] md:[--strategy:fixed] [--adaptive:none] md:[--trigger:hover] md:py-4">
                <button type="button" class="flex items-center w-full {{request()->route()->named('user.profil') ? 'text-blue-600' : 'text-gray-400' }} hover:text-gray-500 font-medium ">
                  {{ auth()->user()->pseudo }}
                <svg class="ms-2 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="m6 9 6 6 6-6" />
                </svg>
              </button>
  
              <div class="hs-dropdown-menu transition-[opacity,margin] duration-[0.1ms] md:duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 md:w-48 hidden z-10 bg-white md:shadow-md rounded-lg p-2 dark:bg-gray-800 md:dark:border dark:border-gray-700 dark:divide-gray-700 before:absolute top-full md:border before:-top-5 before:start-0 before:w-full before:h-5">
                
                
                @if(auth()->user()->profil_photo)
                <a wire:navigate class="rounded-full p-0 m-0 px-3 mb-2 mx-auto flex items-center justify-between" href="#">
                  <span class="text-orange-600"> 
                    <b>{{ auth()->user()->pseudo }}</b>
                    <small class="text-orange-400">{{ auth()->user()->email }}</small>
                  </span>
                  <img class="h-10 w-10 border rounded-full m-0 p-0 flex items-center gap-x-3.5 text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1" src="{{ url('storage', auth()->user()->profil_photo) }}" alt="Photo de profil">
                </a>
                <hr class="mb-2">
                @endif

                @if(auth()->user()->isAdminAs(['admin', 'master']))
                  <a wire:navigate href="{{url('/administration')}}" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 " >
                    Administration
                  </a>
                  <a href="{{route('master.users.list')}}" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 " >
                    Gestion utilisateurs
                  </a>
                  <a href="{{route('master.orders.list')}}" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 " >
                    Gestion commandes
                  </a>
                  <a href="{{route('user.notifications')}}" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 " >
                    Mes notifications 

                    @if(count(auth()->user()->getNotifications()))
                    <span class="ml-1 text-orange-600">
                      <span class="py-0.5 px-1.5 rounded-full text-xs font-medium bg-blue-50 border border-blue-200 text-orange-600">
                        <strong>{{ count(auth()->user()->getNotifications()) }}</strong>
                      </span>
                    </span>
                    @endif
                  </a>
                @endif
                <a wire:navigate class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 " href="{{route('user.orders', ['identifiant' => auth_user()->identifiant])}}">
                  Mes commandes
                </a>
                @if($total_items && $total_items > 0)
                <a wire:click.prevent='clearCart'  href="#" class="flex items-center cursor-pointer gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1 ">
                  Vider mon panier <b> ({{ $total_items }}) </b>
                </a>
                @endif
                <a wire:navigate href="{{route('user.profil', ['identifiant' => auth_user()->identifiant])}}" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1">
                  Mon profil
                </a>
                <a wire:navigate wire:click='logout' href="#" class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1">
                  Deconnexion
                </a>
              </div>
              </div>
              @endauth
  
            </div>
  
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>