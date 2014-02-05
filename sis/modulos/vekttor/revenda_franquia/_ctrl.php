<?php
//Ações do Formulário

//Recebe ID
if(isset($_POST['franquia_id']))
	$franquia_id=$_POST['franquia_id'];
if($_GET['id'])

$franquia_id=$_GET['id'];

//Cadastra Novo Usuario
if($_POST['action']=='Salvar' and empty($_POST['franquia_id'])){
	
		global $vkt_id;
	
		//echo "cadastra";
		$cadastra=cadastraFranquiaRevenda($_POST['cliente_fornecedor_id'],$vkt_id);
	
	//salvaUsuarioHistorico("Formulário - Cliente","Salvou um Cliente Novo");
}

//Altera Usuario
if(!empty($franquia_id)){
		
		global $vkt_id;
		
		//echo "altera";
		$altera=alteraFranquia($franquia_id,$_POST['cliente_fornecedor_id'],$vkt_id);
	
	//salvaUsuarioHistorico("Formulário - Cliente","Alterou o ID $cliente_fornecedor_id");
}

//Exclui Usuario
if($_POST['action']=='Excluir'){
	
	//echo "exckui";
	$exclui=excluiFranquia($_POST['franquia_id']);
	if($exclui==0){
		alert('não pode excluir');
	}
}

//Pega informações
if($franquia_id > 0 and empty($_POST['action']) ){
	
	$franquia=mysql_fetch_object(mysql_query("SELECT * FROM revenda_franquia WHERE id='".$franquia_id."' LIMIT 1")); 
	
			$c=mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = ".$franquia->cliente_id));
}

?>