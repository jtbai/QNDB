<?PHP
if($_GET['Table']=='Niveau'){
	$SQL->UPDATE("UPDATE niveau set Rank=".next_rank()." WHERE IDNiveau=".$_GET['ID']);
}elseif($_GET['Table']=='Session'){
	$SQL->UPDATE("UPDATE session set Active=0 WHERE IDSession not in(".$_GET['ID'].")");
}
activate($_GET['Table'],$_GET['ID']);
$WarnOutput->AddTexte($_GET['Table']." activé(e)",'warning');
?>