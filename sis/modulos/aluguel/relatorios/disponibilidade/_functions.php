<?php
function manipula_equipamentos($dados,$vkt_id){
	
	if($dados[id]>0){
		$inicio="UPDATE";
		$fim="WHERE id=".$dados['id']." AND vkt_id='$vkt_id'";
	}else{
		$inicio="INSERT INTO";
		$fim="";
	}
	$sql=mysql_query($t="$inicio aluguel_equipamentos SET 
			vkt_id='$vkt_id',
			descricao='{$dados[descricao]}',
			modelo='{$dados[modelo]}',
			fabricante='{$dados[fabricante]}',
			data_cadastro='".DataBrToUsa($dados[data_cadastro])."',
			vlr_aluguel='".MoedaBrToUsa($dados[vlr_aluguel])."',
			periodo='{$dados[periodo]}'
			$fim");
	//echo $t;
	
	if($dados['id']>0){
		$equipamento_id = $dados['id'];
	}else{
		$equipamento_id = mysql_insert_id();
	}
	
	manipulaItens($dados,$vkt_id,$equipamento_id);
}

function excluir_equipamentos($dados,$vkt_id){
	//verifica se há itens locados
	//mysql_query($t="DELETE FROM aluguel_equipamentos WHERE id='$dados[id]' AND vkt_id='$vkt_id'");
	//echo $t;
	//mysql_query("DELETE FROM aluguel_equipamentos_itens WHERE equipamento_id='$dados[id]' AND vkt_id='$vkt_id'");
	//echo $sql;
}

function manipulaItens($dados,$vkt_id,$equipamento_id){
	//laço para cadastrar itens
	
	if(!empty($dados[item_q])){
		foreach($dados[item_q] as $item){
			if($item==''){
				$item='NI';
			}
			$sql=mysql_query($t="INSERT INTO aluguel_equipamentos_itens SET
				vkt_id='$vkt_id',
				equipamento_id='$equipamento_id',
				numero_serie='$item',
				status='1'
				");
				//echo $t;
		}//foreach
		
	}else{
			for($i=0;$i<$dados[qtd_itens];$i++){
				$sql=mysql_query($t="INSERT INTO aluguel_equipamentos_itens SET
				vkt_id='$vkt_id',
				equipamento_id='$equipamento_id',
				numero_serie='NI',
				status='1'
				");
				
			}			
		}
}
?>