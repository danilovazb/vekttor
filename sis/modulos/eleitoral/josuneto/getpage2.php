info = '<?
$gt = file_get_contents("http://vkt.srv.br/~nv/sis/modulos/eleitoral/josuneto/getpage.php");



$i =  str_replace("\n",'',$gt );
$i =  str_replace("\n",'',$i );
$i =  str_replace("\r",'',$i );
$i =  str_replace('width="1024"','',$i );
$i =  str_replace('height="502"','',$i );
echo $i;
?>';
