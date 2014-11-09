<?PHP

//check si c'est un cours / ou bin un responsable

if($_GET['AllSession']=="FALSE"){
	if($_GET['IDCours']==NULL or !isset($_GET['IDCours']) or $_GET['IDCours']==""){
		$Req = "Delete FROM ressource WHERE isnull(IDCours) AND IDPeriode=".$_GET['IDPeriode']." AND NoRessource = '".$_GET['NoRessource']."'";
		$SQL->Query($Req);
		$Req = "UPDATE ressource SET `NoRessource`= `NoRessource`-1 WHERE NoRessource >".$_GET['NoRessource']." AND IDPeriode=".$_GET['IDPeriode']." AND isnull(IDCours)";
		$SQL->Query($Req);
	}else{
		$Req = "Delete FROM ressource WHERE IDCours=".$_GET['IDCours']." AND IDPeriode=".$_GET['IDPeriode']." AND NoRessource = '".$_GET['NoRessource']."'";
		$SQL->Query($Req);
		$Req = "UPDATE ressource SET `NoRessource`= `NoRessource`-1 WHERE NoRessource >".$_GET['NoRessource']." AND IDPeriode=".$_GET['IDPeriode']." AND IDCours=".$_GET['IDCours'];
		$SQL->Query($Req);
	}
	
	
}else{
	$Couple = "";
	$Couple2 = "";
	if($_GET['IDCours']==NULL or !isset($_GET['IDCours']) or $_GET['IDCours']==""){
		$Periodes = get_similar_periode($_GET['IDPeriode']);
		$Couple = "";
		foreach($Periodes as $k=>$v){
			$Couple .= ",(".$k.",".$_GET['NoRessource'].")";
			$Couple2 .= ",(".$k.")";
		}
		$Req = "Delete FROM ressource WHERE ISNULL(IDCours) AND (`IDPeriode`,`NoRessource`) IN (".substr($Couple,1).")";
		$SQL->Query($Req);
		$Req = "UPDATE ressource SET `NoRessource`= `NoRessource`-1 WHERE NoRessource >".$_GET['NoRessource']." AND (`IDPeriode`) IN (".substr($Couple2,1).") and ISNULL(IDCours)";			
		$SQL->Query($Req);
		
	}else{
		$Cours = get_similar_cours($_GET['IDCours']);

		foreach($Cours as $k=>$v){
			$Couple .= ",(".$v[1].",".$v[0].",'".$_GET['NoRessource']."')";
			$Couple2 .= ",(".$v[1].",".$v[0].")";
		}	
		$Req = "Delete FROM ressource WHERE (`IDPeriode`,`IDCours`,`NoRessource`) IN (".substr($Couple,1).")";
		$SQL->Query($Req);
		$Req = "UPDATE ressource SET `NoRessource`= `NoRessource`-1 WHERE NoRessource >".$_GET['NoRessource']." AND (`IDPeriode`,`IDCours`) IN (".substr($Couple2,1).")";			
		$SQL->Query($Req);
	}
	
}





?>