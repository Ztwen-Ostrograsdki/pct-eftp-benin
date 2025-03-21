<div class="my-2 mx-auto py-3 px-0 w-3/5 border border-gray-500 rounded-md shadow-3" wire:loaded.class='shadow-sky-500' wire:loading.class='shadow-green-500' wire:target="sendCardToMember('{{$member->id}}')">

    <div class="text-center w-full mx-auto my-4 px-3">
        <h6 class="letter-spacing-2 flex flex-col items-center gap-y-1">
            <div class="text-sky-400 flex items-center gap-x-32">
                <img src="{{asset(env('APP_LOGO'))}}" alt="" class="xs:w-16 xs:h-16  lg:w-16 lg:h-16 shadow-3 shadow-sky-500 rounded-full">
                <span class="flex flex-col font-bold">
                    <span>
                        Carte de membre
                    </span>  
                    <small class="text-orange-400 letter-spacing-1">
                        {{ env('APP_NAME') }}
                    </small>
                </span>
                <img src="{{asset(env('APP_LOGO'))}}" alt="" class="xs:w-16 xs:h-16  lg:w-16 lg:h-16 shadow-3 shadow-sky-500 rounded-full">
            </div>
        </h6>
        <hr class="text-gray-500 bg-gray-500 my-2 ">
    </div>

    @php
        $user = $member->user;
    @endphp

    <div class="grid grid-cols-5 gap-x-2 items-center">
        <div class="col-span-3 text-right">
            <h1 class="text-sky-400 text-3xl font-bold letter-spacing-1">
                {{ $user->getFullName(true) }}
            </h1>
            <h6 class="bg-blue-800 text-gray-400 font-bold letter-spacing-1 p-1">
                {{ $member->role->name }}
            </h6>

            <div class="flex flex-col text-start w-3/5 mx-auto text-sky-400 letter-spacing-1 font-semibold">
                <h6>
                    <span class="fas fa-phone"></span>
                    <span>
                        {{ $user->contacts }}
                    </span>
                </h6>

                <h6>
                    <span class="fas fa-envelope"></span>
                    <span>
                        {{ $user->email }}
                    </span>
                </h6>

                <h6>
                    <span class="fas fa-home"></span>
                    <span>
                        {{ Str::upper($user->address) }}
                    </span>
                </h6>
                
                <h6>
                    <span class="fab fa-codepen"></span>
                    <span>
                        {{ $user->identifiant }}
                    </span>
                </h6>
            </div>
        </div>

        <div class="col-span-2 mr-3 flex flex-col gap-y-3 items-center mb-4">
            <img class="w-60 h-52 mx-auto border shadow-lg" src="{{ user_profil_photo($user) }}" alt="Photo de profil de {{ $user->getFullName() }}"/>

            <h6 class="text-orange-500 letter-spacing-1 font-sans italic">
                Signature impétrant
            </h6>
        </div>
    </div>

    <div class="mx-auto w-full text-center my-7">
        <h1 class="text-sky-400 text-3xl font-bold letter-spacing-1">
            {{ $user->identifiant }}
        </h1>
    </div>

    <h6 class="text-yellow-500 letter-spacing-1 font-sans text-xs text-right px-4">
        Cette carte expirera le 22 Janv 2026
    </h6>
</div>
