<?
//Aç?es do Formulário

//Recebe ID
if($_POST['id'])$cliente_fornecedor_id=$_POST['id'];
if($_GET['id'])$cliente_fornecedor_id=$_GET['id'];
if($_POST['cliente_fornecedor_id'])$cliente_fornecedor_id=$_POST['cliente_fornecedor_id'];
if($_GET['cliente_fornecedor_id'])$cliente_fornecedor_id=$_GET['cliente_fornecedor_id'];
if($_GET['socio_id']>0){$socio_id=$_GET['socio_id'];}
if($_POST['socio_id']>0){$socio_id=$_POST['socio_id'];}
if($_GET['remove_documento_socio']==1){$socio_id=$_GET['socio_id'];}

//Cadastra Novo Usuario

if($_POST['action']=='Salvar'){
	//alert($_POST);
	if($_POST['acao2']=='empresa'){
		
		$cliente_fornecedor_id = ManipulaEmpresa($_POST,'jurídico');
		$_POST['action']='';
		//echo "
			//<script>
			//top.document.getElementById('cliente_fornecedor_id').value='$cliente_fornecedor_id';
			//top.document.getElementById('cliente_fornecedor_id2').value='$cliente_fornecedor_id';
			//top.document.getElementById('cliente_fornecedor_id3').value='$cliente_fornecedor_id';
		//";
		
		//alert($cliente_fornecedor_id);
		//exit();
	}
	
	if($_POST['acao2']=='socio'){
		
		if(ManipulaSocio($_POST,'físico')){
			
			$_POST['acao2']='';
			require_once('tabela_socios.php'); 

			echo "
			<script>
			top.document.getElementById('form_socio').innerHTML='';
			top.document.getElementById('dados_socios').innerHTML=document.getElementById('socios_interno').innerHTML;	
			</script>
			";
			
			exit();
				
		}
		
	}
	if($_POST['acao2']=='requerimento'){
		
		ManipulaRequerimento($_POST);
		
	}
	
}

if($_POST['acao2']== 'documento'){
	
	adicionarDocumento($_POST);
	
	$_POST['acao2']='';
	$acao_documento='documento';
	require_once('tabela_documentos.php'); 

	echo "
			<script>
		
			top.document.getElementById('dados_documentos').innerHTML=document.getElementById('documentos_funcionario').innerHTML;	
			</script>
			";
			
			exit();
	
}

if($_POST['acao2']== 'documento_socio'){
	
	//alert(strlen($_FILES['documento_arquivo_socio']));
	
	adicionarDocumentoSocio($_POST);
	
	$_POST['acao2']='';
	
	require_once('tabela_documentos_socios.php'); 

	echo "
			<script>
		
			top.document.getElementById('dados_documentos_socios').innerHTML=document.getElementById('documentos_funcionario').innerHTML;	
			</script>
			";
			
			exit();
	
}

if($_GET['remove_documento']==1){
	
	excluirDocumento($_GET);
	//$_GET['remove_documento']='';
	
	$id=$_GET['cliente_fornecedor_id'];
}

if($_GET['remove_documento_socio']==1){
	//alert('oi');
	excluirDocumento($_GET);
	
}

if($_POST['action']=='Excluir'){
	alteraStausEmpresa(0,$_POST['cliente_fornecedor_id']);
}

if(!empty($_POST['salva_formulario_contrato'])){
	
	manipulaContrato($_POST,$vkt_id,$_POST['salva_formulario_contrato']);
	

}


if($_GET[associa_socio]==1){
	liga_socio_a_empresa();
	$cliente_fornecedor_id = $_GET['empresa_id'];
}

if($_GET[remove_socio]==1){
	desliga_socio_a_empresa();
	$cliente_fornecedor_id = $_GET['empresa_id'];
}


/*if($_POST['salva_formulario_contrato_social']== '1'){
	//alert("Contrato Social");
	manipulaContrato($_POST,$vkt_id,'social');

}*/



if($cliente_fornecedor_id>0){
	$cliente_fornecedor=mysql_fetch_object(mysql_query("
	SELECT 
	*, cf.id as cliente_fornecedor_id 
	FROM 
	rh_empresas re,
	cliente_fornecedor cf 
	WHERE 
	re.cliente_fornecedor_id=cf.id AND
	cf.id='".$cliente_fornecedor_id."' LIMIT 1")); 
	$contrato_interno = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_empresa_has_contratos  WHERE tipo='interno' AND empresa_id='".$cliente_fornecedor_id."' LIMIT 1"));
	$contrato_social = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_empresa_has_contratos  WHERE tipo='social' AND empresa_id='".$cliente_fornecedor_id."' LIMIT 1"));
	//echo $t;
	//salvaUsuarioHistorico("Formulário - Cliente","Excluiu o ID $cliente_fornecedor_id");
}

if($socio_id>0){
	$socio=mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$socio_id."' LIMIT 1"));
	//echo  $t;
	$dados_socio = mysql_fetch_object(mysql_query("SELECT * FROM rh_socios WHERE cliente_fornecedor_id='$socio->id'"));
}
?>