<?PHP
$MainOutput->AddForm('Modifier les dates d\'une ou des période(s) de cours');
$ReqPiscine = "SELECT IDPiscine, Nom FROM piscine WHERE Active ORDER BY Nom ASC";
$MainOutput->inputhidden_env('Action','ModifPeriode');
$MainOutput->flaglist('IDPiscine',$ReqPiscine,'','Piscines');
$MainOutput->inputradio('Action',array('Deplacer'=>'MovePeriode','Supprimer'=>'DeletePeriode'),'MovePeriode','Action à faire ');

$MainOutput->InputTime('START','Commençant',0,array('Date'=>TRUE,'Time'=>FALSE));
$MainOutput->InputTime('END','Finissant',0,array('Date'=>TRUE,'Time'=>FALSE));
$MainOutput->FormSubmit('Effectuer');
echo $MainOutput->Send(1);
?>