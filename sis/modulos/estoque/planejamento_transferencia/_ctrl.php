<?php
if($_GET['id']>0){$transferencia_id=$_GET['id'];}
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

$comensais=@mysql_fetch_object(mysql_query($t="SELECT SUM(almoco_mes) as comensais 
		FROM cozinha_contratos as cc, cliente_fornecedor as cf
		WHERE cc.vkt_id='$vkt_id' AND cc.cliente_id=cf.id AND
		cc.unidade_id = ".$_GET['id_destino']." AND
		cc.status='1'"));

if($_GET['id_origem'] > 0 and $_GET['id_destino'] > 0 and ($_GET['acao'] == 'cadastra')){
	
	if($_POST['transferencia_id'] == 0){
		$origem = $_GET['id_origem'];
		$destino = $_GET['id_destino'];
		$data= date('Y-m-d');
		$origem_nome = mysql_fetch_object(mysql_query(" SELECT * FROM cozinha_unidades WHERE id = ".$_GET['id_origem']));
		$destino_nome = mysql_fetch_object(mysql_query(" SELECT * FROM cozinha_unidades WHERE id = ".$_GET['id_destino']));
		$produtos = mysql_query("SELECT * FROM produto WHERE vkt_id='$vkt_id'");
		
	mysql_query("INSERT INTO estoque_transferencia 
				 SET 
				  unidade_id_origem = '$origem', 
				  unidade_id_destino = '$destino',
				  data_inicio = '$data',
				  comensal='$comensais->comensais',
				  vkt_id = '$vkt_id'
			 ");
	$transferencia_id = mysql_insert_id();		 
	//insere os itens da transferencia
	while($produto=mysql_fetch_object($produtos)){
		mysql_query("INSERT INTO estoque_transferencia_item 
							SET 
								vkt_id           = '$vkt_id',
								transferencia_id = '$transferencia_id',
								produto_id       = '".$produto->id."',
								qtd_enviada      = '0',
								valor_ini        = '".$produto->preco_compra."',
								ocorrencia       = '',
								unidade          = '".$produto->unidade_embalagem."',
								fatorconversao   = '".$produto->conversao."',
								gramatura        = '".$produto->gramatura."',
								recebido         = 'nao',
								marcado          = 'nao'
					");
	}
	echo "<script>location.href='?tela_id=518&acao=edit&id=$transferencia_id&id_origem=$origem&id_destino=$destino&status=0'</script>";		 
	//$transferencia_id = mysql_insert_id(); // pega o ultimo registro da transferencia
	$data = date('d/m/Y');	
	}
	
}


if($_POST['action']== 'Excluir'){
	deletar_corretor($_POST['id']);
}
//echo "Id da Nova Transferencia: ".$transferencia_id;
if($transferencia_id > 0){
	//$transferencia_id = $_GET['id'];

	$transferencia = mysql_fetch_object(mysql_query("SELECT * FROM estoque_transferencia WHERE id = '$transferencia_id'"));
	

							
							//echo $t;
							
		$origem_nome = mysql_fetch_object(mysql_query(" SELECT * FROM cozinha_unidades WHERE id = ".$_GET['id_origem']));
		$destino_nome = mysql_fetch_object(mysql_query(" SELECT * FROM cozinha_unidades WHERE id = ".$_GET['id_destino']));
}
	//$comensais = @mysql_fetch_object(mysql_query($t=" SELECT SUM(almoco_mes) as comensais FROM cozinha_contratos WHERE unidade_id = ".$_GET['id_origem']." AND vkt_id='$vkt_id' AND status='1'"));
	
		//echo $t;
	//echo $comensais->comensais;
	
?>