<?PHP
//
//function format_horaire($IDPiscine,$d){
//		$MainOutput->OpenTable();
//		$d=0
//		$MainOutput->OpenRow();
//		while($d=0){
//			$MainOutput->OpenCol();
//				$MainOutput->AddPic('carlos.gif','width=50, height=1');
//				$MainOutput->AddTexte('<div align=center>'.$NDay[$d].'</div>','Titre');
//			$MainOutput->CloseCol();
//			$d++;
//		}
//		$MainOutput->CloseRow();
//		$MainOutput->CloseTable();	
//}

function apply_multiplicateur($Pinfo){
	$Req = "SELECT IDCours, Multiplicateur FROM cours JOIN periode on cours.IDPeriode = periode.IDPeriode WHERE Semaine in (".$Pinfo['Semaine1'].",".$Pinfo['Semaine2'].") ORDER BY Multiplicateur ASC";
	$OldMultiplicateur = "";
	$IDCoursString = "";
	$SQL2 = new sqlclass;
	$SQLW = new sqlclass;	
	$SQLW->SELECT($Req);
	while($RepW = $SQLW->FetchArray()){
		if($OldMultiplicateur <> $RepW['Multiplicateur'] AND $OldMultiplicateur <>""){
			$ReqStr = "UPDATE ressource SET multiplicateur = ".$OldMultiplicateur." WHERE IDCours IN(".substr($IDCoursString,1).")";
			$SQL2->UPDATE($ReqStr);
			$IDCoursString = "";
		}
		$OldMultiplicateur = $RepW['Multiplicateur'];
		$IDCoursString .= ", ".$RepW['IDCours'];
	}
	$ReqStr = "UPDATE ressource SET multiplicateur = ".$OldMultiplicateur." WHERE IDCours IN(".substr($IDCoursString,1).")";
	$SQL2->UPDATE($ReqStr);
	$IDCoursString = "";
}
?>