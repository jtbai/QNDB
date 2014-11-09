<?PHP
//No, Nom, Prenom, Tel, Cell, Secteur, Qualif-Age

if($_GET['ToPrint'])
	$NBCol = 6;
else
	$NBCol = 8;


if(!isset($_GET['Cessation']))
	$_GET['Cessation']=0;

if(!isset($_GET['Session']))
	$_GET['Session']=$_ACTIVE['Session'];

if(!isset($_GET['Field'])){
	$_GET['Field']="employe.Nom";
}

if(!isset($_GET['Order'])){
	$_GET['Order']="ASC";
}

if($_GET['Order']=="ASC")
	$Unorder = "DESC";
else
	$Unorder = "ASC";




$MainOutput->OpenTable();
$MainOutput->OpenRow();
$MainOutput->OpenCol('100%',$NBCol);
	
	$MainOutput->AddLink('index.php?Section=FormEmploye','<img src=images/insert.png border=0>');

	
$SessionReq = "SELECT IDSession, Saison, Annee FROM session WHERE 1 ORDER BY IDSession DESC LIMIT 0,4";
$SQL->SELECT($SessionReq);
$Saison = array();
while($Rep = $SQL->FetchArray()){
	if($Rep[0]==$_GET['Session'])
		$MainOutput->Addlink('index.php?Section=EmployeList&Session='.$Rep[0],$Rep[1].substr($Rep[2],2),'','Titre');
	else
		$MainOutput->Addlink('index.php?Section=EmployeList&Session='.$Rep[0],$Rep[1].substr($Rep[2],2));
	$MainOutput->Addtexte(' - ');
}



$MainOutput->Addlink('index.php?Section=EmployeList&Session=','Pas rejoinds');
$MainOutput->Addtexte(' - ');
$MainOutput->Addlink('index.php?Section=EmployeList&Session=%','Tous');
$MainOutput->Addtexte(' - ');
$MainOutput->Addlink('index.php?Section=EmployeList&Cessation=1','Cessationnés');


$MainOutput->CloseCol();
$MainOutput->CloseRow();
$MainOutput->OpenRow();

$MainOutput->OpenCol('10');
$MainOutput->addtexte('&nbsp;');
$MainOutput->AddPic('carlos.gif','widht=150');

$MainOutput->CloseCol();

$MainOutput->OpenCol();
$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=IDEmploye&Order='.$Unorder.'&Cessation='.$_GET['Cessation'],'No');
$MainOutput->AddPic('carlos.gif','width=10  height=1');
$MainOutput->CloseCol();


$MainOutput->OpenCol();
$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=employe.Nom&Order='.$Unorder.'&Cessation='.$_GET['Cessation'],'Nom');
$MainOutput->AddPic('carlos.gif','width=100 height=1');
$MainOutput->CloseCol();

$MainOutput->OpenCol();
$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=Prenom&Order='.$Unorder.'&Cessation='.$_GET['Cessation'],'Prénom');
$MainOutput->AddPic('carlos.gif','width=100 height=1');
$MainOutput->CloseCol();

$MainOutput->OpenCol();
$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=TelP&Order='.$Unorder.'&Cessation='.$_GET['Cessation'],'Teléphone');
$MainOutput->AddPic('carlos.gif','width=100 height=1');
$MainOutput->CloseCol();

$MainOutput->OpenCol();
$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=Cell&Order='.$Unorder.'&Cessation='.$_GET['Cessation'],'Cellulaire');
$MainOutput->AddPic('carlos.gif','width=100 height=1');
$MainOutput->CloseCol();

if(!$_GET['ToPrint']){
	
	$MainOutput->OpenCol();
	$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=`Status`&Order='.$Unorder.'&Cessation='.$_GET['Cessation'],'Status');
$MainOutput->AddPic('carlos.gif','width=100 height=1');
	$MainOutput->CloseCol();
}
	$MainOutput->OpenCol();
	$MainOutput->addlink('index.php?Section=EmployeList&Session='.$_GET['Session'].'&Field=`DateNaissance`&Order='.$Unorder.'&Cessation='.$_GET['Cessation'],'Qualification');
$MainOutput->AddPic('carlos.gif','width=100 height=1');
	$MainOutput->CloseCol();

$MainOutput->CloseRow();
 
$SQL = new sqlclass;
$SQL2 = new sqlclass;

if($_GET['Cessation']==1){
$Req = "SELECT IDEmploye, employe.`Nom` , Prenom, TelP, Cell, `Status`, DateNaissance
FROM employe
WHERE `Cessation` ORDER BY ".$_GET['Field']." ".$_GET['Order'];	
}ELSE{
	if($_GET['Session'] == "%"){
		$Req = "SELECT IDEmploye, employe.`Nom` , Prenom, TelP, Cell, `Status`, DateNaissance
		FROM employe
		WHERE !`Cessation` ORDER BY ".$_GET['Field']." ".$_GET['Order'];
	}else{
		$Req = "SELECT IDEmploye, employe.`Nom` , Prenom, TelP, Cell, `Status`, DateNaissance
		FROM employe
		WHERE `Session` = '".$_GET['Session']."' AND !`Cessation` ORDER BY ".$_GET['Field']." ".$_GET['Order'];
	}
}
$SQL->SELECT($Req);
$c="two";

while($v = $SQL->FetchArray()){



if($c=="two")
	$c="one";
else
	$c="two";
$MainOutput->OpenRow('',$c);
		
		$MainOutput->OpenCol('10');
		$MainOutput->addlink('index.php?Section=FormEmploye&IDEmploye='.$v[0],'<img src=images/edit.png border=0>');
		$MainOutput->CloseCol();
		$MainOutput->OpenCol('20');
		$MainOutput->addtexte($v[0]);
		$MainOutput->CloseCol();
		$MainOutput->OpenCol('100');
		$MainOutput->addtexte($v[1]);
		$MainOutput->CloseCol();
		$MainOutput->OpenCol('100');
		$MainOutput->addtexte($v[2]);
		$MainOutput->CloseCol();
		
		if(strlen($v[3])<10)
			$v[3]="";
		else
			$v[3] = "(".substr($v[3],0,3).") ".substr($v[3],3,3)."-".substr($v[3],6,4);
		
		$MainOutput->OpenCol(40);
		$MainOutput->addtexte($v[3]);
		$MainOutput->CloseCol();
		
		if(strlen($v[4])<10)
			$v[4]="";
		else
			$v[4] = "(".substr($v[4],0,3).") ".substr($v[4],3,3)."-".substr($v[4],6,4);
		
		$MainOutput->OpenCol(40);
		$MainOutput->addtexte($v[4]);
		$MainOutput->CloseCol();
if(!$_GET['ToPrint']){
		$MainOutput->OpenCol('100');
		$MainOutput->addtexte($v[5]);
		$MainOutput->CloseCol();
		}
	$Req2 = "SELECT Qualification, Expiration FROM link_employe_qualification JOIN qualification ON qualification.IDQualification = link_employe_qualification.IDQualification WHERE IDEmploye = ".$v[0]." ORDER BY link_employe_qualification.IDQualification ASC";
	$SQL2->SELECT($Req2);
	$Qualif="<span class=Titre>".get_age($v[6])."</span>";
	$New = TRUE;
	
	While($Rep = $SQL2->FetchArray()){
		$Class='Texte';
		$Now = getdate(time());
		$Date = mktime(0,0,0,$Now['mon'],1,$Now['year']);
		if($Rep['Expiration']<$Date)
			$Class='Warning';
		
		if($New){
			$Qualif .= ":<span class=".$Class."> ".$Rep[0]."</span>";			
			$New=FALSE;
		}else{
			$Qualif = $Qualif."<span class=Texte> - </span><span class=".$Class.">".$Rep[0]."</span>";
		}
	}
	
	$MainOutput->OpenCol('100');	
	$MainOutput->addoutput($Qualif,0,0);
	$MainOutput->CloseCol();		
		
		
$MainOutput->CloseRow();
}
$MainOutput->CloseTable();
echo $MainOutput->Send(1);





?>