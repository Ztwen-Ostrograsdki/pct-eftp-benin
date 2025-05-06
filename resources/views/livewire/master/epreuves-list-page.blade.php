<div class="w-full  py-4 px-4 sm:px-6 lg:px-8 lg:text-lg xl:text-lg md:text-sm sm:text-sm xs:text-xs mx-auto z-bg-secondary-light mt-10 rounded-xl shadow-4 shadow-sky-500">
    <div class="py-2 mb-4 shadow-3 shadow-sky-700 border border-sky-900  rounded-xl w-full my-5">
        <div class="w-full px-2 font-semibold letter-spacing-2">
            <h4 class="py-3 xs:text-xs lg:text-base">
                <span class="text-sky-400 uppercase ml-2">
                    Liste complète des épreuves publiées  
                    <span class=" text-sky-400 float-right">
                       {{ numberZeroFormattor(count($epreuves)) }} 
                       <span class="lowercase">épreuves trouvées</span> 
                    </span>
                </span>
            </h4>
        </div>
    </div>
    <div class="w-full p-0 m-0">
        <div class="w-full m-0 p-0 mb-2 ">
            <div class="mb-4">
                <div class="items-center justify-between px-3 border-sky-700 bg-transparent shadow-1 shadow-sky-4000 rounded-lg">
                  <div class="flex items-center w-2/5 justify-between">
                    <select wire:model.live='authorized' name="authorized" id="" class="block w-full text-base px-3 border-none cursor-pointer border-sky-700 z-bg-secondary-light shadow-1 shadow-sky-400 py-3 rounded-lg text-sky-300 font-semibold letter-spacing-1">
                        <option class="py-4" value="{{'all'}}">Lister toutes les épreuves</option>
                        <option class="py-4 px-3" value="{{true}}"> {{ "Les épreuves déjà authorisées" }} </option>
                        <option class="py-4 px-3" value="{{false}}"> {{ "Les épreuves pas encore authorisées" }} </option>
                    </select>
                  </div>
                </div>
              </div>
        </div>
    </div>
    <section class="py-3 font-poppins bg-transparent rounded-lg">
      <div class="px-4 mx-auto lg:py-6 md:px-6">
        <div class="grid lg:grid-cols-4  mb-24 -mx-3">
          <div class="pr-2 sm:col-span-4 xs:col-span-4 lg:col-span-1 grid md:grid-cols-4 lg:grid-cols-4 xs:grid-cols-4 sm:grid-cols-4 lg:block xs:text-xs lg:text-base">
            <div class="p-4 mb-5 xs:col-span-2 sm:col-span-2 lg:col-span-1  border border-sky-700 bg-transparent shadow-1 shadow-sky-400">
              <h2 class="xs:text-sm lg:text-base font-bold dark:text-gray-400"> Par Promotion</h2>
              <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
              <ul>
                @foreach(getPromotions(true) as $p_id => $promo)
                <li class="mb-1 py-2 px-2 rounded-lg cursor-pointer hover:bg-gray-800">
                  <label for="promo{{$promo->id}}" class="flex items-center cursor-pointer dark:text-gray-400  has-[:checked]:shadow-2 has-[:checked]:shadow-sky-400 has-[:checked]:rounded-full has-[:checked]:px-2 has-[:checked]:py-1">
                    <input wire:model.change='selected_promotions' value="{{$promo->id}}" id="promo{{$promo->id}}" type="checkbox" class="w-4 h-4 mr-2 checked:rounded-full">
                    <span class="">{{ $promo->name }}</span>
                  </label>
                </li>
                @endforeach
              </ul>
            </div>
            <div class="p-4 mb-5 xs:col-span-2 sm:col-span-2 lg:col-span-1  border border-sky-700 bg-transparent shadow-1 shadow-sky-400">
              <h2 class="xs:text-sm lg:text-base font-bold dark:text-gray-400">Par Filières</h2>
              <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
              <ul>
                @foreach(getFiliars(true) as $f_id => $fil)
                <li class="mb-1 py-2 px-2 rounded-lg cursor-pointer hover:bg-gray-800">
                  <label for="filli{{$fil->id}}" class="flex items-center cursor-pointer dark:text-gray-300 has-[:checked]:shadow-2 has-[:checked]:shadow-sky-400 has-[:checked]:rounded-full has-[:checked]:px-2 has-[:checked]:py-1">
                    <input on wire:model.change='selected_filiars' value="{{$fil->id}}" id="filli{{$fil->id}}" type="checkbox" class="w-4 h-4 mr-2 checked:rounded-full">
                    <span class=" dark:text-gray-400">{{ $fil->name }}</span>
                  </label>
                </li>
                @endforeach
              </ul>
            </div>
            
          </div>
          <div class="w-full xs:col-span-4 sm:col-span-4 lg:col-span-3 lg:grid-cols-4">
            <div class="px-3 mb-4">
              <div class="items-center flex justify-between border-sky-700 bg-transparent shadow-1 shadow-sky-4000 rounded-lg gap-x-4">
                <div class="">
                  <select wire:model.live='selected_year' class="block w-full px-3 border-none cursor-pointer border-sky-700 z-bg-secondary-light shadow-1 shadow-sky-400 py-3 rounded-lg text-sky-300 font-semibold letter-spacing-1">
                    <option class="py-4" value="">Trier par Années</option>
                    @foreach (getYears() as $year_val => $year)
                      <option wire:key="par-annee-epreuves-page-admin-list-list-{{$year}}" class="py-4 px-3" value="{{$year}}"> 
                        Les épreuves de l'année {{ $year }} 
                        <span class="text-orange font-semibold letter-spacing-1 ml-3">
                          ({{ numberZeroFormattor(count(getYearEpreuves($year))) }})
                        </span>
                      </option>
                    @endforeach
                  </select>
                </div>

                <div class="">
                  <select wire:model.live='selected_lycee_id' class="w-full px-3 border-none cursor-pointer border-sky-700 z-bg-secondary-light shadow-1 shadow-sky-400 py-3 rounded-lg text-sky-300 font-semibold letter-spacing-1">
                    <option class="py-4" value="">Trier par Lycée ou Centre</option>
                    @foreach ($lycees as $lycee)
                      <option wire:key="par-lycee-epreuves-page-admin-list-list-{{$lycee->id}}" class="py-4 px-3" value="{{$lycee->id}}"> 
                        Les épreuves de {{ $lycee->name }} 
                        <span class="text-orange font-semibold letter-spacing-1 ml-3">
                          ({{ numberZeroFormattor(count(getLyceeEpreuves($lycee->id))) }})
                        </span>
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="w-full py-1 my-3 px-3">
              <form class="w-full mx-auto">   
                  <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Rechercher</label>
                  <div class="relative">
                      <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                          </svg>
                      </div>
                      <input wire:model.live="search" type="search" id="epreuve-search" class=" block w-full p-4 ps-10 text-sm letter-spacing-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 focus" placeholder="Rechercher des épreuves selon: une notion, un titre..." />
                      @if(!$search)
                      <span disabled class="text-white md:inline lg:inline absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 disabled xs:hidden sm:hidden">Rechercher</span>
                      @else
                      <span wire:click="resetSearch" class="text-white md:inline lg:inline absolute end-2.5 bottom-2.5 bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-blue-800 cursor-pointer xs:hidden sm:hidden">Effacer</span>
                      @endif
                  </div>
              </form>
            </div>
            @if(count($epreuves))
            <div class="grid xs:grid-cols-4 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-4 gap-2">
              
              @foreach($epreuves as $epreuve)
              <div wire:key="epreuve-admin-{{$epreuve->id}}" class="px-3 mb-6 xs:col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-2">
                <div class="border transition-opacity rounded-lg  @if($epreuve->authorized) shadow-gray-300 shadow-3 @else shadow-red-500 shadow-2 opacity-75 p-1 @endif border-gray-700">
                  <div class="p-3 pb-8">
                    <div class="flex m-0 p-0 justify-between">
                        <span>
                          @if(in_array(auth_user()->id, (array)$epreuve->downloaded_by))
                            <span title="Vous avez déjà télécharger ce fichier" class="text-green-500 fa fa-check-double cursor-pointer animate-pulse"></span>
                          @endif
                        </span>
                        <span class="gap-x-2 flex text-xs">

                              <span wire:loading.remove wire:target='deleteFile({{$epreuve->id}})' wire:click="deleteFile({{$epreuve->id}})"   title="Supprimer cette épreuve " class="text-red-500 p-2 rounded-full cursor-pointer bg-red-300 border-red-900 border animate-pulse hover:shadow-3 hover:shadow-sky-600">
                                <span class="fas fa-trash"></span> 
                                <span>Suppr.</span>
                            </span>
                            <span wire:loading wire:target='deleteFile({{$epreuve->id}})' class="text-gray-900 p-2 rounded-full cursor-pointer bg-green-400 border-gray-900 border animate-pulse hover:shadow-3 hover:shadow-sky-600">
                                <span class="fas fa-rotate animate-spin mr-2"></span> 
                                <span>Suppression en cours...</span>
                            </span>
                        
                            @if(!$epreuve->authorized)
                                <span wire:loading.remove wire:target='validateEpreuve({{$epreuve->id}})' wire:click="validateEpreuve({{$epreuve->id}})"   title="Valider cette épreuve et la rendre accessible par tous" class="text-gray-900 p-2 rounded-full cursor-pointer bg-green-400 border-gray-900 border animate-pulse hover:shadow-3 hover:shadow-sky-600">
                                    <span class="fas fa-check"></span> 
                                    <span>Valider</span>
                                </span>
                                <span wire:loading wire:target='validateEpreuve({{$epreuve->id}})' class="text-gray-900 p-2 rounded-full cursor-pointer bg-green-400 border-gray-900 border animate-pulse hover:shadow-3 hover:shadow-sky-600">
                                    <span class="fas fa-rotate animate-spin mr-2"></span> 
                                    <span>Validation en cours...</span>
                                </span>
                            @endif
                          <a target="_blank" href="{{url('storage', $epreuve->path)}}" title="Lire les éléments de réponses" class="text-gray-900 p-2 rounded-full cursor-pointer bg-sky-400 border-gray-900 border hover:shadow-3 hover:shadow-sky-600">
                            <span class="fas fa-pen"></span> 
                            <span>Rep</span>
                          </a>
                          <a target="_blank" href="{{url('storage', $epreuve->path)}}" title="Lire le fichier" class="text-gray-300 p-2 rounded-full cursor-pointer bg-gray-950 border-gray-400 border hover:shadow-3 hover:shadow-sky-600">
                            <span class="fas fa-eye"></span> 
                            <span>Lire</span>
                          </a>
                          <span title="Ce fichier a été téléchargé {{$epreuve->downloaded}} fois" class="text-orange-300 p-2 rounded-full animate-pulse cursor-pointer bg-gray-900 border-gray-400 border hover:shadow-3 hover:shadow-sky-600">
                            {{ $epreuve->downloaded }}
                            <span class="fas fa-download"></span> 
                          </span>
                        </span>
                    </div>
                    <div class=" items-center justify-between mt-2 gap-2 mb-2">
                      <div class="flex items-center">
                        <img class="hidden" width="50" src="{{asset('images/icons/dark-file.png') }}" alt="">
                        <span class="text-gray-400 letter-spacing-2 mr-3">
                          Fichier
                        </span> 
                        <span style="font-size: 2rem;" class="{{$epreuve->getExtensionIcon()}}"></span>
                        <h5 class="text-base gap-3 w-full float-right text-right justify-between font-medium text-gray-400">
                          <span>{{$epreuve->name}}</span>
                        </h5>
                      </div>
                      
                      <div class="w-full">
                        <span class="text-gray-300">
                          <strong>Filières :</strong> 
                          @foreach ($epreuve->getFiliars() as $f)
                            <small class="mx-2">{{ $f->name }}</small> 
                          @endforeach
                        </span>
                      </div>
                      <div class="w-full">
                        <span class="text-cyan-300">
                          <strong>Promotion :</strong> 
                          {{ $epreuve->getPromotion() }}
                        </span>
                      </div>
                      <div class="w-full">
                        <span class="text-yellow-300">
                          <strong>Contenus :</strong> 
                          {{ $epreuve->contents_titles }}
                        </span>
                      </div>
                    </div>
                    <p class=" w-full">
                      <span class="text-green-600 text-base dark:text-green-600">
                        Taille : {{ $epreuve->file_size ? $epreuve->file_size : 'inconnue' }}
                      </span>
                      <span class="text-xs ml-3 text-sky-600">
                        ({{$epreuve->getTotalPages()}} Pages)
                      </span>
                      @if($epreuve->lycee_id)
                      <br>
                      <small class="text-gray-600 text-right text-sm">Lycée ou Centre :  
                         {{$epreuve->getLycee() ? $epreuve->getLycee()->name : 'Inconnu'}}
                      </small>
                      @endif
                      <br>
                      <small class="text-gray-400 text-right text-sm">Publié le 
                         {{$epreuve->__getDateAsString($epreuve->created_at)}}
                      </small>
                      <br>
                      <small class="text-sky-400 pt-2 opacity-60 text-right float-right text-sm">Par 
                         {{$epreuve->user->getFullName()}}
                      </small>
                    </p>
                  </div>
                  <div class="m-0 p-0 justify-center w-full mt-2">
                    <span class="text-center w-full bg-blue-600 text-gray-950 hover:bg-blue-800 cursor-pointer py-2 px-3 inline-block"  wire:loading.class='bg-green-400' wire:click='downloadTheFile({{$epreuve->id}})' wire:target='downloadTheFile({{$epreuve->id}})' >
                      <span wire:loading wire:target='downloadTheFile({{$epreuve->id}})'>
                          <span class="fa animate-spin fa-rotate float-end mt-2"></span>
                          <span class="mx-2">téléchargement en cours... </span>
                      </span>
                      <span wire:loading.remove wire:target='downloadTheFile({{$epreuve->id}})'>
                          <span>Telecharger</span>
                          <span class="fa fa-download mx-2"></span>
                      </span>
                    </span>
                  </div>
                </div>
              </div>
              @endforeach
            </div>
            @else
              <div class="mx-auto w-full p-4 mt-5">
                <h2 class="text-red-700 bg-red-300 border-red-600 mt-6 letter-spacing-2 lg:text-xl xs:text-xs sm:text-sm md:text-sm py-3 px-2 rounded-2xl text-center">
                  Oupppps!!! Aucune épreuve n'a été trouvée
                </h2>
                @if($selected_promotions || $selected_lycee_id || $selected_filiars || strlen($search) >= 3)
                <h5 class="w-full my-6 mx-auto flex justify-center">
                  <span wire:click="clearAll" class="text-white inline-block rounded-full bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium text-sm p-5 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-blue-800 cursor-pointer border">
                    <span class="fa fa-trash mr-5"></span>
                      <span>Réinitialiser les filtres</span>
                    </span>
                  </h5>
                  @endif
              </div>
            @endif
            <!-- pagination start -->
            <div class="flex justify-end mt-6">
                {{$epreuves->links()}} 
            </div>
            <!-- pagination end -->
          </div>
        </div>
      </div>
    </section>
  
  </div>
