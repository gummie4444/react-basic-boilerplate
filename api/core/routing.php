<?php

class Routing
{
    private $blackList = array(
        "websitesController/setRoles" => 1,
        "websitesController/addUser" => 1,
        "websitesController/deleteUser" => 1
    );

    public function checkAccess($controller, $method, $role)
    {
        $cm = $controller . "/" . $method;
        if (isset($this->blackList[$cm])) {
            if ($this->blackList[$cm] >= $role) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }
}