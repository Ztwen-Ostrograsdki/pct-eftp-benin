<?php
namespace App\Helpers\Dater;


trait DateAgoBuilder{


    /**
     * Undocumented function
     *
     * @param array $matrice
     * @return string
     */
    public function __AgoToString(array $matrice)
    {
        $string = "Il y a ";
        if($matrice['Y']){
            if($matrice['Y'] > 1){
                $string .= $matrice['Y']. " ans ";
    
            }
            else{
                $string .= " un an ";
            }

        }
        else{
            if($matrice['M']){
                if($matrice['M'] > 1){
                    $string .= $matrice['M'] . " mois ";
                }
                else{
                    $string .= " un mois ";
                }
            }
            else{
                if($matrice['J']){
                    $days = $matrice['J'];
                    if($days >= 7){
                        $weeks = floor($days / 7);
                        if($weeks > 1){
                            $string .= $weeks . " semaines";
                        }
                        else{
                            $string .= " une semaine";
                        }
                    }
                    else{
                        if($matrice['J'] > 1){
                            $string .= $matrice['J'] . " jours ";
                        }
                        else{
                            $string .= "un jour ";
                        }
                    }
                }
                else{
                    if($matrice['H']){
                        if($matrice['H'] > 1){
                            $string .= $matrice['H'] . " H ";
                        }
                        else{
                            $string .= " une heure ";
                        }
                    }
                    else{
                        if($matrice['m']){
                            if($matrice['m'] > 1){
                                $string .= $matrice['m'] . " min ";
                            }
                            else{
                                $string .= " 01 min ";
                            }
                            if($matrice['s']){
                                if($matrice['s'] > 1){
                                    $string .= $matrice['s'] . " sec ";
                                }
                                else{
                                    $string .= $matrice['s'] . " une seconde ";
                                }
                            }
                        }
                        else{
                            $string .= " moins d'une minute";
                            // if($matrice['s'] > 1){
                            //     $string .= $matrice['s'] . " secondes ";
                            // }
                            // else{
                            //     $string .= $matrice['s'] . " une seconde ";
                            // }
                        }
                    }
                }
            }
        }
        
        return $string;
    }


    public function __strings($matrice_created, $matrice_updated = null)
    {
        $strings = [];
        $strings['created_at'] = $this->__AgoToString($matrice_created);
        if($matrice_updated){
            $strings['updated_at'] = $this->__AgoToString($matrice_updated);
        }

        return $strings;
    }


    public function __diffDateAgoManager(int $diff)
    {
                    
         $year = 0;
         $year_r = 0;

         $mois = 0;
         $mois_r = 0;

         $jours = 0;
         $jours_r = 0;

         $hours = 0;
         $hours_r = 0;

         $minutes = 0;
         $minutes_r = 0;

         $secondes = 0;
         $secondes_r = 0;

         $Y = $diff / (12*30*24*60*60);
         $Y_r = 0;
         $M = $diff / (30*24*60*60);
         $J = 0;
         $J_r = 0;
         $H = 0;
         $H_r = 0;
         $Mn = 0;
         $Mn_r = 0;
         $Sec = 0;
         $Sec_r = 0;

        $less = $diff / 60;
        if ($less > 0) {
            
        if ($Y < 1) {
            if ($M < 1) {
                // la durée n'atteint pas un mois donc on passe aux jours
                $J = $M * 30;
                if ($J < 1) {
                    // la durée n'atteint pas un jour on passe aux heures
                    $H = $J * 24;
                    if ($H < 1) {
                        // La durée n'atteint pas une heure on passe aux minutes
                        $Mn = $H * 60;
                        if ($Mn < 1) {
                            // La durée n'atteint pas une minute on passe aux secondes
                            $secondes = floor($Mn*60);
                        }
                        else{
                            $minutes = floor($Mn);
                            $minutes_r = $Mn - $minutes;
                            $secondes = floor($minutes_r * 60);
                        }
                    }
                    else{
                        $hours = floor($H);
                        $hours_r = $H - $hours;
                        $Mn = $hours_r * 60;
                        if ($Mn < 1) {
                            // La durée n'atteint pas une minute on passe aux secondes
                            $secondes = floor($Mn * 60);
                        }
                        else{
                            $minutes = floor($Mn);
                            $secondes = floor(($Mn - $minutes) * 60);
                        }
                    }
                }
                else{
                    $jours = floor($J);
                    $J_r = $J - $jours;
                    $H = $J_r * 24;
                    if ($H < 1) {
                        // La durée n'atteint pas une heure on passe aux minutes
                        $Mn = $H * 60;
                        if ($Mn < 1) {
                            // La durée n'ateint pas une minute on passe aux secondes
                            $secondes = floor($Mn * 60);
                        }
                        else{
                            $minutes = floor($Mn);
                            $Mn_r = $Mn - $minutes;
                            $secondes = floor($Mn_r * 60);
                        }
                    }
                    else{
                        $hours = floor($H);
                        $H_r = $H - $hours;
                        $Mn = $H_r * 60;
                        if ($Mn < 1) {
                            //La durée n'atteint pas une minute on passe aux secondes
                            $Sec = $Mn * 60;
                        }
                        else{
                            $minutes = floor($Mn);
                            $Mn_r = $Mn - $minutes;
                            $secondes = floor($Mn_r * 60);
                        }
                    }
                }
            }
            else{
                $mois = floor($M);
                $mois_r = $M - $mois;
                $J = $mois_r * 30;
                if ($J < 1) {
                    //La durée n'atteint pas un jours on passe aux heures
                    $H = $J * 24;
                    if ($H < 1) {
                        // la durée n'atteint pas une heure on passe aux minutes
                        $Mn = $H * 60;
                        if ($Mn < 1) {
                            // la durée n'atteint pas une minute on passe aux secondes
                            $secondes = floor($Mn*60);
                        }
                        else{
                            $minutes = floor($Mn);
                            $minutes_r = $Mn - $minutes;
                            $secondes = floor($minutes_r * 60);
                        }
                    }
                    else{
                        $hours = floor($H);
                        $hours_r = $H - $hours;
                    }
                }
                else{
                    $jours = floor($J);
                    $J_r = $J - $jours;
                    $H = $J_r * 24;
                    if ($H < 1) {
                        // La durée n'atteint pas une heure on passe aux minutes
                        $Mn = $H * 60;
                        if ($Mn < 1) {
                            // La durée n'atteint pas une minute on pase aux secondes
                            $secondes = floor($Mn * 60);
                        }
                        else{
                            $minutes = floor($Mn);
                            $minutes_r = $Mn - $minutes;
                            $Sec = $minutes_r * 60;
                            if ($Sec < 1) {
                                // la durée n'atteint pas une seconde on passe aux millisecondes
                            }
                            else{
                                $secondes = floor($Sec);
                            }
                        }
                        
                    }
                    else{
                        $hours = floor($H);
                        $hours_r = $H - $hours;
                        $Mn = $hours_r  * 60;
                        if ($Mn < 1) {
                            // La durée n'atteint pas une minute on passe aux secondes
                            $secondes = floor($Mn * 60);
                        }
                        else{
                            $minutes = floor($Mn);
                            $minutes_r = $Mn - $minutes;
                            $Sec = $minutes_r * 60;
                            if ($Sec < 1) {
                                // la durée n'atteint pas une seconde on passe aux millisecondes
                            }
                            else{
                                $secondes = floor($Sec);
                            }
                        }
                    }
                }
            }

        }
        else{
            $year = floor($Y);
            $M = ($Y - $year) * 12;
            if ($M < 1) {
                // la durée n'atteint pas un mois donc on passe aux jours
                $J = $M * 30;
                if ($J < 1) {
                    // la durée n'atteint pas un jour on passe aux heures
                    $H = $J * 24;
                    if ($H < 1) {
                        // La durée n'atteint pas une heure on passe aux minutes
                        $Mn = $H * 60;
                        if ($Mn < 1) {
                            // La durée n'atteint pas une minute on passe aux secondes
                        }
                        else{
                            $minutes = floor($Mn);
                            $minutes_r = $Mn - $minutes;
                        }
                    }
                    else{
                        $hours = floor($H);
                        $hours_r = $H - $hours;
                    }
                }
                else{
                    $jours = floor($J);
                    $J_r = $J - $jours;
                    $H = $J_r * 24;
                    if ($H < 1) {
                        // La durée n'atteint pas une heure on passe aux minutes
                        $Mn = $H * 60;
                        if ($Mn < 1) {
                            // La durée n'ateint pas une minute on passe aux secondes
                            $secondes = floor($Mn * 60);
                        }
                        else{
                            $minutes = floor($Mn);
                            $Mn_r = $Mn - $minutes;
                            $secondes = floor($Mn_r * 60);
                        }
                    }
                    else{
                        $hours = floor($H);
                        $H_r = $H - $hours;
                        $Mn = $H_r * 60;
                        if ($Mn < 1) {
                            //La durée n'atteint pas une minute on passe aux secondes
                            $Sec = $Mn * 60;
                        }
                        else{
                            $minutes = floor($Mn);
                            $Mn_r = $Mn - $minutes;
                            $secondes = floor($Mn_r * 60);
                        }
                    }
                }
            }
            else{
                $mois = floor($M);
                $mois_r = $M - $mois;
                $J = $mois_r * 30;
                if ($J < 1) {
                    //La durée n'atteint pas un jours on passe aux heures
                    $H = $J * 24;
                    if ($H < 1) {
                        // la durée n'atteint pas une heure on passe aux minutes
                        $Mn = $H * 60;
                        if ($Mn < 1) {
                            // la durée n'atteint pas une minute on passe aux secondes
                        }
                        else{
                            $minutes = floor($Mn);
                            $minutes_r = $Mn - $minutes;
                        }
                    }
                    else{
                        $hours = floor($H);
                        $hours_r = $H - $hours;
                    }
                }
                else{
                    $jours = floor($J);
                    $J_r = $J - $jours;
                    $H = $J_r * 24;
                    if ($H < 1) {
                        // La durée n'atteint pas une heure on passe aux minutes
                        $Mn = $H * 60;
                        if ($Mn < 1) {
                            // La durée n'atteint pas une minute on pase aux secondes
                            $secondes = floor($Mn * 60);
                        }
                        else{
                            $minutes = floor($Mn);
                            $minutes_r = $Mn - $minutes;
                            $Sec = $minutes_r * 60;
                            if ($Sec < 1) {
                                // la durée n'atteint pas une seconde on passe aux millisecondes
                            }
                            else{
                                $secondes = floor($Sec);
                            }
                        }
                        
                    }
                    else{
                        $hours = floor($H);
                        $hours_r = $H - $hours;
                        $Mn = $hours_r  * 60;
                        if ($Mn < 1) {
                            // La durée n'atteint pas une minute on passe aux secondes
                            $secondes = floor($Mn * 60);
                        }
                        else{
                            $minutes = floor($Mn);
                            $minutes_r = $Mn - $minutes;
                            $Sec = $minutes_r * 60;
                            if ($Sec < 1) {
                                // la durée n'atteint pas une seconde on passe aux millisecondes
                            
                                
                            }
                            else{
                                $secondes = floor($Sec);
                            }
                        }
                    }
                }
            }
        }

        }
        else{
            // secondes = 0
            // year = 0
            // mois = 0
            // jours = 0
            // hours = 0
            // minutes = 0
        }


        return [
            'Y' => $year,
            'M' => $mois,
            'J' => $jours,
            'H' => $hours,
            'm' => $minutes,
            's' => $secondes,
        ];

    }


    public function __getDiff(int $date_created, int $date_updated = null)
    {
        $dates = [];

        $dates['created_at'] = $this->__diffDateAgoManager($date_created);

        if($date_updated){

            $dates['updated_at'] = $this->__diffDateAgoManager($date_updated);

        }

        return $dates;
    }


    // public function __to($date = null, $with_hour = false)
    // {
    //     $date = $this->created_at;

    //     $date_timestamp = Carbon::parse($date);

    //     $now_timestamp = Carbon::now();

    //     $dates = explode(' ', Carbon::parse($date)->toDateTimeString());

    //     $d = $dates[0];

    //     $t = $dates[1];

    //     $date_to_str = $this->__getDateAsString($date, null);

    //     $times = explode(':', $t);

    //     $h = $times[0];

    //     $m = $times[1];

    //     if($now_timestamp->diffInHours($date_timestamp) > 24){

    //         $to = ucwords($date_to_str);

    //         if($with_hour){

    //             $to.= ' à ' . $h . 'H ' . $m . "'";

    //         }

    //         $date_to_str = $to;

    //     }
    //     else{

    //         $date_to_str = $this->getDateAgoFormated(false);

    //     }


    //     return $date_to_str;

        
    // }





}