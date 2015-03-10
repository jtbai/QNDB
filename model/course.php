<?PHP

class course extends baseModel{

    public function init(){
        $this->Property = array(
            'IDCours'=>0,
            'IDPeriode'=>0,
            'IDNiveau'=>0,
            'Multiplicateur'=>0,
            'Periode'=>new period
            #'Niveau'=>new niveau
        );

    }

    public function __construct($Args=NULL){
        $this->init();
    }


}