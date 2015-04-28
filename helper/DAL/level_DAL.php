<?php

class level_DAL extends baseDAL{

    public function __construct(){

        $this->DAL_Field = array(
            'IDNiveau',
            'Niveau',
            'Code',
            'Active',
            'Objectif',
            'Rank'
        );
        $this->DAL_FieldType = array(
            'IDNiveau'=>'Integer',
            'Niveau'=>'String',
            'Code'=>'String',
            'Active'=>'Integer',
            'Objectif'=>'String',
            'Rank'=>'Integer'
        );
    }

    function search_by_id($ID){
        $myLevel = new level();
        $this->PushArrayIntoInfo("Niveau",$this->get_data_byID($ID,'niveau'),$myLevel);
        return $myLevel;
    }

    function generate($Arg){
        $myLevel = new level();
        $this->PushArrayIntoInfo('Level',$Arg,$myLevel);
        return $myLevel;
    }

    function save($Model){
        $this->base_save("niveau",$Model);
    }


} 