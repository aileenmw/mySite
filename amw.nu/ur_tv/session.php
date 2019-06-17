<?php

session_start();


// if username > $_SESSION['login_status'] = loged_in  

if ($_SESSION['username']) {
    $_SESSION['login_status'] = 'logged_in';
} 