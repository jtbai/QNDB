<?PHP
if($_POST['UPDATE']){
	$Req = "Update niveau set `Niveau`='".addslashes($_POST['FORMNiveau'])."', `Code`='".addslashes($_POST['FORMCode'])."', `Objectif`='".addslashes($_POST['FORMObjectif'])."' WHERE IDNiveau=".$_POST['IDNiveau'];
	$SQL->UPDATE($Req);
	$WarnOutput->AddTexte('Niveau modifié','warning');
}else{
	if(check_unique('niveau','Niveau',addslashes($_POST['FORMNiveau'])))
		$WarnOutput->AddTexte('Il existe déjà un niveau avec le même nom','warning');
	elseif(check_unique('niveau','Code',addslashes($_POST['FORMCode'])))
		$WarnOutput->AddTexte('Il existe déjà un niveau avec le même code','warning');
	else{
		$Rank = next_rank();
		$Req = "INSERT INTO niveau(`Niveau`,`Code`,`Objectif`,`Rank`) VALUES('".addslashes($_POST['FORMNiveau'])."','".$_POST['FORMCode']."','".addslashes($_POST['FORMObjectif'])."','".$Rank."')";
		$SQL->INSERT($Req);
		$WarnOutput->AddTexte('Niveau ajouté','warning');
	}
}
$Section = "Niveau";
?>