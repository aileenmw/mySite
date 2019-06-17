<?php

$con = new mysqli('mydb8.surf-town.net', "hb37147_amw", "2Paccap2", "hb37147_wi2");

if ($mysqli->connect_errno) {
    printf("No connection: %s\n", $mysqli->connect_error);
    exit();
}

//$username = $_POST['username'];
//$pw = $_POST['pw'];

$username = 'katze';
$pw = 'cute';

$statement = mysqli_prepare($con, "SELECT `id`,`fname`,`lname`,`username`,`pw` FROM `ur_tv_users` WHERE `username`= ? AND `pw` = ? ");
mysqli_stmt_bind_param($statement, "ss", $username, $pw);
mysqli_stmt_execute($statement);

mysqli_stmt_store_result($statement);
mysqli_stmt_bind_result($stmt, $userID, $fname, $lname, $username, $pw);

$response = array();
$response["succes"] = false;

while (mysqli_stmt_fetch($statement)) {
    $response["succes"] = true;
    $response["userID"] = $userID;
    $response["fname"] = $fname;
    $response["lname"] = $lname;
    $response["username"] = $username;
    $response["pw"] = $pw;
}

echo json_encode($response);
