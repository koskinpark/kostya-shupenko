<?php
    $dbhost = "localhost";
    $dbusername = "user";
    $dbpass = "";
    $dbname = "my_site";
    $dbconnect = mysql_connect($dbhost, $dbusername, $dbpass);
    mysql_query("SET NAMES utf8");
    if (!$dbconnect) {
        print "����� � ������������";
    }
    if (@mysql_select_db($dbname)) {
    }
    else {
        die ("�� ������");
    }

?>