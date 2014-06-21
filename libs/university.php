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

    public function getAllUniversities() {
        $sql=$this->db->university();
        $usrs = array();
        foreach ($sql as $data) {
            $usrs[]  = array(
                "id"                => $data["id"],
                "university_name"   => $data["university_name"],
                "university_ext"    => $data["university_ext"],
                "city_id"           => $data["city_id"]
            );
        }
        return $usrs;

    }

    public function getUniversityViewWithId($id) {

        $data = $this->db->university("id = ?",$id)->fetch();
        $usr = array(
                "id"                => $data["id"],
                "university_name"   => $data["university_name"],
                "university_ext"    => $data["university_ext"],
                "city_id"           => $data["city_id"]
        );
        return $usr;
    }

    public function getUniversityViewWithExt($ext) {

        $data = $this->db->university("university_ext = ?",$ext)->fetch();
        $usr = array(
                "id"                => $data["id"],
                "university_name"   => $data["university_name"],
                "university_ext"    => $data["university_ext"],
                "city_id"           => $data["city_id"]
        );
        return $usr;

    }


    public function getUniversityViewWithCity($id) {

        $sql = $this->db->university("city_id = ?",$id);
        foreach ($sql as $data) {
            $usrs[]  = array(
                "id"                => $data["id"],
                "university_name"   => $data["university_name"],
                "university_ext"    => $data["university_ext"],
                "city_id"           => $data["city_id"]
            );
        }
        return $usrs;

    }

    public function deleteUniversityId($id) {

        if($data = $this->db->university("id = ?",$id)->delete()) {
            
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

        if($data = $this->db->university()->insert($content)) {
            $usrs = array(
                "id"                => $data["id"],
                "university_name"   => $data["university_name"],
                "university_ext"    => $data["university_ext"],
                "city_id"           => $data["city_id"]
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
        $data = $this->db->university('id', $content["id"])->fetch();
        if($data) 
        { 
            $usr = array(
                "university_name"   => $content["university_name"],
                "university_ext"    => $content["university_ext"],
                "city_id"           => $content["city_id"]
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


