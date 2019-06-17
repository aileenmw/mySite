<?php

class UniversalConnect implements IConnectInfo {

    private static $server = IConnectInfo::CONN_HOST;
    private static $currentDB = IConnectInfo::CONN_DB;
    private static $user = IConnectInfo::CONN_USER;
    private static $pass = IConnectInfo::CONN_PASS;
    private static $port = IConnectInfo::CONN_PORT;
    private static $charset = IConnectInfo::MYSQL_CHARSET;
    private static $mysqli;

    public static function doConnect() {

        if (null == self::$mysqli) {
            self::$mysqli = new mysqli(self::$server, self::$user, self::$pass, self::$currentDB, self::$port);
            if (self::$mysqli->set_charset(self::$charset)) {
                self::$mysqli->character_set_name();
            } elseif (self::$mysqli->connect_errno > 0) {

                throw new CustomException("Failed to connect to MySQL: (" . self::$mysqli->connect_errno . ") "
                . self::$mysqli->connect_error);
            }
        }
        return self::$mysqli;
    }

}
