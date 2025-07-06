<div class="flex flex-col justify-center items-center w-full"
x-data="{
    expiresAt: {{ request()->query('expires') }} * 1000,
    secondsLeft: 0,
    timer: null,

    redirectToExpired() {
        window.location.href = '{{ route('error.419') }}';
    },

    startCountdown() {
        const update = () => {
            const now = Date.now();
            this.secondsLeft = Math.floor((this.expiresAt - now) / 1000);

            if (this.secondsLeft <= 0) {
                clearInterval(this.timer);
                this.redirectToExpired();
            }
        };

        update();
        this.timer = setInterval(update, 1000);
    }
}"
x-init="startCountdown()"

>
    <h2 class="text-xl p-2 py-5 mb-4 w-full text-center z-bg-secondary-light text-sky-500 letter-spacing-1 font-semibold border flex flex-col gap-y-4">
        <span class="uppercase">
            Lecture de l’épreuve
            <span class="text-yellow-400">
                {{ $the_file->uuid }}
            </span>
        </span>
        <span x-show="secondsLeft > 1" class="text-gray-300 uppercase">
            Temps restant avant fermeture de la page: <span class="text-green-400 lowercase" x-text="secondsLeft  + ' secondes'"></span>
        </span>
        <span x-show="secondsLeft <= 1" class="text-red-500">
            🔒 Page expirée
        </span>
    </h2>

    <iframe
        src="{{ asset('pdfjs/web/viewer.html') }}?file={{ urlencode($secureUrl) }}"
        width="90%"
        height="100%"
        style="border: none; height: 90vh;">
    </iframe>

</div>
