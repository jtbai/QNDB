<?PHP
$Req = "UPDATE session set Active=0";
$SQL->UPDATE($Req);

	$Session  = get_last('session');

		if($Session['Saison']=="H"){
			$Saison = "P";
			$Annee = $Session['Annee'];
		}elseif($Session['Saison']=="P"){
			$Saison = "E";
			$Annee = $Session['Annee'];
		}elseif($Session['Saison']=="E"){
			$Saison = "A";	
			$Annee = $Session['Annee'];
		}elseif($Session['Saison']=="A"){
			$Saison = "H";
			$Annee = $Session['Annee']+1;
		}

$Req = "INSERT INTO session(`Saison`,`Annee`,`Active`) VALUES('".$Saison."','".$Annee."',1)";
$SQL->Insert($Req);
$Section="Session";
?>