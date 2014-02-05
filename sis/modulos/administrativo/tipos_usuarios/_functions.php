<?


//Tipo de Usuário
function cadastraUsuarioTipo($nome,$modulo_id){
	global $vkt_id;
	if($nome!=""){
		$nome=limitaTexto($nome,20);
	}else return 0;
	
	mysql_query("
				INSERT INTO usuario_tipo SET
				nome='".$nome."',
				vkt_id= '$vkt_id'
				");
				
	$usuario_tipo_id = mysql_insert_id();
	
	for($i=0;$i<count($modulo_id);$i++){
		cadastraUsuarioTipoModulo($modulo_id[$i],$usuario_tipo_id);
	}
	
				
	return 1;
}

function alteraUsuarioTipo($id,$nome,$modulo_id){
	global $vkt_id;
	if($nome!=""){
		$nome=limitaTexto($nome,255);
	}else return 0;
	
	if(mysql_query($trace="
				UPDATE usuario_tipo SET
				nome='".$nome."',
				vkt_id='$vkt_id'
				WHERE
				id='".$id."'
				")){
		mysql_query("DELETE FROM usuario_tipo_modulo WHERE usuario_tipo_id='$id'");
		for($i=0;$i<count($modulo_id);$i++){
			cadastraUsuarioTipoModulo($modulo_id[$i],$id);
		}
		return 1;
	}else{
		return 0;
	}
	return 0;
}

function excluiUsuarioTipo($id){
	
	$usuario_tipo=mysql_fetch_object(mysql_query("SELECT * FROM usuario WHERE usuario_tipo_id='".$id."' LIMIT 1"));
	if($usuario_tipo->id>0) return 0;
	if($id>0){
		mysql_query($trace="DELETE FROM usuario_tipo_modulo WHERE usuario_tipo_id='$id'");
		mysql_query($trace="
					DELETE FROM usuario_tipo
					WHERE id='".$id."'
					");
		//echo $trace;
		return 1;
	}
	
	return 0;
}

//Usuário Tipo com Módulos
function cadastraUsuarioTipoModulo($modulo_id,$usuario_tipo_id){
	
	$erro=0;
	
	if(!validaNumero($modulo_id))$erro=1;
	if(!validaNumero($usuario_tipo_id))$erro=1;
	
	if($erro==0&&$modulo_id>0&&$usuario_tipo_id>0){
		mysql_query($trace="
					INSERT INTO usuario_tipo_modulo SET
					modulo_id='".$modulo_id."',
					usuario_tipo_id='".$usuario_tipo_id."'
					");
		//echo $trace;
				
		return 1;
	}
	return 0;
}


?>