<?PHP
$MainOutput->OpenTable();
$SQL2 = new sqlclass();
if(!isset($_GET['Semaine']))
	$_GET['Semaine'] = get_last_sunday();


$SemD = get_date($_GET['Semaine']);
$SemE = get_date($_GET['Semaine'] + 6*(86400));

$Dates = array();
$CurrentDate = $_GET['Semaine'];
for($i=0;$i<=6;$i++){
    $Dates[$i] = $CurrentDate;
    $CurrentDate += get_day_length($CurrentDate);
}

$Month = get_month_list('court');
	
$Time = $SemD;
$Time2 = $SemE;
$Month = get_month_list('court');

	$MainOutput->OpenRow();
 	$MainOutput->OpenCol(900,8);
	if(!$_GET['ToPrint']){
		$MainOutput->addlink('index.php?Section=Remplacement&Semaine='.$_GET['Semaine'],'<img border=0 src=images/empl.png>');
		$MainOutput->addlink('index.php?Section=Missing_Monit&Semaine='.$_GET['Semaine'].'&ToPrint=TRUE','<img border=0 src=images/print.png>','_BLANK');
	/** A AJOUTER LORSQUE LES SHIFT POURRONT ÊTRE CONFIRMÉS
		if($_GET['Semaine'] < get_last_sunday() )
			$MainOutput->addlink('index.php?Section=Conf_Shift&Semaine='.$_GET['Semaine'],'<img border=0 src=b_conf.png>');
	**/
	}
		 $MainOutput->addtexte('<div align=Center>Feuille de temps de la semaine du '.$Time['d']."-".$Month[intval($Time['m'])]."-".$Time['Y']." au ".$Time2['d']."-".$Month[intval($Time2['m'])]."-".$Time2['Y'].'</div>','Titre');
	$MainOutput->CloseCol();
	$MainOutput->CloseRow();
	
	if(!$_GET['ToPrint']){
		$MainOutput->OpenRow();
		$MainOutput->OpenCol('100',1);
		$MainOutput->addoutput('<div align=right>',0,0);
			$MainOutput->AddLink('index.php?Section=Missing_Monit&Semaine='.get_last_sunday(2,$_GET['Semaine']),'<<');
		$MainOutput->addoutput('</div>',0,0);
		$MainOutput->CloseCol();
		
			$MainOutput->OpenCol('350',3);
		$MainOutput->addoutput('<div align=left>',0,0);
			$MainOutput->AddLink('index.php?Section=Missing_Monit&Semaine='.get_last_sunday(1,$_GET['Semaine']),'Semaine précédente');
		$MainOutput->addoutput('</div>',0,0);
		$MainOutput->CloseCol();
		
		
		$MainOutput->OpenCol('350',3);
		$MainOutput->addoutput('<div align=right>',0,0);
			$MainOutput->AddLink('index.php?Section=Missing_Monit&Semaine='.get_next_sunday(0,$_GET['Semaine']),'Semaine Suivante');
		$MainOutput->addoutput('</div>',0,0);
		$MainOutput->CloseCol();
		
		$MainOutput->OpenCol('100',1);
		$MainOutput->addoutput('<div align=left>',0,0);
			$MainOutput->AddLink('index.php?Section=Missing_Monit&Semaine='.get_next_sunday(1,$_GET['Semaine']),'>>');
		$MainOutput->addoutput('</div>',0,0);
		$MainOutput->CloseCol();
		
		
		$MainOutput->CloseRow();
	}
	$MainOutput->CloseTable();
echo $MainOutput->Send(1);

$Req = "SELECT periode.IDPeriode, periode.IDPiscine, group_concat(Role) as Missing, Jour, Start, round((End-Start)/60) as Duree, Nom FROM periode JOIN ressource JOIN piscine ON piscine.IDPiscine = periode.IDPiscine AND ressource.IDPeriode = periode.IDPeriode WHERE Semaine='".$_GET['Semaine']."' AND IDEmploye = 0 GROUP BY IDPiscine, Jour, Start ORDER BY Nom ASC, Jour ASC, Start ASC"; 
$SQL->SELECT($Req);
$OldIDPiscine = "";
$Start=FALSE;
$Output = array(0=>new HTML,1=>new HTML,2=>new HTML,3=>new HTML,4=>new HTML,5=>new HTML,6=>new HTML);	
while($Rep = $SQL->FetchArray()){
	if(!$Start){
		$Start=TRUE;
		$OldIDPiscine = $Rep['IDPiscine'];
	}
	
	if($Rep['IDPiscine']<>$OldIDPiscine){

		$PiscineInfo = get_info('piscine',$OldIDPiscine);
		$MainOutput->OpenTable();
		$MainOutput->OpenRow();
		$MainOutput->OpenCol('100%',7);
			$MainOutput->AddTexte("<div align=center><b>".$PiscineInfo['Nom']."</b></div>");
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		
		$MainOutput->OpenRow();
		for($d=0;$d<7;$d++){
			$MainOutput->OpenCol();
			

			$MainOutput->OpenTable(115);
			$MainOutput->OpenRow();
			$MainOutput->OpenCol(115,2);
			$MainOutput->AddPic('carlos.gif','width=115, height=1');
			$MainOutput->CloseCol();
			$MainOutput->CloseRow();
			$MainOutput->OpenRow();
			$MainOutput->OpenCol(16);
			$MainOutput->AddLink('index.php?Section=Batch_Remplace&Jour='.$d.'&Semaine='.$_GET['Semaine'].'&IDPiscine='.$OldIDPiscine,'<img src=images/empl.png border=0>');			
			$MainOutput->CloseCol();
			$MainOutput->OpenCol();
			
			$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
			$MainOutput->addtexte("<div align=center>".$CJour[$d]."</div>", 'Titre');
            $Date = get_date($Dates[$d]);
			$MainOutput->addtexte("<div align=center>".$Date['d']."-".$Month[intval($Date['m'])]."</div>", 'Titre');
			$MDay[$d] = $Date['d']."-".$Month[intval($Date['m'])];
			
			$MainOutput->CloseCol();
			$MainOutput->CloseRow();
			$MainOutput->CloseTable();	
			$MainOutput->CloseCol();
		}
	
		$MainOutput->CloseRow();
		$MainOutput->OpenRow();
		for($d=0;$d<7;$d++){
			$MainOutput->OpenCol();
			$MainOutput->AddOutput($Output[$d]->Send(1),0,0);
			$MainOutput->CloseCol();
		}
		$MainOutput->CloseRow();
		$Output = array(0=>new HTML,1=>new HTML,2=>new HTML,3=>new HTML,4=>new HTML,5=>new HTML,6=>new HTML);	
		$OldIDPiscine=$Rep['IDPiscine'];
	}
	
	
			$sh = intval($Rep['Start']/60/60);
			$sm = bcmod($Rep['Start'],3600)/60;
			if($sm==0)
				$sm="";
			
			$NbM = substr_count($Rep['Missing'],'M');
			$NbA = substr_count($Rep['Missing'],'A');
			$NbR = substr_count($Rep['Missing'],'R');
		
			//Dans le fonds on veut valider s'il manque un responsable parce qu'il y a un remplacement ou bien si c'est parce qu'il y en a jamais
			$SQL2 = new sqlclass;
			$Req2 = "SELECT sum(IDEmploye) FROM ressource WHERE isnull(IDCours) and IDPeriode IN".get_periode_string($Rep['IDPeriode'],TRUE);

			$SQL2->SELECT($Req2);
			$Rep2 = $SQL2->FetchArray();
			if($Rep2[0]>0){
				$Output[$Rep['Jour']]->Addlink('index.php?Section=Periode&IDPeriode='.$Rep['IDPeriode'],$sh."h".$sm,'','TitreLink');
				$Output[$Rep['Jour']]->AddTexte("(<font color=green>".$NbR."</font> - <font color=Red>".$NbM."</font> - <font color=Blue>".$NbA."</font>)");
				$Output[$Rep['Jour']]->br();
			}elseif($NbA-$NbM<>0){
				//Dans le fond il n'y a juste pas de responsable. Est-ce qu'il manque des remplacements?
				$Output[$Rep['Jour']]->Addlink('index.php?Section=Periode&IDPeriode='.$Rep['IDPeriode'],$sh."h".$sm,'','TitreLink');
				$Output[$Rep['Jour']]->AddTexte("(<font color=green>0</font> - <font color=Red>".$NbM."</font> - <font color=Blue>".$NbA."</font>)");
				$Output[$Rep['Jour']]->br();				
			}
			// dans les autres cas il peut manquer un responsable, mais c'est parce que yen manque toujours ET qu'il manque pas d'autres monit
	}

if($Start){
$PiscineInfo = get_info('piscine',$OldIDPiscine);
		$MainOutput->OpenTable();
		$MainOutput->OpenRow();
		$MainOutput->OpenCol('100%',7);
			$MainOutput->AddTexte("<div align=center><b>".$PiscineInfo['Nom']."</b></div>");
		$MainOutput->CloseCol();
		$MainOutput->CloseRow();
		
		$MainOutput->OpenRow();
		for($d=0;$d<7;$d++){
			$MainOutput->OpenCol();
			

			$MainOutput->OpenTable(115);
			$MainOutput->OpenRow();
			$MainOutput->OpenCol(115,2);
			$MainOutput->AddPic('carlos.gif','width=115, height=1');
			$MainOutput->CloseCol();
			$MainOutput->CloseRow();
			$MainOutput->OpenRow();
			$MainOutput->OpenCol(16);
			$MainOutput->AddLink('index.php?Section=Batch_Remplace&Jour='.$d.'&Semaine='.$_GET['Semaine'].'&IDPiscine='.$OldIDPiscine,'<img src=images/empl.png border=0>');			
			$MainOutput->CloseCol();
			$MainOutput->OpenCol();
			
			$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
			$MainOutput->addtexte("<div align=center>".$CJour[$d]."</div>", 'Titre');
            $Date = get_date($Dates[$d]);
			$MainOutput->addtexte("<div align=center>".$Date['d']."-".$Month[intval($Date['m'])]."</div>", 'Titre');
			$MDay[$d] = $Date['d']."-".$Month[intval($Date['m'])];
			
			$MainOutput->CloseCol();
			$MainOutput->CloseRow();
			$MainOutput->CloseTable();	
			$MainOutput->CloseCol();
			
		}
	
		$MainOutput->CloseRow();
		$MainOutput->OpenRow();
		for($d=0;$d<7;$d++){
			$MainOutput->OpenCol();
			$MainOutput->AddOutput("<div align=center>".$Output[$d]->Send(1)."</div>",0,0);
			$MainOutput->CloseCol();
		}
		$MainOutput->CloseRow();
		$Output = array(0=>new HTML,1=>new HTML,2=>new HTML,3=>new HTML,4=>new HTML,5=>new HTML,6=>new HTML);	
}else{
		$MainOutput->OpenTable();
		$MainOutput->OpenRow();
		for($d=0;$d<7;$d++){
			$MainOutput->OpenCol();
			$MainOutput->AddPic('carlos.gif','width=125, height=1');
			$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
			$MainOutput->addtexte("<div align=center>".$CJour[$d]."</div>", 'Titre');
            $Date = get_date($Dates[$d]);
			$MainOutput->addtexte("<div align=center>".$Date['d']."-".$Month[intval($Date['m'])]."</div>", 'Titre');
			$MDay[$d] = $Date['d']."-".$Month[intval($Date['m'])];
			$MainOutput->CloseCol();	
		}
		$MainOutput->CloseRow();
	}
		$MainOutput->CloseTable();
echo $MainOutput->Send(1);
?>
