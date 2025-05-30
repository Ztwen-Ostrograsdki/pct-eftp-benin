<div>
   <!-- DRAWER MENU -->
   @auth
  <div  id="drawer-online-users" class="fixed border-l border-sky-500 top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full w-auto z-bg-secondary-light" tabindex="-1" aria-labelledby="drawer-online-users-label">
    <h5 id="drawer-online-users-label" class="text-sm px-3 font-semibold text-sky-400 uppercase border-b pb-3  ">
      <span class="fas fa-users mr-2"></span>
      <span>Enseignants en lignes</span>
      <span class="fas fa-circle text-green-600 ml-2"></span>
   </h5>
    <button type="button" data-drawer-target="drawer-online-users"
    data-drawer-show="drawer-online-users"
    aria-controls="drawer-online-users" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white" >
      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
      </svg>
      <span class="sr-only">Close menu</span>
   </button>
  <div class="py-4 mt-9 overflow-y-auto">
      <ul class="space-y-2 font-medium lg:text-sm xl:text-sm md:text-sm sm:text-xs xs:text-xs">
         <li wire:key='online-users-user-id-{{auth_user()->id}}' class="mb-2 border border-sky-700 shadow-2 shadow-sky-600 rounded-full py-1 flex items-center">
            <div class="flex flex-wrap items-center justify-between space-x-2 dark:border-gray-700">
               <div class="flex px-6 md:mb-0 ">
                  <div class="flex mr-2 rounded-full">
                     <a title="Charger le profil de {{ auth_user()->getFullName() }}" href="#">
                        @if(auth_user()->profil_photo)
                              <img src="{{ url('storage', auth_user()->profil_photo) }}" alt="" class="object-cover w-12 h-12 rounded-full shadow-1 shadow-sky-400">
                        @else
                              <div class="border rounded-full border-gray-600 w-10 h-10 flex justify-center">
                                 <span class="fa fa-user mt-1" ></span>
                              </div>
                        @endif
                     </a>
                  </div>
                  <div>
                     <a class="text-xs letter-spacing-1" title="Charger votre profil" href="{{ route('user.profil', ['identifiant' => auth_user()->identifiant]) }}">
                        <h5 class="font-semibold text-sky-400">
                           Vous
                           <span class="fas fa-circle animate-pulse text-green-600 ml-2"></span>
                        </h5>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                              {{ auth_user()->status }}
                        </p>
                        @if(auth_user()->member)
                           <p class="text-xs text-yellow-500">
                              {{auth_user()->member->role ? auth_user()->member->role->name : 'Membre' }}
                           </p>
                        @endif
                     </a>
                  </div>
               </div>
               
               <div class="flex justify-end flex-col px-4">
               <p class="text-xs text-gray-600 dark:text-gray-400 hidden"> Inscrit depuis, {{ auth_user()->__getDateAsString(auth_user()->created_at) }}
               </p>
               </div>
            </div>
         </li>

         @if(!count($users))
         <li class="my-5 text-orange-600">
            <div class="flex flex-wrap items-center justify-between mb-2 space-x-2 dark:border-gray-700 my-5">
               <div class="flex items-center px-6 my-3">
                  <div class="my-9">
                     <a class="text-xs letter-spacing-1"  href="#">
                        <h5 class="font-semibold text-orange-600">
                           <span class="fas fa-user-slash mt-1" ></span>
                           Oupps aucun enseignant en ligne présentement
                        </h5>
                     </a>
                  </div>
               </div>
            </div>
         </li>
         @else
            @foreach($users as $user)
               <li wire:key='online-users-user-id-{{$user->id}}' class="mb-2 border-b">
                  <div class="flex flex-wrap items-center justify-between mb-2 space-x-2 dark:border-gray-700">
                     <div class="flex items-center px-6 mb-2 md:mb-0 ">
                     <div class="flex mr-2 rounded-full">
                        <a title="Charger le profil de {{ $user->getFullName() }}" href="#">
                           @if($user->profil_photo)
                                 <img src="{{ url('storage', $user->profil_photo) }}" alt="" class="object-cover w-12 h-12 rounded-full shadow-1 shadow-sky-400">
                           @else
                                 <div class="border rounded-full border-gray-600 w-10 h-10 flex justify-center">
                                    <span class="fa fa-user mt-1" ></span>
                                 </div>
                           @endif
                        </a>
                     </div>
                     <div>
                        <a class="text-xs letter-spacing-1" title="Charger le profil de {{ $user->getFullName() }}" href="#">
                           <h5 class="font-semibold text-sky-400">
                                 {{ $user->getFullName() }}
                           </h5>
                           <p class="text-xs text-gray-500 dark:text-gray-400">
                                 {{ $user->status }}
                           </p>
                           @if($user->member)
                              <p class="text-xs text-yellow-500">
                                 {{ $user->member->role ? $user->member->role->name : 'Membre' }}
                              </p>
                           @endif
                        </a>
                     </div>
                     </div>
                     <span class="fas fa-circle text-green-600 ml-2"></span>
                     <div class="flex justify-end flex-col px-4">
                     <p class="text-xs text-gray-600 dark:text-gray-400 hidden"> Inscrit depuis, {{ $user->__getDateAsString($user->created_at) }}
                     </p>
                     </div>
                  </div>
               </li>
            @endforeach
         @endif
         @auth
         
         <li class="mt-10">
            <a title="Se déconnecter" wire:click.prevent='logout' href="#" class="flex items-center mt-6 p-2 rounded-lg bg-red-400 border border-gray-50 hover:bg-red-600 text-gray-800 group">
               <span class="fas fa-user-xmark"></span>
               <span class="flex-1 ms-3 whitespace-nowrap">Déconnexion</span>
            </a>
         </li>
         @endauth
      </ul>
   </div>
   </div> {{-- Care about people's approval and you will be their prisoner. --}}
   @endauth

</div>
