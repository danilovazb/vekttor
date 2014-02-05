<?php
	
	function insere_arquivo(){
	 	global $vkt_id;
	 	$extensao = getExtensao($_FILES['arquivo']['name']);
		
		if($extensao!='php'){
			$aula_id = $_POST['aula_id'];
				
			mysql_query($ql=" INSERT INTO escolar_upload_online
											SET
												aula_online_id = '$aula_id',
												vkt_id  = '$vkt_id',
												extensao = '$extensao',
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
			
			
						
			if(move_uploaded_file($_FILES['arquivo']['tmp_name'], "modulos/escolar/aulas_online_cadastro/aulas_online_cadastradas/arquivos_aula_online/arquivos/$arquivo")){
				
				echo "
					<script>
						top.location='?tela_id=326&aula_id=$aula_id';
					</script>
					";
				
				mysql_query(" UPDATE escolar_upload_online 
									SET
										arquivo = '".$id_aula.'.'.$extensao."'
									WHERE 
										id = '".$id_aula."'
							");
							exit();
				
				
			}
		} /*Fim de if*/
		
	} /* Fim da Funcao insere_arquivo */
	function altera_arquivo($arquivo_id){
	 	global $vkt_id;
	 	$extensao = getExtensao($_FILES['arquivo']['name']);
		
		if($extensao!='php'){
			$aula_id = $_POST['aula_id'];
				
			mysql_query($ql=" UPDATE escolar_upload_online
											SET
												extensao = '$extensao',
												observacao = '".$_POST['observacao']."',
												data_envio = '".dataBrToUsa($_POST['data_envio'])."
											WHERE
												id='$arquivo_id'	
											'
												");
			//$id_aula = mysql_insert_id();
			
			$arquivo = $arquivo_id.'.'.$extensao;
			
			
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
			
			
						
			if(move_uploaded_file($_FILES['arquivo']['tmp_name'], "modulos/escolar/aulas_online_cadastro/aulas_online_cadastradas/arquivos_aula_online/arquivos/$arquivo")){
				
				echo "
					<script>
						top.location='?tela_id=325&modulo_id=$aula_id';
					</script>
					";
				
				mysql_query(" UPDATE escolar_upload_online 
									SET
										arquivo = '".$arquivo_id.'.'.$extensao."'
									WHERE 
										id = '".$arquivo_id."'
							");
							exit();
				
				
			}
		} /*Fim de if*/
		
	}

?>