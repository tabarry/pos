<?php
include('../sulata/includes/config.php');
include('../sulata/includes/functions.php');
include('../sulata/includes/connection.php');
#include('../sulata/includes/get-settings.php');
set_time_limit(0);
if ($_POST['api_key'] != API_KEY) {
    suExit(INVALID_ACCESS);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Sync started..</title>
        <style type="text/css">
            body{font-family: "Trebuchet MS",Verdana,Tahoma,Arial;font-size: 11px;}
            .green{color:green;font-size: 13px;}
            .red{color:red;font-size: 13px;}
            .blue{color:blue;font-size: 13px;}
        </style>
    </head>
    <body>
        <p class="blue">Sync started..</p>
        <?php
        $sql = explode(PHP_EOL, $_POST['q']);
        for ($i = 0; $i <= sizeof($sql); $i++) {
            if ($sql[$i] != '') {
                suQuery($sql[$i], FALSE);
                if (suErrorNo() > 0) {
                    $errorCount = TRUE;
                    echo "<div id='api'><div class='api-error'>" . API_ERROR . '</div>' . $sql[$i] . "<div class='mysql-error'>" . mysqli_error($cn) . '</div>';
                }
            }
        }
        if ($errorCount == TRUE) {
            echo "<p class='red'>" . API_FAILURE . "</p>";
        } else {
            echo "<p class='green'>" . API_SUCCESS . "</p>";
        }
        echo "<a href='" . LOCAL_URL . "'>Back to POS</a>";
        ?>
    </body>
</html>