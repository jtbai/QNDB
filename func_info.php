<?PHP
function get_info($Table,$ID){
	$SQL = new sqlclass;
	$Table =  strtolower($Table);
	$Req = "SELECT * FROM `".$Table."` WHERE ID".ucfirst($Table)." = ".$ID;
	$SQL->Select($Req);
	return $SQL->FetchArray();
}

function get_active($Table,$Active=1,$Sort='Nom',$Order='ASC'){
	$SQL = new sqlclass;
	$Table =  strtolower($Table);
	$Req = "SELECT * FROM `".$Table."` WHERE Active = ".$Active." ORDER BY ".$Sort." ".$Order;
	$SQL->Select($Req);
	
	$Ret=Array();
	
	while($Rep = $SQL->FetchArray())
		$Ret[$Rep[0]] = $Rep;
	return $Ret;
}
/** FONCTION D�SUETTE -> On passera maintenant par la fonction get_similar_cours et get_cours_string
**/
function get_cours($Caract,$Total=0,$IDSession=NULL){
	
	$SQL = new sqlclass;
	if($IDSession==NULL){
		$AS = get_active('session',1,'IDSession');
		foreach($AS as $v)
		$_ACTIVE['Session'] = $v['IDSession'];
	}
	
	if(!is_array($Caract)){
		//�a veut dire qu'on a un ID
		$InfoC = get_info('cours',$Caract);
		$InfoP = get_info('periode',$InfoC['IDPeriode']);
	}else{
		//A VOIR
		//$InfoP = get_info(
		//$Info = $Caract;
	}
		print_r($InfoP);
		$Req = "SELECT IDCours FROM Cours JOIN Periode on cours.IDPeriode = periode.IDPeriode WHERE Semaine+(3600*24)*Jour+Start>".get_last_sunday()." AND Start = ".$InfoP['Start']." AND IDPiscine = ".$InfoP['IDPiscine']." AND  Jour = ".$InfoP['Jour']." AND IDNiveau = ".$InfoC['IDNiveau']." AND IDSession = ".$_ACTIVE['Session']." ORDER BY Semaine ASC";
		$SQL->SELECT($Req);
		$Cours = array();
		while($Rep = $SQL->FetchArray()){
			$Cours[] = $Rep['IDCours'];
		}
		return $Cours;
}


function get_monit($IDCours){
	$SQL = new sqlclass;
	$Req = "SELECT NoRessource, IDEmploye, Role, Salaire FROM ressource WHERE IDCours=".$IDCours." ORDER BY NoRessource ASC";
	$SQL->SELECT($Req);
	$Ret = array();
	while($Rep = $SQL->FetchArray())
		$Ret[$Rep[0]] = array('IDEmploye'=>$Rep[1],'Role'=>$Rep[2],'Salaire'=>$Rep[3]);
	return $Ret;
}

function get_responsable($IDPeriode){
	$SQL = new sqlclass;
	$Req = "SELECT NoRessource, IDEmploye, Role, Salaire FROM ressource WHERE ISNULL(IDCours) AND IDPeriode=".$IDPeriode." ORDER BY NoRessource ASC";
	$SQL->SELECT($Req);
	$Ret = array();
	while($Rep = $SQL->FetchArray())
		$Ret[$Rep[0]] = array('IDEmploye'=>$Rep[1],'Role'=>$Rep[2],'Salaire'=>$Rep[3]);
	return $Ret;
}

function get_last($Table,$Active=NULL){
	$SQL = new sqlclass;
	$Table =  strtolower($Table);
	$Req = "SELECT * FROM `".strtolower($Table)."` ORDER BY ID".ucfirst($Table)." DESC limit 0,1";
	$SQL->Select($Req);
	return $SQL->FetchArray();
}

function check_unique($Table,$Field,$Value){
	$Table =  strtolower($Table);
	$SQL = new sqlclass;
	$Req = "SELECT * FROM `".strtolower($Table)."` WHERE `".$Field."` = '".$Value."'";
	$SQL->Select($Req);
	return $SQL->NumRow();
}

function activate($Table,$ID,$Activate=1){
	$SQL = new sqlclass;
	$Req = "UPDATE `".strtolower($Table)."` SET `Active`=".$Activate." WHERE ID".ucfirst($Table)." = ".$ID;
	$SQL->Update($Req);
};

function get_vars($Vars){
	return "HOU";
}

function get_qualif_employe($IDEmploye){
	$SQL = new sqlclass;
	$SQL2 = new sqlclass;
	$Req = "SELECT IDQualification FROM qualification ORDER BY IDQualification ASC";
	$SQL->SELECT($Req);
	$Ret = array();
	while($Rep = $SQL->FetchArray()){
		$Req2 = "SELECT Expiration FROM link_employe_qualification WHERE IDEmploye = ".$IDEmploye." AND IDQualification = ".$Rep[0];
		$SQL2->SELECT($Req2);
		$Rep2 = $SQL2->FetchArray();
		if($SQL2->NumRow()==0)
			$Ret[$Rep[0]] = 0;
		else
			$Ret[$Rep[0]] = $Rep2[0];
	}
	return $Ret;
}
function get_niveau_list(){
    $SQL= new sqlclass();
    $Req = "SELECT IDNiveau, Niveau, Code FROM niveau WHERE Active";
    
    $SQL->select($Req);
    $ret = array();
    while($Rep = $SQL->FetchArray()){
        $ret[$Rep['IDNiveau']] = array('Niveau'=>$Rep['Niveau'],'Code'=>$Rep['Code']);
        
        
    }
    return $ret;
}
?>