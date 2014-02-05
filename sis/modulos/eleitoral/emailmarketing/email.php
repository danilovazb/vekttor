<?php
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
global $vkt_id;
	if(!empty($_GET['vkt_id'])){
		$vkt_id = $_GET['vkt_id'];
	}
function mes($mes){
	switch($mes){
		case 1: echo "Janeiro";break;
		case 2: echo "Fevereiro";break;
		case 3: echo "Março";break;
		case 4: echo "Abril";break;
		case 5: echo "Maio";break;
		case 6: echo "Junho";break;
		case 7: echo "Julho";break;
		case 8: echo "Agosto";break;
		case 9: echo "Setembro";break;
		case 10: echo "Outubro";break;
		case 11: echo "Novembro";break;
		case 12: echo "Dezembro";break;
		
	}
} /*fim da funcao*/
//alert($logo);
$email=mysql_fetch_object(mysql_query($t="SELECT *
															
											FROM 
												eleitoral_emailmarketing 
											WHERE
												id='".$_GET['id']."'"));

												
$cliente_vekttor = mysql_fetch_object(mysql_query("SELECT * FROM clientes_vekttor WHERE id='$vkt_id'"));

echo $email->html;

?>
   
