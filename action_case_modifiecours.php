<?PHP

$Str = "";

if($_POST['AllSession']=="TRUE"){
	if(!isset($_POST['IDCours']) || $_POST['IDCours']==NULL){
	// Modification des shift de responsable
	// IDPeriode doit être setté 
		$Info = get_similar_periode($_POST['IDPeriode']);
		foreach($Info as $k=>$v)
			$Str .= ",(".$k.")";
		$STR = "(".substr($Str,1).")";
		$Req = "UPDATE ressource SET IDEmploye='".$_POST['FORMIDEmploye']."', Role='".$_POST['FORMRole']."', Salaire='".$_POST['FORMSalaire']."' WHERE NoRessource=".$_POST['IDRessource']." AND ISNULL(IDCours) AND (IDPeriode) in ".$STR;
	}else{
	//Modification des shifts de 
		$Info = get_similar_cours($_POST['IDCours']);
		foreach($Info as $k=>$v)
			$Str .= ",(".$v[1].",".$v[0].")";	
			$STR = "(".substr($Str,1).")";
			$Req = "UPDATE ressource SET IDEmploye='".$_POST['FORMIDEmploye']."', Role='".$_POST['FORMRole']."', Salaire='".$_POST['FORMSalaire']."' WHERE NoRessource=".$_POST['IDRessource']." AND (IDPeriode,IDCours) in ".$STR;
	}

}ELSE{
	if(!isset($_POST['IDCours']) || $_POST['IDCours']==NULL){
	// Modification des shift de responsable
	// IDPeriode doit être setté 
			$Str .= ",(".$_POST['IDPeriode'].")";
			$STR = substr($Str,1);
			$Req = "UPDATE ressource SET IDEmploye='".$_POST['FORMIDEmploye']."', Role='".$_POST['FORMRole']."', Salaire='".$_POST['FORMSalaire']."' WHERE NoRessource=".$_POST['IDRessource']." AND ISNULL(IDCours) AND (IDPeriode) in ".$STR;
	}else{
	//Modification des shifts de 
			$Str .= ",(".$_POST['IDPeriode'].",".$_POST['IDCours'].")";	
			$STR = "(".substr($Str,1).")";
			$Req = "UPDATE ressource SET IDEmploye='".$_POST['FORMIDEmploye']."', Role='".$_POST['FORMRole']."', Salaire='".$_POST['FORMSalaire']."' WHERE NoRessource=".$_POST['IDRessource']." AND (IDPeriode,IDCours) in ".$STR;
	}
}
$SQL->update($Req);
?>