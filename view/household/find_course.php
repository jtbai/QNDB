<?PHP
$MainOutput = new html();
$MainOutput->addform('Entrez le numéro du cours - donné par le responsable de piscine','test.php');
$MainOutput->inputhidden_env('Controller','household');
$MainOutput->inputhidden_env('Action','POST');
$MainOutput->inputtext('IDCours','Numéro du Cours',8);
$MainOutput->formsubmit('Rechercher');
echo $MainOutput->send(1);
?>
