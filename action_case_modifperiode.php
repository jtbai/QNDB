<?PHP
$SQL2 = new sqlclass;
$SD = mktime(0,0,0,$_POST['MultiVar_START4'],$_POST['MultiVar_START5'],$_POST['MultiVar_START3']);
$ED = mktime(0,0,0,$_POST['MultiVar_END4'],$_POST['MultiVar_END5'],$_POST['MultiVar_END3']);
foreach($_POST['FORMIDPiscine'] as $k=>$v){
	$Req = "SELECT DISTINCT IDPeriode, Jour, Start FROM periode WHERE IDPiscine=$k and Semaine+Jour*(60*60*24)+Start >".$SD." AND Semaine+Jour*(60*60*24)+Start <".$ED." GROUP BY Semaine, Jour, Start ORDER BY Semaine ASC, Jour ASC, Start ASC";
	$SQL->SELECT($Req);
	while($Rep = $SQL->FetchArray()){
		$Req2 = "SELECT max(Semaine) FROM periode WHERE Jour=".$Rep['Jour']." AND Start=".$Rep['Start']." AND IDPiscine = ".$k." AND IDSession=".$_ACTIVE['Session'] ;
		$SQL2->SELECT($Req2);
		$Rep2 = $SQL2->FetchArray();
		$ToWeek =$Rep2[0]+60*60*24*7;
		$Req2 = "UPDATE periode SET Semaine=".$ToWeek." WHERE IDPeriode=".$Rep['IDPeriode'];
		$SQL2->UPDATE($Req2);
		print($Req2);
	}
}


?>