<?PHP
$NDay = get_day_list();
$PiscineInfo = get_info('piscine',$_GET['IDPiscine']);

$MainOutput->AddForm('Affecter un moniteur à une série de cours');
$MainOutput->InputHidden_Env('Action','Batch_Remplace');
$MainOutput->InputHidden_Env('IDPiscine',$_GET['IDPiscine']);
$MainOutput->InputHidden_Env('Jour',$_GET['Jour']);
$MainOutput->InputHidden_Env('Semaine',$_GET['Semaine']);

if(!isset($_GET['Inscripteur'])){
	$MainOutput->InputHidden_Env('Inscripteur',FALSE);
}else{
	$MainOutput->InputHidden_Env('Inscripteur',TRUE);
}

$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte("<div align=center>".$PiscineInfo['Nom']." - ".$NDay[$_GET['Jour']]."</div>",'Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte("<div align=center>------------------------------------------------------</div>",'Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
$Req = "SELECT IDEmploye, Nom, Prenom FROM employe WHERE !Cessation ORDER BY Nom ASC";
$MainOutput->InputSelect('IDEmploye',$Req,'','Employé');
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte("<div align=center>------------------------------------------------------</div>",'Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

$Req = "SELECT DISTINCT min(IDPeriode) FROM periode WHERE IDPiscine = ".$_GET['IDPiscine']." AND IDSession =".$_ACTIVE['Session']." AND Jour=".$_GET['Jour']." AND Semaine=".$_GET['Semaine']." GROUP BY Jour, Start, IDPiscine, IDSession ORDER BY Start ASC";
$SQL->SELECT($Req);
$SQL2 = new sqlclass();
while($Rep = $SQL->FetchArray()){
	$Info = get_info('Periode',$Rep[0]);
	$sh = intval($Info['Start']/60/60);
		$sm = bcmod($Info['Start'],3600)/60;
			if($sm==0)
				$sm="";

	$Req2 = "(SELECT Concat('R-',NoRessource) as Rank, Concat('Responsable - ',NoRessource) as Val, 0 as A FROM ressource WHERE IDPeriode = ".$Rep[0]." AND isnull(IDCours) AND IDEmploye=0) UNION (SELECT concat(niveau.IDNiveau,'-',NoRessource) AS ID, concat(Niveau,' - ',Role) as Val, Rank as A FROM niveau JOIN cours JOIN ressource ON niveau.IDNiveau = cours.IDNiveau AND cours.IDCours = ressource.IDCours WHERE cours.IDPeriode = ".$Rep[0]." AND IDEmploye = 0 ORDER BY `A` ASC) ORDER BY `A` ASC";
	$MainOutput->InputSelect('IDPeriode'.$Rep[0],$Req2,'',$sh."h".$sm,1);



}
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',2);
	$MainOutput->AddTexte("<div align=center>------------------------------------------------------</div>",'Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->FormSubmit('Enregistrer');

echo $MainOutput->Send(1);
?>
