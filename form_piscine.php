<?PHP

$MainOutput->AddForm('Ajouter/Modifier une Piscine');
$MainOutput->inputhidden_env('Action','Piscine');
if(isset($_GET['IDPiscine'])){
	$Info = get_info('piscine',$_GET['IDPiscine']);
	$MainOutput->inputhidden_env('UPDATE',TRUE);
	$MainOutput->inputhidden_env('IDPiscine',$_GET['IDPiscine']);
}else{
	$Info = array('Nom'=>'','Adresse'=>'','Tel'=>'418');
	$MainOutput->inputhidden_env('UPDATE',FALSE);
}

$MainOutput->InputText('Nom','Nom','28',$Info['Nom']);
$MainOutput->TextArea('Adresse','Adresse',25,5,$Info['Adresse']);
$MainOutput->InputPhone('Tel','Téléphone',$Info['Tel'],TRUE);
$MainOutput->formsubmit('Ajouter/Modifier');
echo $MainOutput->Send(1);
?>
