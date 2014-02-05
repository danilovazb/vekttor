<?php

if($_POST['action']== 'Salvar'){
	manipulaFerias($_POST,$vkt_id);
}

if($_GET['deleta_ferias']>0){
	deleteFerias($_GET);
	//header("Location:modulos/rh/ferias/form.php?id=".$_GET[id]."&data_admissao=".$_GET[data_admissao]);
	echo "<script>location='form.php?id=".$_GET['id']."&data_admissao=".$_GET[data_admissao]."'</script>";
	exit();
}

if($_GET['id'] > 0){
	
	$id = $_GET['id'];
	
	$cargo_salario = mysql_fetch_object(mysql_query("SELECT * FROM cargo_salario WHERE id='$id'"));
}

if($_GET['empresaid']>0){
	$empresa = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$_GET['empresaid']."'"));
}

if($id>0){
	
	
	$registro = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$id' AND vkt_id='$vkt_id'"));
	$empresa = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='".$registro->empresa_id."'"));
	$ultimo_salario = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_alteracao_salario WHERE vkt_id='$vkt_id' AND funcionario_id='".$registro->id."' ORDER BY data DESC LIMIT 1"));
	
	//calcula a quantidade de férias total do funcionario
	$ferias_tiradas = mysql_query($t="SELECT * FROM rh_ferias WHERE vkt_id='$vkt_id' AND funcionario_id='".$registro->id."' ORDER BY id");
	
		
	//verifica se o mesmo tirou férias este ano
	$tirou_ferias = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_ferias WHERE funcionario_id='$registro->id' AND YEAR(data_inicio)=".date('Y')));
	
	if($ultimo_salario->id<1){
		$ultimo_salario = $registro->salario;
	}else{
		$ultimo_salario = $ultimo_salario->salario;
	}

}

?>