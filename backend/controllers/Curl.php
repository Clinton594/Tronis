<?php



class Curl
{
    // set to true if you want to return headers from Lunex 
    private static $return_headers = false;
    private static $headers = [
        "Content-Type: application/json",
        "Accept: application/json",
    ];

    public static function get(string $endpoint, array $param = [], array $http_headers = [])
    {
        // Build Param Query
        $headers = $setHeaders = [];
        $query = "";
        if (count($param)) {
            $query = self::array_serialize($param);
        }
        foreach ($http_headers as $key => $value) {
            $setHeaders[] = "{$key}: {$value}";
        }

        // Initialize CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint . $query);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge(self::$headers, $setHeaders));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if (self::$return_headers) {
            curl_setopt(
                $ch,
                CURLOPT_HEADERFUNCTION,
                function ($curl, $header) use (&$headers) {
                    $len = strlen($header);
                    $header = explode(':', $header, 2);
                    if (count($header) < 2) // ignore invalid headers
                        return $len;

                    $headers[strtolower(trim($header[0]))][] = trim($header[1]);

                    return $len;
                }
            );
        }
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return (object)["headers" => $headers, "body" => isJson($response) ?? $response, "code" => $httpCode];
    }

    public static function post(string $endpoint, array $param = [], array $http_headers = [])
    {
        // Build Param Query
        $headers = $setHeaders = [];
        $post_fields =  "";
        if (count($param)) {
            $post_fields = urldecode(json_encode($param));
        }
        foreach ($http_headers as $key => $value) {
            $setHeaders[] = "{$key}: {$value}";
        }
        // Initialize CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,  $endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge(self::$headers, $setHeaders));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);

        if (self::$return_headers) {
            curl_setopt(
                $ch,
                CURLOPT_HEADERFUNCTION,
                function ($curl, $header) use (&$headers) {
                    $len = strlen($header);
                    $header = explode(':', $header, 2);
                    if (count($header) < 2) // ignore invalid headers
                        return $len;

                    $headers[strtolower(trim($header[0]))][] = trim($header[1]);

                    return $len;
                }
            );
        }
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return (object)["headers" => $headers, "body" => isJson($response) ?? $response, "code" => $httpCode];
    }

    private static function array_serialize(array $array = array()): string
    {
        $build = [];
        if (!empty($array)) {
            foreach ($array as $key => $val) {
                $key = trim($key);
                $val = trim(urlencode($val));
                $build[] = "$key=$val";
            }
        }
        return "?" . implode("&", $build);
    }

    public static function setHeader($string)
    {
        array_push(self::$headers, $string);
    }
}
