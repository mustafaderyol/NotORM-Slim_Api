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

    public function getAllUsers() {
        $sql=$this->db->users();
        $usrs = array();
        foreach ($sql as $data) {
            $usrs[]  = array(
                "id"            => $data["id"],
                "user_nick"     => $data["user_nick"],
                "user_mail"     => $data["user_mail"],
                "user_password" => $data["user_password"],
                "user_photo"    => $data["user_photo"],
                "user_gender"   => $data["user_gender"],
                "university_id" => $data["university_id"]
            );
        }
        return $usrs;

    }

    public function getUserViewWithId($id) {

        $data = $this->db->users("id = ?",$id)->fetch();
        $usr = array(
            "id"            => $data["id"],
            "user_nick"     => $data["user_nick"],
            "user_mail"     => $data["user_mail"],
            "user_password" => $data["user_password"],
            "user_photo"    => $data["user_photo"],
            "user_gender"   => $data["user_gender"],
            "university_id" => $data["university_id"]
        );
        return $usr;
    }

    public function getMaxViewedUser() {

        $view = $this->db->users()->max("id");
        $data = $this->db->users("id = ?",$view)->fetch();
        $usr = array(
            "id"            => $data["id"],
            "user_nick"     => $data["user_nick"],
            "user_mail"     => $data["user_mail"],
            "user_password" => $data["user_password"],
            "user_photo"    => $data["user_photo"],
            "user_gender"   => $data["user_gender"],
            "university_id" => $data["university_id"]
        );
        return $usr;

    }


    public function getUserViewWithNick($nick) {

        $data = $this->db->users("user_nick = ?",$nick)->fetch();
        $usr = array(
            "id"            => $data["id"],
            "user_nick"     => $data["user_nick"],
            "user_mail"     => $data["user_mail"],
            "user_password" => $data["user_password"],
            "user_photo"    => $data["user_photo"],
            "user_gender"   => $data["user_gender"],
            "university_id" => $data["university_id"]
        );
        return $usr;

    }


    public function getUserViewWithUniversity($id) {

        $sql = $this->db->users("university_id = ?",$id);
        foreach ($sql as $data) {
            $usrs[]  = array(
                "id"            => $data["id"],
                "user_nick"     => $data["user_nick"],
                "user_mail"     => $data["user_mail"],
                "user_password" => $data["user_password"],
                "user_photo"    => $data["user_photo"],
                "user_gender"   => $data["user_gender"],
                "university_id" => $data["university_id"]
            );
        }
        return $usrs;

    }

    public function deleteUserId($id) {

        if($data = $this->db->users("id = ?",$id)->delete()) {
            
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

    public function deleteUserNick($nick) {

        if($data = $this->db->users("user_nick = ?",$nick)->delete()) {
            
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

        if($data = $this->db->users()->insert($content)) {
            $usrs = array(
                "id"       => $data["id"],
                "user_nick"     => $data["user_nick"],
                "user_mail"     => $data["user_mail"],
                "user_password" => $data["user_password"],
                "user_photo"    => $data["user_photo"],
                "user_gender"   => $data["user_gender"],
                "university_id" => $data["university_id"]
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
        $data = $this->db->users('id', $content["id"])->fetch();
        if($data) 
        { 
            $usr = array(
                "user_nick"     => $data["user_nick"],
                "user_mail"     => $data["user_mail"],
                "user_password" => $content["user_password"],
                "user_photo"    => $content["user_photo"],
                "user_gender"   => $content["user_gender"],
                "university_id" => $content["university_id"]
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


