<?php
/**
 * JSON MIDDLEWARE
 * ---------------
 * Forces all responses to be JSON
 * Enables CORS for APIs
 */

class JsonMiddleware {

    public static function handle(){

        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
    }
}
