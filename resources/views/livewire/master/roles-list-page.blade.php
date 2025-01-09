<div>
    <section class="py-14 font-poppins">
        <div class="max-w-6xl px-4 py-6 mx-auto lg:py-4 md:px-6">
          <div class="max-w-xl mx-auto">
            <div class="text-center ">
              <div class="relative flex flex-col items-center">
                <h1 class="text-xl font-bold dark:text-gray-200 "> 
                    Les Postes disponibles de 
                    <span class="text-blue-500">l'association</span> 
                </h1>
                <div class="flex w-96 mt-2 mb-6 overflow-hidden rounded">
                  <div class="flex-1 h-2 bg-blue-200"></div>
                  <div class="flex-1 h-2 bg-blue-400"></div>
                  <div class="flex-1 h-2 bg-blue-600"></div>
                </div>
              </div>
              <p class="mb-12 text-base text-center text-gray-500">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Delectus magni eius eaque?
                Pariatur
                numquam, odio quod nobis ipsum ex cupiditate?
              </p>
            </div>
          </div>
          
            @if($roles)
                <div class="grid gap-6 md:grid-cols-2  sm:grid-cols-1 ">
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
                            <div class="flex justify-end pr-2">
                                <button id="dropdownButton-from-role-{{$role->id}}" data-dropdown-toggle="dropdown-from-role-{{$role->id}}" class="inline-block border text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                                    <span class="sr-only">Open dropdown</span>
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                                        <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                                    </svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div id="dropdown-from-role-{{$role->id}}" class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-56 dark:bg-gray-700">
                                    <ul class="py-2" aria-labelledby="dropdownButton-from-role-{{$role->id}}">
                                        @if( __isAdminAs())

                                            <li>
                                                <a wire:click="$dispatch('OpenRoleModalForEditEvent', {role_id: {{$role->id}}})" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Editer cette fonction</a>
                                            </li>
                                            @if($role->member)
                                                <li>
                                                    <a href="#" wire:click="$dispatch('OpenMemberModalForEditEvent', {role_id: {{$role->id}}})" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Choisir un nouveau membre</a>
                                                </li>
                                            @endif
                                        @endif
                                        @if($role->member)
                                        <li>
                                            <a href="{{route('user.profil', ['identifiant' => $user->identifiant])}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profil utilisateur</a>
                                        </li>
                                        @else
                                        <li>
                                            <a href="#" title="Ajouter un nouveau membre à l'association" wire:click="$dispatch('OpenMemberModalForEditEvent', {role_id: {{$role->id}}})" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Choisir le nouveau {{$role->name}}</a>
                                        </li>
                                        @endif
                                        @if($role->member && __isAdminAs())
                                            <li>
                                                <a wire:click="removeUserFormMembers('{{$role->member->id}}')" href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Supprimer</a>
                                            </li>
                                            <li>
                                                <a wire:click="confirmedUserBlockOrUnblocked('{{$role->member->user->id}}')" href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                                    {{ $user->blocked ? "DéBloquer" : "Bloquer" }}
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                                
                            </div>
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
            @else
                <h4 class="w-full animate-pulse text-center py-4 border rounded-lg bg-red-300 text-red-600 text-base text-cursive">
                    <span class="fas fa-trash"></span>
                    <span>Oupps aucune données trouvées!!!</span>
                </h4>
                </div>
            @endif
        </div>
    </section>
</div>
