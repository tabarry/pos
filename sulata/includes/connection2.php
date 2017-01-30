<?php

/*
 * SULATA FRAMEWORK
 * This file contains the database connection.
 */

$cn = @mysqli_connect(DB_HOST2, DB_USER2, DB_PASSWORD2, DB_NAME2) or suDie();
mysqli_query($cn, "SET NAMES utf8");
@mysqli_select_db($cn, DB_NAME2) or suDie();
