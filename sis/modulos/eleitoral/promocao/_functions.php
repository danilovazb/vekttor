<?
	//-------Funcoes Vereador-----------------------------
	function ManipulaPromocao($dados,$vkt_id){
		if($dados['id']>0){
			$inicio = "UPDATE";
			$fim   = "WHERE id=$dados[id]";
		}else{
			$inicio = "INSERT INTO";
			$fim   = "";
		}
		$query = mysql_query($trace="$inicio eleitoral_promocao SET descricao='$dados[nome]',vkt_id='$vkt_id',obs='$dados[obs]' $fim");
		//echo $trace;
	}
	
	function ExcluiPromocao($id){
		$query = mysql_query($trace="DELETE FROM eleitoral_promocao WHERE id='$id'");
		//echo $trace;
	}
	
?>