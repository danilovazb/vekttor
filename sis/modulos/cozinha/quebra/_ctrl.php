<?

if($_GET[contrato_id]>0){$contrato_id=$_GET[contrato_id];}
if($_POST[contrato_id]>0){$contrato_id=$_POST[contrato_id];}

if($_POST[action]=='Salvar' && $contrato_id>0){
		
}

if($_GET[action]=='Importar' && $contrato_id>0){
	importarFichas($_GET);
}

if($contrato_id>0){
	$contrato=mysql_fetch_object(mysql_query($p="SELECT * FROM cozinha_contratos WHERE id='{$contrato_id}'"));
	$cliente=mysql_fetch_object(mysql_query($o="SELECT * FROM cliente_fornecedor WHERE id='{$contrato->cliente_id}' "));
}

if($_GET['acao'] == 'desperdicio'){
			altera_desperdicio($_POST);
}