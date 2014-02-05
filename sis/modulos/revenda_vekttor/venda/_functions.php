<?
//Atualiza Venda 
function update($campos){
	global $vkt_id;
	
	/*-VEKTTOR CLIENTE IMG-*/
		////echo"Foto: ".$_FILES['foto']['name'];
	if(strlen($_FILES['foto']['name'])>3){
		logomarca_envia_arquivo($campos['cliente_vekttor_id']);
	}
	/*-USUARIO-*/
			/*Atualiza o usuario*/
			if(!empty($campos['usuarioID'])){
				updateUsuario($campos);
			}
	/*-SERVIÇO-*/
			cadItemServicoVenda($campos);
			removeServico($campos);
			$obsEditServico = $campos['obsItemEditServico'];	
				if(sizeof($obsEditServico) > 0){
							updateServico($campos);	
				}	
	/*-PACOTE-*/
			cadItemPacotesVenda($campos);
			removePacote($campos);
	/*-VEKTTOR VENDA -*/
	$sqlVendaUpdate = " UPDATE vekttor_venda SET
								revenda_contato_id  = '$campos[contato_id]',
								vendedor_id         = '$campos[vendedor_id]',
								contrato            = '$campos[texto]',
								data_negociacao     = '".dataBrToUsa($campos['data_negociacao'])."',
								valor_mensalidade   = '".moedaBrToUsa($campos['val_mensalidade'])."',
								valor_implantacao   = '".moedaBrToUsa($campos['val_implantacao'])."',
								valor_desconto      = '".moedaBrToUsa($campos['val_desconto'])."',
								valor_servico       = '".moedaBrToUsa($campos['val_servico'])."',
								subtotal            = '".moedaBrToUsa($campos['sub-total'])."',
								total               = '".moedaBrToUsa($campos['total_venda'])."',
								situacao_venda      = '1',
								dia_vencimento      = '".dataBrToUsa($campos['diaVencimento'])."',
								contrato            = '".$campos['texto']."' 
					WHERE id = '$campos[venda_id]'";
					mysql_query($sqlVendaUpdate);
}
function updateServico($campos){
	$obsEditServico = $campos['obsItemEditServico'];
	$itemID = $campos['item_id'];
		for($i=0;$i <sizeof($obsEditServico);$i++){
			$sql=" UPDATE vekttor_venda_servico SET 
					observacao       = '$obsEditServico[$i]' WHERE id = $itemID[$i]";
					mysql_query($sql);	
		}
}

function removeServico($campos){
		/* Aqui um Array com a lista de ID para ser removido na tabela vekttor_venda_servico */
			$itemID = $campos['InputDelServico'];
			for($i=0;$i<sizeof($itemID);$i++){
						$sql=" DELETE FROM vekttor_venda_servico WHERE id = '$itemID[$i]'";
						mysql_query($sql);
			}
}


function removePacote($campos){
			/* Array com Lista de pacote_id para ser removida da venda*/
			$listDel = $campos['InputDelPacote'];			
				
				if(!empty($listDel)){
				
				for($i=0;$i<sizeof($listDel);$i++){
						if($listDel[$i] != 0){
								$sql = " DELETE FROM vekttor_venda_pacote WHERE pacotes_id = '$listDel[$i]' AND vekttor_venda_id = '$campos[venda_id]'";
								//echo $sql;
								mysql_query($sql);	
						}
						
					/*Seleciona os pacote para trazer os modulos */
					$sqlPacote = mysql_query($tn=" SELECT * FROM  pacote_item WHERE pacote_id = '$listDel[$i]' ");
						while($pct=mysql_fetch_object($sqlPacote)){
								$modulos[] = $pct->sis_modulo_id;
						}
				} /*Fim de For*/
				
					for($j=0;$j<sizeof($modulos);$j++){
							$sqlModulos = " DELETE FROM  usuario_tipo_modulo WHERE modulo_id = '$modulos[$j]' AND usuario_tipo_id = '$campos[id_usuario_tipo]'";
							mysql_query($sqlModulos);
					}
				}
				
				
}

function updateObs($campos){
			$campos['ItemID'];
			$obs = $campos['obsItemServico'];
			for($i=0; $i <sizeof($obs);$i++){
					if($obs[$i] != 0){
							$sql = "";
					}	
			}
			
}
//Cadastra Venda
function cadastra($campos){
	//vendedor_cliente_vekttor_id = '$campos[]',
				global $vkt_id;
				
				$campos['cliente_vekttor_id'] = cadClienteVekttor($campos); /* Cadastra Cliente Vekttor e retorna o ID do registro cadastrado */
				$campos['tipo_usuario'] = cadTipoUsuario($campos);
				$campos['usuario_id'] = cadUsuario($campos); /* Cadastra o usuario e retorna o ID do registro cadastrado */
				
				cadClienteFornecedor($campos);
				if(strlen($_FILES['foto']['name'])>3){
					logomarca_envia_arquivo($campos['cliente_vekttor_id']);
				}
				
				
				$sqlVenda = " INSERT INTO vekttor_venda SET
								
								revenda_franquia_id = '$vkt_id',
								revenda_contato_id  = '$campos[contato_id]',
								cliente_vekttor_id  = '$campos[cliente_vekttor_id]',
								vendedor_id         = '$campos[vendedor_id]',
								contrato            = '$campos[texto]',
								data_negociacao     = '".dataBrToUsa($campos['data_negociacao'])."',
								valor_mensalidade   = '".moedaBrToUsa($campos['val_mensalidade'])."',
								valor_implantacao   = '".moedaBrToUsa($campos['val_implantacao'])."',
								valor_desconto      = '".moedaBrToUsa($campos['val_desconto'])."',
								valor_servico       = '".moedaBrToUsa($campos['val_servico'])."',
								subtotal            = '".moedaBrToUsa($campos['sub-total'])."',
								total               = '".moedaBrToUsa($campos['total_venda'])."',
								situacao_venda      = '1',
								dia_vencimento      = '".dataBrToUsa($campos['diaVencimento'])."'";
/*- Execuçao de SQL -*/
				
mysql_query($sqlVenda);
$campos['venda_id'] = mysql_insert_id();	

	cadItemPacotesVenda($campos);
	cadItemServicoVenda($campos);
	
	mysql_query("UPDATE revenda_contato SET status='4' WHERE id='$campos[contato_id]'");
	
	if(strlen($_FILES['file']['name'])>3){
		EnviaArquivo($campos['venda_id']);
	}	
	
} /*Fim da Funçao */

function cadItemPacotesVenda($campos){
	
	$pacote_id       = $campos['pacote_id'];
	$valMensalPacote = $campos['valMensalPacote'];
	$valImplatPacote = $campos['valImplatPacote'];
		//print_r($valMensalPacote);
		for($i = 0;$i <sizeof($pacote_id);$i++){
			
			$sqlSelect = mysql_fetch_object(mysql_query($tt=" SELECT COUNT(id) AS qtd FROM vekttor_venda_pacote WHERE pacotes_id = '$pacote_id[$i]' AND vekttor_venda_id = '$campos[venda_id]'"));
					if($sqlSelect->qtd == 0){
						$sql = " INSERT INTO  vekttor_venda_pacote SET 
									pacotes_id        = '$pacote_id[$i]',
									vekttor_venda_id  = '$campos[venda_id]',
									valor_mensalidade = '".moedaBrToUsa($valMensalPacote[$i])."',
									valor_implantacao = '".moedaBrToUsa($valImplatPacote[$i])."' ";
						//echo $sql;
						mysql_query($sql);
					}
					/*Seleciona os pacote para trazer os modulos */
					$sqlPacote = mysql_query($tn=" SELECT * FROM  pacote_item WHERE pacote_id = '$pacote_id[$i]' ");
						while($pct=mysql_fetch_object($sqlPacote)){
								$modulos[] = $pct->sis_modulo_id;
						}	
		}
		
			if(!empty($campos['id_usuario_tipo'])){
					$campos['tipo_usuario'] = $campos['id_usuario_tipo'];
			}
			
		for($j=0;$j<sizeof($modulos);$j++){
				$sqlModulos = " INSERT INTO usuario_tipo_modulo SET 
											modulo_id = '$modulos[$j]', 
											usuario_tipo_id = '$campos[tipo_usuario]'";	
				mysql_query($sqlModulos);
		}
		//print_r($modulos);
		
}

function cadItemServicoVenda($campos){
		$servico_id = $campos['servicoItemID'];    // ID do serviço a ser cadastrado
		$valorItem  = $campos['valorItemServico'];
		$obsItem    = $campos['obsItemServico'];
					
					for($i=0;$i < sizeof($servico_id);$i++){
						$sqlSelect = mysql_fetch_object(mysql_query($tt=" SELECT COUNT(id) AS qtd FROM vekttor_venda_servico WHERE servico_id = '$servico_id[$i]' AND vekttor_venda_id = '$campos[venda_id]'"));
								if($sqlSelect->qtd == 0){
										$sql=" INSERT INTO  vekttor_venda_servico SET 
												servico_id       = $servico_id[$i],
												vekttor_venda_id = '$campos[venda_id]' ,
												valor            = '$valorItem[$i]',
												observacao       = '$obsItem[$i]'
												";
										mysql_query($sql);
								}
					}
}

function cadClienteFornecedor($campos){
			
			if($campos['tipo_pessoa'] == '1')
					$campos['tipo_cadastro'] = "Jurídico";	
			 else
					$campos['tipo_cadastro'] = "Físico";
			
			$insert = " INSERT INTO cliente_fornecedor SET 
			cliente_vekttor_id = '$campos[cliente_vekttor_id]',
			usuario_id         = '$campos[usuario_id]',
			razao_social       = '$campos[cliente_nome]',
			nome_fantasia = '$campos[cliente_nome_fantasia]',
			nome_contato  = '$campos[cliente_nome_contato]',
			cnpj_cpf      = '$campos[cliente_cnpj]',
			email         = '$campos[cliente_email]',
			telefone1     = '$campos[cliente_telefone1]',
			telefone2     = '$campos[cliente_telefone2]',
			fax           = '$campos[cliente_fax]',
			cep           = '$campos[cliente_cep]',
			endereco      = '$campos[cliente_endereco]',
			bairro        = '$campos[cliente_bairro]',
			cidade        = '$campos[cliente_cidade]',
			estado        = '$campos[cliente_estado]',
			tipo_cadastro = '$campos[tipo_cadastro]'";
			mysql_query($insert);
}

function cadClienteVekttor($campos){
			$insert = " INSERT INTO  clientes_vekttor SET
						nome             = '$campos[cliente_nome]',
						nome_fantasia    = '$campos[cliente_nome_fantasia]',
						cnpj 		     = '$campos[cliente_cnpj]',
						cep 			 = '$campos[cliente_cep]',
						endereco 		 = '$campos[cliente_endereco]',
						bairro 			 = '$campos[cliente_bairro]',
						cidade 			 = '$campos[cliente_cidade]',
						estado 			 = '$campos[cliente_estado]',
						quantidade_sms_mes = '0',
						img 			 = '1',
						status 			 = '1',
						data_cadastro 	 = '".dataBrToUsa($campos['data_cadastro'])."'";
/*- Executa SQL -*/			
mysql_query($insert);
$ultimo = mysql_insert_id();
return $ultimo;
//echo $insert;
}


function logomarca_envia_arquivo($cliente_vekttor_id){
	
	$filis_autorizados = array('jpg','gif','png');
	
	$infomovimento = mysql_fetch_object(mysql_query($t="SELECT * FROM clientes_vekttor WHERE id='$cliente_vekttor_id'"));
	
	if(strlen($_FILES['foto']['name'])>3){
	  $pasta 	= 'modulos/vekttor/clientes/img/';
	  $extensao = strtolower(substr($_FILES['foto']['name'],-3));
	  $arquivo 	= $pasta.$cliente_vekttor_id.".".$extensao;
	  $arquivodel = $pasta.$cliente_vekttor_id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['foto'][tmp_name],$arquivo)){
			  mysql_query($f="UPDATE clientes_vekttor SET img='".$cliente_vekttor_id.".".$extensao."' WHERE id='$cliente_vekttor_id'");
			  //echo $f;
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}	
}

function EnviaArquivo($venda_id){
	
	$filis_autorizados = array('jpg','gif','png','pdf','doc');
	
	$infomovimento = mysql_fetch_object(mysql_query($t="SELECT * FROM clientes_vekttor WHERE id='$cliente_vekttor_id'"));
	
	if(strlen($_FILES['file']['name'])>3){
	  $pasta 	= 'modulos/revenda_vekttor/venda/arquivo/';
	  $extensao = strtolower(substr($_FILES['file']['name'],-3));
	  $arquivo 	= $pasta.$venda_id.".".$extensao;
	  $arquivodel = $pasta.$cliente_vekttor_id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['file'][tmp_name],$arquivo)){
			  mysql_query($f="UPDATE vekttor_venda SET arquivo='".$venda_id.".".$extensao."' WHERE id='$venda_id'");
			  //echo $f;
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}	
}


function EnviaArquivoTeste($venda_id){
	
	$filis_autorizados = array('jpg','gif','png','pdf','doc');
	//$infomovimento = mysql_fetch_object(mysql_query($t="SELECT * FROM clientes_vekttor WHERE id='$cliente_vekttor_id'"));
	
	if(strlen($_FILES['file']['name'])>3){
	  $pasta 	= 'modulos/revenda_vekttor/venda/arquivo/';
	  $nameOriginal = $_FILES['file']['name'];
	  /*-Arquivo com pasta e nome original -*/
	  $arquivoModel = $pasta.$nameOriginal;
	  /*-Renomear arquivo original para = arquivo/venda_id -*/
	  rename($arquivoModel, $pasta.$venda_id);
	  $arquivo =  $pasta.$venda_id;
	  /*-retira extensao do arquivo -*/
	  $extensao = strtolower(substr($_FILES['file']['name'],-3));
	  
	  mysql_query($f="UPDATE vekttor_venda SET arquivo='".$venda_id.".".$extensao."' WHERE id='$venda_id'");
	  chmod($arquivo,0777);
	  //$arquivo 	= $pasta.$venda_id.".".$extensao;
	  //$arquivodel = $pasta.$cliente_vekttor_id.'.';
	  
	  
	}	
}




function cadTipoUsuario($campos){
			global $vkt_id;
			
			$insert = " INSERT INTO usuario_tipo SET vkt_id = '$campos[cliente_vekttor_id]' , nome = '$campos[nome_tipo_usuario]'";
			mysql_query($insert);
			$ultimo = mysql_insert_id();
			return $ultimo;
}
function cadUsuario($campos){
	global $vkt_id;
	$sqlSelect = mysql_query($t="SELECT * FROM usuario WHERE login='$campos[login_usuario]' AND senha='$campos[senha_usuario]'");
		echo $t;
		$reg_usuario = mysql_num_rows($sqlSelect);
		//echo $reg_usuario;
	if(!empty($campos['login_usuario'])){
		  if($reg_usuario == 0){
			  $sqlUsuario = " INSERT INTO usuario SET 
										  cliente_vekttor_id = '$campos[cliente_vekttor_id]',
										  usuario_tipo_id    = '$campos[tipo_usuario]',
										  nome			   = '$campos[nome_usuario]',
										  login			   = '$campos[login_usuario]',
										  senha              = '$campos[senha_usuario]'
										  ";
			  mysql_query($sqlUsuario);		
			  $usuarioID = mysql_insert_id();
			  return $usuarioID;
		  }else{
			  alert("Usuário já cadastrado!!");
			  return 0;	
		  }
	}
}

function updateUsuario($campos){
				$sqlUsuario = " UPDATE usuario SET 
									nome  = '$campos[nome_usuario]',
									login = '$campos[login_usuario]',
									senha = '$campos[senha_usuario]'
								WHERE id = '$campos[usuarioID]'
									";
		mysql_query($sqlUsuario);	
}

/*-====================================================================-*/







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