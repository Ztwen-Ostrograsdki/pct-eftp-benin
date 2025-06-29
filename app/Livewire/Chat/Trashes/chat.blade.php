<div class="flex flex-col h-full p-4 space-y-2 overflow-y-auto">
    {{-- En cours d’envoi --}}
    @foreach ($sendingMessages as $message)
        <div class="self-end bg-blue-200 text-blue-900 p-2 rounded-2xl max-w-xs opacity-70 animate-pulse">
            <p>{{ $message['body'] }}</p>
            <small class="text-xs">Envoi en cours...</small>
        </div>
    @endforeach

    {{-- Messages confirmés --}}
    @foreach ($messages as $message)
        <div class="self-{{ $message->user_id === auth()->id() ? 'end' : 'start' }} bg-gray-100 text-gray-900 p-2 rounded-2xl max-w-xs">
            <p>{{ $message->body }}</p>
            <small class="text-xs">{{ \Carbon\Carbon::parse($message->created_at)->format('H:i') }}</small>
        </div>
    @endforeach

    {{-- Formulaire --}}
    <form wire:submit.prevent="sendMessage" class="mt-auto flex gap-2 pt-4">
        <input wire:model.defer="newMessage" type="text"
               class="flex-1 border rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
               placeholder="Écrire un message..." />
        <button type="submit"
                class="bg-blue-500 text-white rounded-xl px-4 py-2 hover:bg-blue-600 transition">
            Envoyer
        </button>
    </form>
</div>
