<?php

ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
    require_once '../classes/' . $class . '.php';
});
$mysqli = UniversalConnect::doConnect();

// get a response and build a switch case ->
//                                get userid if equip is booked or loaned out
//
//                                if booked : check if booked by user
//                                 alert : do You want to loan
//                                 OR alert : this item is booked by one of Your collegues and should be back -> time
//
//                                 if nothing : alert do You want to loan
//                                    if yes : return time
//
//                                 if loaned: alert : do You want to return
//                                    if return : check if on time, if not check if booked already
//                                    if booked -> inform bookee                      
//                                               hvis ikke udlånt eller reserveret => udlån 
// check wether eqip is booked and get userid if
$equip_id = $_GET['id'];
$equip_id = 16;

if ($equip_id) {
    $sql_book_check = "SELECT `status` FROM `ur_tv_equipment` WHERE `id` = $equip_id ";
    $result = $mysqli->query($sql_book_check);
    while ($row = $result->fetch_object()) {
        echo $status = $row->status;

        echo '<br>';
    }
}

$case = 0;
$user = 0;
$return_time = 0;

switch ($status) {
    case 0 :
        // not booked or loanes
        $case = 1;
        break;

    case 1 :
        // booked -> get booker to check if its the same as the user
        $sql_booker = "SELECT `user_id` FROM `ur_tv_loans` WHERE `equipId` = $equip_id ";
        $data = $mysqli->query($sql_booker);
        while ($row = $data->fetch_object()) {
            $user = $row->user_id;
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

        $case = 1;

        break;
}


$post_data = json_encode(array(
    'user' => $user,
    'case' => $case,
    'return_time' => $return_time), JSON_FORCE_OBJECT);

echo $post_data;
