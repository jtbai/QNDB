<?PHP
if($_GET['Table']=='Niveau'){
	$Info = get_info('niveau',$_GET['ID']);
	$SQL->UPDATE("UPDATE niveau set Rank=Rank-1 WHERE Rank>".$Info['Rank']);
	$SQL->UPDATE("UPDATE niveau set Rank=0 WHERE IDNiveau=".$_GET['ID']);
}
activate($_GET['Table'],$_GET['ID'],0);
$WarnOutput->AddTexte(ucfirst($_GET['Table'])." desactivé(e)",'warning');

?>