<?PHP
//Premièrement Enlever de l'horaire la personne
$Rapport = new HTML;

	$Rapport->OpenTable(300);
	$Rapport->OpenRow();
	$Rapport->OpenCol(300,3);
	$Rapport->AddTexte('Remplacements ajoutés à la liste','Titre');
	$Rapport->CloseCol();
	$Rapport->CloseRow();

	
if($_POST['FORMFROM5']<>"" AND $_POST['FORMIDEmployeS']<>""){

$SQL = new sqlclass;
$SQL2 = new sqlclass;


if(!isset($_POST['FORMLastminute']))
	$_POST['FORMLastminute']="0";
	
	$FROM = mktime(0,0,0,$_POST['FORMFROM4'],$_POST['FORMFROM5'],$_POST['FORMFROM3']);
	if($_POST['FORMTO5']=="")
		$TO = $FROM;
	else
		$TO = mktime(0,0,0,$_POST['FORMTO4'],$_POST['FORMTO5'],$_POST['FORMTO3']);
	
	$Req = "SELECT IDRessource, IDCours, Semaine+(60*60*24)*Jour as T, Start, End FROM ressource JOIN periode on periode.IDPeriode = ressource.IDPeriode WHERE periode.Semaine+(60*60*24)*periode.Jour>=".$FROM." AND periode.Semaine+(60*60*24)*periode.Jour<=".$TO." AND IDEmploye=".$_POST['FORMIDEmployeS']." ORDER BY Semaine ASC, Jour ASC, Start ASC";
	$SQL->SELECT($Req);

if($SQL->NumRow()==0){
	$Rapport->OpenRow();
	$Rapport->OpenCol(300,3);
	$Rapport->AddTexte('Aucun');
	$Rapport->CloseCol();
	$Rapport->CloseRow();

};

	$Month = get_month_list('long');
	
	$Today = time();
	$IDRessource = "";
	$Couple = "";
	while($Rep = $SQL->FetchArray()){
	$IDRessource .= ",".$Rep['IDRessource'];
	$Couple .= ",(".$_POST['FORMIDEmployeS'].",".$Rep['IDRessource'].",'".addslashes($_POST['FORMRaison'])."','".$_POST['FORMTalkedto']."',".$Today.")";
	
	$Date = get_date($Rep['T']);
	$Start= get_date($Rep['Start']);
	$End = get_date($Rep['End']);
	if($Start['i']==0)
		$Start['i']="";
	if($End['i']==0)
		$End['i']="";

	if(is_null($Rep['IDCours']))
		$Nom = "Reponsable";
	else{
		$I = get_info('cours',$Rep['IDCours']);
		$I2 = get_info('niveau',$I['IDNiveau']);
		$Nom = $I2['Niveau'];
	}
		
	$Rapport->OpenRow();
	
	$Rapport->OpenCol();
	$Rapport->addtexte($Date['d']."-".$Month[intval($Date['m'])]."-".$Date['Y'],'Titre');
	$Rapport->CloseCol();
	
	$Rapport->OpenCol();
	$Rapport->addtexte($Nom);
	$Rapport->CloseCol();


	$Rapport->OpenCol();
	$Rapport->addtexte($Start['G']."h".$Start['i']." à ".$End['G']."h".$End['i']);
	$Rapport->CloseCol();
	
	$Rapport->CloseRow();
	}


	$Req2 = "INSERT INTO remplacement(`IDEmployeS`,`IDRessource`,`Raison`,`Talkedto`,`Asked`,`Lastminute`) 
	VALUES ".substr($Couple,1);


	$Infoemp = get_info('employe',$_POST['FORMIDEmployeS']);
	$Req3 = "UPDATE ressource SET IDEmploye=0 WHERE IDRessource in (".substr($IDRessource,1).")";
if($SQL->NumRow()<>0)
	$SQL2->QUERY($Req3);
	
}else{
		$Rapport->OpenRow();
		$Rapport->OpenCol('100%',3);
		$Rapport->AddTexte('Il manque quelques données','Warning');
		$Rapport->CloseCol();
		$Rapport->CloseRow();
	}
	
$Rapport->CloseTable();
$Section = "Periode";
?>