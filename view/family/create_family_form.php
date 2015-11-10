<?php
$ViewOutput = new html();
$ViewOutput->addform('Ajouter / Modifier une famille','index.php');
$ViewOutput->inputhidden_env('Controller','family');



if($family->IDFamily<>0){
    $ViewOutput->inputhidden_env('FORMIDFamily',$family->IDFamily);
    $ViewOutput->inputhidden_env('Action','PUT');
}else{
    $ViewOutput->inputhidden_env('Action','POST');
}

$ViewOutput->OpenRow();
$ViewOutput->OpenCol('100%',2);
$ViewOutput->addtexte('----------Personnel------------------------------','Titre');
$ViewOutput->CloseCol();
$ViewOutput->CloseRow();

$ViewOutput->inputtext('Name','Nom','28',$family->Name);
$ViewOutput->inputtext('Address','Adresse','28',$family->Address);
$ViewOutput->inputtext('City','Ville','28',$family->City);
$ViewOutput->inputtext('PostalCode','Code postal','7',$family->PostalCode);
$ViewOutput->inputphone('Telephone','Numéro Téléphone',$family->Telephone);
$ViewOutput->inputtext('Email','Courriel',28,$family->Email);

$ViewOutput->formsubmit('Ajouter / Modifier');
echo $ViewOutput->send(1);
