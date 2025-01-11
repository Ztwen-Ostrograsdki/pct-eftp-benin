<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cookie;

class SubscriptionManager
{
	public static function setPersonnalData($data)
	{
		Cookie::queue('personnalData', json_encode($data), 60 * 24 * 7);
	}

	public static function getPersonnalData()
	{
		$data = json_decode(Cookie::get('personnalData'), true);
	}


	public static function setGraduateData($data)
	{
		Cookie::queue('graduateData', json_encode($data), 60 * 24 * 7);
	}

	public static function getGraduateData()
	{
		$data = json_decode(Cookie::get('graduateData'), true);
	}

	public static function setProfessionnalData($data)
	{
		Cookie::queue('professionnalData', json_encode($data), 60 * 24 * 7);
	}


	public static function getProfessionnalData()
	{
		$data = json_decode(Cookie::get('professionnalData'), true);
	}


	public static function clearUserDataFromCookie()
	{
		self::clearEachData();

        return [];
	}

	public static function clearEachData()
	{
		Cookie::queue(Cookie::forget('personnalData'));

		Cookie::queue(Cookie::forget('graduateData'));

		Cookie::queue(Cookie::forget('professionnalData'));
	}

	public static function clearDataFromCache($target = null)
	{

		Cookie::queue(Cookie::forget($target));

	}

	
}
