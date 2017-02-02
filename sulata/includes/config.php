<?php

/*
 * SULATA FRAMEWORK
 * Version: 21
 * Date: June 2016
 */
//Error reporting
error_reporting("E_ALL & ~E_NOTICE & ~E_DEPRECATED");
//ini_set('display_errors',1);
//Include the language file
include('language.php');
//MISC SETTINGS
define('LOCAL_URL', 'http://localhost/pos/');
define('API_URL', 'http://www.truckcafe.pk/pos/');
define('API_URL', 'http://www.truckcafe.pk/pos/api/');
//
define('SESSION_PREFIX', '11d_');
define('UID_LENGTH', 14);
define('OPENID_DOMAIN', $_SERVER['HTTP_HOST']);
define('GOOGLE_LOGOUT_URL', 'https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=');
define('COOKIE_EXPIRY_DAYS', '30');
define('API_KEY', 'BMQ4957');

//URLs and db settings
//Other settings are in sulata_settings table
//If local
if (!strstr($_SERVER['HTTP_HOST'], ".")) {
    define('DEBUG', FALSE);
    define('BASE_URL', LOCAL_URL);
    define('ADMIN_URL', BASE_URL . '_admin/');
    define('ADMIN_SUBMIT_URL', ADMIN_URL);
    define('PING_URL', BASE_URL . 'static/ping.html');
    define('NOSCRIPT_URL', BASE_URL . 'sulata/static/no-script.html');
    define('ACCESS_DENIED_URL', BASE_URL . 'sulata/static/access-denied.html');
    define('ADMIN_UPLOAD_PATH', '../files/');
    define('PUBLIC_UPLOAD_PATH', 'files/');
    define('LOCAL', TRUE);
    //MySQL DB Settings
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'pos');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'root');
    define('DB_PASSWORD2', 'root1234');
    //MySQL DB2 Settings
    define('DB2_HOST', 'localhost');
    define('DB2_NAME', 'truckcaf_pos');
    define('DB2_USER', 'truckcaf_pos');
    define('DB2_PASSWORD', 'Z+iP4VkV1a!+');
    define('DB2_PASSWORD2', 'Z+iP4VkV1a!+');
} else {
    define('DEBUG', FALSE);
    define('BASE_URL', WEB_URL);
    define('ADMIN_URL', BASE_URL . '_admin/');
    define('ADMIN_SUBMIT_URL', ADMIN_URL);
    define('PING_URL', BASE_URL . 'sulata/ping.html');
    define('NOSCRIPT_URL', BASE_URL . 'sulata/static/no-script.html');
    define('ACCESS_DENIED_URL', BASE_URL . 'sulata/static/access-denied.html');
    define('ADMIN_UPLOAD_PATH', '../files/');
    define('PUBLIC_UPLOAD_PATH', 'files/');
    define('LOCAL', FALSE);
    //MySQL Settings
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'truckcaf_pos');
    define('DB_USER', 'truckcaf_pos');
    define('DB_PASSWORD', 'Z+iP4VkV1a!+');
    define('DB_PASSWORD2', 'Z+iP4VkV1a!+');
    //MySQL DB2 Settings
    define('DB2_HOST', 'localhost');
    define('DB2_NAME', 'truckcaf_pos');
    define('DB2_USER', 'truckcaf_pos');
    define('DB2_PASSWORD', 'Z+iP4VkV1a!+');
    define('DB2_PASSWORD2', 'Z+iP4VkV1a!+');
}
//Edit delete download access
$editAccess = TRUE;
$deleteAccess = TRUE;
$addAccess = TRUE;
$downloadAccessCSV = TRUE;
$downloadAccessPDF = TRUE;
