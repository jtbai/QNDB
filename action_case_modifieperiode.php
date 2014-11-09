<?PHP
$SQL2 = new sqlclass();
	$Ar = get_similar_periode($_POST['IDPeriode'],TRUE);
	$CoupleIni = "";
	foreach($Ar as $k=>$v){
			$CoupleIni .= ",".$k;
	}
$PeriodeIniInfo = get_info('periode',$_POST['IDPeriode']);
$StartIni = $PeriodeIniInfo['Start'];
$EndIni = $PeriodeIniInfo['End'];

if($_POST['FORMEndTime1']=="")
	$_POST['FORMEndTime1']=0;
if($_POST['FORMStartTime1']=="")
	$_POST['FORMStartTime1']=0;

$ACT = "";
if($_POST['FORMEndTime2']=="" or $_POST['FORMEndTime2']==0 OR $_POST['FORMStartTime2']==0 OR $_POST['FORMStartTime2']==""){
	//cas où il manque soit l'heure de début et/ou de fin
	$ACT = "DELETE";
}else{
	//on cheke les overlap
	$NStart = 60*$_POST['FORMStartTime1']+$_POST['FORMStartTime2']*3600;
	$NEnd = 60*$_POST['FORMEndTime1']  +$_POST['FORMEndTime2']*3600;
	$Req = "SELECT IDPeriode FROM periode WHERE ((Start>=".$NStart." AND End<=".$PeriodeIniInfo['Start'].") OR (End<=".$NEnd." AND Start>=".$PeriodeIniInfo['End'].")) AND Jour=".$PeriodeIniInfo['Jour']." AND IDPiscine=".$PeriodeIniInfo['IDPiscine']." AND IDSession=".$PeriodeIniInfo['IDSession'];
	$SQL->SELECT($Req);
	if($SQL->NumRow()==0)
		$OverLap = False;
	else
		$OverLap=TRUE;
	if(!$OverLap){
	$ACT = "UPDATE";

		//trouver les périodes avant qui doivent ajuster leurs heures
		$Req = "SELECT IDPeriode FROM periode WHERE IDPiscine=".$PeriodeIniInfo['IDPiscine']." AND IDSession=".$PeriodeIniInfo['IDSession']." AND End=".$PeriodeIniInfo['Start']." AND Jour=".$PeriodeIniInfo['Jour']." Limit 0,1";
		$SQL->SELECT($Req);
		while($Rep = $SQL->FetchArray()){
			$Ar = get_similar_periode($Rep[0]);
			$Couple = "";
			foreach($Ar as $k=>$v){
				$Couple .= ",".$k;
			}
			$Req2 = "UPDATE periode set End = ".$NStart." WHERE IDPeriode in (".substr($Couple,1).")";
			$SQL2->QUERY($Req2);
		}
		//Trouver les périods après qui doivent faire changer leur heure
		$Req = "SELECT IDPeriode FROM periode WHERE IDPiscine=".$PeriodeIniInfo['IDPiscine']." AND IDSession=".$PeriodeIniInfo['IDSession']." AND Start=".$PeriodeIniInfo['End']." AND Jour=".$PeriodeIniInfo['Jour']." Limit 0,1";
		$SQL->SELECT($Req);
		while($Rep = $SQL->FetchArray()){
			$Ar = get_similar_periode($Rep[0],TRUE);
			$Couple = "";
			foreach($Ar as $k=>$v){
				$Couple .= ",".$k;
			}
			$Req2 = "UPDATE periode set Start = ".$NEnd." WHERE IDPeriode in (".substr($Couple,1).")";
			$SQL2->QUERY($Req2);
		}
	}else
		$WarnOutput->addtexte("Le changement n'a pas pu être effectué: vous écrasez une période adjacente",'Warning');
	
}



$SP = get_similar_periode($_POST['IDPeriode'],TRUE,'IDPeriode, Semaine');
$i=1;
foreach($SP as $k=>$v){
	$ArrayMap5 = "FORMPeriode".$k.'5';
	$ArrayMap4 = "FORMPeriode".$k.'4';
	$ArrayMap3 = "FORMPeriode".$k.'3';
	if ($_POST[$ArrayMap5]=="" or $_POST[$ArrayMap4]=="" or $_POST[$ArrayMap3] ==""){
		$ReqSP = "DELETE FROM Periode WHERE IDPeriode = ".$k;
			$SQL2->QUERY($ReqSP);
		$ReqSP = "DELETE FROM ressource WHERE IDPeriode = ".$k;
			$SQL2->QUERY($ReqSP);
		$ReqSP .="DELETE FROM cours WHERE IDPeriode = ".$k;
	}else
		$ReqSP = "UPDATE Periode SET Semaine=".get_last_sunday(0,mktime(0,0,0,$_POST[$ArrayMap4],$_POST[$ArrayMap5],$_POST[$ArrayMap3]))." WHERE IDPeriode = ".$k;

$SQL2->QUERY($ReqSP);

}

if($ACT=="DELETE"){
	$Req2 = "DELETE FROM periode WHERE IDPeriode in (".substr($CoupleIni,1).")"; 
	$SQL2->QUERY($Req2);
	$Req2 = "DELETE FROM ressource WHERE IDPeriode in (".substr($CoupleIni,1).")";
	$SQL2->QUERY($Req2);
	$Req2 = "DELETE FROM cours WHERE IDPeriode in (".substr($CoupleIni,1).")";
	$SQL2->QUERY($Req2);
	$Section = "Modifie_Periode";
}ELSEIF($ACT=="UPDATE"){
	$Req2 = "UPDATE periode set Start = ".$NStart.", End = ".$NEnd.", IDPlan='".$_POST['FORMIDPlan']."' WHERE IDPeriode in (".substr($CoupleIni,1).")";
	$SQL2->QUERY($Req2);
	$Section = "Periode";
}ELSE{
	$Section = "Modifie_Periode";
}





?>