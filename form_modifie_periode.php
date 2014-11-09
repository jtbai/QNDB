<?PHP
$NDay = get_day_list();
if(!isset($_GET['FORMIDPeriode'])){

$MainOutput->AddForm('Modifier une période','index.php','GET');
$MainOutput->Inputhidden_env('Section','Modifie_Periode');
$Piscine = get_active('piscine');
	$Ar = array();
foreach($Piscine as $v){
	$Req = "SELECT DISTINCT IDPeriode, IDPiscine, Jour, Start, End FROM periode WHERE IDSession=".$_ACTIVE['Session']."
			AND IDPiscine = ".$v['IDPiscine']." GROUP BY Jour, Start ORDER BY Jour ASC, Start ASC";
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
	$MainOutput->InputSelect('IDPeriode',$Ar,'','Periode');
	$MainOutput->FormSubmit('Modifier');
}else{
	$PeriodeInfo = get_info('periode',$_GET['FORMIDPeriode']);

		$sh = intval($PeriodeInfo['Start']/60/60);
		$sm = bcmod($PeriodeInfo['Start'],3600)/60;
		if($sm==0)
		$sm="";
		$eh = intval($PeriodeInfo['End']/60/60);
		$em = bcmod($PeriodeInfo['End'],3600)/60;
		if($em==0)
		$em="";
	$PiscineInfo = get_info('piscine',$PeriodeInfo['IDPiscine']);
	$MainOutput->AddForm($PiscineInfo['Nom']." - ".$NDay[$PeriodeInfo['Jour']]." ".$sh."h".$sm." à ".$eh."h".$em);
	$MainOutput->Inputhidden_env('Action','Modifie_Periode');
	$MainOutput->Inputhidden_env('IDPeriode',$_GET['FORMIDPeriode']);
	$MainOutput->Inputtime('StartTime','Heure de début',$PeriodeInfo['Start'],array('Date'=>FALSE,'Time'=>TRUE));
	$MainOutput->Inputtime('EndTime','Heure de fin',$PeriodeInfo['End'],array('Date'=>FALSE,'Time'=>TRUE));
	$Req = "SELECT IDPlan, Nom FROM plan ORDER BY Nom ASC";
	$MainOutput->InputSelect('IDPlan',$Req,$PeriodeInfo['IDPlan'],'Plan de piscine');
	$SP = get_similar_periode($_GET['FORMIDPeriode'],TRUE,'IDPeriode, Semaine+Jour*24*3600');
	$i=1;
	foreach($SP as $k=>$v){
		$MainOutput->InputTime('Periode'.$k,'Periode '.$i,$v[1],array('Time'=>FALSE,'Date'=>TRUE));
		$i++;
	}
	
	
	$MainOutput->FormSubmit('Modifier');
}
echo $MainOutput->send(1);
?>