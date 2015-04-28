<?PHP
$MainOutput = new html();
$MainOutput->addform('Ajouter / Modifier une famille','test.php');
$MainOutput->inputhidden_env('Controller','family');



if($family->IDFamily<>0){
    $MainOutput->inputhidden_env('FORMIDFamily',$family->IDFamily);
    $MainOutput->inputhidden_env('Action','PUT');
}else{
    $MainOutput->inputhidden_env('Action','POST');
}

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
$MainOutput->addtexte('Quel était le nom de votre enfant dans le cours','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->inputtext('NomEnfant1',$course->Level->Niveau." au ".$course->Period->Pool->Nom,'28',$family->Address);


$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
$MainOutput->addtexte('Est-ce que d\'autres membres de votre famille suivent des cours avec Québec Natation?','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();



$MainOutput->OpenRow();

$MainOutput->OpenCol();
$MainOutput->addtexte('Numéro cours','Titre');
$MainOutput->CloseCol();

$MainOutput->OpenCol();
$MainOutput->addtexte('Prénom','Titre');
$MainOutput->CloseCol();


$MainOutput->CloseRow();




$MainOutput->OpenRow();

$MainOutput->OpenCol();
$MainOutput->addoutput("<input type='text' size=5 name='FORM_NoCoursEnfant2'>");
$MainOutput->CloseCol();

$MainOutput->OpenCol();
$MainOutput->addoutput("<input type='text'  name='FORM_PrenomEnfant2'>");
$MainOutput->CloseCol();


$MainOutput->CloseRow();


$MainOutput->OpenRow();

$MainOutput->OpenCol();
$MainOutput->addoutput("<input type='text' size=5 name='FORM_NoCoursEnfant3'>");
$MainOutput->CloseCol();

$MainOutput->OpenCol();
$MainOutput->addoutput("<input type='text'  name='FORM_PrenomEnfant3'>");
$MainOutput->CloseCol();


$MainOutput->CloseRow();


$MainOutput->OpenRow();

$MainOutput->OpenCol();
$MainOutput->addoutput("<input type='text' size=5 name='FORM_NoCoursEnfant4'>");
$MainOutput->CloseCol();

$MainOutput->OpenCol();
$MainOutput->addoutput("<input type='text'  name='FORM_PrenomEnfant4'>");
$MainOutput->CloseCol();


$MainOutput->CloseRow();






$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
$MainOutput->addtexte('----------Information sur votre famille--------------------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->inputtext('Name','Nom de famille','28',$family->Name);
$MainOutput->inputtext('Address','Adresse','28',$family->Address);
$MainOutput->inputtext('City','Ville','28',$family->City);
$MainOutput->inputtext('PostalCode','Code postal','7',$family->PostalCode);
$MainOutput->inputphone('Telephone','Numéro Téléphone',$family->Telephone);
$MainOutput->inputtext('Email','Courriel',28,$family->Email);

$MainOutput->formsubmit('Ajouter / Modifier');
echo $MainOutput->send(1);

?>
