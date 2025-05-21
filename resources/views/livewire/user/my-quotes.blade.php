<div class="p-6 max-w-6xl mx-auto z-bg-secondary-light-opac shadow-2 shadow-sky-500">
    <div class="mb-6">
        <div class="flex items-center justify-between gap-x-2 mb-6">
            <h2 class="lg:text-lg md:text-lg sm:text-sm  font-semibold letter-spacing-1 uppercase text-sky-500">
                <span>Mes citations</span>
                <span class="ml-5 text-yellow-500 text-sm">
                   ({{ numberZeroFormattor(count($quotes)) }} enregistrées)
                </span>
            </h2>
            <div class="flex justify-end gap-x-2">
                <div class="flex items-center">
                    <button wire:target='manageQuote'
                        wire:click="manageQuote"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-800 hover:text-gray-800 transition"
                    >
                        <span wire:loading.remove wire:target='manageQuote'>
                            Ajouter une citation
                        </span>
                        <span wire:target='manageQuote' wire:loading>
                            <span>Chargement en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                </div>
                
            </div>
        </div>
        <div class="flex items-center w-full justify-center">
              <h6 class="w-full items-center flex justify-center gap-x-9 py-3 font-semibold letter-spacing-1 text-yellow-400">
                <span>
                    <span class="text-gray-300">Membre : </span>
                    <span>{{ $member->user->getFullName() }}</span>
                </span>
              </h6>
            </div>
        <hr class="border-sky-600 mb-2">

        <div class="w-full flex justify-between items-center">
            
        <div class="px-3 mb-4 w-8/12">
            <div class="items-center flex float-end border-sky-700 bg-transparent shadow-1 shadow-sky-4000 rounded-lg gap-x-4">

            </div>
        </div>
        
    </div>

    <div class="">

        @if (count($quotes) > 0)

            <div class="w-full p-3 mx-auto flex flex-col gap-y-3">
                @foreach ($quotes as $quote)
                    <div wire:key="citation-{{$member->id}}-{{$quote->id}}" class="border p-3 z-bg-secondary-light rounded-lg library-widget-card">
                        <div class="flex w-full justify-between">
                            <h6 class="uppercase letter-spacing-1 text-sky-400 py-2">Citation {{ $loop->iteration }}</h6>
                            <div class="flex items-center justify-between gap-x-2">
                                <button wire:target='manageQuote({{$quote->id}})' wire:click="manageQuote({{$quote->id}})" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                                    <span wire:loading.remove wire:target='manageQuote({{$quote->id}})'>
                                        Modifier la citation
                                    </span>
                                    <span wire:target='manageQuote({{$quote->id}})' wire:loading>
                                        <span>Chargement en cours...</span>
                                        <span class="fas fa-rotate animate-spin"></span>
                                    </span>
                                </button>

                                <button wire:target='deleteQuote({{$quote->id}})'  wire:click="deleteQuote({{$quote->id}})" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-800 hover:text-gray-100 transition">
                                    <span wire:loading.remove wire:target='deleteQuote({{$quote->id}})'>
                                        Supprimer
                                    </span>
                                    <span wire:target='deleteQuote({{$quote->id}})' wire:loading>
                                        <span>Suppression en cours...</span>
                                        <span class="fas fa-rotate animate-spin"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        <hr class="border border-sky-600 my-2">

                        <h6 class="text-gray-400 font-semibold letter-spacing-1 my-2">
                            <blockquote>
                                {{ $quote->content }}
                            </blockquote>
                            <span class="text-right mt-3 block text-sm text-sky-400 letter-spacing-1 font-semibold italic">
                                @ {{ $member->user->getFullName() }}
                            </span>
                        </h6>
                        

                        <p class="text-right text-xs text-yellow-400 letter-spacing-1">
                            Publiée le {{ __formatDateTime($quote->created_at) }}
                        </p>
                    </div>
                @endforeach
            </div>
            
        @endif
    </div>

    <div class="swiper mySwiper max-w-4xl mx-auto">
    <div class="swiper-wrapper">

      <!-- Slide 1 -->
      <div class="swiper-slide bg-white p-6 rounded-2xl shadow-lg">
        <div class="flex items-center space-x-4 mb-4">
          <img src="https://i.pravatar.cc/100?img=32" class="w-14 h-14 rounded-full border-2 border-cyan-400" />
          <div>
            <h3 class="text-lg font-semibold text-gray-800">Alice Dupont</h3>
            <a href="mailto:alice@example.com" class="text-sm text-cyan-600 hover:underline">alice@example.com</a>
          </div>
        </div>
        <blockquote class="text-gray-600 italic border-l-4 border-cyan-400 pl-4">
          “Cette plateforme est incroyable ! Elle a transformé notre façon de gérer les enseignants.”
        </blockquote>
      </div>

      <!-- Slide 2 -->
      <div class="swiper-slide bg-white p-6 rounded-2xl shadow-lg">
        <div class="flex items-center space-x-4 mb-4">
          <img src="https://i.pravatar.cc/100?img=15" class="w-14 h-14 rounded-full border-2 border-cyan-400" />
          <div>
            <h3 class="text-lg font-semibold text-gray-800">Jean Koffi</h3>
            <a href="mailto:jean.koffi@example.com" class="text-sm text-cyan-600 hover:underline">jean.koffi@example.com</a>
          </div>
        </div>
        <blockquote class="text-gray-600 italic border-l-4 border-cyan-400 pl-4">
          “L’interface est fluide, moderne et intuitive. Bravo à toute l’équipe.”
        </blockquote>
      </div>

      <!-- Slide 3 -->
      <div class="swiper-slide bg-white p-6 rounded-2xl shadow-lg">
        <div class="flex items-center space-x-4 mb-4">
          <img src="https://i.pravatar.cc/100?img=12" class="w-14 h-14 rounded-full border-2 border-cyan-400" />
          <div>
            <h3 class="text-lg font-semibold text-gray-800">Fatou Ndiaye</h3>
            <a href="mailto:fatou.ndiaye@example.com" class="text-sm text-cyan-600 hover:underline">fatou.ndiaye@example.com</a>
          </div>
        </div>
        <blockquote class="text-gray-600 italic border-l-4 border-cyan-400 pl-4">
          “Un vrai gain de temps et une meilleure organisation. Je recommande vivement.”
        </blockquote>
      </div>

    </div>
  </div>



</div>






