<?php

namespace App\Livewire\Master;

use App\Helpers\LivewireTraits\ListenToEchoEventsTrait;
use App\Models\Communique;
use App\Models\Epreuve;
use App\Models\ForumChat;
use App\Models\NewsLetterSubscribers;
use App\Models\SupportFile;
use App\Models\Visitor;
use Livewire\Attributes\On;
use Livewire\Component;

class DashboardSiteStats extends Component
{
    public $counter = 1;

    use ListenToEchoEventsTrait;
    
    public function render()
    {
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

        $visitors = Visitor::all()->count();

        $subscribers = NewsLetterSubscribers::all()->count();

        $top_chating_user = ForumChat::select('user_id')
                                     ->selectRaw('COUNT(*) as message_count')
                                     ->groupBy('user_id')
                                     ->orderByDesc('message_count')
                                     ->with('user')
                                     ->first();

        $epreuves_stats_data = Epreuve::select('is_exam')
                                    ->selectRaw('SUM(downloaded) as total_downloads')
                                    ->selectRaw('SUM(CASE WHEN authorized = 1 THEN 1 ELSE 0 END) as authorized_count')
                                    ->selectRaw('SUM(CASE WHEN authorized = 0 THEN 1 ELSE 0 END) as unauthorized_count')
                                    ->groupBy('is_exam')
                                    ->get();

        $epreuves_stats = [
            'exam' => [
                'total_downloads' => 0,
                'authorized_count' => 0,
                'unauthorized_count' => 0,
                'all' => 0,
            ],
            'simple' => [
                'total_downloads' => 0,
                'authorized_count' => 0,
                'unauthorized_count' => 0,
                'all' => 0,
            ],
            
            'all' => [
                'total_downloads' => 0,
                'authorized_count' => 0,
                'unauthorized_count' => 0,
                'all' => 0,
            ],
        ];

        $all_epreuves = 0;

        $epreuves_downloadeds = 0;

        $confirmeds_epreuves = 0;

        $unconfirmeds_epreuves = 0;
        
        foreach ($epreuves_stats_data as $row) {

            $key = $row->is_exam ? 'exam' : 'simple';

            $epreuves_stats[$key] = [
                'total_downloads' => $row->total_downloads,
                'authorized_count' => $row->authorized_count,
                'unauthorized_count' => $row->unauthorized_count,
                'all' => $row->unauthorized_count + $row->authorized_count,
            ];

            $epreuves_downloadeds = $epreuves_downloadeds + $row->total_downloads;

            $confirmeds_epreuves = $confirmeds_epreuves + $row->authorized_count;

            $unconfirmeds_epreuves = $unconfirmeds_epreuves + $row->unauthorized_count;

            $all_epreuves = $confirmeds_epreuves + $unconfirmeds_epreuves;
            
        }

        $epreuves_stats['all'] = [
            'total_downloads' => $epreuves_downloadeds,
            'authorized_count' => $confirmeds_epreuves,
            'unauthorized_count' => $unconfirmeds_epreuves,
            'all' => $all_epreuves,
        ];
        
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
                'visitors',
                'subscribers',
                'top_chating_user',
                'epreuves_stats',
            )
        );
    }


    #[On("LiveNewVisitorHasBeenRegistredEvent")]
    public function newVisitor()
    {
        $this->counter = getRand();
    }
}
