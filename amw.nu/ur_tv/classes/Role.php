<?php

class Role extends DatabaseTable {

    private $table_name = 'cms_role';
    private $role_id, $role;

    public function __construct($mysqli, $table_name) {
        parent::__construct($mysqli);
        $this->table_name = $table_name;
    }

    function adminRole($mysqli) {
        $sql = "SELECT `id`,`name`  FROM `mc_role`";
        return $result = $mysqli->query($sql);
    }

}
