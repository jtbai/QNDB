<?PHP
if($_POST['Update']){

	if(!isset($_POST['FORMCessation']))
		$_POST['FORMCessation']=0;
	
	if($_POST['FORMDateNaissance4']<>"" AND $_POST['FORMDateNaissance5']<>"" AND $_POST['FORMDateNaissance3']<>"")
		$Naissance = mktime(0,0,0,$_POST['FORMDateNaissance4'],$_POST['FORMDateNaissance5'],$_POST['FORMDateNaissance3']);
	else
		$Naissance=0;
	if($_POST['FORMDateEmbauche4']<>"" AND $_POST['FORMDateEmbauche5']<>"" AND $_POST['FORMDateEmbauche3']<>"")
		$Embauche = mktime(0,0,0,$_POST['FORMDateEmbauche4'],$_POST['FORMDateEmbauche5'],$_POST['FORMDateEmbauche3']);
	else
		$Embauche=0;


	$Req = 
	"UPDATE employe SET
	`Nom`=	'".addslashes($_POST['FORMNom'])."',
	`Prenom` ='".addslashes($_POST['FORMPrenom'])."', 
	`HName` = '".addslashes($_POST['FORMHName'])."',
	`NAS` =  '".$_POST['FORMNAS']."',
	`Ville` = '".addslashes($_POST['FORMVille'])."',
	`Adresse` = '".addslashes($_POST['FORMAdresse'])."',
	`Email` = '".$_POST['FORMEmail']."',
	`TelP` = '".$_POST['FORMTelP1'].$_POST['FORMTelP2'].$_POST['FORMTelP3']."',
	`TelA` = '".$_POST['FORMTelA1'].$_POST['FORMTelA2'].$_POST['FORMTelA3']."',
	`Cell` = '".$_POST['FORMCell1'].$_POST['FORMCell2'].$_POST['FORMCell3']."',
	`CodePostal` = '".$_POST['FORMCodePostal']."',
	`SalaireB` = '".$_POST['FORMSalaireB']."',
	`SalaireR` = '".$_POST['FORMSalaireR']."',
	`SalaireRE` = '".$_POST['FORMSalaireRE']."',
	`SalaireM` = '".$_POST['FORMSalaireM']."',
	`SalaireA` = '".$_POST['FORMSalaireA']."',
	`Status` = '".$_POST['FORMStatus']."',
	`Session` = '".$_POST['FORMSession']."',
	`Notes` = '".addslashes($_POST['FORMNotes'])."',
	`DateEmbauche` = '".$Embauche."',
	`DateNaissance` = 	'".$Naissance."',
	`Cessation` = 	'".$_POST['FORMCessation']."',
	`Raison` = '".addslashes($_POST['FORMRaison'])."'
	WHERE IDEmploye=".$_POST['IDEmploye'];
	$SQL->query($Req);
}ELSE{
	if($_POST['FORMIDEmploye']<>"" AND check_unique('employe','IDEmploye',addslashes($_POST['FORMIDEmploye'])))
		$WarnOutput->AddTexte('Ce numéro d\'employé est déjà attribué','warning');
	elseif(check_unique('employe','NAS',addslashes($_POST['FORMNAS'])) AND $_POST['FORMNAS']<>0)
		$WarnOutput->AddTexte('Il existe déjà un employé avec le même NAS','warning');
	else{
	
	if(!isset($_POST['FORMCessation']))
		$_POST['FORMCessation']=0;
	if($_POST['FORMIDEmploye']==""){
		$Last = get_last('employe');
		$_POST['FORMIDEmploye'] = $Last['IDEmploye']+1;
	}
	if($_POST['FORMDateNaissance4']<>"" AND $_POST['FORMDateNaissance5']<>"" AND $_POST['FORMDateNaissance3']<>"")
		$Naissance = mktime(0,0,0,$_POST['FORMDateNaissance4'],$_POST['FORMDateNaissance5'],$_POST['FORMDateNaissance3']);
	else
		$Naissance=0;
	if($_POST['FORMDateEmbauche4']<>"" AND $_POST['FORMDateEmbauche5']<>"" AND $_POST['FORMDateEmbauche3']<>"")
		$Embauche = mktime(0,0,0,$_POST['FORMDateEmbauche4'],$_POST['FORMDateEmbauche5'],$_POST['FORMDateEmbauche3']);
	else
		$Embauche=0;
	$Req = 
	"INSERT INTO employe
	(`IDEmploye`,`Nom`,`Prenom`,`HName`,`NAS`,`Ville`,`Adresse`,`Email`,`TelP`,`TelA`,`Cell`,`CodePostal`,`SalaireB`,`SalaireR`,`SalaireRE`,
	`SalaireM`,`SalaireA`,`Status`,`Session`,`Notes`,`DateEmbauche`,`DateNaissance`,`Cessation`,`Raison`) 
	VALUES (
	'".$_POST['FORMIDEmploye']."',
	'".addslashes($_POST['FORMNom'])."',
	'".addslashes($_POST['FORMPrenom'])."',
	'".addslashes($_POST['FORMHName'])."',
	'".$_POST['FORMNAS']."',
	'".addslashes($_POST['FORMVille'])."',
	'".addslashes($_POST['FORMAdresse'])."',
	'".$_POST['FORMEmail']."',
	'".$_POST['FORMTelP1'].$_POST['FORMTelP2'].$_POST['FORMTelP3']."',
	'".$_POST['FORMTelA1'].$_POST['FORMTelA2'].$_POST['FORMTelA3']."',
	'".$_POST['FORMCell1'].$_POST['FORMCell2'].$_POST['FORMCell3']."',
	'".$_POST['FORMCodePostal']."',
	'".$_POST['FORMSalaireB']."',
	'".$_POST['FORMSalaireR']."',
	'".$_POST['FORMSalaireRE']."',
	'".$_POST['FORMSalaireM']."',
	'".$_POST['FORMSalaireA']."',
	'".$_POST['FORMStatus']."',
	'".$_POST['FORMSession']."',
	'".addslashes($_POST['FORMNotes'])."',
	'".$Embauche."',
	'".$Naissance."',
	'".$_POST['FORMCessation']."',
	'".addslashes($_POST['FORMRaison'])."')";
	$SQL->insert($Req);
	}
}
	$_GET['Section']='EmployeList';
?>