<div class="w-full px-4 sm:px-6 lg:px-8 lg:text-lg xl:text-lg md:text-sm sm:text-sm xs:text-xs mx-auto z-bg-secondary-light mt-10 rounded-xl shadow-4 shadow-sky-500">
    <section class="py-14 font-poppins">
        <div class="max-w-6xl px-4 py-6 mx-auto lg:py-4 md:px-6">
          <div class="w-full mx-auto">
            <div class="text-center ">
              <div class="relative flex flex-col ">
                <h1 class="text-xl font-bold dark:text-gray-200 text-left letter-spacing-1"> 
                    Listes complètes des Lycées et Centres de Formations du 
                    <span class="text-blue-500">BENIN</span>
                    <span class="text-orange-200 float-right text-right">
                        {{ numberZeroFormattor(count($lycees)) }}
                    </span> 
                </h1>
                <div class="flex w-full mt-2 mb-6 overflow-hidden rounded">
                  <div class="w-1/6 h-2 bg-blue-200"></div>
                  <div class="w-1/6 h-2 bg-blue-300"></div>
                  <div class="w-1/6 h-2 bg-blue-400"></div>
                  <div class="w-1/6 h-2 bg-blue-500"></div>
                  <div class="w-1/6 h-2 bg-blue-600"></div>
                  <div class="w-1/6 h-2 bg-blue-700"></div>
                </div>
              </div>
              <p class="mb-12 text-base text-center text-gray-300 letter-spacing-1 font-semibold">
                Parcourez ici la liste complète des lycées et centre de formations du BENIN!
              </p>
            </div>
          </div>

            <div class="border-t my-2 shadow-2 items-center shadow-sky-400 py-3 gap-x-2 flex justify-end px-2">
                @if(__isAdminAs())
                    @if($selected_lycee)
                        <button wire:click="deleteLycee" title="Supprimer le lycée | centre de formation {{ $selected_lycee->name }}" type="button" class="border cursor-pointer bg-red-500 text-red-100 rounded-md hover:bg-red-700 float-right px-2 py-2  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm  text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-blue-800">
                            <span wire:loading.remove wire:target='deleteLycee'>
                                <span>Supprimer</span>
                                <span class="fas fa-trash hover:animate-spin"></span>
                            </span>
                            <span wire:loading wire:target='deleteLycee'>
                                <span class="">
                                    Suppression en cours...
                                </span>
                                <span class="fas fa-rotate animate-spin"></span>
                            </span>

                            
                        </button>
                        <button wire:click="manageLyceeData" title="Editer les données de {{ $selected_lycee->name }}" type="button" class="border cursor-pointer bg-gray-500 text-gray-100 rounded-md hover:bg-gray-700 float-right px-2 py-2  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm  text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-blue-800">
                            <span>Editer les données</span>
                            <span class="fas fa-edit hover:animate-spin"></span>
                        </button>
                    @endif
                    
                    <button wire:click="addNewLycee" title="Ajouter un lycée ou un centre de formation" type="button" class="border cursor-pointer bg-green-500 text-gray-100 rounded-md hover:bg-green-700 float-right px-2 py-2  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm  text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-blue-800">
                        <span>Ajouter un lycée | centre de formation</span>
                        <span class="fas fa-plus hover:animate-spin"></span>
                    </button>
                @endif
            </div>

            <div>
                <div class="flex justify-between gap-x-3 w-full">
                    <div class="items-center justify-between px-0 border-sky-700 bg-transparent shadow-1 shadow-sky-4000 rounded-lg w-1/2 mx-0">
                        <div class="flex items-center justify-between mx-0 px-0">
                          <select wire:model.live='selected_department' name="selected_department" id="lycee-listing-by-year" class="block w-full px-3 border-none cursor-pointer border-sky-700 z-bg-secondary-light shadow-1 shadow-sky-400 py-4 rounded-lg text-sky-300 font-semibold letter-spacing-1">
                            <option class="py-4" value="">Trier par department</option>
                            @foreach ($departments as $department_value => $dpvl)
                              <option wire:key="par-lycee-departement-page-{{$department_value}}" class="py-4 px-3" value="{{$dpvl}}"> 
                                Les lycées et centre du département {{ $dpvl }} 
                              </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="items-center justify-between px-0 border-sky-700 bg-transparent shadow-1 shadow-sky-4000 rounded-lg w-1/2 mx-0">
                        <div class="flex items-center justify-between mx-0 px-0">
                          <select wire:model.live='selected_lycee_id' name="selected_lycee_id" id="epreuves-listing-by-year" class="block w-full px-3 border-none cursor-pointer border-sky-700 z-bg-secondary-light shadow-1 shadow-sky-400 py-4 rounded-lg text-sky-300 font-semibold letter-spacing-1">
                            <option class="py-4" value="{{null}}">Liste des lycées et centre de formations</option>
                            @foreach ($lycees as $lycee)
                              <option wire:key="liste-des-lycees-{{$lycee->id}}" class="py-4 px-3" value="{{$lycee->id}}"> 
                                {{ $lycee->name }} 
                              </option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                </div>


                <div class="w-full my-3">

                    <div class="w-full shadow-2 shadow-sky-400 rounded-lg my-3">

                        @if($selected_lycee_id)

                        <div class="letter-spacing-1 font-semibold p-2">
                            <h6 class="text-orange-300">
                                Profil du lycée ou centre de formation
                            </h6>
                            <h6 class="text-sky-500">
                                {{ $selected_lycee->name }}

                                @if($selected_lycee->is_public)
                                <span class="text-green-600 text-right">
                                    (PUBLIC)
                                </span>
                                @else
                                <span class="text-orange-400 text-right">
                                    (PRIVE)
                                </span>
                                @endif
                            </h6>

                            <div class="rounded-lg p-3 shadow-2 shadow-sky-400 my-5">

                                <h6>
                                    <span class="text-gray-400">
                                        Lycée :
                                    </span>
                                    <span class="text-orange-300">
                                        {{ $selected_lycee->name }}
                                    </span>
                                </h6>
                                <h6>
                                    <span class="text-gray-400">
                                        Department :
                                    </span>
                                    <span class="text-orange-300">
                                        {{ $selected_lycee->department }}
                                    </span>
                                </h6>
                                <h6>
                                    <span class="text-gray-400">
                                        Ville ou comunne :
                                    </span>
                                    <span class="text-orange-300">
                                        {{ $selected_lycee->city }}
                                    </span>
                                </h6>

                                <h6>
                                    <span class="text-gray-400">
                                        Proviseur actuel :
                                    </span>
                                    <span class="text-orange-300">
                                        {{ $selected_lycee->provisor }}
                                    </span>
                                </h6>

                                <h6>
                                    <span class="text-gray-400">
                                        Censeur actuel :
                                    </span>
                                    <span class="text-orange-300">
                                        {{ $selected_lycee->censeur }}
                                    </span>
                                </h6>

                                <h6>
                                    <span class="text-gray-400">
                                        Rand actuel sur le plan national :
                                    </span>
                                    <span class="text-orange-300">
                                        {{ $selected_lycee->rank }}
                                    </span>
                                </h6>

                                <div class="shadow-2 shadow-sky-300 p-2 mt-3">
                                    <h6 class="w-full border-b text-center text-yellow-400 border-sky-400 py-1 flex justify-between items-center">

                                        <span>Promotions disponibles</span>
                                       
                                        @if(__isAdminAs())
                                        <button wire:click="manageLyceePromotions()" title="Gérer les promotions" type="button" class="border cursor-pointer bg-green-500 text-gray-100 rounded-md hover:bg-green-700 float-right px-2 py-2  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm  text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-blue-800">
                                            <span>Gérer les promotions</span>
                                            <span class="fas fa-edit hover:animate-spin"></span>
                                        </button>
                                        @endif

                                    </h6>
                                    <div class="flex-wrap flex gap-x-3 my-2">
                                        @if(count($promotions) > 0)
                                            @foreach ($promotions as $promotion)
                                            <span class="shadow-2 p-2 px-3 shadow-sky-400 text-sky-500 rounded-lg">
                                                <span>
                                                    {{ $promotion->name }}
                                                </span>
                                            </span>
                                            @endforeach
                                        @else
                                            <span class="text-gray-400 letter-spacing-1 text-center my-3 inline-block w-full">Aucune promotion renseignée</span>
                                        @endif
                                    </div>

                                </div>

                                <div class="shadow-2 shadow-purple-300 p-2 mt-3">
                                    <h6 class="w-full border-b text-center text-yellow-400 border-purple-400 py-1 flex justify-between items-center">

                                        <span>Filières disponibles</span>

                                       
                                        @if(__isAdminAs())
                                        <button wire:click="manageLyceeFiliars()" title="Gérer les filières" type="button" class="border cursor-pointer bg-green-500 text-gray-100 rounded-md hover:bg-green-700 float-right px-2 py-2  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm  text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-blue-800">
                                            <span>Gérer les filières</span>
                                            <span class="fas fa-edit hover:animate-spin"></span>
                                        </button>
                                        @endif

                                    </h6>
                                    <div class="flex-wrap flex gap-x-3 my-2">
                                        @if(count($filiars) > 0)
                                            @foreach ($filiars as $filiar)
                                            <span class="shadow-2 p-2 px-3 shadow-purple-400 text-purple-500 rounded-lg">
                                                <span>
                                                    {{ $filiar->name }}
                                                </span>
                                            </span>
                                            @endforeach
                                        @else
                                            <span class="text-gray-400 letter-spacing-1 text-center my-3 inline-block w-full">Aucune filière renseignée</span>
                                        @endif
                                    </div>

                                </div>

                            </div>
                        </div>

                        @else

                        <h6 class="text-center letter-spacing-1 font-semibold text-yellow-300 p-2">
                            Veuillez Sélectionner un lycée ou un centre de formation pour voir ses détails et description
                        </h6>

                        @endif

                    </div>


                </div>

            </div>

            @if(!$selected_lycee_id)
            <div class="swiper LyceeSwiper w-full mx-auto p-3">
                <h3 class="my-4 font-semibold letter-spacing-1 py-3 text-gray-200 text-lg uppercase text-center border bg-gray-900" >Liste des lycées et centre de formation</h3>
                <div class="swiper-wrapper">
                <!-- Slide 1 -->
                @foreach ($lycees as $lc)
                    <div wire:key='defilement-lycee-{{$lc->id}}' class="swiper-slide z-bg-secondary-light p-6 rounded-2xl shadow-2 shadow-purple-400">
                        <div class="w-full rounded-lg my-3">

                            @php
                                $lc_flrs = $lc->getFiliars();

                                $lc_prms = $lc->getPromotions();
                            @endphp

                            <div class="letter-spacing-1 font-semibold p-2">
                                <h6 class="text-orange-300">
                                    Profil du lycée ou centre de formation
                                </h6>
                                <h6 class="text-sky-500">
                                    {{ $lc->name }}

                                    @if($lc->is_public)
                                    <span class="text-green-600 text-right">
                                        (PUBLIC)
                                    </span>
                                    @else
                                    <span class="text-orange-400 text-right">
                                        (PRIVE)
                                    </span>
                                    @endif
                                </h6>

                                <div class="rounded-lg p-3 shadow-2 shadow-sky-400 my-5">

                                    <h6>
                                        <span class="text-gray-400">
                                            Lycée :
                                        </span>
                                        <span class="text-orange-300">
                                            {{ $lc->name }}
                                        </span>
                                    </h6>
                                    <h6>
                                        <span class="text-gray-400">
                                            Department :
                                        </span>
                                        <span class="text-orange-300">
                                            {{ $lc->department }}
                                        </span>
                                    </h6>
                                    <h6>
                                        <span class="text-gray-400">
                                            Ville ou comunne :
                                        </span>
                                        <span class="text-orange-300">
                                            {{ $lc->city }}
                                        </span>
                                    </h6>

                                    <h6>
                                        <span class="text-gray-400">
                                            Proviseur actuel :
                                        </span>
                                        <span class="text-orange-300">
                                            {{ $lc->provisor }}
                                        </span>
                                    </h6>

                                    <h6>
                                        <span class="text-gray-400">
                                            Censeur actuel :
                                        </span>
                                        <span class="text-orange-300">
                                            {{ $lc->censeur }}
                                        </span>
                                    </h6>

                                    <h6>
                                        <span class="text-gray-400">
                                            Rand actuel sur le plan national :
                                        </span>
                                        <span class="text-orange-300">
                                            {{ $lc->rank }}
                                        </span>
                                    </h6>

                                    <div class="shadow-2 shadow-sky-300 p-2 mt-3">
                                        <h6 class="w-full border-b text-center text-yellow-400 border-sky-400 py-1 flex justify-between items-center">

                                            <span>Promotions disponibles</span>
                                        </h6>
                                        <div class="flex-wrap flex gap-x-3 my-2">
                                            @if(count($lc_prms) > 0)
                                                @foreach ($lc_prms as $pr)
                                                <span class="shadow-2 p-2 px-3 shadow-sky-400 text-sky-500 rounded-lg">
                                                    <span>
                                                        {{ $pr->name }}
                                                    </span>
                                                </span>
                                                @endforeach
                                            @else
                                                <span class="text-gray-400 letter-spacing-1 text-center my-3 inline-block w-full">Aucune promotion renseignée</span>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="shadow-2 shadow-purple-300 p-2 mt-3">
                                        <h6 class="w-full border-b text-center text-yellow-400 border-purple-400 py-1 flex justify-between items-center">

                                            <span>Filières disponibles</span>
                                        </h6>
                                        <div class="flex-wrap flex gap-x-3 my-2">
                                            @if(count($lc_flrs) > 0)
                                                @foreach ($lc_flrs as $fl)
                                                <span class="shadow-2 p-2 px-3 shadow-purple-400 text-purple-500 rounded-lg">
                                                    <span>
                                                        {{ $fl->name }}
                                                    </span>
                                                </span>
                                                @endforeach
                                            @else
                                                <span class="text-gray-400 letter-spacing-1 text-center my-3 inline-block w-full">Aucune filière renseignée</span>
                                            @endif
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
            @endif
          
            
        </div>
    </section>
</div>

