<?
if($_GET[contrato_id]>0){$contrato_id=$_GET[contrato_id];}
if($_POST[contrato_id]>0){$contrato_id=$_POST[contrato_id];}

if($_POST['salva_formulario_contrato_cliente']== '1'){
	//print_r($_POST);
	envair_email($_POST);
}

if($_POST[action]=='Salvar' && $contrato_id>0 && $_POST['actionCardapio']==1){
	adicionaFichas($_POST);
}

if($_POST[action]=='Salvar' && $_POST['actionCardapio']!=1){
	include('modulos/cozinha/ficha_tecnica/_functions.php');
	include('modulos/cozinha/ficha_tecnica/_ctrl.php');	
}

if($_POST[action]=='Importar' && $contrato_id>0){
	importarFichas($_POST);
}

if($_POST[action]=='Exportar'){
	exportarCardapio($_POST);
}

if($contrato_id>0){
	$contrato=mysql_fetch_object(mysql_query($p="SELECT * FROM cozinha_contratos WHERE vkt_id='$vkt_id' AND id='$contrato_id'"));
	$cliente=mysql_fetch_object(mysql_query($o="SELECT * FROM cliente_fornecedor WHERE id='{$contrato->cliente_id}' "));
}