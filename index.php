<?PHP
ini_set("default_charset", "iso-8859-1");
ini_set("display_errors", TRUE);
setlocale("LC_TIME","fr_CA");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//include de cookie et de fonctions
;
include('func_info.php');
include('func_horaire.php');
include('func_niveau.php');
include('func_plan.php');
include('func_session.php');
include('func_date.php');
include('func_periode.php');
include('func_employe.php');
include('func_paye.php');
//

//print_r($_REQUEST);
if (isset($_POST['FORMCIE'])) {

    if ($_POST['FORMCIE'] == "RNORD")
        include('rnord/mysql_class.php');
    if ($_POST['FORMCIE'] == "RSUD")
        include('rsud/mysql_class.php');
    $SQL = New SqlClass;
} elseif (isset($_COOKIE['Cie'])) {

    if ($_COOKIE['Cie'] == "RNORD")
        include('rnord/mysql_class.php');
    if ($_COOKIE['Cie'] == "RSUD")
        include('rsud/mysql_class.php');
    $SQL = New SqlClass;
    $AS = get_active('session', 1, 'IDSession');
    foreach ($AS as $v)
        $_ACTIVE['Session'] = $v['IDSession'];

}


include('class_html.php');

//Inclusion of MVC model
include('./mvc_loader.php');

$MainOutput = New HTML();
$WarnOutput = New HTML();
$MessageOutput = New HTML();
$MenuOutput = New HTML();
if (isset($_GET['ToPrint']) AND $_GET['ToPrint'] == "TRUE") {
    $ToPrint = TRUE;
} else {
    $ToPrint = FALSE;
}


// Get active session

if (isset($_GET['Action']))
    $Action = $_GET['Action'];
elseif (isset($_POST['Action']))
    $Action = $_POST['Action'];
if (isset($Action))
    include('action.php');
if (!isset($_GET['ToPrint']))
    $_GET['ToPrint'] = FALSE;
if (isset($_POST['ToPrint']) AND $_POST['ToPrint'])
    $ToPrint = TRUE;
?>
<html>
<head>
    <title>Logiciel de gestion Québec Natation</title>
    <link rel="STYLESHEET" type="text/css" href="style.css">
    <link rel="STYLESHEET" type="text/css" href="horaire.css">

</head>
<?PHP

// va chercher les valeur de section pass� par get ou post
if (isset($_GET['Section']))
    $Section = $_GET['Section'];
elseif (isset($_POST['Section']))
    $Section = $_POST['Section'];
elseif (!isset($Section))
    $Section = "Accueil";

if (!isset($_COOKIE['IDEmploye']))
    $Section = "Accueil";
//si c'est section est pas sett� nulle part, c'est qu'on veut aller a l'accueil	

//D�claration de variable de contenu

?>

<body>


<table>
    <tr>


        <?PHP

        if (!$ToPrint) {
            echo "	<td width=200 valign=TOP>
		<img src=carlos.gif width=200 height=1>";
            include('menu.php');
            if ($WarnOutput->output <> "") {
                echo "<br><br>";
                echo "<span class=Titre>Notes</span>";
                echo "<br>";
                echo $WarnOutput->Send(1);
                echo "</td>";
            }
        }
        ?>
        <td width=600 valign=TOP><?PHP
            echo $MessageOutput->send(1);
          include('section.php');
          include('route.php');

		?></td>
    </tr>
</table>
</body>
</html>