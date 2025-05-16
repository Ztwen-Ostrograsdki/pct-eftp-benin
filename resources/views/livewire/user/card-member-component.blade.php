<div>
    <div class="mx-auto shadow-3 shadow-sky-600 rounded-lg  my-3 lg:w-4/6 xl:w-4/6 2xl:w-4/6 w-11/12 p-2 m-2 z-bg-secondary-light">
        @if($member)
        <h1 class="p-4 text-gray-300 flex items-center justify-between uppercase text-center">
            <span class="text-xs letter-spacing-2 flex flex-col gap-y-1">
                <strong class="text-sky-400">
                    Carte de membre  
                </strong>
                <small class="text-orange-400 letter-spacing-1">
                    {{ $member->role->name }}
                </small>
            </span>
    
            
                @php
                    
                    $user = $member->user;
                
                @endphp
                <div class="flex flex-col items-center">
                    <img class="w-16 h-16 mb-3 rounded-full shadow-lg" src="{{ user_profil_photo($user) }}" alt="Photo de profil de {{ $user->getFullName() }}"/>
                    <h6 class="mb-1 text-sm font-medium text-gray-900 dark:text-white">
                        {{ $user->getFullName(true) }}
                    </h6>
                    <span class="text-sm text-yellow-500 letter-spacing-2 dark:text-yellow-400">
                        <span class="fas fa-envelope"></span>
                        <span>{{ $user->email }}</span>
                    </span>
                </div>
            
        </h1>

        @include('pdftemplates.card', [
            'reverse_name' => $user->getFullName(true),
            'name' => $user->getFullName(false),
            'email' =>  $user->email,
            'identifiant' =>  $user->identifiant,
            'address' =>  Str::upper($user->address),
            'role' =>  $user->member->role->name,
            'photo' =>  user_profil_photo($user),
            'contacts' =>  $user->contacts,

        ])

        {{-- @livewire('user.card-module', ['member' => $member, 'identifiant' => $identifiant]) --}}

        <div class="mx-auto my-4 text-gray-300 font-bold letter-spacing-1 text-center flex items-center justify-center w-3/5  sm:text-sm sm:font-semibold xs:text-xs xs:font-semibold">
            <span wire:click="generateCardMember('{{$member->id}}')" class="bg-sky-800 hover:bg-sky-900 py-2 px-3 border rounded-lg cursor-pointer w-full">
                <span wire:loading.remove wire:target="generateCardMember('{{$member->id}}')">
                    <span class="lg:inline">Générer et envoyer la carte</span>
                    <span class="fa fa-book"></span>
                </span>
                <span wire:loading wire:target="generateCardMember('{{$member->id}}')">
                    <span>En cours...</span>
                    <span class="fas fa-rotate animate-spin"></span>
                </span>
            </span>
        </div>
        @endif
    </div>
</div>
