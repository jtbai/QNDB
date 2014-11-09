<?PHP
$MainOutput->AddForm('Ajouter/Modifier un niveau');
$MainOutput->inputhidden_env('Action','Niveau');
if(isset($_GET['IDNiveau'])){
	$Info = get_info('niveau',$_GET['IDNiveau']);
	$MainOutput->inputhidden_env('UPDATE',TRUE);
	$MainOutput->inputhidden_env('IDNiveau',$_GET['IDNiveau']);
}else{
	$Info = array('Niveau'=>'','Code'=>'','Objectif'=>'');
	$MainOutput->inputhidden_env('UPDATE',FALSE);
}

$MainOutput->InputText('Niveau','Niveau','28',$Info['Niveau']);
$MainOutput->InputText('Code','Code',3,$Info['Code']);
$MainOutput->TextArea('Objectif','Objectifs',25,7,$Info['Objectif']);
$MainOutput->formsubmit('Ajouter/Modifier');
echo $MainOutput->Send(1);
?>
