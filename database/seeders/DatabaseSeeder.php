<?php

namespace Database\Seeders;

use App\Helpers\Tools\DefaultData;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Classe;
use App\Models\Filiar;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /*$filiars = DefaultData::getFiliars();

        foreach($filiars as $filiar){

            $slug = Str::slug($filiar['description']);

            $filiar['slug'] = $slug;

            Filiar::create($filiar);
        }

        */


        /*$promotions = Promotion::all();

        $filiars = Filiar::all();

        foreach($filiars as $filiar){

            foreach($promotions as $promo){

                $name = $promo->name . '-' . $filiar->name;


                $data = [
                    'name' => $name,
                    'slug' => Str::lower(Str::slug($name)),
                    'promotion_id' => $promo->id,
                    'filiar_id' => $filiar->id,
                    'description' => "Une description de la classe de " . $name

                ];

                if($name !== 'Seconde-BTP'){

                    Classe::create($data);
                }


            }

            
        }
        */

        

        
    }
}
