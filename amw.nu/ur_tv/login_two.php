<?php

//include 'session.php';

ini_set('display_errors', 1);

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


$stmt = $mysqli->prepare("SELECT  `id`,`fname`, `lname`, `pw`, `role`,`status` FROM `ur_tv_users` WHERE `username`= ?");
$stmt->bind_param("s", $username);

$stmt_update = $mysqli->prepare("UPDATE `ur_tv_users` SET `status`= 1 WHERE `username` = ?");
$stmt_update->bind_param("s", $username);


$response = array();
$response["success"] = false;
$response["case"] = "four";
$response["user"] = array();

if (!$username || !$pw) {
    $response["success"] = false;
    $response["case"] = 'one';
} elseif ($stmt->execute()) {

    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {

        $user_pw = $row['pw'];
        $status = $row['status'];
        $response["user"][] = $row;

        if (($user_pw == $pw) && ($status == 0)) {
            $response["success"] = true;

            $response["case"] = "four";
            $mysqli->query($sql_update_status);
        } elseif (($user_pw == $pw) && ($status == 1)) {
            $response["success"] = true;

            $response["case"] = "two";
        } elseif ($user_pw !== $pw) {
            $response["success"] = false;
            $response["case"] = "three";
        } elseif (!$obj->id) {
            $response["success"] = false;
            $response["case"] = "four";
        }
    }
} else {
    $response["success"] = false;
    $response["case"] = "four";
}


echo json_encode($response);

