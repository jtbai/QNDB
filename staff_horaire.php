<?PHP
$NMonth = get_month_list();
$NDay = get_day_list('court');
$Req1 = "SELECT NoRessource as 'Role', 'Resp' as 'Niveau', Semaine as 'Semaine', Jour as 'Jour', Nom as 'Nom', Start as 'Start' FROM ressource JOIN piscine JOIN periode on ressource.IDPeriode = periode.IDPeriode AND piscine.IDPiscine = periode.IDPiscine WHERE isnull(ressource.IDCours) AND Semaine in(".get_last_sunday().",".get_next_sunday().",".get_next_sunday(1).") AND IDEmploye = ".$_COOKIE['IDEmploye'];
$Req2 = "SELECT  Role as 'Role', Code as 'Niveau', Semaine as 'Semaine', Jour as 'Jour', Nom as 'Nom', Start as 'Start' FROM ressource JOIN cours JOIN piscine JOIN periode JOIN niveau on ressource.IDCours = cours.IDCours AND niveau.IDNiveau = cours.IDNiveau AND periode.IDPiscine = piscine.IDPiscine AND cours.IDPeriode = periode.IDPeriode WHERE Semaine in(".get_last_sunday().",".get_next_sunday().",".get_next_sunday(1).") AND IDEmploye = ".$_COOKIE['IDEmploye'];


$Req = "(".$Req1.") UNION (".$Req2.") ORDER BY Semaine ASC, Jour ASC, Start ASC";
$SQL->SELECT($Req);

$Semaine = array('1'=>get_last_sunday(),'2'=>get_next_sunday(),'3'=>get_next_sunday(1));
$VDay1 = array(0=>new HTML,1=>new HTML,2=>new HTML,3=>new HTML,4=>new HTML,5=>new HTML,6=>new HTML);
$VDay2 = array(0=>new HTML,1=>new HTML,2=>new HTML,3=>new HTML,4=>new HTML,5=>new HTML,6=>new HTML);
$VDay3 = array(0=>new HTML,1=>new HTML,2=>new HTML,3=>new HTML,4=>new HTML,5=>new HTML,6=>new HTML);
$Output = array($Semaine[1]=>$VDay1,$Semaine[2]=>$VDay2,$Semaine[3]=>$VDay3);
$OldJour="";
$OldPiscine="";


while($Rep = $SQL->FetchArray()){


	if($OldJour<>$Rep['Jour'] ){
		$OldPiscine = "";
	}
	if($OldPiscine<>$Rep['Nom']){
		$Output[$Rep['Semaine']][$Rep['Jour']]->AddTexte("&nbsp;".$Rep['Nom'],'Titre');
		$Output[$Rep['Semaine']][$Rep['Jour']]->br();
		$OldJour=$Rep['Jour'];
		$OldPiscine=$Rep['Nom'];
	}
	$Output[$Rep['Semaine']][$Rep['Jour']]->AddTexte("&nbsp;&nbsp;&nbsp;- <b>".floor($Rep['Start']/3600)."h".number_format(floor(bcmod($Rep['Start'],3600)/60),0)."</b> : ".$Rep['Niveau']." (".$Rep['Role'].")");
	$Output[$Rep['Semaine']][$Rep['Jour']]->br();
}


$MainOutput->OpenTable();
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',7);
	$MainOutput->AddTexte('Mon Horaire','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->OpenRow();
$i=0;
while($i<7){
$MainOutput->OpenCol('100%');
	$MainOutput->AddTexte('<img src=carlos.gif height=1 width=125>');
$MainOutput->CloseCol();
$i++;
}

$MainOutput->CloseRow();


foreach($Output as $Semaine=>$V){
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('100%',7);
	
	$Time = get_end_dates(0,$Semaine);
		$MainOutput->AddTexte('<div align=center>'.$Time['Start'].' au '.$Time['End'].'</div>','Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	$MainOutput->OpenRow();
	
	foreach($V as $Jour => $HTML){
		$MainOutput->OpenCol();
		$Time= $Semaine+3600*24*$Jour;
		$SemD = get_date($Time);
		$MainOutput->addtexte("<div align=center>".$NDay[$Jour]." ".$SemD['d']."-".$NMonth[intval($SemD['m'])]."</div>", 'Titre');
		$MainOutput->CloseCol();
	}
	$MainOutput->CloseRow();
	$MainOutput->OpenRow();
	foreach($V as $Jour => $HTML){
		$MainOutput->OpenCol();
		$MainOutput->AddOutput($Output[$Semaine][$Jour]->Send(1),0,0);
		$MainOutput->CloseCol();
	}
	$MainOutput->CloseRow();
}
$MainOutput->CloseTable();

echo $MainOutput->Send(1);
?>