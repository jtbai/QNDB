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
            $pool_DAL = new pool_DAL();
            $level_DAL = new level_DAL();
            $course = $course_DAL->search_by_id($Arg['IDCours']);
            $course->Period = $period_DAL->search_by_id($course->IDPeriode);
            $course->Period->Pool = $pool_DAL->search_by_id($course->Period->IDPiscine);
            $course->Level = $level_DAL->search_by_id($course->IDNiveau);

            include_once("view/household/create_household_form.php");
        }else{
            trigger_error($GLOBALS['$INVALID_ARGUMENT']);
        }

    }


}