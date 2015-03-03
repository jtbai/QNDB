<?PHP
if($_POST['Update']){

	if(!isset($_POST['FORMCessation']))
		$_POST['FORMCessation']=0;
	
	if($_POST['MultiVar_DateNaissance4']<>"" AND $_POST['MultiVar_DateNaissance5']<>"" AND $_POST['MultiVar_DateNaissance3']<>"")
		$DateNaissance = mktime(0,0,0,$_POST['MultiVar_DateNaissance4'],$_POST['MultiVar_DateNaissance5'],$_POST['MultiVar_DateNaissance3']);
	else
		$DateNaissance=0;
	if($_POST['MultiVar_DateEmbauche4']<>"" AND $_POST['MultiVar_DateEmbauche5']<>"" AND $_POST['MultiVar_DateEmbauche3']<>"")
		$DateEmbauche = mktime(0,0,0,$_POST['MultiVar_DateEmbauche4'],$_POST['MultiVar_DateEmbauche5'],$_POST['MultiVar_DateEmbauche3']);
	else
		$DateEmbauche=0;

	$Req = 
	"UPDATE employe SET
	`Nom`=	'".addslashes($_POST['FORMNom'])."',
	`Prenom` ='".addslashes($_POST['FORMPrenom'])."', 
	`HName` = '".addslashes($_POST['FORMHName'])."',
	`NAS` =  '".$_POST['FORMNAS']."',
	`Ville` = '".addslashes($_POST['FORMVille'])."',
	`Adresse` = '".addslashes($_POST['FORMAdresse'])."',
	`Email` = '".$_POST['FORMEmail']."',
	`TelP` = '".$_POST['MultiVar_TelP1'].$_POST['MultiVar_TelP2'].$_POST['MultiVar_TelP3']."',
	`TelA` = '".$_POST['MultiVar_TelA1'].$_POST['MultiVar_TelA2'].$_POST['MultiVar_TelA3']."',
	`Cell` = '".$_POST['MultiVar_Cell1'].$_POST['MultiVar_Cell2'].$_POST['MultiVar_Cell3']."',
	`CodePostal` = '".$_POST['FORMCodePostal']."',
	`SalaireB` = '".$_POST['FORMSalaireB']."',
	`SalaireR` = '".$_POST['FORMSalaireR']."',
	`SalaireRE` = '".$_POST['FORMSalaireRE']."',
	`SalaireM` = '".$_POST['FORMSalaireM']."',
	`SalaireA` = '".$_POST['FORMSalaireA']."',
	`Status` = '".$_POST['FORMStatus']."',
	`Session` = '".$_POST['FORMSession']."',
	`Notes` = '".addslashes($_POST['FORMNotes'])."',
	`DateEmbauche` = '".$DateEmbauche."',
	`DateNaissance` = 	'".$DateNaissance."',
	`Cessation` = 	'".$_POST['FORMCessation']."',
	`Raison` = '".addslashes($_POST['FORMRaison'])."'
	WHERE IDEmploye=".$_POST['IDEmploye'];

	$SQL->query($Req);

}ELSE{
	if($_POST['FORMIDEmploye']<>"" AND check_unique('employe','IDEmploye',addslashes($_POST['FORMIDEmploye'])))
		$WarnOutput->AddTexte('Ce numéro d\'employé  est déjà attribué','warning');
	elseif(check_unique('employe','NAS',addslashes($_POST['FORMNAS'])) AND $_POST['FORMNAS']<>0)
		$WarnOutput->AddTexte('Il existe déjà un employé avec le même NAS','warning');
	else{
	
	if(!isset($_POST['FORMCessation']))
		$_POST['FORMCessation']=0;
	if($_POST['FORMIDEmploye']==""){
		$Last = get_last('employe');
		$_POST['FORMIDEmploye'] = $Last['IDEmploye']+1;
	}
	if($_POST['MultiVar_DateNaissance4']<>"" AND $_POST['MultiVar_DateNaissance5']<>"" AND $_POST['MultiVar_DateNaissance3']<>"")
		$Naissance = mktime(0,0,0,$_POST['MultiVar_DateNaissance4'],$_POST['MultiVar_DateNaissance5'],$_POST['MultiVar_DateNaissance3']);
	else
		$Naissance=0;
	if($_POST['MultiVar_DateEmbauche4']<>"" AND $_POST['MultiVar_DateEmbauche5']<>"" AND $_POST['MultiVar_DateEmbauche3']<>"")
		$Embauche = mktime(0,0,0,$_POST['MultiVar_DateEmbauche4'],$_POST['MultiVar_DateEmbauche5'],$_POST['MultiVar_DateEmbauche3']);
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
	'".$_POST['MultiVar_TelP1'].$_POST['MultiVar_TelP2'].$_POST['MultiVar_TelP3']."',
	'".$_POST['MultiVar_TelA1'].$_POST['MultiVar_TelA2'].$_POST['MultiVar_TelA3']."',
	'".$_POST['MultiVar_Cell1'].$_POST['MultiVar_Cell2'].$_POST['MultiVar_Cell3']."',
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