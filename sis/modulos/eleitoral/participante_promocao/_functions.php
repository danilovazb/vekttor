<?
	//-------Funcoes Vereador-----------------------------
	function ManipulaParticipantePromocao($dados,$vkt_id){
		if($dados['id']>0){
			$inicio = "UPDATE";
			$fim   = "WHERE id=$dados[id]";
		}else{
			$inicio = "INSERT INTO";
			$fim   = "";
		}
		$verifica_existencia = mysql_fetch_object(mysql_query($t="SELECT * FROM eleitoral_participante_promocao WHERE eleitor_id='$dados[participante_id]' AND promocao_id='$dados[promocao_id]' AND vkt_id='$vkt_id'"));
		//echo $t."<br>";
		if($verifica_existencia->id<=0){	
			mysql_query($t="INSERT INTO eleitoral_participante_promocao SET vkt_id='$vkt_id', eleitor_id='$dados[participante_id]', promocao_id='$dados[promocao_id]'");	
			//echo $t."<br>";
		}
	}
	
	function ExcluiPromocao($id){
		$query = mysql_query($trace="DELETE FROM eleitoral_promocao WHERE id='$id'");
		//echo $trace;
	}
	
?>