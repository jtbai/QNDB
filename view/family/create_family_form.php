<?php
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
	$MainOutput->addtexte('----------Personnel------------------------------','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$MainOutput->inputtext('Name','Nom','28',$family->Name);
$MainOutput->inputtext('Address','Adresse','28',$family->Address);
$MainOutput->inputtext('City','Ville','28',$family->City);
$MainOutput->inputtext('PostalCode','Code postal','7',$family->PostalCode);
$MainOutput->inputphone('Telephone','Numéro Téléphone',$family->Telephone);
$MainOutput->inputtext('Email','Courriel',28,$family->Email);

$MainOutput->formsubmit('Ajouter / Modifier');
echo $MainOutput->send(1);

?>
