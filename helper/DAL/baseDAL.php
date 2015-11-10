<?php

class baseDAL{

    protected $DAL_Field;
    protected $DAL_FieldType;


    function get_data_byID($ID,$Table){
        $SQL = new sqlclass;
        $BDTable = strtolower($Table);
        $DBField = ucfirst($BDTable);

        $Req = "SELECT * FROM ".$BDTable." WHERE ID".$DBField."=".$ID;
        $SQL->Select($Req);

        if($SQL->NumRow()==1){
            return $SQL->FetchAssoc();
        }elseif($SQL->NumRow()==0){
            trigger_error($GLOBALS['NODATA']." get_data_byID - ".$Table);
            return NULL;
        }elseif($SQL->NumRow()>1){
            trigger_error($GLOBALS['TMDATA']." get_data_byID - ".$Table);
            return NULL;
        }else{
            trigger_error($GLOBALS['NOWAY']." get_data_byID - ".$Table);
            return NULL;
        }

    }


    function get_last_id($Table){
        $SQL = new sqlclass;
        $Field = "ID".ucfirst($Table);
        $Table =  strtolower($Table);

        $Req = "SELECT ".$Field." FROM `".strtolower($Table)."` ORDER BY ID".ucfirst($Table)." DESC limit 0,1";
        $SQL->Select($Req);
        $Rep = $SQL->FetchArray();
        return $Rep[0];
    }



    function StringArrayToString($VarArray,$Separator=","){
        #This will return a "Separated" string made of items in the array
        $RetString = "";
        foreach ($VarArray as $v){
            $RetString .= $RetString .$v. $Separator;
        }
        return substr($RetString,0,-1);

    }



    function PushArrayIntoInfo($Class, $Data, &$Model){

        #The Model Variable is a full object. Its expected to have a list of
        #DAL Field
        #Property Field
        #DAL Field Values
        #Propery Field Values


        $Property_List =  $Model->get_Property_Fields();

        foreach($Data as $k=>$v){

            if (in_array($k,$Property_List)){
                $Model->$k = $v;
            }else{
                trigger_error("No Such item (".$k.") in model:".$Class);
            }

        }
    }


    function base_save($Class, $Model){
        $SQL = new sqlclass;
        $ID = "ID".ucfirst($Class);

        if($Model->$ID <>0){
               $Query = $this->GenerateUpdateStatement($Class,$Model);
           }else{
               $Query = $this->GenerateInsertStatement($Class,$Model);
           }

        $SQL->Query($Query);

        #Ca serait bien que le ID s'update automatiquement...
        $Model->$ID = $this->get_last_id(ucfirst($Class));

    }

    Function GenerateUpdateStatement($Class, $Model){

        #The Model Variable is a full object. Its expected to have a list of
        #DAL Field
        #Property Field
        #DAL Field Values
        #Propery Field Values

        $TableName = strtolower($Class);
        $FieldName = ucfirst($Class);
        $IDFieldName =  'ID'.$FieldName;
        $Statement = "Update ".$TableName." SET ";

        foreach($this->DAL_Field as $k){

            $Statement .= "`".addslashes($k)."`=";

            if(strtolower($this->DAL_FieldType[$k])=="string"){
                $Statement.= "'".addslashes(nl2br($Model->$k))."', ";
            }elseif(strtolower($this->DAL_FieldType[$k])=="bool"){
                if($Model->$k){
                    $Statement.= "TRUE, ";
                }else{
                    $Statement.= "FALSE, ";
                }

            }elseif(strtolower($this->DAL_FieldType[$k])=="integer"){
                $Statement.= intval($Model->$k).", ";
            }elseif(strtolower($this->DAL_FieldType[$k])=="double"){
                $Statement.= doubleval($Model->$k).", ";
            }else{
                trigger_error($GLOBALS['UNKNOWN_DATATYPE'].": ".strtolower($this->DAL_FieldType[$k]));
            }


        }

        $Statement = substr($Statement, 0,-2)." WHERE ID".$FieldName." = ".$Model->$IDFieldName;
        return $Statement;
    }

    function GenerateInsertStatement($Class, $Model){


        #The Model Variable is a full object. Its expected to have a list of
        #DAL Field
        #Property Field
        #DAL Field Values
        #Propery Field Values



        $TableName = strtolower($Class);
        $FieldName = ucfirst($Class);

        $Statement = "INSERT INTO ".$TableName." (";

        $Field = "";
        $Values = "";

        foreach($this->DAL_Field as $k){

            $Field .= "`".addslashes($k)."`,";

            if(strtolower($this->DAL_FieldType[$k])=="string"){
                $Values.= "'".addslashes(nl2br($Model->$k))."', ";
            }elseif(strtolower($this->DAL_FieldType[$k])=="bool"){
                if($Model->$k){
                    $Values.= "TRUE, ";
                }else{
                    $Values.= "FALSE, ";
                }

            }elseif(strtolower($this->DAL_FieldType[$k])=="integer"){
                $Values.= intval($Model->$k).", ";
            }elseif(strtolower($this->DAL_FieldType[$k])=="double"){
                $Values.= doubleval($Model->$k).", ";
            }else{
                trigger_error($GLOBALS['UNKNOWN_DATATYPE'].": ".strtolower($this->DAL_FieldType[$k]));
            }

        }

        $Statement .= substr($Field, 0,-1).") VALUES(".substr($Values,0,-2).")";
        return $Statement;
    }

}

?>
