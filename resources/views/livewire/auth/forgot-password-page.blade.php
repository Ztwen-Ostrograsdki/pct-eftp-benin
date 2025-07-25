<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex h-full items-center">
      <main class="w-full max-w-md mx-auto p-6">
        <div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
          <div class="p-4 sm:p-7">
            <div class="text-center">
              <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Mot de passe oublié </h1>
              <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Je me rappelle de mon mot de passe
                <a class="text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{route('login')}}">
                  Connexion ici
                </a>
              </p>
            </div>

            <div class="mt-5">
              <!-- Form -->
                @if(session()->has('success'))
                <span class="text-dark font-semibold letter-spacing-1 bg-green-400 border block text-sm rounded-md p-2 border-green-950 text-center">
                  {{ session('success')}}
                </span>
                @endif

                @if(session()->has('error'))
                <span class="text-dark text-sm font-semibold letter-spacing-1 bg-red-400 border block rounded-md p-2 border-red-950 text-center">
                  {{ session('error')}}
                </span>
                @endif
  
              <form wire:submit.prevent='submitForm'>
                <div class="grid gap-y-4">
                  <!-- Form Group -->
                  <div>
                    <label for="email" class="block text-sm mb-2 cursor-pointer dark:text-white">Adresse mail</label>
                    <div class="relative">
                      <input placeholder="Renseignez votre adresse mail" wire:model='email' type="email" id="email" name="email" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="fogot_email-error">
                      @error('email')
                      <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                        <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                        </svg>
                      </div>
                      @enderror
                    </div>
                    @error('email')
                      <p class="text-xs text-red-600 mt-2" id="fogot_email-error">{{ $message }}</p>
                    @enderror
                  </div>
                  <!-- End Form Group -->
                  <a wire:loading.class='opacity-50' wire:target='submitForm' href="#" wire:click='submitForm' class="cursor-pointer w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    <span wire:loading.remove wire:target='submitForm'>Réinitialiser mot de passe</span>
                    <span wire:loading wire:target="submitForm">
                      <span class="animate-spin fas fa-rotate"></span>
                      En cours de traitement...
                    </span>
                  </a>
                  
                </div>
              </form>
              <!-- End Form -->
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>