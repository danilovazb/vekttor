<?
//------------------------------------------------------------------
if($_GET['id']){$id=$_GET['id'];}
if($_POST['id']){$id=$_POST['id'];}
//echo "Acao=".$_POST['acao'];
$fornecedor_id   =$_GET['fornecedor_id'];
$almoxarifado_id =$_GET['almoxarifado'];
$fornecedor      = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='".$fornecedor_id."'"));
$almoxarifado    = mysql_fetch_object(mysql_query("SELECT * FROM cozinha_unidades WHERE id='".$almoxarifado_id."'"));
$compra_q=mysql_query($t="SELECT * FROM estoque_compras WHERE id='{$_GET['compra_id']}' AND status !='Finalizado'");
$compra=mysql_fetch_object($compra_q);

if($_GET['totalcompra'] > 0){
	$total         = $_GET['totalcompra'];
	$fornecedor_id = $_GET['fornecedor_id'];
	$compra_id     = $_GET['compra_id'];
}
if($_POST['action'] == 'MandarFinanceiro'){
	if(!isset($_POST['enviar_boleto_financeiro'])){
		
		MandarFinanceiro($_POST);
		$fornecedor_id = $_POST['fornecedor_id'];
	}else{
		
		Finalizar($compra->id,$almoxarifado->id, $status='Finalizado');
	}
}
//if($_GET['Finalizar']){
	//Atualiza o status da compra para finalizado
	//$compra_q=mysql_query("SELECT * FROM estoque_compras WHERE id='{$_GET['compra_id']}' AND status !='Finalizado'");

?>