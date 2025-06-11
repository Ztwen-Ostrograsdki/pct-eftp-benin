<?php
namespace App\Helpers\Services;

use App\Models\Visitor;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;


trait VisitorsRegisterService{

	public static function getDeviceType()
	{
		$agent = request()->header('User-Agent');

		if (str_contains($agent, 'Mobile')) {

			return 'Téléphone portable';

		} elseif (str_contains($agent, 'Tablet')) {

			return 'Tablette';
		}

		return 'Ordinateur|PC';
	}


	public static function visitorRegistorManager()
    {
        if (!app()->runningInConsole()) {
            
            $ip = Request::ip();

            // Évite les doublons dans une courte période
            if (!Visitor::where('ip_address', $ip)->whereDate('visited_at', now()->toDateString())->exists()) {


                if(__isConnectedToInternet()){

					$location = Http::get("http://ip-api.com/json/{$ip}")->json(); // API gratuite

					$country = $location['country'] ?? "BENIN";

					$city =  $location['city'] ?? null;
				}
				else{

					$country = "BENIN";

					$city =  null;
				}

                Visitor::create([
                    'ip_address' => $ip,
                    'user_agent' => Request::header('User-Agent'),
                    'country' => $country,
                    'city' => $city,
                    'device_type' => self::getDeviceType(),
                ]);
            }
        }
    }

	public static function verifyUserAgent()
	{
		// $userAgent = strtolower(request()->header('User-Agent'));

		// if (str_contains($userAgent, ['bot', 'crawler', 'spider'])) {

		// 	return; // Ne pas enregistrer
		// }
	}





}

