<?php

if($_POST['action']== 'Salvar'){
	//alert("oi");
	manipulaLista($_POST);
}
if($_POST['action']=='Excluir'){
	exclui_contrato($_POST['id']);
}

if($_GET['id'] > 0){
		$lista = mysql_fetch_object(mysql_query($t="SELECT * FROM emailmarketing_listas WHERE id='".$_GET['id']."'")); 
}

?>