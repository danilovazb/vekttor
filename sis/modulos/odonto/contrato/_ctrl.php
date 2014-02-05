<?php

if($_POST['salva_formulario_contrato_cliente']== '1'){
	//alert("oi");
	manipulaContratoCliente($_POST,$vkt_id);
}
if($_POST['action']=='Excluir'){
	exclui_contrato_cliente($_POST['id']);
}

if($_GET['id'] > 0){
		$contrato = mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_contrato_cliente WHERE id='".$_GET['id']."'")); 
}

?>