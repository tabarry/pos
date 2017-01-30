<?php

include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();

//Validation array
$validateAsArray = array('product__Category_validateas' => 'required', 'product__Picture_validateas' => 'image', 'product__Code_validateas' => 'required', 'product__Name_validateas' => 'required', 'product__Cost_Price_validateas' => 'float', 'product__Price_validateas' => 'float', 'product__Description_validateas' => 'required', 'product__Status_validateas' => 'enum',);
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
//To skip validation set '*' to '' like: $dbs_sulata_products['product__ID_req']=''   
    suProcessForm($dbs_sulata_products, $validateAsArray);


//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids
//add record
    $extraSql = '';

    //for picture
    if ($_FILES['product__Picture']['name'] != '') {
        $uid = uniqid();
        $product__Picture = suSlugify($_FILES['product__Picture']['name'], $uid);
        $uploadPath = suMakeUploadPath(ADMIN_UPLOAD_PATH);
        $extraSql.=" ,product__Picture='" . $uploadPath . $product__Picture . "' ";
    }

    //build query for file  uploads
    $sql = "INSERT INTO sulata_products SET product__Category='" . suStrip($_POST['product__Category']) . "',product__Code='" . suStrip($_POST['product__Code']) . "',product__Name='" . suStrip($_POST['product__Name']) . "',product__Cost_Price='" . suStrip($_POST['product__Cost_Price']) . "',product__Price='" . suStrip($_POST['product__Price']) . "',product__Description='" . suStrip($_POST['product__Description']) . "',product__Status='" . suStrip($_POST['product__Status']) . "', product__Last_Action_On ='" . date('Y-m-d H:i:s') . "',product__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', product__dbState='Live' " . $extraSql;
    suQuery($sql, FALSE);

    if (suErrorNo() > 0) {
        if (suErrorNo() == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'Name');
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
        if ($_FILES['product__Picture']['name'] != '') {
            @unlink(ADMIN_UPLOAD_PATH . $uploadPath . $product__Picture);
            @unlink(ADMIN_UPLOAD_PATH . $_POST['previous_product__Picture']);
            suResize($defaultWidth, $defaultHeight, $_FILES['product__Picture']['tmp_name'], ADMIN_UPLOAD_PATH . $uploadPath . $product__Picture);
        }

 for ($i = 0; $i <= sizeof($_POST['material__ID']) - 1; $i++) {
            if ($_POST['material__ID'][$i] != '') {
                
                $promaterial__Material = $_POST['material__ID'][$i];

                $promaterial__Quantity = $_POST['qty'][$i];


                 $sql = "INSERT INTO sulata_product_material SET promaterial__Product = '" . $max_id . "',promaterial__Material='" . $promaterial__Material . "',promaterial__Quantity='" . $promaterial__Quantity . "',promaterial__Last_Action_On='" . date('Y-m-d H:i:s') . "',promaterial__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "',promaterial__dbState='Live'";
                suQuery($sql);
              
            }
 }
      
        /* POST INSERT PLACE */

        suPrintJs('
            parent.suToggleButton(0);
            parent.$("#error-area").hide();
            parent.$("#message-area").show();
            parent.$("#message-area").html("' . SUCCESS_MESSAGE . '");
            parent.$("html, body").animate({ scrollTop: parent.$("html").offset().top }, "slow");
            parent.suForm.reset();

        ');
          suPrintJs("
            parent.window.location.href='" . ADMIN_URL . "products-add/';
        ");
    }
}
//Update record
if ($do == "update") {
//Check referrer
    suCheckRef();
//Validate
    $vError = array();

//Validate entire form in one go using the DB Structure
//To skip validation set '*' to '' like: $dbs_sulata_products['product__ID_req']=''   
    //Reset optional

    $dbs_sulata_products['product__Picture_req'] = '';


    $dbs_sulata_products['product__Picture_req'] = '';



    suProcessForm($dbs_sulata_products, $validateAsArray);

//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids
//update record
    $extraSql = '';

    //for picture
    if ($_FILES['product__Picture']['name'] != '') {
        $uid = uniqid();
        $product__Picture = suSlugify($_FILES['product__Picture']['name'], $uid);
        $uploadPath = suMakeUploadPath(ADMIN_UPLOAD_PATH);
        $extraSql.=" ,product__Picture='" . $uploadPath . $product__Picture . "' ";
    }

    $sql = "UPDATE sulata_products SET product__Category='" . suStrip($_POST['product__Category']) . "',product__Code='" . suStrip($_POST['product__Code']) . "',product__Name='" . suStrip($_POST['product__Name']) . "',product__Cost_Price='" . suStrip($_POST['product__Cost_Price']) . "',product__Price='" . suStrip($_POST['product__Price']) . "',product__Description='" . suStrip($_POST['product__Description']) . "',product__Status='" . suStrip($_POST['product__Status']) . "', product__Last_Action_On ='" . date('Y-m-d H:i:s') . "',product__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', product__dbState='Live' " . $extraSql . " WHERE product__ID='" . $_POST['product__ID'] . "'";
    suQuery($sql, FALSE);

    if (suErrorNo() > 0) {
        if (suErrorNo() == 1062) {
            $error = sprintf(DUPLICATION_ERROR, 'Name');
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
        $max_id = $_POST['product__ID'];
        //Upload files
        // picture
        if ($_FILES['product__Picture']['name'] != '') {
            @unlink(ADMIN_UPLOAD_PATH . $uploadPath . $product__Picture);
            @unlink(ADMIN_UPLOAD_PATH . $_POST['previous_product__Picture']);
            suResize($defaultWidth, $defaultHeight, $_FILES['product__Picture']['tmp_name'], ADMIN_UPLOAD_PATH . $uploadPath . $product__Picture);
        }
        $sqlDelete = "DELETE FROM sulata_product_material WHERE promaterial__Product = '".$max_id."'";
        suQuery($sqlDelete);
         for ($i = 0; $i <= sizeof($_POST['material__ID']) - 1; $i++) {
            if ($_POST['material__ID'][$i] != '') {
                
                $promaterial__Material = $_POST['material__ID'][$i];

                $promaterial__Quantity = $_POST['qty'][$i];


                 $sql = "INSERT INTO sulata_product_material SET promaterial__Product = '" . $max_id . "',promaterial__Material='" . $promaterial__Material . "',promaterial__Quantity='" . $promaterial__Quantity . "',promaterial__Last_Action_On='" . date('Y-m-d H:i:s') . "',promaterial__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "',promaterial__dbState='Live'";
                suQuery($sql);
              
            }
 }

        /* POST UPDATE PLACE */

        if ($_POST['referrer'] == '') {
            $_POST['referrer'] = ADMIN_URL . 'products-cards/';
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

    $sql = "UPDATE sulata_products SET product__Name=CONCAT('" . $uid . "',product__Name), product__Last_Action_On ='" . date('Y-m-d H:i:s') . "',product__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', product__dbState='Deleted' WHERE product__ID = '" . $id . "'";
    $result = suQuery($sql);
}
?>    
