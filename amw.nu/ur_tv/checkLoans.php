<?php

ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
    require_once '../classes/' . $class . '.php';
});
$mysqli = UniversalConnect::doConnect();


$userId = $_POST['userId'];

//$userId = 1;

$stmt_bookings = $mysqli->prepare("SELECT ur_tv_loans.id as loanId, ur_tv_loans.`equipId`, `cat`, `img` ,
      `user_id`, `loanTime`, `estimReturnTime`, `reservationTime`, `name`
      FROM `ur_tv_loans` 
      INNER JOIN ur_tv_equipment ON ur_tv_loans.`equipId` = ur_tv_equipment.id 
      WHERE ur_tv_loans.`status` = 1  AND ur_tv_loans.`user_id` = ?");

$stmt_bookings->bind_param('i', $userId);
$stmt_bookings->execute();
$result = $stmt_bookings->get_result();

$stmt_loans = $mysqli->prepare("SELECT ur_tv_loans.id, ur_tv_loans.`equipId`, `cat`, `img` ,
      `user_id`, `loanTime`, `estimReturnTime`, `reservationTime`, `name`
      FROM `ur_tv_loans` 
      INNER JOIN ur_tv_equipment ON ur_tv_loans.`equipId` = ur_tv_equipment.id 
      WHERE ur_tv_loans.`status` = 2  AND ur_tv_loans.`user_id` = ?");

$stmt_loans->bind_param('i', $userId);
$stmt_loans->execute();
$result1 = $stmt_loans->get_result();

$response = array();

$response[success] = true;

$response['booking'] = array();
$response['loan'] = array();


while ($row = $result->fetch_assoc()) {
    $response['booking'][] = $row;
}
while ($row1 = $result1->fetch_assoc()) {
    $response['loan'][] = $row1;
}

echo json_encode($response);
