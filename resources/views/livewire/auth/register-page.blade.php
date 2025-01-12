<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto shadow-3 shadow-sky-500 rounded-xl my-5">
    <div class="flex h-full items-center">
      <main class="w-full max-w-xl mx-auto py-6">
        <div class=" my-2 mx-auto">
          @if(!$to_confirm_data)
            <div class="mx-auto w-full mt-3 flex justify-center" wire:click="$dispatch('UpdateSectionInsertion', {section: 'confirmed'})" >
              <a href="#" class="py-3 w-full px-4 xl:text-sm lg:text-sm md:text-sm sm:text-xs xs:text-xs font-medium focus:outline-none rounded-xl border  focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 bg-gray-800 hover:bg-slate-600 text-gray-200 text-center hover:text-gray-950">
                <span class="fas fa-recycle mr-2"></span>
                  Charger la page de confirmation des données
                  <span>
                    <span class=" fas fa-chevron-right ml-3"></span>
                  </span>
              </a>
            </div>
          @endif
        </div>
        <div class="bg-white border border-gray-200 rounded-xl z-bg-secondary-light-opac dark:border-gray-700 py-6 px-5 shadow-4 shadow-sky-500 w-full mx-auto">
            
            <!-- Form -->
            @if($is_perso_data_insertion)
              @livewire('auth.components.init-user-perso-data')
            @elseif($is_graduate_data_insertion)
              @livewire('auth.components.init-user-graduate-data')
            @elseif($is_professionnal_data_insertion)
              @livewire('auth.components.init-user-professionnal-data')
            @elseif($is_password_data_insertion)
              @livewire('auth.components.set-user-profil-photo-and-password-data')
            @elseif($to_confirm_data)
              @livewire('auth.components.validate-user-data-subscription')
            @endif
            <!-- End Form -->
          </div>
        </div>
    </div>
  </div>