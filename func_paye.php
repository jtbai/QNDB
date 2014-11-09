<?PHP
function overwrite_salaire($IDSession){
	$SQL = new sqlclass;
	//AQUAFORME - AQUAJOGGING - AQUAFORME @ limoilou
	//20$
	$Req = "SELECT IDRessource FROM ressource JOIN cours JOIN periode on ressource.IDCours = cours.IDCours AND periode.IDPeriode = cours.IDPeriode WHERE IDNiveau in (32,33,34,36) AND End-Start >=3600 AND IDPiscine = 11 AND IDSession = ".$IDSession;
	$SQL->SELECT($Req);
	$Couple = "";
	while($Rep = $SQL->FetchArray()){
		$Couple .= ",".$Rep['IDRessource'];
	}
	$Req = "UPDATE ressource SET salaire=20 WHERE IDRessource in (".substr($Couple,1).")"; 
	$SQL->QUERY($Req);

	
	//AQUAFORME - AQUAJOGGING - AQUAFORME @ Garneau/Eudes
	//15$
	$Req = "SELECT IDRessource FROM ressource JOIN cours JOIN periode on ressource.IDCours = cours.IDCours AND periode.IDPeriode = cours.IDPeriode WHERE IDNiveau in (32,33,34,36) AND IDPiscine in (13,14) AND IDSession = ".$IDSession;
	$SQL->SELECT($Req);
	$Couple = "";
	while($Rep = $SQL->FetchArray()){
		$Couple .= ",".$Rep['IDRessource'];
	}
	
	$Req = "UPDATE ressource SET salaire=15 WHERE IDRessource in (".substr($Couple,1).")"; 
	$SQL->QUERY($Req);

	//Cours de semaine, sauf bain libre (Lundi à Jeudi)
	//15$ / h
	$Req = "SELECT IDRessource FROM ressource JOIN cours JOIN periode on ressource.IDCours = cours.IDCours AND periode.IDPeriode = cours.IDPeriode WHERE IDNiveau <> 42 AND IDPiscine = 12 AND Jour in (1,2,3,4) AND IDSession = ".$IDSession;
	$SQL->SELECT($Req);
	$Couple = "";
	while($Rep = $SQL->FetchArray()){
		$Couple .= ",".$Rep['IDRessource'];
	}
		$Req = "UPDATE ressource SET salaire=15 WHERE IDRessource in (".substr($Couple,1).")"; 
	$SQL->QUERY($Req);
	
	
	//Cours de semaine, sauf bain libre (Vendredi)
	//15$ / h
	$Req = "SELECT IDRessource FROM ressource JOIN cours JOIN periode on ressource.IDCours = cours.IDCours AND periode.IDPeriode = cours.IDPeriode WHERE IDNiveau <> 42 AND IDPiscine = 12 AND Jour = 5 AND Start<61200 AND IDSession = ".$IDSession;
	$SQL->SELECT($Req);
	$Couple = "";
	while($Rep = $SQL->FetchArray()){
		$Couple .= ",".$Rep['IDRessource'];
	}

	$Req = "UPDATE ressource SET salaire=15 WHERE IDRessource in (".substr($Couple,1).")"; 
	$SQL->QUERY($Req);

	//Bains Libre Plaza
	//15$ / h
	$Req = "SELECT IDRessource FROM ressource JOIN cours JOIN periode on ressource.IDCours = cours.IDCours AND periode.IDPeriode = cours.IDPeriode WHERE IDNiveau = 42 AND IDPiscine = 12 AND Jour in (1,2,3,4,5) AND Start<61200 AND IDSession = ".$IDSession;
	$SQL->SELECT($Req);
	$Couple = "";
	while($Rep = $SQL->FetchArray()){
		$Couple .= ",".$Rep['IDRessource'];
	}

	$Req = "UPDATE ressource SET salaire=15 WHERE IDRessource in (".substr($Couple,1).")"; 
	$SQL->QUERY($Req);

}
?>