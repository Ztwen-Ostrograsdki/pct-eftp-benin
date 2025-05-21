<div>
    <section class="py-14">
        <div class="w-full px-4 py-6 mx-auto lg:py-4 md:px-6 z-bg-secondary-light-opac border rounded my-1">
            <div class="m-auto  p-0 my-3 font-semibold">
                <h1 class="p-4 text-gray-300 flex justify-between border uppercase rounded-sm">
                    <span class="lg:text-sm letter-spacing-2 sm:text-xs xs:text-xs">
                        <span class="">
                            Administration :
                        </span>
        
                        <strong class="text-gray-200">
                            Gestion des postes disponibles au sein de l'association 
                            @if ($roles)
                            <br>
                            <small class="text-orange-600"> {{ numberZeroFormattor(count($roles)) }} Postes actifs</small>
                            @endif
                        </strong>
                    </span>
    
                    <div class="flex gap-x-2 lg:text-sm items-center letter-spacing-2 sm:text-xs xs:text-xs">
                        <span wire:click="refreshAllPosts" class="text-gray-200 font-semibold px-3 py-3 cursor-pointer hover:bg-red-500 letter-spacing-1 rounded-lg border bg-red-700">
                            <span wire:loading.remove wire:target='refreshAllPosts'>
                                <span class="fas fa-trash"></span>
                                <span>Rafraichir tous les postes occupés</span>
                            </span>
                            <span wire:loading wire:target='refreshAllPosts'>
                                <span class="fas fa-rotate animate-spin"></span>
                                <span>Opération en cours...</span>
                            </span>
                        </span>
                    </div>
                </h1>
            </div>
          
            @if($roles)
                <div class="grid gap-6 md:grid-cols-3  sm:grid-cols-1 ">
                @foreach($roles as $key => $role)
                    <div class="">
                        @php
                            $user = null;

                            if($role->member && $role->member->user) $user = $role->member->user;

                        @endphp
                        <div class="p-0 pb-3 bg-inherit border rounded-md shadow-3 shadow-sky-400">
                            
                            <h2 class="lg:text-2xl md:text-base xs:text-lg font-semibold text-gray-900 dark:text-gray-300 hover:text-blue-500 w-full text-center border-b flex items-center justify-center pb-2 mb-2 z-bg-secondary-light-opac py-2">
                                {{ $role->name }}
                            </h2>
                            
                            <div class=" pb-4 mb-1 w-full">
                                @if($role->member)
                                <h5 class="text-center w-full text-gray-400">
                                    Poste actuellement occupé par 
                                </h5>
                                <a wire:navigate href="{{route('member.profil', ['identifiant' => $role->member->user->identifiant])}}" class="rounded-full text-center mx-auto w-full flex justify-center">
                                    <img src="{{user_profil_photo($role->member->user)}}" alt="" class="object-cover w-12 h-12 shadow-2 shadow-green-500 rounded-full">
                                </a>
                                
                                <a wire:navigate href="{{route('member.profil', ['identifiant' => $role->member->user->identifiant])}}" class="flex justify-center w-full px-6 mb-2 md:mb-0 hover:text-blue-500">
                                    <div class="flex flex-col justify-center">
                                        <p class="lg:text-lg xs:text-xs md:text-base text-gray-500 dark:text-gray-400 hover:text-blue-500">
                                            <span class="text-yellow-400">{{ auth_user_fullName(true, $role->member->user) }}</span>
                                        </p>
                                        
                                    </div>
                                </a>
                                
                                <div class="w-full flex justify-end">
                                    <p class="text-xs  w-full  text-gray-600 dark:text-yellow-400 px-2 py-2">
                                        <span class="flex flex-col gap-y-2 letter-spacing-2 text-right w-full pb-2">
                                            <span class="text-orange-200">
                                                <span class="fas fa-envelope"></span>
                                                <span>{{ $role->member->user->email }}</span>
                                            </span>
                                            <span class="text-orange-200">
                                                <span class="fas fa-phone"></span>
                                                <span>{{ $role->member->user->contacts ? $role->member->user->contacts : 'non renseigné' }}</span>
                                            </span>
                                            <span class="text-orange-200">
                                                <span class="fas fa-home"></span>
                                                <span>
                                                    {{ $role->member->user->current_function ? $role->member->user->current_function : 'non renseigné' }}
                                                    <span class="text-orange-500">
                                                        à {{ $role->member->user->school ? $role->member->user->school : 'non renseigné' }}
                                                    </span>
                                                    <span class="text-orange-400">
                                                        sis à {{ $role->member->user->job_city ? $role->member->user->job_city : 'non renseigné' }}
                                                    </span>
                                                </span>
                                            </span>
                                        </span>
                                    </p>
                                </div>
                                @else
                                <div class="mx-auto m-0 p-2">
                                    <h5 class="w-full m-0 mx-auto flex gap-2 text-center lg:text-lg md:text-base text-orange-400 letter-spacing-2 py-2 border-gray-500 bg-transparent animate-pulse items-center justify-center">
                                        <span class="fas fa-warning"></span>
                                        Poste non occupé
                                        <span class="fas fa-warning"></span>
                                    </h5>
                                </div>
                                @endif

                                <div class="mx-auto w-full flex gap-x-2 px-3 my-0 py-0 font-semibold letter-spacing-1 text-gray-200 lg:text-sm md:text-sm sm:text-sm xs:text-xs">
                                    @if( __isAdminAs())
                                        <h6>
                                            <span wire:click="$dispatch('OpenRoleModalForEditEvent', {role_id: {{$role->id}}})"  class="block cursor-pointer px-2 py-1 bg-gray-600 rounded-md hover:bg-gray-700 ">Editer</span>
                                        </h6>
                                        @if($role->member)
                                            <h6>
                                                <span wire:click="$dispatch('OpenModalToChangeTheMemberOfThisRoleEvent', {role_id: {{$role->id}}})" class="block cursor-pointer px-2 py-1 bg-gray-600 rounded-md hover:bg-gray-700 ">Modifier membre</span>
                                            </h6>
                                        @else
                                        <h6>
                                            <span wire:click="$dispatch('OpenModalToChangeTheMemberOfThisRoleEvent', {role_id: {{$role->id}}})" class="block cursor-pointer px-2 py-1 bg-gray-600 rounded-md hover:bg-gray-700 ">Choisir le membre</span>
                                        </h6>
                                        @endif
                                        @if($role->member && __isAdminAs())
                                            <h6>
                                                <span wire:click="resetMemberRoleToNull('{{$role->member->id}}')" class="block cursor-pointer px-2 py-1 bg-red-600 rounded-md hover:bg-red-700 ">Supprimer</span>
                                            </h6>
                                            <h6>
                                                <span wire:click="confirmedUserBlockOrUnblocked('{{$role->member->user->id}}')" class="block cursor-pointer px-2 py-1 bg-gray-600 rounded-md hover:bg-gray-700 ">
                                                    {{ $user->blocked ? "DéBloquer" : "Bloquer" }}
                                                </span>
                                            </h6>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="mx-auto m-0 p-2">
                                <h5 class="w-full m-0 flex items-center justify-between px-2 mx-auto text-center text-xs lg:text-lg  text-orange-400 letter-spacing-2 py-2 border-b border-t border-gray-500 z-bg-secondary-light">

                                    <span>
                                        Les prérogatives du {{ $role->name }}
                                    </span>

                                    <span wire:click="addNewTaskToRole({{$role->id}})" title="Editer les prérogatives à la fonction {{$role->name}}" class="float-right border bg-blue-600 hover:bg-blue-800 text-gray-50 rounded-full cursor-pointer text-xs lg:text-sm p-1">
                                        <span  wire:loading.remove wire:target="addNewTaskToRole({{$role->id}})" wire:target="removeFromTasks({{$role->id}})" class="">
                                            <span class="">Editer</span>
                                            <span class="fa fa-edit"></span>
                                        </span>

                                        <span wire:loading wire:target="addNewTaskToRole({{$role->id}})" class="text-yellow-500">
                                            <span>...</span>
                                            <span class="fa fa-rotate animate-spin"></span>
                                        </span>
                                    </span>

                                </h5>
                            </div>
                            <div class="flex w-full items-center text-center mx-auto">
                                <ul class="flex w-full flex-wrap gap-2 ml-3">
                                    @foreach ($role->tasks as $k => $task)
                                    <li class="ucfirst xs:text-xs lg:text-sm border shadow-2 shadow-sky-500 rounded-full p-1 text-left text-gray-300"> 
                                        <span class="fas fa-circle text-orange-500"></span>
                                        <span>{{ $task }}</span>
                                        <span wire:key='{{$k}}' class="">
                                            <span wire:click="removeFromTasks('{{$role->id}}', '{{str_replace("'", "@", $task)}}')" title="Retirer la tâche {{$task}}" class="fas fa-trash mx-2 cursor-pointer text-red-500"></span>
                                        </span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="flex flex-wrap mt-2 justify-between pt-4 border-t dark:border-gray-700">
                                <div class="flex px-6 mb-2 md:mb-0">
                                <ul class="flex items-center justify-start mr-4">
                                    <li>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 mr-1 text-blue-500 dark:text-blue-900 bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                        </path>
                                        </svg>
                                    </a>
                                    </li>
                                    <li>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 mr-1 text-blue-500 dark:text-blue-700 bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                        </path>
                                        </svg>
                                    </a>
                                    </li>
                                    <li>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 mr-1 text-blue-500 dark:text-blue-500 bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                        </path>
                                        </svg>
                                    </a>
                                    </li>
                                    <li>
                                    <a href="#">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="w-4 mr-1 text-blue-500 dark:text-blue-300 bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z">
                                        </path>
                                        </svg>
                                    </a>
                                    </li>
                                </ul>
                                <h2 class="text-sm text-gray-500 dark:text-gray-400">

                                </h2>
                                </div>
                                <div class="flex items-center px-6 space-x-1 text-sm font-medium text-gray-500 dark:text-gray-400">
                                @if($role->member)
                                <div class="flex items-center">
                                    <div class="flex text-sm text-gray-700 dark:text-gray-400">
                                        <a href="#" class="inline-flex hover:underline text-xs font-medium text-gray-600 dark:text-yellow-400">
                                        Poste occupé depuis le {{$role->member->user->__getDateAsString($role->created_at)}}
                                        </a>
                                    </div>
                                </div>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            @else
                <h4 class="w-full animate-pulse text-center py-4 border rounded-lg bg-red-300 text-red-600 text-base text-cursive">
                    <span class="fas fa-trash"></span>
                    <span>Oupps aucune données trouvées!!!</span>
                </h4>
            @endif
        </div>
    </section>
</div>
