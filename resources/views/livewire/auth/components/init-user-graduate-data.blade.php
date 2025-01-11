<div class="w-full p-0 m-0">

    <div class="p-0 m-0 mb-4">
      
      <div class="text-center">
        <h5 class="letter-spacing-1 flex flex-col gap-y-2 text-gray-200">
          <span class="uppercase inline-block w-full pb-2">
            inscription
            <span>2/4</span>
        </span>
          <span wire:loading.remove wire:target='initGraduateDataInsertion' class="inline-block w-full py-2 border-y">
            <span class="text-green-600 font-semibold letter-spacing-1 border-b border-green-500 mb-2 inline-block">
              Insertion des donnée liées au diplôme
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
      <div wire:loading wire:target='initGraduateDataInsertion' class="text-center w-full mx-auto my-3">
        <h5 class="w-full bg-success-400 text-gray-900 border rounded-xl p-3 letter-spacing-2 border-r-gray-800 border-gray-900">
          <span class="fa animate-spin fa-rotate"></span>
          Traitement en cours...
        </h5>
      </div>
    </div>
  
    <div class="my-7">
  
    </div>
  
    <div class="mt-4">
      <form class="mx-auto mt-4 shadow-2 p-3" autocomplete="false">
        
        <div class="relative z-0 w-full mb-5 group text-gray-400">
          <label for="register-grade" class="block mb-1 text-sm font-medium text-gray-400">Votre grade</label>
          <div class="relative">
              <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                  <span class="fas fa-user-graduate"></span>
              </div>
              <input wire:model='grade' type="text" id="register-grade" aria-describedby="helper-text-register-grade" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Votre grade" required />
          </div>
          @error('grade')
          <p id="helper-text-register-grade" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
            {{ $message }}
          </p>
          @enderror
        </div>
        <div class="grid md:grid-cols-2 md:gap-6">
          <div class="relative z-0 w-full mb-5 text-gray-400 group ">
            <label for="register-status" class="block mb-1 text-sm font-medium text-gray-400">Votre status</label>
            <select aria-describedby="helper-text-register-status" wire:model='status' id="register-status" class="bg-inherit border border-gray-300 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
              <option class="z-bg-secondary-light-opac" value="{{null}}">Votre status</option>
              @foreach ($teachers_statuses as $sk => $s)
                <option class="z-bg-secondary-light-opac" value="{{$s}}">{{$s}}</option>
              @endforeach
            </select>
            @error('status')
            <p id="helper-text-register-status" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
              {{ $message }}
            </p>
            @enderror
          </div>
          <div class="relative z-0 w-full mb-5 text-gray-400 group ">
            <label for="register-graduate" class="block mb-1 text-sm font-medium text-gray-400">Votre diplôme</label>
            <select aria-describedby="helper-text-register-graduate" wire:model.live='graduate' id="register-graduate" class="bg-transparent border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500">
              <option class="z-bg-secondary-light-opac" value="{{null}}">Votre diplôme</option>
              @foreach ($teachers_graduates as $grk => $gr)
                <option class="z-bg-secondary-light-opac" value="{{$gr}}">{{$gr}}</option>
              @endforeach
            </select>
            @error('graduate')
            <p id="helper-text-register-graduate" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
              {{ $message }}
            </p>
            @enderror
          </div>
          
        </div>
  
        <div class="grid md:grid-cols-2 md:gap-6">
          <div class="relative z-0 w-full mb-5 text-gray-400 group ">
            <label for="register-graduate_type" class="block mb-1 text-sm font-medium text-gray-400">Type de diplôme</label>
            <select aria-describedby="helper-text-register-graduate_type" wire:model='graduate_type' id="register-graduate_type" class="bg-inherit border border-gray-300 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
              <option class="z-bg-secondary-light-opac" value="{{null}}">Préciser le type de votre diplôme le plus haut</option>
              @foreach ($teachers_graduate_types as $grtk => $grt)
                <option class="z-bg-secondary-light-opac" value="{{$grt}}">{{$grt}}</option>
              @endforeach
            </select>
            @error('graduate_type')
            <p id="helper-text-register-graduate_type" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
              {{ $message }}
            </p>
            @enderror
          </div>
          <div class="relative z-0 w-full mb-5 text-gray-400 group ">
            <label for="register-graduate_year" class="block mb-1 text-sm font-medium text-gray-400">Année d'obtention</label>
            <select aria-describedby="helper-text-register-graduate_year" wire:model='graduate_year' id="register-graduate_year" class="bg-inherit border border-gray-300 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
              <option class="z-bg-secondary-light-opac" value="{{null}}">Préciser l'Année d'obtention du diplôme
                 </option>
                 
              @foreach ($years as $y)
                <option class="z-bg-secondary-light-opac" value="{{$y}}">{{$y}}</option>
              @endforeach
            </select>
            @error('graduate_year')
            <p id="helper-text-register-graduate_year" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
              {{ $message }}
            </p>
            @enderror
          </div>
          
        </div>
  
        <div class="grid md:gap-6">
          <div class="relative z-0 w-full mb-5 group text-gray-400">
            <label for="register-graduate_deliver" class="block mb-1 text-sm font-medium text-gray-400">Renseignez l'instance ayant délivrée le diplôme</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                    <span class="fas fa-school"></span>
                </div>
                <input wire:model.live='graduate_deliver' type="text" id="register-graduate_deliver" aria-describedby="helper-text-register-graduate_deliver" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Renseignez l'instance ayant délivrée le diplôme" required />
            </div>
            @error('graduate_deliver')
            <p id="helper-text-register-graduate_deliver" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
              {{ $message }}
            </p>
            @enderror
            
          </div>
        </div>
        <div class="grid grid-cols-5 gap-x-2">
            <a href="#" wire:click='goToThePersoForm' wire:loading.class='opacity-50' wire:target='goToThePersoForm' class=" cursor-pointer py-3 px-4 col-span-2 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-gray-500 text-white hover:bg-gray-500 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                <span wire:loading.remove wire:target='goToThePersoForm'>
                    <span class="fas fa-hand-point-left"></span>
                    <span>En arrière</span>
                </span>
                <span wire:loading wire:target='goToThePersoForm'>
                  <span class="fa animate-spin fa-rotate"></span>
                  Chargement en cours...
                </span>
            </a>

            <a href="#" wire:click='initGraduateDataInsertion' wire:loading.class='opacity-50' wire:target='initGraduateDataInsertion' class=" cursor-pointer py-3 px-4 col-span-3 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                <span wire:loading.remove wire:target='initGraduateDataInsertion'>
                  <span>Suivant</span>
                  <span class="fas fa-hand-point-right"></span>
        
                </span>
                <span wire:loading wire:target='initGraduateDataInsertion'>
                  <span class="fa animate-spin fa-rotate"></span>
                  Traitement en cours...
                </span>
            </a>
        </div>
      </form>
      
    </div>
  </div>
