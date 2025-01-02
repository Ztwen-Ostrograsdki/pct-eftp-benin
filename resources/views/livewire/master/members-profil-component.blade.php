<div>
    <section class="py-14 font-poppins ">
        <div class="max-w-6xl px-4 py-6 mx-auto lg:py-4 md:px-6">
          <div class="max-w-xl mx-auto">
            <div class="text-center ">
              <div class="relative flex flex-col items-center">
                <h1 class="text-xl font-bold dark:text-gray-200 "> 
                    Les membres de 
                    <span class="text-blue-500">l'association</span> 
                </h1>
                <div class="flex w-40 mt-2 mb-6 overflow-hidden rounded">
                  <div class="flex-1 h-2 bg-blue-200">
                  </div>
                  <div class="flex-1 h-2 bg-blue-400">
                  </div>
                  <div class="flex-1 h-2 bg-blue-600">
                  </div>
                </div>
              </div>
              <p class="mb-12 text-base text-center text-gray-500">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Delectus magni eius eaque?
                Pariatur
                numquam, odio quod nobis ipsum ex cupiditate?
              </p>
            </div>
          </div>
          
            @if($members)
                @foreach($members as $key => $member)
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 ">
                        <div class="py-6 bg-inherit border rounded-md shadow-3 shadow-sky-400">
                        <div class=" pb-4 mb-6 w-full">
                            <a href="{{ route('member.profil', ['identifiant' => $member->user->identifiant]) }}" class="flex items-center px-6 mb-2 md:mb-0 hover:text-blue-500">
                                <div class="flex mr-2 rounded-full">
                                    <img src="{{user_profil_photo($member->user)}}" alt="" class="object-cover w-12 h-12 shadow-2 shadow-green-500 rounded-full">
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-300 hover:text-blue-500">
                                        {{ $member->role->name }}
                                    </h2>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 hover:text-blue-500">
                                        {{ auth_user_fullName(true, $member->user) }}
                                    </p>
                                </div>
                            </a>
                            <div class="w-full flex justify-end">
                                <p class="text-xs  w-full border-b dark:border-gray-700  text-gray-600 dark:text-yellow-400 px-2 py-2">
                                    <span class="flex flex-col gap-y-2 letter-spacing-2 text-right w-full pb-2">
                                        <span class="text-orange-200">
                                            <span class="fas fa-envelope"></span>
                                            <span>{{ $member->user->email }}</span>
                                        </span>
                                        <span class="text-orange-200">
                                            <span class="fas fa-phone"></span>
                                            <span>{{ $member->user->contacts }}</span>
                                        </span>
                                        <span class="text-orange-200">
                                            <span class="fas fa-home"></span>
                                            <span>
                                                {{ $member->user->current_function }}
                                                @if($member->user->school)
                                                <span class="text-orange-500">
                                                    à {{ $member->user->school }}
                                                </span>
                                                    @if($member->user->job_city)
                                                    <span class="text-orange-400">
                                                        sis à {{ $member->user->job_city }}
                                                    </span>
                                                    @endif
                                                @endif
                                            </span>
                                        </span>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <p class="px-6 mb-6 text-base text-gray-500 dark:text-gray-400">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem cupiditate similique,
                            iure minus sed fugit obcaecati minima quam reiciendis dicta!
                        </p>
                        <div class="flex flex-wrap justify-between pt-4 border-t dark:border-gray-700">
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
                            <div class="flex items-center">
                                <div class="flex text-sm text-gray-700 dark:text-gray-400">
                                    <a href="#" class="inline-flex hover:underline text-xs font-medium text-gray-600 dark:text-yellow-400">
                                    Membre depuis le {{$member->user->__getDateAsString($member->created_at)}}
                                    </a>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h4 class="w-full animate-pulse text-center py-4 border rounded-lg bg-red-300 text-red-600 text-3xl text-cursive">
                    <span class="fas fa-trash"></span>
                    <span>Oupps aucune données trouvées!!!</span>
                </h4>
            @endif
        </div>
    </section>
</div>
