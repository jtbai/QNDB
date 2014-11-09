<?PHP
$NDay = get_day_list();
$MainOutput->AddForm('Ajouter des cours de natation aux périodes');
$MainOutput->Inputhidden_env('Action','BatchPlan');
$Req = "SELECT IDPlan, Nom FROM plan ORDER BY Nom ASC";
$MainOutput->inputSelect('IDPlan',$Req,'','Plan');
$MainOutput->AddOutput('<tr>

<td colspan=2><span class=Titre>&nbsp;</span>
',0,0);

$Piscine = get_active('piscine');
$MainOutput->OpenTable();
$MainOutput->OpenRow();
	$i=0;
foreach($Piscine as $v){
	$MainOutput->OpenCol();
	$MainOutput->AddPic('carlos.gif','width=125, height=1');
	$MainOutput->br();
	$MainOutput->AddTexte($v['Nom'],'Titre');
	$MainOutput->br(2);
	$Req = "SELECT DISTINCT IDPeriode, Jour, Start, End FROM periode WHERE IDSession=".$_ACTIVE['Session']." AND IDPiscine=".$v['IDPiscine']." AND IDPlan=0
		GROUP BY Jour, Start ORDER BY Jour ASC, Start ASC";
	$SQL->SELECT($Req);
	$OldDay = -1;
	$BlackCarlos = FALSE;

	while($Rep = $SQL->FetchArray()){
		if($OldDay<>$Rep['Jour']){
			if($BlackCarlos)
				$MainOutput->AddPic('blackcarlos.gif','width=100, height=1');
			$OldDay = $Rep['Jour'];
			$MainOutput->AddTexte($NDay[$Rep['Jour']],'Titre');
			$MainOutput->br();
		}
		$BlackCarlos=TRUE;
	
		$sh = intval($Rep['Start']/60/60);
		$sm = bcmod($Rep['Start'],3600)/60;
		if($sm==0)
		$sm="";
		$eh = intval($Rep['End']/60/60);
		$em = bcmod($Rep['End'],3600)/60;
		if($em==0)
		$em="";
		$MainOutput->AddOutput('<input type=checkbox name=\'FORMIDPeriode['.$i.']\' value='.$Rep['IDPeriode'].'> ',0,0);
		$MainOutput->AddTexte($sh."h".$sm);
		$MainOutput->AddTexte('à');
		$MainOutput->AddTexte($eh."h".$em);
		$MainOutput->br();
		$i++;
	}
	$MainOutput->CloseCol();
}
$MainOutput->CloseRow();
$MainOutput->CloseTable();

$MainOutput->AddOutput('</td>
</tr>',0,0);
$MainOutput->Formsubmit();
echo $MainOutput->Send(1);
?>