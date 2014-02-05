<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_nv = "187.108.193.15";
$database_nv = "nv_sistema";
$username_nv = "nv";
$password_nv = "ybu4zfs60h";
$nv = mysql_pconnect($hostname_nv, $username_nv, $password_nv) or trigger_error(mysql_error(),E_USER_ERROR); 
?>