<?PHP

class family extends baseModel{

    public function init(){
        $this->Property = array(
            'IDFamily'=>0,
            'Name'=>'',
            'City'=>'Qu�bec',
            'Address'=>'',
            'PostalCode'=>'',
            'Email'=>'',
            'Telephone'=>'',
            'LastVisited'=>time(),
            'Members'=>array()
        );

    }

    public function __construct($Args=NULL){
        $this->init();
    }


}
?>