<?php

class family_DAL extends baseDAL{

    public function __construct(){
        

    }

    function search_by_id($ID){
        $myFamily = new family();
        $this->PushArrayIntoInfo("Family",$this->get_data_byID($ID,'family'),$myFamily);
        return $myFamily;
    }

    function generate($Arg){
        $myFamily = new family();
        $this->PushArrayIntoInfo('family',$Arg,$myFamily);
        return $myFamily;
    }

    function save($family){
        $this->base_save("family",$family);
    }

}

?>