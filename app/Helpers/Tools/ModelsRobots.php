<?php
namespace App\Helpers\Tools;

use App\Models\User;

class ModelsRobots{

    public $model;

    public function __construct($model = null) {

        $this->model = $model;
    }

    public static function getUserAdmins($pluckindColumn = 'id', $except = null)
    {
        $admins = User::where('ability', 'admin')
                      ->orWhere('ability', 'master')
                      ->orWhere('id', 1)
                      ->pluck($pluckindColumn)
                      ->toArray();

        return count($admins) ? $admins : [1];
    }





}