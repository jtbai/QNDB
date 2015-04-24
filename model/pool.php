<?php
class pool extends baseModel{

    public function init(){
        $this->Property = array(
            'IDPiscine'=>0,
            'Nom'=>'',
            'Tel'=>'',
            'Adresse'=>'',
            'Active'=>0,
            );
    }

    public function __construct($Args=NULL){
        $this->init();
    }

} 