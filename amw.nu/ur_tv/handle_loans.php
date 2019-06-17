<?php

$mysqli = new mysqli('mydb8.surf-town.net', "hb37147_amw", "2Paccap2", "hb37147_wi2");

if ($mysqli->connect_errno) {
    printf("No connection: %s\n", $mysqli->connect_error);
    exit();
}

$sql = "SELECT ur_tv_users.id, ur_tv_users.fname,ur_tv_users.lname, ur_tv_loans.loanTime, ur_tv_loans.id  
        FROM `ur_tv_users` 
        INNER JOIN `ur_tv_loans`  ON ur_tv_users.id = ur_tv_loans.user_id";



/*
 * What do I need?
 * 
 *- make new loans onclick : need : userid, eqipId
 *                   !! evt new row: estimated return time
 *                   -> create loan  + update equipment status
 *                      
 * -reserved : eqipId -> get loaner name + estimated return time + evt. mail
 * - not avail : show who has the eqip : eqipId -> get loaner name + estimated return time + evt. mail
 * 
 * 
 */