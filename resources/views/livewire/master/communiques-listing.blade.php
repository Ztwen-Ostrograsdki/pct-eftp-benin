<div>

    <style>
      tr{
			border: thin solid white !important;
      }

      tr:nth-child(odd) {
        
      }

      tr:nth-child(even) {
      background: #141b32;
      }
      

      table {
        border-collapse: collapse;
      }

      th, td{
        border: thin solid rgb(177, 167, 167) !important;
      }
    </style>

    <div class="w-full mx-auto p-4 z-bg-secondary-light-opac">
        <h1 class="text-lg font-bold mb-6 text-sky-600 border-b border-sky-600 pb-2">
            <span>Liste des Communiqués</span>
            <span class="ml-3 text-yellow-400">
                {{ numberZeroFormattor(count($communiques)) }}
            </span>

        </h1>
        <div class="my-2 flex justify-end">
            <button wire:click='manageCommnunique' type="button" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                <span wire:target='manageCommnunique' wire:loading.remove='manageCommnunique'>
                    + Nouveau communiqué
                </span>
                <span wire:target='manageCommnunique' wire:loading='manageCommnunique'>
                    <span>Chargement...</span>
                    <span class="fa fa-rotate animate-spin"></span>
                </span>
            </button>
        </div>
        <div class="overflow-x-auto lg:text-base md:text-sm sm:text-xs xs:text-xs">
            @if(count($communiques) > 0)
            <table class="w-full bg-transparent border border-gray-200 shadow text-gray-300">
            <thead class="bg-gray-800">
                <tr>
                <th class="py-3 px-3 text-left font-semibold ">N°</th>
                <th class="py-3 px-3 text-left font-semibold ">Objet</th>
                <th class="py-3 px-3 text-left font-semibold ">Titre</th>
                <th class="py-3 px-3 text-left font-semibold ">Contenu</th>
                <th class="py-3 px-3 text-left font-semibold ">Date de publication</th>
                <th class="py-3 px-3 text-center font-semibold ">Actions</th>
                </tr>
            </thead>
                <tbody class="divide-y divide-gray-100">
                    <!-- Boucle sur les communiqués -->
                    @foreach($communiques as $communique)
                    <tr>
                        <td class="py-2 px-3 ">{{ $loop->iteration }}</td>
                        <td class="py-2 px-3 ">
                            <a href="{{ $communique->toProfilRoute() }}">
                                {{ $communique->title }}
                            </a>
                        </td>
                        <td class="py-2 px-3 ">
                            <a href="{{ $communique->toProfilRoute() }}">
                                {{ $communique->objet }}
                            </a>
                        </td>
                        <td class="py-2 px-3  max-w-sm truncate">
                            <a href="{{ $communique->toProfilRoute() }}">
                                {{ $communique->content }}
                            </a>
                        </td>
                        <td class="py-2 px-3 ">
                            {{ __formatDate($communique->created_at) }}
                        </td>
                        <td class="py-2 px-3 text-center space-x-2">
                            <a wire:click="manageCommnunique({{$communique->id}})"  class="text-blue-600 hover:underline">
                                <span wire:target="manageCommnunique({{$communique->id}})" wire:loading.remove="manageCommnunique({{$communique->id}})">Modifier</span>
                                <span wire:target="manageCommnunique({{$communique->id}})" wire:loading="manageCommnunique({{$communique->id}})" class="fas fa-rotate animate-spin"></span>
                            </a>
                            <button title="Supprimer le communiqué {{ $communique->getCommuniqueFormattedName() }}" wire:click="deleteCommunique({{$communique->id}})" type="submit" class="text-red-600 hover:underline">
                                Supprimer
                            </button>
                            <button wire:click="hideOrUnHideCommunique({{$communique->id}})"  title="@if($communique->hidden) Rendre visible @else Masquer @endif le communiqué {{ $communique->getCommuniqueFormattedName() }}"  type="submit" class="text-yellow-600 hover:underline">
                                @if($communique->hidden) Rendre visible @else Masquer @endif
                            </button>
                            <button wire:click="sendCommuniqueToMemberByEmail({{$communique->id}})" type="submit" class="text-green-600 hover:underline">
                                Publier
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    <!-- Fin de boucle -->
                </tbody>
            </table>
            @else
            <div class="mx-auto w-full px-4 py-3">
                <h6 class="text-center text-lg font-semibold letter-spacing-2 py-4 text-orange-600 shadow-3 mx-auto rounded-lg shadow-orange-400 w-2/3">
                    Ouups, aucun communiqué n'est disponible pour le moment!
                </h6>
            </div>
            @endif
        </div>
    </div>

</div>
