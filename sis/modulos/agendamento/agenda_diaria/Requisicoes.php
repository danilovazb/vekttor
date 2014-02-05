<?php
include("../../../_config.php");
include("../../../_functions_base.php");

	$acao = $_GET['acao'];
	
	if($acao == 'atl_cliente'){
	
				$nome =  utf8_decode($_POST['nome']);	
				
					if(!empty($_POST['tipo'])){
							$tipo = $_POST['tipo'];	
					} else{ $tipo = "Cliente"; }
					
					if($_POST['tipo_cadastro'] == '1'){
						$tipo_cliente = "Físico";
					}else{ $tipo_cliente = "Jurídico"; }
					
				mysql_query($r=" INSERT INTO cliente_fornecedor 
								   SET 
								   cliente_vekttor_id = '$vkt_id', 
								   usuario_id         = '$usuario_id', 
								   razao_social       = '".$nome."', 
								   nome_fantasia      = '".$nome."',
								   nome_contato       = '".$nome."', 
								   cnpj_cpf           = '".$_POST['cnpjCpf']."', 
								   tipo               = '$tipo',
								   tipo_cadastro      = '$tipo_cliente' ");
					$id = mysql_insert_id();
					echo $id;
					
					mysql_query(" INSERT INTO odontologo_atendimentos SET
						vkt_id                = '$vkt_id',
						cliente_fornecedor_id = '$id',
						data_cadastro         = now() ");
					 
	}
?>