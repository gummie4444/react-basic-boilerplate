<?php

class userModel extends Model
{
    public function userLogin($magicword)
    {
        echo $this->login("masterofpuppets",$magicword);
    }

    public function userAuthentication($id, $token){
        echo $this->read("SELECT * FROM masterlogin WHERE id=$id AND token='$token'");
    }
}