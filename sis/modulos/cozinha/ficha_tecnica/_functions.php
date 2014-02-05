<?

function adicionaFicha($valores,$vkt_id){
	if(isset($valores['exibir_cliente'])){
		$exibir_cliente='1';
	}else{
		$exibir_cliente='0';
	}
	$insere_ficha= mysql_query("INSERT INTO cozinha_fichas_tecnicas SET
	nome='{$valores['nome']}',
	nome_cliente='{$valores['nome_cliente']}',
	peso='".moedaBrToUsa($valores['peso'])."',
	grupo_cardapio_id='{$valores['cardapio_id']}',
	refeicao='".@implode(',',$valores['refeicao'])."',
	percapta_leve='".qtdBrToUsa($valores['percapta_leve'])."',
	percapta_medio='".qtdBrToUsa($valores['percapta_medio'])."',
	percapta_pesado='".qtdBrToUsa($valores['percapta_pesado'])."',
	percapta_extra='".qtdBrToUsa($valores['percapta_extra'])."',
	modo_preparo='{$valores['modo_preparo']}',
	foto_src='{$valores['foto_src']}',
	exibir_cliente='$exibir_cliente',
	vkt_id='$vkt_id'
	");
	$ultimo_id=mysql_insert_id();
	
	for($i=0;$i<count($_POST['produto_id']);$i++){
		if($_POST['produto_id'][$i]!=''&&$_POST['produto']!=''){
			$query = mysql_query($trace="INSERT INTO cozinha_ficha_has_produto SET ficha_id='$ultimo_id', produto_id='{$_POST['produto_id'][$i]}', qtd='".qtdBrToUsa($_POST['produto_qtd'][$i])."', obs='{$_POST[obs][$i]}', grupo='{$_POST[grupo][$i]}' ");
			//echo $trace;
		}
		
		
	}
	if(strlen($_FILES['foto']['name'])>3){
		ficha_envia_arquivo($ultimo_id);
	}
	alert('Salvo Com Sucesso!');
}
function alteraFicha($id,$valores){
	if(isset($valores['exibir_cliente'])){
		$exibir_cliente='1';
	}else{
		$exibir_cliente='0';
	}
	$altera_ficha= mysql_query($t="UPDATE cozinha_fichas_tecnicas SET
	nome='{$valores['nome']}',
	nome_cliente='{$valores['nome_cliente']}',
	peso='".qtdBrToUsa($valores['peso'])."',
	grupo_cardapio_id='{$valores['cardapio_id']}',
	refeicao='".@implode(',',$valores['refeicao'])."',
	percapta_leve='".qtdBrToUsa($valores['percapta_leve'])."',
	percapta_medio='".qtdBrToUsa($valores['percapta_medio'])."',
	percapta_pesado='".qtdBrToUsa($valores['percapta_pesado'])."',
	percapta_extra='".qtdBrToUsa($valores['percapta_extra'])."',
	modo_preparo='{$valores['modo_preparo']}',
	foto_src='{$valores['foto_src']}',
	exibir_cliente='$exibir_cliente'
	WHERE id='$id'
	");
	//echo $t."<br>";
	/* deleta produtos antigos */
	$deleta_antigo=mysql_query("DELETE FROM cozinha_ficha_has_produto WHERE ficha_id='$id'");
	
	/* adiciona novos*/
	for($i=0;$i<count($_POST['produto_id']);$i++){
		if($_POST['produto_id'][$i]!=''){
			$query = mysql_query($trace="INSERT INTO cozinha_ficha_has_produto SET ficha_id='$id', produto_id='{$_POST['produto_id'][$i]}', qtd='".qtdBrToUsa($_POST['produto_qtd'][$i])."', obs='{$_POST[obs][$i]}', grupo='{$_POST[grupo][$i]}' ");
		}

		
	}
	if(strlen($_FILES['foto']['name'])>3){
		ficha_envia_arquivo($id);
	}
	
	alert('Salvo Com Sucesso!');
}

function deletaFicha($id,$status){
	/*financeiro_remove_arquivos($id);
	mysql_query($d="DELETE FROM cozinha_fichas_tecnicas WHERE id='$id'");
	mysql_query("DELETE FROM cozinha_ficha_has_produto WHERE ficha_id='$id'");
	*/
	global $vkt_id;
	mysql_query($d="UPDATE cozinha_fichas_tecnicas SET status='$status' WHERE id='$id' AND vkt_id='$vkt_id'");
	//echo $d;
}



function ficha_envia_arquivo($ficha_id){
	
	$filis_autorizados = array('jpg','gif','png','pdf');
	
	$infomovimento = mysql_fetch_object(mysql_query("SELECT * FROM cozinha_fichas_tecnicas WHERE id='$ficha_id'"));
	
	if(strlen($_FILES['foto']['name'])>4){
	  $pasta 	= 'modulos/cozinha/ficha_tecnica/imagens_produtos/';
	  $extensao = strtolower(substr($_FILES['foto']['name'],-3));
	  $arquivo 	= $pasta.$ficha_id.'.'.$extensao;
	  $arquivodel= $pasta.$ficha_id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['foto'][tmp_name],$arquivo)){
			  mysql_query($f="UPDATE cozinha_fichas_tecnicas SET foto_src='$arquivo' WHERE id='$ficha_id'");
			  //echo $f;
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	
}

function financeiro_remove_arquivos($ficha_id){
	$arquivo=mysql_fetch_object(mysql_query("SELECT foto_src FROM cozinha_fichas_tecnicas WHERE id ='$ficha_id' "));
	@unlink($arquivo->foto_src);
  	//mysql_query("UPDATE cozinha_fichas_tecnicas SET  foto_src='' WHERE id='$ficha_id' ");

}
?>