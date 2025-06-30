<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 lg:text-lg xl:text-lg md:text-sm sm:text-sm xs:text-xs mx-auto z-bg-secondary-light mt-10 rounded-xl shadow-4 shadow-sky-500 ">
      <div class="py-2 mb-4 shadow-3 shadow-sky-700 border border-sky-900  rounded-xl w-full my-5">
        <div class="w-full px-2 font-semibold letter-spacing-2">
            <h4 class="py-3 xs:text-xs lg:text-base">
                <span class="text-sky-400 uppercase ml-2">
                    Banque des épreuves  
                    <span class=" text-sky-400 float-right">
                      {{ numberZeroFormattor(count($epreuves)) }} 
                      <span class="lowercase">épreuves trouvées</span> 
                    </span>
                </span>
            </h4>
        </div>
    </div>
    <div class="w-full m-0 p-0 my-4 lg:text-lg xl:text-lg sm:text-xs md:text-xs xs:text-xs">
      <a class="bg-sky-600 text-gray-300 border border-sky-100 shadow-sky-800 rounded-lg px-2 py-3 w-full inline-block hover:bg-sky-700 hover:text-gray-950 shadow-2" href="{{route('library.epreuves.uplaoder', ['type' => 'examen'])}}">
          <span class="fa fa-send"></span>
          <span>Publier des épreuves d'examen</span>
          <span class="fa fa-share"></span>
      </a>
    </div>
    @if(__hasFiles('Epreuve', true))
    
    <div class="w-full p-0 m-0 flex gap-x-2 justify-between ">
      <div class="items-center justify-between px-0 border-sky-700 bg-transparent shadow-1 shadow-sky-4000 rounded-lg w-1/2 mx-0 card-reveal">
        <div class="flex items-center justify-between mx-0 px-0">
          <select wire:model.live='is_normal_exams' name="is_normal_exams" id="epreuves-listing-by-year" class="block w-full px-3 border-none cursor-pointer border-sky-700 z-bg-secondary-light shadow-1 shadow-sky-400 py-4 rounded-lg text-sky-300 font-semibold letter-spacing-1">
            <option class="py-4" value="twice">Tous les examens</option>
              <option class="py-4 px-3" value="{{true}}"> 
                Les examens session normale 
              </option>
              <option class="py-4 px-3" value="{{false}}"> 
                Les examens blancs
              </option>
          </select>
        </div>
      </div>
      @if($is_normal_exams == false || $is_normal_exams == 'twice')
      <div class="items-center justify-between px-0 border-sky-700 bg-transparent shadow-1 shadow-sky-4000 rounded-lg w-1/2 mx-0 card-reveal">
        <div class="flex items-center justify-between mx-0 px-0">
          <select wire:model.live='selected_department' name="selected_department" id="epreuves-listing-by-year" class="block w-full px-3 border-none cursor-pointer border-sky-700 z-bg-secondary-light shadow-1 shadow-sky-400 py-4 rounded-lg text-sky-300 font-semibold letter-spacing-1">
            <option class="py-4" value="">Trier par department</option>
            @foreach ($departments as $department_value => $dpvl)
              <option wire:key="par-type-epreuves-departement-f-page-{{$department_value}}" class="py-4 px-3" value="{{$dpvl}}"> 
                Les examens blancs du département {{ $dpvl }} 
                <span class="text-orange font-semibold letter-spacing-1 ml-3">
                  
                </span>
              </option>
            @endforeach
          </select>
        </div>
      </div>
      @endif
    </div>
    <section class="py-3 bg-gray-50 font-poppins bg-transparent rounded-lg mx-0">
      <div class=" mx-auto max-w-7xl lg:py-6">
        <div class="flex px-0 gap-x-3 justify-between mx-0">
          
            <div class="items-center justify-between px-0 border-sky-700 bg-transparent shadow-1 shadow-sky-4000 rounded-lg w-1/3 mx-0 card-reveal">
                <div class="flex items-center justify-between mx-0 px-0">
                  <select wire:model.live='selected_type' name="selected_type" id="epreuves-listing-by-year" class="block w-full px-3 border-none cursor-pointer border-sky-700 z-bg-secondary-light shadow-1 shadow-sky-400 py-4 rounded-lg text-sky-300 font-semibold letter-spacing-1">
                    <option class="py-4" value="">Trier par type</option>
                    @foreach ($types as $type_value => $type)
                      <option wire:key="par-type-epreuves-examens-page-{{$type}}" class="py-4 px-3" value="{{$type}}"> 
                        Les examens de {{ $type }} 
                        <span class="text-orange font-semibold letter-spacing-1 ml-3">
                          
                        </span>
                      </option>
                    @endforeach
                  </select>
                </div>
            </div>
            <div class="items-center justify-between px-0 mx-0 border-sky-700 bg-transparent shadow-1 shadow-sky-4000 rounded-lg w-1/3 card-reveal">
                <div class="flex items-center justify-between ">
                  <select wire:model.live='selected_year' name="selected_year" id="epreuves-listing-by-year" class="block w-full px-3 border-none cursor-pointer border-sky-700 z-bg-secondary-light shadow-1 shadow-sky-400 py-4 rounded-lg text-sky-300 font-semibold letter-spacing-1">
                    <option class="py-4" value="">Trier par Année</option>
                    @foreach (getYears() as $year_val => $year)
                      <option wire:key="par-annee-epreuves-examens-page-list-list-{{$year}}" class="py-4 px-3" value="{{$year}}"> 
                        Les épreuves de l'année {{ $year }} 
                        <span class="text-orange font-semibold letter-spacing-1 ml-3">
                          ({{ numberZeroFormattor(count(getYearEpreuves($year, true))) }})
                        </span>
                      </option>
                    @endforeach
                  </select>
                </div>
            </div>
            @if($is_normal_exams == false || $is_normal_exams == 'twice')
            <div class="items-center justify-between px-0 mx-0 border-sky-700 bg-transparent shadow-1 shadow-sky-4000 rounded-lg w-1/3 card-reveal">
                <div class="flex items-center justify-between ">
                  <select wire:model.live='selected_lycee_id' class="w-full px-3 border-none cursor-pointer border-sky-700 z-bg-secondary-light shadow-1 shadow-sky-400 py-4 rounded-lg text-sky-300 font-semibold letter-spacing-1">
                    <option class="py-4" value="">Trier par Lycée ou Centre</option>
                    @foreach ($lycees as $lycee)
                      <option wire:key="lister-par-lycee-epreuves-page-admin-list-list-{{$lycee->id}}" class="py-4 px-3" value="{{$lycee->id}}"> 
                        Les épreuves de {{ $lycee->name }} 
                        <span class="text-orange font-semibold letter-spacing-1 ml-3">
                          ({{ numberZeroFormattor(count(getLyceeEpreuves($lycee->id))) }})
                        </span>
                      </option>
                    @endforeach
                  </select>
                </div>
            </div>
            @endif
        </div>
        <div class="grid lg:grid-cols-4  mb-24 -mx-3">
          <div class="w-full col-span-4 ">
            <div class="w-full py-1 my-3 px-3 card-reveal">
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
                      <span class="text-white md:inline lg:inline absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 xs:hidden sm:hidden">Rechercher</span>
                      @else
                      <span wire:click="resetSearch" class="text-white md:inline lg:inline absolute end-2.5 bottom-2.5 bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-blue-800 cursor-pointer xs:hidden sm:hidden">Effacer</span>
                      @endif
                  </div>
              </form>
            </div>
            @if(count($epreuves))
            <div class="grid grid-cols-6 gap-2">
              
              @foreach($epreuves as $epreuve)
              <div wire:key="epreuves-examens-page-{{$epreuve->id}}" class="px-3 mb-6 xs:col-span-6 sm:col-span-6 md:col-span-3 lg:col-span-2 epreuve-card text-xs font-semibold letter-spacing-1">
                <div class="border transition-opacity rounded-lg shadow-3 shadow-gray-300 border-gray-700">
                  <div class="p-3 pb-8">
                    <div class="flex m-0 p-0 justify-between">
                        <span>
                          @if(in_array(auth_user()->id, (array)$epreuve->downloaded_by))
                            <span title="Vous avez déjà télécharger ce fichier" class="text-green-500 fa fa-check-double cursor-pointer animate-pulse"></span>
                          @endif
                        </span>
                        <span class="gap-x-2 flex">
                          <a href="{{route("library.epreuve.profil", ['uuid' => $epreuve->uuid])}}" title="Lire ou proposer des éléments de réponses à cette épreuve" class="text-gray-900 p-2 rounded-full cursor-pointer bg-green-400 border-gray-900 border">
                            <span>Rep
                              @if($epreuve->answers)
                                <span> ({{ count($epreuve->answers) }}) </span>
                              @endif
                            </span>
                          </a>
                          <a target="_blank" href="{{url('storage', $epreuve->path)}}" title="Lire le fichier" class="text-gray-300 p-2 rounded-full cursor-pointer bg-gray-950 border-gray-400 border">
                            <span class="fas fa-eye"></span> 
                            <span>Lire</span>
                          </a>
                          <span title="Ce fichier a été téléchargé {{$epreuve->downloaded}} fois" class="text-orange-300 p-2 rounded-full animate-pulse cursor-pointer bg-gray-900 border-gray-400 border">
                            {{ $epreuve->downloaded }}
                            <span class="fas fa-download"></span> 
                          </span>
                        </span>
                    </div>
                    <div class=" items-center justify-between gap-2 mb-2">
                      <div class="flex items-center">
                        <img class="hidden" width="50" src="{{asset('images/icons/dark-file.png') }}" alt="">
                        <span class="text-gray-400 letter-spacing-2 mr-3">
                          Fichier
                        </span> 
                        <span style="font-size: 2rem;" class="{{$epreuve->getExtensionIcon()}}"></span>
                        <h5 class="gap-3 w-full float-right text-right justify-between font-medium text-gray-400">
                          <span>{{$epreuve->name}}</span>
                          @if($epreuve->is_normal_exam)
                            <span class="ml-2 text-green-500 letter-spacing-1">(Session normal)</span>
                          @else
                            <span class="ml-2 text-green-200 letter-spacing-1">(Examen blanc)</span>
                          @endif
                          <span></span>
                        </h5>
                      </div>
                      
                      <div class="w-full">
                        <span class="text-gray-300">
                          <strong>Filières :</strong> 
                          @foreach ($epreuve->getFiliars() as $f)
                            <small wire:key="epreuve-filiars-list-{{$f->id}}" class="mx-2">{{ $f->name }}</small> 
                          @endforeach
                        </span>
                      </div>
                      <div class="w-full hidden">
                        <span class="text-cyan-300">
                          <strong>Promotion :</strong> 
                          {{ $epreuve->getPromotion() }}
                        </span>
                      </div>
                      @if(!$epreuve->is_normal_exam)
                      <div class="w-full ">
                        <span class="text-cyan-300">
                          <strong>Département :</strong> 
                          {{ $epreuve->exam_department }}
                        </span>
                      </div>
                      @endif
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
                      <br>
                      <small class="text-gray-400 text-right text-sm">Publié le 
                         {{$epreuve->__getDateAsString($epreuve->created_at)}}
                      </small>
                      <br>
                      @if(auth_user()->isAdminsOrMaster() || auth_user()->hasRole('epreuves-manager'))
                      <small class="text-sky-200 pt-2 opacity-60 text-right float-right text-xs">Par 
                         {{$epreuve->user->getFullName()}}
                      </small>
                      @endif
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
                @if($selected_promotions || $selected_year || $selected_filiars || strlen($search) >= 3)
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

    @else
    <div class="mx-auto w-full p-4 mt-5">
      <h2 class="text-red-700 bg-red-300 border-red-600 mt-6 letter-spacing-2 lg:text-xl xs:text-xs sm:text-sm md:text-sm py-3 px-2 rounded-2xl text-center">
        Oupppps!!! Aucune épreuve d'examen n'est disponible pour le moment!
      </h2>
    </div>
    @endif
  
  </div>
