<?
$Now = getdate(time());
$Date = mktime(0,0,0,$Now['mon'],1,$Now['year']);
$Req = "SELECT IDEmploye FROM link_employe_qualification WHERE IDQualification=6 and Expiration>=".$Date;
$SQL->SELECT($Req);
$Couple = "";
while($Rep = $SQL->FetchArray()){
	$Couple .= ",".$Rep['IDEmploye'];
}
$Req = "UPDATE employe SET SalaireM = 10.75, SalaireR = 13.75, SalaireRE=15.75, SalaireA = 9.75";
$SQL->SELECT($Req);
$Req = "UPDATE employe SET SalaireM = 11.75 WHERE IDEmploye in (".substr($Couple,1).")";
$SQL->SELECT($Req);
?>


