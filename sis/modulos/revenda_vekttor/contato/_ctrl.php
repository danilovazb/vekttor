<?
//Ações do Formulário

//Recebe ID

if($_POST['action']=='Salvar'){
		
		if($_POST['id'] > 0)
			$contato_id = update($_POST);
		else
			$contato_id = cadastra($_POST);
		
			
		if($_POST['tipo_interacao']>0){
			//alert($contato_id);
			manipulaInteracao($_POST,$contato_id);
		}

}
//Altera Usuario
if($_POST['action']=='Excluir'){
		excluir($_POST['id']);		
}

if($_GET['id'] > 0){
		$id = $_GET['id'];
		$contato = mysql_fetch_object(mysql_query(" SELECT * FROM revenda_contato WHERE id = '$id' "));
		//seleciona o histórioco de interacao
		$interacoes = mysql_query("SELECT * FROM revenda_contato_interacao WHERE revenda_contato_id = '".$_GET['id']."' ORDER BY id");
		
}
?>