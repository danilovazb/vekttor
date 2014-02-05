<?php
$display = 'none';

$status_transferencia = array(
		0 => "Aberto",
		1 => "Enviado",
		2 => "Recebido",
		3 => "Cancelado",
);
if($_POST['opcao'] == "enviar"){
	
	RealizaTransferenciaOrigem($_POST); // transferencia para origem
}

if($_GET['id_origem'] > 0 and $_GET['id_destino'] > 0 and ($_GET['acao'] == 'cadastra')){
	
	if($_POST['transferencia_id'] == 0){
		$origem = $_GET['id_origem'];
		$destino = $_GET['id_destino'];
		$data= date('Y-m-d');
		$origem_nome = mysql_fetch_object(mysql_query(" SELECT * FROM cozinha_unidades WHERE id = ".$_GET['id_origem']));
		$destino_nome = mysql_fetch_object(mysql_query(" SELECT * FROM cozinha_unidades WHERE id = ".$_GET['id_destino']));
	mysql_query("INSERT INTO estoque_transferencia 
				 SET 	
				  unidade_id_origem = '$origem', 
				  unidade_id_destino = '$destino',
				  data_inicio = '$data',
				  vkt_id = '$vkt_id'
			 ");
	$transferencia_id = mysql_insert_id(); // pega o ultimo registro da transferencia
	$data = date('d/m/Y');	
	}
	
	echo "<script>location.href='?tela_id=193&acao=edit&id=$transferencia_id&id_origem=$origem&id_destino=$destino&status=0'</script>";
	
}


if($_POST['action']=='Excluir'){
	deletar_corretor($_POST['id']);
}

if($_GET['id'] > 0 and $_GET['acao'] == 'edit'){
	$transferencia_id = $_GET['id'];

	$transferencia = mysql_fetch_object(mysql_query("SELECT * FROM estoque_transferencia WHERE id = '$transferencia_id'"));
	
	$item = mysql_query($t="SELECT *,i.ocorrencia_recebimento as oc_recebimento, i.id AS item_id FROM estoque_transferencia_item AS i 
						 JOIN 
						 	estoque_transferencia AS t  on t.id = i.transferencia_id
						 JOIN 
						 	produto AS p on i.produto_id=p.id WHERE t.id = '$transferencia_id' AND i.marcado='sim' ORDER BY p.nome ASC" );
							
							//echo $t;
							
		$origem_nome = mysql_fetch_object(mysql_query(" SELECT * FROM cozinha_unidades WHERE id = ".$_GET['id_origem']));
		$destino_nome = mysql_fetch_object(mysql_query(" SELECT * FROM cozinha_unidades WHERE id = ".$_GET['id_destino']));
}

?>