<?php
/**
 * PATIENT MODEL
 * -------------
 * Handles only database operations
 */

class Patient {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // Get all patients
    public function getAllPatients(){
        return $this->conn->query(
            "SELECT * FROM patients ORDER BY id DESC"
        );
    }

    // Get patient by ID
    public function getPatientById($id){

        $stmt = $this->conn->prepare(
            "SELECT * FROM patients WHERE id=?"
        );
        $stmt->bind_param("i",$id);
        $stmt->execute();

        return $stmt->get_result();
    }

    // Create patient
    public function createPatient($data){

        try{

            $stmt = $this->conn->prepare(
                "INSERT INTO patients(name,age,gender,phone)
                 VALUES (?,?,?,?)"
            );

            $stmt->bind_param(
                "siss",
                $data['name'],
                $data['age'],
                $data['gender'],
                $data['phone']
            );

            if(!$stmt->execute()){
                throw new Exception("Insert failed");
            }

            return $stmt->insert_id;

        }catch(Exception $e){
            throw $e;
        }
    }

    // Update patient
    public function updatePatient($id,$data){

        $stmt = $this->conn->prepare(
            "UPDATE patients
             SET name=?,age=?,gender=?,phone=?
             WHERE id=?"
        );

        $stmt->bind_param(
            "sissi",
            $data['name'],
            $data['age'],
            $data['gender'],
            $data['phone'],
            $id
        );

        return $stmt->execute();
    }

    // Delete patient
    public function deletePatient($id){

        $stmt = $this->conn->prepare(
            "DELETE FROM patients WHERE id=?"
        );
        $stmt->bind_param("i",$id);

        return $stmt->execute();
    }
}
