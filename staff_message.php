<?PHP
$MainOutput->AddTexte("<u>"."Messages à tous"."</u>",'Titre');
$MainOutput->br();
	$Now = time();
	$Req = "SELECT * FROM message WHERE Start<=".$Now." AND End+24*60*60>=".$Now." ORDER BY IDMessage DESC"; 
	$SQL->SELECT($Req);
	$MSG = array();
	while($Rep = $SQL->FetchArray()){
		$MSG[$Rep['IDMessage']] = array('Titre'=>$Rep['Titre'],'Texte'=>$Rep['Texte'],'Start'=>$Rep['Start'],'IDEmploye'=>$Rep['IDEmploye']);
	}
	
$Month = get_month_list('long');
foreach($MSG as $v){

	$Inf = get_info('employe',$v['IDEmploye']);
	$Date = get_date($v['Start']);
	$MainOutput->AddTexte($v['Titre'],'Titre');
	$MainOutput->AddTexte(" posté le ".$Date['d']." ".$Month[intval($Date['m'])]." ".$Date['Y']);
	$MainOutput->br();
	$MainOutput->AddTexte($v['Texte'].'<br>- '.$Inf['Prenom']);
	$MainOutput->br(2);
}

echo $MainOutput->Send(1);