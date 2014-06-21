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

    public function getAllTokens() {
        $sql=$this->db->tokens();
        $lks = array();
        foreach ($sql as $data) {
            $lks[]  = array(
                "id"            => $data["id"],
                "user_id"       => $data["user_id"],
                "tokenName_id"  => $data["tokenName_id"]
            );
        }
        return $lks;

    }

    public function getTokenViewWithId($id) {

        $data = $this->db->tokens("id = ?",$id)->fetch();
        $fvrt = array(
                "id"            => $data["id"],
                "user_id"       => $data["user_id"],
                "tokenName_id"  => $data["tokenName_id"]
        );
        return $fvrt;
    }

    public function getTokenViewWithUserId($id) {

        $data = $this->db->tokens("user_id = ?",$id)->fetch();
        $fvrt = array(
                "id"            => $data["id"],
                "user_id"       => $data["user_id"],
                "tokenName_id"  => $data["tokenName_id"]
        );
        return $fvrt;
    }

    public function deleteTokenId($id) {

        if($data = $this->db->tokens("id = ?",$id)->delete()) {
            
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

        if($data = $this->db->tokens()->insert($content)) {
            $fvrt = array(
                "id"            => $data["id"],
                "user_id"       => $data["user_id"],
                "tokenName_id"  => $data["tokenName_id"]
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
        $data = $this->db->tokens('user_id', $content["user_id"])->fetch();
        if($data) 
        { 
            $fvrt = array(
                "tokenName_id"  => $content["tokenName_id"]
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


