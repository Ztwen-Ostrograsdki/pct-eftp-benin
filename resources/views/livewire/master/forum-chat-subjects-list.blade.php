<div>
    <div class="mx-auto shadow-3 shadow-sky-600 rounded-lg  my-3 lg:w-4/6 xl:w-4/6 2xl:w-4/6 w-11/12 p-2 m-2 z-bg-secondary-light">
      <h1 class="p-4 text-gray-300 flex items-center justify-between uppercase text-center">
          <span class="text-xs letter-spacing-2">
              <strong class="text-sky-400">
                  Gestion des sujets de discussion sur le forum 
                
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
                      
                  </div>
                  <h4 class="font-bold dark:text-gray-200"> 
                      Les <span class="text-blue-500"> sujets de discussion</span> 
                      <span class="text-blue-300 ml-3 text-base lowercase @if($search  && strlen($search) >= 3) hidden @endif ">
                        <span class="fas fa-quote-left"></span>
                            {{ $sections[$forum_chat_subject_section] }}
                        <span class="fas fa-quote-right"></span>
                      </span>
                      <span class="text-gray-400 float-right  "> {{ numberZeroFormattor(count($all_subjects), true) }} </span>
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
                  <input wire:keydown.enter='searcher' wire:model.live="search" type="search" id="epreuve-search" class=" block w-full p-2.5 ps-10 text-sm letter-spacing-2 border  bg-transparent rounded-lg focus:ring-blue-500 focus:border-blue-500  dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500 focus text-sky-200" placeholder="Filtrer les sujets par : un mot clé, un titre, un objet..." />
                </div>
              </div>

              <div class="py-3 w-full bg-transparent shadow ">
                <div class="w-full flex justify-start">
                  <form @submit.prevent class="w-3/5 flex justify-start">
                    <select  class="z-bg-secondary-light  font-semibold letter-spacing-1 rounded-lg shadow-1 shadow-sky-400 text-sky-300 py-3 w-full px-2" wire:model.live='forum_chat_subject_section' id="forum_chat_subject_section">
                      @foreach ($sections as $key => $sec)
                        <option class="border-none" wire:key="subject-option-{{$sec}}-{{auth()->user()->id}}" class="z-bg-secondary-light font-semibold letter-spacing-1 my-2" value="{{$key}}">{{ $sec }}</option>
                      @endforeach
                    </select>
                  </form>
                </div>
              </div>
              
              @if(count($subjects))
              
              @foreach ($subjects as $key => $subject)
              <div wire:key="forum-chat-subject-{{$subject->id}}-{{auth()->user()->id}}" class="py-6 rounded-xl z-bg-secondary-light shadow-2 shadow-sky-500 mb-2">
                <div class="flex flex-wrap items-center justify-between pb-4 mb-2 space-x-2 border-b dark:border-gray-700">
                  <div class="flex items-center px-6 mb-2 md:mb-0 ">
                    <div class="flex mr-2 rounded-full">
                     
                      <a title="Charger le profil de {{ $subject->user->getFullName() }}" href="{{ route('user.profil', ['identifiant' => $subject->user->identifiant]) }}">
                          
                          @if($subject->user->profil_photo)
                              <img src="{{ url('storage', $subject->user->profil_photo) }}" alt="" class="object-cover w-12 h-12 rounded-full shadow-1 shadow-sky-400">
                          @else
                              <div class="border rounded-full border-gray-600 w-10 h-10 flex justify-center">
                                  <span class="fa fa-user text-lg mt-1" ></span>
                              </div>
                          @endif
                      </a>
                  </div>
                    <div>
                      <h6 class="text-green-400 text-sm letter-spacing-1 font-semibold">Publié par:  </h6>
                      <a class="text-xs letter-spacing-1" title="Charger le profil de {{ $subject->user->getFullName() }}" href="{{ route('user.profil', ['identifiant' => $subject->user->identifiant]) }}">
                          <h5 class="font-semibold text-sky-400">
                              {{ $subject->user->getFullName() }}
                          </h5>
                          <p class="text-xs text-gray-500 dark:text-gray-400">
                              {{ $subject->user->member->getMemberRoleName() }}
                          </p>
                      </a>
                    </div>
                  </div>
                  <div class="flex justify-end flex-col px-4">
                    <p class="text-xs text-gray-600 dark:text-gray-400 hidden"> Inscrit depuis, {{ $subject->user->__getDateAsString($subject->user->created_at) }}
                    </p>
                    <span class="text-xs font-semibold letter-spacing-1 text-gray-600 dark:text-yellow-600 ">Sujet N° 00{{ $subject->id }}</span>
                  </div>
                </div>
                <div class="flex flex-col px-6 mb-6 text-xs text-gray-400">
                  <strong class="text-yellow-600 font-bold letter-spacing-2">Contenu du sujet de discussion:</strong>
                  <div class="shadow-1 shadow-sky-400 rounded-lg border-gray-600 my-2 p-2">
                      <p class="letter-spacing-1">
                          {{ $subject->subject }}
                      </p>
                  </div>
              </div>
                
                <div class="flex flex-wrap justify-between gap-y-2 pt-4 border-t dark:border-gray-700">
                  <div class="flex px-6 mb-2 md:mb-0 text-xs letter-spacing-1">
                    <h6 class=" text-gray-400">
                      <span class="fas fa-clock text-blue-500"></span>
                      Envoyé le : 
                      <span class="font-semibold text-gray-600 dark:text-gray-300"> 
                          {{ $subject->__getDateAsString($subject->created_at, 3, true) }} 
                      </span> 
                    </h6>
                  </div>
                  <div class="flex items-center px-6 space-x-1 text-gray-400">
                    <div class="flex items-center text-xs">
                        <div class="flex gap-x-2 mr-3 float-right justify-end  text-gray-700 dark:text-gray-400">
                            <div class="">
                                <span wire:click="validateSubject({{$subject->id}})" class="border cursor-pointer bg-green-300 text-green-700 hover:shadow-lg hover:shadow-sky-600 hover:bg-green-400 px-3 py-2 rounded ">
                                    <span class="fas fa-check"></span>
                                    <span class="sm:hidden xs:hidden md:inline " wire:loading.remove wire:target='validateSubject({{$subject->id}})'>Valider</span>
                                    <span wire:loading wire:target='validateSubject({{$subject->id}})' class="fas fa-rotate animate-spin"></span>
                                </span>
                            </div>
                            <div class="">
                                <span wire:click="deleteSubject({{$subject->id}})" class="border cursor-pointer bg-red-300 text-red-700 hover:shadow-lg hover:shadow-sky-600 hover:bg-red-400 px-3 py-2 rounded ">
                                    <span class="fas fa-trash"></span>
                                    <span class="sm:hidden xs:hidden md:inline " wire:loading.remove wire:target='deleteSubject({{$subject->id}})'>Supprimer</span>
                                    <span wire:loading wire:target='deleteSubject({{$subject->id}})' class="fas fa-rotate animate-spin"></span>
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
                    <span>Aucun sujet de discussion <span class="text-warning-600"> {{ $sections[$forum_chat_subject_section] }} </span> en cours...</span>
                    </h5>
                </div>
                
              @endif

            <div class="flex justify-end mt-6">
                 
            </div>
              
            </div>
          </div>
        </section>
  </div>
  