<?php

include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();

//Validation array
$validateAsArray = array('promotionalcode__Code_validateas' => 'required', 'promotionalcode__Validity_validateas' => 'required', 'promotionalcode__Type_validateas' => 'enum', 'promotionalcode__Value_validateas' => 'float', 'promotionalcode__Active_validateas' => 'enum',);
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
//To skip validation set '*' to '' like: $dbs_sulata_promotional_codes['promotionalcode__ID_req']=''   
    suProcessForm($dbs_sulata_promotional_codes, $validateAsArray);


//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids
//add record
    $extraSql = '';

    //build query for file  uploads
    $sql = "INSERT INTO sulata_promotional_codes SET promotionalcode__Code='" . suStrip($_POST['promotionalcode__Code']) . "',promotionalcode__Validity='" . suDate2Db($_POST['promotionalcode__Validity']) . "',promotionalcode__Type='" . suStrip($_POST['promotionalcode__Type']) . "',promotionalcode__Value='" . suStrip($_POST['promotionalcode__Value']) . "',promotionalcode__Active='" . suStrip($_POST['promotionalcode__Active']) . "', promotionalcode__Last_Action_On ='" . date('Y-m-d H:i:s') . "',promotionalcode__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', promotionalcode__dbState='Live' " . $extraSql;
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
//To skip validation set '*' to '' like: $dbs_sulata_promotional_codes['promotionalcode__ID_req']=''   
    //Reset optional


    suProcessForm($dbs_sulata_promotional_codes, $validateAsArray);

//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids
//update record
    $extraSql = '';

    $sql = "UPDATE sulata_promotional_codes SET promotionalcode__Code='" . suStrip($_POST['promotionalcode__Code']) . "',promotionalcode__Validity='" . suDate2Db($_POST['promotionalcode__Validity']) . "',promotionalcode__Type='" . suStrip($_POST['promotionalcode__Type']) . "',promotionalcode__Value='" . suStrip($_POST['promotionalcode__Value']) . "',promotionalcode__Active='" . suStrip($_POST['promotionalcode__Active']) . "', promotionalcode__Last_Action_On ='" . date('Y-m-d H:i:s') . "',promotionalcode__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', promotionalcode__dbState='Live' " . $extraSql . " WHERE promotionalcode__ID='" . $_POST['promotionalcode__ID'] . "'";
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
        $max_id = $_POST['promotionalcode__ID'];
        //Upload files

        /* POST UPDATE PLACE */

        if ($_POST['referrer'] == '') {
            $_POST['referrer'] = ADMIN_URL . 'promotional-codes-cards.php/';
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

    $sql = "UPDATE sulata_promotional_codes SET =CONCAT('" . $uid . "',), promotionalcode__Last_Action_On ='" . date('Y-m-d H:i:s') . "',promotionalcode__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', promotionalcode__dbState='Deleted' WHERE promotionalcode__ID = '" . $id . "'";
    $result = suQuery($sql);
}
?>    
