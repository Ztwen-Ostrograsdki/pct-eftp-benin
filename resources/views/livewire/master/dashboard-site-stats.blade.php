<div class="p-2">
    <div class="m-auto z-bg-secondary-light rounded my-1 min-h-80 p-2">
        <div class="m-auto  p-0 my-3">
            <div class="mt-6 text-sky-500 p-6 ">
                <div class="p-6 bg-gray-900 rounded-xl shadow-2 shadow-sky-300">
                    <h2 class="text-xl font-semibold mb-2">Bienvenue dans votre tableau de bord</h2>
                    <p class="text-sky-600">Utilisez la barre latérale pour naviguer.</p>
                </div>
            </div>
            <div class="flex gap-x-2">
                    <div class="flex-1 p-6 overflow-y-auto text-gray-950 uppercase font-semibold letter-spacing-1">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                            <div class="p-4 bg-zinc-950 rounded-xl shadow-2 shadow-sky-300 ">
                                <h3 class="text-lg text-gray-400 border-b-2 border-b-gray-400 font-bold flex justify-between mb-3">Utilisateurs enregistrés
                                        <p class="text-gray-200">
                                        {{ __formatNumber3(count(getUsers())) }}
                                    </p>
                                </h3>
                                
                                <div class="flex flex-col text-sm gap-y-2">
                                    <p class="text-sky-300 text-right flex justify-between">
                                        <span>
                                            Les comptes confirmés:
                                        </span>
                                        <span>
                                            {{ __formatNumber3(count(confirmedsAccounts())) }}
                                        </span>
                                    </p>

                                    <p class="text-sky-400 text-right flex justify-between">
                                        <span>
                                            Les comptes non confirmés:
                                        </span>
                                        <span>
                                            {{ __formatNumber3(count(unconfirmedsAccounts())) }}
                                        </span>
                                    </p>
                                    <p class="text-red-600 text-right flex justify-between">
                                        <span>
                                            Les comptes bloqués:
                                        </span>
                                        <span>
                                            {{ __formatNumber3(count(blockedsUsers())) }}
                                        </span>
                                    </p>
                                    
                                </div>
                            </div>

                            <div class="p-4 bg-zinc-900 rounded-xl shadow-2 shadow-sky-300 ">
                                <h3 class="text-lg text-gray-400 border-b-2 border-b-gray-400 font-bold flex justify-between mb-3">Les Membres enregistrés
                                        <p class="text-gray-200">
                                        {{ __formatNumber3(count(getMembers())) }}
                                    </p>
                                </h3>
                                
                                <div class="flex flex-col text-sm gap-y-2">
                                    <p class="text-red-500 text-right flex justify-between">
                                        <span>
                                            Les membres bloqués:
                                        </span>
                                        <span>
                                            {{ __formatNumber3(count(blockedsUsers())) }}
                                        </span>
                                    </p>

                                </div>
                            </div>
                            
                            <div class="p-4 bg-zinc-800 rounded-xl shadow-2 shadow-sky-300 ">
                                <h3 class="text-lg text-gray-400 border-b-2 border-b-gray-400 font-bold flex justify-between mb-3">Epreuves enregistrées
                                        <p class="text-gray-200">
                                        {{ __formatNumber3($all_epreuves) }}
                                    </p>
                                </h3>
                                
                                <div class="flex flex-col text-sm gap-y-2">
                                    <p class="text-sky-300 text-right flex justify-between">
                                        <span>
                                            Epreuves déjà authorisées :
                                        </span>
                                        <span>
                                            {{ __formatNumber3($confirmeds_epreuves) }}
                                        </span>
                                    </p>

                                    <p class="text-sky-400 text-right flex justify-between">
                                        <span>
                                            Epreuves non authorisées:
                                        </span>
                                        <span>
                                            {{ __formatNumber3($unconfirmeds_epreuves) }}
                                        </span>
                                    </p>
                                    <p class="text-green-600 text-right flex justify-between">
                                        <span>
                                            Nombres de téléchargements :
                                        </span>
                                        <span>
                                            {{ __formatNumber3($epreuves_downloadeds) }}
                                        </span>
                                    </p>
                                    
                                </div>
                            </div>

                            <div class="p-4 bg-zinc-700 rounded-xl shadow-2 shadow-sky-300 ">
                                <h3 class="text-lg text-gray-400 border-b-2 border-b-gray-400 font-bold flex justify-between mb-3">Fiches de cours enregistrées
                                        <p class="text-gray-200">
                                        {{ __formatNumber3($all_courses_files) }}
                                    </p>
                                </h3>
                                
                                <div class="flex flex-col text-sm gap-y-2">
                                    <p class="text-sky-300 text-right flex justify-between">
                                        <span>
                                            Fiches déjà authorisées :
                                        </span>
                                        <span>
                                            {{ __formatNumber3($confirmeds_courses_files) }}
                                        </span>
                                    </p>

                                    <p class="text-sky-400 text-right flex justify-between">
                                        <span>
                                            Fiches non authorisées:
                                        </span>
                                        <span>
                                            {{ __formatNumber3($unconfirmeds_courses_files) }}
                                        </span>
                                    </p>
                                    <p class="text-green-600 text-right flex justify-between">
                                        <span>
                                            Nombres de téléchargements :
                                        </span>
                                        <span>
                                            {{ __formatNumber3($courses_files_downloadeds) }}
                                        </span>
                                    </p>
                                    
                                </div>
                            </div>

                            <div class="p-4 bg-gray-700 rounded-xl shadow-2 shadow-sky-300 ">
                                <h3 class="text-lg text-gray-400 border-b-2 border-b-gray-400 font-bold flex justify-between mb-3">Les messages du forum
                                        <p class="text-gray-200">
                                        {{ __formatNumber3($chat_messages) }}
                                    </p>
                                </h3>
                                
                                <div class="flex flex-col text-sm gap-y-2">
                                    <p class="text-sky-300 text-right flex justify-between">
                                        <span>
                                            Images partagées :
                                        </span>
                                        <span>
                                            {{ __formatNumber3($chat_images) }}
                                        </span>
                                    </p>

                                    <p class="text-sky-400 text-right flex justify-between">
                                        <span>
                                            Documents partagés:
                                        </span>
                                        <span>
                                            {{ __formatNumber3($chat_documents) }}
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="p-4 bg-gray-800 rounded-xl shadow-2 shadow-sky-300 ">
                                <h3 class="text-lg text-gray-400 border-b-2 border-b-gray-400 font-bold flex justify-between mb-3">Les communiqués
                                        <p class="text-gray-200">
                                        {{ __formatNumber3($communiques) }}
                                    </p>
                                </h3>
                                
                                <div class="flex flex-col text-sm gap-y-2">
                                    <p class="text-sky-300 text-right flex justify-between">
                                        <span>
                                            Communiqués actifs :
                                        </span>
                                        <span>
                                            {{ __formatNumber3($communiques_visibles) }}
                                        </span>
                                    </p>

                                    <p class="text-red-600 text-right flex justify-between">
                                        <span>
                                            Communiqués masqués:
                                        </span>
                                        <span>
                                            {{ __formatNumber3($communiques_hidden) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    
</div>
