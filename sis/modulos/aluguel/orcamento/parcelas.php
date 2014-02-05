<?php
	include("../../../_config.php");
	// funções base do sistema
	include("../../../_functions_base.php");
	
	$numparcelas = $_POST['numparcelas'];
	$valor_total = moedaBrToUsa($_POST['valor_total']);
	$locacao     = $_POST['id'];
	
	$vlr_parcela = $valor_total/$numparcelas;
	
	$parcelas = mysql_query("SELECT * FROM aluguel_pagamento_parcela WHERE locacao_id='$locacao'");
	
	$dados ="
	<div style='clear:both'></div>
		<label>Informa&ccedil;&otilde;es da parcela
	</label>
	<div style='clear:both'></div>
	";  
	$data = date("Y-m-d");
	$c=0;
	while($parcela=mysql_fetch_object($parcelas)){
		if($c<$numparcelas){
		
		$dados.="
			<div style='clear:both'></div>
			<label style='width:150px;'>
				Descri&ccedil;&atilde;o da Parcela
				<input type='text' name='descricao_parcela[]' class='descricao_parcela' value='$parcela->descricao_parcela'>                
			</label>		
			
			<label style='width:100px;'>
				Data Vencimento
				<input type='text' name='data_vencimento_parcela[]' class='data_vencimento_parcela' size='9' value='".DataUsaToBr($parcela->data_vencimento_parcela)."'>
			</label>
			<label style='width:100px;'>
				Valor Parcela
				<input type='text' name='text_valor_parcela[]' class='text_valor_parcela' size='8' value='".MoedaUsaToBr($vlr_parcela)."' disabled>
				<input type='hidden' name='valor_parcela[]' class='valor_parcela' size='8' value='".MoedaUsaToBr($vlr_parcela)."'>
			</label>
			<div style='clear:both'></div>";
			$c++;
		}
	}
	
	for($i=$c;$i<$numparcelas;$i++){
		
		$num_parcela = $i+1;
		$parcela = "Parcela $num_parcela";		
		if($i>0){
			$data = mysql_fetch_object(mysql_query($t="SELECT DATE_ADD('".$data."',INTERVAL 30 DAY) as data")); 
			$data = $data->data;
			//echo $t; 
		}
		
		$dados.="
			<label style='width:150px;'>
				Descri&ccedil;&atilde;o da Parcela
				<input type='text' name='descricao_parcela[]' class='descricao_parcela' value='$parcela'>
			</label>
					
			<label style='width:100px;'>
				Data Vencimento
				<input type='text' name='data_vencimento_parcela[]' class='data_vencimento_parcela' size='9' value='".DataUsaToBr($data)."'>
			</label>
			<label style='width:100px;'>
				Valor Parcela
				<input type='text' name='text_valor_parcela[]' class='text_valor_parcela' size='8' value='".MoedaUsaToBr($vlr_parcela)."' disabled>
				<input type='hidden' name='valor_parcela[]' class='valor_parcela' size='8' value='".MoedaUsaToBr($vlr_parcela)."'>
			</label>
			<div style='clear:both'></div>";
	}
	
	echo $dados;
?>