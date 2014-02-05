<?php

if($_GET['id'] > 0){
	//Seleciona itens locados
	$equipamento_itens_locados = mysql_query($t="SELECT 
														* 
													  FROM 
													  	aluguel_equipamentos ae,
														aluguel_equipamentos_itens aei,
														aluguel_locacao al,
														aluguel_locacao_itens ali														 
													  WHERE
													  	ae.id=aei.equipamento_id AND
														al.id=ali.locacao_id AND
														aei.id=ali.item_equipamento_id AND 
													    ae.id='".$_GET['id']."' AND 
														ae.vkt_id='$vkt_id'");
	echo $t;
}

?>