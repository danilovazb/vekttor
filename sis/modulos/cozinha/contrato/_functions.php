<? 

function cadastraContrato($id_cliente,$unidade_id,$valor,$dt_vencimento1,$dt_vencimento2,$pesagem,
		 $cafe_dia,$cafe_mes,$cafe_valor,$almoco_dia,$almoco_mes,$almoco_valor,
		 $lanche_dia,$lanche_mes,$lanche_valor,$janta_dia,$janta_mes,$janta_valor,$ceia_dia,$ceia_mes,
		$ceia_valor,$vkt_id,$data,$status){
	$query=mysql_query($t="INSERT INTO cozinha_contratos SET cliente_id='$id_cliente', unidade_id='$unidade_id', valor='".moedaBrToUsa($valor)."',
	data_vencimento1='$dt_vencimento1',data_vencimento2='$dt_vencimento2', pesagem='$pesagem', cafe_valor='$cafe_valor', cafe_dia='$cafe_dia',
	cafe_mes='$cafe_mes', almoco_valor='$almoco_valor', almoco_dia='$almoco_dia', almoco_mes='$almoco_mes',
	lanche_dia='$lanche_dia', lanche_mes='$lanche_mes', lanche_valor='$lanche_valor',
	janta_dia='$janta_dia',janta_mes='$janta_mes', janta_valor='$janta_valor',ceia_dia='$ceia_dia',ceia_mes='$ceia_mes', ceia_valor='".moedaBrToUsa($ceia_valor)."',
	vkt_id='$vkt_id', data='".dataBrToUsa($data)."', status='$status'");
	
}

function alteraContrato($cliente_id,$unidade_id,$valor,$dt_vencimento1,$dt_vencimento2,$pesagem,
		 $cafe_dia,$cafe_mes,$cafe_valor,$almoco_dia,$almoco_mes,$almoco_valor,
		 $lanche_dia,$lanche_mes,$lanche_valor,$janta_dia,$janta_mes,$janta_valor,$ceia_dia,$ceia_mes,
		$ceia_valor,$vkt_id,$data,$status,$id){
	$query=mysql_query("UPDATE cozinha_contratos SET cliente_id='$cliente_id', unidade_id='$unidade_id', valor='".moedaBrToUsa($valor)."',
	data_vencimento1='$dt_vencimento1',data_vencimento2='$dt_vencimento2', pesagem='$pesagem', cafe_valor='$cafe_valor', cafe_dia='$cafe_dia',
	cafe_mes='$cafe_mes', almoco_valor='$almoco_valor', almoco_dia='$almoco_dia', almoco_mes='$almoco_mes',
	lanche_dia='$lanche_dia', lanche_mes='$lanche_mes', lanche_valor='$lanche_valor',
	janta_dia='$janta_dia',janta_mes='$janta_mes', janta_valor='$janta_valor',ceia_dia='$ceia_dia',ceia_mes='$ceia_mes', ceia_valor='".moedaBrToUsa($ceia_valor)."',
	vkt_id='$vkt_id', data='".dataBrToUsa($data)."', status='$status' WHERE id='$id'") OR DIE(mysql_error());
}
function deletaContrato($id){
	$query=mysql_query("DELETE FROM cozinha_contratos WHERE id='$id'");
}

?>
