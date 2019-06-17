<?php

//ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
    require_once '../classes/' . $class . '.php';
});
$mysqli = UniversalConnect::doConnect();

$equip_id = $_GET['id'];
//$equip_id = 34;

if ($equip_id) {
   $sql_book_check = "SELECT `status` FROM `ur_tv_equipment` WHERE `id` = $equip_id ";
    $result = $mysqli->query($sql_book_check);
    while ($row = $result->fetch_object()) {
        $status = $row->status;
    }
}

$case = 0;
(int)$user = 0;
$return_time = 0;

switch ($status) {
    case 0 :
        // not booked or loaned
        $case = 1;
        break;

    case 1 :
        // booked -> get booker to check if its the same as the user
        $sql_booker = "SELECT `user_id`, `estimReturnTime` FROM `ur_tv_loans` WHERE `equipId` = $equip_id ";
        $data = $mysqli->query($sql_booker);
        while ($row = $data->fetch_object()) {
           (int)$user = $row->user_id;
           $return_time = $row->estimReturnTime;
        }
        
        $case = 2;
        break;

    case 2 :
        // eqip is loaned out
        $sql_return = "SELECT `estimReturnTime`, `user_id` FROM `ur_tv_loans` WHERE `equipId` = $equip_id";
        $result = $mysqli->query($sql_return);
        while ($row = $result->fetch_object()) {
            $return_time = $row->estimReturnTime;
            $user = $row = $row->user_id;
        }

        $case = 3;

        break;
}

$post_data = json_encode(array(
    'equip_id' => $equip_id,
    'user' => (int)$user,
    'case' => $case,
    'return_time' => $return_time), JSON_FORCE_OBJECT);

echo $post_data;
