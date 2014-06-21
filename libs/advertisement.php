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

    public function getAllAdvertisement() {
        $sql=$this->db->advertisement();
        $adv = array();
        foreach ($sql as $data) {
            $adv[]  = array(
                "id"            => $data["id"],
                "company_id"    => $data["company_id"],
                "city_id"       => $data["city_id"],
                "date"          => $data["date"],
                "picture"       => $data["picture"]
            );
        }
        return $adv;

    }

    public function getAdvertisementViewWithId($id) {

        $data = $this->db->advertisement("id = ?",$id)->fetch();
        $adv = array(
                "id"            => $data["id"],
                "company_id"    => $data["company_id"],
                "city_id"       => $data["city_id"],
                "date"          => $data["date"],
                "picture"       => $data["picture"]
        );
        return $adv;
    }

    public function deleteAdvertisementId($id) {

        if($data = $this->db->advertisement("id = ?",$id)->delete()) {
            
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

        if($data = $this->db->advertisement()->insert($content)) {
            $cty = array(
                "id"            => $data["id"],
                "company_id"    => $data["company_id"],
                "city_id"       => $data["city_id"],
                "date"          => $data["date"],
                "picture"       => $data["picture"]
            );
            return $cty;
        } else {
            $error = array(
                "error"     => "SAVE_ERROR"
            );
            return $error;
        }

    }


    public function updateContent($content) {
        $data = $this->db->advertisement('id', $content["id"])->fetch();
        if($data) 
        { 
            $adv = array(
                "company_id"    => $content["company_id"],
                "city_id"       => $content["city_id"],
                "date"          => $content["date"],
                "picture"       => $content["picture"]
            );
            if($data->update($adv)) 
            { 
                return $adv;
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


