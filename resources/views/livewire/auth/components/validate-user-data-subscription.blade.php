<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex h-full items-center">
      <main class="w-full max-w-lg mx-auto p-6">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
          <div class="p-4 sm:p-7">
            <div wire:loading wire:target='register' class="text-center">
              <h5 class="w-full bg-success-400 text-gray-900 shadow-2 shadow-sky-500 border rounded-xl p-3 letter-spacing-2 border-r-gray-800">
                <span class="fa animate-spin fa-rotate"></span>
                Traitement en cours...
              </h5>
            </div>
            <div wire:loading.remove wire:target='register' class="text-center">
              <h1 class="block text-2xl font-bold text-gray-800 dark:text-white uppercase">inscription</h1>
              <p class="mt-2 text-sm block text-gray-600 dark:text-gray-400">
                Vous avez déjà un compte?
                <a class="text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{route('login')}}">
                  Connectez-vous ici
                </a>
              </p>
              <div class="block w-full">
                <small class="text-yellow-400 float-right w-full block ">
                    Veuillez renseigner vos nom et prénoms selon votre acte de naissance
                </small>
            </div>
              <div class=" bg-transparent w-full p-2 text-center py-6 my-2" wire:loading wire:target='profil_photo'>
                <b class=" text-yellow-700 text-center">
                  Chargement photo en cours... Veuillez patientez!
                </b>
              </div>
              @if($profil_photo)
              <div class="flex justify-center rounded-full p-2 my-2" >
                  <img wire:loaded wire:target='profil_photo' class="mt-1  h-40 w-40 border rounded-full" src="{{$profil_photo->temporaryUrl()}}" alt="">
              </div>
              @else
              <div class="flex justify-center @if(!$pseudo) hidden @endif rounded-full p-2 my-2" >
                <b wire:loaded.remove wire:target='profil_photo' class="pt-2 text-9xl  bg-gray-900 uppercase text-center align-middle text-gray-400 h-40 w-40 border rounded-full">
                  {{ Str::upper(Str::substr($pseudo, 0, 1)) }}
                </b>
            </div>
              @endif
            </div>
            <hr class="my-5 border-slate-300">
            <!-- Form -->
            <form wire:submit.prevent='register'>
              <div class="grid gap-y-4">
                <!-- Form Group -->
                
                <div>
                    <label for="firstname" class="block text-sm mb-2 cursor-pointer dark:text-white">Votre Nom <span class="text-red-700 text-lg">*</span></label>
                    <div class="relative">
                      <input placeholder="Renseignez votre Nom..." wire:model.live='firstname' type="text" id="firstname" name="firstname" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="email-error">
                      @error('firstname')
                      <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                        <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                        </svg>
                      </div>
                      @enderror
                    </div>
                    @error('firstname')
                      <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="lastname" class="block text-sm mb-2 cursor-pointer dark:text-white">Vos prénoms <span class="text-red-700 text-lg">*</span> </label>
                    <div class="relative">
                      <input placeholder="Renseignez vos prénoms complet selon votre acte de naissance..." wire:model.live='lastname' type="text" id="lastname" name="lastname" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="email-error">
                      @error('lastname')
                      <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                        <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                        </svg>
                      </div>
                      @enderror
                    </div>
                    @error('lastname')
                      <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                  <label for="email" class="block text-sm mb-2 cursor-pointer dark:text-white">Adresse mail <span class="text-red-700 text-lg">*</span></label>
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
                <!-- End Form Group -->
  
                <!-- Form Group -->
                <div>
                  <div class="flex justify-between items-center">
                    <label for="password" class="block text-sm mb-2 cursor-pointer dark:text-white">Mot de passe <span class="text-red-700 text-lg">*</span></label>
                  </div>
                  <div class="relative">
                    <input placeholder="Choisissez un mot de passe" wire:model.live='password' type="password" id="password" name="password" class="@error('password') border-red-700 @else @if($password && $password_confirmation) border-green-700  @endif @enderror  py-3 border px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="password-error">
                    @error('password')
                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                      <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                      </svg>
                    </div>
                    @enderror
                  </div>
                  @error('password')
                    <p class="text-xs text-red-600 mt-2" id="password-error">{{ $message }}</p>
                  @else
                  @if ($password && $password_confirmation &&  $password == $password_confirmation)
                    <p class="text-xs text-green-700 mt-2" id="password-error">Confirmé!</p>
                  @endif
                  @enderror
                </div>

                <div>
                  <div class="flex justify-between items-center">
                    <label for="password_confirmation" class="block text-sm mb-2 cursor-pointer dark:text-white">Confirmez <span class="text-red-700 text-lg">*</span></label>
                  </div>
                  <div class="relative">
                    <input placeholder="Confirmez le mot de passe..." wire:model.live='password_confirmation' type="password" id="password_confirmation" name="password_confirmation" class="py-3 border px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="password_confirmation-error">
                    @error('password_confirmation')
                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                      <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                      </svg>
                    </div>
                    @enderror
                  </div>
                  @error('password_confirmation')
                    <p class="text-xs text-red-600 mt-2" id="password_confirmation-error">{{ $message }}</p>
                  @enderror
                </div>

                <div>
                  <div class="flex justify-between items-center">
                    <label for="profil_photo" class="block text-sm mb-2 cursor-pointer dark:text-white">Photo de profil (Facultative)</label>
                  </div>
                  <div class="relative">
                    <input placeholder="Choisissez une photo de profil" wire:model='profil_photo' type="file" id="profil_photo" name="profil_photo" class="py-3 border px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" required aria-describedby="profil_photo-error">
                    @error('profil_photo')
                    <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                      <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                      </svg>
                    </div>
                    @enderror
                  </div>
                  @error('profil_photo')
                    <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                  @enderror
                </div>
                <!-- End Form Group -->
                <a href="#" wire:click='register' wire:loading.class='opacity-50' wire:target='register' class="w-full cursor-pointer py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                  <span wire:loading.remove wire:target='register'>S'inscrire</span>
                  <span wire:loading wire:target='register'>
                    <span class="fa animate-spin fa-rotate"></span>
                    Traitement en cours...
                  </span>
                </a>
              </div>
            </form>
            <!-- End Form -->
          </div>
        </div>
    </div>
  </div>
