<?PHP
$MainOutput->AddForm('Ajouter un remplacement');
$MainOutput->inputhidden_env('Action','Remplacement');
$Req = "SELECT IDEmploye, Nom, Prenom FROM employe WHERE !Cessation ORDER BY Nom ASC, Prenom ASC";
$MainOutput->InputSelect('IDEmployeS',$Req,'','Employ� Sortant');
$MainOutput->inputtime('FROM','Commen�ant','',array('Date'=>TRUE,'Time'=>FALSE));
$MainOutput->inputtime('TO','Terminant','',array('Date'=>TRUE,'Time'=>FALSE));

$MainOutput->textarea('Raison',NULL,25,1);
$MainOutput->flag('Lastminute',0,'Derni�re Minute');

$Req = "SELECT IDEmploye, Nom, Prenom FROM employe WHERE Status='Bureau' ORDER BY Nom ASC";
$MainOutput->InputSelect('Talkedto',$Req,'','Demand� �');


$MainOutput->Formsubmit('Ajouter');
echo $MainOutput->Send(1);
?>