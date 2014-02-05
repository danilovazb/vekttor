<?php
	include("../../../../../_config.php");
	include("../../../../../_functions_base.php");
			$acao = $_GET['acao'];
			
			
			if($acao == 'excluir'){
				global $vkt_id;
					$id = $_POST['id'];
					remove_imgem($id);
			} /* Fim de if*/
			
			function remove_imgem($id){
				global $tabela,$vkt_id;
				$info = mf(mq("SELECT * FROM escolar2_upload WHERE id='$id' AND vkt_id='$vkt_id'"));
					$extensao = $info->extensao;
					echo $id.".$extensao"; 
					if($info->id>0){
						unlink("../upload/escolar2/".$id.".$extensao");
						mysql_query(" DELETE FROM escolar2_upload WHERE id = '$id' AND vkt_id  = '$vkt_id' ");
					}	
	
			} /* Fim da funcao */
			
?>