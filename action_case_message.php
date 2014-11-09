<?PHP
if($_POST['Update']){
	$SQL = new sqlclass;
	if($_POST['FORMTitre']==""){
	$Req = "DELETE FROM message WHERE IDMessage = ".$_POST['IDMessage'];
	}else{
	$Start = mktime(0,0,0,$_POST['FORMStart4'],$_POST['FORMStart5'],$_POST['FORMStart3']);
	$End = mktime(0,0,0,$_POST['FORMEnd4'],$_POST['FORMEnd5'],$_POST['FORMEnd3']);
	$Req = "UPDATE message
	Set `Start` = ".$Start.",
	`End` = ".$End.",
	`Titre` = '".addslashes($_POST['FORMTitre'])."',
	`Texte` = '".addslashes($_POST['FORMTexte'])."',
	`IDEmploye` = ".$_POST['FORMIDEmploye']."
	WHERE IDMessage = ".$_POST['IDMessage'];
	}
	$SQL->INSERT($Req);
	$MainOutput->AddTexte('Message modifié','Warning');
}else{
	$SQL = new sqlclass;
	$Start = mktime(0,0,0,$_POST['FORMStart4'],$_POST['FORMStart5'],$_POST['FORMStart3']);
	if($_POST['FORMEnd5']==""){
		$End = $Start+7*24*60*60;
	}else{
		$End = mktime(0,0,0,$_POST['FORMEnd4'],$_POST['FORMEnd5'],$_POST['FORMEnd3']);
	}
	$Req = "INSERT INTO message(`Start`,`End`,`Titre`,`Texte`,`IDEmploye`) VALUES('".$Start."','".$End."','".addslashes($_POST['FORMTitre'])."','".addslashes($_POST['FORMTexte'])."','".$_POST['FORMIDEmploye']."')";
	$SQL->INSERT($Req);
	$MainOutput->AddTexte('Message ajouté','Warning');
}

?>