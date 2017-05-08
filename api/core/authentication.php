<?php

class Authentication
{
    private $result = array("success" => false, "msg" => null, "result" => null, "number" => 0, "id" => null);
    private $db;

    public function __construct() {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $this->db->set_charset("utf8");
    }

    public function authenticate($id, $token, $json = true) {
        $res = $this->db->query("SELECT * FROM login WHERE id=$id AND token = '$token'");
        if ($res) {
            $this->result["number"] = $res->num_rows;
            if ($res->num_rows == 1) {
                $this->result["success"] = true;
                $rec = $res->fetch_assoc();
                $this->result["result"] = $rec;
            } else {
                $this->result["msg"] = $this->db->error;
            }
        } else {
            $this->result["msg"] = $this->db->error;
        }
        if ($json) {
            return json_encode($this->result);
        } else {
            return $this->result;
        }
    }

    public function authFailed($code) {
        $result = array("success" => false, "msg" => "Authentication failed. code: E" . $code, "result" => null);
        $return = json_encode($result, JSON_NUMERIC_CHECK);
        exit($return);
    }
}