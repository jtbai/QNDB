<?php
include('model/baseModel.php');


class Grappe extends baseModel{

public function __construct($Args=NULL){
$this->Property = array('Raisin1'=>new Raisin());
}

    public function addRaisin($Nom,$raisin){
        $this->Property[$Nom] = $raisin;

    }

}

class Raisin extends baseModel{

public function __construct($Args=NULL){
$this->Property = array('Color'=>"Bleu",'Noyau'=>new Noyau);
}

}

class Noyau {
public $Solidite;
public function __construct($Args=NULL){
$this->Solidite = "Très dur";
}

}



$MaGrappe = new Grappe();
$monRaisin = new raisin();
$MaGrappe->addRaisin('Raisin2',$monRaisin);
$monRaisin->Color = "Rouge";
echo $MaGrappe->Raisin2->Color;
