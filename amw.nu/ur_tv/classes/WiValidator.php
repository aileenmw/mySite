<?php

//spl_autoload_register(function ($class) {
//    require_once 'classes/' . $class . '.php';
//});
//$mysqli = UniversalConnect::doConnect();

class WiValidator {

    private $errors;

    public function __construct($mysqli) {

        $this->mysqli = $mysqli;
    }

// den er først relevant ved insert :

    function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function checkTextstring($str, $min, $max, $fieldName = 0) {
        if (empty($str)) {
            $this->errors[] = 'Please insert ' . $fieldName;
            return;
        }

        if (!preg_match("/^[a-zA-Z ]*$/", $str)) {
            $this->errors[] = 'There should only be letters in the \'' . $fieldName . '\' field';
        }
        if (strlen($str) > $max || strlen($str) < $min) {
            $this->errors[] = $fieldName . ' should consist of min ' . $min . ' and max ' . $max;
        }
    }

    public function checkEmail($email, $fieldName = 0) {
        if (empty($email)) {
            $this->errors[] = 'Please insert email';
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Email is not valid';
        }
    }

    public function checkInt($val, $fieldName = 0) {
        if (empty($val)) {
            $this->errors[] = 'Please insert ' . $fieldName;
            return;
        }

        if (!filter_var($val, FILTER_VALIDATE_INT)) {
            $this->errors[] = 'The ' . $fieldName . ' must consist of integers only';
        }
    }

    public function checkDec($val) {
        if (empty($val)) {
            $this->errors[] = 'Please fill out ' . $fieldName;
            return;
        }

        if (!filter_var($val, FILTER_VALIDATE_FLOAT)) {
            $this->errors[] = $fieldName . ' input can not be decimal';
        }
    }

    public function checkPcode($pCode, $nmbLen, $fieldName = 0) {

        if (empty($pCode)) {
            $this->errors[] = 'Please insert ' . $fieldName;
            return;
        }
//       
        if (!filter_var($pCode, FILTER_VALIDATE_INT)) {
            $this->errors[] = 'Danish postal codes consist only of integers';
            return;
        }
        if (strlen((string) $pCode) !== $nmbLen) {

            $this->errors[] = 'Danish postal codes consist of 4 numbers only';
            return;
        }
    }

    public function getErrors() {
        return $this->errors;
    }

}
