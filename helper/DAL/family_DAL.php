<?php

class family_DAL extends baseDAL
{

    public function __construct()
    {

        $this->DAL_Field = array(
            'IDFamily',
            'Name',
            'City',
            'Address',
            'PostalCode',
            'Email',
            'Telephone',
            'LastVisited'
        );
        $this->DAL_FieldType = array(
            'IDFamily' => 'Integer',
            'Name' => 'String',
            'City' => 'String',
            'Address' => 'String',
            'PostalCode' => 'String',
            'Email' => 'String',
            'Telephone' => 'String',
            'LastVisited' => 'Integer'
        );
    }

    function search_by_id($ID)
    {
        $myFamily = new family();
        $this->PushArrayIntoInfo("Family", $this->get_data_byID($ID, 'family'), $myFamily);
        return $myFamily;
    }

    function get_list($Arg = NULL)
    {


        if (is_null($Arg)) {
            $families = $this->get_data_list("family",$Field="Name, Address, Telephone",1,"Name ASC");

        } elseif (is_array($Arg)) {
            # comment on gère l'injection de filtres dans le query string...?
        }

        $myFamilies = array();
        foreach ($families as $ID => $family) {
            $myFamily = new family();
            $this->PushArrayIntoInfo("Family", $family, $myFamily);
            $myFamilies[$ID] = $myFamily;
        }
        return $myFamilies;
    }

    function generate($Arg)
    {
        $myFamily = new family();
        $this->PushArrayIntoInfo('family', $Arg, $myFamily);
        return $myFamily;
    }


    function save($family)
    {
        $this->base_save("family", $family);
    }

}
