<div class="w-full p-0 m-0">
    <div class="w-full p-0 m-0">
        <div wire:loading.remove wire:target='validatePasswordAndProfil' class="text-center">
            <h5 class="letter-spacing-1 flex flex-col gap-y-2 text-gray-200">
              <span class="uppercase inline-block w-full pb-2">
                inscription
                <span>4/4</span>
              </span>
              <span class="inline-block w-full py-2 border-y">
                <span class="text-green-400 font-semibold letter-spacing-1 border-b border-green-700 mb-2 inline-block">
                  Validation addresse mail et photo de profil
                </span>
                <span class="text-yellow-400 letter-spacing-2 text-xs block">
                  Veuillez choisir une photo récente de vous
                </span>
              </span>
            </h5>
            <p class="mt-2 text-sm block text-gray-600 dark:text-gray-400">
              Vous avez déjà un compte?
              <a class="text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{route('login')}}">
                Connectez-vous ici
              </a>
            </p>
        </div>
        <div wire:loading wire:target='validatePasswordAndProfil' class="text-center w-full mx-auto my-3">
            <h5 class="w-full bg-success-400 text-gray-900 border rounded-xl p-3 letter-spacing-2 border-r-gray-800 border-gray-900">
              <span class="fa animate-spin fa-rotate"></span>
              Traitement en cours...
            </h5>
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
            <div class="flex mx-auto items-center @if(!$email) hidden @endif rounded-full p-2 my-2 justify-center text-gray-400 bg-gray-900 h-20 w-20 border" >
            <b wire:loaded.remove wire:target='profil_photo' class="text-6xl   uppercase mb-2">
                {{ Str::upper(Str::substr($email, 0, 1)) }}
            </b>
            </div>
        @endif
    </div>
    <!-- Form -->
    <form wire:submit.prevent='validatePasswordAndProfil'>
            <div class="w-full mt-5">
                <div class="relative z-0 w-full mb-5 group text-gray-400">
                    <label for="register-email" class="block mb-1 text-sm font-medium text-gray-400">Votre addresse mail</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                            <span class="fas fa-envelope"></span>
                        </div>
                        <input wire:model.live='email' type="text" id="register-email" aria-describedby="helper-text-register-email" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Votre addresse mail" required />
                    </div>
                    @error('email')
                    <p id="helper-text-register-email" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                      {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group text-gray-400">
                    <label for="register-password" class="block mb-1 text-sm font-medium text-gray-400">Votre mot de passe</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                            <span class="fas fa-key"></span>
                        </div>
                        <input wire:model='password' type="password" id="register-password" aria-describedby="helper-text-register-password" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Choisissez un mot de passe confidentiel" required />
                    </div>
                    @error('password')
                    <p id="helper-text-register-password" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                      {{ $message }}
                    </p>
                    @else
                        @if ($password && $password_confirmation &&  $password == $password_confirmation)
                        <p id="helper-text-register-password" class="mt-2 text-xs text-green-500 letter-spacing-2 ">
                            Confirmé
                          </p>
                        @endif
                    @enderror
                </div>
                    
                <div class="relative z-0 w-full mb-5 group text-gray-400">
                    <label for="register-password_confirmation" class="block mb-1 text-sm font-medium text-gray-400">Confirmez votre mot de passe</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                            <span class="fas fa-key"></span>
                        </div>
                        <input wire:model='password_confirmation' type="password" id="register-password_confirmation" aria-describedby="helper-text-register-password_confirmation" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Confirmez le mot de passe" required />
                    </div>
                    @error('password_confirmation')
                    <p id="helper-text-register-password_confirmation" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                      {{ $message }}
                    </p>
                    @enderror
                </div>
            </div>

            <div class="w-full mb-5">
                <div class="flex justify-between items-center">
                    <label for="profil_photo" class="block text-sm mb-2 cursor-pointer text-gray-400">Photo de profil 
                        <span class="text-orange-500 float-right ml-4">(Obligatoire)</span>
                    </label>
                </div>
                <div class="relative">
                    <input placeholder="Choisissez une photo de profil" wire:model='profil_photo' type="file" id="profil_photo" name="profil_photo" class="py-3 border px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none bg-transparent dark:border-gray-700 text-gray-400 dark:focus:ring-gray-600" required aria-describedby="profil_photo-error">
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
            <div class="grid grid-cols-5 gap-x-2">
                <a href="#" wire:click='goToTheProfessionnalForm' wire:loading.class='opacity-50' wire:target='goToTheProfessionnalForm' class=" cursor-pointer py-3 px-4 col-span-2 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gray-500 text-white hover:bg-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    <span wire:loading.remove wire:target='goToTheProfessionnalForm'>
                        <span class="fas fa-hand-point-left"></span>
                        <span>En arrière</span>
                    </span>
                    <span wire:loading wire:target='goToTheProfessionnalForm'>
                      <span class="fa animate-spin fa-rotate"></span>
                      Chargement en cours...
                    </span>
                </a>
    
                <a href="#" wire:click='validatePasswordAndProfil' wire:loading.class='opacity-50' wire:target='validatePasswordAndProfil' class=" cursor-pointer py-3 px-4 col-span-3 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                    <span wire:loading.remove wire:target='validatePasswordAndProfil'>
                      <span>Suivant</span>
                      <span class="fas fa-hand-point-right"></span>
            
                    </span>
                    <span wire:loading wire:target='validatePasswordAndProfil'>
                      <span class="fa animate-spin fa-rotate"></span>
                      Traitement en cours...
                    </span>
                </a>
            </div>
        </form>
    </div>
</div>
