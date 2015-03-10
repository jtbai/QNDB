<?PHP

class period extends baseModel{

    public function init(){
        $this->Property = array(
            'IDPeriode'=>0,
            'IDPiscine'=>0,
            'IDSession'=>0,
            'Jour'=>0,
            'Start'=>0,
            'End'=>0,
            'Semaine'=>0,
            'IDPlan'=>0
            #'Season' => New season,
           # 'Piscine' =>New pool
        );

    }

    public function __construct($Args=NULL){
        $this->init();
    }


}