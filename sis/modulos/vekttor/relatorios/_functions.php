<?
//Funções 

//Cadastra Cliente
function ManipulaCliente($dados,$cliente_vekttor_id,$modulo_id){
	if($cliente_vekttor_id<=0){$inicio ="INSERT INTO";$data=',data_cadastro="'.date('Y-m-d').'"';}else{$inicio ="UPDATE";$data='';}
	if($cliente_vekttor_id<=0){$fim="";}else{$fim = "WHERE id='".$cliente_vekttor_id."'";}
	
	$query = mysql_query($t="$inicio clientes_vekttor  SET nome='".$dados['cliente_nome']."', nome_fantasia='".$dados['cliente_nome_fantasia']."',
	cnpj='".$dados['cliente_cnpj']."', cep='".$dados['cliente_cep']."', endereco='".$dados['cliente_endereco']."', bairro='".$dados['cliente_bairro']."',
	cidade='".$dados['cliente_cidade']."', estado='".$dados['cliente_estado']."', status=1 $data $fim"); 
	//echo $t."<br>";
	
	if($cliente_vekttor_id==0){
		$aux=1;
		$cliente_vekttor_id=mysql_insert_id();
	}
	
	//echo "Foto: ".$_FILES['foto']['name'];
	if(strlen($_FILES['foto']['name'])>3){
		logomarca_envia_arquivo($cliente_vekttor_id);
	}
	
	$tipo=ManipulaTipo($dados['nome_tipo_usuario'],$cliente_vekttor_id,$aux,$dados['id_tipo']);
	//echo "Tipo: ".$tipo."<br>"; 
	ManipulaUsuario($dados['nome_usuario'],$dados['login_usuario'],$dados['senha_usuario'],$cliente_vekttor_id,$tipo,$dados['id_usuario'],$aux);
	
	// Limpa Tabela
	mysql_query("DELETE FROM usuario_tipo_modulo WHERE usuario_tipo_id='$tipo'");

	for($i=0;$i<count($modulo_id);$i++){
		cadastraUsuarioTipoModulo($modulo_id[$i],$tipo);
	}
}

//Exclui cliente
function ExcluiCliente($dados){
	mysql_query("DELETE FROM clientes_vekttor WHERE id='".$dados['cliente_id']."'");
	mysql_query("DELETE FROM usuario_tipo WHERE id='".$dados['id_tipo']."'");
	mysql_query("DELETE FROM usuario WHERE id='".$dados['id_usuario']."'");
}

function ManipulaTipo($nome,$cliente_vekttor_id,$aux,$tipo_id){
	if(empty($tipo_id)){$inicio="INSERT INTO";}else{$inicio ="UPDATE";}
	if(empty($tipo_id)){$fim="";}else{$fim = "WHERE vkt_id='$cliente_vekttor_id' AND id='$tipo_id'";}
	$query=mysql_query($t="$inicio usuario_tipo SET nome='$nome',vkt_id='$cliente_vekttor_id' $fim");	
	//echo $t."<br>";
	if(empty($tipo_id)){
		return mysql_insert_id();
	}else{
		return $tipo_id;
	}
}

function ManipulaUsuario($nome,$login,$senha,$cliente_vekttor_id,$tipo_id,$id_usuario,$aux){
	if($aux==1){$inicio="INSERT INTO";}else{$inicio ="UPDATE";}
	if($aux==1){$fim="";}else{$fim = "WHERE id='$id_usuario'";}
	$query = mysql_query($t="$inicio usuario SET nome='$nome',login='$login',senha='$senha',usuario_tipo_id='$tipo_id',cliente_vekttor_id='$cliente_vekttor_id'  $fim");
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
function cadastraUsuarioTipoModulo($modulo_id,$usuario_tipo_id){
	//echo "Chamou Funcao cadastraUsuarioTipoModulo";
	//$erro=0;
	
	//if(!validaNumero($modulo_id))$erro=1;
	//if(!validaNumero($usuario_tipo_id))$erro=1;
	
	//if($erro==0&&$modulo_id>0&&$usuario_tipo_id>0){
		
	mysql_query($trace="
				INSERT INTO usuario_tipo_modulo SET
				modulo_id='".$modulo_id."',
				usuario_tipo_id='".$usuario_tipo_id."'
			");
	//	echo $trace;
				
		//return 1;
	//}
	return 0;
}
?>