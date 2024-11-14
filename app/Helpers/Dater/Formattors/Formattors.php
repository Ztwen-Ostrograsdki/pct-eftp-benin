<?php
namespace App\Helpers\Dater\Formattors;


class Formattors{


    public static function getNameAndSurname(string $defaultName)
    {

        if ($defaultName == ""  || $defaultName == null || empty($defaultName)){
            return [];
        }else{
            $each = explode(' ', $defaultName);

            $name = strtoupper($each[0]);
            if (count($each) > 1) {
               $tabSurname = [];
                for ($i = 1; $i < count($each); $i++) { 
                    $tabSurname[] = $each[$i];
                }
                $surname =  ucwords(implode(' ', $tabSurname));
            }
            else{
                $surname = "";
            }

            return [ 'name' => $name, 'surname' => $surname];
        }

    }


    /**
     * Use to cut a text 
     * @param  string      $content the text
     * @param  int|integer $limit   [description]
     * @return null|string             [description]
     */
    public static function excerpt (string $content, int $limit = 200):?string 
    {
        $strLengh = mb_strlen($content);
        if($strLengh <= $limit) {
            return $content;
        }
        $lastSpace = mb_strpos($content, ' ', $limit);
        return mb_substr($content, 0, $lastSpace).' ...';
    }


	public static function dateFormattor($dateTime)
	{
		$date = mb_substr($dateTime, 0, 10);
        $time = mb_substr($dateTime, 11, 19);

        $m = (int)mb_substr($date, 5,2);

        $month = self::monthOfADate($m);

        $parts = array_reverse(explode('-', $date));
        unset($parts[1]);
        $date = implode(' '.$month.' ', $parts);

        $t = new \DateTime($time);
        $h = $t->format('H');
        $m = $t->format('i');
        

        return $date. " à ". $hour = $h."h ".$m."'"; 


	}


    public static function numberZeroFormattor($number)
    {
        return $number >= 10 ? $number : '0' . $number;
    }

	/**
	 * Return the month of the given index
	 * @param  int    $index numeric index the the month
	 * @return string      the month
	 */
	public static function monthOfADate(int $index){
	
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
            "novembre",
            "Décembre"

        ];
        return $months[$index];
    }


    public static function birthFormattor($date)
    {
        
    }





}