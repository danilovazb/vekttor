<?
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento

//$cpf_cnpj =  str_replace=

function checaEstoque($produto_id,$status_inventario,$almoxarifado_id=NULL,$inventario_id=NULL){
	global $vkt_id;
	if($status_inventario==1){
			$estoque=mysql_fetch_object(mysql_query($opa="
			SELECT * FROM estoque_inventario_item WHERE produto_id='$produto_id' AND inventario_id='$inventario_id'  ORDER BY id DESC LIMIT 1"));
		if($estoque->id>0){
			$qtd=$estoque->qtd_estoque;
		}else{
			$qtd=0;
		}
	}else{
		$estoque=mysql_fetch_object(mysql_query($trace="SELECT * FROM estoque_mov WHERE produto_id='$produto_id' AND almoxarifado_id='$almoxarifado_id' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));

		if($estoque->id>0){
			$qtd=$estoque->saldo;
		}else{
			$qtd=0;
		}
	}
	return $qtd;
}

$q=mysql_query("SELECT * FROM produto WHERE vkt_id ='$vkt_id' AND (nome  like '%$_GET[busca_auto_complete]%' )  LIMIT 15");
$i=0;
while($r= mysql_fetch_object($q)){
	$em_estoque=checaEstoque($r->id,0,$_GET['id_origem']);
	echo urlencode("$r->nome|$r->id|$em_estoque\n");
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado, Cadastre em Clinte ou Fornecedor|0|0\n");
}

?>