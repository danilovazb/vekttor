<?php

if($_GET['id'] > 0){
	
	$id = $_GET['id'];
	
	$aluguel = mysql_fetch_object(mysql_query($t="SELECT * FROM aluguel_locacao WHERE id='$id' AND vkt_id='$vkt_id'"));
	
	$qtd_dias_locacao = mysql_fetch_object(mysql_query("SELECT DATEDIFF('$aluguel->data_devolucao','$aluguel->data_locacao')as dias"));
	
	$itens_aluguel = mysql_query($t="SELECT 
										DISTINCT(item_equipamento_id) as id 
									FROM 
										aluguel_locacao_itens										  
									WHERE 
										locacao_id='$id' AND 
										vkt_id='$vkt_id'");
		
	$custos_aluguel = mysql_query($t="SELECT * FROM aluguel_custos WHERE locacao_id='$id' AND vkt_id='$vkt_id'");
	
}
?>