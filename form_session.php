<?PHP
$MainOutput->AddForm('Ajouter/Modifier une session');
$MainOutput->inputhidden_env('Action','Session');
if(isset($_GET['IDSession'])){
	$Info = get_info('session',$_GET['IDSession']);
	$MainOutput->inputhidden_env('UPDATE',TRUE);
	$MainOutput->inputhidden_env('IDSession',$_GET['IDSession']);
}else{
	$Session = get_active('session',1,'IDSession','DESC');
	foreach($Session as $v){
		if($v['Saison']=="H"){
			$Saison = "P";
			$Annee = $v['Annee'];
		}elseif($v['Saison']=="P"){
			$Saison = "E";
			$Annee = $v['Annee'];
		}elseif($v['Saison']=="E"){
			$Saison = "A";	
			$Annee = $v['Annee'];
		}elseif($v['Saison']=="A"){
			$Saison = "H";
			$Annee = $v['Annee']+1;
		}
	}
	$Info = array('Saison'=>$Saison,'Annee'=>$Annee);
	$MainOutput->inputhidden_env('UPDATE',FALSE);
}
$Saison = array('H'=>'Hiver','P'=>'Printemps','E'=>'Été','A'=>'Automne');
$MainOutput->inputselect('Saison',$Saison,$Info['Saison'],'Saison');
$Year1 = date("Y", strtotime("This Year"));
$Year2 = date("Y", strtotime("Year + 1"));
$Annee = array($Year1=>$Year1,$Year2=>$Year2);
$MainOutput->inputselect('Annee',$Annee,$Info['Annee'],'Année');
$MainOutput->formsubmit();
echo $MainOutput->Send(1);
?>