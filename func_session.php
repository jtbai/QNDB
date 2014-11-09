<?PHP
function WriteAccess($IDSession=NULL){
	if($IDSession==NULL){
		$Session = get_active('session',1,'IDSession');
		foreach($Session as $v){
			$IDSession = $v['IDSession'];
		}
	}
	$Info = get_info('session',$IDSession);
	return $Info['WriteAccess'];
}
?>