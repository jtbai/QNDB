<?PHP

$NDay = get_day_list();
$MainOutput->AddForm('Ajouter des cours de natation aux périodes');
$MainOutput->Inputhidden_env('Action','AddCours2');
$Req2 = "SELECT IDNiveau, Niveau FROM niveau WHERE Active and IDNiveau<>46 ORDER BY Rank ASC";
//

$Piscine = get_active('piscine');
	$Ar = array();
foreach($Piscine as $v){
	$Req = "SELECT DISTINCT IDPeriode, IDPiscine, Jour, Start, End FROM periode WHERE IDSession=".$_ACTIVE['Session']."
			AND IDPiscine = ".$v['IDPiscine']." GROUP BY Jour, Start ORDER BY Jour ASC, Start ASC";
	
	//$Req = "SELECT DISTINCT IDPeriode, Jour, Start, End FROM periode WHERE IDSession=".$_ACTIVE['Session']." GROUP BY IDPiscine, Jour, Start ORDER BY IDPiscine ASC, Jour ASC, Start ASC";
	$SQL->SELECT($Req);

	while($Rep = $SQL->FetchArray()){
		$sh = intval($Rep['Start']/60/60);
		$sm = bcmod($Rep['Start'],3600)/60;
		if($sm==0)
		$sm="";
		$eh = intval($Rep['End']/60/60);
		$em = bcmod($Rep['End'],3600)/60;
		if($em==0)
		$em="";
		$Ar[$Rep[0]] = $v['Nom']." - ".$NDay[$Rep['Jour']]." ".$sh."h".$sm." à ".$eh."h".$em;
	}
}

$MainOutput->inputSelect('Periode',$Ar);
$MainOutput->flaglist('Niveau',$Req2);
$MainOutput->Formsubmit();
echo $MainOutput->Send(1);

?>