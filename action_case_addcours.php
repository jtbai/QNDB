<?PHP
$Last1 = get_last('cours');
if(!isset($Last1['IDCours']))
	$Last1['IDCours']=0;

$SQL2 = new sqlclass();
$Couple = "";
$First = "";
$Exist = "";
foreach($_POST['FORMIDPeriode'] as $v){
	$Req2 = "SELECT IDPeriode from cours where IDPeriode = ".$v." and IDNiveau = ".$_POST['FORMNiveau'];
	$SQL2->SELECT($Req2);
	if($SQL2->NumRow())
		$Exist = "Certaines périodes avaient déjà le niveau sélectionné. Celles-ci ont été sautées";
	else{
		$First = $First.",(".$v.",46)";
		$Info = get_info('periode',$v);
		$Req = "SELECT IDPeriode FROM periode WHERE Start=".$Info['Start']." AND IDPiscine=".$Info['IDPiscine']." AND Jour=".$Info['Jour']." AND IDSession=".$_ACTIVE['Session'];
		$SQL->SELECT($Req);
		while($Rep = $SQL->FetchArray()){
			$Couple = $Couple.",(".$Rep[0].",".$_POST['FORMNiveau'].")";
		}
	}
	
}

if($_POST['FORMNiveau']==46)
	$Req = "INSERT INTO cours(`IDPeriode`,`IDNiveau`) VALUES".substr($First,1);
else
	$Req = "INSERT INTO cours(`IDPeriode`,`IDNiveau`) VALUES".substr($Couple,1);

$SQL->INSERT($Req);
$Req = "SELECT * FROM cours WHERE IDCours > ".$Last1['IDCours']." ORDER BY IDPeriode ASC";
$SQL->SELECT($Req);


$Couple ="";
while($Rep = $SQL->FetchArray()){
	if($_POST['FORMNiveau']==46)
		$Couple = $Couple.",(".$Rep['IDCours'].",".$Rep['IDPeriode'].",1,'B')";
	else
		$Couple = $Couple.",(".$Rep['IDCours'].",".$Rep['IDPeriode'].",1,'M')";
}
$Req = "INSERT INTO ressource(`IDCours`,`IDPeriode`,`NoRessource`,`Role`) VALUES".substr($Couple,1);
$SQL->INSERT($Req);

if($Exist<>"")
	$WarnOutput->AddTexte($Exist."<br>",'Warning');
?>