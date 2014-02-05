<?php

if($_POST['salva_formulario_contrato_cliente']== '1'){
	//alert("oi");
	manipulaContrato($_POST,$vkt_id);
}
if($_POST['action']=='Inserir Imagem'){
	incluirImagem($_POST);
}
if($_POST['action']=='Excluir'){
	exclui_emailmarketing($_POST['id']);
}
if($_POST['action']=='Excluir'){
	exclui_contrato($_POST['id']);
}

if($_GET['id'] > 0){
		$contrato = mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_contrato_modelo WHERE id='".$_GET['id']."'")); 
}

?>