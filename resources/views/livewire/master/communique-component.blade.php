<div class="p-6 w-full mx-auto">
    @if(auth()->user() && __isAdminAs())
    <div class="text-center mx-auto flex justify-end gap-x-3 mt-2 border-2 border-gray-900 p-3 max-w-7xl lg:px-6 md:px-4 sm:px-1 xs:px-1 lg:text-base md:text-base sm:text-xs xs:text-xs">
        <span wire:click="sendCommuniqueToMemberByEmail({{$communique->id}})" class="border cursor-pointer rounded-lg py-2 px-3 bg-green-700 hover:bg-green-800 text-white">
            <span wire:target='sendCommuniqueToMemberByEmail({{$communique->id}})' wire:loading.remove="sendCommuniqueToMemberByEmail({{$communique->id}})">
                <span class="">Publier par mail</span>
                <span class="fa fa-envelope"></span>
            </span>
            <span wire:target='sendCommuniqueToMemberByEmail({{$communique->id}})' wire:loading="sendCommuniqueToMemberByEmail({{$communique->id}})">
                <span>En cours...</span>
                <span class="fas fa-rotate animate-spin"></span>
            </span>
        </span>
        
        <span wire:click="manageCommnunique({{$communique->id}})" class="border cursor-pointer rounded-lg py-2 px-3 bg-blue-700 hover:bg-blue-800 text-white">
            <span wire:target='manageCommnunique({{$communique->id}})' wire:loading.remove="manageCommnunique({{$communique->id}})">
                <span class="">Modifier</span>
                <span class="fa fa-pen"></span>
            </span>
            <span wire:target='manageCommnunique({{$communique->id}})' wire:loading="manageCommnunique({{$communique->id}})">
                <span>En cours...</span>
                <span class="fas fa-rotate animate-spin"></span>
            </span>
        </span>

        <span  wire:click="hideOrUnHideCommunique({{$communique->id}})" class="border cursor-pointer rounded-lg py-2 px-3 bg-gray-700 hover:bg-gray-800 text-white">
            <span wire:target='hideOrUnHideCommunique({{$communique->id}})' wire:loading.remove="hideOrUnHideCommunique({{$communique->id}})">
                <span class="">@if($communique->hidden)Rendre visible @else Masquer @endif</span>
                <span class="fa fa-eye-slash"></span>
            </span>
            <span wire:target='hideOrUnHideCommunique({{$communique->id}})' wire:loading="hideOrUnHideCommunique({{$communique->id}})">
                <span>En cours...</span>
                <span class="fas fa-rotate animate-spin"></span>
            </span>
        </span>

        <span title="Supprimer le communiqué {{$communique->getCommuniqueFormattedName()}} " wire:click="deleteCommunique({{$communique->id}})" class="border cursor-pointer rounded-lg py-2 px-3 bg-red-700 hover:bg-red-800 text-white">
            <span wire:target='deleteCommunique({{$communique->id}})' wire:loading.remove="deleteCommunique({{$communique->id}})">
                <span class="">Supprimer</span>
                <span class="fa fa-trash"></span>
            </span>
            <span wire:target="deleteCommunique({{$communique->id}})" wire:loading="deleteCommunique({{$communique->id}})">
                <span>Suppression en cours...</span>
                <span class="fas fa-rotate animate-spin"></span>
            </span>
        </span>

    </div>
    @endif
    
    <div class="text-center mx-auto mt-2 border-2 border-gray-900 p-3 bg-gray-100 max-w-7xl lg:px-6 md:px-4 sm:px-1 xs:px-1">
        
		<h6 class="letter-spacing-2 flex flex-col items-center gap-y-1 px-4 mt-8">
			<div class="text-sky-400 flex w-full lg:px-7 md:px-3 sm:px-1 xs:px-1">
				<img src="{{asset(env('APP_LOGO'))}}" alt="" style="height: 80px; " class="border rounded-full float-right border-r-red-500 border-t-red-500 border-b-yellow-500 border-l-green-600">
				<span class="flex flex-col font-bold mx-auto">
					<span class="uppercase text-orange-600">
						République du Bénin
					</span>
					<span class="text-gray-800 text-sm">
						Ministère de l'Enseignement Technique et de la Formation Professionnelle
					</span>
					<span class="mx-auto inline-block w-full mt-1">
						<span class="w-full flex mx-auto ">
							<span class="bg-green-500 inline-block p-0.5 w-1/3"></span>
							<span class="bg-yellow-500 inline-block p-0.5 w-1/3"></span>
							<span class="bg-red-600 inline-block p-0.5 w-1/3"></span>
						</span>
					</span>
                    <h3 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif" class="text-gray-800 fas fa-2x letter-spacing-1 flex flex-col">
						<span>{{ env('APP_NAME') }}</span>
                        <span class="text-xs font-mono letter-spacing-1">
                            {{ getAppFullName() }}
                        </span>
					</h3>
					<h4 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif" class="text-gray-900 my-0 uppercase letter-spacing-1 lg:text-xl md:text-xl sm:text-base xs:text-sm border-2 border-gray-900 py-3 mt-2">
						Communiqué {{ $communique->getCommuniqueFormattedName() }}
					</h4>  
					
				</span>
				<img src="{{asset(env('APP_LOGO'))}}" style="height: 80px" alt="" class="rounded-full float-end border  border-r-red-500 border-t-red-500 border-b-yellow-500 border-l-green-600">
			</div>
		</h6>

        <div class="mx-auto w-10/12 mt-6 lg:px-6 md:px-4 sm:px-1 xs:px-1 mb-32">

            <div class="flex justify-between items-center w-full mt-5">
                <div>
                    <div class="flex flex-col">
                        <h6 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif" class="uppercase lg:text-2xl m:text-2xl sm:text-base xs:text-xs font-bold text-gray-950">
                            {{ $communique->from ? $communique->from : "L'administration" }}
                        </h6>
                        <h6>
                            {{ $communique->getCommuniqueFormattedName() }}
                        </h6>
                    </div>
                </div>
                <div>
                    <h6 class="letter-spacing-1 font-semibold text-gray-800 lg:text-lg m:text-lg sm:text-base xs:text-xs"> Cotonou, le {{ __formatDate($communique->created_at) }} </h6>
                </div>
            </div>

            <div class="w-full mx-auto">

                <h3 style="" class="text-center text-lg uppercase text-gray-700 mt-3 flex justify-end gap-x-4 font-bold letter-spacing-1">
                    <span class="underline">Objet: </span>
                    <span>
                        {{ $communique->objet }}
                    </span>
                </h3>

                <h2 style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif" class="text-center text-2xl uppercase text-black underline font-bold letter-spacing-2 mt-3">communiqué</h2>

                <div class="text-left mt-3 mb-2">
                    {{ $communique->content }}
                </div>
            </div>

            <div class="my-10 flex justify-end">
                <h6 class="letter-spacing-1 font-semibold text-gray-800 lg:text-lg m:text-lg sm:text-base xs:text-xs"> Cotonou, le {{ __formatDate($communique->created_at) }} </h6>

            </div>
            
        </div>
        <span class="mx-auto inline-block w-8/12 mt-1">
            <span class="w-full flex mx-auto ">
                <span class="bg-green-500 inline-block p-0.5 w-1/3"></span>
                <span class="bg-yellow-500 inline-block p-0.5 w-1/3"></span>
                <span class="bg-red-600 inline-block p-0.5 w-1/3"></span>
            </span>
        </span>
        
	</div>
    <span class="mx-auto inline-block w-full mt-1">
        <span class="w-full flex mx-auto ">
            <span class="bg-green-500 inline-block p-0.5 w-1/3"></span>
            <span class="bg-yellow-500 inline-block p-0.5 w-1/3"></span>
            <span class="bg-red-600 inline-block p-0.5 w-1/3"></span>
        </span>
    </span>
	
</div>
