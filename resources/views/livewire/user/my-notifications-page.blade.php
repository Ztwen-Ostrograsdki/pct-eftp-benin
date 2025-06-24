<div>
    <div class="mx-auto shadow-3 shadow-sky-600 rounded-lg  my-3 max-w-6xl p-2 m-2 z-bg-secondary-light">
        <h1 class="p-4 text-gray-300 flex items-center justify-between uppercase text-center">
            <span class="text-xs letter-spacing-2">
                <strong class="text-sky-400">
                    Gestion de mes notifications 
                
                </strong>
            </span>

            <div class="flex gap-x-2">
                
            </div>
        </h1>
    </div>
    <section class="py-14 rounded-xl shadow-3 shadow-sky-600 font-poppins max-w-6xl mx-auto p-2 m-2 z-bg-secondary-light">
        <div class="w-full px-4 mx-auto lg:text-base md:text-sm sm:text-sm xs:text-xs">
          <div class="w-full mx-auto">
            <div class="text-left w-full">
              <div class="relative flex flex-col">
                <div class="w-full mx-auto hidden">
                    
                </div>
                <h4 class="font-bold dark:text-gray-200"> 
                    Mes <span class="text-blue-500"> Notifications</span> 
                    <span class="text-blue-300 ml-3 text-base lowercase @if($search  && strlen($search) >= 3) hidden @endif ">
                      <span class="fas fa-quote-left"></span>
                      {{ config('app.notifications_sections')[$sectionned] }}
                      <span class="fas fa-quote-right"></span>
                    </span>
                    <span class="text-gray-400 float-right  "> {{ numberZeroFormattor(count($my_notifications), true) }} </span>
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
            </div>
          </div>
      
          <div class="grid gap-2 gap-y-2">
            <div class="w-full bg-transparent rounded-md shadow ">
              <div class="w-full lg:text-sm md:text-xs xs:text-xs break-all">
                <input wire:model.live="search" type="search" id="epreuve-search" class=" block w-full p-2.5 ps-10 text-sm letter-spacing-2 border  bg-transparent rounded-lg focus:ring-blue-500 focus:border-blue-500  dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500 focus text-sky-200 lg:text-sm md:text-xs xs:text-xs break-all" placeholder="Lister les notifications par : un mot clé,..." />
              </div>
            </div>

            <div class="py-3 w-full bg-transparent shadow ">
              <div class="w-full flex justify-between">
                <form action="" class="w-3/5 flex justify-start">
                  <select  class="z-bg-secondary-light  font-semibold letter-spacing-1 rounded-lg shadow-1 shadow-sky-400 text-sky-300 py-3 w-full px-2" wire:model.live='sectionned' id="user_e_notifications_section">
                    @foreach ($notif_sections as $key => $sec)
                      <option class="border-none" wire:key="option-{{$sec}}-{{auth()->user()->id}}" class="z-bg-secondary-light font-semibold letter-spacing-1 my-2" value="{{$key}}">{{ $sec }}</option>
                    @endforeach
                  </select>
                </form>

                
                <div class="flex items-center justify-end gap-x-2">
                  <span wire:click='markAllAsRead' title="Marquées toutes les notifications lues..." class="hover:scale-110 rounded-md shadow-1 shadow-sky-500 py-2 flex items-center cursor-pointer  text-sky-600">
                    <span class="fas fa-pen px-4"></span>
                  </span>
  
                  <span wire:click='deleteAllNotifications' title="Suprimer les notifications de la section en cours..." class="hover:scale-110 rounded-md flex items-center cursor-pointer shadow-1 shadow-sky-500 py-2  text-red-600">
                    <span wire:target='deleteAllNotifications' wire:loading.remove class="fas fa-trash px-4"></span>
                    <span wire:target='deleteAllNotifications' wire:loading class="px-2" >
                        <span class="fas fa-rotate animate-spin"></span>
                        <span>en cours...</span>
                    </span>
                  </span>
                </div>
              </div>
            </div>
            
            @if(count($my_notifications))
            
            @foreach ($my_notifications as $key => $notif)

                @php
                    $name = $notif->id;
                @endphp
                <div class="flex flex-col gap-0 gap-y-1 items-center w-full p-1 my-2 shadow-1 shadow-purple-500  opacity-85 transition-opacity border border-gray-400" role="alert" >
                  <div wire:key="notif-page-{{$name}}" id="notif-{{$notif->id}}" class="flex gap-0 items-center w-full p-2 px-3 my-0 text-gray-200 bg-gray-800  opacity-85 transition-opacity" role="alert" >
                      <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-gray-500 bg-gray-100 rounded-lg dark:bg-gray-800 dark:text-gray-200">
                          <span class="fas fa-envelope-open"></span>
                          <span class="sr-only">Check icon</span>
                      </div>
                      <div class="ms-3 lg:text-sm md:text-xs xs:text-xs break-all font-semibold letter-spacing-1">{{ $notif->data ? $notif->data['message'] : 'Une notification...' }}</div>
                      <button wire:click='deleteNotification("{{$name}}")' title="Cliquer pour Masquer cette notification" type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#notif-{{$notif->id}}" aria-label="Close">
                          <span class="sr-only">Close</span>
                          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                          </svg>
                      </button>
                  </div>
                  <div class="text-right w-full py-0 my-0 text-xs border-b-2 bg-slate-600 font-semibold letter-spacing-1 text-yellow-400">
                      <small> Récu le {{ __formatDateTime($notif->created_at) }} </small>
                  </div>
                </div>
            @endforeach
            @elseif($search)
              <div>
                <h5 title="Cliquez vous effacer le champ de Rechercher" wire:click="$set('search', '')" class="cursor-pointer text-gray-400 letter-spacing-1 shadow-1 rounded-lg shadow-red-400 lg:text-sm xl:text-sm md:text-xs sm:text-xs xs:text-xs break-all animate-pulse text-center p-3 my-4">
                  <span>Désolée aucun résultat trouvé avec 
                    <b class="text-red-600 underline">
                      {{ $search }}
                    </b>
                  </span> 
                  <span> dans la section </span>
                  <span class="text-yellow-400"> {{ config('app.notifications_sections')[$sectionned] }}</span>
                </h5>
              </div>
            @else
              <div>
                <h5 class="text-gray-400 letter-spacing-1 shadow-inner font-semibold rounded-lg shadow-sky-500 lg:text-lg xl:text-lg md:text-sm sm:text-sm xs:text-sm animate-pulse text-center py-4 my-4">
                  <span>Vous n'avez aucune notification <span class="text-warning-600"> {{ config('app.notifications_sections')[$sectionned] }} </span> en cours...</span>
                </h5>
              </div>
            @endif
            
          </div>
        </div>
    </section>
</div>
