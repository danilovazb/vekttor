<?
function adicionaFichas($dados){
	global $vkt_id;
	//alert(count($dados[ficha_id]));
	mysql_query("DELETE FROM cozinha_cardapio_dia_refeicao WHERE contrato_id='{$dados[contrato_id]}' AND data='{$dados[data]}' AND tipo_refeicao='{$dados[refeicao]}' ");
	
	for($i=0;$i<count($dados['ficha_id']);$i++){
		if($dados['ficha_id'][$i]>0){
			mysql_query($t=" 
			INSERT INTO 
				cozinha_cardapio_dia_refeicao 
			SET vkt_id='$vkt_id', contrato_id='{$dados[contrato_id]}', ficha_tecnica_id='{$dados[ficha_id][$i]}', pessoas='{$dados[pessoas][$i]}', data='{$dados[data]}', tipo_refeicao='{$dados[refeicao]}'");
		}
		//echo $t."<br>";
	}
}
function importarFichas($dados){
	global $vkt_id;
	
	$refeicoes = array("cafe", "almoco", "lanche", "janta"); 
	
	$fichas_importadas_q=mysql_query($x="
	SELECT * FROM cozinha_cardapio_dia_refeicao 
		WHERE contrato_id = '{$dados[outro_contrato_id]}' 
		AND data >= '".dataBrToUsa($dados["filtro_inicio"])."' 
		AND data <= '".dataBrToUsa($dados["filtro_fim"])."' 
		AND vkt_id = '$vkt_id' ");
		
	while($fichas_importadas=mysql_fetch_object($fichas_importadas_q)){
		  $verifica=mysql_query("SELECT * FROM cozinha_cardapio_dia_refeicao 
		  	WHERE vkt_id = '$vkt_id' 
			AND contrato_id = '{$dados[contrato_id]}' 
			AND ficha_tecnica_id = '{$fichas_importadas->ficha_tecnica_id}' 
			AND data = '{$fichas_importadas->data}' 
			AND tipo_refeicao='{$fichas_importadas->tipo_refeicao}' ");
			 
		$contrato = mysql_fetch_array(mysql_query(" SELECT * FROM cozinha_contratos WHERE id = '{$dados[contrato_id]}' ")); //add por jaime
		
		if(!@mysql_num_rows($verifica)>0){
			
			$tipo = $fichas_importadas->tipo_refeicao;
			
			if( in_array($tipo, $refeicoes) and $contrato[$tipo."_dia"] > 0){
				
				$sql_export = ("INSERT INTO cozinha_cardapio_dia_refeicao SET 
				vkt_id           = '$vkt_id', 
				contrato_id      = '{$dados[contrato_id]}', 
				ficha_tecnica_id = '{$fichas_importadas->ficha_tecnica_id}', 
				pessoas          = '".$contrato[$tipo."_dia"]."',
				data             = '{$fichas_importadas->data}', 
				tipo_refeicao    = '{$tipo}' ");
				mysql_query($sql_export);
				
			}
			$cadastrou=1;		
		 }
				
	}
	
	if(!$cadastrou){
		alert("Dados Já Importados Anteriormente!");
	}else{
		alert("Dados Importados Com Sucesso!");
	}
		
		//filtro_inicio=20%2F05%2F2013&filtro_fim=26%2F05%2F2013
	if($dados[filtro_inicio]){
	 	$add = "&filtro_inicio={$dados[filtro_inicio]}&filtro_fim={$dados[filtro_fim]}";	
	}	
		
	/*echo "<script> location='?tela_id=101&contrato_id={$dados[contrato_id]}$add'</script>";
	exit();*/
}
function envair_email($dados){
	global $vkt_id;
	$contrato_id = $dados['contrato_id'];
	$de      = $dados['de'];
	$para    = $dados['para'];	
	$assunto = $dados['assunto'];
	$mensagem= $dados['texto'];
	//$mensagem= "TESTE DE ALTERAÇÃO DE MENSAGEM";
	//alert($mensagem);
	$mensagem.= "<br><br><a href='http://vkt.srv.br/~nv/cardapio_palatare.php?vkt_id=".base64_encode($vkt_id)."&contrato_id=".base64_encode($contrato_id)."&filtro_inicio=".base64_encode($dados[filtro_inicio])."&filtro_fim=".base64_encode($dados[filtro_fim])."'>
	Clique aqui para ver o cardápio</a>"; 
	$headers = 'MIME-Version: 1.0' . "\r\n".
	'Content-type: text/html; charset=iso-8859-1' . "\r\n".
	'From: '.trim($de)."\r\n" .
    'Return-Path: '.trim($de). ">\r\n" .
    'Reply-To: '.trim($de).">\r\n" .
    'X-Mailer: PHP/' . phpversion();
	$sql="INSERT INTO cozinha_cardapio_email SET vkt_id='$vkt_id', de='$de', para='$para', assunto='$assunto', mensagem='$mensagem', contrato_id='$contrato_id', data_envio=NOW()";
	if(mail($para,$assunto,$mensagem,$headers)){
		//alert("oi".$mensagem);
		alert('Email Enviado Com Sucesso');
		$sql.=",status='1'";
	}else{
		alert('Email Não Pode ser enviado');
		$sql.=",status='0'";
	}
	mysql_query($sql);
	if($dados[filtro_inicio]){
	 $add = "&filtro_inicio=".DataUsaToBr($dados[filtro_inicio])."&filtro_fim=".DataUsaToBr($dados[filtro_fim]);	
	}
	echo $mensagem;
	
	echo "<script>location='?tela_id=101&contrato_id={$dados[contrato_id]}$add'</script>";
	exit();
	//echo $t."<br>";
}
function exportarCardapio($dados){
	
	global $vkt_id;
	
	$fichas="
				SELECT c.*
				FROM cozinha_cardapio_dia_refeicao as c, cozinha_fichas_tecnicas as f, cozinha_cardapios_grupos g 
				WHERE 
				contrato_id='$dados[contrato_id]' 
				AND f.grupo_cardapio_id=g.id
				AND f.exibir_cliente='1'
				AND data='".DataBrToUsa($dados[data_selecionada])."' 
				AND c.vkt_id='$vkt_id'
				AND f.id=c.ficha_tecnica_id
				AND tipo_refeicao='$dados[tipo_refeicao]'
				ORDER BY g.nome,f.nome ASC";
	
		
	foreach($dados['data_exportacao'] as $data_exportacao){
		$fichas_q = mysql_query($fichas);
		while($ficha=mysql_fetch_array($fichas_q)){
			
			mysql_query($t="INSERT INTO cozinha_cardapio_dia_refeicao SET vkt_id='$vkt_id', contrato_id='$dados[contrato_id]', ficha_tecnica_id='$ficha[ficha_tecnica_id]', pessoas='$ficha[pessoas]',
			tipo_refeicao='$dados[tipo_refeicao]', data='$data_exportacao',obs='$ficha[obs]',desperdicio='$ficha[obs]'");
			//echo $t."<br>".mysql_error();
		}
					
	}
}
?>