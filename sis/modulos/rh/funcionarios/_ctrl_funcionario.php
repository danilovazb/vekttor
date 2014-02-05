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
	if($_POST['acao2']=='dados_sociais'){
		$id=$_POST['id'];
		ManipulaDadosSociais($_POST);
		$_POST['action']='';
	}
	if($_POST['acao2']=='avaliacao'){
		avaliafuncionario($_POST);
		$_POST['action']='';
	}
}
if($_POST['action']== 'Excluir'){
	deletar_funcionario($_POST['id']);
}

if($_GET['adicionar_dependente']== '1'){
	$adicionar_dependente=1;
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

if($_GET['acao']=='remover_foto'){
	include("../../../_config.php");
	include('_function_funcionario.php');
	remover_foto($_GET['id_foto']);
}


if($id>0){
	
	
	$registro = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_funcionario WHERE id='$id' AND vkt_id='$vkt_id'"));
	//cho $t."<br>";	$dados['periodo_experiencia'] = $registro->dias_experiencia;-<br />
	$dados['data_admissao'] = $registro->data_admissao;
	$prazos_experiencia = calculadata($dados);
	
	//print_r($prazos_experiencia);
}

if($empresa1id>0){
	
		
	$cliente_fornecedor = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$empresa1id."'"));
	
}

if($_POST['acao']=='consulta_avaliacao'){
	include("../../../_config.php");
	
	include('_function_funcionario.php');
	
	$avaliacao =consulta_avaliacao($_POST);
	echo $avaliacao;
	exit();
}

if($_POST['acao']=='calcula_data'){
	include("../../../_config.php");
	include("../../../_functions_base.php");	
	include('_function_funcionario.php');
    $_POST['data_admissao'] = dataBrToUsa($_POST['data_admissao']);
	$resultado = calculadata($_POST);
	echo $resultado;
	exit();
}


$escolaridade = array("1"=>"Analfabeto",
					   "2"=>"Até a 4ª série incompleta do ensino fundamental",
        			   "3"=>"Com a 4ª série completa do ensino fundamental",
        			   "4"=>"De 5 a 8ª série incompleta do ensino fundamental",
        			   "5"=>"Ensino fundamental completo",
        			   "6"=>"Ensino médio incompleto",
					   "7"=>"Ensino médio completo",
					   "8"=>"Superior incompleto",
					   "9"=>"Superior completo",
					   "10"=>"Mestrado",
					   "11"=>"Doutorado",
					   "12"=>"Pós Doutorado");
?>