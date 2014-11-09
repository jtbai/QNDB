<?PHP
$MainOutput->addform('Ajouter / Modifier un employé');
$MainOutput->inputhidden_env('Action','Employe');
if(isset($_GET['IDEmploye'])){
	$Info = get_info('employe',$_GET['IDEmploye']);
	$MainOutput->inputhidden_env('IDEmploye',$_GET['IDEmploye']);
	$MainOutput->inputhidden_env('Update',TRUE);
}else{
	$Info = array('IDEmploye'=>'','HName'=>'','Ville'=>'Québec','Status'=>'','NAS'=>'','Nom'=>'','Prenom'=>'','Session'=>$_ACTIVE['Session'],'DateNaissance'=>'','Adresse'=>'','CodePostal'=>'','Email'=>'','TelM'=>'','TelP'=>'','TelA'=>'','Cell'=>'','Cessation'=>'','Notes'=>'','Raison'=>'','SalaireB'=>'','SalaireRE'=>'','SalaireR'=>'','SalaireM'=>'','SalaireA'=>'','DateEmbauche'=>'','Engage'=>1);
	$MainOutput->inputhidden_env('Update',FALSE);
}

//$MainOutput->addlink('index.php?Section=Employe_Report&IDEmploye='.$Info['IDEmploye'].'&ToPrint=TRUE','<img src=b_sheet.png border=0>');
$MainOutput->addlink('index.php?Section=Employe_Horshift&IDEmploye='.$Info['IDEmploye'],'<img src=images/plan.png border=0>','_BLANK');
//$MainOutput->addlink('index.php?Section=Employe_Summer&IDEmploye='.$Info['IDEmploye'],'<img src=b_fact.png border=0>');
//$MainOutput->addlink('index.php?Section=Mail_Horaire&IDEmploye='.$Info['IDEmploye'],'<img src=b_edit.png border=0>','_BLANK');

$MainOutput->inputtext('IDEmploye','Numéro d\'employé','3',$Info['IDEmploye']);


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->addtexte('----------Personnel------------------------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->inputtext('Nom','Nom','28',$Info['Nom']);
$MainOutput->inputtext('Prenom','Prénom','28',$Info['Prenom']);
$MainOutput->inputtext('HName','Nom Horaire','28',$Info['HName']);
$MainOutput->inputtime('DateNaissance','Date de naissance',$Info['DateNaissance'],array('Date'=>TRUE,'Time'=>FALSE));
$MainOutput->inputtext('NAS','Numéro d\assurance sociale','9',$Info['NAS']);
$MainOutput->textarea('Notes','Notes','25','2',$Info['Notes']);


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->addtexte('----------Contact----------------------------------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->inputtext('Adresse','Adresse','28',$Info['Adresse']);
//$Req = "SELECT IDSecteur, Nom FROM Secteur ORDER BY Nom ASC";
//$MainOutput->inputselect('IDSecteur',$Req,$Info['IDSecteur'],'Secteur');
$MainOutput->inputtext('Ville','Ville','28',$Info['Ville']);
$MainOutput->inputtext('CodePostal','Code Postal','7',$Info['CodePostal']);
$MainOutput->inputtext('Email','Courriel','28',$Info['Email']);
$MainOutput->inputphone('TelP','Tél. Principal',$Info['TelP']);
$MainOutput->inputphone('TelA','Tél. Autre',$Info['TelA']);
$MainOutput->inputphone('Cell','Cellulaire',$Info['Cell']);


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->addtexte('----------Compagnie----------------------------------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->inputtime('DateEmbauche','Date d\'embauche',$Info['DateEmbauche'],array('Date'=>TRUE,'Time'=>FALSE));
$Status = array('Temps plein'=>'Temps plein','Secondaire'=>'Secondaire','CÉGEP'=>'CÉGEP','Université'=>'Université','Bureau'=>'Bureau');
$SessionReq = "SELECT IDSession, Saison, Annee FROM session WHERE 1 ORDER BY IDSession DESC LIMIT 0,4";
$SQL->SELECT($SessionReq);
$Saison = array();
while($Rep = $SQL->FetchArray()){
	$Saison[$Rep[0]]=$Rep[1].substr($Rep[2],2);
}
$MainOutput->inputselect('Session',$Saison,$Info['Session'],'Session');
$MainOutput->inputselect('Status',$Status,$Info['Status'],'Status');
$MainOutput->inputtext('SalaireB','Salaire Bureau','5',$Info['SalaireB']);
$MainOutput->inputtext('SalaireRE','Salaire Responsable*','5',$Info['SalaireRE']);
$MainOutput->inputtext('SalaireR','Salaire Responsable','5',$Info['SalaireR']);
$MainOutput->inputtext('SalaireM','Salaire Moniteur','5',$Info['SalaireM']);
$MainOutput->inputtext('SalaireA','Salaire Assistant','5',$Info['SalaireA']);
$MainOutput->flag('Cessation',$Info['Cessation']);
$MainOutput->textarea('Raison','Raison du départ','25','2',$Info['Raison']);



$MainOutput->formsubmit('Ajouter / Modifier');
echo $MainOutput->send(1);

?>
