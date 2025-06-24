<div class="p-6 w-full mx-auto z-bg-secondary-light-opac shadow-2 shadow-sky-500" x-data="{ show: false, currentImage: '', userName: '', email: '' }">
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
          border: thin solid rgb(177, 167, 167);
        }
      </style>
      <div class="mb-6 lg:text-lg md:text-sm sm:text-sm xs:text-xs">
          <div class="flex items-center justify-between flex-col gap-x-2 mb-6 lg:text-lg md:text-lg sm:text-xs xs:text-xs">
              <h2 class="lg:text-lg md:text-sm sm:text-sm xs:text-xs w-full flex gap-x-3  font-semibold letter-spacing-1 uppercase text-sky-500">Détails sur les utilisateurs et leurs rôles administrateurs
  
                  <span class="text-yellow-500">
                      
                  </span>
              </h2>
              <div class="flex justify-end gap-x-2 w-full mt-2 lg:text-base md:text-lg sm:text-xs xs:text-xs">
                  <button
                      wire:click="toggleSelectionsCases"
                      class="bg-zinc-600 text-white px-4 py-2 rounded-lg hover:bg-zinc-700 hover:text-gray-500 transition"
                  >
                      <span wire:loading.remove wire:target='toggleSelectionsCases'>
                          <span class="fas fa-check"></span>
                          <span>De/Cocher</span>
                      </span>
                      <span wire:target='toggleSelectionsCases' wire:loading>
                          <span class="fas fa-rotate animate-spin"></span>
                      </span>
                  </button>
                  <div class="flex items-center">
                      <button
                          wire:click="memberPaymentsManager"
                          class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 hover:text-gray-900 transition"
                      >
                          <span wire:loading.remove wire:target='memberPaymentsManager'>
                              <span class="fas fa-save"></span>
                              <span>Enregistrer un paiement</span>
                          </span>
                          <span wire:target='memberPaymentsManager' wire:loading>
                              <span>Chargement en cours...</span>
                              <span class="fas fa-rotate animate-spin"></span>
                          </span>
                      </button>
                  </div>
                  <div class="flex gap-x-2 items-center">
                      <button
                          wire:click="sendDocumentToOthers"
                          class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-800 hover:text-gray-900 transition"
                      >
                          <span wire:loading.remove wire:target='sendDocumentToOthers'>
                              <span>Envoyez aux admins</span>
                              <span class="fas fa-paper-plane"></span>
                          </span>
                          <span wire:target='sendDocumentToOthers' wire:loading>
                              <span>Envoie en cours...</span>
                              <span class="fas fa-rotate animate-spin"></span>
                          </span>
                      </button>
                      <button
                          wire:click="printMembersCotisations"
                          class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 hover:text-gray-900 transition"
                      >
                          <span wire:loading.remove wire:target='printMembersCotisations'>
                              <span>Recevoir par mail</span>
                              <span class="fas fa-print"></span>
                          </span>
                          <span wire:target='printMembersCotisations' wire:loading>
                              <span>Processus en cours...</span>
                              <span class="fas fa-rotate animate-spin"></span>
                          </span>
                      </button>
                      
                  </div>
              </div>
  
          </div>
          <hr class="border-sky-600 mb-2">
  
          <div class="w-full flex justify-between items-center">
              
          <div class="mb-4">
              <div class="items-center flex float-start border-sky-700 bg-transparent shadow-1 shadow-sky-4000 rounded-lg gap-x-4">
                  
                  
                </div>
              </div>
          </div>
          
      </div>
  
    <!-- Tableau des paiements -->
    <div class="overflow-x-auto letter-spacing-1 rounded-lg shadow border border-gray-200 z-bg-secondary-light">
        @if (count($users) > 0)

            @if($selected_users AND count($selected_users) > 0)
                <h6 class="w-full text-zinc-400 text-right font-semibold letter-spacing-2 p-2">
                    <span class="text-yellow-400">
                        {{ numberZeroFormattor(count($selected_users)) }}
                    </span> membres sélectionnés
                </h6>
            @endif
            <table class="min-w-full divide-y divide-gray-200 xl:text-sm lg:text-sm md:text-sm sm:text-sm xs:text-xs">
            <thead class="bg-gray-900 text-gray-300 font-semibold">
                <tr>
                    <th class="px-3 py-4 text-center">#N°</th>
                    <th class="px-3 py-4 text-left">Membre</th>
                    <th class="px-3 py-4 text-left">Email</th>
                    <th class="px-3 py-4 text-center">Rôles administrateurs assignés</th>
                    <th class="px-3 py-4 text-center">Actions</th>
                    @if($display_select_cases)
                    <th class="px-3 py-4 text-center">
                        <button
                                wire:click="toggleSelectAll"
                                class="bg-zinc-600 text-white px-4 py-2 rounded-lg hover:bg-zinc-700 hover:text-gray-500 transition"
                            >
                            <span wire:loading.remove wire:target='toggleSelectAll'>
                                <span class="fas fa-check-double"></span>
                                <span>Tout dé/cocher</span>
                            </span>
                            <span wire:target='toggleSelectAll' wire:loading>
                                <span class="fas fa-rotate animate-spin"></span>
                            </span>
                        </button>
                    </th>
                @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100" id="payments-tbody">
                 @foreach ($users as $user)
                    <tr wire:key='list-des-cotisations-mensuelles-{{getRand(2999, 8888888)}}'>
                        <td class="px-2 py-2 text-gray-400 text-center @if(in_array($user->id, $selected_users)) bg-green-500 text-gray-900 border-gray-900 border @endif ">
                            {{ numberZeroFormattor($loop->iteration) }}
                        </td>
                        <td class="px-2 py-2 text-gray-300 font-medium">
                            <span class="flex gap-x-2 items-center">
                                <img title="Cliquez pour zoomer sur l'image de profil"  @click="currentImage = '{{ user_profil_photo($user) }}'; userName = '{{ $user->getFullName(true) }}'; email = '{{ $user->email }}'; show = true" class="w-8 h-8 rounded-full" src="{{ user_profil_photo($user) }}" alt="Photo de profil de {{ $user->getFullName() }}">
                                <a title="Charger le profil de {{$user->getFullName()}}" class="" href="{{ route('user.profil', ['identifiant' => $user->identifiant]) }}">
                                    {{$user->getFullName()}} 
                                </a>
                            </span>
                        <td class="px-2 py-2 text-gray-400">
                            {{ $user->email }}
                        </td>
                        <td class="px-2 py-2 text-yellow-600">
                            <span class="flex flex-wrap gap-1 gap-x-2">
                                @foreach ($user->roles as $role)
                                    <span class="p-2 text-xs border rounded bg-gray-900 text-gray-300 hover:text-gray-100 "> 
                                        {{ __translateRoleName($role->name) }} 
                                    </span>
                                @endforeach
                            </span>
                        </td>
                        <td class="px-2 py-2 text-center text-xs">
                            @if(auth_user()->isAdminsOrMaster() && !$user->isMaster())
                                <span class="flex gap-x-3 w-full justify-center items-center">
                                    @if(!$user->isMaster() || auth_user()->isMaster())
                                        <button
                                            wire:click="assignAdminRoles({{$user->id}})"
                                            class="bg-blue-600 border text-white px-4 py-2 rounded-lg hover:bg-blue-800 hover:text-gray-300 transition"
                                        >
                                            <span wire:loading.remove wire:target='assignAdminRoles({{$user->id}})'>
                                                <span class="fas fa-user-check"></span>
                                                <span>Editer les rôles</span>
                                            </span>
                                            <span wire:target='assignAdminRoles({{$user->id}})' wire:loading>
                                                <span>Chargement en cours...</span>
                                                <span class="fas fa-rotate animate-spin"></span>
                                            </span>
                                        </button>
                                    @endif
                                </span>
                            </td>
                            @if($display_select_cases)
                                <td>
                                    <span wire:click="pushOrRetrieveFromSelectedUsers({{$user->id}})" class="w-full mx-auto text-center font-bold inline-block cursor-pointer">
                                        @if(in_array($user->id, $selected_users))
                                            <span class="fas fa-user-check text-green-600"></span>
                                        @else
                                            <span class="text-xs text-zinc-500">Cliquer pour ajouter</span>
                                        @endif
                                    </span>
                                </td>
                            @endif
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="w-full text-center py-4 border-none bg-red-300 text-red-600 text-base">
                <span class="fas fa-trash"></span>
                <span>Oupps aucune données trouvées!!!</span>
            </div>
        @endif
  
    </div>

    <div 
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75"
        class="fixed inset-0 bg-black bg-opacity-80 flex flex-col items-center justify-center z-50"
        style="display: none;"
        @click="show = false"
    >
        <h5 class="mx-auto flex flex-col gap-y-1 text-lg w-auto text-center py-3 font-semibold letter-spacing-1 bg-gray-950 my-3" >
            <span class=" text-sky-500 uppercase" x-text="userName"></span>
            <span class=" text-yellow-500" x-text="email"></span>
        </h5>
        <img :src="currentImage" alt="Zoom" class="max-w-4xl max-h-[90vh] rounded shadow-xl border-2 border-white" @click.stop>
        
    </div>
    
</div>
