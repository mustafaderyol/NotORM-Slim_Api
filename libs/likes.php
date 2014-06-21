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

    public function getAllLikes() {
        $sql=$this->db->likes();
        $lks = array();
        foreach ($sql as $data) {
            $lks[]  = array(
                "id"          => $data["id"],
                "user_id"     => $data["user_id"],
                "message_id"  => $data["message_id"]
            );
        }
        return $lks;

    }

    public function getLikeViewWithId($id) {

        $data = $this->db->likes("id = ?",$id)->fetch();
        $fvrt = array(
                "id"          => $data["id"],
                "user_id"     => $data["user_id"],
                "message_id"  => $data["message_id"]
        );
        return $fvrt;
    }


    public function getLikeViewWithUserID($id) {

        $data = $this->db->likes("user_id = ?",$id)->fetch();
        $fvrt = array(
                "id"          => $data["id"],
                "user_id"     => $data["user_id"],
                "message_id"  => $data["message_id"]
        );
        return $fvrt;

    }


    public function getLikeViewWithMessageId($id) {

        $sql = $this->db->likes("message_id = ?",$id);
        foreach ($sql as $data) {
            $fvrts[]  = array(
                "id"          => $data["id"],
                "user_id"     => $data["user_id"],
                "message_id"  => $data["message_id"]
            );
        }
        return $fvrts;

    }

    public function deleteLikeId($id) {

        if($data = $this->db->likes("id = ?",$id)->delete()) {
            
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

        if($data = $this->db->likes()->insert($content)) {
            $fvrt = array(
                "id"          => $data["id"],
                "user_id"     => $data["user_id"],
                "message_id"  => $data["message_id"]
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
        $data = $this->db->likes('id', $content["id"])->fetch();
        if($data) 
        { 
            $fvrt = array(
                "user_id"     => $content["user_id"],
                "message_id"  => $content["message_id"]
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


