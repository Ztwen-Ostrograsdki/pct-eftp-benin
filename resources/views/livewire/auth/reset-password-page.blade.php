<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex h-full items-center">
      <main class="w-full max-w-md mx-auto p-6">
        <div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
          <div class="p-4 sm:p-7">
            <div class="text-center">
              <h1 class="block text-xl font-bold text-gray-800 dark:text-white">Réinitialisation de mot de passe</h1>
              <hr class="text-gray-600 bg-gray-600 my-2">
            </div>
            <div class="mt-5">

              @if(session()->has('success'))
              <span class="text-dark bg-green-400 border block text-sm rounded-md p-2 border-green-950 text-center">
                <b>{{ session('success')}}</b>
              </span>
              @endif

              @if(session()->has('error'))
              <span class="text-dark bg-red-400 border block rounded-md p-2 border-red-950 text-center">
                <b>{{ session('error')}}</b>
              </span>
              @endif
              <!-- Form -->
              <form wire:submit.prevent='savePassword'>
                <div class="grid gap-y-4">
                  <!-- Form Group -->
                  <div>
                    <div class="flex justify-between items-center">
                      <label for="r_password" class="block text-sm mb-2 cursor-pointer dark:text-white">Mot de passe</label>
                    </div>
                    <div class="relative">
                      <input placeholder="Choisissez un mot de passe" wire:model.live='password' type="password" id="r_password" name="password" class="@error('password') border-red-700 @else @if($password && $password_confirmation) border-green-700  @endif @enderror  py-3 border px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="r_password-error">
                      @error('password')
                      <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                        <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                        </svg>
                      </div>
                      @enderror
                    </div>
                    @error('password')
                      <p class="text-xs text-red-600 mt-2" id="r_password-error">{{ $message }}</p>
                    @else
                    @if ($password && $password_confirmation &&  $password == $password_confirmation)
                      <p class="text-xs text-green-700 mt-2" id="password-error">Confirmé!</p>
                    @endif
                    @enderror
                  </div>
  
                  <div>
                    <div class="flex justify-between items-center">
                      <label for="r_password_confirmation" class="block text-sm mb-2 cursor-pointer dark:text-white">Confirmez</label>
                    </div>
                    <div class="relative">
                      <input placeholder="Confirmez le mot de passe..." wire:model.live='password_confirmation' type="password" id="r_password_confirmation" name="password_confirmation" class="py-3 border px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="r_password_confirmation-error">
                      @error('password_confirmation')
                      <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                        <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                        </svg>
                      </div>
                      @enderror
                    </div>
                    @error('password_confirmation')
                      <p class="text-xs text-red-600 mt-2" id="r_password_confirmation-error">{{ $message }}</p>
                    @enderror
                  </div>

                  @if(!$token)
                  <div>
                    <label for="password_reset_key" class="block text-sm mb-2 cursor-pointer dark:text-white">La clé</label>
                    <div class="relative">
                      <input placeholder="Renseignez la clé..." wire:model.live='password_reset_key' type="text" id="password_reset_key" name="password_reset_key" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="password_reset_key-error">
                      @error('password_reset_key')
                      <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                        <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                        </svg>
                      </div>
                      @enderror
                    </div>
                    @error('password_reset_key')
                      <p class="text-xs text-red-600 mt-2" id="password_reset_key-error">{{ $message }}</p>
                    @enderror
                  </div>
                  <div>
                    <label for="email" class="block text-sm mb-2 cursor-pointer dark:text-white">Adresse mail</label>
                    <div class="relative">
                      <input placeholder="Renseignez votre adresse mail" wire:model.live='email' type="email" id="email" name="email" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="email-error">
                      @error('email')
                      <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                        <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                        </svg>
                      </div>
                      @enderror
                    </div>
                    @error('email')
                      <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                    @enderror
                  </div>
                  @endif

                  @if($key_expired)
                    <a wire:loading.class='opacity-50' wire:target='resendPasswordRequest' href="#" wire:click='resendPasswordRequest' class="w-full cursor-pointer py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orande-600 text-white hover:bg-orange-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                      <span wire:loading.remove wire:target='resendPasswordRequest'>Relancer la demande</span>
                      <span wire:loading wire:target='resendPasswordRequest' class="">
                        En cours d'envoi...
                        <span class="fa fas fa-rotate animate-spin"></span>
                      </span>
                    </a>
                  @else
                    @if(!$not_request_sent)
                    <a wire:loading.class='opacity-50' wire:target='savePassword' href="#" wire:click='savePassword' class="w-full cursor-pointer py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                      <span wire:loading.remove wire:target='savePassword'>Réinitialiser</span>
                      <span wire:loading wire:target='savePassword' class="">
                        Mise à jour en cours...
                        <span class="fa fas fa-rotate animate-spin"></span>
                      </span>
                    </a>
                    @else
                    <a href="{{route('password.forgot')}}" class="w-full cursor-pointer py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-600 text-dark hover:bg-orange-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                      Envoyez une demande
                    </a>
                    @endif
                  @endif
                </div>
              </form>
              <!-- End Form -->
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>