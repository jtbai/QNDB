<?php
class family_controller{


    public function INDEX($Arg=NULL){
        if(is_null($Arg)) {
            include_once("view/family/list_family.php");
        }elseif(is_string($Arg)){
            # Ajouter le filtre dans la family list
        }elseif(is_array($Arg)){
            # Ajouter LES filtes dans la family list
        }
    }

    public function GET($Arg=NULL){

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