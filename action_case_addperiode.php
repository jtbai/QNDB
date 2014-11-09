<?PHP

// il faudrait ajouter de quoi ici pour vérifier qu'il n'y pas pas déjà un cours du même niveau de fait
// question de pas se ramasser avec 300 niveau 2 exemple

$Last1 = get_last('periode');
if(!isset($Last1['IDPeriode']))
	$Last1['IDPeriode']=0;
$Date = mktime(0,0,0,$_POST['FORMStartDate4'],$_POST['FORMStartDate5'],$_POST['FORMStartDate3']);
$TimeIni = $_POST['FORMStartTime2']*3600+$_POST['FORMStartTime1']*60;
$DateIni = $Date;
if($_POST['FORMDuree2']==""){
	$Duration = intval($_POST['FORMDuree']);
}else{
	$Duration = intval($_POST['FORMDuree2']);
}
$NBP = floor(intval($_POST['FORMNBP']));
$NBC = floor(intval($_POST['FORMNBC']));
$c=0;
$PInfo = get_info('piscine',$_POST['FORMIDPiscine']);
$JourN = get_day_list('court');
$MoisN = get_month_list('court');
$Allonge = "";
$Deja = "";
$SemaineJustCree = 0;
while($c<$NBC){
	$p=0;

		
	
	$Time = $TimeIni;
	$End = $TimeIni;
	while($p<$NBP){
		$Time = $End;
		$End = $Time + $Duration*60; 
		$SQL->SELECT("SELECT IDPeriode, max(Semaine) as MaxSemaine FROM periode WHERE IDPiscine=".$_POST['FORMIDPiscine']." AND Jour =".date("w",$Date)." AND Start=".$Time." AND IDSession = ".$_ACTIVE['Session']." GROUP BY IDPiscine, Jour, Start, IDSession");
		$NomPiscine = $PInfo['Nom'];
		$NomJour = $JourN[date("w",$Date)];
		$Start = floor($Time/3600)."h";
		if(bcmod($Time/3600,1)>0)
			$Start .= bcmod($Time/3600,1)*60;
		$Rep = $SQL->FetchArray();
		if(!is_null($Rep['MaxSemaine'])){
			if($Rep['MaxSemaine']<get_last_sunday(0,$Date)){
				$SQL->INSERT("INSERT INTO periode(`IDPiscine`,`Semaine`,`Jour`,`Start`,`End`,`IDSession`) VALUES(".$_POST['FORMIDPiscine'].",".get_last_sunday(0,$Date).",".date("w",$Date).",".$Time.",".$End.",".$_ACTIVE['Session'].")");

				if($Rep['MaxSemaine']<>$SemaineJustCree)
					$Allonge .= $NomJour.'. '.$Start.' à '.$NomPiscine.' <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- ('.date('j',$Date).' '.$MoisN[intval(date('n',$Date))].') <br>';
				else
					$SemaineJustCree = get_last_sunday(0,$Date);
			}else{
				$Deja .= $NomJour.'. '.$Start.' à '.$NomPiscine.' <br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-  ('.date('j',$Date).' '.$MoisN[intval(date('n',$Date))].') <br>';
			}

			$p++;
		}else{
			$SQL->INSERT("INSERT INTO periode(`IDPiscine`,`Semaine`,`Jour`,`Start`,`End`,`IDSession`) VALUES(".$_POST['FORMIDPiscine'].",".get_last_sunday(0,$Date).",".date("w",$Date).",".$Time.",".$End.",".$_ACTIVE['Session'].")");
			$p++;
			$SemaineJustCree = get_last_sunday(0,$Date);
		}
	}
	for( $i=0;$i<=6;$i++){
		$Date += get_day_length($Date);
	}
	
	$c++;
}
$Req = "SELECT * FROM periode WHERE IDPeriode > ".$Last1['IDPeriode']." ORDER BY IDPeriode ASC";
$SQL->SELECT($Req);


$Couple ="";
while($Rep = $SQL->FetchArray()){
	$Couple = $Couple.",(".$Rep['IDPeriode'].",NULL,1,'R')";
}
$Req = "INSERT INTO ressource(`IDPeriode`,`IDCours`,`NoRessource`,`Role`) VALUES".substr($Couple,1);
$SQL->INSERT($Req);
if($Couple<>"")
	$WarnOutput->AddTexte('Période(s) ajoutée(s)','warning');
if($Deja<>""){
$WarnOutput->br();
$WarnOutput->Addtexte('Ces périodes existent déjà','Warning');
$WarnOutput->br();
$WarnOutput->AddTexte($Deja,'Warning');
}
if($Allonge<>""){
$WarnOutput->br();
$WarnOutput->Addtexte('Ces périodes ont été allongées','Warning');
$WarnOutput->br();
$WarnOutput->AddTexte($Allonge,'Warning');
}
	
$Section = "Periode";
?>
