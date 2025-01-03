<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>
        <link rel="stylesheet" href="@sweetalert2/themes/dark/dark.css">
        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        

    </head>
    <body class="bg-slate-200 min-h-screen dark:bg-blue-300">
        
        @livewire('partials.navbar')
        <main>
            {{ $slot }}
        </main>
        @livewire('master.modals.new-member-modal-component')
        @livewire('master.modals.new-role-modal-component')
        @livewire('partials.footer')

        @livewireScripts
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
        <script src="https://cdn.fedapay.com/checkout.js?v=1.1.7"></script>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
        @livewireSweetalertScripts

        <script>
            document.addEventListener('livewire:navigated', () =>{
                console.log('navigated');
                
                initFlowbite();
            });
            
            window.User = { 
                id: {{optional(auth()->user())->id}},
            }

            
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


            FedaPay.init('#pay-btn', {
                public_key: 'pk_sandbox_lf7ed0OyC_S-JmIEL3RvCE1R',
                
                }
            )
        </script>
    </body>
</html>
