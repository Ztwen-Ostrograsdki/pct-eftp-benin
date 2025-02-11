<div>
    <div class="m-auto border rounded my-1 lg:w-full z-bg-secondary-light-opac min-h-80 p-2">
        <div class="my-2 p-3 w-full">
            <h4 class="text-lg text-gray-400 text-right border-b pb-2 border-gray-400">Bienvenue sur la page de l'association</h4>
        </div>
        <div class="w-full my-2 p-2 gap-2 items-center grid grid-cols-5">
            <div class="flex mr-2 rounded-full lg:col-span-2 md:col-span-2 sm:col-span-5 xs:col-span-5">
                <img src="{{asset(env('APP_LOGO'))}}" alt="" class="xs:w-16 xs:h-16  lg:w-52 lg:h-52 shadow-3 shadow-sky-500 rounded-full">
            </div>
            <div class="lg:col-span-3 md:col-span-3 lg:text-sm sm:col-span-5 sm:text-xs xs:col-span-5 xs:text-xs">
                <div class="flex flex-wrap gap-2 text-center justify-start">
                    @foreach($member_sections as $section => $sec_title)
                    <span wire:click="$set('member_section', '{{$section}}')" class="border hover:bg-blue-600 cursor-pointer @if($member_section == $section) shadow-2 shadow-sky-400 bg-blue-800 @endif bg-blue-400 text-gray-50 rounded-xl py-2 px-3">
                        {{$sec_title}}
                    </span>
                    @endforeach
                    @if(__isAdminAs())
                    <button title="Ajouter un nouveau membre à l'association" data-modal-target="new-member-modal" data-modal-toggle="new-member-modal" type="button" class="border cursor-pointer bg-blue-500 text-gray-100 rounded-xl hover:bg-blue-700 float-right px-2 py-2 block focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm  text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <span>Ajouter un membre</span>
                        <span class="fas fa-plus hover:animate-spin"></span>
                    </button>
    
                    <button title="Ajouter une nouvelle fonction de membre à l'association" data-modal-target="new-role-modal" data-modal-toggle="new-role-modal" type="button" class="border cursor-pointer bg-green-500 text-gray-100 rounded-xl hover:bg-green-700 float-right px-2 py-2 block focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium text-sm  text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-blue-800">
                        <span>Ajouter un role</span>
                        <span class="fas fa-plus hover:animate-spin"></span>
                    </button>
                    @endif
                </div>
            </div>
        </div>
        <div>
            @if($member_section == 'members')
                <div>
                    @livewire('master.members-profil-component', ['is_included' => true])
                </div>
            @elseif($member_section == "members-list")
                <div>
                    @livewire('master.members-list-page')
                </div>
            @elseif($member_section == "users-list")
                <div>
                    @livewire('master.users-list-page')
                </div>
            @elseif($member_section == "roles")
                <div>
                    @livewire('master.roles-list-page')
                </div>
            @elseif($member_section == "epreuves")
                <div>
                    @livewire('master.epreuves-list-page')
                </div>
            @elseif($member_section == "subjects")
                <div>
                    @livewire('master.forum-chat-subjects-list')
                </div>
            @elseif($member_section == "laws")
                <div>
                    @livewire('master.laws-page')
                </div>
            @endif
        </div>
    </div>
</div>
