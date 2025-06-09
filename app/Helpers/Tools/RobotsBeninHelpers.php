<?php
namespace App\Helpers\Tools;

class RobotsBeninHelpers {


	public static function getDepartments($department_id = null)
	{
		$data = [
			1 => 'ALIBORI',
			2 => 'ATACORA',
			3 => 'ATLANTIQUE',
			4 => 'BORGOU',
			5 => 'COLLINES',
			6 => 'COUFFO',
			7 => 'DONGA',
			8 => 'LITTORAL',
			9 => 'MONO',
			10 => 'OUEME',
			11 => 'PLATEAU',
			12 => 'ZOU',
		];

		if(!$department_id) 
			return $data;

		else
			return $data[$department_id];
	}

	public static function getCities($department_id = null)
	{
		$data = [

			1 => [
				'BANIKOARA',
				'GOGOUNOU',
				'KANDI',
				'KARIMAMA',
				'MALANVILLE',
				'SEGBANA',
			],

			2 => [
				'BOUKOUMBE',
				'COBLY',
				'KEROU',
				'KOUANDE',
				'MATERI',
				'NATITINGOU',
				'OUASSA-PEHUNCO',
				'TANGUIETA',
				'TOUKOUNTOUNA',

			],

			3 => [
				'ABOMEY-CALAVI',
				'ALLADA',
				'KPOMASSE',
				'OUIDAH',
				'SO-AVA',
				'TOFFO',
				'TORI-BOSSITO',
				'ZE',
			],

			4 => [
				'BEMBEREKE',
				'KALALE',
				"N'DALI",
				'NIKKI',
				'PARAKOU',
				'PERERE',
				'SINENDE',
				'TCHAOUROU',
			],

			5 => [
				'BANTE',
				'DASSA-ZOUME',
				'GLAZOUE',
				'OUESSE',
				'SAVALOU',
				'SAVE',
			],

			6 => [
				'APLAHOUE',
				'DJAKOTOMEY',
				'DOGBO',
				'KLOUEKANMEY',
				'LALO',
				'TOVIKLIN',
			],

			7 => [

				'BASSILA',
				'COPARGO',
				'DJOUGOU',
				'OUAKE',

			],
			8 => [
				'COTONOU',
			],

			9 => [
				'ATHIEME',
				'BOPA',
				'COME',
				'GRAND-POPO',
				'HOUEYOGBE',
				'LOKOSSA',
			],

			10 => [
				'ADJARRA',
				'ADJOHOUN',
				'AGUEGUES',
				'AKPRO-MISSERETE',
				'AVRANKOU',
				'BONOU',
				'DANGBO',
				'PORTO-NOVO',
				'SEME-PODJI',
			],

			11 => [
				'ADJA-OUERE',
				'IFANGNI',
				'KETOU',
				'POBE',
				'SAKETE',

			],

			12 => [

				'ABOMEY',
				'AGBANGNIZOUN', 
				'BOHICON', 
				'COVE', 
				'DJIDJA', 
				'OUINHI', 
				'ZAGNANADO', 
				'ZA-KPOTA', 
				'ZOGBODOMEY', 

			]

		];


		if($department_id) 

			return $data[$department_id];
		
		else

			return $data;

	}


	public static function getLycees($department_id = null, $city_name = null)
	{
		$data = [
			8 => [
				"COTONOU" =>  [
					"Lycée Technique Coulibaly",
					"Lycée Technique et Professionnel de Kpondéhou"
				]
			],
			1 => [
				"KANDI" => [
					"Lycée Technique Industriel et Commercial de Kandi"
				],
				"BANIKOARA" => [
					"Lycée Technique Agricole de Banikoara",
				],
			],
			2 => [
				"NATITINGOU" => [
					"Lycée Technique et Professionnel de Natitingou",
				],
			],
			3 => [
				"ABOMEY-CALAVI" => [
					"Lycée Technique d'Amitié Sino-Béninoise d'Akassato",
					"Lycée Technique et Professionnel d'Économie Familiale et Sociale d'Akassato",
				],
				"OUIDAH" => [
					"Lycée Technique et Professionnel de Ouidah"
				],
			],
			4 => [
				"TCHAOUROU" => [
					"Lycée Technique et Professionnel de Tchaourou",
					
				],
				"BEMBEREKE" => [
					"Lycée Technique et Professionnel d'Ina" ,
				],
			],
			9 => [
				"BOPA" => [
					"Lycée Technique et Professionnel de Bopa"
				],
				"LOKOSSA" => [
					"Lycée Technique de Lokossa",
				],
			],
			7 => [
				"DJOUGOU" => [
					"Lycée Technique et Professionnel de Djougou" 
				],
			],
			6 => [
				"DJAKOTOMEY" => [
					"Lycée Technique et Professionnel de Djakotomè"
				],
			],
			12 => [
				"BOHICON" => [
					"Lycée Technique et Professionnel de Bohicon",
				],
			],
			11 => [
				"POBE" => [
					"Lycée Technique et Professionnel de Pobè",
				],
			],
			10 => [
				"PORTO-NOVO" => [
					"Lycée Technique et Professionnel de Porto-Novo",
				],
			],
		];

		if($department_id){

			if($city_name){

				return $data[$department_id][$city_name];
			}

			else{

				return $data[$department_id];
			}

		}

		return $data;



	}

}
