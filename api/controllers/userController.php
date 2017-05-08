<?php

class userController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model("user");
    }

    public function login($magicword)
    {
        print $this->model->userLogin($magicword);
    }

    public function authenticate($id, $token){
        print $this->model->userAuthentication($id, $token);
    }
}