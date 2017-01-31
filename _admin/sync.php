<?php
//Changes files: api folder,language.php,connection2.php,config,sync.php

include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
include('../sulata/includes/get-settings.php');
include('../sulata/includes/db-structure.php');
set_time_limit(0);
checkLogin();
//Stylesheet
echo "
<style>
#api{
  font-size: 12px;
  font-family: arial;
}
#api .api-error{
  color: red;
}
#api .mysql-error{
  color: blue;
}
#api .api-success{
  color: green;
}
</style>
";
$lastDate = suDate2Db($_POST['startDate']);
$sql = "SELECT order__UID,order__Number,order__Customer_Name,order__Mobile_Number,order__Date,order__Total_Amount,order__Discount,order__Discount_Type,order__Cash_Recieved,order__Tax,order__Tax_Value,order__Notes,order__Status,order__Promo_Code,order__Session,order__Location,order__Last_Action_On,order__Last_Action_By,order__dbState FROM sulata_orders WHERE order__Date >='$lastDate' ORDER BY order__ID ";

$result = suQuery($sql);
while ($row = suFetch($result)) {
    $sql2 .= " INSERT IGNORE INTO sulata_orders SET order__UID = '" . $row['order__UID'] . "', order__Number = '" . $row['order__Number'] . "', order__Customer_Name = '" . $row['order__Customer_Name'] . "', order__Mobile_Number = '" . $row['order__Mobile_Number'] . "', order__Date = '" . $row['order__Date'] . "', order__Total_Amount = '" . $row['order__Total_Amount'] . "', order__Discount = '" . $row['order__Discount'] . "', order__Discount_Type = '" . $row['order__Discount_Type'] . "', order__Cash_Recieved = '" . $row['order__Cash_Recieved'] . "', order__Tax = '" . $row['order__Tax'] . "', order__Tax_Value = '" . $row['order__Tax_Value'] . "', order__Notes = '" . $row['order__Notes'] . "', order__Status = '" . $row['order__Status'] . "', order__Promo_Code = '" . $row['order__Promo_Code'] . "', order__Session = '" . $row['order__Session'] . "', order__Location = '" . $row['order__Location'] . "', order__Last_Action_On = '" . $row['order__Last_Action_On'] . "', order__Last_Action_By = '" . $row['order__Last_Action_By'] . "', order__dbState = '" . $row['order__dbState'] . "'" . PHP_EOL;

    $sql3 = "SELECT orderdet__Order_UID,orderdet__Product,orderdet__Code,orderdet__Name,orderdet__Price,orderdet__Quantity,orderdet__Last_Action_On,orderdet__Last_Action_By,orderdet__dbState FROM sulata_order_details WHERE orderdet__Order_UID = '" . $row['order__UID'] . "' ";
    $rs3 = suQuery($sql3);
    if (suNumRows($rs3) > 0) {
        while ($row3 = suFetch($rs3)) {

            $sql4 .= "INSERT IGNORE INTO sulata_order_details SET orderdet__Order_UID='" . $row3['orderdet__Order_UID'] . "',orderdet__Product='" . $row3['orderdet__Product'] . "',orderdet__Code='" . $row3['orderdet__Code'] . "',orderdet__Name='" . $row3['orderdet__Name'] . "',orderdet__Price='" . $row3['orderdet__Price'] . "',orderdet__Quantity='" . $row3['orderdet__Quantity'] . "',orderdet__Last_Action_On='" . $row3['orderdet__Last_Action_On'] . "',orderdet__Last_Action_By='" . $row3['orderdet__Last_Action_By'] . "',orderdet__dbState='" . $row3['orderdet__dbState'] . "'" . PHP_EOL;
        }
    }

    //$url = API_URL . "?api_key=" . API_KEY . "&uid=" . $row['order__UID'] . "&sql=" . urlencode($sql2) . "&sql4=" . urlencode($sql4);
    //echo file_get_contents($url);
}

//echo nl2br($sql2.$sql4);
//echo "<div id='api'><center><img src='" . ADMIN_URL . "img/loader.gif' /></center></div>";
//echo '<div>&nbsp;</div>';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Preparing Sync..</title>
        <style type="text/css">
            body{font-family: "Trebuchet MS",Verdana,Tahoma,Arial;}
        </style>
    </head>
    <body>
        Preparing sync..
        <div id="api"><center><img src="<?php echo ADMIN_URL; ?>img/loader.gif" /></center></div>
        <form name="suForm" id="suForm" method="POST" action="<?php echo API_URL; ?>">
            <input type="hidden" name="api_key" value="<?php echo API_KEY; ?>"/>
            <textarea name="q" style="width:100%;height: 100px;display:none;"><?php echo $sql2 . $sql4; ?></textarea>
        </form>
        <script>
            document.suForm.submit();
        </script>
    </body>
</html>

