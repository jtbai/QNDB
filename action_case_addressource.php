<?PHP
//check si c'est un cours / ou bin un responsable // OU BIN UN Inscripteur

$Req = "SELECT IDNiveau FROM cours WHERE IDCours = ".$_GET['IDCours'];
$SQL->SELECT($Req);
$Rep = $SQL->FetchArray();
if($Rep[0]==46){
	$Role = "B";
}else{
	if($_GET['IDCours']=="NULL"){
		$Role = "R";
	}else{
		$Role = "A";
	}
}
//get last ressource number
if($_GET['IDCours']==NULL or $_GET['IDCours']=="NULL" or $_GET['IDCours']==""){
	$Req = "SELECT NoRessource FROM ressource WHERE isnull(".$_GET['IDCours'].") AND IDPeriode=".$_GET['IDPeriode']." ORDER BY NoRessource DESC LIMIT 0,1";
	$_GET['IDCours'] = "NULL";
}else
	$Req = "SELECT NoRessource FROM ressource WHERE IDCours=".$_GET['IDCours']." AND IDPeriode=".$_GET['IDPeriode']." ORDER BY NoRessource DESC LIMIT 0,1";
//Debug en cours...
//il faut trouver pkoi c'est pas faisable d'ajouter un assis responsable
//die($Req);
$SQL->SELECT($Req);
$Rep = $SQL->FetchArray();
$NoRessource = $Rep['NoRessource']+1;

if($_GET['AllSession']=="FALSE")
	$Req = "INSERT INTO ressource(`IDPeriode`,`IDCours`,`Role`,`NoRessource`) VALUES('".$_GET['IDPeriode']."',".$_GET['IDCours'].",'".$Role."','".$NoRessource."')";
else{
	if($_GET['IDCours']=="NULL"){
		$Periodes = get_similar_periode($_GET['IDPeriode']);
		$Couple = "";
		foreach($Periodes as $k=>$v){
			$Couple .= ",(".$k.",NULL,'".$Role."','".$NoRessource."')";
		}	
	}else{
		$Cours = get_similar_cours($_GET['IDCours']);
		$Couple = "";
		foreach($Cours as $k=>$v){
			$Couple .= ",(".$v[1].",".$v[0].",'".$Role."','".$NoRessource."')";
		}	
	}
	
	$Req = "INSERT INTO ressource(`IDPeriode`,`IDCours`,`Role`,`NoRessource`) VALUES ".substr($Couple,1);
}

$SQL->INSERT($Req);


?>