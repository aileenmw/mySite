<?php

interface IConnectInfo {

    const CONN_HOST = 'mydb8.surf-town.net';
    const CONN_USER = 'hb37147_amw';
    const CONN_PASS = '2Paccap2';
    const CONN_DB = 'hb37147_wi2';
    const CONN_PORT = 3306;
    const MYSQL_CHARSET = 'utf8';

    public static function doConnect();
}
