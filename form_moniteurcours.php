<?PHP


if(!isset($_GET['IDCours']) OR $_GET['IDCours']==0){
	$_GET['IDCours']=NULL;
	$Monit = get_responsable($_GET['IDPeriode']);
	if(!isset($Monit[1]))
	$Monit[1] = array('IDEmploye'=>0,'Role'=>'R','Salaire'=>0);
}else{
	$InfoC = get_info('cours',$_GET['IDCours']);
	$_GET['IDPeriode'] = $InfoC['IDPeriode'];
	$Monit = get_monit($_GET['IDCours']);
	if(!isset($Monit[1]))
	$Monit[1] = array('IDEmploye'=>0,'Role'=>'M','Salaire'=>0);
}

$Day = get_day_list();
if(!is_null($_GET['IDCours'])){
$MainOutput->AddForm('Modifier les ressources');
$MainOutput->Inputhidden_env('Action','Modifie_Cours');
$MainOutput->Inputhidden_env('AllSession',$_GET['AllSession']);
$MainOutput->Inputhidden_env('IDCours',$_GET['IDCours']);
}
else{
$MainOutput->OpenTable();
$MainOutput->OpenRow();
$MainOutput->OpenCol();
	$MainOutput->AddTexte('<div align=center>Modifier les ressources</div>','Titre');
$MainOutput->Closecol();
$MainOutput->CloseRow();
}
	$Rep = get_info('periode',$_GET['IDPeriode']);
	$Rep2 = get_info('piscine',$Rep['IDPiscine']);
		$sh = intval($Rep['Start']/60/60);
		$sm = bcmod($Rep['Start'],3600)/60;
		if($sm==0)
			$sm="";
	$Periodes = "<b>".$Rep2['Nom']."</b> - ".$Day[intval($Rep['Jour'])]." - ".$sh."h".$sm;
	
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
$MainOutput->AddTexte($Periodes,'Titre');
$MainOutput->br();
$MainOutput->CloseCol();
$MainOutput->CloseRow();
if(!is_null($_GET['IDCours'])){
	$C = get_active('niveau',1,'Rank');
	$Cours = array();
	foreach($C as $v){
		$Cours[$v[0]] = $v['Niveau'];
	}
	$MainOutput->InputSelect('IDNiveau',$Cours,$InfoC['IDNiveau'],'Niveau');
	$MainOutput->InputText('Multiplicateur',NULL,4,$InfoC['Multiplicateur']);
}else{
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte('Responsable','Titre');

$MainOutput->CloseCol();
$MainOutput->CloseRow();

}

$str = get_periode_string($_GET['IDPeriode']);
$Xstr = explode(',',$str);
if(!is_null($_GET['IDCours']))
	$MainOutput->FormSubmit('Modifier le cours');
else
	$MainOutput->CloseTable();

$MainOutput->addtexte(
'------------------------------------------------------------------------------------------------');
$MainOutput->br();
if(!isset($_GET['IDCours']) OR $_GET['IDCours']=="")
	$MainOutput->AddLink('index.php?Action=AddRessource&IDCours=NULL&IDPeriode='.$_GET['IDPeriode'].'&AllSession='.$_GET['AllSession'],'<img src=images/insert.png border=0>');
else
	$MainOutput->AddLink('index.php?Action=AddRessource&IDCours='.$_GET['IDCours'].'&IDPeriode='.$_GET['IDPeriode'].'&AllSession='.$_GET['AllSession'],'<img src=images/insert.png border=0>');
$MainOutput->AddForm('Ressource Principale');
$MainOutput->InputHidden_Env('Action','ModifCours');
$MainOutput->InputHidden_Env('AllSession',$_GET['AllSession']);
$MainOutput->InputHidden_Env('IDRessource',1);
$MainOutput->InputHidden_Env('IDPeriode',$_GET['IDPeriode']);
$MainOutput->InputHidden_Env('IDCours',$_GET['IDCours']);

$Req = "SELECT IDEmploye, Nom, Prenom FROM employe WHERE !Cessation ORDER BY Nom ASC, Prenom ASC";
$Role = array('RE'=>'Responsable Étoile','R'=>'Responsable','M'=>'Moniteur','A'=>'Assistant','B'=>'Bureau');

$MainOutput->InputSelect('IDEmploye',$Req,$Monit[1]['IDEmploye'],'Employe');
$MainOutput->InputSelect('Role',$Role,$Monit[1]['Role']);
$MainOutput->InputText('Salaire','Salaire',4,$Monit[1]['Salaire']);
$MainOutput->FormSubmit('Modifier');

$i=1;

while($i<Count($Monit)){
//AJOUTER LES MARDE DE HIDDEN ENV
	$MainOutput->addtexte('------------------------------------------------------------------------------------------------');
	$MainOutput->br();
	$j= $i+1;
	$MainOutput->AddLink('index.php?Action=RemoveRessource&IDCours='.$_GET['IDCours'].'&IDPeriode='.$_GET['IDPeriode'].'&AllSession='.$_GET['AllSession'].'&NoRessource='.$j,'<img src=images/delete.png border=0>');
	$MainOutput->AddForm('Ressource assistante');
	$MainOutput->InputHidden_Env('Action','ModifCours');
	
	$MainOutput->InputHidden_Env('AllSession',$_GET['AllSession']);
	$MainOutput->InputHidden_Env('IDPeriode',$_GET['IDPeriode']);
	$MainOutput->InputHidden_Env('IDCours',$_GET['IDCours']);
	
	
	$MainOutput->InputHidden_Env('IDRessource',$j);
	$MainOutput->InputSelect('IDEmploye',$Req,$Monit[$j]['IDEmploye'],'Employe');
	$MainOutput->InputSelect('Role',$Role,$Monit[$j]['Role']);
	$MainOutput->InputText('Salaire','Salaire',4,$Monit[$j]['Salaire']);
	$MainOutput->FormSubmit('Modifier');
	$i++;
}

echo $MainOutput->Send(1);
?>
