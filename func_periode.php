<?PHP
function get_similar_periode($IDPeriode,$Past=FALSE,$Select='IDPeriode'){
	//chéker si ça pourrait être cool, a place de faire la division sur la query, on pourrait le faire avec 
	//une condition dans le while, et ainsi on pourrait dire QUELS numéro (1 à 8) on a modifier exemple
	// quoi qu'on peut le faire avec 8- le nombre qu'on es rendu...en tout cas
	
	$Info = get_info('periode',$IDPeriode);
	$SQL = new sqlclass();
	$Time = time();
	if($Past)
		$SQL->SELECT('SELECT '.$Select.' FROM periode WHERE Start='.$Info['Start'].' AND Jour='.$Info['Jour'].' AND IDPiscine=  '.$Info['IDPiscine'].' AND IDSession='.$Info['IDSession'].' ORDER BY Semaine ASC');
	else
		$SQL->SELECT('SELECT '.$Select.' FROM periode WHERE Start='.$Info['Start'].' AND Jour='.$Info['Jour'].' AND IDPiscine= '.$Info['IDPiscine'].' AND IDSession='.$Info['IDSession'].' AND Semaine+Jour*24*3600+Start>='.$Time.' ORDER BY Semaine ASC');
	$ret = array();
	While($Rep = $SQL->FetchArray()){
		$ret[$Rep[0]] = $Rep;
	}
	return $ret;
}

function get_periode_string($IDPeriode,$Past=FALSE){
	$Info = get_similar_periode($IDPeriode,$Past);
	$ret = "";
	foreach($Info as $k=>$v)
		$ret .= ",".$k;
	return "(".substr($ret,1).")";
}

function get_similar_cours($IDCours, $Past=FALSE,$Select='IDCours, IDPeriode'){
	$Info = get_info('cours',$IDCours);
	$SQL = new sqlclass();
	$Time = time();
	$InString = get_periode_string($Info['IDPeriode'],$Past);
	$SQL->SELECT('SELECT '.$Select.' FROM cours WHERE IDNiveau = '.$Info['IDNiveau'].' AND IDPeriode IN '.$InString);
	
	$ret = array();
	While($Rep = $SQL->FetchArray()){
		$ret[$Rep[0]] = $Rep;
	}
	return $ret;
}

function get_cours_string($IDCours,$Past=FALSE){
	$Info = get_similar_cours($IDCours,$Past);
	$ret = "";
	foreach($Info as $k=>$v)
		$ret .= ",".$k;
	return "(".substr($ret,1).")";
}

?>