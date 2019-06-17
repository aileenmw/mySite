<?php

ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
    require_once '../classes/' . $class . '.php';
});
$mysqli = UniversalConnect::doConnect();


//$user = 2;
//$equipId = 20;

$dt = date('Y-m-d H:i:s');
//var_dump($dt);

$stmt = $mysqli->prepare("INSERT INTO `ur_tv_loans`(`user_id`, `equipId`, `reservationTime`) VALUES (?,?,?)");


$stmt->bind_param("iis", $user, $equipId, $dt);

$case = 0;

if ($stmt->execute()) {
    $case = 1;
} else {
    $case = 2;
}

return $case;
