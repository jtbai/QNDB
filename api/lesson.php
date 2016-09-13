<?php
include('rnord/mysql_class.php');
$sql = new SqlClass();

#Getting current session
$req = "SELECT IDSession, Saison, Annee FROM session WHERE Active";
$sql->query($req);

while($rep = $sql->FetchArray()){
    $current_session_id = $rep['SessionID'];
    $current_session_id_saison = $rep['Saison'];
    $current_session_id_Annee = $rep['Annee'];
}
#Getting all lessons


$output = [];

$req = "SELECT min(IDPeriode) as IDPeriode, IDPiscine, Jour, Start FROM periode GROUPED BY IDPiscine, Jour, Start WHERE IDSession = ".$current_session_id;
$sql->query($req);
while($rep = $sql->FetchArray()){
    $output[$rep['IDPeriode']] = ['IDPiscine'=>$rep['IDPiscine'],'Jour'=>$rep['Jour'],$rep['Start'] ];
}

print_r($output);