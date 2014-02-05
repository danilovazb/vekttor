<?php
//Ações do Formulário

//Recebe ID
if($_POST['cliente_id'])$cliente_vekttor_id=$_POST['cliente_id'];
if($_GET['cliente_id'])$cliente_vekttor_id=$_GET['cliente_id'];
//Cadastra Novo Cliente
//alert($_POST['']);
if($_POST['salva_formulario_contrato_aluguel']== '1'){
	
if(!($cliente_vekttor_id>0)){
		//echo var_dump($_POST['pacote_id']);
		ManipulaCliente($_POST,0,$_POST[pacote_id]);
}
//Altera Usuario
if($_POST['action']!='Excluir'&&$cliente_vekttor_id>0){
		
		ManipulaCliente($_POST,$cliente_vekttor_id,$_POST[pacote_id]);
		
}
}

if($_POST['action']=='Excluir'){
	ExcluiCliente($_POST);	
}

if(isset($cliente_vekttor_id)){
	
	$cliente_vekttor = mysql_fetch_object(mysql_query($t="SELECT 
															*
														  FROM 
														  clientes_vekttor cv														  
														  WHERE 
														  cv.id='$cliente_vekttor_id'"));
	//echo $t;
	$cliente_fornecedor = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$_GET['cf']."'"));
	//echo $t;
	$tipo_usuario = mysql_fetch_object(mysql_query($t="SELECT * FROM usuario_tipo WHERE vkt_id='".$cliente_vekttor_id."' ORDER BY id "));
	//echo $t;
	$usuario = mysql_fetch_object(mysql_query("SELECT * FROM usuario WHERE cliente_vekttor_id='".$cliente_vekttor->id."'"));
	$revenda = mysql_fetch_object(mysql_query($t="SELECT * FROM revenda_franquia WHERE id='".$_GET['revenda_id']."'"));
	//echo $t."<br>";
}
?>