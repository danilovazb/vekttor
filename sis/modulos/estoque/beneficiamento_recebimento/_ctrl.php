<?php

if($_POST['action']== 'Salvar'){
	if($_POST['pedido_id']>0){
		altera_pedido($_POST);
		//echo "altera";
	}else{
		//insere_insere($_POST);
		//echo "insere";
	}
}

if($_POST['action']== 'Excluir'){
	deletar_corretor($_POST['id']);
}

if($_GET['id'] > 0 ){
	
	
	
	$id_pedido = $_GET['id'];

	$pedido = mysql_fetch_object(mysql_query($tb="SELECT *,
														e.id as pedido_id 
											FROM estoque_beneficiamento_pedido e
												
												JOIN produto p ON e.produto_beneficiado_id=p.id  
													
													WHERE e.vkt_id = '$vkt_id' 
													
													AND e.id = '".$id_pedido."'"));
	
	$item = mysql_query("SELECT *, i.id as item_id FROM estoque_beneficiamento_item i
									JOIN produto p	on i.produto_id=p.id
										WHERE beneficiamento_id = '$id_pedido' ");
										
	
	if($pedido->status == '2'||$pedido->status == '3'){
			$disable  = 'disabled="disabled"';
	} 
							
		
}

?>