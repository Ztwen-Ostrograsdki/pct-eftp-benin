<?php
namespace App\Helpers\Tools;

use Illuminate\Support\Str;

class DefaultData{

    public static function getTeacherStatus()
    {
        
        return [
            'acdpe' => 'ACDPE', 
            'ace' => 'ACE', 
            'ape' => 'APE', 
            'ame' => 'AME'
        ];
    }


    public static function getFiliars()
	{

		$filiars = [
            'FC' => ['name' => 'FC', 'description' => 'Froid et Climatisation', 'option' => 'Industrielle'], 
            'MA' => ['name' => 'MA', 'description' => 'Mécanique et Auto', 'option' => 'Industrielle'],
            'OBB' => ['name' => 'OBB', 'description' => 'OBB', 'option' => 'Industrielle'],
            'OG' => ['name' => 'OG', 'description' => 'Opérateur Géomètre', 'option' => 'Industrielle'],
            'FM' => ['name' => 'FM', 'description' => 'Fabrication Mécanique', 'option' => 'Industrielle'],
            'BTP' => ['name' => 'BTP', 'description' => 'Batiment et Travaux Publics', 'option' => 'Industrielle'],
            'F1' => ['name' => 'F1', 'description' => 'Mécanique Générale', 'option' => 'Technique'],
            'F2' => ['name' => 'F2', 'description' => 'Electronique', 'option' => 'Technique'],
            'F3' => ['name' => 'F3', 'description' => 'Mécanique Générale', 'option' => 'Technique'],
            'F4' => ['name' => 'F4', 'description' => 'Génie Civil', 'option' => 'Technique'],
            'IMI' => ['name' => 'IMI', 'description' => 'Installation et Maintenance Industrielle', 'option' => 'Informatique'],
            'HR' => ['name' => 'HR', 'description' => 'Hotellerie et Restauration', 'option' => 'Restauration'],
        ];

        return $filiars;

	}

    public static function getPromotions()
	{

		$promotions = [
            '1AI' => ['name' => 'Première année', 'description' => Str::random(rand(800, 500))], 
            '2AI' => ['name' => 'Deuxième année', 'description' => Str::random(rand(800, 500))], 
            '3AI' => ['name' => 'Troisième année', 'description' => Str::random(rand(800, 500))], 
            'Seconde' => ['name' => 'Seconde', 'description' => Str::random(rand(800, 500))], 
            'Première' => ['name' => 'Première', 'description' => Str::random(rand(800, 500))], 
            'Terminale' => ['name' => 'Terminale', 'description' => Str::random(rand(800, 500))], 
            'Terminale' => ['name' => 'Terminale', 'description' => Str::random(rand(800, 500))], 
        ];

        return $promotions;

	}





}