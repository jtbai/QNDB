<?PHP
$MainOutput->AddOutput($WarnOutput->Send(1),0,0);
include('welcome.php');
$MainOutput->addform('Connexion au logiciel de gestion de Qu�bec Natation');
$MainOutput->inputhidden_env('Action','Login');

$MainOutput->inputselect('CIE',array('RNORD'=>'Qu�bec Natation Rive-Nord','RSUD'=>'Qu�bec Natation Rive-Sud'),'RNORD','Compagnie');
$MainOutput->inputtext('IDEmploye','Num�ro&nbsp;d\'employ�','3');
$MainOutput->inputtext('NAS','3 dernier&nbsp;NAS','3');


$MainOutput->formsubmit('Login');

echo $MainOutput->send(1);
?>