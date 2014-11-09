<?PHP
$MainOutput->AddOutput($WarnOutput->Send(1),0,0);
include('welcome.php');
$MainOutput->addform('Connexion au logiciel de gestion de Québec Natation');
$MainOutput->inputhidden_env('Action','Login');

$MainOutput->inputselect('CIE',array('RNORD'=>'Québec Natation Rive-Nord','RSUD'=>'Québec Natation Rive-Sud'),'RNORD','Compagnie');
$MainOutput->inputtext('IDEmploye','Numéro&nbsp;d\'employé','3');
$MainOutput->inputtext('NAS','3 dernier&nbsp;NAS','3');


$MainOutput->formsubmit('Login');

echo $MainOutput->send(1);
?>