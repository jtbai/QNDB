<?PHP

$Couple = "";
	foreach($_POST as $k=>$v){
		if($IDPeriode = substr(stristr($k,'FORMIDPeriode'),13)){
			if($v<>" "){
				if($_POST['Inscripteur'])
					$SP	= "(".$IDPeriode.")";
				else
					$SP = get_periode_string($IDPeriode);
				$Valz = explode('-',$v);
				if($v[0]=="R")
				$Req = "SELECT IDRessource FROM ressource WHERE isnull(IDCours) AND NoRessource = ".$Valz[1]." AND IDPeriode in ".$SP;
					else
				$Req = "SELECT IDRessource FROM cours JOIN ressource on ressource.IDCours = cours.IDCours WHERE IDNiveau = ".$Valz[0]." AND NoRessource = ".$Valz[1]." AND cours.IDPeriode in ".$SP;
				$SQL->SELECT($Req);
				while($Rep = $SQL->FetchArray())
					$Couple .= ",".$Rep[0];
			}
		}
	}
	$UberRequest = "UPDATE ressource SET IDEmploye = ".$_POST['FORMIDEmploye']." WHERE IDRessource IN (".substr($Couple,1).")";
	$SQL->UPDATE($UberRequest);
?>