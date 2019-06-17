<?php

ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
    require_once '../classes/' . $class . '.php';
});
$mysqli = UniversalConnect::doConnect();


$user = $_POST['userid'];
$equipId = $_POST['equipid'];
$returnTime = $_POST['returnTime'];

//$user = 1;
//$equipId = 8;
//$returnTime = "1878-01-01 01:01:01";

$dt = date('Y-m-d H:i:s');

$stmt = $mysqli->prepare("INSERT INTO `ur_tv_loans`(`user_id`, `equipId`, `reservationTime`, `estimReturnTime`,`status` ) VALUES (?,?,?,?,1)");
$stmt_1 = $mysqli->prepare("UPDATE `ur_tv_equipment` SET `status`= 1  WHERE `id` = ?");

//$stmt_2 = $mysqli->prepare("SELECT `loanTime`, `estimReturnTime`, `reservationTime` FROM `ur_tv_loans` WHERE `equipId` = $equipId");


$stmt->bind_param("iiss", $user, $equipId, $dt, $returnTime);
$stmt_1->bind_param("i", $equipId);


$case = 0;

if(!$user) {
    $case = 4;
}elseif(!$equipId){
    $case = 5;
}elseif(!$returnTime){
     $case = 6;
}elseif (!$stmt->execute()) {
    $case = 2;
}elseif(!$stmt_1->execute()){
        $case = 3;
}else{
    $case = 1;
}

echo $case;
