<?php

if (isset($_POST['Controller'])) {
    $Controller = $_POST['Controller'];
    if (isset($_POST['Action']))
        $Action = $_POST['Action'];
    else
        $Action = "PUT";
} elseif (isset($_GET['Controller'])) {
    $Controller = $_GET['Controller'];
    if (isset($_GET['Action']))
        $Action = $_GET['Action'];
    else
        $Action = "INDEX";
} else {
    $Controller = "Default";
    $Action = "INDEX";
}

if (isset($_GET['ID'])) {
    $ID = $_GET['ID'];
} else {
    $ID = NULL;
}


switch ($Controller) {

    CASE "family": {
        $ControllerInstance = new family_controller();
        BREAK;
    }

    CASE "household": {
        $ControllerInstance = new household_controller();
        BREAK;
    }

    CASE "Default": {
        $ControllerInstance = NULL;
        BREAK;
    }

}

if (!is_null($ControllerInstance)) {
    switch ($Action) {

        CASE "CREATE": {
            $ControllerInstance->CREATE($ID);
            BREAK;
        }

        CASE "INDEX": {
            $ControllerInstance->INDEX($ID);
            BREAK;
        }

        CASE "GET": {
            $ControllerInstance->GET($ID);
            BREAK;
        }

        CASE "EDIT": {
            $ControllerInstance->EDIT($ID);
            BREAK;
        }

        CASE "POST": {
            $ControllerInstance->POST(HTML::PreparePostData($_POST, 'FORM'));
            BREAK;
        }

        CASE "PUT": {
            $ControllerInstance->PUT(HTML::PreparePostData($_POST, 'FORM'));
            BREAK;
        }


    }
}