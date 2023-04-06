<?php
class Response
{
    static $code;
    static $status;
    static $message;
    static $data;
    static $codes;

    function __construct()
    {

        self::$codes = object(["server_error" => 500, "not_found" => 404, "unauthorized" => 401, "bad_request" => 400, "redirect" => 301, "success" => 200]);
        self::$code = self::$codes->bad_request;
        self::$message = "Bad Request";
        self::$status = false;
        self::$data = new stdClass;
    }

    public static function set(array $object = [], $success = false): object
    {
        if ($success) {
            self::$status = true;
            self::$code = self::$codes->{'success'};
            self::$message = "Successful";
        }
        foreach ($object as $key => $value) {
            if (isset(self::${$key})) {
                if ($key === "code") self::$code = self::$codes->{$value};
                else self::${$key} = $value;
            }
        }

        return self::get();
    }


    public static function get()
    {
        return object(["status" => self::$status, "code" => self::$code, "message" => self::$message, "data" => self::$data]);
    }
}
