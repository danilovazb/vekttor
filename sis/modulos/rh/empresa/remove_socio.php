<?php
	include("../../../_config.php");
	// funções base do sistema
	include("../../../_functions_base.php");
	
	global $vkt_id;
	
	$empresa_id = $_POST['empresa_id'];
	$novo_socio = $_POST['novo_socio'];
	
	mysql_query($t="INSERT INTO rh_empresa_has_socios SET empresa_id='$empresa_id', socio_id='$novo_socio', vkt_id='$vkt_id'");
	
	$dados_socio = mysql_fetch_object(mysql_query($t="SELECT * FROM  rh_empresa_has_socios ehs, cliente_fornecedor cf WHERE ehs.vkt_id='$vkt_id' AND ehs.socio_id=cf.id AND ehs.socio_id='$novo_socio' LIMIT 1"));
	
	$dados.="
			<tr id_atestado='$dados_socio->id'>
                        <td style='width:200px;'>$dados_socio->razao_social</td>
                        <td style='width:30px;'>$dados_socio->rg</td>
                        <td style='width:30px;' align='center'>$dados_socio->cnpj_cpf</td>          
             </tr>";
	
	echo $dados;
?>
