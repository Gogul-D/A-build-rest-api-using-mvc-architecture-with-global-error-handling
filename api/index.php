<?php

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
          ? explode("/", trim($_GET['request'],"/"))
          : [];

$resource = $request[0] ?? null;
$id       = $request[1] ?? null;

$method = strtoupper($_SERVER['REQUEST_METHOD']);

// ID validation
if($id !== null && !filter_var($id, FILTER_VALIDATE_INT)){
    Response::error("Invalid ID",400);
}

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
        Response::error("Bad Request",400);
    }

}else{
    Response::error("Endpoint Not Found",404);
}
