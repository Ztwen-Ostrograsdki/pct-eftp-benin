<div >
    <div class="">
        @if($show_perso && $errors->any())
            <h4 class="bg-red-300 border py-1 text-red-700 w-full text-center text-lg rounded-lg shadow-sm">
                <strong class="mx-3"> Oupps!!! Le formulaire est incorrect</strong>
            </h4>
        @endif
        <form class="w-full mx-auto mt-5 mb-2">
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input wire:model="firstname" @if(!$editing_perso) disabled @endif type="text" name="firstname" id="firstname" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Votre Nom" />
                    <label for="firstname" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Votre Nom</label>
                    @error('firstname')
                        <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input wire:model="lastname" @if(!$editing_perso) disabled @endif type="text" name="lastname" id="lastname" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Vos Prénoms" />
                    <label for="lastname" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Vos Prénoms</label>
                    @error('lastname')
                        <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="grid md:grid-cols-3 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input wire:model="pseudo" @if(!$editing_perso) disabled @endif type="text" name="pseudo" id="pseudo" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Choissisez votre pseudo" />
                    <label for="pseudo" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Votre pseudo</label>
                    @error('pseudo')
                        <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <select wire:model="gender" @if(!$editing_perso) disabled @endif type="text" name="gender" id="gender" class="block rounded-sm ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Votre genre">
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
                    <select wire:model="marital_status" @if(!$editing_perso) disabled @endif type="text" name="marital_status" id="marital_status" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Situation matrimoniale">
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
            <div class="grid md:grid-cols-3 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input wire:model="birth_date" @if(!$editing_perso) disabled @endif type="text" name="birth_date" id="birth_date" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Date de naissance" />
                    <label for="birth_date" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Date de naissance</label>
                    @error('birth_date')
                        <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input wire:model="birth_city" @if(!$editing_perso) disabled @endif type="text" name="birth_city" id="birth_city" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Lieu de naissance" />
                    <label for="birth_city" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Lieu de naissance</label>
                    @error('birth_city')
                        <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input wire:model="contacts" @if(!$editing_perso) disabled @endif type="text" name="contacts" id="contacts" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Vos contacts" />
                    <label for="contacts" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Vos contacts</label>
                    @error('contacts')
                        <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-5 group">
                    <input wire:model="address" @if(!$editing_perso) disabled @endif type="text" name="address" id="address" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Votre addresse" />
                    <label for="address" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Votre addresse</label>
                    @error('address')
                        <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <select wire:model="status" @if(!$editing_perso) disabled @endif type="text" name="status" id="status" class="block ucfirst py-2.5 px-0 w-full text-base text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-orange-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder="Votre statut ou corps">
                        @foreach (config('app.teachers_statuses') as $key =>  $tstatus)
                            <option class="bg-gray-600 text-gray-950 " value="{{$key}}">{{ $tstatus }}</option>
                        @endforeach
                    </select>
                    <label for="status" class=" peer-focus:font-medium absolute text-base text-blue-500 dark:text-blue-600 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-focus:scale-75 peer-focus:-translate-y-6">Votre statut ou corps</label>
                    @error('status')
                        <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
            </div>
            <div class="mx-auto w-full">
                <div wire:target='updateUserPersoData' wire:loading class="flex my-4 text-xl mx-auto justify-center w-full">
                    <span class="animate-spin fas fa-spinner text-5xl text-orange-500 text-center"></span>
                    <span class="text-orange-500 text-lg text-right float-right mx-3">Veuillez patienter, traitement en cours...</span>
                </div>
                <div class="flex gap-3 w-full">
                    @if($editing_perso)
                    <span wire:target='updateUserPersoData' wire:loading.remove wire:click='updateUserPersoData' class="cursor-pointer border text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Valider
                    </span>
    
                    <span wire:target='updateUserPersoData' wire:loading.remove wire:click='cancelPersoEdition' class="cursor-pointer border text-white bg-blue-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-blue-800">
                        <span  class="fas fa-ban"></span>
                        Annuler
                    </span>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>