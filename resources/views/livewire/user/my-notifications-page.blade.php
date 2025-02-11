<div>
  <div class="mx-auto shadow-3 shadow-sky-600 rounded-lg  my-3 lg:w-4/6 xl:w-4/6 2xl:w-4/6 w-11/12 p-2 m-2 z-bg-secondary-light">
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
    <section class="py-14 rounded-xl shadow-3 shadow-sky-600 font-poppins lg:w-4/6 xl:w-4/6 2xl:w-4/6 w-11/12 mx-auto p-2 m-2 z-bg-secondary-light">
        <div class="w-full px-4 mx-auto lg:text-base md:text-sm sm:text-sm xs:textxs">
          <div class="w-full mx-auto">
            <div class="text-left w-full">
              <div class="relative flex flex-col">
                <div class="w-full mx-auto">
                    @if(auth()->user()->profil_photo)
                        <span class="rounded-full p-0 m-0 px-3 mb-2 mx-auto flex items-center justify-end">
                        <span class="text-green-600 text-center"> 
                            <img class="h-10 w-10 text-center border mx-auto rounded-full m-0 p-0  text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300 dark:focus:outline-none dark:focus:ring-1" src="{{ url('storage', auth()->user()->profil_photo) }}" alt="Photo de profil">
                            <b>{{ auth()->user()->pseudo }}</b> <br>
                            <small class="text-green-600">Vous êtes connecté</small>
                        </span>
                        </span>
                    @endif
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
              <div class="w-full grid ">
                <input wire:model.live="search" type="search" id="epreuve-search" class=" block w-full p-2.5 ps-10 text-sm letter-spacing-2 border  bg-transparent rounded-lg focus:ring-blue-500 focus:border-blue-500  dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500 focus text-sky-200" placeholder="Lister les notifications par : un mot clé, un titre, un objet..." />
              </div>
            </div>

            <div class="py-3 w-full bg-transparent shadow ">
              <div class="w-full flex justify-start">
                <form action="" class="w-3/5 flex justify-start">
                  <select  class="z-bg-secondary-light  font-semibold letter-spacing-1 rounded-lg shadow-1 shadow-sky-400 text-sky-300 py-3 w-full px-2" wire:model.live='sectionned' id="user_e_notifications_section">
                    @foreach ($notif_sections as $key => $sec)
                      <option class="border-none" wire:key="option-{{$sec}}-{{auth()->user()->id}}" class="z-bg-secondary-light font-semibold letter-spacing-1 my-2" value="{{$key}}">{{ $sec }}</option>
                    @endforeach
                  </select>
                </form>
              </div>
            </div>
            
            @if(count($my_notifications))
            
            @foreach ($my_notifications as $key => $notif)
            <div wire:click="markAsRead({{$notif->id}})" wire:key="notif-{{$notif->id}}-{{auth()->user()->id}}" class="py-6 rounded-xl z-bg-secondary-light shadow-2 shadow-sky-500 mb-2">
              <div class="flex flex-wrap items-center justify-between pb-4 mb-2 space-x-2 border-b dark:border-gray-700">
                <div class="flex items-center px-6 mb-2 md:mb-0 ">
                  <div class="flex mr-2 rounded-full">
                    <a title="Charger le profil de {{ $notif->user->getFullName() }}" href="{{ route('user.profil', ['identifiant' => $notif->user->identifiant]) }}">
                        @if($notif->user->profil_photo)
                            <img src="{{ url('storage', $notif->user->profil_photo) }}" alt="" class="object-cover w-12 h-12 rounded-full shadow-1 shadow-sky-400">
                        @else
                            <div class="border rounded-full border-gray-600 w-10 h-10 flex justify-center">
                                <span class="fa fa-user text-lg mt-1" ></span>
                            </div>
                        @endif
                    </a>
                </div>
                  <div>
                    <a class="text-xs letter-spacing-1" title="Charger le profil de {{ $notif->user->getFullName() }}" href="{{ route('user.profil', ['identifiant' => $notif->user->identifiant]) }}">
                        <h5 class="font-semibold text-sky-400">
                            {{ $notif->user->getFullName() }}
                        </h5>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $notif->user->status }}
                        </p>
                    </a>
                  </div>
                </div>
                <p class="px-6 text-xs text-gray-600 dark:text-gray-400"> Inscrit depuis, {{ $notif->user->__getDateAsString($notif->user->created_at) }}
                </p>
              </div>
              <div class="flex flex-col px-6 mb-6 text-xs text-gray-400">
                <div class="w-full">
                    <h4 class="text-sky-300 letter-spacing-1">
                        <strong>Action:</strong>
                        <span> {{ $notif->title }} </span>
                    </h4>
                </div>
                <div class="flex justify-end">
                    <h4 class="text-green-400 letter-spacing-1">
                        <strong>Objet:</strong>
                        <span> {{ $notif->object }} </span>
                    </h4>
                </div>
                <div class="shadow-1 shadow-sky-400 rounded-lg border-gray-600 my-2 p-2">
                    <strong class="text-yellow-600 font-bold letter-spacing-2">Contenu:</strong>
                    <p class="letter-spacing-1">
                        {{ $notif->content }}
                    </p>
                </div>
            </div>
              
              <div class="flex flex-wrap justify-between gap-y-2 pt-4 border-t dark:border-gray-700">
                <div class="flex px-6 mb-2 md:mb-0 text-xs letter-spacing-1">
                  <h6 class=" text-gray-400">
                    <span class="fas fa-clock text-blue-500"></span>
                    Envoyé le : 
                    <span class="font-semibold text-gray-600 dark:text-gray-300"> 
                        {{ $notif->__getDateAsString($notif->created_at, 3, true) }} 
                    </span>
                  </h6>
                </div>
                <div class="flex items-center px-6 space-x-1 text-gray-400">
                  <div class="flex items-center text-xs">
                    <div class="flex gap-x-2 mr-3 float-right justify-end  text-gray-700 dark:text-gray-400">
                        <div class="float-right">
                          <span class="border cursor-pointer bg-purple-300 text-purple-700 hover:bg-purple-400 hover:shadow-lg hover:shadow-sky-600 px-3 py-2 rounded ">
                              <span class="fas fa-eye"></span>
                              <span>Lu</span>
                          </span>
                        </div>
                      <div class="float-right">
                        <span wire:click="deleteNotif({{$notif->id}})" class="border cursor-pointer bg-red-300 text-red-700 hover:shadow-lg hover:shadow-sky-600 hover:bg-red-400 px-3 py-2 rounded ">
                            <span class="fas fa-trash"></span>
                            <span class="sm:hidden xs:hidden md:inline " wire:loading.remove wire:target='deleteNotif({{$notif->id}})'>Supprimer</span>
                            <span wire:loading wire:target='deleteNotif({{$notif->id}})' class="fas fa-rotate animate-spin"></span>
                        </span>
                      </div>
                      
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
            @endforeach
            @elseif($search)
              <div>
                <h5 class="text-gray-400 letter-spacing-1 shadow-inner rounded-lg shadow-sky-500 lg:text-lg xl:text-lg md:text-sm sm:text-sm xs:text-sm animate-pulse text-center py-4 my-4">
                  <span>Désolée aucun résultat trouvé avec 
                    <b class="text-red-600 underline">
                      {{ $search }}
                    </b>
                  </span>
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
