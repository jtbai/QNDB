<?php
$MainOutput = new HTML();
$SQL = new SqlClass;
$Req = "SELECT Semaine, Jour, Start, IDPiscine, cours.IDCours, IDNiveau, Role 
    FROM periode 
    RIGHT JOIN cours using(IDPeriode) 
    RIGHT JOIN ressource Using(IDCours)
    WHERE IDEmploye = ".$_GET['IDEmploye']." AND Semaine>=".get_last_sunday()." ORDER BY Semaine ASC, Jour ASC, Start ASC";
$SQL->SELECT($Req);
$Semaine =0;
$NBSemaines =0 ;
$NBSemainesMAX = 2; //donc 3 semaines
$IDPiscine =0;
$Piscine = get_active('Piscine');
$Niveaux = get_niveau_list();

$MainOutput->OpenTable('100%');
$Output = array();

while($Rep = $SQL->FetchArray()){
    if($Rep['Semaine']<> $Semaine and $NBSemaines <= $NBSemainesMAX){
        $Semaine = $Rep['Semaine'];
        $Output[$Semaine] = array(0=>array(),1=>array(),2=>array(),3=>array(),4=>array(),5=>array(),6=>array());
        
        $NBSemaines++;
        }
    
    if($Semaine == $Rep['Semaine']){
        $Output[$Semaine][$Rep['Jour']][] = $Rep;
    }
    
}

$CJour = array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
        
                        

foreach($Output as $Semaine=>$Jour){
    $MainOutput->OpenRow('100%');                    
    for($d=0;$d<=6;$d++){

        $MainOutput->opencol(90);
        $MainOutput->addpic('images/carlos.gif','width=100, height=1');
        $MainOutput->addtexte("<div align=center>".$CJour[$d]."</div>", 'Titre');
                                $MainOutput->addtexte("<div align=center>".datetostr($Semaine+24*60*60*$d)."</div>", 'Titre');
        $MainOutput->closecol();

    }
    $MainOutput->CloseRow();
    $MainOutput->OpenRow('100%');
    foreach($Jour as $JourCourant => $Cours){
        $MainOutput->OpenCol('100%');
        foreach($Cours as $CoursCourant){
        if($IDPiscine <> $CoursCourant['IDPiscine']['IDPiscine']){
           $MainOutput->AddTexte($Piscine[$CoursCourant['IDPiscine']]['Nom'],'Titre');
           $MainOutput->br();
           $IDPiscine = $CoursCourant['IDPiscine']['IDPiscine'];  
        }
              
            $MainOutput->Addlink('index.php?Section=ModifieCours&AllSession=FALSE&IDCours='.$CoursCourant['IDCours'],$Niveaux[$CoursCourant['IDNiveau']]['Code']);
            $MainOutput->Addtexte("(".$CoursCourant['Role'].")",'Link2');
            $Date = get_date($CoursCourant['Start']);
            $MainOutput->Addtexte("- ".$Date['G'].":".$Date['i'],'Link2');
            $MainOutput->br();
            
        }
        $IDPiscine=0;
        $MainOutput->CloseCol();
    }
    $MainOutput->CloseRow();
}
$MainOutput->CloseTable();
echo $MainOutput->send(1);


/**
if($Rep['Semaine']<> $Semaine){
        
        $Semaine = $Rep['Semaine'];
        if($NBSemaines<>0)
                $MainOutput->CloseRow();
        $
        if($NBSemaines <= $NBSemainesMax)    
            $MainOutput->OpenRow();
    }
    
    if($NBSemaines <= $NBSemainesMax){
        
        
    }
**/

?>
