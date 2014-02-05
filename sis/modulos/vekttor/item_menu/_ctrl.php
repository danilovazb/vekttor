<?php
//Ações do Formulário

//Recebe ID
if(isset($_POST['sys_modulos_id'])) 
$sys_modulo_id=$_POST['sys_modulos_id'];

if($_GET['id'])
$sis_modulo_id=$_GET['id'];

//Cadastra Novo Usuario
if($_POST['action']=='Salvar' and empty($_POST['sys_modulos_id'])){
	
		global $vkt_id;
	
		//echo "cadastra";
		$cadastra=cadastraItemMenu($_POST['modulo_id'],$_POST['nome_item'],$_POST['tela'],$_POST['caminho'],$_POST['acao_menu'],$_POST['ordem_menu'],$_POST['menu_escondido']);
	
	
}

//Altera Usuario
if(!empty($sys_modulo_id)){
		global $vkt_id;
		$altera=alteraItemMenu($sys_modulo_id,$_POST['modulo_id'],$_POST['nome_item'],$_POST['tela'],$_POST['caminho'],$_POST['acao_menu'],$_POST['ordem_menu'],$_POST['menu_escondido']);
		alteraItensTutorial($_POST,$sys_modulo_id);
		echo "
		<script>
		$(document).ready(function(){
			var rowpos = $('#tabela_dados tr#{$_POST['modulo_id']}').position();
			$('#dados').scrollTop((rowpos.top)-70);
		})		
		</script>";
		
}

//Exclui Usuario
if($_POST['action']=='Excluir'){
	
	//echo "exckui";
	$exclui=excluiItem($_POST['sys_modulos_id']);
	if($exclui==0){
		alert('não pode excluir');
	}
}

//Pega informações
if($sis_modulo_id > 0 and empty($_POST['action']) ){
	
	$modulo = mysql_fetch_object(mysql_query("SELECT * FROM sis_modulos WHERE id='".$sis_modulo_id."' LIMIT 1")); 
	
		
}

/*-------------------------------------------------*/
if($_POST['salva_texto_html']== '1'){
	
	ManipulaTutorial($_POST,$vkt_id);
}

if(isset($_GET['tutorial_id'])){
	
	$tutorial = mysql_fetch_object(mysql_query("SELECT * FROM sis_modulos_tutorial WHERE id='".$_GET['tutorial_id']."'"));

}

?>