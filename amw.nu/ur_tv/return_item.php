<?php

//ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
    require_once '../classes/' . $class . '.php';
});
$mysqli = UniversalConnect::doConnect();

$eqipId = $_POST['equipid'];

$sql_del_loan = "DELETE FROM `ur_tv_loans` WHERE `equipId` = $eqipId";
$sql_update_equip = "UPDATE `ur_tv_equipment` SET `status`= 0 WHERE `id` = $eqipId";


$response["success"] = false;
if( $mysqli->query($sql_del_loan) && $mysqli->query($sql_update_equip) ){
    $response["success"] = true;
}else{
    $response["success"] = FALSE;
}

echo json_encode($response);