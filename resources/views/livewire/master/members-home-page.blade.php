<div>
    <div class="m-auto border rounded my-1 w-4/5 z-bg-secondary-light-opac min-h-80 p-2">
        <div class="my-2 p-3 w-full">
            <h4 class="text-lg text-gray-400 text-right border-b pb-2 border-gray-400">Bienvenue sur la page de l'association</h4>
        </div>
        <div class="w-full my-2 p-2 gap-2 items-center grid grid-cols-5">
            <div class="flex mr-2 rounded-full lg:col-span-2 md:col-span-2 sm:col-span-5 xs:col-span-5">
                <img src="{{user_profil_photo(auth_user())}}" alt="" class="xs:w-16 xs:h-16  lg:w-52 lg:h-52 shadow-3 shadow-sky-500 rounded-full">
            </div>
            <div class="lg:col-span-3 md:col-span-3 lg:text-base sm:col-span-5 sm:text-xs xs:col-span-5 xs:text-xs">
                <div class="flex gap-1 text-center justify-center">
                    <span class="border hover:bg-blue-700 cursor-pointer bg-blue-400 text-gray-50 rounded-xl py-2 px-3">
                        Les membres
                    </span>
                    <span class="border hover:bg-blue-700 cursor-pointer bg-blue-400 text-gray-50 rounded-xl py-2 px-3">
                        Communiqués
                    </span>
                    <span class="border hover:bg-blue-700 cursor-pointer bg-blue-400 text-gray-50 rounded-xl py-2 px-3">
                        Règlements intérieurs
                    </span>
                    <span class="border hover:bg-blue-700 cursor-pointer bg-blue-400 text-gray-50 rounded-xl py-2 px-3">
                        Les membres
                    </span>
                </div>
            </div>
        </div>
        <div>
            @livewire('master.members-profil-component')
        </div>
    </div>
</div>
