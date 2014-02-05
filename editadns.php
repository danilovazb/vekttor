
<?php

// PHP script to allow periodic cPanel backups automatically, optionally to a remote FTP server.
// This script contains passwords.  KEEP ACCESS TO THIS FILE SECURE! (place it in your home dir, not /www/)

// ********* THE FOLLOWING ITEMS NEED TO BE CONFIGURED *********

// Info required for cPanel access
$cpuser = "vktsrv"; // Username used to login to CPanel
$cppass = "vfe2nji0itario"; // Password used to login to CPanel
$domain = "dev.vkt.srv.br"; // Domain name where CPanel is run
$skin = "x3"; // Set to cPanel skin you use (script won't work if it doesn't match). Most people run the default x theme


// Secure or non-secure mode
$secure = 0; // Set to 1 for SSL (requires SSL support), otherwise will use standard HTTP

// Set to 1 to have web page result appear in your cron log
$debug = 1;

// *********** NO CONFIGURATION ITEMS BELOW THIS LINE *********

if ($secure) {
   $url = "ssl://".$domain;
   $port = 2083;
} else {
   $url = $domain;
   $port = 2082;
}

$socket = fsockopen($url,$port);
if (!$socket) { echo "Failed to open socket connection... Bailing out!\n"; exit; }

// Encode authentication string
$authstr = $cpuser.":".$cppass;
$pass = base64_encode($authstr);
//cpanel_jsonapi_version=2&cpanel_jsonapi_module=ZoneEdit&cpanel_jsonapi_func=edit_zone_record&domain=vkt.srv.br&line=38&class=IN&type=A&name=ooo.vkt.srv.br.&ttl=14400&serialnum=2013072104&address=186.207.142.94&cache_fix=1374367771491
//$params = "cpanel?cpanel_jsonapi_version=2&cpanel_jsonapi_module=ZoneEdit&cpanel_jsonapi_func=edit_zone_record&domain=vkt.srv.br&line=37&class=IN&type=A&name=ooo.vkt.srv.br.&ttl=14400&serialnum=2013072121&address=186.207.142.4&cache_fix=1374368456686";

$params = "cpanel?cpanel_jsonapi_version=2&cpanel_jsonapi_module=ZoneEdit&cpanel_jsonapi_func=fetchzone&domain=vkt.srv.br&cache_fix=1374369902983";


// Make POST to cPanel
fputs($socket,"POST /frontend/".$skin."/json-api/cpanel?".$params." HTTP/1.0\r\n");
fputs($socket,"Host: $domain\r\n");
fputs($socket,"Authorization: Basic $pass\r\n");
fputs($socket,"Connection: Close\r\n");
fputs($socket,"\r\n");

// Grab response even if we don't do anything with it.
while (!feof($socket)) {
  $response .= fgets($socket,4096);
  
}

  $conta = strlen($response);
  $inicio =strpos($response,'{');
    $info = substr($response,$inicio-1,$conta);
	$ar  = json_decode($info);
//	$ar = get_object_vars ($ar);
//	$ar = get_object_vars ($ar[cpanelresult]);
	$serialnum = $ar->cpanelresult->data[0]->serialnum;
	//echo $ar[cpanelresult][data][0][serialnum];
	//echo "<pre>";
	//print_r($ar);
	//echo "</pre>";

fclose($socket);
$response='';
$socket = fsockopen($url,$port);

	$params1 = "cpanel?cpanel_jsonapi_version=2&cpanel_jsonapi_module=ZoneEdit&cpanel_jsonapi_func=edit_zone_record&domain=vkt.srv.br&line=37&class=IN&type=A&name=ooo.vkt.srv.br.&ttl=14400&serialnum=".$serialnum."&address=186.207.142.12&cache_fix=1374368456686";
	fputs($socket,"POST /frontend/".$skin."/json-api/cpanel?".$params1." HTTP/1.0\r\n");
	fputs($socket,"Host: $domain\r\n");
	fputs($socket,"Authorization: Basic $pass\r\n");
	fputs($socket,"Connection: Close\r\n");
	fputs($socket,"\r\n");
while (!feof($socket)) {
  $response .= fgets($socket,4096);
}
//echo $response;



fclose($socket);
	?>