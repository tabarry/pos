<?php

include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();

//Validation array
$validateAsArray = array('notice__Subject_validateas' => 'required', 'notice__Notice_validateas' => 'required',);
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
//To skip validation set '*' to '' like: $dbs_sulata_notices['notice__ID_req']=''   
    suProcessForm($dbs_sulata_notices, $validateAsArray);


//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids
//add record
    $extraSql = '';

    //build query for file  uploads
    $sql = "INSERT INTO sulata_notices SET notice__Subject='" . suStrip($_POST['notice__Subject']) . "',notice__Notice='" . suStrip($_POST['notice__Notice']) . "', notice__Last_Action_On ='" . date('Y-m-d H:i:s') . "',notice__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', notice__dbState='Live' " . $extraSql;
    suQuery($sql, FALSE);

    if (suErrorNo() > 0) {
        if (suErrorNo() == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'Subject');
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
            parent.window.location.href="' . ADMIN_URL . 'notices-add.php/";

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
//To skip validation set '*' to '' like: $dbs_sulata_notices['notice__ID_req']=''   
    //Reset optional


    suProcessForm($dbs_sulata_notices, $validateAsArray);

//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids
//update record
    $extraSql = '';

    $sql = "UPDATE sulata_notices SET notice__Subject='" . suStrip($_POST['notice__Subject']) . "',notice__Notice='" . suStrip($_POST['notice__Notice']) . "', notice__Last_Action_On ='" . date('Y-m-d H:i:s') . "',notice__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', notice__dbState='Live' " . $extraSql . " WHERE notice__ID='" . $_POST['notice__ID'] . "'";
    suQuery($sql, FALSE);

    if (suErrorNo() > 0) {
        if (suErrorNo() == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'Subject');
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
        $max_id = $_POST['notice__ID'];
        //Upload files

        /* POST UPDATE PLACE */

        if ($_POST['referrer'] == '') {
            $_POST['referrer'] = ADMIN_URL . 'notices-cards.php/';
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

    $sql = "UPDATE sulata_notices SET notice__Subject=CONCAT('" . $uid . "',notice__Subject), notice__Last_Action_On ='" . date('Y-m-d H:i:s') . "',notice__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', notice__dbState='Deleted' WHERE notice__ID = '" . $id . "'";
    $result = suQuery($sql);
}
?>    
