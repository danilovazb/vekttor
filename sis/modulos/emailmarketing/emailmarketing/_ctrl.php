<?php

if($_POST['salva_formulario_contrato_cliente']== '1'){
   
	if($_POST['action']=='Inserir Imagem'){
		incluirImagem($_POST);
	}else{
		manipulaEmailmarketing($_POST,$vkt_id);
	}
}
if($_POST['action']=='Excluir'){
	exclui_emailmarketing($_POST['id']);
}


if($_GET['id'] > 0){
		$email = mysql_fetch_object(mysql_query($t="SELECT * FROM emailmarketing WHERE id='".$_GET['id']."'")); 
}

?>