<?php

class baseModel{

    protected $Property; //Model's properties

    public function __get($Var){

        if (isset($this->Property)){
            return $this->Property[$Var];
        }
        else {
            trigger_error($GLOBALS['UNDEFINED_VAR'].": `".$Var."`");
            return FALSE;
        }
    }

    public function __set($Var,$Value){

        if (isset($this->Property)){
            $this->Property[$Var] = $Value;
        } else {
            trigger_error($GLOBALS['UNDEFINED_VAR'].": `".$Var."`");
        }

    }


    public function get_Property_Fields(){
        return array_keys($this->Property);
    }


}