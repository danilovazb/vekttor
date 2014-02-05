<?php

function consulta_ultimo_saldo($almoxarifado_id,$produto_id){
	global $vkt_id;
	$estoque=mysql_fetch_object(mysql_query($t="SELECT * FROM estoque_mov WHERE produto_id='$produto_id' AND almoxarifado_id='$almoxarifado_id' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));

	if($estoque->id>0){
		$saldo_estoque=(double)$estoque->saldo;
	}else{
		$saldo_estoque=0;
	}
	return $saldo_estoque;
}

function movimenta_estoque($almoxarifado_id,$produto_id,$doc_id,$doc_tipo,$entrada,$saida,$unidade=NULL){
	global $vkt_id,$usuario_id;
	$saldo = consulta_ultimo_saldo($almoxarifado_id,$produto_id);
	
	//if(gettype($saldo)=='string')
	
	//echo gettype($saldo)." ".gettype($saida);
	

	$novosaldo = $saldo-$saida;
	//echo "($novosaldo)=($saldo)-($saida)";
	
	

		$data = date('Y-m-d H:i:s');
		mysql_query($trace="INSERT INTO estoque_mov SET vkt_id='$vkt_id',usuario_id='$usuario_id',almoxarifado_id='$almoxarifado_id', produto_id='$produto_id', data_hora='".$data."', doc_id='$doc_id',doc_tipo='$doc_tipo', entrada='$entrada',saida='$saida', saldo='$novosaldo'");		
	
		return true;
	//}else{
		//return false;
	//}
}

/*-------------------*/





function RealizaTransferenciaOrigem($campos){
				
				global $vkt_id;
				/*$qtd           = $campos['qtd_bd'];
				
				$und_origem    = $campos['id_origem'];
				$und_destino   = $campos['id_destino'];
				$produtoID     = $campos['produtoID'];
				$conversao2    = $campos['conversao2'];
				$saldo         = $campos['saldo_origem'];
				$und           = $campos['und'];
				$j = 0;*/
				$transferencia_id = $campos['transferencia_id'];
				//echo $transferencia_id;
				//deleta os itens que não foram marcados
				
				mysql_query($t="DELETE FROM estoque_transferencia_item WHERE transferencia_id='".$transferencia_id."'AND marcado='nao' AND vkt_id = '".$vkt_id."' ");
				//echo $t."<br>";
				mysql_query("UPDATE estoque_transferencia SET status = '1' WHERE id = '".$transferencia_id."' AND vkt_id = '".$vkt_id."' ");
				
				$transferencia = mysql_fetch_object(mysql_query("SELECT * FROM estoque_transferencia WHERE id='$transferencia_id'"));
				$itens = mysql_query("SELECT 
										* 
									  FROM 
									  	estoque_transferencia_item eti,
										produto p
									WHERE
										eti.vkt_id='$vkt_id' AND
										eti.produto_id=p.id AND
										eti.transferencia_id='$transferencia_id'");
				
				while($item = mysql_fetch_object($itens)){
					
					
					$qtd_und = $item->qtd_enviada * $item->conversao2;
					movimenta_estoque($transferencia->unidade_id_origem,$item->produto_id,$transferencia_id,'transferencia',0,$qtd_und); //unidade de origem tirei de la
				}
				
			echo "<script>location.href='?tela_id=517'</script>";
								
				
}


?>