<div>
    <section class="py-14 font-poppins dark:bg-gray-800 lg:w-4/6 xl:w-4/6 2xl:w-4/6 w-11/12 mx-auto p-2 m-2">
        <div class="w-full px-4 mx-auto">
          <div class="w-full mx-auto">
            <div class="text-left w-full">
              <div class="relative flex flex-col">
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
                    Mes <span class="text-blue-500"> Notifications</span> 
                    <span class="text-blue-300 ml-3 text-base lowercase @if($search  && strlen($search) >= 3) hidden @endif ">
                      <span class="fas fa-quote-left"></span>
                      {{ config('app.notifications_sections')[$sectionned] }}
                      <span class="fas fa-quote-right"></span>
                    </span>
                    <span class="text-gray-400 float-right text-sm "> {{ numberZeroFormattor(count($my_notifications), true) }} </span>
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
              @if(count($my_notifications))
              <p class="mb-12 text-base text-gray-500">
                Vous avez de nouvelles notifications
              </p>
              @endif
            </div>
          </div>
      
          <div class="grid gap-2 gap-y-2">
            <div class="py-3 px-2 bg-white rounded-md shadow dark:bg-gray-900 ">
              <div class="w-full grid ">
                <form class="w-full mx-auto">   
                  <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                  <div class="relative">
                      <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                          </svg>
                      </div>
                      <input wire:model.live="search" type="text" id="default-search" class="cursive text-cursive block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Entrer un mot clé, Pseudo, Nom, Prenoms, Email, grade, établissemnt, contacts,..." required />
                      <span class="text-white cursor-pointer absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Rechercher</span>
                  </div>
              </form>
              </div>
            </div>

            <div class="py-3 px-2 bg-white rounded-md shadow dark:bg-gray-900">
              <div class="w-full grid">
                <form action="w-full">
                  <select  class="bg-transparent text-white py-3 w-full px-2" wire:model.live='sectionned' id="user_e_notifications_section">
                    @foreach ($notif_sections as $key => $sec)
                      <option class="bg-gray-700" value="{{$key}}">{{ $sec }}</option>
                    @endforeach
                  </select>
                </form>
              </div>
            </div>
            
            @if(count($my_notifications))
            
            @foreach ($my_notifications as $key => $notif)
            <div class="py-6 bg-white rounded-md shadow dark:bg-gray-900">
              <div class="flex flex-wrap items-center justify-between pb-4 mb-6 space-x-2 border-b dark:border-gray-700">
                <div class="flex items-center px-6 mb-2 md:mb-0 ">
                  <div class="flex mr-2 rounded-full">
                    <a title="Charger le profil de {{ $notif->user->getFullName() }}" href="{{ route('user.profil', ['id' => $notif->user->id]) }}">
                        @if($notif->user->profil_photo)
                            <img src="{{ url('storage', $notif->user->profil_photo) }}" alt="" class="object-cover w-12 h-12 rounded-full">
                        @else
                            <div class="border rounded-full border-gray-600 w-10 h-10 flex justify-center">
                                <span class="fa fa-user text-lg mt-1" ></span>
                            </div>
                        @endif
                    </a>
                </div>
                  <div>
                    <a title="Charger le profil de {{ $notif->user->getFullName() }}" href="{{ route('user.profil', ['id' => $notif->user->id]) }}">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-300">
                            {{ $notif->user->getFullName() }}
                        </h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $notif->user->current_function }}
                        </p>
                    </a>
                  </div>
                </div>
                <p class="px-6 text-base font-medium text-gray-600 dark:text-gray-400"> Inscrit depuis, {{ $notif->user->__getDateAsString($notif->user->created_at) }}
                </p>
              </div>
              <div class="flex flex-col px-6 mb-6 text-base text-gray-500 dark:text-gray-400">
                <div class="w-full">
                    <h4 class="text-blue-600">
                        <strong>Action:</strong>
                        <span> {{ $notif->title }} </span>
                    </h4>
                </div>
                <div class="flex justify-end">
                    <h4 class="text-red-700">
                        <strong>Objet:</strong>
                        <span> {{ $notif->object }} </span>
                    </h4>
                </div>
                <div class="border rounded-lg border-gray-600 shadow-xl my-2 p-3">
                    <strong class="text-yellow-600">Contenu:</strong>
                    <p class="">
                        {{ $notif->content }}
                    </p>
                </div>
            </div>
              
              <div class="flex flex-wrap justify-between pt-4 border-t dark:border-gray-700">
                <div class="flex px-6 mb-2 md:mb-0">
                  <h2 class="text-sm text-gray-500 dark:text-gray-400">
                    <span class="fas fa-clock text-blue-500"></span>
                    Envoyé le : 
                    <span class="font-semibold text-gray-600 dark:text-gray-300"> 
                        {{ $notif->__getDateAsString($notif->created_at, 3, true) }} 
                    </span>
                  </h2>
                </div>
                <div class="flex items-center px-6 space-x-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                  <div class="flex items-center">
                    <div class="flex gap-x-2 mr-3 text-sm text-gray-700 dark:text-gray-400">
                        <div>
                            <span wire:click="confirmedUserUnblocked({{$notif->id}})" class="border cursor-pointer bg-green-300 text-green-700 hover:bg-green-400 px-3 py-2 rounded ">
                                <span class="fas fa-unlock"></span>
                                <span>Débloquer</span>
                            </span>
                        </div>
                        <div>
                          <span class="border cursor-pointer bg-purple-300 text-purple-700 hover:bg-purple-400 px-3 py-2 rounded ">
                              <span class="fas fa-eye"></span>
                              <span>Lu</span>
                          </span>
                        </div>
                      <div>
                        <span wire:click="deleteNotif({{$notif->id}})" class="border cursor-pointer bg-red-300 text-red-700 hover:bg-red-400 px-3 py-2 rounded ">
                            <span class="fas fa-trash"></span>
                            <span wire:loading.remove wire:target='deleteNotif({{$notif->id}})'>Supprimer</span>
                            <span wire:loading wire:target='deleteNotif({{$notif->id}})' class="fas fa-rotate animate-spin"></span>
                        </span>
                      </div>
                      <div>
                        <span wire:click='sendEmailTo({{$notif->id}})' class="border cursor-pointer bg-blue-300 text-blue-700 hover:bg-blue-400 px-3 py-2 rounded ">
                            <span class="fas fa-comment"></span>
                            <span>Repondre</span>
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
                  <strong>Vous n'avez aucune notification <span class="text-warning-600"> {{ config('app.notifications_sections')[$sectionned] }} </span> en cours...</strong>
                </h4>
              </div>
            @endif
            
          </div>
        </div>
      </section>
</div>
