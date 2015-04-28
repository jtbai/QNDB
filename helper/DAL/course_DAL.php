<?PHP

class course_DAL extends baseDAL{

    public $myCourse;

    public function __construct(){

        $myCourse = new course;
        $this->DAL_Field = array(
            'IDCours',
            'IDPeriode',
            'IDNiveau',
            'Multiplicateur'
            
        );
        $this->DAL_FieldType = array(
            'IDCours'=>'Integer',
            'IDPeriode'=>'Integer',
            'IDNiveau'=>'Integer',
               'Multiplicateur'=>'Double'
        );
    }

    function search_by_id($ID){
        $this->myCourse = new course();
        $this->PushArrayIntoInfo("Course",$this->get_data_byID($ID,'cours'),$this->myCourse);
        return $this->myCourse;
    }

    function generate($Arg){
        $this->myCourse = new course();
        $this->PushArrayIntoInfo('Course',$Arg,$this->myCourse);
        return $this->myCourse;
    }

    function save($Model){
        $this->myCourse = $Model;
        $this->base_save("Cours",$Model);
    }

}

?>

