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
        <h1 class="text-2xl font-bold mb-6 text-sky-600 border-b border-sky-600 pb-2">Liste des Communiqués</h1>
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
                    <td class="py-2 px-3 ">I{{ $loop->iteration }}</td>
                    <td class="py-2 px-3 ">{{ $communique->title }}</td>
                    <td class="py-2 px-3 ">{{ $communique->objet }}</td>
                    <td class="py-2 px-3  max-w-sm truncate">
                        {{ $communique->content }}
                    </td>
                    <td class="py-2 px-3 ">
                        {{ __formatDate($communique->created_at) }}
                    </td>
                    <td class="py-2 px-3 text-center space-x-2">
                        <a href="{{ route('communique.profil', ['id' => $communique->id]) }}" class="text-blue-600 hover:underline">
                            Charger
                        </a>
                        <button type="submit" class="text-red-600 hover:underline">
                            Supprimer
                        </button>
                        <button type="submit" class="text-yellow-600 hover:underline">
                            Masquer
                        </button>
                        <button type="submit" class="text-green-600 hover:underline">
                            Publier
                        </button>
                    </td>
                </tr>
                @endforeach
                <!-- Fin de boucle -->
            </tbody>
            </table>
        </div>
    </div>

</div>
