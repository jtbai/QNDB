<?PHP


$Couple = "";
foreach($_POST['FORMIDPeriode'] as $v){
	$Info = get_info('periode',$v);
	$Req = "SELECT IDPeriode FROM periode WHERE Start=".$Info['Start']." AND IDPiscine=".$Info['IDPiscine']." AND Jour=".$Info['Jour']." AND IDSession=".$_ACTIVE['Session'];
	$SQL->SELECT($Req);
	while($Rep = $SQL->FetchArray()){
		$Couple .= ",".$Rep[0];
	}
}

$Req = "UPDATE periode SET IDPlan =".$_POST['FORMIDPlan']." WHERE IDPeriode in (".substr($Couple,1).")";
$SQL->QUERY($Req);

//
//$Couple ="";
//while($Rep = $SQL->FetchArray()){
//	$Couple = $Couple.",(".$Rep['IDCours'].",".$Rep['IDPeriode'].",1,'M')";
//}
//$Req = "INSERT INTO ressource(`IDCours`,`IDPeriode`,`NoRessource`,`Role`) VALUES".substr($Couple,1);
//$SQL->INSERT($Req);
?>