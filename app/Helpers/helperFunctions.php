<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use App\Classes\Slugs;
use Illuminate\Http\Request;
use App\Classes\Settings;

class helperFunctions extends Model {

    public $stores = array(
        'US' => 'com',
        'GB' => 'co.uk',
        'CA' => 'ca'
    );

    function insertIfNotExsit($object, $recordID, $input, $slug = null) {

        if (isset($input['_token'])) {
            unset($input['_token']);
        }

        if (isset($input['menuID'])) {
            unset($input['menuID']);
        }

        $record = $object->find($recordID);

        if ($slug != null) {

            $slug = new Slugs();

            $slug_object = $slug->where('slug', $record->slug)->first();
            $slug_object->slug = $input['slug'];
            $slug_object->save();
        }

        if ($record) {

            foreach ($input as $key => $value) {
                $record->$key = $value;
            }
            $record->save();
        } else {

            $record = $object;
            foreach ($input as $key => $value) {
                $record->$key = $value;
            }
            $record->save();
        }
    }

    function in_object($needle, $haystack) {
        return in_array($needle, get_object_vars($haystack));
    }

    function multi_in_array($value, $array) {
        foreach ($array AS $item) {
            if (!is_array($item)) {
                if ($item == $value) {
                    return true;
                }
                continue;
            }

            if (in_array($value, $item)) {
                return true;
            } else if (multi_in_array($value, $item)) {
                return true;
            }
        }
        return false;
    }

    function containsWord($str, $word) {
        return !!preg_match('#\\b' . preg_quote($word, '#') . '\\b#i', $str);
    }

    function searchJson($obj, $field, $value) {
        foreach ($obj as $item) {
            foreach ($item as $child) {
                if (isset($child->$field) && $child->$field == $value) {
                    return $child;
                }
            }
        }
        return null;
    }

    function file_ext($filename) {
        if (!preg_match('/./', $filename))
            return '';
        return preg_replace('/^.*./', '', $filename);
    }

// Returns the file name, less the extension.
    function file_ext_strip($filename) {
        return preg_replace('/.[^.]*$/', '', $filename);
    }

    function gen_uuid($len = 3) {

        $hex = md5("yourSaltHere" . uniqid("", true));

        $pack = pack('H*', $hex);
        $tmp = base64_encode($pack);

        $uid = preg_replace("#(*UTF8)[^A-Za-z0-9]#", "", $tmp);

        $len = max(4, min(128, $len));

        while (strlen($uid) < $len)
            $uid .= gen_uuid(22);

        return substr($uid, 0, $len);
    }

    function getAmazonStore($object) {

        $settings = new Settings();
        $get_settings = $settings->first();

        $request = "79.66.228.117";
        //$request = new Request();
        //$request->getClientIp(true);

        $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip={$request}");
        $cc = $xml->geoplugin_countryCode;

        $countryCode = strip_tags($cc->asXML());

        $countryCode = 'GB';

        $get_the_tag = json_decode($object->location_ids);
        $store_local = $get_settings->amazonLocale;

        $extension = '';
        $amazon_stores = $this->stores;
        $link = array();


        if (array_key_exists($countryCode, $amazon_stores)) {
            $extension = $amazon_stores[$countryCode];
        } else {
            $extension = $amazon_stores[$store_local];
        }

        if (property_exists($get_the_tag, $countryCode)) {

            if ($get_the_tag->$countryCode == null) {

                $extension = $amazon_stores[$store_local];

                $link['link'] = "http://www.amazon.{$extension}/dp/";
                $link['tag'] = $get_the_tag->$store_local;
                $link['local'] = true;
                $link['button'] = "images/amazon_buttons/{$countryCode}.gif";
                
            } else {
                

                if ($store_local == $countryCode) {
                    
                    

                    $link['link'] = "http://www.amazon.{$extension}/dp/";
                    $link['tag'] = $get_the_tag->$countryCode;
                    $link['local'] = true;
                    $link['button'] = "images/amazon_buttons/{$countryCode}.gif";
                    
                } else {

                    $link['link'] = "http://www.amazon.{$extension}/gp/search?ie=UTF8&keywords=";
                    $link['tag'] = $get_the_tag->$countryCode;
                    $link['local'] = false;
                    $link['button'] = "images/amazon_buttons/{$countryCode}.gif";
                }
            }
        } else {
            

            $link['link'] = "http://www.amazon.{$extension}/dp/";
            $link['tag'] = $get_the_tag->$store_local;
            $link['local'] = true;
            $link['button'] = "images/amazon_buttons/{$countryCode}.gif";
        }

        return $link;
    }

    function getAmazonApiLocale($settings) {

        $get_locations = json_decode($settings->location_ids);
        $local = $settings->amazonLocale;
        $get_country = $get_locations->$local;

        switch ($local) {
            case 'US':
                $to_array = explode(",", $get_country);
                $store['local'] = 'com';
                $store['tag'] = $to_array[0];
                break;
            case 'CA':
                $to_array = explode(",", $get_country);
                $store['local'] = 'ca';
                $store['tag'] = $to_array[0];
                break;
            case 'GB':
                $to_array = explode(",", $get_country);
                $store['local'] = 'co.uk';
                $store['tag'] = $to_array[0];
                break;
        }

        return $store;
    }

}
