<?php namespace App\Helpers;


class DateHelper
{
    public static function getCurrentWeek(){
        $date = new \DateTime(date('Y-m-d'));
        $current_week = $date->format("W");
        return $current_week;
    }

    public static function getWeeks(){
        $date = new \DateTime();
        $date->setISODate(date('Y'), 53);
        return  ($date->format("W") === "53" ? 53 : 52);
    }

    public static function dateSlashToDateDash($date){
        $date = \DateTime::createFromFormat('d/m/Y', $date);
        $date = $date->format("Y-m-d");
        return $date;
    }
}
