<?PHP
$SQL2 = new sqlclass;
	$NDay = get_day_list();
	$NMonth = get_month_list();
	if(isset($_POST['IDPeriode']))
		$_GET['IDPeriode']=$_POST['IDPeriode'];
		
if(isset($_GET['IDPeriode'])||(isset($_GET['IDPiscine'])AND isset($_GET['Jour']) AND isset($_GET['Start'])) ){
	
	if(!isset($_GET['IDPeriode'])){
		$Req = "SELECT IDPeriode FROM periode WHERE IDPiscine=".$_GET['IDPiscine']." AND Jour=".$_GET['Jour']." AND Start=".$_GET['Start']." AND Semaine+(3600*24)*Jour+Start>".time()." AND IDSession = ".$_ACTIVE['Session']." ORDER BY Semaine ASC";
		$SQL->SELECT($Req);
		$Rep = $SQL->FetchArray();
		$_GET['IDPeriode'] = $Rep[0];
		if($_GET['IDPeriode']==""){
			$Req = "SELECT IDPeriode FROM periode WHERE IDPiscine=".$_GET['IDPiscine']." AND Jour=".$_GET['Jour']." AND Start=".$_GET['Start']." AND IDSession = ".$_ACTIVE['Session']." AND Semaine <=".get_last_sunday()." ORDER BY Semaine DESC";
			$SQL->SELECT($Req);
			$Rep = $SQL->FetchArray();
			$_GET['IDPeriode'] = $Rep[0];
			if($_GET['IDPeriode']==""){
				$Req = "SELECT IDPeriode FROM periode WHERE IDPiscine=".$_GET['IDPiscine']." AND Jour=".$_GET['Jour']." AND Start=".$_GET['Start']." AND IDSession = ".$_ACTIVE['Session']." AND Semaine <=".get_last_sunday()." ORDER BY Semaine ASC";
				$SQL->SELECT($Req);
				$Rep = $SQL->FetchArray();
				$_GET['IDPeriode'] = $Rep[0];
			}
		}
	}
	$MainOutput->OpenTable();
	$MainOutput->OpenRow();
	$Info = get_info('periode',$_GET['IDPeriode']);
	$InfoP = get_info('piscine',$Info['IDPiscine']);
	$GetDateReq = "SELECT IDPeriode, Semaine FROM periode WHERE IDPiscine=".$Info['IDPiscine']." AND Jour=".$Info['Jour']." AND Start=".$Info['Start']." AND IDSession=".$_ACTIVE['Session']." ORDER BY Semaine ASC";
		$SQL->SELECT($GetDateReq);
	$NBRow = $SQL->NumRow();
	$MainOutput->OpenCol('100%',$NBRow);
		$sh = intval($Info['Start']/60/60);
		$sm = bcmod($Info['Start'],3600)/60;
			if($sm==0)
				$sm="";
				
		$eh = intval($Info['End']/60/60);
		$em = bcmod($Info['End'],3600)/60;
			if($em==0)
				$em="";
	$MainOutput->addoutput('<div align=middle valign=middle>',0,0);
	$LeftStamp = $Info['Semaine']+$Info['Jour']*(24*60*60)+$Info['Start'];
	$RightStamp = $Info['Semaine']+$Info['Jour']*(24*60*60)+$Info['End'];

	$Req2 = "SELECT IDPeriode FROM periode WHERE IDSession=".$_ACTIVE['Session']." AND IDPiscine = ".$Info['IDPiscine']." AND Semaine+Jour*(24*60*60)+End-".$LeftStamp."<=0 ORDER BY Semaine+Jour*(24*60*60)+End-".$LeftStamp." DESC LIMIT 0,1";
	$SQL2->SELECT($Req2);
	$Rep2 = $SQL2->FetchArray();
		if($Rep2[0]==""){
			$Rep2[0]=$_GET['IDPeriode'];
		}

	if(!$ToPrint)
		$MainOutput->AddLink('index.php?Section=Periode&ToPrint='.$_GET['ToPrint'].'&IDPeriode='.$Rep2[0],'<img src=images/prev.png border=0>');
	
	// HEAD LINE OR BOTTOM LINE 
	$Title = $InfoP['Nom']." - ".$NDay[$Info['Jour']]." (".$sh."h".$sm." à ".$eh."h".$em.") ";
	if(!$ToPrint)
		$MainOutput->AddTexte($Title,'Titre');

	$Req2 = "SELECT IDPeriode FROM periode WHERE IDSession=".$_ACTIVE['Session']." AND IDPiscine = ".$Info['IDPiscine']." AND Semaine+Jour*(24*60*60)+Start-".$RightStamp.">=0 ORDER BY Semaine+Jour*(24*60*60)+Start-".$RightStamp." ASC LIMIT 0,1";
	$SQL2->SELECT($Req2);
	$Rep2 = $SQL2->FetchArray();
		if($Rep2[0]==""){
			$Rep2[0]=$_GET['IDPeriode'];
		}
	if(!$ToPrint)
	$MainOutput->AddLink('index.php?Section=Periode&ToPrint='.$_GET['ToPrint'].'&IDPeriode='.$Rep2[0],'<img src=images/next.png border=0>');
	$MainOutput->addoutput('</div>',0,0);
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	$MainOutput->OpenRow();
	while($Rep=$SQL->FetchArray()){
        //il y a un peu de magie à faire ici pour les changements d'heures...
        //je m'attends à ce que la variable $Rep['Semaine'] soit le dimanche à minuit. si ce n'est pas le cas je dois modifier
        //De plus, il se peut que la fonction de projection des jours ne fonctionne pas (parce que certains jours ont plus ou moins de 24h...
        $CurrentDay =1; //On commence à 1 parce que si la journée est le dimanche (=0) alors je ne veux pas ajouter de jours...
        $UsableTimeStamp = $Rep['Semaine'];
        while($CurrentDay<=$Info['Jour']){
            $UsableTimeStamp += get_day_length($UsableTimeStamp);
            $CurrentDay++;
        }
		$Date = getdate($UsableTimeStamp);
		if($Rep['Semaine']==$Info['Semaine']){
			$Class= 'TitreLink';
			$IDPeriode = $Rep['IDPeriode'];
			}
		else
			$Class='Link';
		if($ToPrint)
			$Class='TitreLink';
		$MainOutput->OpenCol();
		$MainOutput->AddLink('index.php?Section=Periode&ToPrint='.$_GET['ToPrint'].'&IDPeriode='.$Rep['IDPeriode'],$Date['mday']."-".$NMonth[$Date['mon']],'',$Class);
		$MainOutput->CloseCol();
	}	$MainOutput->CloseRow();
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('100%',$NBRow);
	if($ToPrint)
			$MainOutput->BR(2);
	else
	$MainOutput->BR();
	$PlanInfo = get_info('plan',$Info['IDPlan']);
	if($Info['IDPlan']<>0){
		$Req = "SELECT employe.IDEmploye, employe.Nom , employe.Prenom FROM ressource JOIN employe on ressource.IDEmploye = employe.IDEmploye WHERE IDPeriode=".$IDPeriode." AND isnull(IDCours) ORDER BY NoRessource ASC";
		$SQL->SELECT($Req);
		$NBResp = $SQL->NumRow();
		if(!$ToPrint){
			$MainOutput->OpenTable();
			$MainOutput->OpenRow();
			$MainOutput->OpenCol('50%');
			$MainOutput->AddOutput('<div align=right>',0,0);
			$MainOutput->AddLink('index.php?Section=ModifieCours&AllSession=FALSE&IDPeriode='.$IDPeriode,'Responsable','','Titre');
			$MainOutput->br();
			$MainOutput->AddOutput('</div>',0,0);
			$MainOutput->CloseCol();
			$MainOutput->OpenCol('50%');
			while($Rep = $SQL->FetchArray()){
				$MainOutput->AddLink('index.php?Section=FormEmploye&IDEmploye='.$Rep[0],$Rep[1]." ".$Rep[2],'_Blank');
				$MainOutput->br();
			}
			$MainOutput->CloseCol();
			$MainOutput->CloseRow();
			$MainOutput->CloseTable();
		}
	$MainOutput->AddOutput(render($_GET['IDPeriode'],$_GET['ToPrint']),0,0);

	if($ToPrint){
		if($NBResp<>0){
		$MainOutput->OpenTable();
			$MainOutput->OpenRow();
			$MainOutput->OpenCol('50%');
			$MainOutput->AddOutput('<div align=right>',0,0);
			$MainOutput->AddLink('index.php?Section=ModifieCours&AllSession=FALSE&IDPeriode='.$IDPeriode,'Responsable','','Titre');
			$MainOutput->br();
			$MainOutput->AddOutput('</div>',0,0);
			$MainOutput->CloseCol();
			$MainOutput->OpenCol('50%');
			while($Rep = $SQL->FetchArray()){
				$MainOutput->AddLink('index.php?Section=FormEmploye&IDEmploye='.$Rep[0],$Rep[1]." ".$Rep[2],'_Blank');
				$MainOutput->br();
			}
			$MainOutput->CloseCol();
			$MainOutput->CloseRow();
			$MainOutput->CloseTable();
		}else{
		$MainOutput->br();
		}

	


		$MainOutput->AddTexte("
		<DIV ALIGN=CENTER><FONT SIZE=4>".$Title."</FONT></DIV>",'Titre');


}
	}
	else{
//Table bidon qui servira ?ventuellement ? faire entrer les plans de piscine

			$MainOutput->OpenTable();
				$MainOutput->OpenRow();
				$MainOutput->OpenCol('30%');
					$MainOutput->AddLink('index.php?Section=ModifieCours&AllSession=FALSE&IDPeriode='.$IDPeriode,'Responsable','','Titre');
					$MainOutput->br();
				$MainOutput->CloseCol();
				$MainOutput->OpenCol('70%');
					$Req = "SELECT employe.IDEmploye, employe.Nom , employe.Prenom FROM ressource JOIN employe on ressource.IDEmploye = employe.IDEmploye WHERE IDPeriode=".$IDPeriode." AND isnull(IDCours)";
					$SQL->SELECT($Req);
					while($Rep = $SQL->FetchArray()){
						$MainOutput->AddLink('index.php?Section=FormEmploye&IDEmploye='.$Rep[0],$Rep[1]." ".$Rep[2],'_Blank');
						$MainOutput->br();
					}
				
				$MainOutput->CloseCol();
				$MainOutput->CloseRow();
				
					$Req = "SELECT IDCours, Niveau
							FROM cours JOIN niveau ON
							cours.IDNiveau = niveau.IDNiveau 
							WHERE cours.IDPeriode = ".$IDPeriode;

					$SQL->SELECT($Req);
					$SQL2 = new SQLClass();
					
					while($Rep = $SQL->FetchArray()){
					$MainOutput->OpenRow();
					$MainOutput->OpenCol('30%');
						$MainOutput->AddLink('index.php?Section=ModifieCours&IDCours='.$Rep[0].'&AllSession=FALSE',$Rep[1],'','Titre');
					$MainOutput->CloseCol();
					$MainOutput->OpenCol();	
					$Req2 = "SELECT employe.IDEmploye, Nom, Prenom FROM ressource LEFT JOIN employe ON ressource.IDEmploye = employe.IDEmploye WHERE IDCours=".$Rep[0];
					$SQL2->SELECT($Req2);
					while($Rep2 = $SQL2->FetchArray()){
							if($Rep2[0]==0)
								$MainOutput->AddTexte('__________________');
							else
								$MainOutput->AddLink('index.php?Section=FormEmploye&IDEmploye='.$Rep2[0],$Rep2[1]." ".$Rep2[2],'_Blank');
							$MainOutput->br();
					}
			}
					$MainOutput->CloseCol();
					$MainOutput->CloseRow();
							$MainOutput->OpenRow();
			$MainOutput->OpenCol();
							$MainOutput->addoutput("<a href=index.php?Section=Modifie_Periode&FORMIDPeriode=".$IDPeriode."><Span class=Titre><img src=images/edit.png border=0></SPAN></a>",0,0);
			$MainOutput->CloseCol();
			$MainOutput->CloseRow();
					}
				
				
						

			$MainOutput->CloseTable();
	
//fin de la table bidon
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	$MainOutput->CloseTable();
}else{
IF(ISSET($Rapport))
	 echo $Rapport->Send();
	$MainOutput->OpenTable();
	$MainOutput->OpenRow();
	$MainOutput->OpenCol('100%',8);
	$MainOutput->AddTexte('Liste des périodes de cours','Titre');
	$MainOutput->AddLink('index.php?Section=FormPeriode','<img src=images/insert.png border=0>');
	$MainOutput->AddLink('index.php?Section=FormModifPeriode','<img src=images/edit.png border=0>');
	$MainOutput->AddLink('index.php?Section=Remplacement','<img src=images/empl.png border=0>');
	$MainOutput->AddLink('index.php?Section=BatchPlan','<img src=images/plan.png border=0>');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	
	$Piscines = get_active('piscine');
	foreach($Piscines as $v){

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
			$MainOutput->CloseCol();
			$d++;
		}
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();


		$MainOutput->OpenRow();
		
		
		$Output = array(0=>new HTML,1=>new HTML,2=>new HTML,3=>new HTML,4=>new HTML,5=>new HTML,6=>new HTML);
		$Req = "SELECT DISTINCT Jour, Start, round((max(End)-max(Start))/60) as Duree FROM periode WHERE IDSession=".$_ACTIVE['Session']." AND IDPiscine=".$v['IDPiscine']." GROUP BY Jour, `Start` ORDER BY Jour ASC, `Start` ASC";
		$SQL->SELECT($Req);
		$OldStart = 0;
		$OldJour = -1;
		while($Rep = $SQL->FetchArray()){
			if($OldJour<>$Rep['Jour']){
				$OldStart=0;
				$OldJour = $Rep['Jour'];
				$BlackCarlos = FALSE;
			}
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
			$Output[$Rep['Jour']]->Addlink('index.php?Section=Periode&ToPrint='.$_GET['ToPrint'].'&IDPiscine='.$v['IDPiscine'].'&Jour='.$Rep['Jour'].'&Start='.$Rep['Start'],$sh."h".$sm,'','TitreLink');
			$Output[$Rep['Jour']]->AddTexte("(".$Rep['Duree']." min)");
			$Output[$Rep['Jour']]->br();
		}

		$d=0;
	$MainOutput->OpenCol(100,1,'Top','HInstall');
		$MainOutput->AddTexte($v['Nom'],'Titre');
		$MainOutput->CloseCol();
		
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
}




echo $MainOutput->Send(1);
?>