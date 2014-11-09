<?PHP
$MainOutput->AddTexte('Liste des niveaux actifs','Titre');
$MainOutput->AddLink('index.php?Section=FormNiveau','<img src=images/insert.png border=0>');
$MainOutput->br();
$List = get_active('niveau',1,'Rank');
foreach($List as $v){
	$MainOutput->AddLink('index.php?Action=Desactivate&PostBack=Niveau&Table=Niveau&ID='.$v['IDNiveau'],'<img src=images/activated.png border=0>');
	$MainOutput->AddLink('index.php?Action=MoveNiveau&PostBack=Niveau&Direction=down&IDNiveau='.$v['IDNiveau'],'<img src=images/up.png border=0>');
	$MainOutput->AddLink('index.php?Action=MoveNiveau&PostBack=Niveau&Direction=up&IDNiveau='.$v['IDNiveau'],'<img src=images/down.png border=0>');

	$MainOutput->AddTexte($v['Niveau'],'Titre');
		$MainOutput->AddTexte("[".$v['Code']."]",'Titre');
	$MainOutput->AddLink('index.php?Section=FormNiveau&IDNiveau='.$v['IDNiveau'],'<img src=images/edit.png border=0>');
	$MainOutput->br();

}

$MainOutput->AddTexte('Liste des niveaux non actifs','Titre');
$MainOutput->br();
$List = get_active('niveau',0,'IDNiveau');
foreach($List as $v){
	$MainOutput->AddLink('index.php?Action=Activate&PostBack=Niveau&Table=Niveau&ID='.$v['IDNiveau'],'<img src=images/desactivated.png border=0>');
	$MainOutput->AddTexte($v['Niveau'],'Titre');
	$MainOutput->AddTexte("[".$v['Code']."]",'Titre');
		$MainOutput->br();
}
echo $MainOutput->Send(1);
?>