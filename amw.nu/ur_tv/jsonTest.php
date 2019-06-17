<?php

$mysqli = new mysqli('mydb8.surf-town.net', "hb37147_amw", "2Paccap2", "hb37147_wi2");

if ($mysqli->connect_errno) {
    printf("No connection: %s\n", $mysqli->connect_error);
    exit();
}

$cat = $_POST['cat'];
$cat = 2;

$cat = (int) $cat;

$sql = "SELECT `id`, `name`,`qr`,`status`,`img` FROM `tv2_equipment` WHERE `cat` = $cat ";
$data = $mysqli->query($sql);

$response["success"] = true;

while ($obj = $data->fetch_assoc()) {
    $resp = Array(
        $obj);

    $response[] = $resp;
}
echo json_encode($response);
