<?php
	function consultaMovimentacoes($dados){
		include("../../../../_config.php");
		include("../../../../_functions_base.php");
		
		$forma_pagamento = $dados['forma_pagamento'];
		$tipo            = $dados['tipo'];
		$conta_id        = $dados['conta'];
		$dta_inicio      = DataBrToUsa($dados['dta_inicio']);
		$dta_fim         = DataBrToUsa($dados['dta_fim']);
		$movimentacoes = mysql_query($t="
		SELECT * FROM financeiro_movimento WHERE 1 AND ((data_movimento BETWEEN '$dta_inicio' AND '$dta_fim') OR (data_info_movimento BETWEEN '$dta_inicio' AND '$dta_fim')) AND cliente_id = '$cliente_id' AND status = '1' 			AND tipo='$tipo' AND extorno!='1' AND forma_pagamento='$forma_pagamento'  
		");
		
		$retorno = "
		<table width='100%'>
		<thead>
		<tr>
			<td width='50'>Data</td>
			<td width='180'>Descrição</td>
			<td width='40'>Valor</td>
		</tr>
		<thead>
		<tbody>
		";
		$total_movimentacao=0;
		while($movimentacao = mysql_fetch_object($movimentacoes )){
			$total_movimentacao += $movimentacao->valor_cadastro;
			$retorno.="
			<tr>
				<td>".DataUsaToBr(substr($movimentacao->data_registro,0,10))."</td>
				<td>$movimentacao->descricao</td>
				<td>".MoedaUsaToBr($movimentacao->valor_cadastro)."</td>
			</tr>
			";
			
		}
	
		$retorno .="<tbody>
		<thead>
			<tr>
				<td width='50'>&nbsp;</td>
				<td width='180' align='right'>Total</td>
				<td width='40'>".moedaUsaToBr($total_movimentacao)."</td>
			</tr>
		<thead>
		</table>";
		return utf8_encode($retorno);
	}
?>