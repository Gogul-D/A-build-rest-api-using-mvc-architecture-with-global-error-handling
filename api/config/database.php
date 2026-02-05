<?php
/**
 * DATABASE CONNECTION FILE
 * ------------------------
 * Creates MySQL connection
 * Used by all models
 */

$host = "localhost";
$user = "root";
$pass = "";
$db   = "hospital_db";

// Create connection
$conn = new mysqli($host,$user,$pass,$db);

// Check connection
if($conn->connect_error){
    echo json_encode([
        "status"=>false,
        "message"=>"Database connection failed",
        "error"=>$conn->connect_error
    ]);
    exit;
}
