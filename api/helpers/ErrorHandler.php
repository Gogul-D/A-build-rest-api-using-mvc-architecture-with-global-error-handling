<?php
/**
 * GLOBAL ERROR HANDLER
 * -------------------
 * Converts PHP exceptions into JSON responses
 */

class ErrorHandler {

    public static function handleException($e){

        http_response_code(500);

        echo json_encode([
            "status"=>false,
            "message"=>"Internal Server Error",
            "error"=>$e->getMessage()
        ]);

        exit;
    }
}
