<?PHP
$Tel = $_POST['MultiVar_Tel1'].$_POST['MultiVar_Tel2'].$_POST['MultiVar_Tel3'].$_POST['MultiVar_Tel4'];
if($_POST['UPDATE']){
	$Req = "Update piscine set `Nom`='".addslashes($_POST['FORMNom'])."', `Adresse`='".addslashes($_POST['FORMAdresse'])."', `Tel`='".$Tel."' WHERE IDPiscine=".$_POST['IDPiscine'];
	$SQL->UPDATE($Req);
	$WarnOutput->AddTexte('Piscine modifiée','warning');
}else{
	if(check_unique('piscine','Nom',addslashes($_POST['FORMNom'])))
		$WarnOutput->AddTexte('Il existe déjà une piscine avec le même nom','warning');
	else{
		$Req = "INSERT INTO piscine(`Nom`,`Adresse`,`Tel`) VALUES('".addslashes($_POST['FORMNom'])."','".addslashes($_POST['FORMAdresse'])."','".$Tel."')";
		$SQL->INSERT($Req);
		$WarnOutput->AddTexte('Piscine ajoutée','warning');
	}
}
$Section = "Piscine";
	?>