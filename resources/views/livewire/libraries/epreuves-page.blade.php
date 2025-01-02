<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="py-2 bg-gray-400 border rounded-lg w-full my-2">
        <div class="w-full px-2">
            <h4 class="py-3 xs:text-xs lg:text-base">
                <span class="text-gray-700">
                    Vous êtes
                </span>
                <span class="text-gray-800">
                    à la
                </span>
                <span class="text-gray-900 uppercase ml-2">
                    Banque des épreuves  <span class="float-right text-gray-800"> {{ numberZeroFormattor(count($epreuves)) }} <span class="lowercase">épreuves disponibles</span> </span>
                </span>
            </h4>
        </div>
    </div>
    <div class="w-full p-0 m-0">
        <div class="w-full m-0 p-0 mb-2 ">
            <a class="bg-blue-600 text-gray-300 border border-white rounded-lg px-2 py-3 text-lg w-full inline-block" href="{{route('library.epreuves.uplaoder')}}">
                <span class="fa fa-send"></span>
                <span>Envoyer des épreuves</span>
                <span class="fa fa-book"></span>
            </a>
        </div>
    </div>
    <section class="py-3 bg-gray-50 font-poppins dark:bg-gray-800 rounded-lg">
      <div class="px-4 mx-auto max-w-7xl lg:py-6 md:px-6">
        
        <div class="grid lg:grid-cols-4  mb-24 -mx-3">
          <div class="pr-2 sm:col-span-4 lg:col-span-1 grid md:grid-cols-4 lg:grid-cols-4 xs:grid-cols-4 sm:grid-cols-4 lg:block xs:text-xs lg:text-base">
            <div class="p-4 mb-5 xs:col-span-2 sm:col-span-2 lg:col-span-1 bg-white border border-gray-200 dark:border-gray-900 dark:bg-gray-900">
              <h2 class="xs:text-sm lg:text-base font-bold dark:text-gray-400"> Par Promotion</h2>
              <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
              <ul>
                @foreach(getPromotions(true) as $p_id => $promo)
                <li class="mb-1 py-2 px-2 rounded-lg cursor-pointer hover:bg-gray-800">
                  <label for="promo{{$promo->id}}" class="flex items-center cursor-pointer dark:text-gray-400 ">
                    <input wire:model.change='selected_promotions' value="{{$promo->id}}" id="promo{{$promo->id}}" type="checkbox" class="w-4 h-4 mr-2">
                    <span class="">{{ $promo->name }}</span>
                  </label>
                </li>
                @endforeach
              </ul>
            </div>
            <div class="p-4 mb-5 xs:col-span-2 sm:col-span-2 lg:col-span-1 bg-white border border-gray-200 dark:bg-gray-900 dark:border-gray-900">
              <h2 class="xs:text-sm lg:text-base font-bold dark:text-gray-400">Par Filières</h2>
              <div class="w-16 pb-2 mb-6 border-b border-rose-600 dark:border-gray-400"></div>
              <ul>
                @foreach(getFiliars(true) as $f_id => $fil)
                <li class="mb-1 py-2 px-2 rounded-lg cursor-pointer hover:bg-gray-800">
                  <label for="filli{{$fil->id}}" class="flex items-center cursor-pointer dark:text-gray-300">
                    <input on wire:model.change='selected_filiars' value="{{$fil->id}}" id="filli{{$fil->id}}" type="checkbox" class="w-4 h-4 mr-2">
                    <span class=" dark:text-gray-400">{{ $fil->name }}</span>
                  </label>
                </li>
                @endforeach
              </ul>
            </div>
            
          </div>
          <div class="w-full xs:col-span-4 sm:col-span-4 lg:col-span-3 lg:grid-cols-4">
            <div class="px-3 mb-4">
              <div class="items-center justify-between hidden px-3 py-2 bg-gray-100 sm:flex dark:bg-gray-900 rounded-lg shadow-2">
                <div class="flex items-center w-2/5 justify-between py-2">
                  <select name="" id="" class="block w-full text-base px-3 bg-gray-100 border-none cursor-pointer dark:text-gray-400 dark:bg-gray-900">
                    <option class="py-4" value="">Trier par classe</option>
                    @foreach (getClasses(true) as $c_id => $cl)
                      <option class="py-4 px-3" value="{{$cl->id}}"> {{ $cl->name }} </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            @if(count($epreuves))
            <div class="grid xs:grid-cols-4 sm:grid-cols-4 md:grid-cols-4 lg:grid-cols-4 gap-2">
              
              @foreach($epreuves as $epreuve)
              <div class="px-3 mb-6 xs:col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-2">
                <div class="border transition-opacity rounded-lg shadow-3 shadow-gray-300 border-gray-700">
                  <div class="p-3 pb-8">
                    <div class="flex m-0 p-0 justify-between">
                        <span>
                          @if(in_array(auth_user()->id, (array)$epreuve->downloaded_by))
                            <span title="Vous avez déjà télécharger ce fichier" class="text-green-500 fa fa-check-double cursor-pointer animate-pulse"></span>
                          @endif
                        </span>
                        <span class="gap-x-2 flex">
                          <a target="_blank" href="{{url('storage', $epreuve->path)}}" title="Lire les éléments de réponses" class="text-gray-900 p-2 rounded-full cursor-pointer bg-green-400 border-gray-900 border">
                            <span class="fas fa-pen"></span> 
                            <span>Rep</span>
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
                        <img width="50" src="{{asset('images/icons/dark-file.png') }}" alt="">
                        <h5 class="text-base gap-3 w-full float-right text-right justify-between font-medium text-gray-400">
                          <span>{{$epreuve->name}}</span>
                          <strong class="text-blue-600 ml-3 float-right">(fichier {{$epreuve->extension}})</strong>
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
                      <br>
                      <small class="text-gray-400 text-right text-sm">Publié le 
                         {{$epreuve->__getDateAsString($epreuve->created_at)}}
                      </small>
                      <br>
                      <small class="text-orange-400 pt-2 opacity-60 text-right float-right text-sm">Par 
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
                <h2 class="text-red-700 bg-red-300 border-red-600 mt-6 letter-spacing-2 text-2xl py-3 px-2 rounded-2xl text-center">
                  Oupppps!!! Aucune épreuve n'a été trouvée
                </h2>
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
