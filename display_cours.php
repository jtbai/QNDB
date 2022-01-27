<?PHP

$MainOutput->Opentable();
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',8);
	$MainOutput->AddTexte('Liste des cours','Titre');
	$MainOutput->AddLink('index.php?Section=FormCours','<img src=images/insert.png border=0>');
	$MainOutput->AddLink('index.php?Section=FormCours2','<img src=images/insert.png border=0>');
$MainOutput->CloseCol();
$MainOutput->CloseRow();

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
				$MainOutput->AddLink('index.php?Section=Batch_Affect&IDPiscine='.$v['IDPiscine'].'&Jour='.$d,'<img src=images/empl.png border=0>');
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
    $Req = "SELECT DISTINCT Niveau, Jour, max(Start) as Start, round(max(End)-max(Start)/60) as Duree, min(cours.IDCours) as IDCours , min(ressource.IDEmploye) as Full, min(Rank) as Rank 
                FROM piscine JOIN niveau JOIN cours JOIN periode JOIN ressource ON cours.IDCours = ressource.IDCours AND periode.IDPiscine= piscine.IDPiscine AND cours.IDPeriode=periode.IDPeriode AND cours.IDNiveau = niveau.IDNiveau  WHERE piscine.IDPiscine=".$v['IDPiscine']." AND periode.IDSession = ".$_ACTIVE['Session']." AND (Semaine+Jour*(3600*24)+Start-".$now.")>0 GROUP BY periode.IDPiscine, Jour, Start, cours.IDNiveau ORDER BY Jour ASC, Start ASC, Rank ASC";
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
				$Output[$Rep['Jour']]->AddLink('index.php?Section=ModifieCours&AllSession=TRUE&IDPeriode='.$Info['IDPeriode'],$sh."h".$sm,'','Titre');
				$Output[$Rep['Jour']]->AddTexte("(".$Rep['Duree']." min)");
				$Output[$Rep['Jour']]->br();
			}

			if($Rep['Full']==0)
				$Class = 'Warning';
			else
				$Class = 'Texte';
			
				
				
			$Output[$Rep['Jour']]->AddLink('index.php?Section=ModifieCours&AllSession=TRUE&IDCours='.$Rep['IDCours'],$Rep['Niveau'],'',$Class);
			$Output[$Rep['Jour']]->br();
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