<?PHP
if($_POST['UPDATE']){
	$Req = "Update niveau set `Niveau`='".addslashes($_POST['FORMNiveau'])."', `Code`='".addslashes($_POST['FORMCode'])."', `Objectif`='".addslashes($_POST['FORMObjectif'])."' WHERE IDNiveau=".$_POST['IDNiveau'];
	$SQL->UPDATE($Req);
	$WarnOutput->AddTexte('Niveau modifi�','warning');
}else{
	if(check_unique('niveau','Niveau',addslashes($_POST['FORMNiveau'])))
		$WarnOutput->AddTexte('Il existe d�j� un niveau avec le m�me nom','warning');
	elseif(check_unique('niveau','Code',addslashes($_POST['FORMCode'])))
		$WarnOutput->AddTexte('Il existe d�j� un niveau avec le m�me code','warning');
	else{
		$Rank = next_rank();
		$Req = "INSERT INTO niveau(`Niveau`,`Code`,`Objectif`,`Rank`) VALUES('".addslashes($_POST['FORMNiveau'])."','".$_POST['FORMCode']."','".addslashes($_POST['FORMObjectif'])."','".$Rank."')";
		$SQL->INSERT($Req);
		$WarnOutput->AddTexte('Niveau ajout�','warning');
	}
}
$Section = "Niveau";
?>