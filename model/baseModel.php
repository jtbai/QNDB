<?php

class baseModel{
    protected $DAL; //Model's DAL
    protected $Property; //Model's properties
    protected $FieldType;



    public function __get($Var){

        if (isset($this->DAL[$Var])) {
            return $this->DAL[$Var];
        }elseif(isset($this->Property)){
            return $this->Property[$Var];
        }
        else {
            trigger_error($GLOBALS['UNDEFINED_VAR'].": `".$Var."`");
        }
    }

    public function __set($Var,$Value){

        if (isset($this->DAL[$Var])) {
            $this->DAL[$Var] = $Value;
        }elseif(isset($this->Property)){
            $this->Property[$Var] = $Value;
        } else {
            trigger_error($GLOBALS['UNDEFINED_VAR'].": `".$Var."`");
        }

    }

    public function get_DAL_Fields(){
        return array_keys($this->DAL);
    }

    public function get_Property_Fields(){
        return array_keys($this->Property);
    }

    public function get_DAL_FieldType(){
        return ($this->FieldType);
    }


}