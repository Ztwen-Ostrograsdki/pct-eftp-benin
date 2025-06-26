<div>
    <div class="w-full mt-3">
        <div>
            <div class="max-w-4xl mx-auto xs:px-2 xs:text-base my-16">
                <h3 class="font-bold text-center library-option-li-card border-y border-gray-600 border-2 text-3xl flex justify-center items-center letter-spacing-1 py-2 text-gray-800 uppercase bg-zinc-500" >
                    A propos de {{ env('APP_NAME') }}
                </h3>
                <span class="block home-element mx-auto font-semibold letter-spacing-1 text-gray-950 text-center">
                    {{ env('APP_FULL_NAME') }}
                </span>
                <div class="flex flex-col gap-y-1 w-full my-3">
                    <hr class="border-red-600 w-full border-2 home-element">
                    <hr class="border-yellow-600 w-full border-2 home-element">
                    <hr class="border-green-600 w-full border-2 home-element">
                </div>
                <div class="font-semibold letter-spacing-1 text-gray-900 lg:text-lg xl:text-lg md:text-base sm:text-sm xs:text-xs my-3">
                    <div class="my-3 text-lg text-center z-bg-secondary-light-opac letter-spacing-2 py-2 text-sky-500 shadow-lg shadow-sky-800 rounded-2xl association-objectives-card mb-7 uppercase">
                        <span>Apperçu de {{ env('APP_NAME') }}</span>
                    </div>
                    <ul class="flex flex-col gap-y-4 font-normal">
                        <li class="library-option-li-card shadow-md flex items-center z-bg-secondary-light shadow-green-500 text-gray-100 p-3">
                            <span class="fas fa-circle-check text-green-600 mr-2"></span>
                            <span>
                                L’<strong>Association des Enseignants de Sciences Physiques du sous-secteur de l’Enseignement et de la Formation Techniques et Professionnels (AESP-EFTP)</strong> est une organisation apolitique, à but non lucratif, créée le 4 juillet 2021.
                            </span>
                        </li>
                        <li class="library-option-li-card shadow-md flex items-center z-bg-secondary-light shadow-yellow-300 text-gray-100 p-3">
                            <span class="fas fa-circle-check text-yellow-400 mr-2"></span>
                            <span>
                                Elle vise à <strong>renforcer la qualité de l’enseignement des sciences physiques</strong> dans le sous-secteur de l’EFTP, à adapter les contenus pédagogiques aux réalités des programmes en vigueur, et à améliorer les résultats des apprenants.
                            </span>
                        </li>
                        <li class="library-option-li-card shadow-md flex items-center z-bg-secondary-light shadow-purple-700 text-gray-100 p-3">
                            <span class="fas fa-circle-check text-purple-600 mr-2"></span>
                            <span>
                                L’association regroupe les enseignants de sciences physiques de l’EFTP, qui s’engagent activement dans la vie associative et professionnelle, dans un esprit de solidarité, d'innovation et de rigueur scientifique.
                            </span>
                        </li>
                        <li class="library-option-li-card shadow-md flex items-center z-bg-secondary-light shadow-sky-400 text-gray-100 p-3">
                            <span class="fas fa-circle-check text-sky-600 mr-2"></span>
                            <span>
                                Le siège de l’AESP-EFTP est situé à Agla les Pylônes, à Cotonou (Bénin), et l’association fonctionne selon les dispositions de la loi du 1er juillet 1901 et les textes réglementaires en vigueur en République du Bénin.
                            </span>
                        </li>
                        <li class="library-option-li-card shadow-md flex items-center z-bg-secondary-light shadow-indigo-700 text-gray-100 p-3">
                            <span class="fas fa-circle-check text-indigo-600 mr-2"></span>
                            <span>
                                Son logo, une lampe électrique allumée entourée du sigle « AESP-EFTP », symbolise la lumière que la science physique apporte dans le domaine de l’enseignement technique et professionnel.
                            </span>
                        </li>
                    </ul>
                    <div class="text-center font-semibold library-option-li-card mt-4 text-gray-950">
                        <span class="text-base">Le logo de l'{{ env('APP_NAME') }} </span>
                        <div class="flex items-center justify-center mt-2">
                            <img class="inline-block border-gray-950 border-2" src="{{ asset(env('APP_LOGO')) }}" alt="">
                        </div>
                    </div>

                    <div class="w-full mx-auto my-4">
                        <div class="w-full my-3 mb-6 mx-auto">
                            <div class="text-center ">
                              <div class="relative flex flex-col items-center">
                                <div class="flex w-full mt-2 mb-0 overflow-hidden rounded">
                                  <div class="flex-1 h-2 bg-blue-200"></div>
                                  <div class="flex-1 h-2 bg-blue-400"></div>
                                  <div class="flex-1 h-2 bg-blue-500"></div>
                                  <div class="flex-1 h-2 bg-blue-600"></div>
                                  <div class="flex-1 h-2 bg-blue-700"></div>
                                  <div class="flex-1 h-2 bg-blue-800"></div>
                                  <div class="flex-1 h-2 bg-blue-900"></div>
                                </div>
                              </div>
                              <div class=" my-0 text-center text-gray-200">
                                <div class="my-3 text-lg z-bg-secondary-light-opac letter-spacing-2 py-2 text-sky-500 shadow-lg shadow-sky-800 rounded-2xl association-objectives-card">
                                    <span>NOS OBJECTIFS</span>
                                </div>
                                <div class="text-gray-100 text-left py-3">
                                    @include('pdftemplates.aesp-objectives-template')
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="flex w-full flex-row-reverse mt-2 mb-0 overflow-hidden rounded">
                            <div class="flex-1 h-2 bg-blue-200"></div>
                            <div class="flex-1 h-2 bg-blue-400"></div>
                            <div class="flex-1 h-2 bg-blue-500"></div>
                            <div class="flex-1 h-2 bg-blue-600"></div>
                            <div class="flex-1 h-2 bg-blue-700"></div>
                            <div class="flex-1 h-2 bg-blue-800"></div>
                            <div class="flex-1 h-2 bg-blue-900"></div>
                        </div>

                    </div>
                    <div class="w-full mx-auto my-4">
                        <div class="my-3 text-lg z-bg-secondary-light-opac letter-spacing-2 py-2 text-center mb-6 text-sky-500 shadow-lg shadow-sky-800 rounded-2xl association-objectives-card">
                            <span>NOS MEMBRES</span>
                        </div>
                        <div class="w-full flex flex-col gap-y-5">
                            @foreach ($members as $member)

                                @php
                                    $user = $member->user;
                                @endphp

                                <div wire:key='defilement-about-us-membre-{{$user->id}}' class="p-6 shadow-lg shadow-gray-600 bg-slate-900 association-objectives-card">
                                    <div class="flex items-center space-x-4 mb-4">
                                        <img src="{{user_profil_photo($user)}}" class="w-24 h-24 rounded-full border-2 border-cyan-700" />
                                        <div>
                                            <h3 class="text-lg font-semibold text-green-500 hover:underline cursor-pointer hover:text-orange-300">
                                            {{ $user->getFullName(true) }}
                                            </h3>
                                            <span class="flex flex-col">
                                                <a href="#" class="text-sm text-cyan-600 hover:underline">
                                                    <span class="fas fa-user-check"></span>
                                                    {{ $member->getMemberRoleName() }}
                                                </a>
                                                <a href="mailto:{{$user->email}}" class="text-sm text-cyan-600 hover:underline">
                                                    <span class="fas fa-envelope"></span>
                                                    {{ $user->email }}
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <blockquote class="text-purple-500 italic border-l-4 border-cyan-600 pl-4">
                                        “{{ $user->getSingleQuote() }}”
                                    </blockquote>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
