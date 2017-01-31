<?php

include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
checkLogin();

//Validation array
$validateAsArray = array('menu__Title_validateas' => 'required', 'menu__Status_validateas' => 'enum',);
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
//To skip validation set '*' to '' like: $dbs_sulata_menus['menu__ID_req']=''   
    suProcessForm($dbs_sulata_menus, $validateAsArray);

    if (sizeof($_POST['product__Name']) == 0) {
        $vError[] = VALIDATE_EMPTY_CHECKBOX;
    }
//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids
//add record
    $extraSql = '';

    //build query for file  uploads
    $sql = "INSERT INTO sulata_menus SET menu__Title='" . suStrip($_POST['menu__Title']) . "',menu__Status='" . suStrip($_POST['menu__Status']) . "', menu__Last_Action_On ='" . date('Y-m-d H:i:s') . "',menu__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', menu__dbState='Live' " . $extraSql;
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

        for ($i = 0; $i <= sizeof($_POST['product__Name']) - 1; $i++) {
            $sqlPrice = "SELECT product__Price FROM sulata_products WHERE product__dbState = 'Live' AND product__Status = 'Available' AND product__ID = '" . $_POST['product__Name'][$i] . "'";
            $rsPrice = suQuery($sqlPrice);
            $rowPrice = suFetch($rsPrice);
            $sql = "INSERT INTO sulata_menu_details SET menudetail__Menu='" . $max_id . "', menudetail__Product='" . $_POST['product__Name'][$i] . "',menudetail__Product_Price='" . $rowPrice['product__Price'] . "',  menudetail__Last_Action_On ='" . date('Y-m-d H:i:s') . "',  menudetail__Last_Action_By  ='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "'";
            suQuery($sql);
        }


        /* POST INSERT PLACE */

        suPrintJs('
            parent.suToggleButton(0);
            parent.$("#error-area").hide();
           

        ');
        suPrintJs("
            parent.window.location.href='" . ADMIN_URL . "menu-details.php/" . $max_id . "/';
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
//To skip validation set '*' to '' like: $dbs_sulata_menus['menu__ID_req']=''   
    //Reset optional


    suProcessForm($dbs_sulata_menus, $validateAsArray);

//Print validation errors on parent
    suValdationErrors($vError);

//Get autocomplete insert ids
//update record
    $extraSql = '';

    $sql = "UPDATE sulata_menus SET menu__Title='" . suStrip($_POST['menu__Title']) . "',menu__Status='" . suStrip($_POST['menu__Status']) . "', menu__Last_Action_On ='" . date('Y-m-d H:i:s') . "',menu__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', menu__dbState='Live' " . $extraSql . " WHERE menu__ID='" . $_POST['menu__ID'] . "'";
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
        $max_id = $_POST['menu__ID'];
        //Upload files
        $products = array();
        $sqlItems = "SELECT menudetail__Product FROM sulata_menu_details WHERE menudetail__dbState = 'Live' AND menudetail__Menu = '" . $max_id . "' ";
        $rsItems = suQuery($sqlItems);
        while ($rowItems = suFetch($rsItems)) {
            $products[] = $rowItems['menudetail__Product'];
        }
        $result = array_diff($products, $_POST['product__Name']);
        //print_array($result);
        foreach ($result as $row1) {
            $sql = "DELETE FROM sulata_menu_details WHERE menudetail__Product = '" . $row1 . "' AND menudetail__dbState = 'Live' AND menudetail__Menu = '" . $max_id . "'";
            suQuery($sql);
        }
        for ($i = 0; $i <= sizeof($_POST['product__Name_2']) - 1; $i++) {
            $sqlPrice = "SELECT product__Price FROM sulata_products WHERE product__dbState = 'Live' AND product__Status = 'Available' AND product__ID = '" . $_POST['product__Name_2'][$i] . "'";
            $rsPrice = suQuery($sqlPrice);
            $rowPrice = suFetch($rsPrice);
            $sql = "INSERT INTO sulata_menu_details SET menudetail__Menu='" . $max_id . "', menudetail__Product='" . $_POST['product__Name_2'][$i] . "',menudetail__Product_Price='" . $rowPrice['product__Price'] . "',  menudetail__Last_Action_On ='" . date('Y-m-d H:i:s') . "',  menudetail__Last_Action_By  ='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "'";
            suQuery($sql);
        }

        suPrintJs("
            parent.window.location.href='" . ADMIN_URL . "menu-details.php/" . $max_id . "/';
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

    $sql = "UPDATE sulata_menus SET menu__Title=CONCAT('" . $uid . "',menu__Title), menu__Last_Action_On ='" . date('Y-m-d H:i:s') . "',menu__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', menu__dbState='Deleted' WHERE menu__ID = '" . $id . "'";
    $result = suQuery($sql);
    $sql2 = "UPDATE sulata_menu_details SET  menudetail__Last_Action_On ='" . date('Y-m-d H:i:s') . "',menudetail__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "', menudetail__dbState='Deleted' WHERE menudetail__Menu = '" . $id . "'";
    $result2 = suQuery($sql2);
}
if ($do == "menu-details") {
    $sql = "DELETE FROM sulata_menu_details WHERE menudetail__Menu = '" . $_POST['menu__ID'] . "'";
    suQuery($sql);
    for ($i = 0; $i <= sizeof($_POST['menudetail__Product']) - 1; $i++) {

        $sql = "INSERT INTO sulata_menu_details SET menudetail__Menu='" . $_POST['menu__ID'] . "', menudetail__Product='" . $_POST['menudetail__Product'][$i] . "',menudetail__Product_Price='" . $_POST['menudetail__Product_Price'][$i] . "',  menudetail__Last_Action_On ='" . date('Y-m-d H:i:s') . "',  menudetail__Last_Action_By  ='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "'";
        suQuery($sql);
    }


    suPrintJs("
            parent.window.location.href='" . ADMIN_URL . "menus-cards.php/';
        ");
}
if ($do == "assign-menu") {

//Check referrer


    $sql = "UPDATE sulata_settings SET setting__Value='" . $_POST['assign_menu'] . "', setting__Last_Action_On ='" . date('Y-m-d H:i:s') . "',setting__Last_Action_By='" . $_SESSION[SESSION_PREFIX . 'user__Name'] . "' WHERE setting__Key = 'truck_menu'";

    $result = suQuery($sql);
    $_SESSION[SESSION_PREFIX . 'getSettings'] = '';
    suPrintJs("
            parent.window.location.href='" . ADMIN_URL . "assign-menu.php';
        ");
}
?>    
