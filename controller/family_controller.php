<?php
class family_controller{

    public function GET($Arg=NULL){

        if(is_null($Arg)){
            $family = new family();
        }elseif(is_numeric($Arg)){
            $myDAL =  new family_DAL();
            $family = $myDAL->search_by_id($Arg);
        }else{
            trigger_error($GLOBALS['$INVALID_ARGUMENT']);
        }
        include_once("view/family/create_family_form.php");
    }


    public function POST($Arg){
        $myDAL =  new family_DAL();
        $family = $myDAL->generate($Arg);
        $myDAL->save($family);
        include_once("view/family/create_family_form.php");
    }


    public function PUT($Arg){
        $myDAL =  new family_DAL();
        $family = $myDAL->generate($Arg);
        $myDAL->save($family);
        include_once("view/family/create_family_form.php");
    }


}

?>