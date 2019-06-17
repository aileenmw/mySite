<?php

$mysqli = new mysqli('mydb8.surf-town.net', "hb37147_amw", "2Paccap2", "hb37147_wi2");

if ($mysqli->connect_errno) {
    printf("No connection: %s\n", $mysqli->connect_error);
    exit();
}

$username = $_POST['username'];
$pw = $_POST['pw'];

$username = 'pol';
$pw = 'pot';


$sql = "SELECT `fname`, `lname`, `pw` FROM `ur_tv_users` WHERE `username`= '$username'";

//die('hertil');
$response = array();
//$response["succes"] = true;

if (!$username || !$pw) {
    $response["success"] = false;
    $response["case"] = 'one';
} else {
    $query = $mysqli->query($sql);
    while ($obj = $query->fetch_object()) {
        $check_pw = $obj->pw;
        $fname = $obj->fname;
        $lname = $obj->lname;
        if ($check_pw == $pw) {
            $response["success"] = true;
            $response["fname"] = $fname;
            $response["lname"] = $lname;
        } else {
            $response["success"] = false;
        }
    }
}
echo json_encode($response);
