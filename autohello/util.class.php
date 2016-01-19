<?php

/**
 * 工具方法
 *
 */
class AutohelloUtils
{

    static public function http_init($use_cache=true)
    {
        static $ch = null;
        if (!$ch) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_ENCODING, 'deflate, gzip');
            curl_setopt($curl, CURLOPT_USERAGENT, 'Autohello API/SDK ' . CHEMI_API_SDK_VERSION);

            if ($use_cache) {
                $ch = $curl;
            } else {
                return $curl;
            }
        }

        return $ch;
    }

    static public function http_get($url, $ch = null)
    {
        if (!$ch) {
            $ch = self::http_init();
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_POST, 0);

        return curl_exec($ch);
    }

    static public function http_code($ch = null)
    {
        if (!$ch) {
            $ch = self::http_init();
        }
        return curl_getinfo($ch,CURLINFO_HTTP_CODE);
    }


    static public function http_post($url, $data, $ch = null)
    {
        if (!$ch) {
            $ch = self::http_init();
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPGET, 0);

        return curl_exec($ch);
    }

    static public function api_get($url)
    {
        $result = self::http_get($url);
        return self::api_process_result($result);
    }

    static public function api_post($url, $data)
    {
        $result = self::http_post($url, $data);
        return self::api_process_result($result);
    }

    static public function api_process_result($result_in)
    {
        $result = json_decode($result_in, true);
        if (!$result) {
            throw new AutohelloException('JSON解析错误', 9901);
        }

        if ($result['error']['code']) {
            throw new AutohelloException($result['error']['msg'], $result['error']['code']);
        }

        return $result['data'];
    }

}

# EOF