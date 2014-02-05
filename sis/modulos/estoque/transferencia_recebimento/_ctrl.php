<?php
$display = 'none';

$status_transferencia = array(
		0 => "Aberto",
		1 => "Enviado",
		2 => "Recebido",
		3 => "Cancelado",
);

if($_POST['action']== 'Salvar'){
	if($_POST['id']>0){
		altera_corretor($_POST);
	}else{
		insere_corretor($_POST);
	}
}
if($_POST['action']== 'Excluir'){
	deletar_corretor($_POST['id']);
}
if($_POST['acao'] == "receber"){
	//print_r($_POST['qtd_enviada']);
	RealizaTransferenciaDestino($_POST);
}




if($_GET['id'] > 0 and $_GET['acao'] == 'edit_recebimento'){
	global $vkt_id;
	$transferencia_id = $_GET['id'];

	$transferencia = mysql_fetch_object(mysql_query("SELECT * FROM estoque_transferencia WHERE id = '$transferencia_id' AND vkt_id = '$vkt_id' "));
	
	$item = mysql_query("SELECT *,i.ocorrencia_recebimento AS oc_recebimento FROM estoque_transferencia_item AS i 
							JOIN estoque_transferencia t  on t.id = i.transferencia_id
							JOIN produto p on i.produto_id=p.id 
							WHERE t.id = '$transferencia_id' AND t.vkt_id = '$vkt_id' ");
							
	$origem_nome = mysql_fetch_object(mysql_query(" SELECT * FROM cozinha_unidades WHERE id = ".$_GET['origem']."  AND vkt_id = '$vkt_id' "));
	$destino_nome = mysql_fetch_object(mysql_query(" SELECT * FROM cozinha_unidades WHERE id = ".$_GET['destino']." AND vkt_id = '$vkt_id' "));
}

?>