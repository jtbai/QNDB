<?PHP
if(!isset($_COOKIE['Cie']) || $_COOKIE['Cie']=="RNORD")
	$MenuOutput->AddPic('images/logo.jpg');
else
	$MenuOutput->AddPic('images/logorsud.jpg');

$MenuOutput->br();
if(isset($_COOKIE['Status']) AND $_COOKIE['Status']=="Bureau"){

$MenuOutput->AddTexte('Gestion des cours de natation','Titre');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=Piscine','Gestion des piscines');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=Session','Gestion des sessions');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=Niveau','Gestion des niveaux');
$MenuOutput->br(2);
$MenuOutput->AddTexte('Gestion des employ�s','Titre');
$MenuOutput->br();

$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=EmployeList','Liste d\'employ�');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=Add_Qualif','Ajouter une Qualification');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=Message','Messages � tous');
$MenuOutput->br(2);
$MenuOutput->AddTexte('Gestion de l\'horaire','Titre');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=Periode','Gestion des p�riodes de cours');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=Cours','Gestion des cours');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=Inscripteur','Gestion des inscripteurs');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=Missing_Monit','Gestion des absences');
$MenuOutput->br(2);
$MenuOutput->AddTexte('Feuille de temps','Titre');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=Generate_Timesheet','Faire la feuille de temps');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=Display_Timesheet','Afficher la feuille de temps');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=Calcul_Ferie','Calculer un f�ri�');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=Generate_TimesheetPiscine','Feuille de temps piscine');
$MenuOutput->br(2);
$MenuOutput->AddTexte('Modification SuperAdmin','Titre');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=Modifie_Periode','Modifier une p�riode');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=Inspect_Plan','V�rifier les plan');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=Parse_Responsable','Mettre des responsables');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section=Unlinked','Ressources non-link�es');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section='.$Section.'&Action=UpdateSalaire','Mettre les salaires sp�ciaux');
$MenuOutput->br();
$MenuOutput->AddPic('images/cat.png');
$MenuOutput->AddLink('index.php?Section='.$Section.'&Action=Sync_Salaire','Mettre les salaires qualifications');
$MenuOutput->br();
$MenuOutput->AddLink('index.php?Action=Delog','Se D�connecter');
$MenuOutput->br();
}else{
$MenuOutput->AddLink('index.php?Section=Mon_Horaire','Mon Horaire');
$MenuOutput->br();
$MenuOutput->AddLink('index.php?Section=Mes_Info','Mes Informations');
$MenuOutput->br();
$MenuOutput->AddLink('index.php?Section=Messages','Mes Messages');
$MenuOutput->br();
$MenuOutput->AddLink('index.php?Action=Delog','Se D�connecter');
$MenuOutput->br();
}
echo $MenuOutput->Send(1);

?>