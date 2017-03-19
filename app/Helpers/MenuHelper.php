<?php namespace App\Helpers;


class MenuHelper
{
    public static $submenu = array(
        array(
            'caption' => 'Dashboard',
            'tree' => array(
                array(
                    'caption' => 'Check In/Out',
                    'url' => 'dashboard/inout'
                )
            )
        ),

    );

}
