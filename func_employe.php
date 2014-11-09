<?PHP


function get_employe_ferie($IDEmploye,$Time){
	$SQL = new sqlclass;
	$End = get_last_sunday(1,$Time);
	$Mid2 = get_last_sunday(2,$Time);
	$Mid = get_last_sunday(3,$Time);
	$Start = get_last_sunday(4,$Time);
	$Req = "SELECT IDPaye, Semaine1, Semaine2 FROM paye WHERE Semaine1 = ".$Start." OR Semaine2 = ".$Start;
	$SQL->Select($Req);
	$Rep = $SQL->FetchArray();
	$IDPaye = $Rep['IDPaye'];
if($Rep['Semaine1']==$Start){
		$Req2 = "SELECT sum((`0`+`1`+`2`+`3`+`4`+`5`+`6`+`7`+`8`+`9`+`10`+`11`+`12`+`13`+Ajustement)*Salaire) FROM timesheet where IDEmploye=".$IDEmploye." AND Heures and IDPaye=".$IDPaye." AND timesheet.IDEmploye=".$IDEmploye." GROUP BY IDEmploye";
		$SQL->SELECT($Req2);
		$Rep = $SQL->FetchArray();
		$Sum = $Rep[0];
		$Req3 = "SELECT sum((`0`+`1`+`2`+`3`+`4`+`5`+`6`+`7`+`8`+`9`+`10`+`11`+`12`+`13`+Ajustement)*Salaire) FROM timesheet JOIN paye on timesheet.IDPaye = paye.IDPaye WHERE paye.Semaine2 = ".$End." AND timesheet.IDEmploye=".$IDEmploye." AND Heures GROUP BY IDEmploye";
		$SQL->SELECT($Req3);
		$Rep = $SQL->FetchArray();		
		$Sum = $Sum+$Rep[0];

return round($Sum/20,2);
	}else{
		$Req2 = "SELECT sum((`7`+`8`+`9`+`10`+`11`+`12`+`13`+Ajustement/2)*Salaire) FROM timesheet where IDEmploye=".$IDEmploye." and IDPaye=".$IDPaye." AND timesheet.IDEmploye=".$IDEmploye." AND Heures GROUP BY IDEmploye";
		$SQL->SELECT($Req2);
		$Rep2 = $SQL->FetchArray();
		$Sum = $Rep2[0];
		$Req3 = "SELECT sum((`0`+`1`+`2`+`3`+`4`+`5`+`6`+`7`+`8`+`9`+`10`+`11`+`12`+`13`+Ajustement)*Salaire) FROM timesheet JOIN paye on timesheet.IDPaye = paye.IDPaye WHERE paye.Semaine1 = ".$Mid." AND timesheet.IDEmploye=".$IDEmploye." AND Heures GROUP BY IDEmploye";
		$SQL->SELECT($Req3);
		$Rep2 = $SQL->FetchArray();
		$Sum = $Sum+$Rep2[0];
		$Req3 = "SELECT sum((`0`+`1`+`2`+`3`+`4`+`5`+`6`+Ajustement/2)*Salaire) FROM timesheet JOIN paye on timesheet.IDPaye = paye.IDPaye WHERE paye.Semaine1 = ".$End." AND timesheet.IDEmploye=".$IDEmploye."  AND Heures GROUP BY IDEmploye";
		$SQL->SELECT($Req3);
		$Rep2 = $SQL->FetchArray();
		$Sum = $Sum+$Rep2[0];
		return round($Sum/20,2);
	}
}
function get_employe_working($IDPaye){
	$SQL = new sqlclass;
	$Req = "SELECT DISTINCT employe.IDEmploye, Nom, Prenom FROM employe RIGHT JOIN timesheet ON employe.IDEmploye = timesheet.IDEmploye WHERE IDPaye = ".$IDPaye." ORDER BY IDEmploye ASC";
	$SQL->SELECT($Req);
	$Ret = array();
	while($Rep = $SQL->FetchArray()){
		$Ret[$Rep[0]] = array('Nom'=>$Rep[1],'Prenom'=>$Rep[2]);
	}
	return $Ret;
}


?>