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
        <div x-show="loaded" x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 500)})" class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black">
            <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-primary border-t-transparent">
            </div>
        </div>
        @livewire('partials.navbar')
        <main>
            {{ $slot }}
        </main>
        @livewire('partials.footer')

        @livewireScripts
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
        <script src="https://cdn.fedapay.com/checkout.js?v=1.1.7"></script>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
        @livewireSweetalertScripts

        <script>
            // document.addEventListener('livewire.navigated', () =>{
            //     window.HSStaticMethods.autoInit();
            // });
            window.User = { 
                id: {{optional(auth()->user())->id}},
            }

            $wire.on('HideModal', (event) => {

                console.log("okay", event);
                

                modal_name = event[0];

                const modalElement: HTMLElement = document.querySelector(modal_name);
                
                console.log(modalElement);

                //modal = new Modal($modalElement)

                //modal.hide();

            });

            FedaPay.init('#pay-btn', {
                public_key: 'pk_sandbox_lf7ed0OyC_S-JmIEL3RvCE1R',
                
                }
            )
        </script>
    </body>
</html>
