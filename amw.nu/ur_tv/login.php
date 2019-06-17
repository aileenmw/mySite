<?php

//include 'session.php';

spl_autoload_register(function ($class) {
    require_once '../classes/' . $class . '.php';
});
$mysqli = UniversalConnect::doConnect();


$username = $_POST['username'];
$pw = $_POST['pw'];

$username = 'pol';
$pw = 'pot123';

$sql = "SELECT  `id`,`fname`, `lname`, `pw`, `role`,`status` FROM `ur_tv_users` WHERE `username`= '$username'";
$sql_update_status = "UPDATE `ur_tv_users` SET `status`= 1 WHERE `username` = '$username'";


$response = array();
$response["success"] = false;
$response["case"] = "four";

if (!$username || !$pw) {
    $response["success"] = false;
    $response["case"] = 'one';
} elseif ($query = $mysqli->query($sql)) {

    while ($obj = $query->fetch_object()) {

        $user_pw = $obj->pw;
        $status = $obj->status;

        if (($user_pw == $pw) && ($status == 0)) {
            $response["success"] = true;
            $response["id"] = (int) $obj->id;
            $response["fname"] = $obj->fname;
            $response["lname"] = $obj->lname;
            $response["role"] = $obj->role;
            $response["case"] = "four";
            $mysqli->query($sql_update_status);
        } elseif (($user_pw == $pw) && ($status == 1)) {
            $response["success"] = true;
            $response["id"] = (int) $obj->id;
            $response["fname"] = $obj->fname;
            $response["lname"] = $obj->lname;
            $response["role"] = $obj->role;
            $response["case"] = "two";
        } elseif ($user_pw !== $pw) {
            $response["success"] = false;
            $response["case"] = "three";
        }
//        elseif (!$obj->id) {
//            $response["success"] = false;
//            $response["case"] = "four";
//        }
    }
} else {
    $response["success"] = false;
    $response["case"] = "four";
}


echo json_encode($response);

