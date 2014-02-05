<?php
function verifica_usuario($usuario,$senha){

	$usuario = mysql_fetch_object(mysql_query($t="SELECT * FROM usuario WHERE login='$usuario' AND senha='$senha'"));
	
	return $usuario->id;
}

function ManipulaUsuario($dados){
	
	global $vkt_id;
	global $usuario_id;
	
	
	if($dados['usuario_id']<=0){$inicio="INSERT INTO";}else{$inicio ="UPDATE";}
	if($dados['usuario_id']<=0){$fim="";}else{$fim = "WHERE id='".$dados['usuario_id']."'";}
	
	//$tipo = mysql_fetch_object(mysql_query("SELECT * FROM `usuario_tipo` WHERE vkt_id = '$vkt_id' LIMIT 1 "));
	$existe_usuario = verifica_usuario($dados[login_usuario],$dados[senha_usuario]);
	
	if(!$existe_usuario>0||$existe_usuario==$dados['usuario_id']){	
		mysql_query($t="$inicio usuario SET nome='$dados[nome_usuario]',login='$dados[login_usuario]',senha='$dados[senha_usuario]',usuario_tipo_id='$dados[usuatio_tipo_id]',cliente_vekttor_id='$vkt_id'  $fim");
	}else{
		alert("Login e senha não podem ser cadastrados, Por favor Digite outro login e senha");
	}
	if($dados['usuario_id']<=0){ return mysql_insert_id();}else{ return $dados['usuario_id'];}
}

function ManipulaClienteFornecedor($campos,$usuario_id){
				global $vkt_id;
				
				if($campos['cliente_fornecedor_id']<=0){$inicio = 'INSERT INTO';$fim='';}
				else{$inicio='UPDATE';$fim='WHERE id='.$campos['cliente_fornecedor_id'];}
				$insert = "
					$inicio  cliente_fornecedor SET 
  					cliente_vekttor_id 			= '$vkt_id',
					usuario_id                  = '$usuario_id',
  					razao_social  				= '$campos[f_nome_contato]',
					nome_fantasia  				= '$campos[f_nome_contato]',
					nome_contato  				= '$campos[f_nome_contato]',
					ramo_atividade	 			= '$campos[f_ramo_atividade]',
					nascimento	 				= '".dataBrtoUsa($campos['f_nascimento'])."',
					cnpj_cpf 					= '$campos[f_cnpj_cpf]',
					rg 							= '$campos[f_rg]',
					local_emissao 				= '$campos[f_local_emissao]',
					suframa 					= '',
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
					tipo 					    = 'Fornecedor',
					tipo_cadastro 			    = 'Físico' ,
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
					grau_instrucao 				= ''
					
					$fim

				";
				//echo $insert."<br>";
				//echo mysql_error();
				mysql_query($insert);

				if($campos['cliente_fornecedor_id']>0){
					return $campos['cliente_fornecedor_id'];
				}else{
					return mysql_insert_id();
				}
}

function manipulaOdontologo($dados,$usuario,$cliente_fornecedor){
	
	global $vkt_id;
	
	if($dados['id']<=0){$inicio = 'INSERT INTO';$fim='';}
	else{$inicio = 'UPDATE';$fim='WHERE id='.$dados['id'];}
	
	mysql_query($t="$inicio odontologo_odontologo
				SET
				vkt_id                  = '$vkt_id',
				cliente_fornecedor_id   = '$cliente_fornecedor',
				usuario_id              = '$usuario',
				agenda_id               = '$dados[agenda_id]',
				cro                     = '$dados[f_cro]',
				porcentagem_recebimento = '".MoedaBrToUsa($dados[porcentagem_recebimento])."'
				$fim			
	");
	
	//echo $t;
		
}

function ExcluiOdontologo($dados){
	mysql_query("DELETE FROM odontologo_odontologo WHERE id=".$dados['id']);
	mysql_query("DELETE FROM cliente_fornecedor WHERE id=".$dados['cliente_fornecedor_id']);
	mysql_query("DELETE FROM usuario WHERE id=".$dados['usuario_id']);
}
?>