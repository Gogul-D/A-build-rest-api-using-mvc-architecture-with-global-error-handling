<?php
/**
 * API ROUTER
 * ----------
 * Receives all requests
 * Routes to correct controller
 */

require_once "middlewares/JsonMiddleware.php";
JsonMiddleware::handle();

require_once "helpers/ErrorHandler.php";
set_exception_handler(['ErrorHandler','handleException']);

require_once "config/database.php";
require_once "models/Patient.php";
require_once "controllers/PatientController.php";
require_once "helpers/Response.php";


$patientModel = new Patient($conn);
$controller   = new PatientController($patientModel);

// Extract URL
$request = isset($_GET['request'])
          ? explode("/",$_GET['request'])
          : [];

$resource = $request[0] ?? null;
$id       = $request[1] ?? null;

$method = $_SERVER['REQUEST_METHOD'];

if($resource === "patients"){

    if($method === "GET" && !$id){
        $controller->index();
    }
    elseif($method === "GET" && $id){
        $controller->show($id);
    }
    elseif($method === "POST"){
        $controller->store();
    }
    elseif($method === "PUT" && $id){
        $controller->update($id);
    }
    elseif($method === "DELETE" && $id){
        $controller->destroy($id);
    }
    else{
        http_response_code(400);
        echo json_encode([
            "status"=>false,
            "message"=>"Bad Request"
        ]);
    }

}else{

    http_response_code(404);
    echo json_encode([
        "status"=>false,
        "message"=>"Endpoint Not Found"
    ]);
}
