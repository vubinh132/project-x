<?php

namespace App\Services;

use App;
use App\Models\Note;
use Illuminate\Support\Str;
use Log;
use App\Models\SettingKey;

class CommonService
{
    public static function formatFullDate($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('Y-m-d', strtotime($date));
    }

    public static function formatShortDate($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('Y-m-d', strtotime($date));
    }

    public static function formatLongDate($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public static function formatFlightTime($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('H:i Y-m-d', strtotime($date));
    }

    public static function formatShortFlightTime($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('H:i', strtotime($date));
    }

    public static function formatSmsTime($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('d-m-Y/H:i', strtotime($date));
    }

    public static function formatEmailTime($date)
    {
        if (empty($date)) {
            return '';
        }
        return date('H:i d-m-Y', strtotime($date));
    }

    public static function formatDuration($minutes)
    {
        $hours = (int)($minutes / 60);
        $minutes = $minutes % 60;
        return $hours . 'h' . $minutes . "'";
    }

    public static function formatPrice($price)
    {
        return number_format($price, 0, '.', ',');
    }

    public static function formatPriceVND($price)
    {
        return number_format($price, 0, ',', '.') . " VND";
    }

    public static function formatInteger($number)
    {
        return number_format($number, 0, ',', '.');
    }

    public static function correctSearchKeyword($keyword)
    {
        $keyword = str_replace(' ', '%', $keyword);
        return "%$keyword%";
    }


    public static function queryStringUrl($path = null, $qs = array(), $secure = null)
    {
        $url = app('url')->to($path, $secure);
        if (count($qs)) {

            foreach ($qs as $key => $value) {
                $qs[$key] = sprintf('%s=%s', $key, urlencode($value));
            }
            $url = sprintf('%s?%s', $url, implode('&', $qs));
        }
        return $url;
    }

    public static function asciiText($text)
    {
        if (empty($text)) {
            return $text;
        }
        return Str::ascii($text);
    }

//    public static function generateOrderCode()
//    {
//        $codes = strtoupper(str_random(7));
//        $count = Order::where('code', $codes)->count();
//        while ($count > 0) {
//            $codes = strtoupper(random_str(7));
//            $count = Order::where('code', $codes)->count();
//        }
//        return $codes;
//    }

    public static function mapStatus($statusArray, $statusTextArray, $chosenValues = [])
    {
        $result = [];

        foreach ($statusArray as $key => $value) {
            if ($chosenValues && !in_array($value, $chosenValues)) {
                continue;
            }
            $code = $value;
            $text = $statusTextArray[$key];
            $result[$code] = $text;
        }

        return $result;
    }

//    call setting value methods

    public static function getSettingValues($keyName)
    {
        return SettingKey::where('key', $keyName)->first()->values()->get();
    }

    public static function getSettingChosenValue($keyName)
    {
        return SettingKey::where('key', $keyName)->first()->chosenValue()->first()['value'];
    }

    public static function updateSettingValue($keyName, $value, $isSelectionValue = false)
    {
        if (!$isSelectionValue) {
            $chosenValue = SettingKey::where('key', $keyName)->first()->chosenValue()->first();
            $chosenValue->update(['value' => $value]);
        } else {
            // update selection value
        }
    }

    public static function updateVersion()
    {
        $versionNotes = Note::where('name', 'Version Notes')->firstOrFail()->content;
        Log::info($versionNotes);
        $versions = explode('/^<p>=====Version [0-9]+=====</p>$/', $versionNotes);
        Log::info($versions);
        return 'ahihi';
    }
}