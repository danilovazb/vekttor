<?php
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");

	$acao = $_GET['acao'];
		
		if($acao == 'buscaServico'){
				global $vkt_id;
						$id = $_POST['id'];
						$result = mysql_fetch_object(mysql_query($h=" SELECT * FROM servico WHERE id = '$id'"));
										$nome = utf8_encode($result->nome);
						$Array = array('id'=>$result->id,'nome' =>$nome ,'valor_normal' => moedaUsaToBr($result->valor_normal),'valor_colaborador'=>$result->valor_colaborador,'und'=>$result->und);
						//print_r ($Array);
						echo json_encode($Array);
		}

?>