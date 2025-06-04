<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Helpers\Tools\SpatieManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        return ;

        DB::beginTransaction();

        try {
            $permissions = SpatieManager::getPermissions();

            $roles = SpatieManager::getRoles();

            foreach ($permissions as $perm) {

                Permission::firstOrCreate(['name' => $perm]);

            }

            foreach ($roles as $role) {

                Role::firstOrCreate(['name' => $role]);

            }

            $master = Role::where('name', 'master')->first();

            $master->syncPermissions($permissions);

            DB::commit();

        } catch (\Throwable $th) {

            DB::rollBack();
        }

        

        // $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        // $superAdmin->syncPermissions($permissions);



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
