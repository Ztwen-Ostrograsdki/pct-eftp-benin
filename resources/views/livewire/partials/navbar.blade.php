

<nav class="bg-white border-gray-200 dark:bg-gray-900">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
  <a wire:navigate href="{{route('home')}}" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 animate-spin hover:animate-none" alt="{{config('app.name')}}" />
      <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">{{ config('app.name') }}</span>
  </a>
  @auth
  <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
      <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
        <span class="sr-only">Open user menu</span>
        <img class="w-8 h-8 rounded-full" src="{{ user_profil_photo(auth_user()) }}" alt="user photo">
      </button>
      <!-- Dropdown menu -->
      <div class="z-50 border hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-3 shadow-sky-500 dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
        <div class="px-4 py-3">
          
            <span class="block text-sm text-gray-200 dark:text-orange-600">{{ auth_user_fullName() }}</span>
            <span class="block text-sm  text-gray-300 truncate dark:text-orange-400">
              {{ auth_user()->email }}
            </span>
          
        </div>
        <ul class="py-2" aria-labelledby="user-menu-button">
          <li>
            <a wire:navigate href="{{route('user.profil', ['identifiant' => auth_user()->identifiant])}}" class="block {{request()->route()->named('user.profil') ? 'text-blue-600' : 'text-gray-400' }} px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600  dark:hover:text-white">
              Mon profil
            </a>
          </li>
          @if(__isAdminAs())
          <li>
            <a wire:navigate href="{{route('master.users.list')}}" class="block {{request()->route()->named('master.users.list') ? 'text-blue-600' : 'text-gray-400' }} px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600  dark:hover:text-white">
              Gestion utilisateurs
            </a>
          </li>
          <li>
            <a wire:navigate href="{{route('master.orders.list')}}" class="block {{request()->route()->named('master.orders.list') ? 'text-blue-600' : 'text-gray-400' }} px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600  dark:hover:text-white">
              Gestion commandes
            </a>
          </li>
          @if(count(auth()->user()->getNotifications()))
          <li>
            <a wire:navigate href="{{route('user.notifications')}}" class="block {{request()->route()->named('user.notifications') ? 'text-blue-600' : 'text-gray-400' }} px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600  dark:hover:text-white">
              Mes notification
              <span class="py-0.5 float-right px-1.5 rounded-full text-xs font-medium bg-blue-50 border border-blue-200 text-blue-600">
                {{ count(auth()->user()->getNotifications()) }}
                </span>
            </a>
          </li>
          @endif
          @endif
          @if(auth_user()->member)
          <li>
            <a wire:navigate href="{{route('member.profil', ['identifiant' => auth_user()->identifiant])}}" class="block {{request()->route()->named('member.profil') ? 'text-blue-600' : 'text-gray-400' }} px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600  dark:hover:text-white">
              Statut membre
            </a>
          </li>
          @endif
          <li>
            <a wire:navigate href="{{route('master.members.home')}}" class="block {{request()->route()->named('master.members.home') ? 'text-blue-600' : 'text-gray-400' }} px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600  dark:hover:text-white">
              Association
            </a>
          </li>
          <li>
            <a href="{{route('library.home')}}" class="block px-4 py-2 text-sm  hover:bg-gray-100 dark:hover:bg-gray-600 {{request()->route()->named('library.home') ? 'text-blue-600' : 'text-gray-400' }} ">
              Bibliothèque
            </a>
          </li>
          <li>
            <a href="{{route('shopping.home')}}" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600  {{request()->route()->named('shopping.home') ? 'text-blue-600' : 'text-gray-400' }} ">
              Boutique
            </a>
          </li>
          <li>
            <a href="{{route('user.orders', ['identifiant' => auth_user()->identifiant])}}"" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600  {{request()->route()->named('user.orders') ? 'text-blue-600' : 'text-gray-400' }} ">
              Mes commandes
            </a>
          </li>
          @if(auth_user() && $total_items && $total_items > 0)
          <li>
            <a href="{{route('user.cart', ['identifiant' => auth_user()->identifiant])}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 {{request()->route()->named('user.cart') ? 'text-blue-600' : 'text-gray-400' }} ">
                Panier
                <span class="py-0.5 px-1.5 rounded-full float-right text-xs font-medium bg-blue-50 border border-blue-200 text-blue-600">
                {{ $total_items }}
                </span>
            </a>
          </li>
          <li>
            <a wire:click.prevent='clearCart' href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 text-orange-400 ">
              Vider panier
              <span class="py-0.5 px-1.5 rounded-full float-right text-xs font-medium bg-blue-50 border border-blue-200 text-blue-600">
                {{ $total_items }}
                </span>
            </a>
          </li>
          @endif
          <li>
            <a wire:click.prevent='logout' href="#" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 text-yellow-400 ">
              <strong class="letter-spacing-2">Deconnexion</strong>
            </a>
          </li>
        </ul>
      </div>
      <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-user" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
    </button>
  </div>
  @endauth
  <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
    <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
      <li>
        <a wire:navigate href="{{route('home')}}" class="block hover:text-sky-400 py-2 px-3 rounded md:bg-transparent {{request()->route()->named('home') ? 'text-blue-600' : 'text-gray-200' }}  md:p-0 " aria-current="page">
          Acceuil
        </a>
      </li>
      @if(__isAdminAs())
      <li>
        <a wire:navigate href="{{url('/administration')}}" class="block hover:text-sky-400 py-2 px-3 rounded text-gray-200  md:p-0 ">Administration</a>
      </li>
      @endif
      <li>
        <a wire:navigate href="{{route('master.members.home')}}" class="block hover:text-sky-400 py-2 px-3 rounded {{request()->route()->named('master.members.home') ? 'text-blue-600' : 'text-gray-200' }}  md:p-0 ">Association</a>
      </li>
      <li>
        <a wire:navigate href="{{route('library.home')}}" class="block hover:text-sky-400 py-2 px-3 rounded {{request()->route()->named('library.home') ? 'text-blue-600' : 'text-gray-200' }}  md:p-0 ">Bibliothèque</a>
      </li>
      <li>
        <a wire:navigate href="{{route('shopping.home')}}" class="block hover:text-sky-400 py-2 px-3 rounded {{request()->route()->named('shopping.home') ? 'text-blue-600' : 'text-gray-200' }}  md:p-0 ">Librairie</a>
      </li>
      @if(auth_user() && $total_items && $total_items > 0)
      <li>
        <a wire:navigate href="{{route('user.cart', ['identifiant' => auth_user()->identifiant])}}" class="block hover:text-sky-400 py-2 px-3 rounded {{request()->route()->named('user.cart') ? 'text-blue-600' : 'text-gray-200' }}  md:p-0 ">
          Panier
          <span class="py-0.5 px-1.5 rounded-full text-xs font-medium bg-blue-50 border border-blue-200 text-blue-600">
            {{ $total_items }}
            </span>
        </a>
      </li>
      @endif
      
      @guest
      <li>
        <a wire:navigate href="{{route('login')}}" class="block hover:text-sky-400 py-2 px-3 rounded {{request()->route()->named('login') ? 'text-blue-600' : 'text-gray-200' }}  md:p-0 ">
          
          <span class="fas fa-user"></span>
          Se connecter
        </a>
      </li>
      <li>
        <a wire:navigate href="{{route('register')}}" class="block hover:text-sky-400 py-2 px-3 rounded {{request()->route()->named('register') ? 'text-blue-600' : 'text-gray-200' }}  md:p-0 ">
          <span class="fas fa-user-plus"></span>
          S'inscrire
        </a>
      </li>
      @endguest
      
    </ul>
  </div>
  </div>
</nav>
