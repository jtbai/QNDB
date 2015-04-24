<?PHP

class level extends baseModel{

    public function init(){
        $this->Property = array(
            'IDNiveau'=>0,
            'Niveau'=>"",
            'Code'=>"",
            'Active'=>0,
            'Objectif'=>'',
            'Rank'=>0

            );

    }


    public function __construct($Args=NULL){
        $this->init();
    }


}