<?php

//include 'session.php';
//$mysqli = new mysqli('mydb8.surf-town.net', "hb37147_amw", "2Paccap2", "hb37147_wi2");

spl_autoload_register(function ($class) {
    require_once '../classes/' . $class . '.php';
});
$mysqli = UniversalConnect::doConnect();

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$username = $_POST['username'];
$pw = $_POST['pw'];


if ($_POST['role']) {
    $role = $_POST['role'];
} else {
    $role = 'staff';
}

$response = array();

//$fname = 'Gucki';
//$lname = 'Tutu';
//$email = 'tutu@mail.com';
//$username = 'tutu';
//$pw = '123wer';
//$role = 'staff';

$sql_check_name = "SELECT `username` FROM `ur_tv_users` WHERE `fname`= '$fname' and `lname` = '$lname'";
$data = $mysqli->query($sql_check_name);

while ($obj = $data->fetch_object()) {
    $name_check = $obj->username;
}

$sql_checkUsername = "SELECT `username` FROM `ur_tv_users` WHERE `username`= '$username'";
$data = $mysqli->query($sql_checkUsername);

while ($obj = $data->fetch_object()) {
    $username_check = $obj->username;
}
$response[success] = false;
//if($_SESSION['login_status'] === 'loged_in'){
//     $response["case"] = "7";
//}else{
if (!$fname || !$lname || !$email || !$username || !$pw) {
    $response["case"] = "2";
} elseif (!$fname && !$lname && !$email && !$username && !$pw) {
    $response["case"] = "2";
} elseif ($username_check) {
    $response["case"] = "3";
} elseif ($name_check) {
    $response["case"] = "4";
} elseif (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{6,50}$/', $pw)) {
    $response["case"] = "5";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response["case"] = "6";
} else {
    $sql = "INSERT INTO `ur_tv_users`(`fname`, `lname`, `username`,`email`, `pw`, `role`) VALUES ('$fname', '$lname', '$username', '$email',  '$pw', '$role')";
    if ($query = $mysqli->query($sql)) {
        $response["success"] = true;
        $response["case"] = "1";
    }
}
//}
echo json_encode($response);



