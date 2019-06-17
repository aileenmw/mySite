<?php
ini_set('display_errors', 1);

$mysqli = new mysqli('mydb8.surf-town.net', "hb37147_amw", "2Paccap2", "hb37147_wi2");

if ($mysqli->connect_errno) {
    printf("No connection: %s\n", $mysqli->connect_error);
    exit();
}

$cat = $_POST['cat'];
//$cat = 2;

$stmt= $mysqli->prepare("SELECT `id`, `name`,`qr`,`status`,`img` FROM `ur_tv_equipment` WHERE `cat` = ? ");
$stmt->bind_param("i", $cat);
$stmt->execute();

$result = $stmt->get_result();

$response = array();
$response["success"] = true;


while ($row = $result->fetch_assoc()) {
$response["items"][] = $row;
}

echo json_encode($response);

