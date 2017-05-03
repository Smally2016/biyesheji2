<?php namespace App\Helpers;


class AttendanceHelper
{

    public static $attendances = array(
        0 => '已删除',
        1 => '正常',
        2 => '补卡',
        3 => '更改过',
    );

    const F1 = 1;
    const F2 = 2;
    const NO_BUTTON = 3;
    const ACCESS = 3;
    const F3 = 4;
    const F4 = 5;

    public static $modes = array(
        AttendanceHelper::F1 => '上班',
        AttendanceHelper::F2 => '下班',
        AttendanceHelper::NO_BUTTON => '普通打卡',
        AttendanceHelper::F3 => 'F3',
        AttendanceHelper::F4 => 'F4'
    );
}
