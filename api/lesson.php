<?php
include('../rnord/mysql_class.php');
include('../func_date.php');
$sql = new SqlClass();
$sql2 = new SqlClass();
function wd_remove_accents($str, $charset = '')
{
    $str = htmlentities($str, ENT_NOQUOTES, 'iso-8859-1');

    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

    return $str;
}

$days = array(
    0 => 'SUNDAY',
    1 => 'MONDAY',
    2 => 'THUESDAY',
    3 => 'WEDNESDAY',
    4 => 'THURSDAY',
    5 => 'FRIDAY',
    6 => 'SATURDAY',
);

// Getting current session
$req = "SELECT IDSession, Saison, Annee FROM session WHERE Active";
$sql->query($req);

while ($rep = $sql->FetchArray()) {
    $current_session_id = $rep['IDSession'];
    $current_session_id_saison = $rep['Saison'];
    $current_session_id_Annee = $rep['Annee'];
}
// Getting all lessons


$output = array();

$req = "SELECT periode.IDPeriode as IDPeriode, IDPiscine, Jour, Start FROM periode WHERE IDSession = " . $current_session_id . " GROUP BY IDPiscine, Jour, Start";
$sql->query($req);

while ($rep = $sql->FetchArray()) {
    $date = get_date($rep['Start']);
    $date_string = $date['G'] . "h";
    if ($date["i"] != 0) {
        $date_string .= $date["i"];
    }
    $req_2 = "SELECT IDCours FROM cours WHERE IDPeriode =".$rep['IDPeriode'];
    $sql2->query($req_2);
    while($rep_2 = $sql2->FetchArray()){
        $output[$rep_2['IDCours']] = array('IDPeriode' => $rep['IDPeriode'], 'IDPiscine' => $rep['IDPiscine'], 'day' => $days[$rep['Jour']], 'time' => $date_string);
    }
}

foreach ($output as $IDCours => $Items) {
    //Session identificateur
    $output[$IDCours]['session'] = $current_session_id_saison.substr($current_session_id_Annee,-2);

    // Piscine Name
    $req = "SELECT Nom FROM piscine WHERE IDPiscine =" . $Items['IDPiscine'];
    $sql->query($req);

    while ($rep = $sql->FetchArray()) {
        $output[$IDCours]['pool'] = wd_remove_accents($rep['Nom']);
    }

    // Moniteur

    $req = "SELECT Nom, Prenom FROM employe JOIN ressource on employe.IDEmploye = ressource.IDEmploye WHERE ressource.Role = \"M\" and IDCours = " . $IDCours;
    $sql->query($req);

    while ($rep = $sql->FetchArray()) {
        $output[$IDCours]['instructor'] = wd_remove_accents($rep['Prenom']) . " " . wd_remove_accents($rep['Nom']);
    }

    //Niveau

    $req = "SELECT Niveau FROM niveau join cours on niveau.IDNiveau = cours.IDNiveau WHERE IDCours = " . $IDCours;
    $sql->query($req);

    while ($rep = $sql->FetchArray()) {
        $output[$IDCours]['level'] = wd_remove_accents($rep['Niveau']);
    }

    unset($output[$IDCours]['IDPiscine']);
    unset($output[$IDCours]['IDPeriode']);
}
print(json_encode($output));

