<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>
        {{-- <link rel="stylesheet" href="@sweetalert2/themes/dark/dark.css"> --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
        

        {{-- <script src="https://unpkg.com/scrollreveal"></script> --}}
        <script src="{{asset('js/myscrollreveal.js')}}"></script>
        <script>
            ScrollReveal({ reset: true });
        </script>
        

        <style>
            .swiper {
                padding: 2rem;
            }
        </style>
        
    </head>
    <body class="bg-slate-200 min-h-screen dark:bg-blue-300">

        <div id="my-preloader-cover" role="status" class="hidden text-center opacity-70 justify-center text-gray-300 w-full min-h-screen items-center absolute z-50 bg-slate-500">
            <span class="text-3xl fas fa-rotate animate-spin"></span>
            <span>Chargement...</span>
        </div>
        
        @livewire('partials.navbar')
        <main class="pt-20 bg-inherit px-2">
            @livewire("live-toaster")
            {{ $slot }}
        </main>
        @livewire('chat.new-forum-chat-subject-modal')
        @livewire('master.modals.new-member-modal-component')
        @livewire('master.modals.new-law-modal')
        @livewire('master.modals.new-chapter-modal')
        @livewire('master.modals.new-article-modal')
        @livewire('master.modals.new-role-modal-component')
        @livewire('master.modals.role-manager-component')
        @livewire('master.modals.open-user-profil-photo-view-component')
        @livewire('master.modals.lycee-manager-modal')
        @livewire('master.modals.lycee-filiars-manager-modal')
        @livewire('master.modals.lycee-promotions-manager-modal')
        @livewire('master.modals.member-payments-modal-manager')
        @livewire('user.quotes-manager-modal')
        @livewire('master.modals.communique-manager-modal')
        @livewire('partials.footer')
        

        @livewireScripts
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        {{-- <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet"> --}}
        {{-- <script src="https://cdn.fedapay.com/checkout.js?v=1.1.7"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        @livewireSweetalertScripts


        <script>

            document.addEventListener('DOMContentLoaded', () => {

                document.getElementById('epreuve-message-input').focus();

                //document.getElementById('my-preloader-cover').remove();

            });

            document.addEventListener('livewire:navigated', () =>{
                initFlowbite();
            });
            
            window.User = { 
                id: {{optional(auth()->user())->id}},
            }

            new Swiper(".mySwiper", {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                spaceBetween: 40,
                grabCursor: true,
            });


            new Swiper(".MyCommuniquesSwiper", {
                loop: 0,
                autoplay: {
                    delay: 20000,
                    disableOnInteraction: false,
                },
                spaceBetween: 50,
                grabCursor: true,
            });

            
            document.addEventListener('livewire:init', () => {

                Livewire.on('HideModalEvent', (event) => {

                    let modal_name = event[0];

                    let modalElement = document.querySelector(modal_name);

                    console.log(modalElement);

                    modal = new Modal(modalElement)

                    modal.hide();

                    document.querySelector(".fixed.inset-0.z-40").remove()

                });

                Livewire.on('OpenModalEvent', (event) => {

                    let modal_name = event[0];

                    let modalElement = document.querySelector(modal_name);

                    console.log(modalElement);

                    modal = new Modal(modalElement)

                    modal.show();

                });
                
            });
            
        </script>
        
        <script src="{{asset('js/revealmanagerfile.js')}}"></script>


        {{-- <script src="./assets/vendor/canvas-confetti/dist/confetti.browser.js"></script> --}}
    </body>
</html>
