<div>
    <div class="mx-auto shadow-3 shadow-sky-600 rounded-lg  my-3 lg:w-4/6 xl:w-4/6 2xl:w-4/6 w-11/12 p-2 m-2 z-bg-secondary-light">
      <h1 class="p-4 text-gray-300 flex items-center justify-between uppercase text-center">
          <span class="text-xs letter-spacing-2">
              <strong class="text-sky-400">
                  Page des lois regissant l'association
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
                  <div class="w-full mx-auto flex justify-end gap-x-2 mt-2 mb-3">
                      <span wire:click='newLaw' class="border cursor-pointer hover:bg-blue-700 rounded-lg py-2 px-1 bg-blue-600 text-white font-semibold letter-spacing-1 text-sm">
                        <span>Ajouter une loi</span>
                        <span class="fas fa-plus"></span>
                      </span>
                  </div>
                  
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
                  <input wire:keydown.enter='searcher' wire:model.live="search" type="search" id="epreuve-search" class=" block w-full p-2.5 ps-10 text-sm letter-spacing-2 border  bg-transparent rounded-lg focus:ring-blue-500 focus:border-blue-500  dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500 focus text-sky-200" placeholder="Filtrer les lois par : un mot clé, un titre, un chapitre, un contenu..." />
                </div>
              </div>
              
              @if(count($all_laws))
              
              @foreach ($all_laws as $key => $law)
              <div wire:key="forum-chat-law-{{$law->id}}" class="py-6 rounded-xl z-bg-secondary-light shadow-2 shadow-sky-500 mb-2">
                <div class="flex flex-wrap items-center justify-between pb-4 mb-2 space-x-2 border-b dark:border-gray-700">
                  <div class="flex items-center px-6 mb-2 md:mb-0 ">
                    <div>
                      <a title="Charger le profil de la loi: {{ $law->name }}" class="text-xs letter-spacing-1" href="{{route('law.profil', ['slug' => $law->slug])}}">
                          <h5 class="font-semibold text-sky-400 flex flex-col">
                            <span>
                              <span class="text-yellow-600">Loi: </span>
                              <span>{{ $law->name }}</span>
                            </span>
                            <span class="text-orange-700">
                              <span>N°</span>
                              <span class="letter-spacing-2 font-semibold">{{ $law->identifiant }}</span>
                            </span>

                          </h5>
                      </a>
                    </div>
                  </div>
                  <p class="px-6 text-xs text-gray-600 dark:text-gray-400"> Instaurée depuis, {{ $law->__getDateAsString($law->created_at) }}
                  </p>
                </div>
                <div class="flex flex-col px-6 mb-6 text-xs text-gray-400">
                  <div class="shadow-1 shadow-sky-400 rounded-lg border-gray-600 my-2 p-2">
                      <strong class="text-yellow-600 font-bold letter-spacing-2">description :</strong>
                      <p class="letter-spacing-1">
                          {{ $law->description }}
                      </p>
                  </div>
              </div>
                
                <div class="flex flex-wrap justify-between gap-y-2 pt-4 border-t dark:border-gray-700">
                  <div class="flex items-center px-6 space-x-1 text-gray-400">
                    <div class="flex items-center text-xs">
                        <div class="flex gap-x-2 mr-3 float-right justify-end  text-gray-700 dark:text-gray-400">
                            <div class="">
                                <span wire:click="editLaw({{$law->id}})" class="border cursor-pointer bg-green-300 text-green-700 hover:shadow-lg hover:shadow-sky-600 hover:bg-green-400 px-3 py-2 rounded ">
                                    <span class="fas fa-edit"></span>
                                    <span class="sm:hidden xs:hidden md:inline " wire:loading.remove wire:target='editLaw({{$law->id}})'>Editer</span>
                                    <span wire:loading wire:target='editLaw({{$law->id}})' class="fas fa-rotate animate-spin"></span>
                                </span>
                            </div>
                            <div class="">
                                <span wire:click="deleteLaw({{$law->id}})" class="border cursor-pointer bg-red-300 text-red-700 hover:shadow-lg hover:shadow-sky-600 hover:bg-red-400 px-3 py-2 rounded ">
                                    <span class="fas fa-trash"></span>
                                    <span class="sm:hidden xs:hidden md:inline " wire:loading.remove wire:target='deleteLaw({{$law->id}})'>Supprimer</span>
                                    <span wire:loading wire:target='deleteLaw({{$law->id}})' class="fas fa-rotate animate-spin"></span>
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
                    <span>Désolée aucune résultat trouvé avec 
                      <b class="text-red-600 underline">
                        {{ $search }}
                      </b>
                    </span>
                  </h5>
                </div>
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
                    <span>Aucune loi correspondante <span class="text-warning-600"> </span> trouvée...</span>
                    </h5>
                </div>
                
              @endif

            </div>
          </div>
        </section>
  </div>
  
