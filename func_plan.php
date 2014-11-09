<?PHP
function render($IDPeriode,$ToPrint=FALSE){

//Couleur de remplacement
IF(!$ToPrint){
$Mon = "#FF6A6F";
$Ass = "#EFB845";
$Safe = "#FFFFFF";
}else{
$Mon = "#FFFFFF";
$Ass = "#FFFFFF";
$Safe = "#FFFFFF";
}
//
	$Output = new HTML();
	$PerInfo = get_info('periode',$IDPeriode);
	$PlanInfo = get_info('plan',$PerInfo['IDPlan']);
	$Req = "SELECT NoZone, zone.IDCours FROM zone JOIN periode JOIN cours ON cours.IDPeriode = periode.IDPeriode AND zone.IDCours = cours.IDCours WHERE periode.IDPeriode = ".$IDPeriode." ORDER BY NoZone ASC";
	$SQL = new sqlclass();
	$SQL->SELECT($Req);
	$Zone = array();
	while($Rep = $SQL->FetchArray()){
		$Zone[$Rep['NoZone']] = $Rep['IDCours'];
	}
	$Req = "SELECT IDCours, Role
		FROM ressource
		WHERE IDPeriode =".$IDPeriode." AND IDEmploye=0";

	$SQL->SELECT($Req);
	$Monit = array();
	while($Rep = $SQL->FetchArray())
		$Monit[$Rep['IDCours']] = $Rep['Role'];
	if(!$ToPrint)
		$Output->AddOutput("<FORM method=POST action=index.php>",0,0);
	$Output->inputhidden_env('Action','CoursPlan');
	$Output->inputhidden_env('IDPeriode',$IDPeriode);
	foreach( file('plan/'.$PlanInfo['Fichier']) as $line){
		if($Zonage = strstr($line,'<-')){
			$InsZone = "";
			$NoZone = substr($Zonage,2,1);
			if($ToPrint){
				if(isset($Zone[$NoZone])){
					$CoursInfo = get_info('cours',$Zone[$NoZone]);
					$NiveauInfo = get_info('niveau',$CoursInfo['IDNiveau']);
					$InsZone = "<span class='Titre'>".$NiveauInfo['Niveau']."</span>";	
					$InsZone .= "<br><br>";
				}else{
					$Zone[$NoZone]=0;
					$InsZone .= "&nbsp;";
				}
			}else{
				$Req = "SELECT cours.IDCours, Niveau FROM niveau JOIN cours ON cours.IDNiveau = niveau.IDNiveau WHERE cours.IDPeriode=".$IDPeriode." ORDER BY Rank ASC";
				if(!isset($Zone[$NoZone])){
					$Zone[$NoZone]=0;
					$SQL->SELECT($Req);
					$InsZone .= "<SELECT name=Zone".$NoZone." class=InputSelect>";
					$InsZone .= "<option>&nbsp;</option>";
					while($Rep = $SQL->FetchArray()){
						$Selected="";
						if($Zone[$NoZone]==$Rep['IDCours'])
							$Selected="SELECTED";
						$InsZone .= "<option name=Zone".$NoZone." value=".$Rep['IDCours']." ".$Selected.">".$Rep['Niveau']."</option>"; 
					}
					$InsZone .= "</Select>";
				}else{
					$CoursInfo = get_info('cours',$Zone[$NoZone]);
					$NiveauInfo = get_info('niveau',$CoursInfo['IDNiveau']);
					$InsZone = "<a href=index.php?Section=ModifieCours&AllSession=FALSE&IDCours=".$Zone[$NoZone]."><span class='Titre'>".$NiveauInfo['Niveau']."</span></a>";	
					$InsZone .= "<br><br>";
				}
			}
			if(isset($Zone[$NoZone])){
			$Req = "SELECT Nom, Prenom, NoRessource FROM employe JOIN ressource JOIN cours ON ressource.IDCours = cours.IDCours AND ressource.IDEmploye = employe.IDEmploye WHERE cours.IDCours =".$Zone[$NoZone]." ORDER BY NoRessource ASC";
			$SQL->SELECT($Req);
				while($Rep = $SQL->FetchArray()){
					$InsZone .= "<span class='Texte'>".$Rep['Prenom']." ".$Rep['Nom']."</span><br>";
				}
			}	

		//check s'il manque un mon sur cette période la
			if(isset($Monit[$Zone[$NoZone]])){
				if($Monit[$Zone[$NoZone]]=="M")
					$line = ereg_replace('bgcolor=#FFFFFF','bgcolor='.$Mon,$line);
				else
					$line = ereg_replace('bgcolor=#FFFFFF','bgcolor='.$Ass,$line);
				
			}
				$Output->addOutput(ereg_replace('<-'.$NoZone.'->',$InsZone,$line),0,0);			
			
		}else
			$Output->addOutput($line,0,0);
	}
	if(!$ToPrint){
		$Output->addoutput("<div align=center><a href=index.php?Action=Destroy_Plan&IDPeriode=".$IDPeriode."><img src=images/delete.png border=0></a> ",0,0);
		$Output->addoutput("<a href=index.php?Section=Periode&IDPeriode=".$IDPeriode."&ToPrint=TRUE target=_BLANK><Span class=Titre><img src=images/print.png border=0></SPAN></a>",0,0);
		$Output->addoutput("<a href=index.php?Section=Modifie_Periode&FORMIDPeriode=".$IDPeriode."><Span class=Titre><img src=images/edit.png border=0></SPAN></a>",0,0);
		$Output->addoutput("<input type=submit value=Sauvegarder> 	</div>",0,0);
		
		$Output->addoutput("</form>",0,0);
	}
	return $Output->Send(1);
}

function inspect_plan($IDPlant){
	$SQL = new sqlclass();
	$Rep = get_info('plan',$IDPlant);
	$Output = new HTML;
	$Output->OpenTable();
	$Output->OpenRow();
	$Output->OpenCol();
		$Output->AddTexte("<div align=center>".$Rep['Nom']." - ".$Rep['Fichier']."</div>",'Titre');
	$Output->CloseCol();
	$Output->CloseRow();
	$Output->OpenRow();
	$Output->OpenCol();
	$Plan = file('plan/'.$Rep['Fichier']);
	foreach($Plan as $v)
		$Output->addoutput($v,0,0);
	$Output->CloseCol();
	$Output->CloseRow();
	$Output->CloseTable();
	return $Output->Send(1);
}


?>