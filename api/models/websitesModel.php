<?php

class websitesModel extends Model
{
    public function getWebsites()
    {
        return $this->readAll("websites");
    }

    public function getSpecificWebsiteUsers($id)
    {
        $query = "SELECT
          wu.id,
          wu.user AS name,
          wr.id AS roleid,
          wr.name AS role,
          wu.manager
        FROM websiteusers AS wu
        JOIN websiteroles AS wr ON wr.id = wu.role
        JOIN websiteuserlink AS wul ON wul.userid=wu.id
        WHERE wul.websiteid = $id AND wu.user NOT LIKE 'aberta'";

        return $this->read($query);
    }

    public function getAllUsers()
    {
        return $this->readAll("websiteusers");
    }

    public function getWebsiteRoles($id)
    {
        $query = "SELECT *
        FROM websiteroles
        WHERE website = $id OR website = 0";

        return $this->read($query);
    }

    public function setWebsiteRoles($id, $value)
    {
        return $this->update("websiteusers", array("role" => $value), $id);
    }

    public function addUserToWebsite($website, $user)
    {
        $userExists = $this->readSingle("SELECT * FROM websiteusers WHERE user LIKE '$user'", false);
        if ($userExists["number"] == 1) {
            return $this->insert("websiteuserlink", array("userid" => $userExists["result"]["id"], "websiteid" => $website));
        } else {
            $values = array("user" => $user);
            $insertedUser = $this->insert("websiteusers", $values, false);
            if ($insertedUser["success"]) {
                return $this->insert("websiteuserlink", array("userid" => $insertedUser["id"], "websiteid" => $website));
            } else {
                return json_encode($insertedUser);
            }
        }
    }

    public function deleteUserFromWebsite($id, $website)
    {
        if ($id != 1) {
            $query = "DELETE FROM websiteuserlink WHERE userid = $id AND websiteid = $website";
            return $this->exec($query);
        } else {
            return json_encode(array("success" => false, "msg" => "This user cannot be deleted."));
        }
    }

    public function setManager($id, $manager)
    {
        return $this->update("websiteusers", array("manager" => $manager), $id);
    }
}