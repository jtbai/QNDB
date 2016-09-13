<?PHP

class period_DAL extends baseDAL{

    public function __construct(){

        $this->DAL_Field = array(
            'IDPeriode',
            'IDPiscine',
            'IDSession',
            'Jour',
            'Start',
            'End',
            'Semaine',
            'IDPlan'
        );
        $this->DAL_FieldType = array(
            'IDPeriode'=>'Integer',
            'IDPiscine'=>'Integer',
            'IDSession'=>'Integer',
            'Jour'=>'Integer',
            'Start'=>'Integer',
            'End'=>'Integer',
            'Semaine'=>'Integer',
            'IDPlan','Integer'
        );
    }

    function search_by_id($ID){
        $myPeriod = new period();
        $this->PushArrayIntoInfo("Period",$this->get_data_byID($ID,'periode'),$myPeriod);
        return $myPeriod;
    }

    function generate($Arg){
        $myPeriod = new period();
        $this->PushArrayIntoInfo('Period',$Arg,$myPeriod);
        return $myPeriod;
    }

    function save($Model){
        $this->base_save("Periode",$Model);
    }

}