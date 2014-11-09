<?PHP
$MainOutput->AddTexte('Liste des piscines actives','Titre');
$MainOutput->AddLink('index.php?Section=FormPiscine','<img src=images/insert.png border=0>');
$MainOutput->br();
$List = get_active('piscine');
foreach($List as $v){
	$MainOutput->AddLink('index.php?Action=Desactivate&PostBack=Piscine&Table=Piscine&ID='.$v['IDPiscine'],'<img src=images/activated.png border=0>');
	$MainOutput->AddTexte($v['Nom'],'Titre');
	$MainOutput->AddLink('index.php?Section=FormPiscine&IDPiscine='.$v['IDPiscine'],'<img src=images/edit.png border=0>');
	$MainOutput->br();
	$MainOutput->AddPhone($v['Tel']);
	$MainOutput->br();
	$MainOutput->AddTexte($v['Adresse']);
	$MainOutput->br();
}

$MainOutput->AddTexte('Liste des piscines non actives','Titre');
$MainOutput->br();
$List = get_active('piscine',0);
foreach($List as $v){
	$MainOutput->AddLink('index.php?Action=Activate&PostBack=Piscine&Table=Piscine&ID='.$v['IDPiscine'],'<img src=images/desactivated.png border=0>');
	$MainOutput->AddTexte($v['Nom'],'Titre');
	$MainOutput->br();
}
echo $MainOutput->Send(1);
?>