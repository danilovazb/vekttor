<?
//Funções 

//Cadastra Cliente
function ManipulaCliente($dados,$cliente_vekttor_id,$pacote_id){
	//alert($cliente_vekttor_id);
	if($cliente_vekttor_id<=0){$inicio ="INSERT INTO";$data=',data_cadastro="'.date('Y-m-d').'"';}else{$inicio ="UPDATE";$data='';}
	if($cliente_vekttor_id<=0){$fim="";}else{$fim = "WHERE id='".$cliente_vekttor_id."'";}
	
	$query = mysql_query($t="$inicio clientes_vekttor  SET nome='".$dados['cliente_nome']."', nome_fantasia='".$dados['cliente_nome_fantasia']."',
	cnpj='".$dados['cliente_cnpj']."', cep='".$dados['cliente_cep']."', endereco='".$dados['cliente_endereco']."', bairro='".$dados['cliente_bairro']."',
	cidade='".$dados['cliente_cidade']."', estado='".$dados['cliente_estado']."', status=1 $data $fim"); 
	//echo$t."<br>";
	
	if($cliente_vekttor_id==0){
		$aux=1;
		$cliente_vekttor_id=mysql_insert_id();
	}
	
	////echo"Foto: ".$_FILES['foto']['name'];
	if(strlen($_FILES['foto']['name'])>3){
		logomarca_envia_arquivo($cliente_vekttor_id);
	}
	
	
	$tipo=ManipulaTipo($dados['nome_tipo_usuario'],$cliente_vekttor_id,$aux,$dados['id_tipo']);
	//echo"Tipo: ".$tipo."<br>"; 
	$usuario_id=ManipulaUsuario($dados['nome_usuario'],$dados['login_usuario'],$dados['senha_usuario'],$cliente_vekttor_id,$tipo,$dados['id_usuario'],$aux);
	
	$fonecedor_id=manipula_cliente_fornecedor($dados,$cliente_vekttor_id,$usuario_id);
	$revendedor_id=manipula_revendedor($dados,$fonecedor_id,$cliente_vekttor_id);
	
	// Limpa Tabela
	mysql_query($t="DELETE FROM usuario_tipo_modulo WHERE usuario_tipo_id='$tipo'");
	//echo $t;
	mysql_query("DELETE FROM  revenda_franquia_pacote WHERE revendedor_id='$revendedor_id'");

	for($i=0;$i<count($pacote_id);$i++){
		//echo "Pacote:    ".$pacote_id[$i]."<br>";
		cadastraUsuarioTipoModulo($pacote_id[$i],$tipo);
		cadastraPacoteRevenda($pacote_id[$i],$revendedor_id);
	}
}

//Exclui cliente
function ExcluiCliente($dados){
	mysql_query($t="DELETE FROM clientes_vekttor WHERE id='".$dados['cliente_id']."'");
	//echo $t."<br>";
	mysql_query($t="DELETE FROM usuario_tipo WHERE id='".$dados['id_tipo']."'");
	//echo $t."<br>";
	mysql_query($t="DELETE FROM usuario_tipo_modulo WHERE usuario_tipo_id='".$dados['id_tipo']."'");
	//echo $t."<br>";
	mysql_query($t="DELETE FROM usuario WHERE id='".$dados['id_usuario']."'");
	//echo $t."<br>";
	mysql_query($t="DELETE FROM revenda_franquia WHERE id='".$dados['revendedor_id']."'");
	//echo $t."<br>";
	mysql_query($t="DELETE FROM cliente_fornecedor WHERE id='".$dados['cliente_fornecedor_id']."'");
	//echo $t."<br>";
}

function ManipulaTipo($nome,$cliente_vekttor_id,$aux,$tipo_id){
	if(empty($tipo_id)){$inicio="INSERT INTO";}else{$inicio ="UPDATE";}
	if(empty($tipo_id)){$fim="";}else{$fim = "WHERE vkt_id='$cliente_vekttor_id' AND id='$tipo_id'";}
	$query=mysql_query($t="$inicio usuario_tipo SET nome='revenda_vekttor',vkt_id='$cliente_vekttor_id' $fim");	
	//echo $t."<br>";
	if(empty($tipo_id)){
		return mysql_insert_id();
	}else{
		return $tipo_id;
	}
}

function ManipulaUsuario($nome,$login,$senha,$cliente_vekttor_id,$tipo_id,$id_usuario,$aux){
		$existe_usuario = mysql_query($t="SELECT * FROM usuario WHERE login='$login' AND senha='$senha'");
		
		if(!$id_usuario>0){$inicio="INSERT INTO";}else{$inicio ="UPDATE";}
		if(!$id_usuario>0){$fim="";}else{$fim = "WHERE id='$id_usuario'";}
		
		if(@mysql_num_rows($existe_usuario)>0&&$id_usuario<=0){
			alert("Usuário já cadastrado!!");
			return 0;
		}else{
			$query =mysql_query($t="$inicio usuario SET nome='$nome',login='$login',senha='$senha',usuario_tipo_id='$tipo_id',cliente_vekttor_id='$cliente_vekttor_id'  $fim");
			if(!$id_usuario>0){return mysql_insert_id();}else{ return $id_usuario;}
		}
	//echo $t;
		
	
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
			  mysql_query($f="UPDATE clientes_vekttor SET img='1' WHERE id='$cliente_vekttor_id'");
			  //echo $f;
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}	
}

//Usuário Tipo com Módulos
function cadastraUsuarioTipoModulo($pacote_id,$usuario_tipo_id){
	//seleciona os módulos pertencentes ao pacote
	$modulos = mysql_query($t="SELECT * FROM pacote_item WHERE pacote_id=$pacote_id");
	//echo $t;
	while($modulo = mysql_fetch_object($modulos)){	
		$existe = mysql_query("SELECT * FROM usuario_tipo_modulo WHERE modulo_id='$modulo->sis_modulo_id' AND usuario_tipo_id='$usuario_tipo_id'");
		if(!@mysql_num_rows($existe)>0){
			$trace=mysql_query($t="
				INSERT INTO usuario_tipo_modulo SET
				modulo_id='".$modulo->sis_modulo_id."',
				usuario_tipo_id='".$usuario_tipo_id."'
			");
		}
		//echo $t."<br>";
	}
	////echo$trace."<br>";
				
		//return 1;
	//}
	return 0;
}

function manipula_cliente_fornecedor($dados,$cliente_vekttor_id,$idusuario){
	
	global $vkt_id;
	
	if(!$dados['cliente_fornecedor_id']>0){$inicio="INSERT INTO";$fim="";}else{$inicio="UPDATE";$fim="WHERE id='".$dados['cliente_fornecedor_id']."'";}
	
	mysql_query($t="$inicio cliente_fornecedor SET 
		cliente_vekttor_id='$vkt_id',
		usuario_id='$idusuario',
		tipo='Fornecedor',
		tipo_cadastro='Jurídico',
		nome_contato='".$dados['cliente_nome_contato']."',
		razao_social='".$dados['cliente_nome']."',
		nome_fantasia='".$dados['cliente_nome']."',
		cnpj_cpf='".$dados['cliente_cnpj']."',
		email='".$dados['cliente_email']."',
		telefone1='".$dados['cliente_telefone1']."',
		telefone2='".$dados['cliente_telefone2']."',
		fax='".$dados['cliente_fax']."',
		cep='".$dados['cliente_cep']."',
		endereco='".$dados['cliente_endereco']."',
		bairro='".$dados['cliente_bairro']."',
		cidade='".$dados['cliente_cidade']."',
		estado='".$dados['cliente_estado']."'		
		$fim");
		//echo $t;
		if($dados['cliente_fornecedor_id']<=0){$cliente_fornecedor_id=mysql_insert_id();}else{$cliente_fornecedor_id=$dados['cliente_fornecedor_id'];}
		return $cliente_fornecedor_id; 
	
}

function manipula_revendedor($dados,$fornecedor_id,$cliente_vekttor_id){
				global $vkt_id;
				
				if(!$dados['revendedor_id']>0){
					$inicio = "INSERT INTO";$fim="";
				}else{
					$inicio = "UPDATE";$fim="WHERE id=".$dados['revendedor_id'];
				}
				$sql = mysql_query($t=" $inicio revenda_franquia SET 
					          					cliente_fornecedor_id = '$fornecedor_id',
												cliente_vekttor_id    = '$cliente_vekttor_id',
												vkt_id                = '$vkt_id',
												porcento_implantacao  = '".moedaBrToUsa($dados['porcento_implantacao'])."',
												porcento_mensalidade  = '".moedaBrToUsa($dados['porcento_mensalidade'])."',
												porcento_negociacao   = '".moedaBrToUsa($dados['porcento_negociacao'])."',
												contrato              = '".$dados['texto']."'
							  $fim
							  ");
							 //echo $t;
				mysql_query($sql);
				if(!$dados['revendedor_id']>0){return mysql_insert_id();}else{return $dados['revendedor_id'];}	
}

function cadastraPacoteRevenda($pacote_id,$revendedor_id){
	global $vkt_id;
	
	mysql_query($t="INSERT INTO revenda_franquia_pacote SET pacote_id=$pacote_id, vkt_id=$vkt_id, revendedor_id='$revendedor_id'");
	//echo $t."<br>";
}

/*function excluir_revendedor($id){
	
			$Delete = " DELETE FROM vendedor WHERE id = '$id' ";
}*/

?>