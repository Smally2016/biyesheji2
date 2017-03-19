<?php namespace App\Helpers;


class AttendanceHelper
{

    public static $attendances = array(
        0 => 'Deleted',
        1 => 'Normal',
        2 => 'Inserted',
        3 => 'Edited',
    );

    const F1 = 1;
    const F2 = 2;
    const NO_BUTTON = 3;
    const ACCESS = 3;
    const F3 = 4;
    const F4 = 5;

    public static $modes = array(
        AttendanceHelper::F1 => 'In',
        AttendanceHelper::F2 => 'Out',
        AttendanceHelper::NO_BUTTON => 'Access',
        AttendanceHelper::F3 => 'F3',
        AttendanceHelper::F4 => 'F4'
    );
}
