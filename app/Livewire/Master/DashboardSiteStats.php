<?php

namespace App\Livewire\Master;

use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Models\Communique;
use App\Models\Epreuve;
use App\Models\ForumChat;
use App\Models\SupportFile;
use Livewire\Attributes\On;
use Livewire\Component;

class DashboardSiteStats extends Component
{
    public $counter = 1;

    use ListenToEchoEventsTrait;
    
    public function render()
    {
        $all_epreuves = Epreuve::all()->count();

        $confirmeds_epreuves = Epreuve::where('authorized', true)->get()->count();

        $unconfirmeds_epreuves = $all_epreuves - $confirmeds_epreuves;

        $epreuves_downloadeds = Epreuve::whereNotNull('downloaded')->get()->count();

        $all_courses_files = SupportFile::all()->count();

        $confirmeds_courses_files = SupportFile::where('authorized', true)->get()->count();

        $unconfirmeds_courses_files = $all_courses_files - $confirmeds_courses_files;

        $courses_files_downloadeds = SupportFile::whereNotNull('downloaded')->get()->count();

        $chat_messages = ForumChat::all()->count();

        $chat_images = ForumChat::whereNotNull('file')->whereIn('file_extension', ['.jpg', '.jpeg', '.png', '.gif', '.webp'])->get()->count();

        $chat_documents = ForumChat::whereNotNull('file')->whereIn('file_extension', ['.pdf', '.xlx', '.xl', '.doc', '.docx'])->get()->count();

        $communiques = Communique::all()->count();

        $communiques_visibles = Communique::where('hidden', false)->get()->count();

        $communiques_hidden = Communique::where('hidden', true)->get()->count();

        


        
        return view('livewire.master.dashboard-site-stats',
            compact(
                'all_epreuves', 
                'confirmeds_epreuves', 
                'unconfirmeds_epreuves', 
                'epreuves_downloadeds',
                'all_courses_files',
                'confirmeds_courses_files',
                'unconfirmeds_courses_files',
                'courses_files_downloadeds',
                'chat_messages',
                'chat_images',
                'chat_documents',
                'communiques',
                'communiques_visibles',
                'communiques_hidden',
            )
        );
    }


    #[On("LiveNewVisitorHasBeenRegistredEvent")]
    public function newVisitor()
    {
        $this->counter = getRand();
    }
}
