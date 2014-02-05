<?
//Funções 

//Cadastra Vendedor
function cadastra($campos){
				global $vkt_id;
				$usuarioID = cadUsuarioVendedor($campos);
				$insertFornecedor = " INSERT INTO cliente_fornecedor SET				
					cliente_vekttor_id = '$vkt_id',
					usuario_id         = '$usuarioID',
					razao_social       = '$campos[f_nome_contato]',
					nome_fantasia      = '$campos[f_nome_contato]',
					nome_contato       = '$campos[f_nome_contato]',
					cnpj_cpf           = '$campos[f_cnpj_cpf]',
					rg                 = '$campos[f_rg]',
					local_emissao      = '$campos[f_local_emissao]',
					data_emissao       = '".dataBrToUsa($campos['f_data_emissao'])."',
					nascimento         = '".dataBrToUsa($campos['f_nascimento'])."',
					naturalidade       = '$campos[f_naturalidade]',
					nacionalidade      = '$campos[f_nacionalidade]',
					email              = '$campos[f_email]',
					telefone1          = '$campos[f_telefone1]',
					telefone2          = '$campos[f_telefone2]',
					fax                = '$campos[f_fax]',
					cep                = '$campos[f_cep]',
					endereco           = '$campos[f_endereco]',
					bairro        	   = '$campos[f_bairro]',
					cidade             = '$campos[f_cidade]',
					tipo               = 'Fornecedor',
					tipo_cadastro      = 'Físico',
					estado             = '$campos[f_estado]'";
				mysql_query($insertFornecedor);
				$CFornecedorID = mysql_insert_id();		
				$sqlVendedor = " INSERT INTO rh_funcionario SET 
												vkt_id                = '$vkt_id',
												cliente_fornecedor_id = '$CFornecedorID',
												usuario_id            = '$usuarioID',
												cliente_vekttor_id    = '$vkt_id',
												nome			      = '$campos[f_nome_contato]',
												vendedor              = 's', 
												implantacao           = '".moedaBrToUsa($campos['porcento_implantacao'])."',
												servico 	          = '".moedaBrToUsa($campos['porcento_servico'])."' ";
				//echo $sqlVendedor;
				mysql_query($sqlVendedor);
					
	
}

function cadUsuarioVendedor($campos){
		global $vkt_id;
		$sqlUsuario = " INSERT INTO usuario SET 
									cliente_vekttor_id = '$vkt_id',
									usuario_tipo_id    = '$campos[tipo_usuario]',
									nome			   = '$campos[nome_usuario]',
									login			   = '$campos[login_usuario]',
									senha              = '$campos[senha_usuario]'
									";
		mysql_query($sqlUsuario);
		//echo $sqlUsuario;		
		$usuarioID = mysql_insert_id();
		return $usuarioID;
}

function update($campos){
				global  $vkt_id;

				$sqlVendedor = " UPDATE rh_funcionario SET nome = '$campos[f_nome_contato]', vendedor = 's', 
														   implantacao = '".moedaBrToUsa($campos['porcento_implantacao'])."',
														   servico = '".moedaBrToUsa($campos['porcento_servico'])."' WHERE id = '$campos[id]' ";
					
					
				
				$UpdateFornecedor = " UPDATE cliente_fornecedor SET				
					cliente_vekttor_id = '$vkt_id',
					usuario_id    = '$campos[usuario_id]',
					nome_contato  = '$campos[f_nome_contato]',
					cnpj_cpf      = '$campos[f_cnpj_cpf]',
					rg            = '$campos[f_rg]',
					local_emissao = '$campos[f_local_emissao]',
					data_emissao  = '".dataBrToUsa($campos['f_data_emissao'])."',
					nascimento    = '".dataBrToUsa($campos['f_nascimento'])."',
					naturalidade  = '$campos[f_naturalidade]',
					nacionalidade = '$campos[f_nacionalidade]',
					email         = '$campos[f_email]',
					telefone1     = '$campos[f_telefone1]',
					telefone2     = '$campos[f_telefone2]',
					fax           = '$campos[f_fax]',
					cep           = '$campos[f_cep]',
					endereco      = '$campos[f_endereco]',
					bairro        = '$campos[f_bairro]',
					cidade        = '$campos[f_cidade]',
					estado        = '$campos[f_estado]'
					WHERE id = '$campos[cliente_vendedor_id]'
					";				
				$sqlUsuraio=" UPDATE usuario SET nome = '$campos[nome_usuario]', login = '$campos[login_usuario]', senha = '$campos[senha_usuario]' WHERE id = '$campos[usuario_id]'";
				
				
/*- Executa SQL -*/
mysql_query($sqlVendedor);
mysql_query($UpdateFornecedor);
mysql_query($sqlUsuraio);
}

function excluir($id){
				$vendedor = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id = '$id'"));
				
				$sql = mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS qtd FROM financeiro_movimento WHERE internauta_id = '$vendedor->cliente_fornecedor_id' "));
				if($sql->qtd > 0){
					echo "<script> alert('Existe Pendencias Financeiras');</script>";
					//exit();	
				} else{
					mysql_query(" DELETE FROM cliente_fornecedor WHERE id = '$vendedor->cliente_fornecedor_id'");
					mysql_query(" DELETE FROM rh_funcionario WHERE id = '$id' ");
					mysql_query(" DELETE FROM usuario WHERE id = '$vendedor->usuario_id'");
				}
	
				
			
			
}

?>