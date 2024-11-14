<?php
namespace App\Helpers\Dater\Formattors;




/**
 * Faker class use to make the fakes data
 */
class ZtwenFaker{

	public static function gender(array $gends = ['female', 'male']): ?string
	{
		return $gends[rand(0, 1)];
	}

	public static function year()
	{
		$years = [2014, 2015, 2016, 2017, 2018, 2019];
		return $years[rand(0, 5)];
	}

	public static function month()
	{
		$months = [
            "Janvier",
            "Février",
            "Mars",
            "Avril",
            "Mai",
            "Juin",
            "Juillet",
            "Août",
            "Septembre",
            "Octobre",
            "Novembre",
            "Décembre"

        ];

        $month = $months[rand(0, 11)];
        return $month;
	}

	public static function level()
	{
		$levels = ['secondary', 'primary'];
		return $levels[rand(0, 1)];
	}

	public static function residence()
	{
		$residences = ['Cotonou', 'Porto Novo', 'Calavi', 'Come', 'Grand-Popo', 'Akpakpa'];
		return $residences[rand(0, 5)];
	}

	public static function phoneNumber():?int
	{
		return rand(94959878, 99782520);
	}


	
	





}