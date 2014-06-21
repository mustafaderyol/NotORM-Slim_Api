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

    public function getAllLodgments() {
        $sql=$this->db->lodgment();
        $lks = array();
        foreach ($sql as $data) {
            $lks[]  = array(
                "id"          => $data["id"],
                "user_id"     => $data["user_id"],
                "message_id"  => $data["message_id"],
                "ip"          => $data["ip"],
                "date"        => $data["date"],
                "reason_id"   => $data["reason_id"]
            );
        }
        return $lks;

    }

    public function getLodgmentViewWithId($id) {

        $data = $this->db->lodgment("id = ?",$id)->fetch();
        $fvrt = array(
                "id"          => $data["id"],
                "user_id"     => $data["user_id"],
                "message_id"  => $data["message_id"],
                "ip"          => $data["ip"],
                "date"        => $data["date"],
                "reason_id"   => $data["reason_id"]
        );
        return $fvrt;
    }


    public function getLodgmentViewWithUserID($id) {

        $data = $this->db->lodgment("user_id = ?",$id)->fetch();
        $fvrt = array(
                "id"          => $data["id"],
                "user_id"     => $data["user_id"],
                "message_id"  => $data["message_id"],
                "ip"          => $data["ip"],
                "date"        => $data["date"],
                "reason_id"   => $data["reason_id"]
        );
        return $fvrt;

    }


    public function getLodgmentViewWithMessageId($id) {

        $sql = $this->db->lodgment("message_id = ?",$id);
        foreach ($sql as $data) {
            $fvrts[]  = array(
                "id"          => $data["id"],
                "user_id"     => $data["user_id"],
                "message_id"  => $data["message_id"],
                "ip"          => $data["ip"],
                "date"        => $data["date"],
                "reason_id"   => $data["reason_id"]
            );
        }
        return $fvrts;

    }



    public function getLodgmentViewWithReasonId($id) {

        $sql = $this->db->lodgment("reason_id = ?",$id);
        foreach ($sql as $data) {
            $fvrts[]  = array(
                "id"          => $data["id"],
                "user_id"     => $data["user_id"],
                "message_id"  => $data["message_id"],
                "ip"          => $data["ip"],
                "date"        => $data["date"],
                "reason_id"   => $data["reason_id"]
            );
        }
        return $fvrts;

    }

    public function deleteLodgmentId($id) {

        if($data = $this->db->lodgment("id = ?",$id)->delete()) {
            
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

        if($data = $this->db->lodgment()->insert($content)) {
            $fvrt = array(
                "id"          => $data["id"],
                "user_id"     => $data["user_id"],
                "message_id"  => $data["message_id"],
                "ip"          => $data["ip"],
                "date"        => $data["date"],
                "reason_id"   => $data["reason_id"]
            );
            return $fvrt;
        } else {
            $error = array(
                "error"     => "SAVE_ERROR"
            );
            return $error;
        }

    }


    public function errorNotFound() {
        $error = array(
            "error"     => "NOT_FOUND"
        );
        return $error;
    }
}


