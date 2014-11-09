<?PHP
$MainOutput->AddForm('Ajouter un remplacement');
$MainOutput->inputhidden_env('Action','Remplacement');
$Req = "SELECT IDEmploye, Nom, Prenom FROM employe WHERE !Cessation ORDER BY Nom ASC, Prenom ASC";
$MainOutput->InputSelect('IDEmployeS',$Req,'','Employé Sortant');
$MainOutput->inputtime('FROM','Commençant','',array('Date'=>TRUE,'Time'=>FALSE));
$MainOutput->inputtime('TO','Terminant','',array('Date'=>TRUE,'Time'=>FALSE));

$MainOutput->textarea('Raison',NULL,25,1);
$MainOutput->flag('Lastminute',0,'Dernière Minute');

$Req = "SELECT IDEmploye, Nom, Prenom FROM employe WHERE Status='Bureau' ORDER BY Nom ASC";
$MainOutput->InputSelect('Talkedto',$Req,'','Demandé à');


$MainOutput->Formsubmit('Ajouter');
echo $MainOutput->Send(1);
?>