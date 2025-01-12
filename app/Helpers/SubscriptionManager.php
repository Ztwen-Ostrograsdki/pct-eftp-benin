<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class SubscriptionManager
{
	public static function putPersoDataIntoSession($data)
	{
		Session::put('persoData', json_encode($data));

		cookie('perso_data', json_encode($data), 60 * 24 * 30);


	}

	public static function getPersoData() : ?array
	{
		return (array)json_decode(session('persoData'));
	}


	public static function putGraduateDataIntoSession($data)
	{
		Session::put('graduateData', json_encode($data));
	}

	public static function getGraduateData() : ? array
	{
		return (array)json_decode(session('graduateData'));
	}

	public static function putProfessionnalDataIntoSession($data)
	{
		Session::put('professionnalData', json_encode($data));
	}

	public static function getProfessionnalData() : ?array
	{
		return (array)json_decode(session('professionnalData'));
	}

	public static function putEmailDataIntoSession($data)
	{
		Session::put('emailData', json_encode($data));
	}

	public static function getEmailData() : ?array
	{
		return (array)json_decode(session('emailData'));
	}

	public static function clearUserDataFromSession()
	{
		self::clearEachData();

        return [];
	}

	public static function clearEachData()
	{
		Session::forget('persoData');

		Session::forget('graduateData');

		Session::forget('professionnalData');

		Session::forget('emailData');
	}

	public static function clearDataFromSession($target = null)
	{
		Session::forget($target);
	}

	
}
