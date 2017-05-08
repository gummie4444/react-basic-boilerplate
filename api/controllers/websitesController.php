<?php

class websitesController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model("websites");
    }

    public function getAll()
    {
        echo $this->model->getWebsites();
    }

    public function getSpecific($id)
    {
        echo $this->model->getSpecificWebsiteUsers($id);
    }

    public function getAllUsers()
    {
        echo $this->model->getAllUsers();
    }

    public function getRoles($id)
    {
        echo $this->model->getWebsiteRoles($id);
    }

    public function setRoles($id, $value)
    {
        echo $this->model->setWebsiteRoles($id, $value);
    }

    public function addUser($website, $user)
    {
        echo $this->model->addUserToWebsite($website, $user);
    }

    public function deleteUser($id, $website)
    {
        echo $this->model->deleteUserFromWebsite($id, $website);
    }

    public function setManager($id, $manager)
    {
        echo $this->model->setManager($id, $manager);
    }
}