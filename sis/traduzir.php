<?
$chave_api="AIzaSyCSYWVaDBCgKuGlks_DCFZQZl4CCIlTaJQ";
$texto=urlencode(utf8_encode($_GET['texto']));
$origem=$_GET['origem'];
$destino=$_GET['destino'];
//$texto=urlencode("Hello, my name is Ricardo. Fuck you!");
$url="https://www.googleapis.com/language/translate/v2?key=AIzaSyCSYWVaDBCgKuGlks_DCFZQZl4CCIlTaJQ&source=$origem&target=$destino&q=$texto";
$retorno=json_decode(file_get_contents($url,0,null,null),TRUE);
echo ($retorno['data']['translations'][0]['translatedText']);


