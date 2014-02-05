<?php

if($_POST['salva_formulario_contrato_aluguel']== '1'){
	if($_POST['id']>0){
		altera_aluguel_equipamento($_POST);
		//echo "Altera";
	}else{
		insere_aluguel_equipamento($_POST);
		//echo "Cadastra";
	}
}

if($_POST['action']== 'Realizar Locaçao'){
	realiza_locacao($_POST,$vkt_id);
}

if($_POST['action']== 'Excluir'){
	deletar_locacao($_POST['id']);
}

if($_GET['id'] > 0){
		$id = $_GET['id'];
		
		$aluguel = mysql_fetch_object(mysql_query(" SELECT * FROM aluguel_locacao WHERE id = '$id' AND vkt_id = '$vkt_id' "));
		$cliente = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$aluguel->cliente_id'"));
		
		if($aluguel->data_reserva != '0000-00-00'){
				$display_reserva = 'block';
		} else{
			    $display_reserva = 'none';
		}
}

?>