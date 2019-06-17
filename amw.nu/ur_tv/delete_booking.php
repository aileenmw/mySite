<?php

ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
    require_once '../classes/' . $class . '.php';
});
$mysqli = UniversalConnect::doConnect();


$bookingId = $_POST['bookedId'];
//$bookingId= 1;
//$response = array();

$stmt = $mysqli->prepare(" DELETE FROM `ur_tv_loans` WHERE `id` = ? ");
$stmt->bind_param("i", $bookingId);

$stmt2 = $mysqli->prepare("UPDATE `ur_tv_equipment` 
                         INNER JOIN ur_tv_loans ON ur_tv_equipment.id = ur_tv_loans.equipId
                         SET ur_tv_equipment.`status`= 0
                         WHERE ur_tv_equipment.`id` = 
                        (SELECT equipId FROM ur_tv_loans WHERE id = ?)");
$stmt2->bind_param("i", $bookingId);

$response["success"] = false;

if ($bookingId) {
    if ($stmt2->execute()) {

        if ($stmt->execute()) {


            $response["success"] = true;
        } else {
            $response["success"] = false;
//                'BookingId : '. $bookingId.'Det er sket en fejl - reserveringen er ikke blevet slettet' ;
        }
    }
} else {
    $response["success"] = false;
}
echo json_encode($response);
