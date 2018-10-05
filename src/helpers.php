<?php
/**
 * @author James Ngugi <james@deadangroup.com>
 * @date   2017-08-01 10:38 PM
 */

use Propaganistas\LaravelPhone\PhoneNumber;

if (!function_exists('format_number')) {
#    Output easy-to-read numbers
#    by james at bandit.co.nz
    /**
     * @param $n
     *
     * @return string
     */
    function format_number($n)
    {
        // first strip any formatting;
        // $n = (0 str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) {
            // return 0;
            return $n;
        }

        // now filter it;
        if ($n > 1000000000000) {
            return round(($n / 1000000000000), 1) . 'T';
        } else {
            if ($n > 1000000000) {
                return round(($n / 1000000000), 1) . 'B';
            } else {
                if ($n > 1000000) {
                    return round(($n / 1000000), 1) . 'M';
                } else {
                    if ($n > 1000) {
                        return round(($n / 1000), 1) . 'K';
                    }
                }
            }
        }

        return number_format($n);
    }
}

if (!function_exists('get_file_size')) {
    /**
     * @param $old
     * @param $new
     *
     * @return array
     */
    function get_decorated_diff($old, $new)
    {
        $from_start = strspn($old ^ $new, "\0");
        $from_end = strspn(strrev($old) ^ strrev($new), "\0");

        $old_end = strlen($old) - $from_end;
        $new_end = strlen($new) - $from_end;

        $start = substr($new, 0, $from_start);
        $end = substr($new, $new_end);
        $new_diff = substr($new, $from_start, $new_end - $from_start);
        $old_diff = substr($old, $from_start, $old_end - $from_start);

        $new = "$start<span style='background-color:#ccffcc; text-decoration: underline'>$new_diff</span>$end";
        $old = "$start<span style='background-color:#ffcccc; text-decoration: line-through;'>$old_diff</span>$end";

        return [$old, $new];
    }
}

if (!function_exists('get_file_size')) {
    /**
     * Calculate the human-readable file size (with proper units).
     *
     * @param  int $size
     *
     * @return string
     */
    function get_file_size($size)
    {
        $units = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB'];
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . '' . $units[$i];
    }
}

if (!function_exists('is_valid_number')) {
    /**
     * @param $number
     * @param $countryCode
     *
     * @return bool
     */
    function is_valid_number($number, $countryCode)
    {
        try {
            $phoneNumber = PhoneNumber::make($number);
            return $phoneNumber->formatForCountry($countryCode);
        } catch (\Propaganistas\LaravelPhone\Exceptions\CountryCodeException $exception) {
            return false;
        }
    }
}

if (!function_exists('mask_email')) {
    /**
     * Method masks the username of an email address
     *
     * @param string $email the email address to mask
     *
     * @return string
     */
    function mask_email($email)
    {
        return app(\Deadan\Support\Str\Mask::class)->maskEmail($email);
    }
}

if (!function_exists('mask_phone')) {
    /**
     * Method masks the phonenumber
     *
     * @return string
     */
    function mask_phone($phone)
    {
        return app(\Deadan\Support\Str\Mask::class)->maskPhone($phone);
    }
}

/**
 * Format a flat JSON string to make it more human-readable
 *
 * @param string $json The original JSON string to process
 *                     When the input is not a string it is assumed the input is RAW
 *                     and should be converted to JSON first of all.
 *
 * @return string Indented version of the original JSON string
 * @throws \Throwable
 */
function json_format($json)
{
    if (!is_string($json)) {
        $json = json_encode($json);
    }

    throw_if(!phpversion() || phpversion() < 5.4, Exception::class);
    return json_encode($json, JSON_PRETTY_PRINT);
}

if (!function_exists('xml_to_json')) {
    /**
     * @param $string
     *
     * @return mixed
     */
    function xml_to_json($string)
    {
        $xml = simplexml_load_string($string);

        $json = json_encode($xml);

        return json_decode($json, true);
    }
}

if (!function_exists('is_xml')) {
    /**
     * @param $string
     *
     * @return bool
     */
    function is_xml($string)
    {
        try {
            $doc = simplexml_load_string($string);
        } catch (\Exception $exception) {
            return false;
        }

        return !empty($doc);
    }
}
if (!function_exists('route_begins')) {
    /**
     * Checks whether the current route begins with the provided string
     *
     * @param $string
     *
     * @return bool
     */
    function route_begins($string)
    {
        return starts_with(request()->route()->getName(), $string);
    }
}

if (!function_exists('route_is')) {
    /**
     * @param $string
     *
     * @return bool
     */
    function route_is($string)
    {
        if (is_null(request()->route())) {
            return false;
        }

        if (is_array($string)) {
            return in_array(request()->route()->getName(), $string);
        } else {
            return request()->route()->getName() === $string;
        }
    }
}


if (!function_exists('url_is')) {
    /**
     * @param $string
     *
     * @return bool
     */
    function url_is($string)
    {
        return str_contains(request()->fullUrl(), $string) || str_contains($string, request()->fullUrl());
    }
}


if (!function_exists('mode')) {
    /**
     * Changes to the specified mode
     *
     * @param $mode
     */
    function mode($mode)
    {
        Session::put(config('general.session.state_key'), $mode);
    }
}

if (!function_exists('has')) {
    /**
     * Checks whether user has more than one instance of the provided relationship.
     * You need to ensure the user has the defined relationship before calling this.
     *
     * @param                                 $relationship
     *
     * @param \App\User|null $user
     *
     * @return bool
     */
    function has($relationship, \App\User $user = null)
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        return $user->{$relationship}()->count() > 0;
    }
}

if (!function_exists('is_email')) {
    /**
     * @param $email
     *
     * @return bool
     */
    function is_email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
}

if (!function_exists('is_url')) {
    /**
     * @param $value
     *
     * @return bool
     */
    function is_url($value)
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }
}

//todo this??
if (!defined('CURL_SSLVERSION_TLSv1_2')) {
    define('CURL_SSLVERSION_TLSv1_2', 6);
}

if (!defined('get_private_field')) {
    /**
     * Get the value of a private field from an object
     *
     * @param $item
     * @param $field
     *
     * @return mixed
     */
    function get_private_field($item, $field)
    {
        $reflectionClass = new ReflectionObject($item);
        $args = $reflectionClass->getProperty($field);
        $args->setAccessible(true);

        return $args->getValue($item);
    }
}

if (!defined('url_add')) {
    /**
     * Append these query strings to the current url
     *
     * @param array $query
     *
     * @return mixed
     */
    function url_add(array $query)
    {
        $url = request()->url();
        $params = http_build_query($query);

        if ($params != '') {
            $url .= '?' . $params;
        }
        return $url;
    }
}

if (!defined('url_with')) {
    /**
     * Get the current url with only these query strings
     *
     * @param array $query
     *
     * @return mixed
     */
    function url_with(array $query)
    {
        $url = request()->url();
        $params = http_build_query(request()->only(array_values($query)));

        if ($params != '') {
            $url .= '?' . $params;
        }
        return $url;
    }
}

if (!defined('is_search')) {
    /**
     * checks whether we are in search mode
     *
     * @return boolean
     */
    function is_search()
    {
        $searchKeys = config('general.search_query');

        //we use keys to because we want to know even when the search params don't have a value
        $keys = request()->keys();
        return count(array_intersect($keys, $searchKeys)) > 0;
    }
}

if (!defined('shorten')) {
    /**
     * Shortens a url
     *
     * @param      $url
     * @param bool $failSafe
     *
     * @return mixed
     * @throws \Exception
     */
    function shorten($url, $failSafe = false)
    {
        $result = \Bitly::shorten($url);
        if (object_get($result, 'status_code') == 200) {
            return object_get($result, 'data.url');
        } elseif ($failSafe) {
            //if it failed, just return the long url
            return $url;
        } else {
            throw new Exception("Bitly threw an error :" . object_get($result, 'status_text'));
        }
    }
}

if (!defined('force_s3_download')) {
    /**
     *
     * Forces the browser to download a file from a private s3 bucket
     *
     * @see https://laracasts.com/discuss/channels/laravel/file-response-from-s3
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    function force_s3_download($storedName, $displayedName)
    {
        $disk = Storage::disk('s3');

        $displayedName = iconv('UTF-8', 'ASCII//TRANSLIT', $displayedName);

        $command = $disk->getDriver()->getAdapter()->getClient()->getCommand('GetObject', [
            'Bucket'                     => config('filesystems.disks.s3.bucket'),
            'Key'                        => $storedName,
            'ResponseContentDisposition' => 'inline; filename="' . $displayedName . '"',
        ]);
        $request = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+5 minutes');
        $url = (string) $request->getUri();

        return response()->redirectTo($url);
    }
}

if (!defined('ascii_art')) {
    /**
     * @see https://donatstudios.com/Damn-Simple-PHP-ASCII-Art-Generator
     *
     * @param $file
     *
     * @return string
     */
    function ascii_art($file)
    {
        $out = "";
        $img = imagecreatefromstring(file_get_contents($file));
        list($width, $height) = getimagesize($file);
        $scale = 10;
        $chars = [
            ' ',
            '\'',
            '.',
            ':',
            '|',
            'T',
            'X',
            '0',
            '#',
        ];
        $chars = array_reverse($chars);
        $c_count = count($chars);
        for ($y = 0; $y <= $height - $scale - 1; $y += $scale) {
            for ($x = 0; $x <= $width - ($scale / 2) - 1; $x += ($scale / 2)) {
                $rgb = imagecolorat($img, $x, $y);
                $r = (($rgb >> 16) & 0xFF);
                $g = (($rgb >> 8) & 0xFF);
                $b = ($rgb & 0xFF);
                $sat = ($r + $g + $b) / (255 * 3);
                $out .= $chars[(int) ($sat * ($c_count - 1))];
            }
            $out .= PHP_EOL;
        }
        return $out;
    }
}

if (!defined('_copy')) {
    /**
     * Copies from one flysystem driver to the other and returns the full url
     *
     * @param $fromDriver
     * @param $toDriver
     * @param $filePath
     *
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    function _copy($fromDriver, $toDriver, $filePath)
    {
        Storage::disk($toDriver)->put($filePath,
            Storage::disk($fromDriver)->get($filePath));

        return Storage::disk($toDriver)->url($filePath);
    }
}