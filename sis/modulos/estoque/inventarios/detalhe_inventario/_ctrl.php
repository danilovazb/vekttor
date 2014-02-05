<?
if($_POST['inventario_id'])$id=$_POST['inventario_id'];
if($_GET['inventario_id'])$id=$_GET['inventario_id'];
if($_GET['almoxarifado_id'])$almoxarifado_id=$_GET['almoxarifado_id'];

if(!isset($_GET['inventario_id']) &&!isset($_POST['inventario_id'])){
	mysql_query("INSERT INTO estoque_inventario SET almoxarifado_id='{$_GET['almoxarifado_id']}', usuario_id='$usuario_id', data_criado=NOW(), vkt_id='$vkt_id'");
	$id=mysql_insert_id();
	
	$produtos_q=mysql_query("SELECT SQL_CACHE p.nome as nome,p.*, g.id as grupo_id, g.nome as grupo FROM produto as p, produto_grupo as g WHERE p.vkt_id='$vkt_id' AND p.produto_grupo_id=g.id  ORDER BY g.nome, p.nome ");
	
	while($produto=mysql_fetch_object($produtos_q)){
	
		mysql_query($a="
				INSERT INTO 
					estoque_inventario_item 
				SET inventario_id='$id', produto_id='{$produto->id}',qtd_estoque='".checaEstoque($produto->id,$inventario->status,$almoxarifado_id)."', vkt_id='$vkt_id',unidade='unidade_embalagem' ");
		//echo $a."<br>";
	}
	echo "<script>location.href='?tela_id=194&inventario_id=$id'</script>";
	exit();
}


//Cadastra Novo Usuario

if($_POST['action']=='Confirmar Quantidades'){
	$id=fechaInventario($_POST);
	salvaUsuarioHistorico("Formulário - Produto",'Cadastrou um Novo','produto',$id);
	echo "<script>location.href='?tela_id=42'</script>";
}


if($_GET['action']=='Cancelar'){
	//alert('')
	cancelaInventario($id);
	echo "<script>location.href='?tela_id=42'</script>";
}
//Pega informações
if($id>0){
	$inventario=mysql_fetch_object(mysql_query("SELECT *,date_format(data_criado,'%d/%m/%Y às %H:%i') as data_hora FROM estoque_inventario WHERE id='$id' AND vkt_id='$vkt_id' "));
	$almoxarifado=mysql_fetch_object(mysql_query("SELECT * FROM cozinha_unidades WHERE id='".$inventario->almoxarifado_id."' "));
}
?>