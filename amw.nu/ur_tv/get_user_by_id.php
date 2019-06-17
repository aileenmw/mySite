<?php

//ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
    require_once '../classes/' . $class . '.php';
});
$mysqli = UniversalConnect::doConnect();

$user_id = $_POST[userId];
$user_id = 1;

$stmt = $mysqli->prepare("SELECT `fname`, `lname` FROM `ur_tv_users` WHERE `id` = ?");
$stmt->bind_param("i", $user_id);

$stmt->execute();

$result = $stmt->get_result();

$response = array();
$response["success"];

while($row = $result->fetch_assoc()){
    $response = $row;
}


echo json_encode($response);