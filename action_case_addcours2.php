<?PHP
$Last1 = get_last('cours');
if(!isset($Last1['IDCours']))
	$Last1['IDCours']=0;

$Couple = "";

$Ar = get_similar_periode($_POST['FORMPeriode'],TRUE);
$Req2 = "SELECT IDNiveau, Niveau FROM niveau WHERE Active ORDER BY Rank ASC";
$SQL2 = new sqlclass();
$SQL2->SELECT($Req2);
$SQL3 = new Sqlclass();
while($Rep2 = $SQL2->FetchArray()){
	foreach($Ar as $k=>$v){
		if(isset($_POST['FORMNiveau'][$Rep2[0]])){
			
			$Req3 = "SELECT IDPeriode FROM cours WHERE IDNiveau =".$Rep2[0]." AND IDPeriode=".$k;
			$SQL3->SELECT($Req3);
			if($SQL3->NumRow()){
				$WarnOutput->AddTexte('Le cours '.$Rep2[1].' existe déjà dans la période donnée<br><br>','Warning');
				break;
			}
			else
				$Couple .= ",('".$k."','".$Rep2[0]."')";
			
		}
	}
}

$Req = "INSERT INTO cours(`IDPeriode`,`IDNiveau`) VALUES".substr($Couple,1);
$SQL->INSERT($Req);

$Req = "SELECT * FROM cours WHERE IDCours > ".$Last1['IDCours']." ORDER BY IDPeriode ASC";
$SQL->SELECT($Req);


$Couple ="";
while($Rep = $SQL->FetchArray()){
	$Couple = $Couple.",(".$Rep['IDCours'].",".$Rep['IDPeriode'].",1,'M')";
}
$Req = "INSERT INTO ressource(`IDCours`,`IDPeriode`,`NoRessource`,`Role`) VALUES".substr($Couple,1);
$SQL->INSERT($Req);
?>