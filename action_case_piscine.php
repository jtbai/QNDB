<?PHP
$Tel = $_POST['FORMTel1'].$_POST['FORMTel2'].$_POST['FORMTel3'].$_POST['FORMTel4'];
if($_POST['UPDATE']){
	$Req = "Update piscine set `Nom`='".addslashes($_POST['FORMNom'])."', `Adresse`='".addslashes($_POST['FORMAdresse'])."', `Tel`='".$Tel."' WHERE IDPiscine=".$_POST['IDPiscine'];
	$SQL->UPDATE($Req);
	$WarnOutput->AddTexte('Piscine modifi�e','warning');
}else{
	if(check_unique('piscine','Nom',addslashes($_POST['FORMNom'])))
		$WarnOutput->AddTexte('Il existe d�j� une piscine avec le m�me nom','warning');
	else{
		$Req = "INSERT INTO piscine(`Nom`,`Adresse`,`Tel`) VALUES('".addslashes($_POST['FORMNom'])."','".addslashes($_POST['FORMAdresse'])."','".$Tel."')";
		$SQL->INSERT($Req);
		$WarnOutput->AddTexte('Piscine ajout�e','warning');
	}
}
$Section = "Piscine";
	?>