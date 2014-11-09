<?PHP

if($_POST['FORMIDNiveau']<>0){
	$Req = "UPDATE cours set IDNiveau = ".$_POST['FORMIDNiveau'].", Multiplicateur=".$_POST['FORMMultiplicateur']." WHERE IDCours in ".get_cours_string($_POST['IDCours'],TRUE);
	$Section = "ModifieCours" ;
	$_GET['AllSession'] = $_POST['AllSession'];
	$_GET['IDCours'] = $_POST['IDCours'];
}else{

	$String = get_cours_string($_POST['IDCours'],TRUE);
	$Req = "DELETE FROM cours WHERE IDCours in ".$String;
	$SQL->QUERY($Req);
	$Req = "DELETE FROM ressource WHERE IDCours in ".$String;
	$Section = "Cours" ;
}
$SQL->QUERY($Req);
?>