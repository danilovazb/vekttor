<?
function criarTransferencia($dados){
	global $vkt_id;
	if(count($dados['produto_id'])>0){

		if(mysql_query("
		INSERT INTO estoque_transferencia 
		SET
			vkt_id='$vkt_id', 
			unidade_id_origem='{$dados[unidade_id_origem]}', unidade_id_destino='{$dados[unidade_id_destino]}', data_inicio='{$dados[necessidade_inicio]}', data_fim='{$dados[necessidade_fim]}', status='0'
			")){
				echo mysql_error();
				$transferencia_id=mysql_insert_id();
				
				for($i=0;$i<count($dados['produto_id']);$i++){
					$qtd_embalagem=moedaBrToUsa($dados['qtd_digitada'][$i]);
					mysql_query($a="INSERT INTO 
				estoque_transferencia_item SET 
				vkt_id='$vkt_id', transferencia_id='$transferencia_id', produto_id='{$dados['produto_id'][$i]}',
				qtd_enviada='$qtd_embalagem', marcado='sim' ");
					//echo $a."<br>";
					//echo mysql_error();
			}
            location("?tela_id=193&acao=edit&id=$transferencia_id&id_origem={$dados['unidade_id_origem']}&id_destino={$dados['unidade_id_destino']}");
		}
	}
	
}

function salvarNecessidade(){
}

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
		$estoque=mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_mov WHERE produto_id='$produto_id' AND almoxarifado_id='$almoxarifado_id' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));
		//echo $t;
		if($estoque->id>0){
			$qtd=$estoque->saldo;
		}else{
			$qtd=0;
		}
	}
	return $qtd;
}