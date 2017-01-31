<?php    
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();

//Validation array
$validateAsArray=array( 'order__Number_validateas'=>'int',  'order__Customer_Name_validateas'=>'required',  'order__Mobile_Number_validateas'=>'required', );
//---------

//Check to stop page opening outside iframe
//Deliberately disabled for list and delete conditions
$do = suSegment(1);
if (($_GET["do"] != "check") && ($_GET["do"] != "autocomplete") ) {
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
//To skip validation set '*' to '' like: $dbs_sulata_orders['order__ID_req']=''   
    suProcessForm($dbs_sulata_orders,$validateAsArray);

        
//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids

    
//add record
    $extraSql = '';

    //build query for file  uploads
    $sql = "INSERT INTO sulata_orders SET order__UID='".suStrip($_POST['order__UID'])."',order__Number='".suStrip($_POST['order__Number'])."',order__Customer_Name='".suStrip($_POST['order__Customer_Name'])."',order__Mobile_Number='".suStrip($_POST['order__Mobile_Number'])."',order__Notes='".suStrip($_POST['order__Notes'])."',order__Status='".suStrip($_POST['order__Status'])."',order__Session='".suStrip($_POST['order__Session'])."', order__Last_Action_On ='" . date('Y-m-d H:i:s') . "',order__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', order__dbState='Live' " .$extraSql;
    suQuery($sql, FALSE);

    if (suErrorNo() > 0) {
        if (suErrorNo() == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'UID');
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
        
            
        /*POST INSERT PLACE*/
        
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
//To skip validation set '*' to '' like: $dbs_sulata_orders['order__ID_req']=''   

    //Reset optional
   
    
    suProcessForm($dbs_sulata_orders,$validateAsArray);
    
//Print validation errors on parent
    suValdationErrors($vError);
    
//Get autocomplete insert ids

            
//update record
    $extraSql = '';

    $sql = "UPDATE sulata_orders SET order__UID='".suStrip($_POST['order__UID'])."',order__Number='".suStrip($_POST['order__Number'])."',order__Customer_Name='".suStrip($_POST['order__Customer_Name'])."',order__Mobile_Number='".suStrip($_POST['order__Mobile_Number'])."',order__Notes='".suStrip($_POST['order__Notes'])."',order__Status='".suStrip($_POST['order__Status'])."',order__Session='".suStrip($_POST['order__Session'])."', order__Last_Action_On ='" . date('Y-m-d H:i:s') . "',order__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', order__dbState='Live' " .$extraSql." WHERE order__ID='" . $_POST['order__ID'] . "'";
    suQuery($sql, FALSE);

    if (suErrorNo() > 0) {
        if (suErrorNo() == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'UID');
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
        $max_id = $_POST['order__ID'];
        //Upload files
        
        /*POST UPDATE PLACE*/
        
        if ($_POST['referrer'] == '') {
            $_POST['referrer'] = ADMIN_URL . 'open-orders-cards/';
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
    
        $sql = "UPDATE sulata_orders SET order__UID=CONCAT('" . $uid . "',order__UID), order__Last_Action_On ='" . date('Y-m-d H:i:s') . "',order__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', order__dbState='Deleted' WHERE order__ID = '" . $id . "'";
    $result = suQuery($sql);


}



?>    
