<?PHP
if(isset($_COOKIE['Status']) AND $_COOKIE['Status']=="Bureau"){
	
	Switch($Section){
	
		CASE "Piscine":{
			include('display_piscine.php');
		BREAK;
		}
                
                CASE "Employe_Horshift":{
                       include('display_employe_horshift.php');
                BREAK;
                }
                
		
		CASE "FormPiscine";{
			include('form_piscine.php');
		BREAK;
		}

		CASE "Remplacement";{
			include('form_remplacement.php');
		BREAK;
		}
		
		CASE "BatchPlan";{
			include('form_batchplan.php');
		BREAK;
		}
		
		CASE "Unlinked";{
			include('check_nonlinked.php');
		BREAK;
		}
		
		CASE "Inspect_Plan";{
			include('inspect_plan.php');
		BREAK;
		}

		CASE "Calcul_Ferie";{
			include('generate_ferie.php');
		BREAK;
		}
		
		CASE "Missing_Monit";{
			include('display_missing_monit.php');
		BREAK;
		}

		
		CASE "ModifieCours";{
			include('form_moniteurcours.php');
		BREAK;
		}
		
		CASE "Modifie_Periode";{
			include('form_modifie_periode.php');
		BREAK;
		}
		
		CASE "Parse_Responsable";{
			include('parse_responsable.php');
		BREAK;
		}
		
			
		CASE "Form_Ajustement";{
			include('form_ajustement.php');
		BREAK;
		}
	
		CASE "Add_Qualif";{
			include('form_qualif_employe.php');
		BREAK;
		}
		
		
		CASE "Niveau";{
			include('display_niveau.php');
		BREAK;
		}
		
		CASE "Generate_TimesheetPiscine";{
			include('generate_timesheetpiscine.php');
		BREAK;
		}
	
		CASE "FormNiveau";{
			include('form_niveau.php');
		BREAK;
		}
		
		CASE "Generate_Timesheet";{
			include('generate_timesheet.php');
		BREAK;
		}
		
		
		CASE "Inscripteur";{
			include('display_inscripteur.php');
		BREAK;
		}
		
		CASE "Display_Timesheet";{
			include('display_timesheet.php');
		BREAK;
		}
	
		CASE "Cours";{
			include('display_cours.php');
		BREAK;
		}
	
		CASE "FormCours";{
			include('form_cours.php');
		BREAK;
		}
	
		CASE "FormCours2";{
			include('form_cours2.php');
		BREAK;
		}
	
		CASE "Batch_Affect";{
			include('form_batch_affect.php');
		BREAK;
		}

		CASE "Batch_Remplace";{
			include('form_batch_remplace.php');
		BREAK;
		}
	
		
		CASE "Session";{
			include('display_session.php');
		BREAK;
		}
	
		CASE "FormSession":{
			include('form_session.php');
		BREAK;
		}
			
		CASE "Periode":{
			include('display_periode.php');
		BREAK;
		}
		
		CASE "FormPeriode":{
			include('form_periode.php');
		BREAK;
		}
		
		CASE "FormModifPeriode":{
			include('form_modif_periode.php');
		BREAK;
		}
		
		CASE "FormEmploye":{
			include('form_employe.php');
		BREAK;
		}
	
		CASE "EmployeList":{
			include('employe_list.php');
		BREAK;
		}
		
		CASE "Test":{
			include('test.php');
		BREAK;
		}
		
		CASE "Message":{
			include('display_message.php');
		BREAK;
		}
		
		CASE "Form_Message":{
			include('form_message.php');
		BREAK;
		}
	}
}else{
	Switch($Section){
		CASE "Mon_Horaire":{
			include('staff_horaire.php');
		BREAK;
		}
		
		CASE "Accueil":{
			if(isset($_COOKIE['IDEmploye']))
				include('staff_message.php');
			else	
				include('form_login.php');
		BREAK;
		}
	
	
		CASE "Mes_Info":{
			include('staff_info.php');
		BREAK;
		}
		
		CASE "Messages":{
			include('staff_message.php');
		BREAK;
		}
		
	}
	

}
?>