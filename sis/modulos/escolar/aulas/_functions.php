<?php
	function AlteraStatus($campos){
		$exibe = $campos['exibe'];
			if($exibe == 2)
				$table = "escolar_avaliacao";
			else
				$table = "escolar_aula";
				
		$sql = " UPDATE $table SET status = '".$campos['status']."' WHERE id = '".$campos['id']."'";
		//echo $sql;
		mysql_query($sql);
	}
?>