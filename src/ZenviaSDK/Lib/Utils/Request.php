<?php

namespace ZenviaSDK\Lib\Utils;

class Request
{
    const URL_API = 'https://api.zenvia.com';

    public static function post($token, $path, $body)
    {
        return self::request($token, 'post', $path, $body);
    }

    private static function request($token, $method, $path, $body)
    {
        $uri = self::URL_API . $path;
        $data = json_encode($body);
        $curl = curl_init();
        switch ($method) {
            case "post":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "post":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($body)
                    $path = sprintf("%s?%s", $path, http_build_query($body));
        }
        echo $data;
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $uri);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'X-API-TOKEN: ' . $token,
            'Content-Type: application/json',
        ));
        //curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        if (!$result = curl_exec($curl)) {
            trigger_error(curl_error($curl));
        }
        curl_close($curl);
        return $result;
    }
}
