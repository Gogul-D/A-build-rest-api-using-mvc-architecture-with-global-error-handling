<?php

class PatientController {

    private $patient;

    public function __construct($patient){
        $this->patient = $patient;
    }

    // GET ALL PATIENTS
    public function index(){

        $result = $this->patient->getAllPatients();
        $data = [];

        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }

        Response::success("Patients fetched successfully",$data);
    }

    // GET PATIENT BY ID
    public function show($id){
        
        if(!is_numeric($id)){
            Response::error("Invalid patient ID",400);
        }

        $result = $this->patient->getPatientById($id);
        $data = $result->fetch_assoc();

        if(!$data){
            Response::error("Patient not found",404);
        }

        Response::success("Patient fetched successfully",$data);
    }

    // CREATE PATIENT
    public function store(){

        $data = json_decode(file_get_contents("php://input"), true);

        if(
            empty($data['name']) ||
            empty($data['age']) ||
            empty($data['gender']) ||
            empty($data['phone'])
        ){
            Response::error("All fields are required",400);
        }

        if(!is_numeric($data['age'])){
            Response::error("Age must be numeric",400);
        }

        $id = $this->patient->createPatient($data);

        if(!$id){
            Response::error("Failed to create patient",500);
        }

        Response::success("Patient created successfully",["id"=>$id],201);
    }

    // UPDATE PATIENT
    public function update($id){
        
    //prevents invalid ids and request before touching the db  
    if(!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0){
        Response::error("Invalid patient ID",400);
        }


        $data = json_decode(file_get_contents("php://input"), true);

        if(!$this->patient->updatePatient($id,$data)){
            Response::error("Failed to update patient",500);
        }

        Response::success("Patient updated successfully");
    }

 // PATCH
    public function patch($id){
        $data=json_decode(file_get_contents("php://input"),true);

        if(!$this->patient->patchPatient($id,$data)){
            Response::error("Patch failed",500);
        }

        Response::success("Patient partially updated");
    }

    public function destroy($id){
        if(!$this->patient->deletePatient($id)){
            Response::error("Delete failed",500);
        }

        Response::success("Patient deleted");
    }


    // DELETE PATIENT
    public function destroy($id){

        
        if(!is_numeric($id)){
            Response::error("Invalid patient ID",400);
        }

        if(!$this->patient->deletePatient($id)){
            Response::error("Failed to delete patient",500);
        }

        Response::success("Patient deleted successfully");
    }
}
