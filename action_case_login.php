<?PHP
if(isset($_POST['FORMIDEmploye']) && isset($_POST['FORMNAS'])){
	$Req = "SELECT NAS FROM employe WHERE IDEmploye =".$_POST['FORMIDEmploye'];
	$SQL->SELECT($Req);
	$Rep = $SQL->FetchArray();
	if(substr($Rep[0],6,3)==$_POST['FORMNAS']){
		setcookie("IDEmploye", $_POST['FORMIDEmploye'], time()+60*60*24*180);
		setcookie("Cie", $_POST['FORMCIE'], time()+60*60*24*180);
		$emplinfo =	get_info('employe', $_POST['FORMIDEmploye']);
		setcookie("Status", $emplinfo['Status'], time()+60*60*24*180);
	?>
		<script>
		window.location = 'index.php';
		</script>
		<?PHP

	}else{
		$WarnOutput->AddTexte('Mauvais identifiants','Warning');
	}
}else{
	$WarnOutput->AddTexte('Veuillez entrer vos identifiants','Warning');
}

?>