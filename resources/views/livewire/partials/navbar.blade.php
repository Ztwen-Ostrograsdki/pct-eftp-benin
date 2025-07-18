<nav class="bg-white border-b top-0 start-0 fixed border-sky-600 dark:bg-gray-900 w-full z-50">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
  <a href="#"
   data-drawer-hide="drawer-navigation" data-drawer-show="drawer-navigation" aria-controls="drawer-navigation" data-drawer-body-scrolling="true" type="button" data-drawer-backdrop="false" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="{{asset(env('APP_LOGO'))}}" alt="" class="h-9 rounded-full animate-pulse hover:animate-none" alt="{{config('app.name')}}">
      
      <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 hidden animate-spin hover:animate-none" alt="{{config('app.name')}}" />
      <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">{{ config('app.name') }}</span>
  </a>
  <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
    @auth
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
          <li>
            <a href="#" wire:click="deleteProfilPhoto" class="block text-gray-400 px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600  dark:hover:text-white">
              Supprimer ma photo de profil
            </a>
          </li>
          @if(auth_user()->isAdminsOrMaster())
          <li>
            <a wire:navigate href="{{route('master.users.list')}}" class="block {{request()->route()->named('master.users.list') ? 'text-blue-600' : 'text-gray-400' }} px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600  dark:hover:text-white">
              Gestion utilisateurs
            </a>
          </li>
          @endif
          
          <li>
            <a wire:navigate href="{{route('user.notifications', ['identifiant' => auth_user()->identifiant])}}" class="block {{request()->route()->named('user.notifications') ? 'text-blue-600' : 'text-gray-400' }} px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600  dark:hover:text-white">
              Mes notification
              <span class="py-0.5 float-right px-1.5 rounded-full text-xs font-medium bg-blue-50 border border-blue-200 text-blue-600">
                {{ count(auth()->user()->unreadNotifications) }}
              </span>
            </a>
          </li>
          
          @if(auth_user()->member)
          <li>
            <a wire:navigate href="{{route('member.profil', ['identifiant' => auth_user()->identifiant])}}" class="block {{request()->route()->named('member.profil') ? 'text-yellow-600 bg-gray-800' : 'text-gray-400' }} px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600  dark:hover:text-white">
              Statut membre
            </a>
          </li>
          <li>
            <a wire:navigate href="{{route('member.payments', ['identifiant' => auth_user()->identifiant])}}" class="block {{request()->route()->named('member.payments') ? 'text-yellow-600 bg-gray-800' : 'text-gray-400' }} px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600  dark:hover:text-white">
              Mes cotisations
            </a>
          </li>
          <li>
            <a wire:navigate href="{{route('member.admins.roles', ['identifiant' => auth_user()->identifiant])}}" class="block {{request()->route()->named('member.admins.roles') ? 'text-yellow-600 bg-gray-800' : 'text-gray-400' }} px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600  dark:hover:text-white">
              Mes rôles administrateurs
            </a>
          </li>
          <li>
            <a wire:navigate href="{{route('member.quotes', ['identifiant' => auth_user()->identifiant])}}" class="block {{request()->route()->named('member.quotes') ? 'text-yellow-600 bg-gray-800' : 'text-gray-400' }} px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600  dark:hover:text-white">
              Mes citations
            </a>
          </li>
          @endif
          @auth
            @if(auth_user()->isAdminsOrMaster() || auth_user()->roles)
            <li class="">
              <a wire:navigate href="{{route('master.members.home')}}" class="block {{request()->route()->named('master.members.home') ? 'text-yellow-600 bg-gray-800' : 'text-gray-400' }} px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600  dark:hover:text-white">
                Administration
              </a>
            </li>
            @endif
          @endauth
          <li>
            <a href="{{route('library.home')}}" class="block px-4 py-2 text-sm  hover:bg-gray-100 dark:hover:bg-gray-600 {{request()->route()->named('library.home') ? 'text-yellow-600 bg-gray-800' : 'text-gray-400' }} ">
              Bibliothèque
            </a>
          </li>
          <li>
            <a title="Se déconnecter" wire:click.prevent='logout' href="#" class="block px-4 py-2 text-sm hover:bg-red-600 dark:hover:bg-red-600 border rounded-xl bg-red-400 text-gray-50 text-center mx-2">
              <strong class="letter-spacing-2">Deconnexion</strong>
            </a>
          </li>
        </ul>
      </div>
      @endauth
      <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-user" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
      </button>
      <button class="text-white bg-gray-700 hover:bg-blue-300 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-transparent dark:hover:bg-gray-800 focus:outline-none dark:focus:ring-blue-800 hidden" type="button" data-drawer-target="drawer-navigation" data-drawer-hide="drawer-navigation" data-drawer-show="drawer-navigation" aria-controls="drawer-navigation" data-drawer-backdrop="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
      </button>
      
  </div>
  
  <div class="items-center justify-between hidden w-full lg:flex md:w-auto md:order-1" id="navbar-user">
    <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
      <li>
        <a wire:navigate href="{{route('home')}}" class="block hover:text-sky-400 py-2 px-3 rounded md:bg-transparent {{request()->route()->named('home') ? 'text-blue-600' : 'text-gray-200' }}  md:p-0 " aria-current="page">
          Acceuil
        </a>
      </li>
      @auth
        @if(auth_user()->isAdminsOrMaster() || auth_user()->roles)
        <li>
          <a wire:navigate href="{{route('master.members.home')}}" class="block hover:text-sky-400 py-2 px-3 rounded md:p-0 {{request()->route()->named('master.members.home') ? 'text-blue-600' : 'text-gray-200' }} ">Administration</a>
        </li>
        @endif
      @endauth
      <li class="hidden">
        <a wire:navigate href="{{route('master.members.home')}}" class="block hover:text-sky-400 py-2 px-3 rounded {{request()->route()->named('master.members.home') ? 'text-blue-600' : 'text-gray-200' }}  md:p-0 ">Association</a>
      </li>
      <li>
        <a wire:navigate href="{{route('library.home')}}" class="block hover:text-sky-400 py-2 px-3 rounded {{request()->routeIs('library.home', 'library.fiches', 'library.epreuve.profil', 'library.epreuves.examens', 'library.epreuves', 'library.epreuves.uplaoder', 'library.fiches.uplaoder') ? 'text-blue-600' : 'text-gray-200' }}  md:p-0 ">Bibliothèque</a>
      </li>
      @if(count($communiques) > 0)
      <li>
        <a wire:navigate href="{{route('communique.dispatched')}}" class="block hover:text-sky-400 py-2 px-3 rounded {{request()->route()->named('communique.dispatched') ? 'text-blue-600' : 'text-gray-200' }}  md:p-0 ">Communiqués</a>
      </li>
      @endif
      <li>
        <a wire:navigate href="{{route('lycee.listing')}}" class="block hover:text-sky-400 py-2 px-3 rounded {{request()->route()->named('lycee.listing') ? 'text-blue-600' : 'text-gray-200' }}  md:p-0 ">Lycées et centres</a>
      </li>
      @auth
      <li>
        <a wire:navigate href="{{route('forum.chat')}}" class="block hover:text-sky-400 py-2 px-3 rounded {{request()->route()->named('forum.chat') ? 'text-blue-600' : 'text-gray-200' }}  md:p-0 ">
          Forum
        </a>
      </li>
      @endauth
      
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

  <!-- DRAWER MENU -->
  <div id="drawer-navigation" class="fixed border-r top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white w-auto dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-navigation-label">
    <h5 id="drawer-navigation-label" class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400">Menu</h5>
    <button type="button" data-drawer-hide="drawer-navigation" aria-controls="drawer-navigation" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
      </svg>
      <span class="sr-only">Close menu</span>
   </button>
  <div class="py-4 overflow-y-auto">
      <ul class="space-y-2 font-medium">
        @auth
          @if(auth_user()->isAdminsOrMaster() || auth_user()->roles)
          <li>
              <a wire:navigate href="{{route('master.members.home')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group  {{request()->route()->named('master.members.home') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
                <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                    <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                    <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                </svg>
                <span class="ms-3">Administration</span>
              </a>
          </li>
          @endif
         @endauth
         <li>
          <a wire:navigate href="{{route('lycee.listing')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group  {{request()->route()->named('lycee.listing') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
             <span class="fas fa-school"></span>
             <span class="ms-3">Les lycées et centres</span>
          </a>
        
       </li>
       
         <li class="">
            <button type="button" class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group {{request()->routeIs('library.home', 'library.fiches', 'library.epreuve.profil', 'library.epreuves.examens', 'library.epreuves', 'library.epreuves.uplaoder', 'library.fiches.uplaoder') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }} text-white hover:bg-gray-700" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                  <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 21">
                     <path d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z"/>
                  </svg>
                  <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap mr-3">Banques des épreuves et fiches</span>
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                     <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                  </svg>
            </button>
            <ul id="dropdown-example" class="hidden  py-2 space-y-2">
                  <li class="">
                     <a wire:navigate href="{{route('library.epreuves')}}" class="flex items-center w-full gap-x-2 p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{request()->route()->named('library.epreuves') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
                      <span class="fas fa-book"></span>
                      <span>Les épreuves</span>
                    </a>
                  </li>
                  <li class="">
                    <a wire:navigate href="{{route('library.epreuves.examens')}}" class="flex items-center w-full gap-x-2 p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{request()->route()->named('library.epreuves.examens') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
                     <span class="fas fa-book"></span>
                     <span>Les épreuves d'examens</span>
                   </a>
                 </li>
                  <li>
                     <a wire:navigate href="{{route('library.fiches')}}" class="flex items-center w-full p-2 gap-x-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{request()->route()->named('library.fiches') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
                      <span class="fas fa-book"></span>
                      <span>Fiches de cours</span>
                    </a>
                  </li>
            </ul>
         </li>
        @auth
         <li class="">
          <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-user-profil-details" data-collapse-toggle="dropdown-user-profil-details">
                <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 21">
                   <path d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z"/>
                </svg>
                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap mr-3">Mon profil</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                   <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
          </button>
          <ul id="dropdown-user-profil-details" class="hidden py-2 space-y-2">
                <li class="">
                   <a wire:navigate href="{{route('user.profil', ['identifiant' => auth_user()->identifiant])}}"class="flex items-center w-full gap-x-2 p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{request()->route()->named('user.profil') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
                    <span class="fas fa-user"></span>
                    <span>Profil utilisateur</span>
                  </a>
                </li>
                
                <li>
                   <a wire:navigate href="{{route('member.profil', ['identifiant' => auth_user()->identifiant])}}" class="flex items-center w-full p-2 gap-x-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{request()->route()->named('member.profi') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
                    <span class="fas fa-user-check"></span>
                    <span>Profil membre</span>
                    
                  </a>
                </li>
                
               <li>
                <a wire:navigate href="{{route('member.quotes', ['identifiant' => auth_user()->identifiant])}}" class="flex items-center w-full p-2 gap-x-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{request()->route()->named('member.quotes') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
                  <span class="fas fa-quote-left"></span>
                  <span>Mes citations</span>
               </a>
             </li>
              @if(auth_user()->member)
                <li>
                  <a wire:navigate href="{{route('member.profil', ['identifiant' => auth_user()->identifiant])}}" class="flex items-center w-full p-2 gap-x-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{request()->route()->named('member.profi') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
                    <span class="fas fa-user-shield"></span>
                    <span>Profil membre</span>
                 </a>
               </li>
              <li>
                  <a wire:navigate href="{{route('member.payments', ['identifiant' => auth_user()->identifiant])}}" class="flex items-center w-full p-2 gap-x-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{request()->route()->named('member.payments') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
                    <span class="fas fa-coins"></span>
                    <span>Mes Cotisations</span>
                </a>
              </li>
              @if (auth_user()->roles)
                <li>
                  <a wire:navigate href="{{route('member.admins.roles', ['identifiant' => auth_user()->identifiant])}}" class="flex items-center w-full p-2 gap-x-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{request()->route()->named('member.admins.roles') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
                    <span class="fas fa-user-secret"></span>
                    <span>Mes rôles administrateurs</span>
                </a>
              </li>
              @endif
           @endif
           <li>
              <a wire:navigate href="{{route('user.notifications', ['identifiant' => auth_user()->identifiant])}}" class="flex items-center w-full p-2 gap-x-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{request()->route()->named('user.notifications') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
                <span class="fas fa-message"></span>
                <span>Mes notification</span>
               <span class="py-0.5 float-right px-1.5 rounded-full text-xs font-medium bg-blue-50 border border-blue-200 text-blue-600">
                {{ count(auth()->user()->unreadNotifications) }}
              </span>
             </a>
           </li>
          </ul>
       </li>
       <li>
        <a wire:navigate href="{{route('forum.chat')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group  {{request()->route()->named('forum.chat') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
           <span class="fas fa-comments"></span>
           <span class="ms-3">Forum</span>
        </a>
       </li>
       @endauth
       @auth
         @if(auth_user()->isAdminsOrMaster() || auth_user()->hasRole(['users-manager']))
         <li>
            <a wire:navigate href="{{route('master.users.list')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->route()->named('master.users.list') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
              <span class="fas fa-users"></span>
               <span class="flex-1 ms-3 whitespace-nowrap">Liste des utilisateurs</span>
               <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                {{ numberZeroFormattor(count(getUsers())) }}
              </span>
            </a>
         </li>
         @endif

         @if(auth_user()->isAdminsOrMaster() || auth_user()->hasRole(['members-manager']))
         <li>
          <a wire:navigate href="{{route('master.members.list')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->route()->named('master.members.list') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
             <span class="fas fa-users-gear"></span>
             <span class="flex-1 ms-3 whitespace-nowrap">Liste des membres</span>
             <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
              {{ numberZeroFormattor(count(getMembers())) }}
            </span>
          </a>
        </li>
         @endif
        @endauth
        <li>
          <a wire:navigate href="{{route('communique.dispatched')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->route()->named('communique.dispatched') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
             <span class="fas fa-newspaper"></span>
             <span class="flex-1 ms-3 whitespace-nowrap">Communiqués</span>
             <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
              {{ numberZeroFormattor(count(getActivesCommuniques())) }}
            </span>
          </a>
       </li>
        @auth
         <li>
            <a title="Se déconnecter" wire:click.prevent='logout' href="#" class="flex items-center p-2 rounded-lg bg-red-400 border border-gray-50 hover:bg-red-600 text-gray-800 group">
               <span class="fas fa-user-xmark"></span>
               <span class="flex-1 ms-3 whitespace-nowrap">Se déconnecter</span>
            </a>
         </li>
         @endauth
         @guest
         <li>
            <a wire:navigate href="{{route('login')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->route()->named('login') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/>
               </svg>
               <span class="flex-1 ms-3 whitespace-nowrap">Se connecter</span>
            </a>
         </li>
         <li>
            <a wire:navigate href="{{route('register')}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{request()->route()->named('register') ? 'z-bg-secondary-light border border-sky-500 shadow-1 shadow-sky-400' : '' }}">
               <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
                  <path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/>
                  <path d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z"/>
               </svg>
               <span class="flex-1 ms-3 whitespace-nowrap">S'inscrire</span>
            </a>
         </li>
         @endguest
      </ul>
   </div>
</div>
@livewire('chat.online-users')
</nav>
