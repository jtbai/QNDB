<?
$Req  = "SELECT ressource.IDCours FROM cours JOIN ressource ON ressource.IDCours = cours.IDCours";
$SQL->SELECT($Req);
$Str = "";
while($Rep = $SQL->FetchArray()){
	$Str .= ",".$Rep['IDCours']." ";
}
$Req = "DELETE FROM ressource WHERE IDCours not in (".substr($Str,1).")";
$SQL->QUERY($Req);
$Req = "DELETE FROM ressource WHERE ROLE = ''";
$SQL->QUERY($Req);



$WarnOutput->Addtexte('Ressources Synchronisées','Warning');
echo $WarnOutput->send(1);
?>