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

    public function getAllFavourites() {
        $sql=$this->db->favourite();
        $fvrts = array();
        foreach ($sql as $data) {
            $fvrts[]  = array(
                "id"          => $data["id"],
                "user_id"     => $data["user_id"],
                "comment"     => $data["comment"]
            );
        }
        return $fvrts;

    }

    public function getFavouriteViewWithId($id) {

        $data = $this->db->favourite("id = ?",$id)->fetch();
        $fvrt = array(
                "id"          => $data["id"],
                "user_id"     => $data["user_id"],
                "comment"     => $data["comment"]
        );
        return $fvrt;
    }


    public function getFavouriteViewWithUserID($id) {

        $data = $this->db->favourite("user_id = ?",$id)->fetch();
        $fvrt = array(
                "id"          => $data["id"],
                "user_id"     => $data["user_id"],
                "comment"     => $data["comment"]
        );
        return $fvrt;

    }


    public function getFavouriteViewWithCommentId($id) {

        $sql = $this->db->favourite("comment = ?",$id);
        foreach ($sql as $data) {
            $fvrts[]  = array(
                "id"          => $data["id"],
                "user_id"     => $data["user_id"],
                "comment"     => $data["comment"]
            );
        }
        return $fvrts;

    }

    public function deleteFavouriteId($id) {

        if($data = $this->db->favourite("id = ?",$id)->delete()) {
            
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

        if($data = $this->db->favourite()->insert($content)) {
            $fvrt = array(
                "id"          => $data["id"],
                "user_id"     => $data["user_id"],
                "comment"     => $data["comment"]
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
        $data = $this->db->favourite('id', $content["id"])->fetch();
        if($data) 
        { 
            $fvrt = array(
                "user_id"     => $content["user_id"],
                "comment"     => $content["comment"]
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


