<?
$vendedor = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE usuario_id='$usuario_id'"));
//A��es do Formul�rio

//Recebe ID
if($_POST['salva_formulario_contrato_aluguel'] == 1){
	include 'modulos/revenda_vekttor/venda/_functions.php';
	include 'modulos/revenda_vekttor/venda/_ctrl.php';
}else 
if($_POST['action']=='Salvar'){
	
	if($_POST['contato_id'] > 0)
			$contato_id = updatei($_POST);			
	else
			$contato_id = cadastrai($_POST);
	
	
	
	if($_POST['tp_interacao']>0){
		manipulaInteracao($_POST,$contato_id);
	}
}

//Id da intera�ao
if($_GET['id']>0){
	$interacao = mysql_fetch_object(mysql_query("SELECT * FROM revenda_contato_interacao WHERE id='".$_GET['id']."'"));
	  if(!empty($interacao)){
		//seleciona o hist�rioco de interacao
		$interacoes = mysql_query("SELECT * FROM revenda_contato_interacao WHERE revenda_contato_id = '$interacao->revenda_contato_id' ORDER BY id");
	}
}
?>