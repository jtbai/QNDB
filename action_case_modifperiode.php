<?PHP
$SQL2 = new sqlclass;
$SD = mktime(0,0,0,$_POST['FORMSTART4'],$_POST['FORMSTART5'],$_POST['FORMSTART3']);
$ED = mktime(0,0,0,$_POST['FORMEND4'],$_POST['FORMEND5'],$_POST['FORMEND3']);
foreach($_POST['FORMIDPiscine'] as $k=>$v){
	$Req = "SELECT DISTINCT IDPeriode, Jour, Start FROM periode WHERE IDPiscine=$k and Semaine+Jour*(60*60*24)+Start >".$SD." AND Semaine+Jour*(60*60*24)+Start <".$ED." GROUP BY Semaine, Jour, Start ORDER BY Semaine ASC, Jour ASC, Start ASC";
	$SQL->SELECT($Req);
	while($Rep = $SQL->FetchArray()){
		$Req2 = "SELECT max(Semaine) FROM periode WHERE Jour=".$Rep['Jour']." AND Start=".$Rep['Start']." AND IDPiscine = ".$k;
		$SQL2->SELECT($Req2);
		$Rep2 = $SQL2->FetchArray();
		$ToWeek =$Rep2[0]+60*60*24*7;
		$Req2 = "UPDATE periode SET Semaine=".$ToWeek." WHERE IDPeriode=".$Rep['IDPeriode'];
		$SQL2->UPDATE($Req2);
	}
}


?>