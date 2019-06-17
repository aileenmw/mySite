<?php

//ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
    require_once '../classes/' . $class . '.php';
});
$mysqli = UniversalConnect::doConnect();

$equipId = $_POST['equipid'];
$status = $_POST['status'];

//$equipId = 24;
//$status = 1;

$stmt = $mysqli->prepare("SELECT `loanTime`, `estimReturnTime`, `reservationTime`, `ur_tv_users`.id,`fname`,`lname`
FROM `ur_tv_loans` 
INNER JOIN `ur_tv_equipment` ON `ur_tv_loans`.`equipId`= `ur_tv_equipment`.`id`
INNER JOIN `ur_tv_users` ON  `ur_tv_loans`.`user_id` =  `ur_tv_users`.`id`
WHERE `equipId` = ? and  `ur_tv_equipment`.`status` =  ? ");

$stmt->bind_param("ii", $equipId, $status);

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {

    $response = $row;
}

echo json_encode($response);
