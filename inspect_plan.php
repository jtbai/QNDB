<?
if(isset($_POST['FORMIDPlan'])){
	$MainOutput->addOutput(inspect_plan($_POST['FORMIDPlan']),0,0);
}else{
	$MainOutput->AddForm('Ajouter/Modifier un niveau');
	$MainOutput->inputhidden_env('Section','Inspect_Plan');
	$MainOutput->inputhidden_env('ToPrint',TRUE);
	$Req = "SELECT IDPlan, Nom  FROM plan ORDER BY Nom ASC";
	$MainOutput->Inputselect('IDPlan',$Req,'','Plan');
	$MainOutput->formsubmit('Ajouter/Modifier');
}
echo $MainOutput->Send(1);

?> 