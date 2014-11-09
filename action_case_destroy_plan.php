<?PHP
$PString = get_periode_string($_GET['IDPeriode'],TRUE);
$Req = "SELECT IDCours FROM cours WHERE IDPeriode in ".$PString;
$Couple = "";
$SQL->Select($Req);
while($Req = $SQL->FetchArray()){
	$Couple .= ",".$Req['IDCours'] ; 
}
$Req = "DELETE FROM zone WHERE IDCours in (".substr($Couple,1).")";
$SQL->query($Req);
$Section = "Periode";
?>