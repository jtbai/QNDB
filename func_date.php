<?PHP
function get_last_sunday($Delta=0, $Time=""){
/**
	if($Time=="")
		$Time=time();
	$NowDay = date('w',$Time);
	$NowHour = date('G',$Time);
	$NowMin = date('i',$Time);
	$NowSec = date('s',$Time);
	$Mod = $NowSec+60*($NowMin+60*($NowHour+24*($NowDay+7*$Delta)));
	$Stamp = $Time - $Mod;
	return $Stamp;
 * 
 */
 
     if($Time=="")
        $Time = time();
    $InitialWeekDay = intval(date("w",$Time));
    $InitialHour = intval(date("G",$Time));
    $InitialMinute = intval(date("i",$Time));
    $InitialSecond = intval(date("s",$Time));

    $ProjectedTime = $Time;
/**
    
    $ProjectedWeekDay = intval(date("w",$ProjectedTime));
    $ProjectedHour = intval(date("G",$ProjectedTime));
    $ProjectedMinute = intval(date("i",$ProjectedTime));
    $ProjectedSecond = intval(date("s",$ProjectedTime));
     **/

    
        $ProjectedTime = $Time - 60*60*24*7*$Delta; 
       
           




$TimeToReturn = $ProjectedTime - ( $InitialSecond + 60 * ($InitialMinute + 60 * ($InitialHour + 24 * $InitialWeekDay)));
        
        $ProjectedWeekDay = intval(date("w",$TimeToReturn));
        $ProjectedHour = intval(date("G",$TimeToReturn));
        $ProjectedMinute = intval(date("i",$TimeToReturn));
        $ProjectedSecond = intval(date("s",$TimeToReturn));
        
        if($ProjectedHour==23)
            $TimeToReturn += 3600;
        elseif($ProjectedHour==1)
            $TimeToReturn -= 3600;
        
        return $TimeToReturn;
  	
}

function generate_sql_extended_semaine_query($semaine){
	# This is a 100% Patch,
	# Daylight Saving (DLS) is problematic across the software and
	# Semaine Variable sometime is with or without DLS, and session where there is an hour change,
	# everything fucks up. This request is intended to search for semaine + or - one hour
	# of the initial semaine variable passed. This is heavy MYSQL syntax but yeah.

	$hour_duration = 60*60;
	$lower_end = $semaine - $hour_duration;
	$upper_end = $semaine + $hour_duration;
	$sql_statement = "Semaine IN (".$lower_end.",".$upper_end.",".$semaine.")";

	return $sql_statement;
}


function generate_reverse_index_for_semaine_extended_query($semaine_array){
	# This is the reverse function of the generate_sql_extended_semaine_query
	# This reverse index allows to know which "real" semaine is associated to a
	# semaine found in the database. This function is mostly useful
	# When there is a request that handles more than one "extended week" such as
	# the pay generation script.
	# This function is using a semaine array to reflects this purpose.
	$hour_duration = 60*60;
	$reverse_index = array();
	foreach($semaine_array as $semaine){
		$lower_end = $semaine - $hour_duration;
		$upper_end = $semaine + $hour_duration;

		$reverse_index[$lower_end] = $semaine;
		$reverse_index[$semaine] = $semaine;
		$reverse_index[$upper_end] = $semaine;
	}

	return $reverse_index;
}

function get_age($Time){
	if($Time==0){
		return "N/A";
	}
	
	$Mois = intval(date('n',$Time));
	$Jour = intval(date('j',$Time));
	$Annee= intval(date('Y',$Time));
	
	$TMois = intval(date('n',Time()));
	$TJour = intval(date('j',Time()));
	$TAnnee = intval(date('Y',Time()));
	
		if($TMois==$Mois AND $TJour>=$Jour)
			return $TAnnee-$Annee;
		elseif($TMois>$Mois)
			return $TAnnee-$Annee;
		else
			return $TAnnee-$Annee-1;
}


function get_end_dates($Lag=0,$Time=""){
	if($Time=="")
		$Time=time();
	$Semaine = get_last_sunday(0,$Time);
	$Semaine2 = get_next_sunday($Lag,$Time) - 86400;
	$Time = get_date($Semaine);
	$Time2 = get_date($Semaine2);
	$Month = get_month_list('court');
	return array('Start'=>$Time['d']."-".$Month[intval($Time['m'])]."-".$Time['Y'],'End'=>$Time2['d']."-".$Month[intval($Time2['m'])]."-".$Time2['Y']);
}



function get_next_sunday($Delta=0,$Time=""){
	if($Time=="")
		$Time=time();
	return get_last_sunday(-($Delta+1),$Time);
}

function get_current_day($Lag=0,$Time=""){
	if($Time=="")
		$Time=time();
	$NowHour = date('G',$Time);
	$NowMin = date('i',$Time);
	$NowSec = date('s',$Time);
	$Mod = ($NowSec+60*($NowMin+60*($NowHour-24*$Lag)));
	$Stamp = $Time - $Mod; 
	return $Stamp;
}


function get_date($Time){
	$Output=array();
	
	if($Time>86400){
				$Hour = bcmod($Time,86400);
				$Output['d'] = date('d',$Time);
				$Output['m'] = date('m',$Time);
				$Output['Y'] = date('Y',$Time);
				$Time = $Hour;
			}
			$Output['i'] = bcmod($Time,3600)/60;
			$Output['G'] = ($Time-$Output['i']*60)/3600;

	return $Output;
}

function get_month_list($Len = "long"){
	if($Len<>"court"){
		return array(1=>'Janvier',2=>'F�vrier',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Ao�t',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'D�cembre');
	}
	return array(1=>'Janv',2=>'F�v',3=>'Mars',4=>'Avr',5=>'Mai',6=>'Juin',7=>'Juil',8=>'Ao�t',9=>'Sept',10=>'Oct',11=>'Nov',12=>'D�c');
}
function get_day_list($Len = "Long"){
	if($Len<>"court"){
		return array(0=>'Dimanche',1=>'Lundi',2=>'Mardi',3=>'Mercredi',4=>'Jeudi',5=>'Vendredi',6=>'Samedi');
	}
	return array(0=>'Dim',1=>'Lun',2=>'Mar',3=>'Mer',4=>'Jeu',5=>'Ven',6=>'Sam');

}

function is_ferie($Date){

	$Date = getdate($Date);
	$Ferie = FALSE;

	//Jour De L'an
	if($Date['mon']==1 && $Date['mday']==1)
		$Ferie = TRUE;
	//P�cques
	
	$M = $Date['year'];
	$n = $M-1900;
    $a = bcmod($n,19);
	$b = floor(($a*7+1)/19);
	$c = bcmod(11*$a-$b+4,29);
	$d = floor($n/4);
	$e = bcmod($n-$c+$d+31,7);
	$P = 25 - $c - $e;
	
	$Pacques = getdate(mktime(0,0,0,'3',31+$P+1,$Date['year']));
	if($Pacques['mon']==$Date['mon'] && $Pacques['mday']==$Date['mday'])
		$Ferie = TRUE;
	
	
	//F�te des patriotes
		$FetePatriotes = getdate(mktime(0,0,0,'5','25',$Date['year']));
	if($Date['mon']==5){
		if($FetePatriotes['wday']==0){
			if($Date['mday']==19){
				$Ferie = TRUE;
			}
		}elseif($FetePatriotes['wday']==1){
			if($Date['mday']==25){
				$Ferie = TRUE;
			}
		}else{
		$FetePatriotes = 26-$FetePatriotes['wday'];
			if($Date['mday']==$FetePatriotes)
				$Ferie = TRUE;
		}
	}	
	
	
	//St-Jean
	if($Date['mon']==6 && $Date['mday']==24)
		$Ferie = TRUE;
	//Conf�d�ration
	if($Date['mon']==7 && $Date['mday']==1)
		$Ferie = TRUE;
	//F�te du travail
	$FeteTravail = getdate(mktime(0,0,0,'9','1',$Date['year']));
	if($Date['mon']==9){
		if($FeteTravail['wday']==0){
			if($Date['mday']==2){
				$Ferie = TRUE;
			}
		}elseif($FeteTravail['wday']==1){
			if($Date['mday']==1){
				$Ferie = TRUE;
			}
		}else{
		$FeteTravail = 9-$FeteTravail['wday'];
			if($Date['mday']==$FeteTravail)
				$Ferie = TRUE;
		}
	}	
	
	//Action de gr�ce
	$ActionGrace = getdate(mktime(0,0,0,'10','1',$Date['year']));
	if($Date['mon']==10){
		if($ActionGrace['wday']==0){
			if($Date['mday']==9){
				$Ferie = TRUE;
			}
		}elseif($ActionGrace['wday']==1){
			if($Date['mday']==8){
				$Ferie = TRUE;
			}
		}else{
		$ActionGrace = 16-$ActionGrace['wday'];
			if($Date['mday']==$ActionGrace)
				$Ferie = TRUE;
		}
	}	
	
	
	//Noel
	if($Date['mon']==12 && $Date['mday']==25)
		$Ferie = TRUE;
	
	return $Ferie;
}
function datetostr($TimeStamp){
	$Month = get_month_list('court');
	$Date = get_date($TimeStamp);
	$STRfinal = $Date['d']."-".$Month[intval($Date['m'])]." ".$Date['Y'];
	return $STRfinal;
}

function get_day_length($Time){
    //compute time needed to jump to the next day and get same shift profile
      $DayLength=60*60*24;
      
     $TimeTomorrow = intval(date("G",$Time + $DayLength));
     
     
                if($TimeTomorrow==23)
                    $DayLength+=60*60;
                elseif($TimeTomorrow==1)
                    $DayLength-=60*60;
                    
                    
                    return $DayLength;
                                       
}

?>
