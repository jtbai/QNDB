<?PHP
$MainOutput->AddTexte('Session active','Titre');
$MainOutput->AddLink('index.php?Action=Session','<img src=images/insert.png border=0>');
$MainOutput->br();
$List = get_active('session',1,'IDSession');
foreach($List as $v){
	$MainOutput->AddPic('images/activated.png','border=0');
	$MainOutput->AddTexte($v['Saison'].substr($v['Annee'],2,2),'Titre');
	$MainOutput->br();
}

$MainOutput->AddTexte('Liste des session non actives','Titre');
$MainOutput->br();
$List = get_active('session',0,'IDSession');
foreach($List as $v){
	$MainOutput->AddLink('index.php?Action=Activate&PostBack=Session&Table=Session&ID='.$v['IDSession'],'<img src=images/desactivated.png border=0>');
	$MainOutput->AddTexte($v['Saison'].substr($v['Annee'],2,2),'Titre');
		$MainOutput->br();
}
echo $MainOutput->Send(1);
?>