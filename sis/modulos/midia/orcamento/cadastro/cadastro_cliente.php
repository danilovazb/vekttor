<?
include "../../../../_config.php";
include "../../../../_functions_base.php";
include "../../../administrativo/clientes/_functions.php";
if($_POST['id'])$cliente_fornecedor_id=$_POST['id'];
if($_GET['id'])$cliente_fornecedor_id=$_GET['id'];
if($_POST['cliente_fornecedor_id'])$cliente_fornecedor_id=$_POST['cliente_fornecedor_id'];
if($_GET['cliente_fornecedor_id'])$cliente_fornecedor_id=$_GET['cliente_fornecedor_id'];


if($_POST['action']=='Salvar'&&empty($cliente_fornecedor_id)){
	
	if($_POST['tipo_cadastro']=='Jurídico'){
		
		$cliente_id=cadastraClienteFornecedor($_POST['j_razao_social'],$_POST['j_nome_fantasia'],$_POST['j_nome_contato'],$_POST['j_ramo_atividade'],$_POST['j_cnpj_cpf'],$_POST['j_suframa'],$_POST['j_inscricao_municipal'],$_POST['j_inscricao_estadual'],$_POST['j_email'],$_POST['j_telefone1'],$_POST['j_telefone2'],$_POST['j_fax'],$_POST['j_cep'],$_POST['j_endereco'],$_POST['j_bairro'],$_POST['j_cidade'],$_POST['j_estado'],$_POST['j_limite'],"Cliente",$_POST['tipo_cadastro'],"","","","","","","","","","","","","","","","","","","","","","",$_POST['cf_grupo_id']);
		$nome=$_POST['j_nome_fantasia'];
		
	}
	if($_POST['tipo_cadastro']=='Físico'){
		
		$cliente_id=cadastraClienteFornecedor($_POST['f_nome_contato'],$_POST['f_nome_contato'],$_POST['f_nome_contato'],$_POST['f_ramo_atividade'],$_POST['f_cnpj_cpf'],"","","",$_POST['f_email'],$_POST['f_telefone1'],$_POST['f_telefone2'],$_POST['f_fax'],$_POST['f_cep'],$_POST['f_endereco'],$_POST['f_bairro'],$_POST['f_cidade'],$_POST['f_estado'],$_POST['f_limite'],"Cliente",$_POST['tipo_cadastro'],$_POST['f_telefone_comercial'],$_POST['f_estado_civil'],
		$_POST['f_naturalidade'],$_POST['f_rg'],$_POST['f_local_emissao'],dataBrToUsa($_POST['f_data_emissao']),$_POST['f_nacionalidade'],$_POST['f_conjugue_nome'],dataBrToUsa($_POST['f_conjugue_data_nascimento']),$_POST['f_conjugue_ramo_atividade'],$_POST['f_conjugue_cpf'],		$_POST['f_conjugue_rg'],$_POST['f_conjugue_local_emissao'],dataBrToUsa($_POST['f_conjugue_data_emissao']),$_POST['f_conjugue_telefone'],$_POST['f_conjugue_email'],$_POST['f_conjugue_naturalidade'],$_POST['f_conjugue_nacionalidade'],
		$_POST['f_endereco_comercial_conjugue'],$_POST['f_telefone_comercial_conjugue'],dataBrToUsa($_POST['f_nascimento']),$_POST['f_endereco_comercial'],$_POST['cf_grupo_id'],$_POST['sexo']);
		$nome=$_POST['f_nome_contato'];
	}
	//salvaUsuarioHistorico("Formulário - Cliente","Salvou um Cliente Novo");
	if($cliente_id>0){
		//echo json_encode(array('id'=>$cliente_id,'nome_fantasia'=>$nome));
		echo "<script>
		top.document.getElementById('nome').value='$nome';
		top.document.getElementById('cliente_id').value='$cliente_id';
		top.document.getElementById('add-cliente-form').innerHTML=''
		
		</script>";
	}
}
