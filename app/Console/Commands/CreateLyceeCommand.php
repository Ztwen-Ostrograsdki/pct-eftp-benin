<?php

namespace App\Console\Commands;

use App\Events\InitNewLyceeDataInsertionEvent;
use App\Helpers\Tools\RobotsBeninHelpers;
use Illuminate\Console\Command;

class CreateLyceeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:lycees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Création des lycées par défaut';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lycess = RobotsBeninHelpers::getLycees();

        foreach($lycess as $department_id => $lyces){

            if(count($lyces)){

                $department = RobotsBeninHelpers::getDepartments($department_id);

                foreach($lyces as $city_name => $these){

                    if(count($these)){

                        foreach($these as $lycee){

                            if($lycee){

                                $data = [
                                    'name' => $lycee,
                                    'provisor' => null,
                                    'censeur' => null,
                                    'is_public' => true,
                                    'department' => $department,
                                    'city' => $city_name,
                                    'rank' => null,
                                    'description' => "Un lycée dans la ville de " . $city_name,

                                ];

                                $dispatched = InitNewLyceeDataInsertionEvent::dispatch($data, null);

                            }


                        }


                    }
                }
            }


        }


    }
}
