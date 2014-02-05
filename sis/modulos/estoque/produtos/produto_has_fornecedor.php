<?php
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");

global $vkt_id;

$produto_id     = $_POST['id'];
$fornecedor_id = $_POST['fornecedor_id'];
$razao_social   = $_POST['razao_social'];
$acao              = $_POST['acao'];

if($acao=='adicionar'){	
	$fornecedor = mysql_fetch_object(mysql_query($t1="SELECT * FROM produto_has_fornecedor WHERE fornecedor_id = '$fornecedor_id' AND produto_id='$produto_id' AND vkt_id='$vkt_id'"));
	//$t1="SELECT * FROM produto_has_fornecedor WHERE produto_id = '$produto_id' AND forncedor_id='$fornecedor_id'";
	
	//if($fornecedor->id<=0){
		$retorno = "<tr>
                	<td style='width:500px;'>$razao_social<input type='hidden' name='produto_has_fornecedor[]' class='produto_has_fornecedor' value='$fornecedor_id'></td>
                    <td style='width:50px;' align='center'><img src='../fontes/img/menos.png' class='remove_fornecedor'/></td>
			</tr>";
		
	//}
	
}
echo $retorno;
/*
if($_GET['acao']=='excluir'){	
	$produto_has_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM produto_has_fornecedor WHERE produto_id = '$produto_id' AND fornecedor_id='$fornecedor_id'"));
	
	if($produto_has_fornecedor->id<=0){
			
	}
}
*/
?>