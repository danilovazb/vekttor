<?

function lista_movimentos_nas_funcioes($pagar_ou_pagar,$data_inicio,$data_fim,$filtro){
	
	$q  = mq($t="
		SELECT 
			nome_plano.nome  as nome,nome_plano.*
		FROM 
			financeiro_plano_has_movimento as p, financeiro_centro_custo as nome_plano ,financeiro_movimento as m
		WHERE
			p.plano_id=nome_plano.id
		AND
			p.movimento_id=m.id
		AND
			m.cliente_id='".$_SESSION[usuario]->cliente_vekttor_id."' 
		AND 
			m.tipo='$pagar_ou_pagar'  
		AND 
			m.`status`='0'
		AND
			m.extorno='0'
		AND
			m.transferencia='0'
		AND 
			m.data_vencimento  between '$data_inicio' AND '$data_fim'
		GROUP BY 
			p.plano_id
		");
	//echo $t;
	while($r=mf($q)){
		$re[]= $r;
	}
	return $re;
}


function retorna_mes_ano_adicionado($data_inicio,$i){
	return mysql_result(mysql_query($trace="SELECT date_format(date_add('$data_inicio', INTERVAL $i MONTH),'%m/%Y')"),0,0);
}

function retorna_data_adicionada($data_inicio,$i){
	return mysql_result(mysql_query($trace="SELECT date_add('$data_inicio', INTERVAL $i MONTH)"),0,0);
}


function movimento_no_mes($pagar_ou_receber,$plano_ou_centro,$id,$data_atual){
	if($plano_ou_centro=='plano'){
		$sql_plano_ou_centro = 'financeiro_plano_has_movimento';
	}else{
		$sql_plano_ou_centro = 'financeiro_centro_has_movimento';
	}
	
	$q  = mq($t="
		SELECT 
			sum(p.valor)
		FROM 
			$sql_plano_ou_centro as p ,financeiro_movimento as m
		WHERE
			p.plano_id='$id'
		AND
			p.movimento_id=m.id
		AND
			m.cliente_id='".$_SESSION[usuario]->cliente_vekttor_id."' 
		AND 
			m.tipo='$pagar_ou_receber'  
		AND 
			m.`status`='0'
		AND
			m.extorno='0'
		AND
			m.transferencia='0'
		AND 
			m.data_vencimento  between '$data_atual' AND LAST_DAY('$data_atual')
		");
		///	echo "<pre>".$t."</pre><br><br>";
	return @mysql_result($q,0,0);
}

function retorna_tip($pagar_ou_receber,$plano_ou_centro,$id,$data_atual){
	if($plano_ou_centro=='plano'){
		$sql_plano_ou_centro = 'financeiro_plano_has_movimento';
	}else{
		$sql_plano_ou_centro = 'financeiro_centro_has_movimento';
	}
	
	$q  = mq($t="
		SELECT 
			m.*,p.valor,date_format(data_vencimento,'%d/%m') as d
		FROM 
			$sql_plano_ou_centro as p ,financeiro_movimento as m
		WHERE
			p.plano_id='$id'
		AND
			p.movimento_id=m.id
		AND
			m.cliente_id='".$_SESSION[usuario]->cliente_vekttor_id."' 
		AND 
			m.tipo='$pagar_ou_receber'  
		AND 
			m.`status`='0'
		AND
			m.extorno='0'
		AND
			m.transferencia='0'
		AND 
			m.data_vencimento  between '$data_atual' AND LAST_DAY('$data_atual')
		");
		//echo $t;
		while($r=mf($q)){
			$cliente = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$r->internauta_id'"));
			$tip .= "$r->d ". str_pad(n($r->valor), 10, ' ', STR_PAD_LEFT)." $r->descricao $cliente->razao_social\n";
		}
		///	echo "<pre>".$t."</pre><br><br>";
		/*
		white-space: pre-wrap;
		27/01    1350,00 Compra de infocentro
		
		
		*/
	return $tip;
}


function linha_diferente($total){
	
	if($total%2){
		return 'class="al"';
	}else{
		return '';
	}
}
function calcula_saldo_incial(){
	global $vkt_id;
	$vlr = @mysql_result(mysql_query("
	SELECT 
	sum(m.saldo)
	FROM 
		financeiro_contas as c,
			financeiro_movimento as m
	WHERE 
		c.cliente_vekttor_id='$vkt_id'
			AND
			c.id=m.conta_id
			AND 
			m.id= (SELECT id FROM financeiro_movimento WHERE conta_id=c.id ORDER BY data_movimento DESC limit 1)	
		"),0,0);
		
		return @$vlr;

}

?>