<div class="w-full p-0 m-0">

  <div class="p-0 m-0 mb-4">
    
    <div class="text-center">
      <h5 class="letter-spacing-1 flex flex-col gap-y-2 text-gray-200">
        <span class="uppercase inline-block w-full pb-2">
          inscription
          <span>1/4</span>
        </span>
        <span wire:loading.remove wire:target='initPersonnalDataInsertion' class="inline-block w-full py-2 border-y">
          <span class="text-orange-600 font-semibold letter-spacing-1 border-b border-orange-500 mb-2 inline-block">
            Insertion des données personnelles
          </span>
          <span class="text-yellow-400 letter-spacing-2 text-xs block">
            Veuillez renseigner vos noms et prénoms complets et dans l'ordre de votre acte de naissance
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
    <div wire:loading wire:target='initPersonnalDataInsertion' class="text-center w-full mx-auto my-3">
      <h5 class="w-full bg-success-400 text-gray-900 border rounded-xl p-3 letter-spacing-2 border-r-gray-800 border-gray-900">
        <span class="fa animate-spin fa-rotate"></span>
        Traitement en cours...
      </h5>
    </div>
  </div>

  <div class="my-7">

  </div>

  <div class="my-4">

    
    @if($errors->any())

      <h4 class="w-full letter-spacing-2 p-2 text-base lg:text-base md:text-base sm:text-xs xs:text-xs mb-4 shadow rounded-full  shadow-red-600 bg-red-300 text-red-800 text-center mx-auto">
            <span>
              Le formulaire est incorrect
            </span>
      </h4>
    @endif

    @if (session()->has('persoData'))
      <h4 class="w-full letter-spacing-2 p-2 text-base lg:text-base md:text-base sm:text-xs xs:text-xs mb-4 shadow text-center mx-auto">
          <span wire:loading.remove wire:target='clearPersoData' wire:click='clearPersoData' class="inline-block w-full border hover:bg-orange-600 bg-orange-700 text-gray-950 py-2 text-center rounded-full cursor-pointer">
            Vider le cache enregistré
          </span>

          <span wire:loading wire:target='clearPersoData' class="inline-block w-full hover:bg-primary-600 bg-primary-700 border text-gray-950 py-2 text-center rounded-full cursor-pointer">
            <span class="fas fa-rotate animate-spin mr-4"></span>
            <span>Nettoyage en cours...</span>
          </span>
      </h4>
    @endif
    <form class="mx-auto mt-4 shadow-2 p-3" autocomplete="false">
      <div class="relative z-0 w-full mb-5 group text-gray-400">
        <label for="register-firstname" class="block mb-1 text-sm font-medium text-gray-400">Votre Nom</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                <span class="fas fa-user"></span>
            </div>
            <input wire:model='firstname' type="text" id="register-firstname" aria-describedby="helper-text-register-firstname" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Votre nom" required />
        </div>
        @error('firstname')
        <p id="helper-text-register-firstname" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
          {{ $message }}
        </p>
        @enderror
      </div>
        
      <div class="relative z-0 w-full mb-5 group text-gray-400">
        <label for="register-lastname" class="block mb-1 text-sm font-medium text-gray-400">Vos prénoms</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                <span class="fas fa-user"></span>
            </div>
            <input wire:model='lastname' type="text" id="register-lastname" aria-describedby="helper-text-register-lastname" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Vos prénoms complets" required />
        </div>
        @error('lastname')
        <p id="helper-text-register-lastname" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
          {{ $message }}
        </p>
        @enderror
      </div>

      <div class="mb-5 grid md:grid-cols-2 gap-3">
        <div class="relative z-0 w-full mb-5 group text-gray-400">
          <label for="register-birth_date" class="block mb-1 text-sm font-medium text-gray-400">Date de naissance</label>
          <div class="relative">
              <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                  <span class="fas fa-calendar-days"></span>
              </div>
              <input wire:model='birth_date' type="date" id="register-birth_date" aria-describedby="helper-text-register-birth_date" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Votre date de naissance" required />
          </div>
          @error('birth_date')
          <p id="helper-text-register-birth_date" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
            {{ $message }}
          </p>
          @enderror
        </div>
          
        <div class="relative z-0 w-full mb-5 group text-gray-400">
          <label for="register-birth_city" class="block mb-1 text-sm font-medium text-gray-400">Lieu de naissance</label>
          <div class="relative">
              <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                  <span class="fas fa-city"></span>
              </div>
              <input wire:model='birth_city' type="text" id="register-birth_city" aria-describedby="helper-text-register-birth_city" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Lieu de naissance" required />
          </div>
          @error('birth_city')
          <p id="helper-text-register-birth_city" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
            {{ $message }}
          </p>
          @enderror
        </div>
      </div>
      
      <div class="w-full mx-auto border rounded-lg border-gray-500 px-2 mb-5">
        <span class="inline-block py-1 letter-spacing-2 text-gray-400 w-full text-center text-sm border-b mb-1 border-gray-500">
            Votre adresse (Domicile)
        </span>
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-5 text-gray-400 group ">
                <label for="register-department" class="block mb-1 text-sm font-medium text-gray-400">Votre département</label>
                <select aria-describedby="helper-text-register-department" wire:model.live='department' id="register-department" class="bg-inherit border border-gray-300 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                  <option class="z-bg-secondary-light-opac" value="{{null}}">Votre département</option>
                  @foreach ($departments as $dk => $dep)
                    <option class="z-bg-secondary-light-opac" value="{{$dk}}">{{$dep}}</option>
                  @endforeach
                </select>
                @error('department')
                <p id="helper-text-register-department" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                  {{ $message }}
                </p>
                @enderror
              </div>
              @if($department)
              <div class="relative z-0 w-full mb-5 text-gray-400 group ">
                <label for="register-city" class="block mb-1 text-sm font-medium text-gray-400">Votre commune</label>
                <select aria-describedby="helper-text-register-city" wire:model.live='city' id="register-city" class="bg-transparent border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500">
                  <option class="z-bg-secondary-light-opac" value="{{null}}">Votre commune</option>
                  @foreach ($cities[$department_key] as $ck => $ct)
                    <option class="z-bg-secondary-light-opac" value="{{$ct}}">{{$ct}}</option>
                  @endforeach
                </select>
                @error('city')
                <p id="helper-text-register-city" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                  {{ $message }}
                </p>
                @enderror
              </div>
              @endif
        </div>
        
    </div>

      <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 w-full mb-5 text-gray-400 group ">
          <label for="register-gender" class="block mb-1 text-sm font-medium text-gray-400">Sexe</label>
          <select aria-describedby="helper-text-register-gender" wire:model='gender' id="register-gender" class="bg-inherit border border-gray-300 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option class="z-bg-secondary-light-opac" value="{{null}}">Préciser votre genre </option>
            @foreach ($genders as $gk => $g)
              <option class="z-bg-secondary-light-opac" value="{{$gk}}">{{$g}}</option>
            @endforeach
          </select>
          @error('gender')
          <p id="helper-text-register-gender" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
            {{ $message }}
          </p>
          @enderror
        </div>
        <div class="relative z-0 w-full mb-5 text-gray-400 group ">
          <label for="register-marital_status" class="block mb-1 text-sm font-medium text-gray-400">Situation matrimoniale</label>
          <select aria-describedby="helper-text-register-marital_status" wire:model='marital_status' id="register-marital_status" class="bg-inherit border border-gray-300 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option class="z-bg-secondary-light-opac" value="{{null}}">Préciser votre situation </option>
            @foreach ($marital_statuses as $mk => $m)
              <option class="z-bg-secondary-light-opac" value="{{$mk}}">{{$m}}</option>
            @endforeach
          </select>
          @error('marital_status')
          <p id="helper-text-register-marital_status" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
            {{ $message }}
          </p>
          @enderror
        </div>
        
      </div>

      <div class="grid md:gap-6">
        <div class="relative z-0 w-full mb-5 group text-gray-400">
          <label for="register-contacts" class="block mb-1 text-sm font-medium text-gray-400">
            Vos contacts
            <small class="text-yellow-500 text-xs letter-spacing-2 float-right ml-3">Séparez vos contacts par un tiret - </small>

          </label>
          <div class="relative">
              <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                  <span class="fas fa-phone"></span>
              </div>
              <input wire:model='contacts' type="text" id="register-contacts" aria-describedby="helper-text-register-contacts" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Vos contacts" required />
          </div>
          @error('contacts')
          <p id="helper-text-register-contacts" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
             {{ $message }}
          </p>
          @enderror
          
        </div>
      </div>
      <a href="#" wire:click='initPersonnalDataInsertion' wire:loading.class='opacity-50' wire:target='initPersonnalDataInsertion' class="w-full cursor-pointer py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
        <span wire:loading.remove wire:target='initPersonnalDataInsertion'>
          <span>Etape suivante</span>
          <span class="fas fa-hand-point-right"></span>

        </span>
        <span wire:loading wire:target='initPersonnalDataInsertion'>
          <span class="fa animate-spin fa-rotate"></span>
          Traitement en cours...
        </span>
      </a>
    </form>
    
  </div>
</div>