<?php

$controller = null;
$method = null;
$params = null;
$role = null;
header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Max-Age: 1000');
    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization, X-Requested-With');

if (isset($_GET["c"]) && isset($_GET["m"])) {
    $controller = $_GET["c"] . "Controller";
    unset($_GET["c"]);
    $method = $_GET["m"];
    unset($_GET["m"]);
    $params = $_GET;
} elseif (isset($_POST["c"]) && isset($_POST["m"])) {
    $controller = $_POST["c"] . "Controller";
    unset($_POST["c"]);
    $method = $_POST["m"];
    unset($_POST["m"]);
    $params = $_POST;
} else {
    $post = json_decode(file_get_contents("php://input"), true);
    if (isset($post["c"]) && isset($post["m"])) {
        $controller = $post["c"] . "Controller";
        unset($post["c"]);
        $method = $post["m"];
        unset($post["m"]);
        $params = $post;
    } else {
        $return = json_encode(array("success" => false, "msg" => "Controller not found", "result" => array("controller" => $controller, "method" => $method)));
        exit($return);
    }
}

require_once "core/controller.php";
require_once "core/model.php";
require_once 'core/config.php';
require_once 'core/authentication.php';
require_once 'core/routing.php';

$auth = new Authentication();

//to be skipped when logging in

if ($controller != 'user' && $method != 'login' && $method != 'authenticate') {
    $headers = apache_request_headers();
    if (isset($headers["Authorization"])) {
        $parts = explode(":", $headers["Authorization"]);
        if (count($parts) === 2) {
            list($id, $encToken) = $parts;
            $authResult = $auth->authenticate($id, $encToken, false);
            if (!$authResult["success"]) {
                $role = 0;
            } else {
                $role = $authResult["result"]["role"];
            }
        } else {
            $role = 0;
        }
    } else {
        $role = 0;
    }
}
$filename = "controllers/" . $controller . ".php";

if (file_exists($filename)) {
    require_once $filename;

    $ctrlName=$controller;
    $controller = new $controller;

    // checking if the method exists, and calling it
    if (method_exists($controller, $method)) {
        $route = new Routing();
        if($route->checkAccess($ctrlName, $method, $role)){
            call_user_func_array([$controller, $method], $params);
        } else {
            print json_encode(array("success" => false, "msg" => "You are not authorized to access this controller/method", "result" => array("controller" => $ctrlName, "method" => $method)));
        }
    } else {
        print json_encode(array("success" => false, "msg" => "Method not found", "result" => array("controller" => $ctrlName, "method" => $method)));
    }
} else {
    print json_encode(array("success" => false, "msg" => "No controller or method defined", "result" => array("controller" => $ctrlName, "method" => $method)));
}
