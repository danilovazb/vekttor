<?

if($_GET['empresa1id']>0){$empresa1id = $_GET['empresa1id'];}
if($_POST['f_empresa_id']>0){$empresa1id = $_POST['f_empresa_id'];}

//echo print_r($_POST);

if($_POST['id']>0){$id=$_POST['id'];}
if($_GET['id']>0){$id=$_GET['id'];}

if($_POST['action']== 'Salvar'){
	if($_POST['acao2']=='funcionario'){
	
		$id=ManipulaFuncionario($_POST);
		$_POST['action']='';
	}
}
if($_POST['action']== 'Excluir'){
	deletar_funcionario($_POST['id']);
}

if($_GET['adicionar_dependente']== '1'){
	
	ManipulaDependente($_GET);
	$id=$_GET['funcionario_id'];
}

if($_POST['acao2']== 'documento'){
	
	ManipulaDocumento($_POST);
	
	$_POST['acao2']='';
	require_once('tabela_documentos.php'); 

	echo "
			<script>
		
			top.document.getElementById('dados_documentos').innerHTML=document.getElementById('documentos_funcionario').innerHTML;	
			</script>
			";
			
			exit();
	
}

if($_GET['remove_dependente']==1){

	remove_dependente($_GET);
	$id=$_GET['funcionario_id'];
}

if($_GET['remove_documento']==1){
	
	remove_documento($_GET);
	//$_GET['remove_documento']='';
	
	$id=$_GET['funcionario_id'];
}

if(!empty($_POST['salva_formulario_contrato'])){
	
	manipulaContrato($_POST,$vkt_id);
	

}


if($id>0){
	
	
	$registro = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$id' AND vkt_id='$vkt_id'"));
	
}

if($empresa1id>0){
	
		
	$cliente_fornecedor = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$empresa1id."'"));
	
}

?>