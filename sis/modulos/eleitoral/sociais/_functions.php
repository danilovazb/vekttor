<?
	//-------Funcoes Vereador-----------------------------
	function CadastraSociais($nome,$vkt_id){
		$query = mysql_query($trace="INSERT INTO eleitoral_grupos_sociais SET nome='$nome',vkt_id='$vkt_id'");
		//echo $trace;
	}
	
	function AlteraSociais($nome,$id){
		$query = mysql_query($trace="UPDATE eleitoral_grupos_sociais SET nome='$nome' WHERE id='$id'");
		//echo $trace."<br>";
	}
	function ExcluiSociais($id){
		$query = mysql_query($trace="DELETE FROM eleitoral_grupos_sociais WHERE id='$id'");
		//echo $trace;
	}
	
?>