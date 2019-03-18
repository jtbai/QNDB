<?PHP
if(isset($_COOKIE['Status']) AND $_COOKIE['Status']=="Bureau"){
	Switch($Action){
	
		CASE "Piscine":{
			include('action_case_piscine.php');
		BREAK;
		}

		CASE "Remplacement":{
			include('action_case_remplacement.php');
		BREAK;
		}
		
		CASE "Sync_Salaire":{
			include('action_case_sync_salaire.php');
		BREAK;
		}
		
		CASE "CoursPlan":{
			include('action_case_coursplan.php');
		BREAK;
		}
		
		
		CASE "BatchPlan":{
			include('action_case_batchplan.php');
		BREAK;
		}
		
		
		CASE "UpdateSalaire":{
			overwrite_salaire($_ACTIVE['Session']);
		BREAK;
		}
		
				
		CASE "Destroy_Plan":{
			include('action_case_destroy_plan.php');
		BREAK;
		}
		
		CASE "Modifie_Cours":{
			include('action_case_modifie_cours.php');
			echo "<script language=JAVASCRIPT>
			history.back(2);
			</script>
			";
		BREAK;
		}
	
		CASE "Niveau":{
			include('action_case_niveau.php');
		BREAK;
		}
		
		CASE "Delete_Paye":{
			include('action_case_delete_paye.php');
		BREAK;
		}
		
		CASE "Ajustement":{
			include('action_case_ajustement.php');
		BREAK;
		}
	
		CASE "Batch_Affect":{
			include('action_case_batch_affect.php');
			if($_POST['Inscripteur'])
				$Section = "Inscripteur";
			else
				$Section = "Cours";
		BREAK;
		}


		CASE "Batch_Remplace":{
			include('action_case_batch_remplace.php');

				$Section = "Missing_Monit";
			$_GET['Semaine'] = $_POST['Semaine'];
		BREAK;
		}
		
	
		
		CASE "Add_Qualif":{
			include('action_case_qualif_employe.php');
		BREAK;
		}
		
		
		CASE "AddCours":{
			include('action_case_addcours.php');
			$WarnOutput->addtexte("Cours ajout?s",'warning');
		if($_POST['FORMNiveau']==46)
			$Section = "Inscripteur";
		else
			$Section = "Cours";
		BREAK;
		}
		CASE "AddCours2":{
			include('action_case_addcours2.php');
			$WarnOutput->addtexte("Cours ajout?s",'warning');
			$Section = "Cours";
		BREAK;
		}
		
		CASE "AddRessource":{
			include('action_case_addressource.php');
			$WarnOutput->addtexte("Ressource ajout?e",'warning');
			$Section = "ModifieCours";
		BREAK;
		}
		
		CASE "RemoveRessource":{	
			include('action_case_removeressource.php');
			$WarnOutput->addtexte("Ressource effac?e",'warning');
			$Section = "ModifieCours";
		BREAK;
		}
		
		CASE "Paye":{
			include('action_case_addpaye.php');
		BREAK;
		}
	
		CASE "Activate" :{
			include('action_case_activate.php');
		BREAK;
		}
		
		CASE "Desactivate":{
			include('action_case_desactivate.php');
		BREAK;
		}
		
		CASE "Session":{
			include('action_case_session.php');
		BREAK;
		}
		
		CASE "Employe":{
			include('action_case_employe.php');
		BREAK;
		}
		
		CASE "Message":{
			include('action_case_message.php');
		$_GET['Section'] = "Message";
	BREAK;
	}
		
		CASE "ModifCours":{
			include('action_case_modifiecours.php');
			//$Section = "ModifieCours";
			//$_GET['IDCours'] = $_POST['IDCours'];
			//if(isset($_POST['IDPeriode']))
			//	$_GET['IDPeriode'] = $_POST['IDPeriode'];
			//$_GET['AllSession'] = $_POST['AllSession'];
			echo "<script language=JAVASCRIPT>
				history.back(2);
			</script>
			";
			BREAK;
		}
		
		
		CASE "ModifPeriode":{
			if(WriteAccess())
				include('action_case_modifperiode.php');
			else
				$WarnOutput->addtexte("Il n'est pas possible de modifier les périodes: vous n'avec pas les droits en écriture sur cette session",'warning');
			BREAK;
		}
		
		
			
		CASE "Modifie_Periode":{
			if(WriteAccess())
				include('action_case_modifieperiode.php');
			else
				$WarnOutput->addtexte("Il n'est pas possible de modifier les périodes: vous n'avec pas les droits en écriture sur cette session",'warning');
		
			BREAK;
		}
		
		// LE DELETE PERIODE N'EST PAS FAITE ENCORE
		
		CASE "AddPeriode":{
			if(WriteAccess())
				include('action_case_addperiode.php');
			else
				$WarnOutput->addtexte("Il n'est pas possible d'ajouter de p?riode: vous n'avec pas les droits en écriture sur cette session",'warning');
		
		BREAK;
		}
		
		CASE "MoveNiveau" : {
			move_rank($_GET['IDNiveau'],$_GET['Direction']);
			$Section= $_GET['PostBack'];
			$WarnOutput->AddTexte("Rang du niveau modifi?",'warning');
		BREAK;
		}
		
		CASE "Delog":{
			setcookie('IDEmploye','',0);
			setcookie('Status','',0);
			
			?>
		<script>
		window.location = 'index.php';
		</script>
			<?PHP
		BREAK;
		BREAK;
		}
		
	}
}ELSE{
	Switch($Action){
	
		CASE "Login":{
			include('action_case_login.php');
		BREAK;
		}
	
		CASE "Delog":{
			setcookie('IDEmploye','',0);
			setcookie('Status','',0);
			
			?>
		<script>
		window.location = 'index.php';
		</script>
			<?PHP
		BREAK;
		BREAK;
		}
	
	
	
	}
	
	
	
}



if(isset($_GET['PostBack'])){
	$Section=$_GET['PostBack'];
}
?>