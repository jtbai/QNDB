<link rel="STYLESHEET" type="text/css" href="style.css">
<link rel="STYLESHEET" type="text/css" href="horaire.css">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><?PHP



//include de cookie et de fonctions
include('func_info.php');
include('func_horaire.php');
include('func_niveau.php');
include('func_plan.php');
include('func_session.php');
include('func_date.php');
include('func_periode.php');
include('func_employe.php');
include('func_paye.php');
include('rnord/mysql_class.php');
include('class_html.php');
//
include_once('helper/ErrorMsg.php');
include_once('helper/DataFunction.php');

//Inclusion of MVC model
include_once('controller/family_controller.php');
include_once('controller/household_controller.php');

include_once('model/baseModel.php');
include_once('model/family.php');
include_once('model/course.php');
include_once('model/period.php');
include_once('model/pool.php');
include_once('model/level.php');


include_once('helper/DAL/baseDAL.php');
include_once('helper/DAL/family_DAL.php');
include_once('helper/DAL/course_DAL.php');
include_once('helper/DAL/period_DAL.php');
include_once('helper/DAL/pool_DAL.php');
include_once('helper/DAL/level_DAL.php');


//print_r($_REQUEST);


include_once('route.php');





?>