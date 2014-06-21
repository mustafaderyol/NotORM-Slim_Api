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

    public function getAllCities() {
        $sql=$this->db->city();
        $cty = array();
        foreach ($sql as $data) {
            $cty[]  = array(
                "id"            => $data["id"],
                "city_name"     => $data["city_name"]
            );
        }
        return $cty;

    }

    public function getCityViewWithId($id) {

        $data = $this->db->city("id = ?",$id)->fetch();
        $cty = array(
                "id"            => $data["id"],
                "city_name"     => $data["city_name"]
        );
        return $cty;
    }

    public function getCityViewWithCityName($name) {

        $data = $this->db->city("city_name = ?",$name)->fetch();
        $cty = array(
                "id"       => $data["id"],
                "city_name"     => $data["city_name"]
        );
        return $cty;

    }

    public function deleteCityId($id) {

        if($data = $this->db->city("id = ?",$id)->delete()) {
            
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

    public function deleteCityName($name) {

        if($data = $this->db->city("city_name = ?",$name)->delete()) {
            
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

        if($data = $this->db->city()->insert($content)) {
            $cty = array(
                "id"       => $data["id"],
                "city_name"     => $data["city_name"]
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
        $data = $this->db->city('id', $content["id"])->fetch();
        if($data) 
        { 
            $cty = array(
                "city_name"     => $content["city_name"]
            );
            if($data->update($cty)) 
            { 
                return $cty;
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


