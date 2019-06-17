<?php

die('deactivated med die();...men den virker');
//ini_set('display_errors', 1);


spl_autoload_register(function ($class) {
    require_once '../classes/' . $class . '.php';
});
$mysqli = UniversalConnect::doConnect();



$sql_max = "SELECT  max(`id`) as max  FROM `ur_tv_equipment`";
$data_max = $mysqli->query($sql_max);
$obj_max = $mysqli->query($data_max);
$max = $obj_max->max;



$sql = "SELECT  `id`  FROM `ur_tv_equipment`";
$data = $mysqli->query($sql);

$x = 0;
$qr = new QR_BarCode();



while ($obj = $data->fetch_object()) {
    $id = $obj->id;

    for ($x = 0; $x <= $max; $x++) {

//        $qr->number($id);
        $url = 'http://http://amw.nu/ur_tv/equip_qr/qr_direct_handler.php?id='. $id;
        $qr->url($url);
        $qr->qrCode();
        $qr->qrCode(250, 'qr_codes/qr' . $id . '.png');
    }
}

function update_qr($id, $qr_png, $mysqli) {
    echo $sql_up = "UPDATE `ur_tv_equipment` SET `qr`= '$qr_png' WHERE `id` = $id";
    $mysqli->query($sql_up);
}

$sql2 = "SELECT  `id`  FROM `ur_tv_equipment`";
$data2 = $mysqli->query($sql2);

while ($obj2 = $data2->fetch_object()) {
    $id2 = $obj2->id;
    $qr_png = 'qr' . $id2 . '.png';
    update_qr($id2, $qr_png, $mysqli);
}
