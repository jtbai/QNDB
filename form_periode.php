<?PHP
$MainOutput->AddForm('Ajouter une période de cours');
$MainOutput->InputHidden_Env('Action','AddPeriode');
$MainOutput->Inputtime('StartDate','Date&nbsp;de&nbsp;début',time(),array('Date'=>TRUE,'Time'=>FALSE));
$MainOutput->Inputtime('StartTime','Heure&nbsp;de&nbsp;début','',array('Date'=>FALSE,'Time'=>TRUE));
$MainOutput->Inputtext('NBP','Nombre&nbsp;de&nbsp;périodes',2);
$MainOutput->AddOutput('<tr>
<td><span class=Titre>Durée</span></td>
<td><span class=Texte>45 min<input type=Radio class=inputtext name=FORMDuree value=45 checked>  60 min<input type=Radio class=inputtext name=FORMDuree value=60>  Autre <input type=Text class=inputtext name=FORMDuree2 size=2></SPAN></td>
</tr>',0,0);
$MainOutput->Inputtext('NBC','Nombre&nbsp;de&nbsp;cours',2,8);
$Req = "SELECT IDPiscine, Nom FROM piscine WHERE Active ORDER BY Nom ASC";
$MainOutput->InputSelect('IDPiscine',$Req,0,'Piscine');
$MainOutput->FormSubmit('Ajouter');
echo $MainOutput->Send(1);

?>