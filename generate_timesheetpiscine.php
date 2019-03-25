<?PHP
// CH?KER LE COMPORTEMENT QU'ON VEUT DONNER
// LES P?RIODES ? venir pour la prochaine semaine?
// Ou bin celle au d?but de la session???



if(isset($_POST['FORMIDPiscine'])){

	if(!isset($_POST['MultiVar_From5']))
		$Semaine = get_last_sunday();
	else
		$Semaine = get_last_sunday(0,mktime(0,0,0,$_POST['MultiVar_From4'],$_POST['MultiVar_From5'],$_POST['MultiVar_From3']));

    $sql_semaine_statement_for_dls = generate_sql_extended_semaine_query($Semaine);
	apply_multiplicateur(array('Semaine1'=>$Semaine,'Semaine2'=>$Semaine));
	$VJour = array('0'=>'0','1'=>0,'2'=>0,'3'=>0,'4'=>0,'5'=>0,'6'=>0);
    $Req ="SELECT IDPiscine, IDEmploye, ressource.Multiplicateur , Role, sum((End-Start)/3600) as Duree, Jour
	FROM 
	ressource JOIN periode
	ON ressource.IDPeriode=periode.IDPeriode 
	WHERE ".$sql_semaine_statement_for_dls." AND IDPiscine = ".$_POST['FORMIDPiscine']." AND IDEmploye<>0
	GROUP BY Jour, IDPiscine, Salaire, IDEmploye, Role
	ORDER BY  IDEmploye ASC,  Role ASC, Salaire ASC, IDPiscine ASC, Semaine ASC,  Jour ASC";
	//ok now this the real shit, premi?re boucle pour les diff?rentes piscines
    $SQL->SELECT($Req);
	$TimeSheet = array();
	$OldIDEmploye="";
	$OldRole="";
	$OldSalaire="";
	//cr?ation du vecteur de timesheet
	while($Rep = $SQL->FetchArray()){
		if($OldIDEmploye<>$Rep['IDEmploye'] || $OldRole <> $Rep['Role']){
			$TimeSheet[$Rep['IDEmploye']][$Rep['Role']]= $VJour;
			$OldIDEmploye=$Rep['IDEmploye'];
			$OldRole=$Rep['Role'];
		}
		$TimeSheet[$Rep['IDEmploye']][$Rep['Role']][$Rep['Jour']] = round($Rep['Duree'],2);
	}
	$PInfo = get_info('piscine',$_POST['FORMIDPiscine']);
	$MainOutput->OpenTable('300');
	$MainOutput->OpenRow();
	$Time = get_end_dates(0,$Semaine);
	$MainOutput->OpenCol('',4); // Zone Vide en haut
	$MainOutput->AddOutput('<div align=center>',0,0);
	$MainOutput->AddTexte('Feuille de temps du '.$Time['Start'].' au '.$Time['End'],'Titre');
	$MainOutput->AddOutput('</div>',0,0);
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('350',7,'top','b');
	$MainOutput->AddTexte('<div align=center>'.$PInfo['Nom'].'</div>','Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('20'); // Zone IDEmploye
	$MainOutput->AddTexte('ID','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('75'); // Zone Nom
	$MainOutput->AddTexte('Nom','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('75'); // Zone Prenom
	$MainOutput->AddTexte('Prenom','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('25'); // Zone Prenom
	$MainOutput->AddTexte('Role','Titre');
	$MainOutput->CloseCol();
	$DList = get_day_list("court");
	foreach($DList as $k=>$v){
		if($k==0)
			$MainOutput->OpenCol('25',1,'top','l');
		else
			$MainOutput->OpenCol('25');
		$MainOutput->AddTexte('<div align=center>'.$v.'</div>','Titre');
		$MainOutput->CloseCol();
	}	
	$MainOutput->OpenCol('30',1,'top','b'); // 
	$MainOutput->AddTexte('Total','Titre');
	$MainOutput->CloseCol();
	$MainOutput->OpenCol('100',1,'top','b'); // 
	$MainOutput->AddTexte('<img src=carlos width=100 height=1>Ajt','Titre');
	$MainOutput->CloseCol();
	$c = "two";
	foreach($TimeSheet as $IDEmploye =>$v1){
		$InfoE = get_info('employe',$IDEmploye);
		foreach($v1 as $Role => $v2){
			if($c=="two")
				$c="one";
			else
				$c="two";
			$MainOutput->OpenRow('',$c);
			$MainOutput->OpenCol('20',1,'top','bl'); // Zone IDEmploye
			$MainOutput->AddTexte($IDEmploye);
			$MainOutput->CloseCol();
			$MainOutput->OpenCol('60',1,'top',$c); // Zone Nom
			$MainOutput->AddTexte($InfoE['Nom']);
			$MainOutput->CloseCol();
			$MainOutput->OpenCol('60',1,'top',$c); // Zone Prenom
			$MainOutput->AddTexte($InfoE['Prenom']);
			$MainOutput->CloseCol();
			$MainOutput->OpenCol('25',1,'top',$c); // Zone Prenom
			$MainOutput->AddTexte($Role);
			$MainOutput->CloseCol();
			$Total =0;			
			foreach($TimeSheet[$IDEmploye][$Role] as $v){
				$MainOutput->OpenCol('25',1,'top',$c);
				if($v==0)
					$v="&nbsp;";
				$MainOutput->AddTexte($v);
				$MainOutput->CloseCol();
			}
			$STotal = array_sum($TimeSheet[$IDEmploye][$Role]);
			$Total = $Total + $STotal;
		$MainOutput->OpenCol(30,1,'top','b');
		$MainOutput->AddTexte($Total);
		$MainOutput->CloseCol();
		$MainOutput->OpenCol(100,1,'top','b');
		$MainOutput->AddTexte("&nbsp;");
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		}

	}
		
	for($k=0;$k<5;$k++){
	
		if($c=="two")
			$c="one";
		else
			$c="two";
		$MainOutput->OpenRow();
		for($i=0;$i<13;$i++){
			$MainOutput->OpenCol('','','',$c);
			$MainOutput->AddTexte('<img src=carlos.gif width=1 height=20>');
		}
		$MainOutput->CloseRow();
	}
	$MainOutput->CloseTable();




}else{
	$MainOutput->AddForm('Générer la feuille de temps piscine');
	$MainOutput->Inputhidden_env('Section','Generate_TimesheetPiscine');
	$MainOutput->Inputhidden_env('ToPrint','TRUE');
	$Req = "SELECT IDPiscine, Nom FROM piscine WHERE Active ORDER BY Nom ASC";
	$MainOutput->inputselect('IDPiscine',$Req,'','Piscine');
	$MainOutput->inputtime('From','Finissant',time(),array('Time'=>FALSE,'Date'=>TRUE));
	$MainOutput->formsubmit('Générer');
}
echo $MainOutput->Send(1);
?>