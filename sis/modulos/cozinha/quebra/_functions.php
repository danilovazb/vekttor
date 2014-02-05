<?
function altera_desperdicio($campos){
	print_r($campos);
}

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
	}
}
function importarFichas($dados){
	global $vkt_id;
	$fichas_importadas_q=mysql_query($x="
	SELECT * 
	FROM 
	cozinha_cardapio_dia_refeicao 
	WHERE 
		contrato_id='{$dados[outro_contrato_id]}' AND data >= '".dataBrToUsa($dados[filtro_inicio])."' AND data <= '".dataBrToUsa($dados[filtro_fim])."' AND vkt_id='$vkt_id' ");
		while($fichas_importadas=mysql_fetch_object($fichas_importadas_q)){
			mysql_query($oioi="INSERT INTO 
				cozinha_cardapio_dia_refeicao 
			SET 
				vkt_id='$vkt_id', 
				contrato_id='{$dados[contrato_id]}', ficha_tecnica_id='{$fichas_importadas->ficha_tecnica_id}', pessoas='{$fichas_importadas->pessoas}', data='{$fichas_importadas->data}', tipo_refeicao='{$fichas_importadas->tipo_refeicao}' ");
				
		}
}


?>