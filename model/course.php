<?php
class course extends baseModel{



    public function init(){

        $this->Property = array(
            'Niveau'=>'',
            'Periode'=>''
        );
//
        $this->DAL = array(
            'IDCours'=>0,
            'IDPeriode'=>'',
            'IDNiveau'=>''
        );
        $this->FieldType = array(
            'IDCours'=>'Integer',
            'IDPeriode'=>'Integer',
            'IDNiveau'=>'Integer'
        );

    }

    public function __construct($Args=NULL){

        $this->init();
        $this->SQL = new SqlClass;
        if(!is_null($Args)){
            if(is_numeric($Args)){
                #Arg is ID...
                $this->DAL['IDCours'] = $Args;
                $Req = "SELECT * FROM cours WHERE IDCours=".$Args;
                $this->SQL->Select($Req);
                $this->PushArrayIntoInfo("cours",$this->SQL->FetchAssoc(),$this->DAL);
            }elseif(is_array($Args)){
                if(isset($Args['IDCours'])){
                    $this->DAL['IDCours'] = $Args['IDCours'];
                }
                $this->PushArrayIntoInfo("Course",$Args,$this->DAL);
            }

        }
        $this->SQL->CloseConnection();
    }





}
