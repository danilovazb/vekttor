<?php
session_start();

function consulta_ultimo_saldo($almoxarifado_id,$produto_id){
	global $vkt_id;
	$estoque=mysql_fetch_object(mysql_query($trace="SELECT * FROM estoque_mov WHERE produto_id='$produto_id' AND almoxarifado_id='$almoxarifado_id' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));

	if($estoque->id>0){
		$qtd=$estoque->saldo;
	}else{
		$qtd=0;
	}
	return $qtd;
}

function movimenta_estoque($almoxarifado_id,$produto_id,$doc_id,$doc_tipo,$entrada,$saida,$unidade=NULL){
	global $vkt_id,$usuario_id;
	$saldo = consulta_ultimo_saldo($almoxarifado_id,$produto_id);
	
	if($saldo>=$saida){
		$novosaldo =$saldo+$entrada-$saida;
		$data = date('Y-m-d H:i:s');
		mysql_query($trace="INSERT INTO estoque_mov SET vkt_id='$vkt_id',usuario_id='$usuario_id',almoxarifado_id='$almoxarifado_id', produto_id='$produto_id', data_hora='".$data."', doc_id='$doc_id',doc_tipo='$doc_tipo', entrada='$entrada',saida='$saida', saldo='$novosaldo'");			
		return true;
	}else{
		return false;
	}
}

/*-------------*/

function insere_corretor($campos){
	global $login_id;
	
	$sql = ($t="INSERT INTO corretor SET nome = '{$campos['nome']}', imobiliaria_id = '$login_id' ");
	
		$result = mysql_query($sql);
		
				if($result){
				} else{
					mysql_error($result);	
				}
	
}

function altera_corretor($campos){
	
		$sql = ("UPDATE corretor SET nome = '{$campos['nome']}' WHERE id = '{$campos['id']}'");
		
			mysql_query($sql); 
	
}

function deletar_corretor($id){

	$sql = mysql_query(" DELETE FROM corretor WHERE id = '$id' ");	
}

function RealizaTransferenciaDestino($campos){
				global $vkt_id;
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
				$data = date('Y-m-d');
				
			mysql_query(" UPDATE estoque_transferencia SET data_fim = '$data', status   = '2' WHERE  id = '$transferencia_id' AND vkt_id = '$vkt_id' ");
			while($item = mysql_fetch_object($itens)){
									
				$qtd_und = $item->qtd_enviada * $item->conversao2;
				
				movimenta_estoque($transferencia->unidade_id_destino,$item->produto_id,$transferencia_id,'transferencia',$qtd_und,0);
						/*mysql_query($r=" UPDATE estoque_transferencia_item 
						SET qtd_recebida = '".$qtd[$i]."' WHERE produto_id = '".$produtoID[$i]."' AND transferencia_id = '".$transferencia."' AND vkt_id = '$vkt_id' ");*/
				
			}
				
				/*for($i=0;$i<sizeof($qtd);$i++){
						$qtd_und = $qtd[$i] * $conversao2[$i];
						movimenta_estoque($und_destino,$produtoID[$i],$transferencia,'transferencia',$qtd_und,0);
						mysql_query($r=" UPDATE estoque_transferencia_item 
						SET qtd_recebida = '".$qtd[$i]."' WHERE produto_id = '".$produtoID[$i]."' AND transferencia_id = '".$transferencia."' AND vkt_id = '$vkt_id' ");
				}*/
			/*echo "<script>location.href='?tela_id=195';</script>";*/		
}

?>