<?
if(isset($_GET['id'])){$id=$_GET['id'];}

if(isset($_POST['id'])){$id=$_POST['id'];}

if($_POST['action']=='Salvar'){
	if($id==0){
		cadastraContrato($_POST['cliente_id'],$_POST['unidade_id'],$_POST['valor'],$_POST['data_vencimento1'],$_POST['data_vencimento2'],
		$_POST['pesagem'],$_POST['cafe_dia'],$_POST['cafe_mes'],$_POST['cafe_valor'],$_POST['almoco_dia'],$_POST['almoco_mes'],
		$_POST['almoco_valor'],$_POST['lanche_dia'],$_POST['lanche_mes'],$_POST['lanche_valor'],$_POST['janta_dia'],$_POST['janta_mes'],
		$_POST['janta_valor'],$_POST['ceia_dia'],$_POST['ceia_mes'],
		$_POST['ceia_valor'],$vkt_id, $_POST['data'], $_POST['status'],$vkt_id);
	}
	if($id>0){
		//print_r($_POST);
		alteraContrato($_POST['cliente_id'],$_POST['unidade_id'],$_POST['valor'],$_POST['data_vencimento1'],$_POST['data_vencimento2'],
		$_POST['pesagem'],$_POST['cafe_dia'],$_POST['cafe_mes'],moedaBrToUsa($_POST['cafe_valor']),$_POST['almoco_dia'],$_POST['almoco_mes'],
		moedaBrToUsa($_POST['almoco_valor']),$_POST['lanche_dia'],$_POST['lanche_mes'],moedaBrToUsa($_POST['lanche_valor']),$_POST['janta_dia'],$_POST['janta_mes'],
		moedaBrToUsa($_POST['janta_valor']),$_POST['ceia_dia'],$_POST['ceia_mes'],
		$_POST['ceia_valor'],$vkt_id, $_POST['data'],$_POST['status'],$id);
	}
}
if($_POST['action']=='Excluir'&&$id>0){
	deletaContrato($id);
}
if($id>0){
	$contrato=mysql_fetch_object(mysql_query("SELECT * FROM cozinha_contratos WHERE id='$id'"));
	$cliente=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='{$contrato->cliente_id}'"));
}
?>