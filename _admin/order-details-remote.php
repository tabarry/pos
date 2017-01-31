<?php

include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();

//Validation array
$validateAsArray = array('orderdet__Code_validateas' => 'required', 'orderdet__Name_validateas' => 'required', 'orderdet__Price_validateas' => 'float', 'orderdet__Quantity_validateas' => 'int',);
//---------
//Check to stop page opening outside iframe
//Deliberately disabled for list and delete conditions
$do = suSegment(1);
if (($_GET["do"] != "check") && ($_GET["do"] != "autocomplete")) {
    suFrameBuster();
}
?>
<?php

//Add record
if ($do == "add") {
//Check referrer
    suCheckRef();
//Validate
    $vError = array();

//
//Validate entire form in one go using the DB Structure
//To skip validation set '*' to '' like: $dbs_sulata_order_details['orderdet__ID_req']=''   
    suProcessForm($dbs_sulata_order_details, $validateAsArray);


//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids
//add record
    $extraSql = '';

    //build query for file  uploads
    $sql = "INSERT INTO sulata_order_details SET orderdet__Order='" . suStrip($_POST['orderdet__Order']) . "',orderdet__Product='" . suStrip($_POST['orderdet__Product']) . "',orderdet__Code='" . suStrip($_POST['orderdet__Code']) . "',orderdet__Name='" . suStrip($_POST['orderdet__Name']) . "',orderdet__Price='" . suStrip($_POST['orderdet__Price']) . "',orderdet__Quantity='" . suStrip($_POST['orderdet__Quantity']) . "', orderdet__Last_Action_On ='" . date('Y-m-d H:i:s') . "',orderdet__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', orderdet__dbState='Live' " . $extraSql;
    suQuery($sql, FALSE);

    if (suErrorNo() > 0) {
        if (suErrorNo() == 1062) {
            $error = sprintf(DUPLICATION_ERROR, '');
        } else {
            $error = MYSQL_ERROR;
        }

        suPrintJs('
            parent.suToggleButton(0);
            parent.$("#message-area").hide();
            parent.$("#error-area").show();
            parent.$("#error-area").html("<ul><li>' . $error . '</li></ul>");
            parent.$("html, body").animate({ scrollTop: parent.$("html").offset().top }, "slow");
        ');
    } else {
        $max_id = suInsertId();
        //Upload files


        /* POST INSERT PLACE */

        suPrintJs('
            parent.suToggleButton(0);
            parent.$("#error-area").hide();
            parent.$("#message-area").show();
            parent.$("#message-area").html("' . SUCCESS_MESSAGE . '");
            parent.$("html, body").animate({ scrollTop: parent.$("html").offset().top }, "slow");
            parent.suForm.reset();

        ');
    }
}
//Update record
if ($do == "update") {
//Check referrer
    suCheckRef();
//Validate
    $vError = array();

//Validate entire form in one go using the DB Structure
//To skip validation set '*' to '' like: $dbs_sulata_order_details['orderdet__ID_req']=''   
    //Reset optional


    suProcessForm($dbs_sulata_order_details, $validateAsArray);

//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids
//update record
    $extraSql = '';

    $sql = "UPDATE sulata_order_details SET orderdet__Order='" . suStrip($_POST['orderdet__Order']) . "',orderdet__Product='" . suStrip($_POST['orderdet__Product']) . "',orderdet__Code='" . suStrip($_POST['orderdet__Code']) . "',orderdet__Name='" . suStrip($_POST['orderdet__Name']) . "',orderdet__Price='" . suStrip($_POST['orderdet__Price']) . "',orderdet__Quantity='" . suStrip($_POST['orderdet__Quantity']) . "', orderdet__Last_Action_On ='" . date('Y-m-d H:i:s') . "',orderdet__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', orderdet__dbState='Live' " . $extraSql . " WHERE orderdet__ID='" . $_POST['orderdet__ID'] . "'";
    suQuery($sql, FALSE);

    if (suErrorNo() > 0) {
        if (suErrorNo() == 1062) {
            $error = sprintf(DUPLICATION_ERROR, '');
        } else {
            $error = MYSQL_ERROR;
        }

        suPrintJs('
            parent.suToggleButton(0);
            parent.$("#message-area").hide();
            parent.$("#error-area").show();
            parent.$("#error-area").html("<ul><li>' . $error . '</li></ul>");
            parent.$("html, body").animate({ scrollTop: parent.$("html").offset().top }, "slow");
        ');
    } else {
        $max_id = $_POST['orderdet__ID'];
        //Upload files

        /* POST UPDATE PLACE */

        if ($_POST['referrer'] == '') {
            $_POST['referrer'] = ADMIN_URL . 'order-details-cards.php/';
        }
        suPrintJs("
            parent.window.location.href='" . $_POST['referrer'] . "';
        ");
    }
}

//Delete record
if ($do == "delete") {
//Check referrer
    suCheckRef();
    $id = suSegment(2);
//Delete from database by updating just the state
    //make a unique id attach to previous unique field
    $uid = uniqid() . '-';

    $sql = "UPDATE sulata_order_details SET =CONCAT('" . $uid . "',), orderdet__Last_Action_On ='" . date('Y-m-d H:i:s') . "',orderdet__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', orderdet__dbState='Deleted' WHERE orderdet__ID = '" . $id . "'";
    $result = suQuery($sql);
}
?>    
