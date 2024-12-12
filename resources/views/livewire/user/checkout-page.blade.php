<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
	<h1 class="text-xl uppercase font-bold bg-gray-800 text-gray-400 rounded-lg mb-4 w-full py-2 px-3">
		Processus de validation du panier
	</h1>
    @if($errors->any())
        <h4 class="w-full letter-spacing-2 p-2 text-xl mb-4 shadow rounded-full  shadow-red-600 bg-red-300 text-red-800 text-center mx-auto">
            <strong>
                Le formulaire est incorrect
            </strong>
        </h4>
    @endif
    @if(count($carts_items))
	<div class="grid grid-cols-12 gap-4">
		<div class="md:col-span-12 lg:col-span-8 col-span-12">
			<!-- Card -->
			<div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
				<!-- Shipping Address -->
				<div class="mb-6">
					<h2 class="text-xl uppercase font-bold text-gray-700 dark:text-white mb-2">
						Adresse de livraison
					</h2>
                    <hr class="bg-slate-400 my-4 h-1 rounded">
					<div class="grid grid-cols-2 gap-4">
						<div>
							<label class="block text-gray-700 dark:text-white mb-1" for="first_name">
								Nom du receveur
							</label>
							<input name="first_name" wire:model.live='first_name' placeholder="Renseignez le nom du receveur..." class="w-full @error('first_name') text-red-400 border border-red-700 @else dark:text-white @enderror rounded-lg py-2 px-3 dark:bg-gray-700 " id="first_name" type="text">
							</input>
							@error('first_name')
								<div class="inset-y-0 relative mt-1 end-0 flex items-center pointer-events-none pe-3">
									<svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
										<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
									</svg>
									<small class="text-red-400 mx-2 space-x-1">{{ $message }}</small>
								</div>
							@enderror
						</div>
						<div>
							<label class="block text-gray-700 dark:text-white mb-1" for="last_name">
								Prénoms du receveur
							</label>
							<input name="last_name" wire:model.live='last_name' placeholder="Renseignez les Prénoms du receveur..." class="w-full @error('last_name') text-red-400 border border-red-700 @else dark:text-white @enderror rounded-lg py-2 px-3 dark:bg-gray-700 " id="last_name" type="text">
							</input>
							@error('last_name')
								<div class="inset-y-0 relative mt-1 end-0 flex items-center pointer-events-none pe-3">
									<svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
										<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
									</svg>
									<small class="text-red-400 mx-2 space-x-1">{{ $message }}</small>
								</div>
							@enderror
						</div>
					</div>
					<div class="mt-4 grid grid-cols-2 gap-4">
						<div>
							<label class="block text-gray-700 dark:text-white mb-1" for="phone">
								Contacts
							</label>
							<input name="phone" wire:model.live='phone' placeholder="Renseignez les contacts du receveur..." class="w-full @error('phone') text-red-400 border border-red-700 @else dark:text-white @enderror rounded-lg py-2 px-3 dark:bg-gray-700 " id="phone" type="text">
								</input>
								@error('phone')
									<div class="inset-y-0 relative mt-1 end-0 flex items-center pointer-events-none pe-3">
										<svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
											<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
										</svg>
										<small class="text-red-400 mx-2 space-x-1">{{ $message }}</small>
									</div>
								@enderror
						</div>
						<div class="">
							<label class="block text-gray-700 dark:text-white mb-1" for="street_address">
								Adresse
							</label>
							<input name="street_address" wire:model.live='street_address' placeholder="Renseignez l'adresse du receveur..." class="w-full @error('street_address') text-red-400 border border-red-700 @else dark:text-white @enderror rounded-lg py-2 px-3 dark:bg-gray-700 " id="street_address" type="text">
								</input>
								@error('street_address')
									<div class="inset-y-0 relative mt-1 end-0 flex items-center pointer-events-none pe-3">
										<svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
											<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
										</svg>
										<small class="text-red-400 mx-2 space-x-1">{{ $message }}</small>
									</div>
								@enderror
						</div>
					</div>
					
					<div class="mt-4 grid grid-cols-2 gap-4">
						<div class="">
							<label class="block text-gray-700 dark:text-white mb-1" for="city">
								Ville
							</label>
							<input name="city" wire:model.live='city' placeholder="Renseignez la ville de réception..." class="w-full @error('city') text-red-400 border border-red-700 @else dark:text-white @enderror rounded-lg py-2 px-3 dark:bg-gray-700 " id="city" type="text">
							</input>
							@error('city')
								<div class="inset-y-0 relative mt-1 end-0 flex items-center pointer-events-none pe-3">
									<svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
										<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
									</svg>
									<small class="text-red-400 mx-2 space-x-1">{{ $message }}</small>
								</div>
							@enderror
						</div>

						<div class="">
							<label class="block text-gray-700 dark:text-white mb-1" for="images">
								Images de reférence (Facultative et au plus 03)
							</label>
							<input multiple name="images" wire:model.live='images' placeholder="Renseignez des images de reférence..." class=" w-full @error('images') text-red-400 border border-red-700 @else dark:text-white @enderror rounded-lg py-2 px-3 dark:bg-gray-700 " id="images" type="file">
							</input>
							@error('images')
								<div class="inset-y-0 relative mt-1 end-0 flex items-center pointer-events-none pe-3">
									<svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
										<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
									</svg>
									<small class="text-red-400 mx-2 space-x-1">{{ $message }}</small>
								</div>
							@enderror
						</div>
					</div>
					<div class="mt-4 grid grid-cols-2 gap-4">
						<div class="">
							<label class="block text-gray-700 dark:text-white mb-1" for="shipping_method">
								Méthode livraison
							</label>
							<select name="shipping_method" wire:model.live='shipping_method' class="bg-slate-600 py-2 border rounded-md w-full text-lg @error('shipping_method') text-red-400 border-red-700 @else dark:text-white @enderror" id="shipping_method">
								<option value="{{ null }}"> Sélectionner la méthode de livraison </option>
								@foreach ($shipping_methods as $shpmk => $shm)
									<option value="{{ $shpmk }}"> {{ $shm }} </option>
								@endforeach
							</select>
							@error('shipping_method')
								<div class="inset-y-0 relative mt-1 end-0 flex items-center pointer-events-none pe-3">
									<svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
										<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
									</svg>
									<small class="text-red-400 mx-2 space-x-1">{{ $message }}</small>
								</div>
							@enderror
						</div>

						<div class="">
							<label class="block text-gray-700 dark:text-white mb-1" for="currency">
								La dévise
							</label>
							<select name="currency" wire:model.live='currency' class="bg-slate-600 py-2 border rounded-md w-full text-lg @error('currency') text-red-400 border-red-700 @else dark:text-white @enderror" id="currency">
								<option value="{{ null }}"> Sélectionner la dévise </option>
								@foreach ($currencies as $dk => $d)
									<option value="{{ $dk }}"> {{ $d }} </option>
								@endforeach
							</select>
							@error('currency')
								<div class="inset-y-0 relative mt-1 end-0 flex items-center pointer-events-none pe-3">
									<svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
										<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
									</svg>
									<small class="text-red-400 mx-2 space-x-1">{{ $message }}</small>
								</div>
							@enderror
							
						</div>
					</div>
					<div class="grid grid-cols-2 gap-4 mt-4">
						<div>
							<label class="block text-gray-700 dark:text-white mb-1" for="state">
								Etat ou Commune
							</label>
							<input name="state" wire:model.live='state' placeholder="Renseignez la commune ou l'état du receveur..." class="w-full @error('state') text-red-400 border border-red-700 @else dark:text-white @enderror rounded-lg py-2 px-3 dark:bg-gray-700 " id="state" type="text">
							</input>
							@error('state')
								<div class="inset-y-0 relative mt-1 end-0 flex items-center pointer-events-none pe-3">
									<svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
										<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
									</svg>
									<small class="text-red-400 mx-2 space-x-1">{{ $message }}</small>
								</div>
							@enderror
						</div>
						<div>
							<label class="block text-gray-700 dark:text-white mb-1" for="zip_code">
								Code ZIP ou Postal (Facultative)
							</label>
							<input name="zip_code" wire:model.live='zip_code' placeholder="Renseignez le code ZIP ou postal..." class="w-full @error('zip_code') text-red-400 border border-red-700 @else dark:text-white @enderror rounded-lg py-2 px-3 dark:bg-gray-700 " id="zip_code" type="text">
							</input>
							@error('zip_code')
								<div class="inset-y-0 relative mt-1 end-0 flex items-center pointer-events-none pe-3">
									<svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
										<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
									</svg>
									<small class="text-red-400 mx-2 space-x-1">{{ $message }}</small>
								</div>
							@enderror
						</div>
					</div>
					<div class="grid gap-4 mt-4">
						<div>
							<label class="block text-gray-700 dark:text-white mb-1" for="notes">
								Ajouter une notes (Facultative)
							</label>
							<textarea name="notes" wire:model.live='notes' placeholder="Renseignez ce que vous voulez faire savoir..." class="w-full @error('notes') text-red-400 border border-red-700 @else dark:text-white @enderror rounded-lg py-2 px-3 dark:bg-gray-700 " id="notes" type="text">
							
							</textarea>
							@error('notes')
								<div class="inset-y-0 relative mt-1 end-0 flex items-center pointer-events-none pe-3">
									<svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
										<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
									</svg>
									<small class="text-red-400 mx-2 space-x-1">{{ $message }}</small>
								</div>
							@enderror
						</div>
					</div>
				</div>
				<div for="payment_method" class="text-lg font-semibold dark:text-white mb-4">
                    <hr class="bg-slate-400 my-1 h-1 rounded">
					Méthode de Payement
                    <hr class="bg-slate-400 my-1 h-1 rounded">
				</div>
				<div class="w-full flex justify-between gap-4 mt-4">
					<div class="w-7/12">
						<select name="payment_method" wire:model.live='payment_method' class="bg-slate-600 py-2 border rounded-xl w-full text-center text-lg @error('payment_method') text-red-400 border-red-700 @else dark:text-white @enderror" id="payment_method">
							<option value="{{ null }}"> Sélectionner la méthode de payement </option>
							@foreach ($payments_methods as $key => $methd)
								<option value="{{ $key }}"> {{ $methd }} </option>
							@endforeach
						</select>
						@error('payment_method')
						<div class="inset-y-0 relative mt-1 end-0 flex items-center pointer-events-none pe-3">
							<svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
							    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
							</svg>
                            @error('payment_method')
                            <small class="text-red-400 mx-2 space-x-1">{{ $message }}</small>
                            @enderror
						</div>
						@enderror
					</div>
					<div class="w-3/12">
						<a href="{{route('user.cart', ['identifiant' => auth_user()->identifiant])}}" class="bg-blue-500 w-full py-3 rounded-xl block text-center text-lg text-white hover:bg-blue-700">
							Voir panier
						</a>
					</div>
				</div>

				<div class="border rounded-lg bg-slate-400 w-full p-2 text-center py-6 my-2" wire:loading wire:target='images'>
					<b class=" text-gray-200 text-center">
						Chargement image en cours... Veuillez patientez!
					</b>
				</div>
				@if(count($images))
				<div class="border grid grid-cols-3 gap-4 rounded-lg p-2 my-2" >
					@foreach ($images as $image)
						<img wire:loaded wire:target='images' class="mt-1 border rounded-sm" src="{{$image->temporaryUrl()}}" alt="">
					@endforeach
				</div>
				@endif
				
			</div>
			<!-- End Card -->
		</div>
		<div class="md:col-span-12 lg:col-span-4 col-span-12">
			<div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
				<div class="text-xl font-bold text-center text-gray-100 dark:text-white mb-2">
					Détails de la commande
				</div>
                <hr class="bg-slate-400 my-4 h-1 rounded">
				<div class="flex justify-between mb-2 dark:text-white font-bold">
					<span>
						Sous total
					</span>
					<span>
						{{ Number::currency($grand_total, 'CFA') }}
					</span>
				</div>
				<div class="flex justify-between mb-2  dark:text-white font-bold">
					<span>
						Taxes
					</span>
					<span>
						0.00
					</span>
				</div>
				<div class="flex justify-between mb-2  dark:text-white font-bold">
					<span>
						Coût de la livraion
					</span>
					<span>
						{{ Number::currency($shipping_amount, 'CFA') }}
					</span>
				</div>
				<hr class="bg-slate-400 my-4 h-1 rounded">
				<div class="flex justify-between mb-2  dark:text-white font-bold">
					<span>
						Montant total
					</span>
					<span>
						{{ Number::currency($grand_total + $shipping_amount, 'CFA') }}
					</span>
				</div>
				</hr>
			</div>
			<a href="#" wire:click='checkout' wire:loading.class='opacity-50' wire:target='checkout' class="cursor-pointer py-3 px-4 inline-flex justify-center items-center gap-x-2 font-semibold border bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
				<span wire:loading wire:target='checkout'>
					<span class="fa animate-spin fa-rotate float-end mt-2"></span>
					<span class="mx-2">Traitement en cours </span>
				</span>
				<span wire:loading.remove wire:target='checkout'>Soumettre l'achat</span>
			</a>
			<div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
				<div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
					Détails du panier <span class="float-right text-orange-500">{{ numberZeroFormattor(count($carts_items)) }} article(s)</span>
				</div>
				<ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
					@foreach ($carts_items as $book_id => $item)
					<li class="py-3 sm:py-4">
						<div class="flex items-center">
							<div class="flex-shrink-0">
								<img alt="Neil image" class="w-12 h-12 rounded" src="{{url('storage', $item['image'])}}">
								</img>
							</div>
							<div class="flex-1 min-w-0 ms-4">
								<p class="text-sm font-medium text-gray-900 truncate dark:text-white">
									{{ $item['name'] }}
								</p>
								<p class="text-sm text-gray-500 truncate dark:text-gray-400">
									Quantité: {{ numberZeroFormattor($item['quantity']) }}
								</p>
							</div>
							<div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
								{{ Number::currency($item['total_amount'], 'CFA') }}
							</div>
						</div>
					</li>
					@endforeach
					
				</ul>
			</div>
		</div>
	</div>
    @else
    <div class="w-full my-8 bg-red-400 rounded-full py-3 border flex justify-center">
        <b class="text-red-800 text-2xl text-center">Oupps, votre panier est vide!!!</b>
    </div>
    <div class="md">
        <a class=" w-full mt-10" href="{{route('shopping.home')}}">
          <h3 class="bg-blue-500 hover:bg-green-600 text-white text-2xl rounded-full text-center py-4 mt-4 w-full">
            <b>Faite un tout à la Librairie maintenant</b>
          </h3>
        </a>
    </div>
    @endif
    
</div>