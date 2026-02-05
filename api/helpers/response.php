<?php
/**
 * RESPONSE HELPER
 * Centralized JSON response handler
 */

class Response {

    // Success Response
    public static function success($message="", $data=null, $code=200){

        http_response_code($code);

        echo json_encode([
            "status" => true,
            "message" => $message,
            "data" => $data
        ]);

        exit;
    }

    // Error Response
    public static function error($message="", $code=400){

        http_response_code($code);

        echo json_encode([
            "status" => false,
            "message" => $message
        ]);

        exit;
    }
}
