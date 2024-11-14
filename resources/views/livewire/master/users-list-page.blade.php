<div class="mx-auto p-2 min-h-90">
    <div class="m-auto w-4/5 bg-gray-500 mt-3 p-0">
        <h1 class="p-4 text-orange-400 border uppercase text-center rounded-sm bg-slate-600">
            <span class="">
                Administration :
            </span>

            <strong class="text-orange-600">
                Gestion des Utilisateurs 
            </strong>
            
        </h1>
    </div>


    <div class="m-auto border rounded overflow-x-auto my-1 lg:flex w-4/5 xl:flex 2xl:flex justify-between z-bg-secondary-light-opac min-h-80">
       
        <div class="mx-auto w-full p-2 bg-gray-800">
            <div class="mt-2 w-full px-2 py-1 my-2 bg-gray-800 border rounded-sm">
                <h6 class="text-white ucfirst  text-2xl">Liste</h6>
            </div>
            <div class="w-full">
                <table class="text-gray-400 z-table-border z-table w-full mx-auto">
                    <col>
                    <col>
                    <col>
                    <col>
                    <col>
                    <colgroup span="3">
                    <tr class="text-center bg-gray-900">
                        <td class="py-2">No</td>
                        <td>Email</td>
                        <td>Nom et Prénoms</td>
                        <td>Etablissement</td>
                        <td>Statut (Grade) </td>
                        <td>Incsrit depuis</td>
                        <td>Compte confirmé le</td>
                        <th colspan="3" scope="colgroup">Actions</th>
                    </tr>
                    
                    
                    @foreach($users as $k => $user)
                        <tr class="z-table-body">
                            <td class="text-center">{{ \App\Helpers\Dater\Formattors\Formattors::numberZeroFormattor($loop->iteration) }}</td>
                            <td class="text-left px-2 py-1"> 
                                {{$user->email}}
                            </td>
                            <td class="text-left px-2"> 
                                {{$user->firstname . ' ' . $user->lastname}}
                            </td>
                            <td class="text-left px-2 @if(!$user->school) text-orange-400 @endif">

                                {{ $user->formatString($user->school) }}

                                <span class="text-orange-500 @if(!$user->job_city) hidden @endif">
                                    ( {{ $user->job_city }} )
                                </span>
                            </td>
                            <td class="text-left px-2 @if($user->status) uppercase @else text-orange-400 @endif "> 
                                {{$user->formatString($user->status)}}

                                <small class="text-orange-500 ml-3 @if(!$user->grade) hidden @endif">( {{ $user->grade }} )</small>
                            </td>
                            <td class="px-2">
                                {{$user->__getDateAsString($user->created_at, 3, true)}}
                            </td>

                            <td class="px-2 @if(!$user->email_verified_at) text-red-600 @endif">
                                {{ $user->email_verified_at ? $user->__getDateAsString($user->email_verified_at) : 'Non confirmé'}}
                            </td>
                            <td class="text-left px-2">S</td>
                            <td class="text-left px-2">S</td>
                            <td class="text-left px-2">S</td>
                        </tr>
                    @endforeach
                </table>

                <div class="my-3">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

</div>