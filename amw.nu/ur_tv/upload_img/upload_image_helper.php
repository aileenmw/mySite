<?php

ini_set('display_errors', 1);

$mysqli = new mysqli('mydb8.surf-town.net', "hb37147_amw", "2Paccap2", "hb37147_wi2");

if ($mysqli->connect_errno) {
    printf("No connection: %s\n", $mysqli->connect_error);
    exit();
}

if ((count($_POST) > 0) OR ( count($_FILES) > 0)) {
    $art_id = $_POST['art_id'];
    $name = utf8_decode($_POST['name']);
    $filename = $_FILES["myimage"]["name"];
    $microtime = microtime();
    $microtime_arr = explode(' ', $microtime);
    $filename = $microtime_arr[1] . '_' . $filename;
    $img_path = '../../assets/img/' . $filename;
    $tmp_name = $_FILES["myimage"]['tmp_name'];



    if (move_uploaded_file($tmp_name, $img_path)) {

        $sql_upload = "INSERT INTO `tv2_equipment`(`img`) VALUES('$filename')";

//        if (isset($_POST['is_carousel'])) {
//            $sql = "INSERT INTO `cms_img`(`title`, `img`, `is_carousel`) VALUES('$name', '$filename', 1)";
//        } else {
//        }
//         header("location: index.php?page=confirm.php");
        $mysqli->query($sql_upload);
        echo 'Your picture has been uploaded';
//        if ($mysqli->query($sql)) {
//                header("Refresh:0");
////            $message = 'The image has been uploaded';
//            exit();
    } else {
//        $message = 'Upload image and fill out a title. ';
        echo 'Your picture has been uploaded';
    }
}