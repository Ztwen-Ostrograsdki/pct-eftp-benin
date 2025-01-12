<div class="w-full p-0 m-0">
    <div class="p-0 m-0 mb-4">
      <div class="text-center">
        <h5 class="letter-spacing-1 flex flex-col gap-y-2 text-gray-200">
          <span class="uppercase inline-block w-full pb-2">
            inscription
            <span>3/4</span>
        </span>
          <span wire:loading.remove wire:target='initProfessionnalDataInsertion' class="inline-block w-full py-2 border-y">
            <span class="text-green-600 font-semibold letter-spacing-1 border-b border-green-500 mb-2 inline-block">
              Insertion des donnée professionnelles
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
      <div wire:loading wire:target='initProfessionnalDataInsertion' class="text-center w-full mx-auto my-3">
        <h5 class="w-full bg-success-400 text-gray-900 border rounded-xl p-3 letter-spacing-2 border-r-gray-800 border-gray-900">
          <span class="fa animate-spin fa-rotate"></span>
          Traitement en cours...
        </h5>
      </div>
    </div>
    <div class="my-7"></div>
    <div class="mt-4">
      @if($errors->any())

        <h4 class="w-full letter-spacing-2 p-2 text-base lg:text-base md:text-base sm:text-xs xs:text-xs mb-4 shadow rounded-full  shadow-red-600 bg-red-300 text-red-800 text-center mx-auto">
            <span>
              Le formulaire est incorrect
            </span>
        </h4>
      @endif

      @if (session()->has('professionnalData'))
        <h4 class="w-full letter-spacing-2 p-2 text-base lg:text-base md:text-base sm:text-xs xs:text-xs mb-4 shadow text-center mx-auto">
            <span wire:loading.remove wire:target='clearprofessionnalData' wire:click='clearprofessionnalData' class="inline-block w-full border hover:bg-orange-600 bg-orange-700 text-gray-950 py-2 text-center rounded-full cursor-pointer">
              Vider le cache enregistré
            </span>

            <span wire:loading wire:target='clearprofessionnalData' class="inline-block w-full hover:bg-primary-600 bg-primary-700 border text-gray-950 py-2 text-center rounded-full cursor-pointer">
              <span class="fas fa-rotate animate-spin mr-4"></span>
              <span>Nettoyage en cours...</span>
            </span>
        </h4>
      @endif
      <form class="mx-auto mt-4 shadow-2 p-3" autocomplete="false">
        
        <div class="relative z-0 w-full mb-5 group text-gray-400">
          <label for="register-matricule" class="block mb-1 text-sm font-medium text-gray-400">Votre matricule</label>
          <div class="relative">
              <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                  <span class="fas fa-user-check"></span>
              </div>
              <input wire:model='matricule' type="text" id="register-matricule" aria-describedby="helper-text-register-matricule" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Votre matricule" required />
          </div>
          @error('matricule')
          <p id="helper-text-register-matricule" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
            {{ $message }}
          </p>
          @enderror
        </div>
        <div class="w-full mx-auto border rounded-lg border-gray-500 px-2 mb-5">
            <span class="inline-block py-1 letter-spacing-2 text-gray-400 w-full text-center text-sm border-b mb-1 border-gray-500">
                Votre lieu de travail ou de déploiement
            </span>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 text-gray-400 group ">
                    <label for="register-job_department" class="block mb-1 text-sm font-medium text-gray-400">Votre département</label>
                    <select aria-describedby="helper-text-register-job_department" wire:model.live='job_department' id="register-job_department" class="bg-inherit border border-gray-300 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                      <option class="z-bg-secondary-light-opac" value="{{null}}">Votre département</option>
                      @foreach ($departments as $dk => $dep)
                        <option class="z-bg-secondary-light-opac" value="{{$dep}}">{{$dep}}</option>
                      @endforeach
                    </select>
                    @error('job_department')
                    <p id="helper-text-register-job_department" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                      {{ $message }}
                    </p>
                    @enderror
                  </div>
                  @if($job_department)
                  <div class="relative z-0 w-full mb-5 text-gray-400 group ">
                    <label for="register-job_city" class="block mb-1 text-sm font-medium text-gray-400">Votre commune</label>
                    <select aria-describedby="helper-text-register-job_city" wire:model.live='job_city' id="register-job_city" class="bg-transparent border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500">
                      <option class="z-bg-secondary-light-opac" value="{{null}}">Votre commune</option>
                      @foreach ($cities[$department_key] as $ck => $jcity)
                        <option class="z-bg-secondary-light-opac" value="{{$jcity}}">{{$jcity}}</option>
                      @endforeach
                    </select>
                    @error('job_city')
                    <p id="helper-text-register-job_city" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                      {{ $message }}
                    </p>
                    @enderror
                  </div>
                  @endif
            </div>
            
        </div>
  
        <div class="">
          <div class="relative z-0 w-full mb-5 text-gray-400 group ">
            <label for="register-teaching_since" class="block mb-1 text-sm font-medium text-gray-400">
              Je suis dans l'enseignement dépuis
              @if($teaching_since && $years_experiences)
                <small class="text-yellow-400 float-right letter-spacing-2">
                    {{ $years_experiences }} années d'expériences 
                </small>
              @endif
            </label>
            <select aria-describedby="helper-text-register-teaching_since" wire:model.live='teaching_since' id="register-teaching_since" class="bg-inherit border border-gray-300 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
              <option class="z-bg-secondary-light-opac" value="{{null}}">Préciser l'Année 
                </option>
                 
              @foreach ($years as $y)
                <option class="z-bg-secondary-light-opac" value="{{$y}}">{{$y}}</option>
              @endforeach
            </select>
            @error('teaching_since')
            <p id="helper-text-register-teaching_since" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
              {{ $message }}
            </p>
            @enderror
          </div>
          
        </div>

        <div class="w-full mx-auto border rounded-lg border-gray-500 px-2 mb-5">
            <span class="inline-block py-1 letter-spacing-2 text-gray-400 w-full text-center text-sm border-b mb-1 border-gray-500">
                Vous êtes déployé dans l'énseignement général (CEG)?
            </span>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 text-gray-400 group ">
                    <label for="register-from_general_school" class="block mb-1 text-sm font-medium text-gray-400">Je suis dans un CEG</label>
                    <select aria-describedby="helper-text-register-from_general_school" wire:model.live='from_general_school' id="register-from_general_school" class="bg-inherit border border-gray-300 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                      <option class="z-bg-secondary-light-opac" value="{{false}}">NON</option>
                      <option class="z-bg-secondary-light-opac" value="{{true}}">OUI</option>
                    </select>
                    @error('from_general_school')
                    <p id="helper-text-register-from_general_school" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                      {{ $message }}
                    </p>
                    @enderror
                  </div>
                  @if($from_general_school)
                  <div class="relative z-0 w-full mb-5 group text-gray-400">
                    <label for="register-general_school" class="block mb-1 text-sm font-medium text-gray-400">Renseignez CEG</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                            <span class="fas fa-school"></span>
                        </div>
                        <input wire:model.live='general_school' type="text" id="register-general_school" aria-describedby="helper-text-register-general_school" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Renseignez vos CEG" required />
                    </div>
                    @error('general_school')
                    <p id="helper-text-register-general_school" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                      {{ $message }}
                    </p>
                    @enderror
                    
                  </div>
                  
                  @endif
            </div>
        </div>
        <div class="grid md:gap-6">
          <div class="relative z-0 w-full mb-5 group text-gray-400">
            <label for="register-school" class="block mb-1 text-sm font-medium text-gray-400">
                Vos lycées d'intervention
                <small class="text-yellow-500 letter-spacing-1 float-right">Les séparer par un point virgule</small>

            </label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                    <span class="fas fa-school"></span>
                </div>
                <input wire:model.live='school' type="text" id="register-school" aria-describedby="helper-text-register-school" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Renseignez lycées en les séparant par un point virgule" required />
            </div>
            @error('school')
            <p id="helper-text-register-school" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
              {{$message }}
            </p>
            @enderror
            
          </div>
        </div>
        <div class="grid grid-cols-5 gap-x-2">
            <a href="#" wire:click='goToTheGraduateForm' wire:loading.class='opacity-50' wire:target='goToTheGraduateForm' class=" cursor-pointer py-3 px-4 col-span-2 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gray-500 text-white hover:bg-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                <span wire:loading.remove wire:target='goToTheGraduateForm'>
                    <span class="fas fa-hand-point-left"></span>
                    <span>En arrière</span>
                </span>
                <span wire:loading wire:target='goToTheGraduateForm'>
                  <span class="fa animate-spin fa-rotate"></span>
                  Chargement en cours...
                </span>
            </a>

            <a href="#" wire:click='initProfessionnalDataInsertion' wire:loading.class='opacity-50' wire:target='initProfessionnalDataInsertion' class=" cursor-pointer py-3 px-4 col-span-3 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                <span wire:loading.remove wire:target='initProfessionnalDataInsertion'>
                  <span>Suivant</span>
                  <span class="fas fa-hand-point-right"></span>
        
                </span>
                <span wire:loading wire:target='initProfessionnalDataInsertion'>
                  <span class="fa animate-spin fa-rotate"></span>
                  Traitement en cours...
                </span>
            </a>
        </div>
      </form>
      
    </div>
  </div>
