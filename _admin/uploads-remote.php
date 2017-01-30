<?php    
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();

//Validation array
$validateAsArray=array( 'upload__Title_validateas'=>'required',  'upload__Picture_validateas'=>'image', );
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
//To skip validation set '*' to '' like: $dbs_sulata_uploads['upload__ID_req']=''   
    suProcessForm($dbs_sulata_uploads,$validateAsArray);

        
//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids

    
//add record
    $extraSql = '';

    //for picture
    if ($_FILES['upload__Picture']['name'] != '') {
        $uid = uniqid();
        $upload__Picture = suSlugify($_FILES['upload__Picture']['name'], $uid);
        $uploadPath = suMakeUploadPath(ADMIN_UPLOAD_PATH);
        $extraSql.=" ,upload__Picture='".$uploadPath . $upload__Picture."' ";
    }    

    //build query for file  uploads
    $sql = "INSERT INTO sulata_uploads SET upload__Title='".suStrip($_POST['upload__Title'])."', upload__Last_Action_On ='" . date('Y-m-d H:i:s') . "',upload__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', upload__dbState='Live' " .$extraSql;
    suQuery($sql, FALSE);

    if (suErrorNo() > 0) {
        if (suErrorNo() == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'Title');
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
        
            // picture
            if ($_FILES['upload__Picture']['name'] != '') {
                @unlink(ADMIN_UPLOAD_PATH . $uploadPath . $upload__Picture);
                copy($_FILES['upload__Picture']['tmp_name'], ADMIN_UPLOAD_PATH . $uploadPath .$upload__Picture);
            }    
    
            
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
//To skip validation set '*' to '' like: $dbs_sulata_uploads['upload__ID_req']=''   

    //Reset optional
   
    $dbs_sulata_uploads['upload__Picture_req']='';
    

    $dbs_sulata_uploads['upload__Picture_req']='';
    

    
    suProcessForm($dbs_sulata_uploads,$validateAsArray);
    
//Print validation errors on parent
    suValdationErrors($vError);
    
//Get autocomplete insert ids

            
//update record
    $extraSql = '';

    //for picture
    if ($_FILES['upload__Picture']['name'] != '') {
        $uid = uniqid();
        $upload__Picture = suSlugify($_FILES['upload__Picture']['name'], $uid);
        $uploadPath = suMakeUploadPath(ADMIN_UPLOAD_PATH);
        $extraSql.=" ,upload__Picture='".$uploadPath . $upload__Picture."' ";
    }    

    $sql = "UPDATE sulata_uploads SET upload__Title='".suStrip($_POST['upload__Title'])."', upload__Last_Action_On ='" . date('Y-m-d H:i:s') . "',upload__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', upload__dbState='Live' " .$extraSql." WHERE upload__ID='" . $_POST['upload__ID'] . "'";
    suQuery($sql, FALSE);

    if (suErrorNo() > 0) {
        if (suErrorNo() == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'Title');
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
        $max_id = $_POST['upload__ID'];
        //Upload files
        
            // picture
            if ($_FILES['upload__Picture']['name'] != '') {
                @unlink(ADMIN_UPLOAD_PATH . $uploadPath . $upload__Picture);
                copy($_FILES['upload__Picture']['tmp_name'], ADMIN_UPLOAD_PATH . $uploadPath .$upload__Picture);
            }    
    
        /*POST UPDATE PLACE*/
        
        if ($_POST['referrer'] == '') {
            $_POST['referrer'] = ADMIN_URL . 'uploads-cards/';
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
    
        $sql = "UPDATE sulata_uploads SET upload__Title=CONCAT('" . $uid . "',upload__Title), upload__Last_Action_On ='" . date('Y-m-d H:i:s') . "',upload__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', upload__dbState='Deleted' WHERE upload__ID = '" . $id . "'";
    $result = suQuery($sql);


}



?>    
