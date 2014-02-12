<?
function calculo_dia($data_ini,$dias_incremento){
	
	return mysql_result(mq("SELECT DATE_ADD('$data_ini', INTERVAL $dias_incremento day)"),0,0);
}

function Inserir($dados){
		$sql = array();
		$item_ids=array_keys($dados['painel_insercao']);
		$item_ids=array_unique($item_ids);
		foreach($dados['painel_insercao'] as $id=>$painel_insercao){
			mysql_query("DELETE FROM paineis_consumo_hora WHERE painel_orcamento_item_id='$id'");
			foreach($dados['datas'] as $indice=>$data){
				//$sql[]="INSERT INTO paineis_consumo_hora SET segundos='{$dados['segundos_vt']}', insercoes='{$painel_insercao[$indice]}', data='".dataBrToUsa($data)."', painel_orcamento_item_id='$id' 
				if($painel_insercao[$indice]!=''){
					mysql_query("INSERT INTO paineis_consumo_hora SET segundos='{$dados['segundos_vt']}', 
					insercoes='{$painel_insercao[$indice]}', data='".dataBrToUsa($data)."', painel_orcamento_item_id='$id', painel_orcamento_tipo_veiculacao_id='{$dados[tipo_midia][$id]}' ");
				}
			
			}
			
		}
	$json["selecionados"] = $item_ids;
	echo json_encode($json);
}