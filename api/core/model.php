<?php

class Model
{

    private $result = array("success" => false, "msg" => null, "result" => null, "number" => 0, "id" => null);
    private $db;
    private $auth_db;

    public function __construct()
    {
        $this->db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $this->db->set_charset("utf8");
    }

    /**
     * @param $table
     * @param bool $json
     * @return array|string
     */
    public function readAll($table, $json = true)
    {
        $res = $this->db->query("SELECT * FROM " . $table);
        if ($res) {
            $types = $this->getTypes($res);
            if ($res->num_rows > 0) {
                $this->result["number"] = $res->num_rows;
                $this->result["success"] = true;
                while ($rec = $res->fetch_assoc()) {
                    $rec = $this->convertToRealTypes($rec, $types);
                    $this->result["result"][] = $rec;
                }
            } else {
                $this->result["success"] = true;
                $this->result["msg"] = "No result";
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

    /**
     * @param $query
     * @param bool $json
     * @return array|string
     */
    public function read($query, $json = true)
    {
        $res = $this->db->query($query);
        if ($res) {
            $types = $this->getTypes($res);
            if ($res->num_rows > 0) {
                $this->result["number"] = $res->num_rows;
                $this->result["success"] = true;
                while ($rec = $res->fetch_assoc()) {
                    $rec = $this->convertToRealTypes($rec, $types);
                    $this->result["result"][] = $rec;
                }
            } else {
                $this->result["success"] = true;
                $this->result["msg"] = "No result";
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

    public function readSingle($query, $json = true)
    {
        $res = $this->db->query($query);
        if ($res) {
            $types = $this->getTypes($res);
            if ($res->num_rows == 1) {
                $this->result["number"] = $res->num_rows;
                $this->result["success"] = true;
                $rec = $res->fetch_assoc();
                $rec = $this->convertToRealTypes($rec, $types);
                $this->result["result"] = $rec;
            } else {
                $this->result["success"] = true;
                $this->result["msg"] = "No result";
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

    /**
     * @param $query
     * @param bool $json
     * @return array|string
     */
    public function exec($query, $json = true)
    {
        $stmt = $this->db->prepare($query);
        if ($stmt) {
            if ($stmt->execute()) {
                $this->result["success"] = true;
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

    /**
     * @param $table
     * @param $value
     * @param string $key
     * @param bool $json
     * @return array|string
     */
    public function remove($table, $value, $key = "id", $json = true)
    {
        $value = $this->getProperValue($value);
        $query = "DELETE FROM " . $table . " WHERE " . $key . " = " . $value;
        $stmt = $this->db->prepare($query);
        if ($stmt) {
            if ($stmt->execute()) {
                $this->result["success"] = true;
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

    /**
     * @param $table
     * @param $columns
     * @param array $values
     * @param bool $json
     * @return array|string
     */
    public function insert($table, $values, $json = true)
    {
        foreach ($values as $key => $value) {
            $values[$key] = $this->getProperValue($value);
            $columns[] = $key;
        }

        $values = implode(",", $values);
        $columns = implode(",", $columns);
        $query = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $values . ")";

        $stmt = $this->db->prepare($query);
        if ($stmt) {
            if ($stmt->execute()) {
                $this->result["id"] = $this->db->insert_id;
                $this->result["success"] = true;
                $this->result["msg"] = "Successfully inserted";
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

    /**
     * @param $table
     * @param array $values key/value pairs
     * @param $id
     * @param string $column_ref
     * @param bool $json
     * @return array|string
     */
    public function update($table, $values, $id, $column_ref = "id", $json = true)
    {
        $valuesToSet = array();
        foreach ($values AS $key => $value) {
            $valuesToSet[] = $key . "=" . $this->getProperValue($value);
        }
        $valuesToSet = implode(",", $valuesToSet);
        $query = "UPDATE " . $table . " SET " . $valuesToSet . " WHERE " . $column_ref . " LIKE '" . $id . "'";
        $stmt = $this->db->prepare($query);
        if ($stmt) {
            if ($stmt->execute()) {
                $this->result["success"] = true;
                $this->result["msg"] = $query;
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

    /**
     * @param $table
     * @param bool $json
     * @return array|string
     */
    public function truncate($table, $json = true)
    {
        $query = "TRUNCATE " . $table;
        $stmt = $this->db->prepare($query);
        if ($stmt) {
            if ($stmt->execute()) {
                $this->result["success"] = true;
                $this->result["msg"] = $table . " truncated";
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

    /**
     * @param $username
     * @param $password
     * @param bool $json
     * @return array|string
     */
    public function login($username, $password, $json = true)
    {
        $query = "SELECT * FROM masterlogin WHERE username = '" . $username . "' AND password = '" . sha1($password) . "'";
        $res = $this->db->query($query);
        if ($res) {
            if ($res->num_rows == 1) {
                $rec = $res->fetch_assoc();
                $token = sha1(microtime());
                $update_token = $this->update("masterlogin", array("token"=>$token), $rec["id"], "id", false);
                if ($update_token["success"]) {
                    $this->result["success"] = true;
                    $this->result["result"] = $rec;
                    $this->result["result"]["token"] = $token;
                    $this->result["msg"] = "Successfully logged in";
                } else {
                    $this->result["msg"] = "Token Update Error: " . $update_token["msg"];
                }
            } else {
                $this->result["msg"] = "Wrong!!!";
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

    /**
     * @param $path
     * @return array|string
     */
    public function upload($path, $json = true)
    {
        $result = array();

        for ($i = 0; $i < count($_FILES["file"]["name"]); $i++) {
            $tmpFilePath = $_FILES["file"]["tmp_name"][$i];
            $filename = $_FILES["file"]["name"][$i];
            $parts = explode(".", $filename);
            $ext = end($parts);

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
                mkdir($path . "/thumb", 0777, true);
            }

            $originalFileNameWithPath = $path . "/" . $filename;


            if (move_uploaded_file($tmpFilePath, $originalFileNameWithPath)) {

                $hash = md5_file($originalFileNameWithPath);

                rename($originalFileNameWithPath, $path . "/" . $hash . "." . $ext);

                $this->createThumbnail($path . "/" . $hash . "." . $ext, $path . "/thumb/" . $hash . "." . $ext, 250, 250);

                $result[$i] = array("success" => true, "name" => $hash . "." . $ext, "original" => $filename);
            } else {
                $result[$i] = array("success" => false, "name" => null, "original" => $filename);
            }

        }
        if ($json) {
            return json_encode($result);
        } else {
            return $result;
        }
    }

    /**
     * @param $name
     * @param $filename
     * @param $new_w
     * @param $new_h
     */
    private function createThumbnail($name, $filename, $new_w, $new_h)
    {
        $parts = explode(".", $name);
        $ext = strtolower(end($parts));
        if ($ext === "jpg" || $ext === "jpeg") {
            $src_img = imagecreatefromjpeg($name);
        }
        if ($ext === "png") {
            $src_img = imagecreatefrompng($name);
        }
        $old_x = imageSX($src_img);
        $old_y = imageSY($src_img);
        if ($old_x > $old_y) {
            $thumb_w = $new_w;
            $thumb_h = $old_y * ($new_h / $old_x);
        }
        if ($old_x < $old_y) {
            $thumb_w = $old_x * ($new_w / $old_y);
            $thumb_h = $new_h;
        }
        if ($old_x == $old_y) {
            $thumb_w = $new_w;
            $thumb_h = $new_h;
        }
        $dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);
        $white = imagecolorallocate($dst_img, 255, 255, 255);
        imagefill($dst_img, 0, 0, $white);
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);
        if ($ext === "png") {
            imagepng($dst_img, $filename);
        } else {
            imagejpeg($dst_img, $filename);
        }
        imagedestroy($dst_img);
        imagedestroy($src_img);
    }

    private function getTypes($res)
    {
        $types = array();
        $finfo = mysqli_fetch_fields($res);
        foreach ($finfo as $val) {
            $types[$val->name] = $val->type;
        }
        return $types;
    }

    private function convertToRealTypes($rec, $types)
    {
        foreach ($rec AS $key => $value) {
            switch ($types[$key]) {
                case 1:
                    $rec[$key] = (bool)$value;
                    break;
                case 3:
                    $rec[$key] = (int)$value;
                    break;
                case 8:
                    $rec[$key] = (int)$value;
                    break;
                case 9:
                    $rec[$key] = (int)$value;
                    break;
            }
        }
        return $rec;
    }

    private function getProperValue($value)
    {
        if (is_bool($value)) {
            if ($value) {
                return 1;
            } else {
                return 0;
            }
        } elseif (is_null($value)) {
            return "NULL";
        } elseif (is_string($value)) {
            if (strtolower($value) === "true") {
                return 1;
            } elseif (strtolower($value) === "false") {
                return 0;
            } elseif (strtolower($value) === "null") {
                return "NULL";
            } else {
                $value = $this->db->real_escape_string($value);
                return "'" . $value . "'";
            }
        } else {
            return $value;
        }
    }
}
