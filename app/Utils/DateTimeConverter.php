<?php

namespace App\Utils;

use Carbon\Carbon;


/**
 * Class DateTimeConverter
 * @package App\Utils
 */
class DateTimeConverter
{

    /**
     * @return false|string
     */
    public static function getDateTimeNow()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * @return false|string
     */
    public static function getDateNow()
    {
        return date('Y-m-d');
    }

    /**
     * @return false|string
     */
    public static function getTimeNow()
    {
        return date('H:i:s');
    }

    /**
     * @return string
     */
    public static function getDateTimeNowToString()
    {
        return Carbon::now()->toString();
    }

    /**
     * @param $dateTime
     * @param string $format
     * @return false|string
     */
    public static function dateTimeFormat($dateTime, string $format)
    {
        return date($format, strtotime($dateTime));
    }

    /**
     * @param $expire
     * @return false|string
     */
    public static function exipredTime($expire)
    {
        return date("Y-m-d H:i:s", strtotime("+$expire min"));
    }

    /**
     * @param $stringDateTime
     * @param string $format
     * @return false|string
     */
    public static function stringToDateTimeFormat($stringDateTime, $format = 'Y-m-d')
    {
        return date($format, strtotime($stringDateTime));
    }

    /**
     * @param $date
     * @param $second
     * @return false|string
     */
    public static function dateAddSecond($date, $second)
    {
        return date('Y-m-d H:i:s', strtotime("+$second min", strtotime($date)));
    }

    /**
     * @param string $format
     * @return false|string
     */
    public static function dateTimeFormatNow(string $format)
    {
        return date($format);
    }

    /**
     * @param $expire
     * @return false|string
     */
    public static function exipredTimeIE($expire)
    {
        return date("d/m/Y H:i:s", strtotime("+$expire min"));
    }

    /**
     * @param $date
     * @param $second
     * @return false|string
     */
    public static function dateAddSecondIE($date, $second)
    {
        return date('d/m/Y H:i:s', strtotime("+$second min", strtotime($date)));
    }

    /**
     * @param $gmt_from
     * @param $gmt_to
     * @return false|string
     */
    public static function convertGMT($gmt_from, $gmt_to)
    {
        $dateNow = DateTimeConverter::getDateTimeNow();
        if ($gmt_from === 'GMT+7' && $gmt_to === 'GMT+8') {
            return date('Y-m-d H:i:s', strtotime("+1 hour", strtotime($dateNow)));
        }

        if ($gmt_from === 'GMT+7' && $gmt_to === 'GMT+9') {
            return date('Y-m-d H:i:s', strtotime("+2 hour", strtotime($dateNow)));
        }

        if ($gmt_from === 'GMT+8' && $gmt_to === 'GMT+9') {
            return date('Y-m-d H:i:s', strtotime("+1 hour", strtotime($dateNow)));
        }

        if ($gmt_from === 'GMT+8' && $gmt_to === 'GMT+7') {
            return date('Y-m-d H:i:s', strtotime("-1 hour", strtotime($dateNow)));
        }

        if ($gmt_from === 'GMT+9' && $gmt_to === 'GMT+8') {
            return date('Y-m-d H:i:s', strtotime("-1 hour", strtotime($dateNow)));
        }

        if ($gmt_from === 'GMT+9' && $gmt_to === 'GMT+7') {
            return date('Y-m-d H:i:s', strtotime("-2 hour", strtotime($dateNow)));
        }

        return $dateNow;
    }
}

