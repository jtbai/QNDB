<?php

class household_controller{

    public function GET($Arg=NULL){

        if(is_null($Arg)){
            include_once('view/household/find_course.php');
        }else{
            trigger_error($GLOBALS['$INVALID_ARGUMENT']);
        }

    }

    public function POST($Arg){

        if(isset($Arg['IDCours'])){
           #include_once('view/household/create_household_form.php');
            $family = new family();
            $course_DAL = new course_DAL();
            $period_DAL = new period_DAL();
            $course = $course_DAL->search_by_id($Arg['IDCours']);
            $course->period = $period_DAL->search_by_id($course->IDPeriode);
            print_r($course->period);
        }else{
            trigger_error($GLOBALS['$INVALID_ARGUMENT']);
        }

    }


}