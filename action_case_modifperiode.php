<?PHP
$SQL2 = new sqlclass;
$SD = mktime(0,0,0,$_POST['MultiVar_START4'],$_POST['MultiVar_START5'],$_POST['MultiVar_START3']);
$ED = mktime(0,0,0,$_POST['MultiVar_END4'],$_POST['MultiVar_END5'],$_POST['MultiVar_END3']) +24*3600;
$MessageOutput->addtexte("Shift modifies<br>", "Titre");
foreach($_POST['FORMIDPiscine'] as $k=>$v){
    $Req = "SELECT DISTINCT IDPeriode, Semaine, Jour, Start FROM periode WHERE IDPiscine=$k and Semaine+Jour*(60*60*24)+Start >".$SD." AND Semaine+(Jour)*(60*60*24)+Start <".$ED." GROUP BY Semaine, Jour, Start ORDER BY Semaine ASC, Jour ASC, Start ASC";
	$SQL->SELECT($Req);
    $piscine_name_req = "SELECT nom FROM piscine where IDPiscine=".$k;
	$SQL2->Select($piscine_name_req);
    $nom_pisince_rep = $SQL2->FetchAssoc();
    $nom_piscine = $nom_pisince_rep['nom'];
	while($Rep = $SQL->FetchArray()){
		$Req2 = "SELECT max(Semaine) as last_week FROM periode WHERE Jour=".$Rep['Jour']." AND Start=".$Rep['Start']." AND IDPiscine = ".$k;
		$SQL2->SELECT($Req2);
		$Rep2 = $SQL2->FetchArray();

        $current_week = new DateTime("@".$Rep['Semaine']);
        $current_week->add(new DateInterval('P'.$Rep['Jour'].'D'));

        $last_week = new DateTime("@".$Rep2['last_week']);
        $last_week->add(new DateInterval('P7D'));
        $ToWeek = $last_week->getTimestamp();
        $jour_du_cours = strftime("%A", $current_week->getTimestamp());
        $date_to_print = strftime("%e-%b",$current_week->getTimestamp());
        $sh= intval($Rep['Start']/60/60);
        $sm = bcmod($Rep['Start'],3600)/60;
        if($sm==0)
            $sm="";
        $time_to_print = $sh."h".$sm;

        $to_week_date_to_print = new DateTime("@".$ToWeek);
        $to_week_date_to_print->add(new DateInterval('P'.$Rep['Jour'].'D'));
        $to_week_date_to_print= strftime("%e-%b",$to_week_date_to_print->getTimestamp());

        $MessageOutput->addtexte($jour_du_cours." ".$time_to_print." au ".$nom_piscine." - ".$date_to_print." -> ".$to_week_date_to_print."<br>");

        $Req2 = "UPDATE periode SET Semaine=".$ToWeek." WHERE IDPeriode=".$Rep['IDPeriode'];
		$SQL2->UPDATE($Req2);
	}
}


$_GET['Section'] = "Periode"
?>