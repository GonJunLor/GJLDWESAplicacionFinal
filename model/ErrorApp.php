<?php
/**
* @author: Gonzalo Junquera Lorenzo
* @since: 11/01/2026
*/
class ErrorApp{

    private $Code,$Message,$File,$Line;

    public function __construct($Code,$Message,$File,$Line){
        $this->Code = $Code;
        $this->Message = $Message;
        $this->File = $File;
        $this->Line = $Line;
    }

    public function getCode() {
        return $this->Code;
    }

    public function getMessage() {
        return $this->Message;
    }

    public function getFile() {
        return $this->File;
    }

    public function getLine() {
        return $this->Line;
    }
}