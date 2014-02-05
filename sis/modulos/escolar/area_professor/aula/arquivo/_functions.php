<?php
	
	function insere_arquivo(){
	 	global $vkt_id;
	 	$extensao = getExtensao($_FILES['arquivo']['name']);
		
		if($extensao!='php'){
			$aula_id = $_POST['insere'];
				
			mysql_query($ql=" INSERT INTO escolar_upload
											SET
												aula_id = '$aula_id',
												vkt_id  = '$vkt_id',
												extensao = '$extensao',
												localizacao = 'escolar/area_professor/aula/arquivo/upload/',
												observacao = '".$_POST['observacao']."',
												data_envio = '".dataBrToUsa($_POST['data_envio'])."'
												");
			$id_aula = mysql_insert_id();
			$arquivo = $id_aula.'.'.$extensao;
			
			
			/*
			if($_FILES['arquivo']){
				echo "entrou no envio do arquivo";
				move_uploaded_file($_FILES['file']['tmp_name'],"modulos/escolar/area_professor/aula/arquivo/upload/$arquivo");
				echo "
				<script>
					top.chegouao100porcento();
				</script>
				";
				exit();
			}
			*/
			
			
						
			if(move_uploaded_file($_FILES['arquivo']['tmp_name'], "modulos/escolar/area_professor/aula/arquivo/upload/$arquivo")){
				
				echo "
					<script>
						top.location='?tela_id=286&aula=$aula_id';
					</script>
					";
				
				mysql_query(" UPDATE escolar_upload 
									SET
										arquivo = '".$id_aula.'.'.$extensao."'
									WHERE 
										id = '".$id_aula."'
							");
							exit();
				
				
			}
		} /*Fim de if*/
		
	} /* Fim da Funcao insere_arquivo */

?>