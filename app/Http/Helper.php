<?php
/**
 * Created by PhpStorm.
 * User: КажиевС
 * Date: 28.04.2016
 * Time: 19:58
 */

namespace App\Http;


use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Helper
{
    public static function select($options = [], $selected = 1, $first_option = '', $attrs = [])
    {
        return view('helpers.select')
            ->with('options', $options)
            ->with('selected', $selected)
            ->with('first_option',$first_option)
            ->with('attrs', $attrs);
    }
    
    public static function getCalendarDays() {
        $days = [];
        for ($i = 0; $i < 42; $i++) {
            $day = strtotime('last Monday +'.$i.' days', mktime(0, 0, 0, date('n'), 1));
            $days[$i][] = getdate($day)['mday'];
            $days[$i][] = $day;
        }
        return $days;
    }

    public static function getThisWeekDays() {
        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $day = strtotime('last Monday +'.$i.' days', mktime(0, 0, 0, date('n'), 1));
            $days[$i][] = $day;
        }
        return $days;
    }

    public static function getMonth() {
        $month = strtotime('now');
        return getdate($month)['month'];
    }

    public static function getTasksCountByDay($day) {
        $tasks = Task::getTasksByUserId(Auth::user()->id);
        $returnValue = [];
        for ($i = 0; $i < count($tasks); $i++) {
            $_day = strtotime(date('Y-m-d', strtotime($tasks[$i]['time'])));
            if ($day == $_day) {
                $returnValue[] = $tasks[$i];
            }
        }
        return count($returnValue);
    }

    public static function getMonday() {
        return strtotime("last Monday");
    }

    public static function getTuesday() {
        return strtotime("last Monday +1 day");
    }

    public static function getWednesday() {
        return strtotime("last Monday +2 day");
    }

    public static function getThirsday() {
        return strtotime("last Monday +3 day");
    }

    public static function getFriday() {
        return strtotime("last Monday +4 day");
    }

    public static function getSaturday() {
        return strtotime("last Monday +5 day");
    }

    public static function getSunday() {
        return strtotime("last Monday +6 day");
    }
}