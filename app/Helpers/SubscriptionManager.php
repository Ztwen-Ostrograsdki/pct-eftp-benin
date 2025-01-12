<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class SubscriptionManager
{
	public static function putPersoDataIntoSession($data)
	{
		Session::put('persoData', json_encode($data));

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
		Session::queue('professionnalData', json_encode($data));
	}


	public static function getProfessionnalData() : ?array
	{
		return (array)json_decode(session('professionnalData'));
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
	}

	public static function clearDataFromSession($target = null)
	{
		Session::forget($target);
	}

	
}
