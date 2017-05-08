<?php

class Controller
{
    public function model($model)
    {
        $modelName = $model . "Model";
        require_once "models/" . $model . "Model.php";
        return new $modelName();
    }
}