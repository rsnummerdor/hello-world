<?php

/*
 * This file is part of the FollowTheMoney package created by the
 * National Institute on Money in State Politics.
 *
 *  (c) National Institute for Money in State Politics <is@followthemoney.org>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

spl_autoload_register(
        function($class) {
            static $classes = null;
    if ($classes === null) {
        $classes = array(
            'nimsp\\FollowTheMoney\\FilerSchedule' => '/Core/FilerSchedule.php',
            'nimsp\\FollowTheMoney\\FilerScheduleLog' => '/Core/FilerScheduleLog.php',
            'nimsp\\FollowTheMoney\\FilerScheduleInterface' => '/DataInterface/FilerScheduleInterface.php',
            'nimsp\\FollowTheMoney\\FilerScheduleLogInterface' => '/DataInterface/FilerScheduleLogInterface.php'
        );
    }
    $cn = strtolower($class);
    if (isset($classes[$cn])) {
        require __DIR__ . $classes[$cn];
        echo "Class require " . __DIR__ . ' ' . $classes[$cn] . "<br>";
    }
}, true, false
);
