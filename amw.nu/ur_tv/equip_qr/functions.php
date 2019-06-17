<?php

function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function getGearById($id, $mysqli) {
    $sql = "SELECT `name`,`available_since`,`price`,`cat`,`status` FROM `tv2_equipment` WHERE `id`=$id";
    $data = $mysqli->query($sql);
    return $data;
}

function getGearByCat($cat_id, $mysqli) {
    $sql = "SELECT `id`,`name`,`available_since`,`price`,`status` FROM `tv2_equipment` WHERE `cat`=$cat_id";
    $data = $mysqli->query($sql);
    return $data;
}

function getAvailableGearByCat($cat, $mysqli) {
    if (is_int($cat)) {
        $cat = 'cat=' . $cat;
    }
    $sql = "SELECT tv2_equipment.`id` as equip_id,`name`, `initials`,`price`
            FROM `tv2_equipment` 
            LEFT JOIN tv2_eqip_loan ON tv2_equipment.id = tv2_eqip_loan.eqip_id
            WHERE tv2_equipment.id = tv2_eqip_loan.eqip_id IS NULL AND $cat";
    $data = $mysqli->query($sql);
    return $data;
}

function getGearByAproveStatus($aprStautus, $mysqli) {
    $sql = "SELECT tv2_eqip_loan.`id` as loan_id, `eqip_id`, `name` ,`initials`,`aproval_status` 
            FROM `tv2_eqip_loan`
            INNER JOIN tv2_equipment ON tv2_eqip_loan.eqip_id = tv2_equipment.id
            WHERE `aproval_status`= $aprStautus";
    $data = $mysqli->query($sql);
    return $data;
}

function requestLoan($eq_id, $init, $mysqli) {
    $sql = "INSERT INTO `tv2_eqip_loan`( `eqip_id`, `initials`) VALUES ($eq_id, '$init')";
    if ($data = $mysqli->query($sql)) {
        return $succes = 1;
    } else {
        return $succes = 0;
    }
}

function loan($eq_id, $init, $mysqli) {
    $sql = "INSERT INTO `tv2_eqip_loan`( `eqip_id`, `initials`,`aproval_status`) VALUES ($eq_id, '$init', 1)";
    if ($data = $mysqli->query($sql)) {
        return $succes = 1;
    } else {
        return $succes = 0;
    }
}

function aproveLoan() {
    
}

function getCats($mysqli) {
    $sql = "SELECT `id`, `name`  FROM `tv2_equip_cat`";
    $data = $mysqli->query($sql);
    return $data;
}

function checkAvail($id, $mysqli) {
    $sql = "SELECT `initials`, `start`, `end`, `aproval_status`, tv2_equipment.`id` as equip_id,`name` 
            FROM `tv2_eqip_loan` 
            INNER JOIN tv2_equipment ON tv2_eqip_loan.eqip_id = tv2_equipment.id
            WHERE `eqip_id`=$id";

    $data = $mysqli->query($sql);
    if (mysqli_num_rows($data) > 0) {
        $obj = $data->fetch_object();

        if ($obj->aproval_status == 1) {
            $return = 'Emnet er udlånt';
        } elseif ($obj->status == 0) {
            $return = 'Emnet er reserveret';
        }
    } elseif (mysqli_num_rows($data) == 0) {
        $sql_check_id = "SELECT `id` FROM `tv2_equipment` WHERE `id`=$id";
        $data_check_id = $mysqli->query($sql_check_id);
        if (mysqli_num_rows($data_check_id) == 0) {
            $return = 'Emnet findes ikke';
        } else {
            $return = 1;
        }
    }
    return $return;
}

function findBorrower($gear, $user_ini, $mysqli) {
    $sql = "SELECT tv2_user.username as user, tv2_user.`initials` as 'user_ini',`start`,`adm_id`,`aproval_status`
            FROM `tv2_eqip_loan` 
            INNER JOIN tv2_user ON tv2_eqip_loan.initials = tv2_user.initials 
            WHERE `eqip_id`=$gear";
    $data = $mysqli->query($sql);
    if ((mysqli_num_rows($data)) > 0) {
        $obj = $data->fetch_object();
        if ($obj->aproval_status == 1) {
            if ($obj->user_ini == $user_ini) {
                $return = 'Du har allerede lånt dette udstyr';
            } else {
                $return = $obj->user_ini . ' har lånt dette udstyr';
            }
        } elseif ($obj->aproval_status == 0) {
            if ($obj->user_ini == $user_ini) {
                $return = 'Du har allerede reserveret dette udstyr';
            } else {
                $return = $obj->user_ini . ' har reserveret dette udstyr';
            }
        }
    } elseif (mysqli_num_rows($data) == 0) {
        $return = 'Udstyret lader til at være ledigt eller ikke-eksisterende';
    }
    return $return;
}

function getLoansByIni($ini, $mysqli) {
    $sql = "SELECT tv2_eqip_loan.`id` as loan_id, tv2_equipment.id as equip_id, `name`, `eqip_id`, `start`, `end`, `aproval_status`, `adm_id` 
           FROM `tv2_eqip_loan`
           INNER JOIN tv2_equipment ON tv2_eqip_loan.eqip_id = tv2_equipment.id
           WHERE tv2_eqip_loan.initials = '$ini' AND `aproval_status` = 1";
    $data = $mysqli->query($sql);
    return $data;
}

function getLoanerIni($mysqli) {
    $sql = "SELECT `initials` FROM `tv2_user` WHERE `is_loaning`=1";
    $data = $mysqli->query($sql);
    $obj = $data->fetch_object();
    if ($obj->initials) {
        $ini = $obj->initials;
    } else {
        $ini = '';
    }
    return $ini;
}

function setLoaner($ini, $mysqli) {
    $sql = "UPDATE `tv2_user` SET `is_loaning`= 1 WHERE `initials` = '$ini'";
    if ($mysqli->query($sql)) {
        $succes = $ini . ' låner udstyr lige nu';
    } else {
        $succes = 'Noget gik galt';
    }
    return $succes;
}

function checkOut($mysqli) {
    $sql = "UPDATE `tv2_user` SET `is_loaning`= 0";
    $mysqli->query($sql);
}

function insertEx($id, $ini, $mysqli) {
  echo  $sql = "INSERT INTO `tv2_ex_loans`( `eqip_id`, `user_ini`) VALUES ($id, '$ini')";
    $mysqli->query($sql);
}
