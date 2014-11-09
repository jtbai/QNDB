<?PHP

$MainOutput->Opentable();
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',8);
	$MainOutput->AddTexte('Liste des inscripteurs','Titre');
$MainOutput->CloseCol();
$MainOutput->CloseRow();
$SQL2 = New Sqlclass;
$Piscine = get_active('piscine');
$NDay = get_day_list();
foreach($Piscine as $v){
	$MainOutput->OpenRow();
		$MainOutput->OpenCol('100');
					$MainOutput->AddPic('carlos.gif','width=100, height=1');
			$MainOutput->AddTexte('&nbsp;');
		$MainOutput->CloseCol();
		$d=0;	
		while($d<=6){
			$MainOutput->OpenCol('50');
			$MainOutput->AddPic('carlos.gif','width=100, height=1');
			$MainOutput->br();

				$MainOutput->AddTexte($NDay[$d],'Titre');
				$MainOutput->AddLink('index.php?Section=Batch_Affect&IDPiscine='.$v['IDPiscine'].'&Inscripteur=TRUE&Jour='.$d,'<img src=images/empl.png border=0>');
			$MainOutput->CloseCol();
			$d++;
		}
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();

		$MainOutput->OpenRow();
		$MainOutput->OpenCol(100,1,'Top','HInstall');
		$MainOutput->AddTexte($v['Nom'],'Titre');
		$MainOutput->CloseCol();
		
		$Output = array(0=>new HTML,1=>new HTML,2=>new HTML,3=>new HTML,4=>new HTML,5=>new HTML,6=>new HTML);
		$now = time();
		$Req = "SELECT cours.IDCours, Jour, Start-30*60 as Start FROM cours JOIN periode JOIN ressource ON cours.IDCours = ressource.IDCours AND cours.IDPeriode=periode.IDPeriode WHERE periode.IDPiscine=".$v['IDPiscine']." AND periode.IDSession = ".$_ACTIVE['Session']." AND cours.IDNiveau=46 GROUP BY Jour, Start ORDER BY Jour ASC, Start ASC";
			$SQL->SELECT($Req);
		$OldStart = 0;
		$OldJour = -1;
		while($Rep = $SQL->FetchArray()){
			if($OldJour<>$Rep['Jour']){
				$OldStart=0;
				$OldJour = $Rep['Jour'];
				$BlackCarlos = FALSE;
			}
			if($OldStart<>$Rep['Start']){
				if($BlackCarlos){
					$Output[$Rep['Jour']]->AddPic('blackcarlos.gif','width=100, height=1');
					$Output[$Rep['Jour']]->br();

				}
				$BlackCarlos=TRUE;
				$OldStart = $Rep['Start'];
				$sh = intval($Rep['Start']/60/60);
				$sm = bcmod($Rep['Start'],3600)/60;
				if($sm==0)
					$sm="";
				$Info = get_info('cours',$Rep['IDCours']);
				$Output[$Rep['Jour']]->AddLink('index.php?Section=ModifieCours&AllSession=FALSE&IDCours='.$Rep['IDCours'],$sh."h".$sm,'','Titre');
				$Output[$Rep['Jour']]->br();
			}

			$Req4 = "SELECT ressource.IDEmploye, Nom, Prenom FROM ressource LEFT JOIN employe on ressource.IDEmploye = employe.IDEmploye WHERE IDCours = ".$Rep['IDCours'];
			$SQL2->Select($Req4);
			while($Rep4 = $SQL2->FetchArray()){
				if($Rep4[0]==0){
					$TXT= "__________";
					$Class = "Warning";
				}else{
					$TXT= $Rep4[1]." ".$Rep4[2];
					$Class = "Texte";
				}
			$Output[$Rep['Jour']]->AddTexte($TXT,$Class);
			$Output[$Rep['Jour']]->br();
			}
			
		}
		$d=0;
		while($d<=6){
			$MainOutput->OpenCol('50',1,'Top','HDay');
 			$MainOutput->AddPic('carlos.gif','width=100, height=1');
			$MainOutput->br();
				$MainOutput->AddOutput($Output[$d]->Send(),0,0);
			$MainOutput->CloseCol();
			$d++;
		}
		$MainOutput->CloseRow();

}
$MainOutput->CloseTable();
echo $MainOutput->Send(1);

?>