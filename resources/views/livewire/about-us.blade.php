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
                <div class="font-semibold letter-spacing-1 text-gray-900 text-lg my-3">
                    <ul class="flex flex-col gap-y-2">
                        <li class="library-option-li-card">
                            <span class="fas fa-circle-check mr-2 text-gray-950"></span>
                            L’<strong>Association des Enseignants de Sciences Physiques du sous-secteur de l’Enseignement et de la Formation Techniques et Professionnels (AESP-EFTP)</strong> est une organisation apolitique, à but non lucratif, créée le 4 juillet 2021.
                        </li>
                        <li class="library-option-li-card">
                            <span class="fas fa-circle-check mr-2 text-gray-950"></span>
                            Elle vise à <strong>renforcer la qualité de l’enseignement des sciences physiques</strong> dans le sous-secteur de l’EFTP, à adapter les contenus pédagogiques aux réalités des programmes en vigueur, et à améliorer les résultats des apprenants.
                        </li>
                        <li class="library-option-li-card">
                            <span class="fas fa-circle-check mr-2 text-gray-950"></span>
                            L’association regroupe les enseignants de sciences physiques de l’EFTP, qui s’engagent activement dans la vie associative et professionnelle, dans un esprit de solidarité, d'innovation et de rigueur scientifique.
                        </li>
                        <li class="library-option-li-card">
                            <span class="fas fa-circle-check mr-2 text-gray-950"></span>
                            Le siège de l’AESP-EFTP est situé à Agla les Pylônes, à Cotonou (Bénin), et l’association fonctionne selon les dispositions de la loi du 1er juillet 1901 et les textes réglementaires en vigueur en République du Bénin.
                        </li>
                        <li class="library-option-li-card">
                            <span class="fas fa-circle-check mr-2 text-gray-950"></span>
                            Son logo, une lampe électrique allumée entourée du sigle « AESP-EFTP », symbolise la lumière que la science physique apporte dans le domaine de l’enseignement technique et professionnel.
                        </li>
                    </ul>
                    <div class="text-center font-semibold library-option-li-card text-lg mt-4 text-gray-950">
                        Le logo de l'{{ env('APP_NAME') }} 
                        <div class="flex items-center justify-center mt-2">
                            <img class="inline-block border-gray-950 border-2" src="{{ asset(env('APP_LOGO')) }}" alt="">
                        </div>
                    </div>

                    <div class="w-full mx-auto my-4">
                        <h5 class="text-center">Voici quelques membres de l'{{ env("APP_NAME") }} </h5>

                        <div class="swiper mySwiper max-w-4xl mx-auto">
                            <div class="swiper-wrapper">
                            <!-- Slide 1 -->
                            @foreach (getActivesMembers() as $member)
                                @php
                                    $user = $member->user;
                                @endphp
                                <div wire:key='defilement-reviews-membre-{{$user->id}}' class="swiper-slide bg-sky-100 p-6 rounded-2xl shadow-lg">
                                <div class="flex items-center space-x-4 mb-4">
                                <img src="{{user_profil_photo($user)}}" class="w-24 h-24 rounded-full border-2 border-cyan-700" />
                                <div>
                                    <h3 class="lg:text-lg md:text-base sm:text-sm xs:text-xs font-semibold text-gray-800">
                                    {{ $user->getFullName(true) }}
                                    </h3>
                                    <span class="flex flex-col lg:text-sm sm:text-xs xs:text-xs">
                                        <a href="#" class=" text-cyan-600 hover:underline">
                                            <span class="fas fa-user-check"></span>
                                            @if($user->member)
                                            {{ $user->member->role ? $user->member->role->name : 'Un membre actif' }}
                                            @else
                                            Un enseignant actif
                                            @endif
                                        </a>
                                        <a href="mailto:{{$user->email}}" class=" text-cyan-600 hover:underline">
                                            <span class="fas fa-envelope"></span>
                                            {{ $user->email }}
                                        </a>
                                        <a href="#" class=" text-cyan-600 hover:underline">
                                            <span class="fas fa-phone"></span>
                                            {{ $user->contacts ? $user->contacts : 'Non renseigné' }}
                                        </a>
                                        <a href="#" class=" text-cyan-600 hover:underline">
                                            <span class="fas fa-home"></span>
                                            {{ $user->address ? $user->address : 'Non renseignée' }}
                                        </a>
                                    </span>
                                </div>
                                </div>
                                <blockquote class="text-gray-600 italic border-l-4 border-cyan-600 pl-4 lg:text-sm sm:text-xs xs:text-xs">
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
</div>
