<?PHP
function next_rank(){
	$SQL = new SQLclass;
	$Req = "Select Max(Rank) From niveau WHERE Active";
	
	$SQL->select($Req);
	$Rep = $SQL->FetchArray();
	if($Rep[0]==""){
		return 1;
	}
	$Rep[0]++;
	Return $Rep[0];
}

function move_rank($IDNiveau,$Direction){
	$Direction = strtolower($Direction);
	$SQL = new SQLclass;
	$Req = "Select `Rank` From niveau WHERE IDNiveau = ".$IDNiveau;
	$SQL->select($Req);
	$Rep = $SQL->FetchArray();
	$Rankini = $Rep[0];
	if($Direction == "up"){
		$RankTo = $Rankini+1;
	}
	if($Direction == "down"){
			$RankTo = $Rankini-1;
	}
	
	
	
	if(isset($RankTo)){
		$Req = "Select IDNiveau From niveau WHERE `Rank` = ".$RankTo;
		$SQL->select($Req);
		$Rep = $SQL->FetchArray();
		$IDNiveau2 = $Rep[0];
		if($IDNiveau2<>""){
			$Req = "UPDATE niveau SET `Rank`=".$RankTo." WHERE IDNiveau = ".$IDNiveau;
			$SQL->Update($Req);
			$Req = "UPDATE niveau SET `Rank`=".$Rankini." WHERE IDNiveau = ".$IDNiveau2;
			$SQL->Update($Req);
		}
	}
}

?>