<div class="w-full bg-gradient-to-r from-blue-200 to-cyan-200 py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Grid -->
      <div class="grid md:grid-cols-2 gap-4 md:gap-8 xl:gap-20 md:items-center">
        <div>
          <h1 class="block text-3xl font-bold text-gray-800 sm:text-4xl lg:text-5xl lg:leading-tight dark:text-gray-500">
            <span class="welcome">
              Bienvenue sur
            </span>   
            <br><span class="text-blue-600 from-right">{{ config('app.name') }}</span><br>
            <span class="text-sky-500 home-element">BENIN</span>
          </h1>
          <p class="mt-3 text-lg text-gray-800 home-element">
            La plateforme qui vous oriente sur le fonctionnement et la pédagogie en PCT dans la formation technique et professionnel en république du BENIN
        </p>
  
          <!-- Buttons -->
          <div class="mt-7 grid gap-3 w-full sm:inline-flex">
            @guest
            <a href="{{route('register')}}" class="home-element py-3 px-4 inline-flex justify-center items-center gap-x-2 text-xs font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
              Enregistez - vous ici
              <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6" />
              </svg>
            </a>
            @endguest

            <a href="#" class="from-left py-3 px-4 inline-flex justify-center items-center gap-x-2 text-xs font-semibold rounded-lg border border-transparent bg-blue-500 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
              <span class="fas fa-newspaper"></span>
              Les nouvelles - ici
              <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6" />
              </svg>
            </a>

            <a class="from-right py-3 px-4 inline-flex justify-center items-center gap-x-2 text-xs font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="#">
              <span class="fas fa-phone"></span>
              <span class="fas fa-comments"></span>
              Contactez un membre actif
            </a>
          </div>
          <!-- End Buttons -->
  
          <!-- Review -->
          <div class="mt-6 lg:mt-10 grid grid-cols-2 gap-x-5">
            <!-- Review -->
            <div class="py-5">
              <div class="flex space-x-1">
                
              </div>
  
              <p class="mt-3 text-sm text-gray-800">

              </p>
  
              <div class="mt-5">
                <!-- Star -->
                
                <!-- End Star -->
              </div>
            </div>
            <!-- End Review -->
  
            <!-- Review -->
            <div class="py-5">
              <div class="flex space-x-1">
                
              </div>
  
              <div class="mt-5">
                <!-- Star -->
                
                <!-- End Star -->
              </div>
            </div>
            <!-- End Review -->
          </div>
          <!-- End Review -->
        </div>
        <!-- End Col -->
  
        <div class="relative ms-4">

            <h1 class="flex text-3xl image-to-rotate justify-end font-bold text-gray-800 sm:text-4xl lg:text-5xl lg:leading-tight dark:text-gray-500">
              <div  class="w-2/3 h-2/3 flex justify-end">
                <img class="shadow-2 rounded-3xl animate-pulse" src="{{asset('images/img5.png')}}" alt="">
              </div>
            </h1>

          {{-- <img class="w-full rounded-md" src="https://png.pngtree.com/png-vector/20240628/ourlarge/pngtree-emblem-for-a-university-with-large-book-child-inventor-physics-chemistry-png-image_12735535.png" alt="Image Description">
          
          <div class="absolute inset-0 -z-[1] bg-gradient-to-tr from-gray-200 via-white/0 to-white/0 w-full h-full rounded-md mt-4 -mb-4 me-4 -ms-4 lg:mt-6 lg:-mb-6 lg:me-6 lg:-ms-6 dark:from-slate-800 dark:via-slate-900/0 dark:to-slate-900/0">
            
          </div> --}}
  
          <!-- SVG-->
          
          <!-- End SVG-->
        </div>
        <!-- End Col -->
      </div>
      {{-- REVIEWS SECTION --}}
      <div>
        <div class="swiper mySwiper max-w-4xl mx-auto">
            <h3 class="font-semibold letter-spacing-1 py-3 text-sky-600 text-lg" >Quelques pensées de nos membres</h3>
            <div class="swiper-wrapper">
            <!-- Slide 1 -->
            @foreach (getUsers() as $user)
                <div wire:key='defilement-reviews-membre-{{$user->id}}' class="swiper-slide bg-sky-100 p-6 rounded-2xl shadow-lg">
                <div class="flex items-center space-x-4 mb-4">
                <img src="{{user_profil_photo($user)}}" class="w-24 h-24 rounded-full border-2 border-cyan-700" />
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                    {{ $user->getFullName(true) }}
                    </h3>
                    <span class="flex flex-col">
                        <a href="#" class="text-sm text-cyan-600 hover:underline">
                            <span class="fas fa-person"></span>
                            @if($user->member)
                              {{ $user->member->role ? $user->member->role->name : 'Un membre actif' }}
                            @else
                              Un enseignant actif
                            @endif
                        </a>
                        <a href="mailto:{{$user->email}}" class="text-sm text-cyan-600 hover:underline">
                            <span class="fas fa-envelope"></span>
                            {{ $user->email }}
                        </a>
                        <a href="#" class="text-sm text-cyan-600 hover:underline">
                            <span class="fas fa-phone"></span>
                            {{ $user->contacts ? $user->contacts : 'Non renseigné' }}
                        </a>
                        <a href="#" class="text-sm text-cyan-600 hover:underline">
                            <span class="fas fa-home"></span>
                            {{ $user->address ? $user->address : 'Non renseignée' }}
                        </a>
                    </span>
                </div>
                </div>
                <blockquote class="text-gray-600 italic border-l-4 border-cyan-600 pl-4">
                “{{ $user->getSingleQuote() }}”
                </blockquote>
            </div>
            @endforeach
            </div>
        </div>
      </div>
    {{-- END REVIEWS SECTION --}}
      @livewire('partials.home-carrousel-component')
      <!-- End Grid -->
    </div>
  </div>
