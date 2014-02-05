<?

$necessidade_id = $_GET['necessidade_id'];

//------------------------------------------------------------------
if($_POST['acao']=='Salvar'){
	
	manipulaPlanejamento($_POST);
}

if($_GET['acao']=='necessidade'){
	if(!empty($cotacao_id)){
		$cotacao=$_GET['cotacao_id'];
		$item_cotacao = mysql_fetch_object(mysql_query($t="SELECT * FROM cozinha_cotacao_item WHERE cotacao_id=".$cotacao_id."'"));
		
	}
}elseif($_GET['acao']=='cotacao'){
	$fornecedor_id=$_GET['fornecedor_id'];
	$fornecedor=mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$fornecedor_id."'"));
	$necessidade_id=$_GET['necessidade_id'];
	
	
	//echo $t."<br>";
	$cotacao=mysql_fetch_object(mysql_query($t="SELECT * FROM cozinha_cotacao WHERE fornecedor_id='$fornecedor_id' AND necessidade_id='$necessidade_id'"));
	//echo $t."<br>";
	if(empty($cotacao)){
		
		$novacotacao=cadastraCotacao($necessidade_id,$fornecedor_id,$vkt_id);
		
		//echo "Criou Nova";
	}
	if(!empty($cotacao)){$cotacao_id=$cotacao->id;}else{$cotacao_id=$novacotacao;}
}

//funções para criar cotação manualmente

if($_GET['acao']=='criar_cotacao'){
	
	$necessidade_id = manipula_necessidade($_GET);

	echo "<script>location.href='?tela_id=118&necessidade_id=$necessidade_id&acao=necessidade'</script>";
}

if($_GET['acao']=="cad_fornecedor"){
	include("../../../_config.php");
	include("_functions.php");
	cadastrar_fornecedor($_POST);
	
}

if(isset($_POST['action2'])){
	include("modulos/estoque/produtos/_functions.php");
	$cadastra=cadastraProduto($_POST['nome'],$_POST['produto_grupo_id'],$_POST['unidade'],$_POST['conversao1'],$_POST['unidade_embalagem'],$_POST['conversao2'],$_POST['unidade_uso'],$_POST['estoque_min'],$_POST['estoque_max'],$_POST['tempo_reposicao'],$_POST['custo'],$_POST['preco_compra'],$_POST['preco_venda'],$_POST['descricao'],$_POST['foto'],$_POST['codigo'],$_POST['gramatura'],$vkt_id);
	if($cadastra > 0){
		produto_has_fornecedor($cadastra,$_POST);
	}
}
?>