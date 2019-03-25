<?PHP
if(isset($Pinfo)){
	$SQLW = new sqlclass;
	$VJour = array('0'=>'0','1'=>0,'2'=>0,'3'=>0,'4'=>0,'5'=>0,'6'=>0,'7'=>0,'8'=>0,'9'=>0,'10'=>0,'11'=>0,'12'=>0,'13'=>0);
	$VPiscine = array();
	$Req = "select Distinct piscine.IDPiscine FROM piscine JOIN periode On piscine.IDPiscine = periode.IDPiscine WHERE IDSession=".$_ACTIVE['Session'];
	$SQL->SELECT($Req);


	apply_multiplicateur($Pinfo);

	while($Rep = $SQL->FetchArray())
		$VPiscine[$Rep[0]] = $VJour;

	$target_week_1 = $Pinfo['Semaine1'];
	$target_week_2 = $Pinfo['Semaine2'];
	$week_array = array($target_week_1, $target_week_2);

	$sql_statement_week_1 = generate_sql_extended_semaine_query($target_week_1);
	$sql_statement_week_2 = generate_sql_extended_semaine_query($target_week_2);
	$searched_week_reverse_index = generate_reverse_index_for_semaine_extended_query($week_array);


	$Req ="SELECT IDPiscine, IDEmploye, Role, sum((End-Start)/3600) as Duree, Salaire, Jour, Semaine, Multiplicateur
	FROM 
	ressource JOIN periode
	ON ressource.IDPeriode=periode.IDPeriode
	WHERE (".$sql_statement_week_1." or ".$sql_statement_week_2.") AND IDEmploye<>0 AND periode.IDSession = ".$_ACTIVE['Session']."
	GROUP BY Jour, Semaine, IDPiscine, Salaire, IDEmploye, Role
	ORDER BY  IDEmploye ASC,  Role ASC, Salaire ASC, IDPiscine ASC, Semaine ASC,  Jour ASC";

	//ok now this the real shit, premi?re boucle pour les diff?rentes piscines
	$SQL->SELECT($Req);
	$TimeSheet = array();
	$OldIDEmploye="";
	$OldRole="";
	$OldSalaire="";
	$OldIDPiscine="";
	//cr?ation du vecteur de timesheet
	while($Rep = $SQL->FetchArray()){

		if($OldIDEmploye<>$Rep['IDEmploye'] || $OldSalaire<>$Rep['Salaire'] || $OldRole <> $Rep['Role']){

			if($Rep['Salaire']==0){
				$Info = get_info('employe',$Rep['IDEmploye']);
				$SalaireReel = $Info["Salaire".$Rep['Role']];
			}else{
				$SalaireReel = $Rep['Salaire'];
			}
			$TimeSheet[$Rep['IDEmploye']][$Rep['Role']][$SalaireReel] = $VPiscine;
			$OldIDEmploye=$Rep['IDEmploye'];
			$OldRole=$Rep['Role'];
			$OldSalaire=$Rep['Salaire'];
		}
			$JourR = $Rep['Jour'];

		if($searched_week_reverse_index[$Rep['Semaine']]==$Pinfo['Semaine2']){
			$Rep['Jour'] = $Rep['Jour']+7;
		}


		if($Rep['Duree']<1){
			//checker si le moniteur travail d?j? cette journ?e la

			$ReqW = "SELECT sum((end-start)/3600) as V FROM periode JOIN ressource on periode.IDPeriode=ressource.IDPeriode WHERE Semaine=".$Rep['Semaine']." AND Jour=".$JourR." AND IDEmploye = ".$Rep['IDEmploye']." AND IDPiscine=".$Rep['IDPiscine'];
			$SQLW->SELECT($ReqW);
			$RepW = $SQLW->FetchArray();
			if($RepW['V']<1)
				$Rep['Duree']=1;
		}
		$TimeSheet[$Rep['IDEmploye']][$Rep['Role']][$SalaireReel]['Ajustement']=0;
		$TimeSheet[$Rep['IDEmploye']][$Rep['Role']][$SalaireReel]['Heures']=1;

		$TimeSheet[$Rep['IDEmploye']][$Rep['Role']][$SalaireReel][$Rep['IDPiscine']][$Rep['Jour']] = round($Rep['Duree']*$Rep['Multiplicateur'],2);

	}


	$Couple="";
	foreach($TimeSheet as $k1=>$v1){ //pour chaque employ?
		foreach($v1 as $k2=>$v2){ //pour chaque role
			foreach($v2 as $k3=>$v3){ // pour chaque salaire

				foreach($v3 as $k4=>$v4){ //pour chaque piscine
					if(is_array($v4) AND array_sum($v4)<>0){
						$Couple .= ",(".$Pinfo['IDPaye'].",".$k1.",'".$k2."',".$k3.",".$k4.",".$v4[0].",".$v4[1].",".$v4[2].",".$v4[3].",".$v4[4].",".$v4[5].",".$v4[6].",".$v4[7].",".$v4[8].",".$v4[9].",".$v4[10].",".$v4[11].",".$v4[12].",".$v4[13].")";
					}
				}
			}
		}
	}
	$UberReq = "INSERT INTO timesheet(`IDPaye`,`IDEmploye`,`Role`,`Salaire`,`IDPiscine`,`0`,`1`,`2`,`3`,`4`,`5`,`6`,`7`,`8`,`9`,`10`,`11`,`12`,`13`) VALUES ".substr($Couple,1);
	$SQL->Insert($UberReq);
	$Infopaye = get_last('paye');
	$_GET['FORMIDPaye'] = $Infopaye['IDPaye'];
	$Section = "Display_Timesheet";
}else{
	$MainOutput->addform('Ajouter une période de paye');
	$MainOutput->inputhidden_env('Action','Paye');
	$MainOutput->inputtime('Finissant','Paye finissant le','0',array('Time'=>FALSE,'Date'=>TRUE));
	$SQL = new sqlclass;
	$Req = "SELECT No FROM paye ORDER BY IDPaye DESC LIMIT 0,1";
	$SQL->Select($Req);
	$Rep = $SQL->FetchArray();
	if($Rep[0]<>26){
		$No = $Rep[0]+1;
	}else{
		$No = 1;
	}
	$MainOutput->inputtext('No','Numéro de paye',1,$No);
	$MainOutput->formsubmit('Ajouter');
	echo $MainOutput->send(1);
}

?> 


