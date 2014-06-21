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

    public function getAllTokenNames() {
        $sql=$this->db->token_name();
        $lks = array();
        foreach ($sql as $data) {
            $lks[]  = array(
                "id"          => $data["id"],
                "tokenName"   => $data["tokenName"]
            );
        }
        return $lks;

    }

    public function getTokenNameViewWithId($id) {

        $data = $this->db->token_name("id = ?",$id)->fetch();
        $fvrt = array(
                "id"          => $data["id"],
                "tokenName"   => $data["tokenName"]
        );
        return $fvrt;
    }

    public function deleteTokenNameId($id) {

        if($data = $this->db->token_name("id = ?",$id)->delete()) {
            
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

        if($data = $this->db->token_name()->insert($content)) {
            $fvrt = array(
                "id"          => $data["id"],
                "tokenName"   => $data["tokenName"]
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
        $data = $this->db->token_name('id', $content["id"])->fetch();
        if($data) 
        { 
            $fvrt = array(
                "tokenName"   => $content["tokenName"]
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


