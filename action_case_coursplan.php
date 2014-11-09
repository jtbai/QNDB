<?PHP
// A OPTIMISER //
$SQL2 = new sqlclass;
$CoupleI = array();
$CoupleM = array();
$AllCours = "";
foreach($_POST as $k=>$v){
	if(strstr($k,'Zone')){
		$NoZone = substr($k,4);
		if($v<>0){
			$Cours = get_similar_cours($v,TRUE);
			foreach($Cours as $IDCours){
				$Req2 = "SELECT IDCours FROM zone WHERE IDCours = ".$IDCours['IDCours'];
				$SQL2->SELECT($Req2);
				if($SQL2->NumRow()<>0)
					$Req = "UPDATE zone SET NoZone WHERE IDCours =".$IDCours['IDCours']; //canceller cette ligne la
				else{
					$Req = "INSERT INTO zone(`IDCours`,`NoZone`) VALUES (".$IDCours['IDCours'].",".$NoZone.")";
					$SQL->QUERY($Req);	
				}
			}
		}
	}
}
$Section = "Periode";
$_GET['IDPeriode'] = $_POST['IDPeriode'];

?>