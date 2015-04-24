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
            'IDPlan'=>0,
            #'Season' => New season,
            'Pool' =>New pool);




    }


    public function __set($Var,$Value){

       if($Var=="Pool"){
           $this->Property['Pool'] = $Value;
           $this->Property['IDPiscine'] = $this->Property['Pool']->IDPiscine;
       }else{
            parent::__set($Var,$Value);
       }

    }

    public function set_piscine($Pool){
        $this->Property['Piscine'] = $Piscine;

    }
    public function __construct($Args=NULL){
        $this->init();
    }


}