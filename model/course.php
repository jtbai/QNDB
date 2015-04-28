<?PHP

class course extends baseModel{

    public function init(){
        $this->Property = array(
            'IDCours'=>0,
            'IDPeriode'=>0,
            'IDNiveau'=>0,
            'Multiplicateur'=>0,
            'Period'=>new period,
            'Level'=>new level
        );

    }


    public function __set($Var,$Value){

        if($Var=="Period"){
            $this->Property['Period'] = $Value;
            $this->Property['IDPeriode'] = $this->Property['Period']->IDPeriode;
        }elseif($Var=="Level"){
            $this->Property['Level'] = $Value;
            $this->Property['IDNiveau'] = $this->Property['Level']->IDNiveau;
        }
        {
            parent::__set($Var,$Value);
        }

    }



    public function __construct($Args=NULL){
        $this->init();
    }


}