<?PHP

class family extends baseModel{

    public function init(){
        $this->DAL = array(
            'IDFamily'=>0,
            'Name'=>'',
            'City'=>'Québec',
            'Address'=>'',
            'PostalCode'=>'',
            'Email'=>'',
            'Telephone'=>'',
            'LastVisited'=>time()
        );
        $this->FieldType = array(
            'IDFamily'=>'Integer',
            'Name'=>'String',
            'City'=>'String',
            'Address'=>'String',
            'PostalCode'=>'String',
            'Email'=>'String',
            'Telephone'=>'String',
            'LastVisited'=>'Integer'
        );
        $this->Property = array();

    }

    public function __construct($Args=NULL){
        $this->init();
    }


}
?>