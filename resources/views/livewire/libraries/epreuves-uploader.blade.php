<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="w-4/5 mx-auto px-3" >
       <div class="bg-gray-900 w-full">
            <div class="w-full">
                <div class="m-0 my-2 p-2 border-b">
                    <h6 class="py-3 text-lg text-gray-500">Gestionnaire d'envoi des épreuves</h6>
                </div>

            </div>

            <div class="w-full px-3">
                <div class="m-0 p-2">
                    <h6 class="py-1 text-lg text-orange-500 text-right">Veuillez renseigner les infos de sur votre document</h6>
                </div>

                <form class="w-full mx-auto">
        
                    <div class="grid md:grid-cols-3 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <input wire:model="job_city" type="text" name="job_city" id="job_city" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Ville ou commune de travail" />
                            <label for="job_city" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Ville ou commune de travail</label>
                            @error('job_city')
                                <span class="text-red-600">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <input wire:model="school" type="text" name="school" id="school" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Etablissement" />
                            <label for="school" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Etablissement</label>
                            @error('school')
                                <span class="text-red-600">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <input wire:model="years_experiences" type="text" name="years_experiences" id="years_experiences" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Année d'expériences" />
                            <label for="years_experiences" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Année d'expériences</label>
                            @error('years_experiences')
                                <span class="text-red-600">{{$message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 md:gap-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <input wire:model="pseudo" type="text" name="pseudo" id="pseudo" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Choissisez votre pseudo" />
                            <label for="pseudo" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Votre pseudo</label>
                            @error('pseudo')
                                <span class="text-red-600">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <select wire:model="gender" type="text" name="gender" id="gender" class="block rounded-sm ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Votre genre">
                                @foreach (config('app.genders') as $key =>  $mgender)
                                    <option class="bg-gray-600 rounded-sm text-gray-950 " value="{{$key}}">{{ $mgender }}</option>
                                @endforeach
                            </select>
                            <label for="gender" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Sexe</label>
                            @error('gender')
                                <span class="text-red-600">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="relative z-0 w-full mb-5 group">
                            <select wire:model="marital_status" type="text" name="marital_status" id="marital_status" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Situation matrimoniale">
                                @foreach (config('app.marital_statuses') as $key =>  $mstatus)
                                    <option class="bg-gray-600 text-gray-950 " value="{{$key}}">{{ $mstatus }}</option>
                                @endforeach
                            </select>
                            <label for="marital_status" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Situation matrimoniale</label>
                            @error('marital_status')
                                <span class="text-red-600">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
        
                   
                </form>
            </div>

        </div>
    </div>
</div>

