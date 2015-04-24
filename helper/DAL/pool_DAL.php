<?php

class pool_DAL extends baseDAL{

    public function __construct(){

        $this->DAL_Field = array(
            'IDPiscine',
            'Nom',
            'Tel',
            'Adresse',
            'Active'
        );
        $this->DAL_FieldType = array(
            'IDPeriode'=>'Integer',
            'Nom'=>'String',
            'Tel'=>'Integer',
            'Adresse'=>'String',
            'Active'=>'Integer'


        );
    }

    function search_by_id($ID){
        $myPool = new pool();
        $this->PushArrayIntoInfo("Piscine",$this->get_data_byID($ID,'piscine'),$myPool);
        return $myPool;
    }

    function generate($Arg){
        $myPool = new pool();
        $this->PushArrayIntoInfo('Pool',$Arg,$myPool);
        return $myPool;
    }

    function save($Model){
        $this->base_save("piscine",$Model);
    }


} 