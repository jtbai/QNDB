<?PHP
if(isset($_GET['FORMIDPaye'])){
$Req = "select Distinct piscine.IDPiscine, Nom FROM piscine JOIN periode On piscine.IDPiscine = periode.IDPiscine WHERE IDSession=".$_ACTIVE['Session'];
$SQL->SELECT($Req);
$TOTALCASH = 0;
$TOTALH = 0;
while($Rep = $SQL->FetchArray())
	$Piscine[$Rep[0]] = $Rep[1];

if(!isset($TimeSheet)){
	//prepare the array
	$TimeSheet = array();
	$Req = "SELECT * FROM timesheet WHERE IDPaye=".$_GET['FORMIDPaye']." AND (`0`+`1`+`2`+`3`+`4`+`5`+`6`+`7`+`8`+`9`+`10`+`11`+`12`+`13`+`Ajustement`)*Salaire<>0 ORDER BY IDEmploye ASC, Role ASC, Salaire ASC";
	$SQL->select($Req);
	$OLDID = 0;
	$OLDSalaire = 0;
	while($Rep = $SQL->FetchArray()){
		if($OLDID<>$Rep['IDEmploye'] OR $OLDSalaire<>$Rep['Salaire']){
			$TimeSheet[$Rep['IDEmploye']][$Rep['Role']][$Rep['Salaire']]['Ajustement']=0;
			$OLDID = $Rep['IDEmploye'];
			$OLDSalaire = $Rep['Salaire'];
		}
		$TimeSheet[$Rep['IDEmploye']][$Rep['Role']][$Rep['Salaire']][$Rep['IDPiscine']] = array('0'=>$Rep['0'],'1'=>$Rep['1'],'2'=>$Rep['2'],'3'=>$Rep['3'],'4'=>$Rep['4'],'5'=>$Rep['5'],'6'=>$Rep['6'],'7'=>$Rep['7'],'8'=>$Rep['8'],'9'=>$Rep['9'],'10'=>$Rep['10'],'11'=>$Rep['11'],'12'=>$Rep['12'],'13'=>$Rep['13']);
		$TimeSheet[$Rep['IDEmploye']][$Rep['Role']][$Rep['Salaire']]['Ajustement'] = $TimeSheet[$Rep['IDEmploye']][$Rep['Role']][$Rep['Salaire']]['Ajustement']+$Rep['Ajustement'];
		$TimeSheet[$Rep['IDEmploye']][$Rep['Role']][$Rep['Salaire']]['Heures'] = $Rep['Heures'];
	}
		
}

$VJour = array('0'=>0,'1'=>0,'2'=>0,'3'=>0,'4'=>0,'5'=>0,'6'=>0,'7'=>0,'8'=>0,'9'=>0,'10'=>0,'11'=>0,'12'=>0,'13'=>0);

$MainOutput->OpenTable('300');
$MainOutput->OpenRow();

	$PayeInfo = get_info('paye',$_GET['FORMIDPaye']);
$Time = get_end_dates(1,$PayeInfo['Semaine1']);
if(!$ToPrint){
	$MainOutput->OpenCol('',5); // Zone Vide en haut
	$MainOutput->AddPic('carlos.gif','width=280, height=1');
	//$MainOutput->br();
	$MainOutput->AddLink('index.php?Section=Form_Ajustement&IDPaye='.$_GET['FORMIDPaye'],'<img src=images/insert.png BORDER=0>');
	$MainOutput->AddLink('index.php?Section=Display_Timesheet&FORMIDPaye='.$_GET['FORMIDPaye'].'&ToPrint=TRUE','<img src=images/print.png BORDER=0>');
	$MainOutput->addlink('index.php?Action=Delete_Paye&IDPaye='.$_GET['FORMIDPaye'],'<img border=0 src=images/delete.png>');

}else{
$MainOutput->OpenCol('',7); // Zone Vide en haut
}
$MainOutput->AddOutput('<div align=center>',0,0);
$MainOutput->AddTexte('Paye #'.$PayeInfo['No'].': '.$Time['Start'].' au '.$Time['End'],'Titre');
$MainOutput->AddOutput('</div>',0,0);
	

$MainOutput->CloseCol();
if(!$ToPrint){
	foreach($Piscine as $IDPiscine => $PNom){
	$MainOutput->OpenCol('350',15,'top','b');
		$MainOutput->AddTexte('<div align=center>'.$PNom.'</div>','Titre');
	$MainOutput->CloseCol();
	}
}
$MainOutput->CloseRow();
$MainOutput->OpenRow();
$MainOutput->OpenCol('20'); // Zone IDEmploye
	$MainOutput->AddTexte('ID','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol('75'); // Zone Nom
	$MainOutput->AddTexte('Nom','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol('75'); // Zone Prenom
	$MainOutput->AddTexte('Prenom','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol('25'); // Zone Prenom
	$MainOutput->AddTexte('Role','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol('40'); // Zone Prenom
	$MainOutput->AddTexte('Salaire','Titre');
$MainOutput->CloseCol();

if(!$ToPrint){
	$DList = get_day_list("court");
	Foreach($Piscine as $IDPiscine => $PNom){
		foreach($DList as $k=>$v){
			if($k==0)
				$MainOutput->OpenCol('25',1,'top','l');
			else
				$MainOutput->OpenCol('25');
				$MainOutput->AddTexte('<div align=center>'.$v.'</div>','Titre');
			$MainOutput->CloseCol();
		}	
		foreach($DList as $k=>$v){
			$MainOutput->OpenCol('25');
				$MainOutput->AddTexte('<div align=center>'.$v.'</div>','Titre');
			$MainOutput->CloseCol();
		}
		$MainOutput->OpenCol(30,1,'top','rl');
			$MainOutput->AddTexte('S-T','Titre');
		$MainOutput->CloseCol();
	}
}
				if(!$ToPrint){
$MainOutput->OpenCol('30',1,'top','b'); // 
	$MainOutput->AddTexte('Total','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol('30',1,'top','b'); // 
	$MainOutput->AddTexte('Ajt','Titre');
$MainOutput->CloseCol();
}else{

$MainOutput->OpenCol('30',1,'top','b'); // 
	$MainOutput->AddTexte('Sem1','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol('30',1,'top','b'); // 
	$MainOutput->AddTexte('Sem2','Titre');
$MainOutput->CloseCol();
}
$MainOutput->OpenCol('30',1,'top','b'); // 
	$MainOutput->AddTexte('Total&nbsp;H','Titre');
$MainOutput->CloseCol();
$MainOutput->OpenCol('30',1,'top','rl'); // 
	$MainOutput->AddTexte('Total&nbsp;$','Titre');
$MainOutput->CloseCol();

$c = "two";
foreach($TimeSheet as $IDEmploye =>$v1){
$InfoE = get_info('employe',$IDEmploye);
	foreach($v1 as $Role => $v2){
		
		foreach($v2 as $Salaire => $v3){
			if($c=="two")
				$c="one";
			else
				$c="two";
			
			$MainOutput->OpenRow('',$c);
				$MainOutput->OpenCol('20',1,'top','bl'); // Zone IDEmploye
			$MainOutput->AddTexte($IDEmploye);
			$MainOutput->CloseCol();

			$MainOutput->OpenCol('60',1,'top',$c); // Zone Nom
				$MainOutput->AddTexte($InfoE['Nom']);
			$MainOutput->CloseCol();
			$MainOutput->OpenCol('60',1,'top',$c); // Zone Prenom
				$MainOutput->AddTexte($InfoE['Prenom']);
			$MainOutput->CloseCol();
			$MainOutput->OpenCol('25',1,'top',$c); // Zone Prenom
				$MainOutput->AddTexte($Role);
			$MainOutput->CloseCol();
			$MainOutput->OpenCol('40',1,'top','br'); // Zone Prenom
				$MainOutput->AddTexte($Salaire);
			$MainOutput->CloseCol();
			$Total =0;			
			$Semaine1 =0;
			$Semaine2 =0;
			foreach($Piscine as $IDPiscine => $Nom){
			$j=0;
				if(!isset($TimeSheet[$IDEmploye][$Role][$Salaire][$IDPiscine]))
					$TimeSheet[$IDEmploye][$Role][$Salaire][$IDPiscine]=$VJour;
				
				foreach($TimeSheet[$IDEmploye][$Role][$Salaire][$IDPiscine] as $v){
					if(!$ToPrint){
						$MainOutput->OpenCol('25',1,'top',$c);
						if($v==0)
							$v="&nbsp;";
							$MainOutput->AddTexte($v);
						$MainOutput->CloseCol();
						}
						if($j<7)
							$Semaine1=$Semaine1+$v;
						else
							$Semaine2=$Semaine2+$v;
					$j++;
					
				}
				$STotal = array_sum($TimeSheet[$IDEmploye][$Role][$Salaire][$IDPiscine])*$TimeSheet[$IDEmploye][$Role][$Salaire]['Heures'];
				$Total = $Total + $STotal;
				if(!$ToPrint){
				$MainOutput->OpenCol(25,1,'top','rl');
					$MainOutput->AddTexte($STotal,'Titre');
				$MainOutput->CloseCol();
				}
				
			
			}
			$Ajustement = $TimeSheet[$IDEmploye][$Role][$Salaire]['Ajustement'];
			$Heures = $TimeSheet[$IDEmploye][$Role][$Salaire]['Heures'];
				
				if(!$ToPrint){
				$MainOutput->OpenCol(30,1,'top','b');
					$MainOutput->AddTexte($Total);
				$MainOutput->CloseCol();
				$MainOutput->OpenCol(30,1,'top','b');
					$MainOutput->AddTexte($Ajustement*$Heures);
				$MainOutput->CloseCol();
				}else{
				$MainOutput->OpenCol(30,1,'top','b');
					$MainOutput->AddTexte($Semaine1);
				$MainOutput->CloseCol();
				$MainOutput->OpenCol(30,1,'top','b');
					$MainOutput->AddTexte($Semaine2);
				$MainOutput->CloseCol();
				}
				
				
				$MainOutput->OpenCol(30,1,'top','b');
					$MainOutput->AddTexte(($Total+$Ajustement)*$Heures,'Titre');
				$MainOutput->CloseCol();

				$MainOutput->OpenCol(30,1,'top','rl');
				if($Heures==0)
					$Class = "Warning";
				else
					$Class = "Titre";
					$TOTALCASH = $TOTALCASH + ($Total+$Ajustement)*$Salaire;
					$TOTALH = $TOTALH + ($Total+$Ajustement)*$Heures;
					$MainOutput->AddTexte(number_format(($Total+$Ajustement)*$Salaire,2)."&nbsp;$",$Class);
				$MainOutput->CloseCol();
			$MainOutput->CloseRow();
		}
	}
}
$MainOutput->CloseTable();
$MainOutput->AddTexte('Total Cash: '.number_format($TOTALCASH,2)." $",'Titre');
$MainOutput->br();
$MainOutput->AddTexte('Total Heure: '.number_format($TOTALH,2)." h",'Titre');

}else{

	$MainOutput->AddForm('Vérifier une paye','index.php','GET');
	$MainOutput->inputhidden_env('Section','Display_Timesheet');
	$Opt = array();
	$Req = "SELECT IDPaye, Semaine1, No FROM paye ORDER BY Semaine1 DESC LIMIT 0,2615";
	$SQL->SELECT($Req);
	while($Rep = $SQL->FetchArray()){
		$Sem = get_end_dates(1,$Rep[1]);
		$Opt[$Rep[0]] = "#".$Rep[2]." : ".$Sem['Start']." au ".$Sem['End'];
	}
	$MainOutput->inputselect('IDPaye',$Opt,'0','Paye Allant du');
	$MainOutput->formsubmit('Afficher');
}
echo $MainOutput->Send(1);
?>