<div>
    <style>
        @keyframes fade-in-down {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-down {
        animation: fade-in-down 0.3s ease-out;
    }
    </style>
    <div 
        x-data="{
            init() {
                window.Echo.channel('chat')
                    .listen('.message.sent', (e) => {
                        Livewire.dispatch('messageReceived');
                    });
            },
            loadMore() {
                @this.call('loadMore');
            }
        }" 
        x-init="init"
        class="flex flex-col-reverse overflow-y-auto h-screen p-4"
        @scroll.window="if ($el.scrollTop === 0) loadMore()"
    >
        @foreach ($messages as $message)
            <div 
                class="flex gap-2 mb-4 animate-fade-in-down {{ $message->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}"
            >
                @if($message->user_id !== auth()->id())
                    <img src="{{ $message->user->avatar_url }}" class="w-8 h-8 rounded-full" alt="avatar">
                @endif
                <div class="max-w-xs bg-white p-2 rounded-2xl shadow">
                    <p class="text-sm text-gray-900">{{ $message->user->name }}</p>
                    @if ($message->file_path)
                        <a href="{{ asset('storage/'.$message->file_path) }}" class="text-blue-600 underline">Voir PDF</a>
                    @endif
                    <p class="text-gray-800">{{ $message->message }}</p>
                    <p class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</p>
                </div>
            </div>
        @endforeach
    </div>

</div>
