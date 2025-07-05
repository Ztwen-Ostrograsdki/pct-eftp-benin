<div class="flex flex-col justify-center items-center">
    <h2 class="text-xl font-bold mb-4 text-center">Lecture de l’épreuve</h2>

    <iframe
        src="{{ asset('pdfjs/web/viewer.html') }}?file={{ urlencode(route('epreuve.secure', $epreuve->uuid)) }}"
        width="90%"
        height="100%"
        style="border: none; height: 90vh;">
    </iframe>

    <style>
        #download, #print {
          display: none !important;
        }
      </style>
</div>
