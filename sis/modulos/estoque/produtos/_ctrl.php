<?
if($_POST['id'])$id=$_POST['id'];

if($_GET['id'])$id=$_GET['id'];
//print_r($_POST);
//Cadastra Novo Produto
//action 2 refere-se a acao feita ao cadastrar uma foto do produto, no formulário de cadastro, aba form

if(($_POST['action']=='Salvar'||$_POST['action2']=='Salvar')&&empty($id)){
	
	$cadastra=cadastraProduto($_POST['nome'],$_POST['produto_grupo_id'],$_POST['unidade'],$_POST['conversao1'],$_POST['unidade_embalagem'],$_POST['conversao2'],$_POST['unidade_uso'],
	$_POST['estoque_min'],$_POST['estoque_max'],$_POST['tempo_reposicao'],$_POST['custo'],$_POST['preco_compra'],$_POST['preco_venda'],$_POST['descricao'],$_POST['foto'],$_POST['codigo'],$_POST['gramatura'],$vkt_id);
	
	if($cadastra > 0){
		produto_has_fornecedor($cadastra,$_POST);
	}
	
	if($_POST['action2']=='Salvar'&&strlen($_FILES['foto_produto_arquivo']['name'])>3&&$cadastra>0){
		//alert('oi');
		$foto_id = produto_envia_foto($cadastra,$_POST);
		
		echo "<script>nl= top.document.getElementById('dados_fotos').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length-1;top.document.getElementById('dados_fotos').getElementsByTagName('tbody')[0].getElementsByTagName('tr')[nl].setAttribute('id','$foto_id');top.document.getElementById('id').value='$cadastra'</script>";
		
	}
	
	salvaUsuarioHistorico("Formulário - Produto",'Cadastrou um Novo','produto',$cadastra);
	//,$_POST['prod_comp_id'],$_POST['prod_comp_qtd']
}
//Altera Produto
if(($_POST['action']=='Salvar'||$_POST['action2']=='Salvar')&&isset($id)){
	
	$altera=alteraProduto($id,$_POST['codigo'],$_POST['nome'],$_POST['produto_grupo_id'],$_POST['unidade'],$_POST['conversao1'],$_POST['unidade_embalagem'],$_POST['conversao2'],$_POST['gramatura'],$_POST['unidade_uso'],
	$_POST['estoque_min'],$_POST['estoque_max'],$_POST['tempo_reposicao'],$_POST['custo'],$_POST['preco_compra'],$_POST['preco_venda'],$_POST['descricao'],$_POST['prod_comp_id'],$_POST['prod_comp_qtd']);
	
	produto_has_fornecedor($id,$_POST);
	
	if($_POST['action2']=='Salvar'&&strlen($_FILES['foto_produto_arquivo']['name'])>3){
		
		$foto_id = produto_envia_foto($id,$_POST);
		
		echo "<script>nl= top.document.getElementById('dados_fotos').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length-1;top.document.getElementById('dados_fotos').getElementsByTagName('tbody')[0].getElementsByTagName('tr')[nl].setAttribute('id','$foto_id')</script>";
		
	}
	
	salvaUsuarioHistorico("Formulário - Produto",'Alterou o ID $id','produto',$id);
}
//Exclui Produto
if($_POST['action']=='Excluir'&&isset($id)){
	$exclui=excluiProduto($id);
	
	remove_produto_has_fornecedor($id,$_POST);
	
	remove_fotos_produtos($id);
	
	salvaUsuarioHistorico("Formulário - Produto",'Excluiu o ID $id','produto',$id);
}

//Exclui Foto do Produto
if($_POST['action2']=='ExcluirFoto'){
	//alert('oi');
	
	excluiFotoProduto($_POST['id_foto_exclusao']);
	
}

//acao enviada ao exluir o fornecedor, na aba fornecedores
if($_GET['acao']=='excluir_produto_fornecedor'){
	include("../../../_config.php");
	include("_functions.php");
	remove_fornecedor_do_produto($_GET);
	exit();
}

//Pega informações
if($id>0){
	
	$obj=mysql_fetch_object(mysql_query($trace="SELECT * FROM produto WHERE id='".$id."' LIMIT 1"));
	salvaUsuarioHistorico("Formulário - Produto",'Abriu o ID $id','produto',$id);
}
?>