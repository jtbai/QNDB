<?PHP

$ReqRep = "SELECT periode.IDPeriode FROM periode JOIN ressource on periode.IDPeriode = ressource.IDPeriode WHERE isnull(IDCours) AND IDSession = ".$_ACTIVE['Session'];
$SQL->Select($ReqRep);
$Couple="";
while($Rep = $SQL->FetchArray()){
	$Couple .= ",".$Rep[0];
}
$ReqMissing = "SELECT IDPeriode FROM periode WHERE IDPeriode not in (".substr($Couple,1).")";
$SQL->SELECT($ReqMissing);
$Couple2 = "";
while($Rep = $SQL->FetchArray()){
	$Couple2 .= ", (".$Rep[0].",'R','1',NULL)";
}
$MegaReq = "INSERT INTO ressource(`IDPeriode`,`Role`,`NoRessource`,`IDCours`) VALUES ".substr($Couple2,1);
echo $MegaReq;
?>