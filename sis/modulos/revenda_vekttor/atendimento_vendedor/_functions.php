	<?php

//Funções 

//Cadastra contato
function cadastrai($campos){
				global $vkt_id;
				if($campos['tipo_cadastro'] == 'Jurídico'){
						 return CadJuridico($campos);
				} else{
						return CadFisico($campos);
				}
				
	
}

function CadFisico($campos){
				global $vkt_id;
$insert = "
					INSERT INTO  revenda_contato SET 
  					cliente_vekttor_id 			= '$vkt_id',
  					revenda_franquia_id			= '$vkt_id',
  					vendedor_id					= '$campos[vendedor_id]',
  					vendedor_cliente_vekttor_id = '',
  					razao_social  				= '$campos[f_nome_contato]',
					nome_fantasia  				= '$campos[f_nome_contato]',
					nome_contato  				= '$campos[f_nome_contato]',
					ramo_atividade	 			= '$campos[f_ramo_atividade]',
					nascimento	 				= '',
					cnpj_cpf 					= '$campos[f_cnpj_cpf]',
					rg 							= '$campos[f_rg]',
					local_emissao 				= '',
					suframa 					= '',
					inscricao_municipal 		= '$campos[f_inscricao_municipal]',
					inscricao_estadual 			= '$campos[f_inscricao_estadual]',
					email 						= '$campos[f_email]',
					telefone1 					= '$campos[f_telefone1]',
					telefone2 					= '$campos[f_telefone2]',
					fax 						= '$campos[f_fax]',
					cep 						= '$campos[f_cep]',
					endereco 					= '$campos[f_endereco]',
					bairro 						= '$campos[f_bairro]',
					cidade 						= '$campos[f_cidade]',
					estado 						= '$campos[f_estado]',
					limite 						= '$campos[f_limite]',
					tipo 					    = '',
					tipo_cadastro 			    = '$campos[tipo_cadastro]' ,
					estado_civil 			    = '$campos[f_estado_civil]',
					conjugue_nome 				= '$campos[f_conjugue_nome]',
					conjugue_ramo_atividade 	= '$campos[f_conjugue_ramo_atividade]',
					conjugue_cpf 				= '$campos[f_conjugue_cpf]',
					conjugue_rg 				= '$campos[f_conjugue_rg]',
					conjugue_local_emissao 		= '$campos[f_conjugue_local_emissao]',
					conjugue_telefone 			= '$campos[f_conjugue_telefone]',
					conjugue_data_emissao 		= '".dataBrToUsa($campos['f_conjugue_data_emissao'])."',
					conjugue_data_nascimento 	= '".dataBrToUsa($campos['f_conjugue_data_nascimento'])."',
					conjugue_email 				= '$campos[f_conjugue_email]',
					conjugue_estado_civil 		= '',
					conjugue_naturalidade 		= '$campos[f_conjugue_naturalidade]',
					conjugue_nacionalidade 		= '$campos[f_conjugue_nacionalidade]',
					conjugue_endereco_comercial = '$campos[f_endereco_comercial_conjugue]',
					conjugue_telefone_comercial = '$campos[f_telefone_comercial_conjugue]',
					naturalidade 				= '$campos[f_naturalidade]',
					nacionalidade 				= '$campos[f_nacionalidade]',
					endereco_comercial 			= '$campos[f_endereco_comercial]',
					telefone_comercial 			= '$campos[f_telefone_comercial]',
					data_emissao	 			= '".dataBrToUsa($campos['f_data_emissao'])."',
					grau_instrucao 				= '',
					situacao                    = '',
					data_cadastro               = '".date("Y-m-d")."',
					
					observacao                  = '$campos[obsContato]'
					

				";
				//echo $insert;
				//echo mysql_error();
				mysql_query($insert);
				return mysql_insert_id();
}

function CadJuridico($campos){
		global $vkt_id;
$insert = "
					INSERT INTO  revenda_contato SET 
  					cliente_vekttor_id 			= '$vkt_id',
  					revenda_franquia_id			= '$vkt_id',
  					vendedor_id					= '$campos[vendedor_id]',
  					vendedor_cliente_vekttor_id = '',
  					razao_social  				= '$campos[j_razao_social]',
  					nome_fantasia 				= '$campos[j_nome_fantasia]',
  					nome_contato  				= '$campos[j_nome_contato]',
					ramo_atividade	 			= '$campos[j_ramo_atividade]',
					nascimento	 				= '',
					cnpj_cpf 					= '$campos[j_cnpj_cpf]',
					rg 							= '',
					local_emissao 				= '',
					suframa 					= '',
					inscricao_municipal 		= '$campos[j_inscricao_municipal]',
					inscricao_estadual 			= '$campos[j_inscricao_estadual]',
					email 						= '$campos[j_email]',
					telefone1 					= '$campos[j_telefone1]',
					telefone2 					= '$campos[j_telefone2]',
					fax 						= '$campos[j_fax]',
					cep 						= '$campos[j_cep]',
					endereco 					= '$campos[j_endereco]',
					bairro 						= '$campos[j_bairro]',
					cidade 						= '$campos[j_cidade]',
					estado 						= '$campos[j_estado]',
					limite 						= '$campos[f_limite]',
					tipo 					    = '',
					tipo_cadastro 			    = '$campos[tipo_cadastro]' ,
					estado_civil 			    = '$campos[f_estado_civil]',
					conjugue_nome 				= '$campos[f_conjugue_nome]',
					conjugue_ramo_atividade 	= '$campos[f_conjugue_ramo_atividade]',
					conjugue_cpf 				= '$campos[f_conjugue_cpf]',
					conjugue_rg 				= '$campos[f_conjugue_rg]',
					conjugue_local_emissao 		= '$campos[f_conjugue_local_emissao]',
					conjugue_telefone 			= '$campos[f_conjugue_telefone]',
					conjugue_data_emissao 		= '".dataBrToUsa($campos['f_conjugue_data_emissao'])."',
					conjugue_data_nascimento 	= '".dataBrToUsa($campos['f_conjugue_data_nascimento'])."',
					conjugue_email 				= '$campos[f_conjugue_email]',
					conjugue_estado_civil 		= '',
					conjugue_naturalidade 		= '$campos[f_conjugue_naturalidade]',
					conjugue_nacionalidade 		= '$campos[f_conjugue_nacionalidade]',
					conjugue_endereco_comercial = '$campos[f_endereco_comercial_conjugue]',
					conjugue_telefone_comercial = '$campos[f_telefone_comercial_conjugue]',
					naturalidade 				= '$campos[f_naturalidade]',
					nacionalidade 				= '$campos[f_nacionalidade]',
					endereco_comercial 			= '$campos[f_endereco_comercial]',
					telefone_comercial 			= '$campos[f_telefone_comercial]',
					data_emissao	 			= '".dataBrToUsa($campos['f_data_emissao'])."',
					grau_instrucao 				= '',
					situacao                    = '',
					data_cadastro               = '".date("Y-m-d")."',
					
					observacao                  = '$campos[obsContato]'

				";
				//echo $insert;
				mysql_query($insert);
				return mysql_insert_id();	
}


function updatei($campos){
		global $vkt_id;
				if($campos['tipo_cadastro'] == 'Jurídico'){
						return UpdateJuridico($campos);
				} else{
						return UpdateFisico($campos);
				}
						
}

function UpdateFisico($campos){
	//alert("F");
	global $vkt_id;
		$update = "
					UPDATE  revenda_contato SET 
  					cliente_vekttor_id 			= '$vkt_id',
  					revenda_franquia_id			= '$vkt_id',
  					vendedor_id					= '$campos[vendedor_id]',
  					vendedor_cliente_vekttor_id = '',
  					razao_social  				= '$campos[f_nome_contato]',
					nome_fantasia  				= '$campos[f_nome_contato]',
					nome_contato  				= '$campos[f_nome_contato]',
					ramo_atividade	 			= '$campos[f_ramo_atividade]',
					nascimento	 				= '',
					cnpj_cpf 					= '$campos[f_cnpj_cpf]',
					rg 							= '',
					local_emissao 				= '',
					suframa 					= '',
					inscricao_municipal 		= '$campos[f_inscricao_municipal]',
					inscricao_estadual 			= '$campos[f_inscricao_estadual]',
					email 						= '$campos[f_email]',
					telefone1 					= '$campos[f_telefone1]',
					telefone2 					= '$campos[f_telefone2]',
					fax 						= '$campos[f_fax]',
					cep 						= '$campos[f_cep]',
					endereco 					= '$campos[f_endereco]',
					bairro 						= '$campos[f_bairro]',
					cidade 						= '$campos[f_cidade]',
					estado 						= '$campos[f_estado]',
					limite 						= '$campos[f_limite]',
					tipo 					    = '',
					tipo_cadastro 			    = '$campos[tipo_cadastro]',
					estado_civil 			    = '$campos[f_estado_civil]',
					conjugue_nome 				= '$campos[f_conjugue_nome]',
					conjugue_ramo_atividade 	= '$campos[f_conjugue_ramo_atividade]',
					conjugue_cpf 				= '$campos[f_conjugue_cpf]',
					conjugue_rg 				= '$campos[f_conjugue_rg]',
					conjugue_local_emissao 		= '$campos[f_conjugue_local_emissao]',
					conjugue_telefone 			= '$campos[f_conjugue_telefone]',
					conjugue_data_emissao 		= '".dataBrToUsa($campos['f_conjugue_data_emissao'])."',
					conjugue_data_nascimento 	= '".dataBrToUsa($campos['f_conjugue_data_nascimento'])."',
					conjugue_email 				= '$campos[f_conjugue_email]',
					conjugue_estado_civil 		= '',
					conjugue_naturalidade 		= '$campos[f_conjugue_naturalidade]',
					conjugue_nacionalidade 		= '$campos[f_conjugue_nacionalidade]',
					conjugue_endereco_comercial = '$campos[f_endereco_comercial_conjugue]',
					conjugue_telefone_comercial = '$campos[f_telefone_comercial_conjugue]',
					naturalidade 				= '$campos[f_naturalidade]',
					nacionalidade 				= '$campos[f_nacionalidade]',
					endereco_comercial 			= '$campos[f_endereco_comercial]',
					telefone_comercial 			= '$campos[f_telefone_comercial]',
					data_emissao	 			= '".dataBrToUsa($campos['f_data_emissao'])."',
					grau_instrucao 				= '',
					situacao                    = '',
					data_cadastro               = '".dataBrToUsa($campos['data_cadastro'])."',
					vendedor_id                 = $campos[vendedor_id],
					observacao                  = '$campos[obsContato]'
				WHERE 
					id = '$campos[contato_id]'
				";
				//echo $update;
				mysql_query($update);
				
				return $campos[contato_id];		
}

function UpdateJuridico($campos){
	
	global $vkt_id;
		$update = "
					UPDATE  revenda_contato SET 
  					cliente_vekttor_id 			= '$vkt_id',
  					revenda_franquia_id			= '$vkt_id',
  					vendedor_id					= '$campos[vendedor_id]',
  					vendedor_cliente_vekttor_id = '',
  					razao_social  				= '$campos[j_razao_social]',
  					nome_fantasia 				= '$campos[j_nome_fantasia]',
  					nome_contato  				= '$campos[j_nome_contato]',
					ramo_atividade	 			= '$campos[j_ramo_atividade]',
					nascimento	 				= '',
					cnpj_cpf 					= '$campos[j_cnpj_cpf]',
					rg 							= '',
					local_emissao 				= '',
					suframa 					= '',
					inscricao_municipal 		= '$campos[j_inscricao_municipal]',
					inscricao_estadual 			= '$campos[j_inscricao_estadual]',
					email 						= '$campos[j_email]',
					telefone1 					= '$campos[j_telefone1]',
					telefone2 					= '$campos[j_telefone2]',
					fax 						= '$campos[j_fax]',
					cep 						= '$campos[j_cep]',
					endereco 					= '$campos[j_endereco]',
					bairro 						= '$campos[j_bairro]',
					cidade 						= '$campos[j_cidade]',
					estado 						= '$campos[j_estado]',
					limite 						= '$campos[f_limite]',
					tipo 					    = '',
					tipo_cadastro 			    = '$campos[tipo_cadastro]',
					estado_civil 			    = '$campos[f_estado_civil]',
					conjugue_nome 				= '$campos[f_conjugue_nome]',
					conjugue_ramo_atividade 	= '$campos[f_conjugue_ramo_atividade]',
					conjugue_cpf 				= '$campos[f_conjugue_cpf]',
					conjugue_rg 				= '$campos[f_conjugue_rg]',
					conjugue_local_emissao 		= '$campos[f_conjugue_local_emissao]',
					conjugue_telefone 			= '$campos[f_conjugue_telefone]',
					conjugue_data_emissao 		= '".dataBrToUsa($campos['f_conjugue_data_emissao'])."',
					conjugue_data_nascimento 	= '".dataBrToUsa($campos['f_conjugue_data_nascimento'])."',
					conjugue_email 				= '$campos[f_conjugue_email]',
					conjugue_estado_civil 		= '',
					conjugue_naturalidade 		= '$campos[f_conjugue_naturalidade]',
					conjugue_nacionalidade 		= '$campos[f_conjugue_nacionalidade]',
					conjugue_endereco_comercial = '$campos[f_endereco_comercial_conjugue]',
					conjugue_telefone_comercial = '$campos[f_telefone_comercial_conjugue]',
					naturalidade 				= '$campos[f_naturalidade]',
					nacionalidade 				= '$campos[f_nacionalidade]',
					endereco_comercial 			= '$campos[f_endereco_comercial]',
					telefone_comercial 			= '$campos[f_telefone_comercial]',
					data_emissao	 			= '".dataBrToUsa($campos['f_data_emissao'])."',
					grau_instrucao 				= '',
					situacao                    = '',
					data_cadastro               = '".dataBrToUsa($campos['data_cadastro'])."',
					
					observacao                  = '$campos[obsContato]'
				WHERE 
					id = '$campos[contato_id]'
				";
				//echo $update;
				mysql_query($update);
				
				return $campos[contato_id];	

}

function excluiri($id){
	
			$Delete = " DELETE FROM revenda_contato WHERE id = '$id' ";
			mysql_query($Delete);
}
/*----------------------------------------------------------------*/

function manipulaInteracao($dados,$contato_id){
	
	if($dados['o_que_gerou']==4){
		$status = "4";
	}else if($dados['o_que_gerou']==5){
		$status = "3";
	}else{
		$status = "2";
	}
		
	if(!$dados['id']>0){
		
		$interacao_id=cadastra_interacao($dados,$contato_id,$status);
		
		// 4 = Venda, 5 = Cancelamento
		if($dados['o_que_gerou']!=4&&$dados['o_que_gerou']!=5&&(!empty($dados['dt_proxima_interacao']))){
			cadastra_proxima_interacao($dados,$interacao_id,$contato_id);
		}
	}else{
		$interacao_id=atualiza_interacao($dados,$contato_id,$status);
		if($dados['o_que_gerou']!=4&&$dados['o_que_gerou']!=5&&(!empty($dados['dt_proxima_interacao']))){
			cadastra_proxima_interacao($dados,$dados['id'],$contato_id);
		}
	}

	if($status=='4'){
		echo "<script>location.href='?tela_id=354&contato_id=$contato_id'</script>";
	}
}

function cadastra_interacao($dados,$contato_id,$status){
	global $vkt_id;
	//alert("OI ".$contato_id);
	$data_hota=DataBrToUsa($dados['data_interacao'])." ".$dados['hora_interacao'];
	
	mysql_query($t="INSERT INTO 
				 revenda_contato_interacao
				 SET
				 revenda_contato_id='$contato_id',
				 cliente_vekttor_id='$vkt_id',
				 vendedor_id='{$dados['vendedor_id']}',
				 tipo_interacao='{$dados['tp_interacao']}',
				 o_que_gerou='{$dados['o_que_gerou']}',
				 data_hora_interacao='$data_hota',
				 data_sistema=NOW(),
				 comentario='{$dados['observacao']}',
				 interacao_id='0'");
	
	//$contato_id = mysql_insert_id();
	if($status!=4){
		mysql_query($t1="UPDATE revenda_contato SET status = '$status', data_ultima_interacao='$data_hota' WHERE id='$contato_id'");
	}
	//echo $t1;
	return mysql_insert_id();
	
	//echo $t."<br>".$t1;;
}

function cadastra_proxima_interacao($dados,$interacao_id,$contato_id){
	global $vkt_id;
	
	$data_hota=DataBrToUsa($dados['dt_proxima_interacao'])." ".$dados['hr_proxima_interacao'];
	mysql_query($t="INSERT INTO 
				 revenda_contato_interacao
				 SET
				 revenda_contato_id='$contato_id',
				 cliente_vekttor_id='$vkt_id',
				 vendedor_id='{$dados['vendedor_id']}',
				 tipo_interacao='{$dados['o_que_gerou']}',
				 data_hora_interacao='$data_hota',
				 data_sistema=NOW(),
				 comentario='{$dados['observacao']}',
				 interacao_id='$interacao_id'");
	//echo $t." ".mysql_error();
}

function atualiza_interacao($dados,$contato_id,$status){
	$data_hota=DataBrToUsa($dados['data_interacao'])." ".$dados['hora_interacao'];
	mysql_query($t="UPDATE 
				 revenda_contato_interacao
				 SET
				 revenda_contato_id={$dados['contato_id']},
				 vendedor_id='{$dados['vendedor_id']}',
				 o_que_gerou='{$dados['o_que_gerou']}',
				 data_sistema=NOW(),
				 data_hora_interacao='$data_hota'				  
				 WHERE id='$dados[id]'");
	//echo $t." ".mysql_error();			 
	if($status!=4){
		mysql_query($t1="UPDATE revenda_contato SET status = '$status', data_ultima_interacao='$data_hota' WHERE id='$contato_id'");			 
	}
	//echo $t."<br>".$t1;
}
?>