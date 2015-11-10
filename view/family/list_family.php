<?php
$ViewOutput = new html();
$ViewOutput->addlink('?Controller=family&Action=CREATE', 'Ajouter une famille');
$ViewOutput->br();
$ViewOutput->br();

$ViewOutput->opentable();

$ViewOutput->openrow();

$ViewOutput->opencol(25);
$ViewOutput->addtexte(' ');
$ViewOutput->closecol();

$ViewOutput->opencol();
$ViewOutput->addtexte('Nom', 'Titre');
$ViewOutput->closecol();

$ViewOutput->opencol();
$ViewOutput->addtexte('Adresse', 'Titre');
$ViewOutput->closecol();

$ViewOutput->opencol();
$ViewOutput->addtexte('Téléphone', 'Titre');
$ViewOutput->closecol();

$ViewOutput->closerow();

foreach ($families as $ID => $Values) {

    $ViewOutput->openrow();

    $ViewOutput->opencol(25);
    $ViewOutput->addpic('./images/edit.png', "", "?Controller=family&Action=EDIT&ID=" . $ID);
    $ViewOutput->closecol();

    $ViewOutput->opencol();
    $ViewOutput->addtexte($Values->Name);
    $ViewOutput->closecol();

    $ViewOutput->opencol();
    $ViewOutput->addtexte($Values->Address);
    $ViewOutput->closecol();

    $ViewOutput->opencol();
    $ViewOutput->addphone($Values->Telephone, true);
    $ViewOutput->closecol();

    $ViewOutput->closerow();


}
echo $ViewOutput->send(1);
