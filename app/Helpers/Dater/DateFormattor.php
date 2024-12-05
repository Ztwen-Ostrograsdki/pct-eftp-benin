<?php
namespace App\Helpers\Dater;


use App\Helpers\Dater\DateAgoBuilder;
use App\Helpers\Dater\Formattors\Formattors;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;


trait DateFormattor{

    use DateAgoBuilder;

    public $year;
    public $year_up;
    public $month;
    public $month_up;
    public $day;
    public $day_up;
    public $hour;
    public $hour_up;
    public $min;
    public $min_up;
    public $sec;
    public $sec_up;
    public $dateForUpdate;
    public $dateForCreate;
    public $dateAgoToString;
    public $dateAgoToStringForUpdated;
    public $daysTab = [
        'Lundi',
        'Mardi',
        'Mercredi',
        'Jeudi',
        'Vendredi',
        'Samedi',
        'Dimanche',
    ];
    public $monthsTab = [
        'Janvier',
        'Février',
        'Mars',
        'Mars',
        'Avril',
        'Mai',
        'Juin',
        'Juillet',
        'Août',
        'Septembre',
        'Novembre',
        'Décembre',
    ];


    public function __getDateAsString($date = null, $substr = 3, $withTime = false)
    {
        if($date){
            $parts = array_reverse(explode('-', $date));


            $day = Str::ucfirst(Carbon::parse($date)->locale('fr')->dayName);

            $dayNumber = Carbon::parse($date)->locale('fr')->day;


            $month = Str::ucfirst(Carbon::parse($date)->locale('fr')->monthName);

            $year = Carbon::parse($date)->locale('fr')->year;

            $fetch = "";

            if($substr){

                $fetch = mb_substr($day, 0, 3) . ' ' . ($dayNumber > 9 ? $dayNumber : '0'. $dayNumber) . ' ' . mb_substr($month, 0, 3) . ' ' . $year;
            }
            else{

                $fetch = $day . ' ' . ($dayNumber > 9 ? $dayNumber : '0'. $dayNumber) . ' ' . $month . ' ' . $year;
            }

            if($withTime){

                $fetch = $fetch .= " à " . $this->__getDateASHour();

            }
            

            return $fetch;

        }



    }


    public function __setDate()
    {
        $tabs = explode(' ', $this->created_at);
        $tabs_up = explode(' ', $this->updated_at);
        $dates = explode('-', $tabs[0]);
        $dates_up = explode('-', $tabs_up[0]);
        
        $times = explode(':', $tabs[1]);
        $times_up = explode(':', $tabs_up[1]);
        $this->year = (int)$dates[0];
        $this->year_up = (int)$dates_up[0];
        $this->month = (int)$dates[1];
        $this->month_up = (int)$dates_up[1];
        $this->day_up = (int)$dates_up[2];
        $this->day = (int)$dates[2];
        $this->hour = (int)$times[0];
        $this->hour_up = (int)$times_up[0];
        $this->min = (int)$times[1];
        $this->min_up = (int)$times_up[1];
        $this->sec = (int)$times[2];
        $this->sec_up = (int)$times_up[2];
        $this->dateForCreate = $dates[2] . 
                            ' ' . $this->monthsTab[(int)$dates[1] - 1] . 
                            ' ' . $dates[0] . 
                            ' à ' . $times[0] . 'H ' . $times[1] . "'";
        $this->dateForUpdate = $dates_up[2] . 
                            ' ' . $this->monthsTab[(int)$dates_up[1] - 1] . 
                            ' ' . $dates_up[0] . 
                            ' à ' . $times_up[0] . 'H ' . $times_up[1] . "'";
        return $this;
    }


    public function __getDateASHour()
    {

        $tabs_up = explode(' ', $this->updated_at);

        $dates_up = explode('-', $tabs_up[0]);
        
        $times_up = explode(':', $tabs_up[1]);

        $this->hour_up = Formattors::numberZeroFormattor((int)$times_up[0]);

        $this->min_up = Formattors::numberZeroFormattor((int)$times_up[1]);

        $this->sec_up = Formattors::numberZeroFormattor((int)$times_up[2]);

        return $this->hour_up . 'H ' . $this->min_up . "min " . $this->sec_up . "s";
    }


    public function __getDate()
    {
        $this->__setDate();

        return $this->date;
    }


    public function __setDateAgo()
    {
        $this->__setDate();

        $past = mktime($this->hour, $this->min, $this->sec, $this->month, $this->day, $this->year);

        $past_up = mktime($this->hour_up, $this->min_up, $this->sec_up, $this->month_up, $this->day_up, $this->year_up);
        
        $diff = time() - $past;

        $diff_up = time() - $past_up;

        $this->__setDateAgoToString($this->__getTheDateAsAgo($diff, $diff_up));
    }


    /**
     * Return an array
     *
     * @param [type] $timestamp
     * @return array
     */
    public function __getTheDateAsAgo($timestamp_created, $timestamp_updated)
    {
        return $this->__getDiff($timestamp_created, $timestamp_updated);
    }

    /**
     * Undocumented function
     *
     * @param array $matrice
     * @return string
     */
    public function __setDateAgoToString(array $matrice)
    {
        if(!array_key_exists('updated_at', $matrice)){

            $this->dateAgoToString = $this->__AgoToString($matrice['created_at']);
        }
        else{

            $this->dateAgoToString = ($this->__strings($matrice['created_at'], $matrice['updated_at']))['created_at'];

            $this->dateAgoToStringForUpdated = ($this->__strings($matrice['updated_at'], $matrice['updated_at']))['updated_at'];
        }
    }


    /**
     * Undocumented function
     *
     * @param int $start|$end  <timestamps>
     * @return int difference between two dates into seconds
     */
    public function __getTimestampInSecondsBetweenDates(int $start, $end = null)
    {
        if(!$end){

            $end = Carbon::now();
        }
        else{

            $end = Carbon::parse($end);
        }

        $start = Carbon::parse((int)$start);

        return $end->diffInSeconds($start);
    }


/**
     * Undocumented function
     *
     * @param int $start|$end  <timestamps>
     * @return int difference between two dates into weeks
     */
    public function __getTimestampInWeeksBetweenDates(int $start, $end = null, $full = true)
    {
        return !$full ?  
                floor($this->__getTimestampInSecondsBetweenDates($start, $end) / (3600*24*7)) : 
                $this->__getTimestampInSecondsBetweenDates($start, $end) / (3600*24*7);
    }


    public function __to($date = null, $with_hour = false, $created_at = false)
    {
        if($created_at){

            $date = $this->created_at;

        }
        else{

            $date = $this->updated_at;

        }

        $date_timestamp = Carbon::parse($date);

        $now_timestamp = Carbon::now();

        $dates = explode(' ', Carbon::parse($date)->toDateTimeString());

        $d = $dates[0];

        $t = $dates[1];

        $date_to_str = $this->__getDateAsString($date, null);

        $times = explode(':', $t);

        $h = $times[0];

        $m = $times[1];

        if($now_timestamp->diffInHours($date_timestamp) > 24){

            $to = 'Le ' . ucwords($date_to_str);

            if($with_hour){

                $to.= ' à ' . $h . 'H ' . $m . "'";

            }

            $date_to_str = $to;

        }
        else{

            $date_to_str = $this->getDateAgoFormated($created_at);

        }


        return $date_to_str;

        
    }


    public function getDateAgoFormated($created_at = false)
    {
        $this->__setDateAgo();

        if($created_at){

            return $this->dateAgoToString;
        }
        return $this->dateAgoToStringForUpdated;
    }

    
}