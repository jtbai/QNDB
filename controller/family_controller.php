<?php
class family_controller{


    public function INDEX($Arg=NULL){

        $myDAL = new family_DAL();
        if(is_null($Arg)) {
            $families = $myDAL->get_list();
        }else{
            $families = $myDAL->get_list($Arg);
        }

        include_once("view/family/list_family.php");
    }

    public function EDIT($Arg=NULL){

        if(is_numeric($Arg)){
            $myDAL =  new family_DAL();
            $family = $myDAL->search_by_id($Arg);
            include_once("view/family/create_family_form.php");
        }else{
            trigger_error($GLOBALS['$INVALID_ARGUMENT']);
        }

    }

    public function CREATE(){
        include_once("view/family/create_family_form.php");
    }


    public function POST($Arg){
        $myDAL =  new family_DAL();
        $family = $myDAL->generate($Arg);
        $myDAL->save($family);

        $this->INDEX();
    }


    public function PUT($Arg){
        $myDAL =  new family_DAL();
        $family = $myDAL->generate($Arg);
        $myDAL->save($family);
        $this->INDEX();
    }


}

?>