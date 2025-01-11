<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto shadow-3 shadow-sky-500 rounded-xl my-5">
    <div class="flex h-full items-center">
      <main class="w-full max-w-xl mx-auto py-6">
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
            @endif
            <!-- End Form -->
          </div>
        </div>
    </div>
  </div>