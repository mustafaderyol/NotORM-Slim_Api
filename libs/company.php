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

    public function getAllCompany() {
        $sql=$this->db->company();
        $cmpny = array();
        foreach ($sql as $data) {
            $cmpny[]  = array(
                "id"            => $data["id"],
                "name"          => $data["name"],
                "address"       => $data["address"],
                "tel"           => $data["tel"],
                "email"         => $data["email"]
            );
        }
        return $cmpny;
    }

    public function getCompanyViewWithId($id) {

        $data = $this->db->company("id = ?",$id)->fetch();
        $cmpny = array(
                "id"            => $data["id"],
                "name"          => $data["name"],
                "address"       => $data["address"],
                "tel"           => $data["tel"],
                "email"         => $data["email"]
        );
        return $cmpny;
    }

    public function deleteCompanyId($id) {

        if($data = $this->db->company("id = ?",$id)->delete()) {
            
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

        if($data = $this->db->company()->insert($content)) {
            $usrs = array(
                "id"            => $data["id"],
                "name"          => $data["name"],
                "address"       => $data["address"],
                "tel"           => $data["tel"],
                "email"         => $data["email"]
            );
            return $usrs;
        } else {
            $error = array(
                "error"     => "SAVE_ERROR"
            );
            return $error;
        }

    }


    public function updateContent($content) {
        $data = $this->db->company('id', $content["id"])->fetch();
        if($data) 
        { 
            $usr = array(
                "name"          => $content["name"],
                "address"       => $content["address"],
                "tel"           => $content["tel"],
                "email"         => $content["email"]
            );
            if($data->update($usr)) 
            { 
                return $usr;
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


