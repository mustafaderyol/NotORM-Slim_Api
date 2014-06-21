<?php

require_once dirname(__FILE__) . '/../third-party/NotORM.php';
require_once dirname(__FILE__) . '/../configs/db.php';

class uup {

    private $pdo;
    private $db;

    public function __construct() {
    
        $this->pdo = new PDO('mysql:dbname='.DB_NAME.';host='.DB_HOST,DB_USER,DB_PASS);
        $this->db = new NotORM($this->pdo);


    }

    public function getAllReasons() {
        $sql=$this->db->reason();
        $lks = array();
        foreach ($sql as $data) {
            $lks[]  = array(
                "id"          => $data["id"],
                "reason"      => $data["reason"]
            );
        }
        return $lks;

    }

    public function getReasonViewWithId($id) {

        $data = $this->db->reason("id = ?",$id)->fetch();
        $fvrt = array(
                "id"          => $data["id"],
                "reason"   => $data["reason"]
        );
        return $fvrt;
    }

    public function deleteReasonId($id) {

        if($data = $this->db->reason("id = ?",$id)->delete()) {
            
            $success = array(
                "success"     => "success"
            );
            return $success;
        } else {
            $error = array(
                "error"     => "DELETE_ERROR"
            );
            return $error;
        }

    }

    public function saveContent($content) {

        if($data = $this->db->reason()->insert($content)) {
            $fvrt = array(
                "id"          => $data["id"],
                "reason"      => $data["reason"]
            );
            return $fvrt;
        } else {
            $error = array(
                "error"     => "SAVE_ERROR"
            );
            return $error;
        }

    }


    public function updateContent($content) {
        $data = $this->db->reason('id', $content["id"])->fetch();
        if($data) 
        { 
            $fvrt = array(
                "reason"   => $content["reason"]
            );
            if($data->update($fvrt)) 
            { 
                return $fvrt;
            } 
            else 
            { 
                $error = array(
                    "error"     => "UPDATE_ERROR"
                );
                return $error; 
            }

        }
    }


    public function errorNotFound() {
        $error = array(
            "error"     => "NOT_FOUND"
        );
        return $error;
    }
}


