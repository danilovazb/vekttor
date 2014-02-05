<?php

if($_POST['action']== 'Salvar'){
	if($_POST['id']>0){
		altera_ordem_servico($_POST);
		//echo "<div id='conteudo'>altera</div>";
	}else{
		insere_ordem_servico($_POST);
		//echo "<div id='conteudo'>cadastra</div>";
	}
	
	verifica_parcelas($_POST);
	
}
if($_POST['action']== 'Excluir'){
	deletar_ordem_servico($_POST['id']);
}
if($_POST['action'] == 'Aprovar'){
		if($_POST['ApAndSalve'] > 0){
				insere_ordem_servico($_POST);
		} else{
			Aprovar($_POST);
		}
}
if($_POST['action'] == 'Cancelar'){
		CancelarOs($_POST);	
}
if($_POST['action'] == 'Enviar ao Financeiro'){
	Pagamento($_POST);
	//echo "fsdds";
}
if($_POST['action'] == 'Finalizar'){
		if($_POST['entrega'] > 0){
			Entrega($_POST);
			//echo "Somente entrega";
		} else{
			Pagamento($_POST);
			echo " Pagamento e Entrega";
		}
	//echo "fsdds";
}

if($_GET['action']=='altera_status'){
	altera_status_impresso($_GET);
}

if($_GET['id'] > 0){
	/*--- Opçoes para os campos de entrada de dados ---*/
	
	$id = $_GET['id'];
	if($id > 0){
		$opcoes = array('1'=>'none','2'=>'inline');
	} 
	
	
	
	$reg_os = mysql_fetch_object(mysql_query("SELECT * FROM os WHERE id='$id' AND vkt_id = '$vkt_id' ORDER BY id ASC"));
	$cliente_id = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$reg_os->cliente_id'"));
	$total_edit_produto = mysql_fetch_object(mysql_query(" SELECT  count(id),sum(valor_produto * qtd_produto) as total_produto FROM os_item_produto WHERE os_id = '$reg_os->id' AND vkt_id = '$vkt_id' "));
	$total_edit_servico = mysql_fetch_object(mysql_query(" SELECT  count(id), sum(valor_servico * qtd_servico) as total_servico FROM os_item WHERE os_id = '$reg_os->id' AND vkt_id = '$vkt_id' "));
	
	/*----------- PEGA OS ITENS DA OS ------------*/
	$array_item = mysql_query("SELECT * FROM os_item WHERE os_id = '$reg_os->id' AND vkt_id = '$vkt_id' ORDER BY id ASC ");
	
					while($itens = mysql_fetch_object($array_item)){
								if($itens->servico_id != 0){
									$array_servico[] = $itens->servico_id;	
								}
								if($itens->produto_id != 0){
									$array_produto[] = $itens->produto_id;
								}
															 
					} 
					
					/*if($reg_os->situacao == '2' or $reg_os->situacao == '3'){
						$readonly = 'readonly="readonly" class="readonly"';
						$disabled = '';
					}*/
					if($reg_os->data_orcamento != '0000-00-00'){ 
						$disOrcado = 'inline';
					} 
					else {
						$disOrcado = 'none';
					}
}

?>