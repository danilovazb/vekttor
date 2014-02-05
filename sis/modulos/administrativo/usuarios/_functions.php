<?
//Funчѕes 

//Funчуo para verificar se jс existe o usuсrio e senha digitado pelo usuсrio
function verifica_usuario($usuario,$senha){

	$usuario = mysql_fetch_object(mysql_query("SELECT * FROM usuario WHERE login='$usuario' AND senha='$senha'"));
	
	return $usuario->id;
}

//Usuсrio
function cadastraUsuario($nome,$usuario_tipo_id,$obra_id,$login,$senha){
	global $vkt_id;
	$erro=0;
	if($nome!=""){
		$nome=limitaTexto($nome,255);
	}else return 0;
	if(!validaNumero($usuario_tipo_id))$erro=1;
	if(!validaNumero($obra_id))$erro=1;
	$login=limitaTexto($login,45);
	$senha=limitaTexto($senha,45);
	
	
	$existe_usuario = verifica_usuario($login,$senha);
	
	if(!$existe_usuario>0){	
		if($erro==0){
			mysql_query("
					INSERT INTO usuario SET
					nome='".$nome."',
					cliente_vekttor_id ='$vkt_id',
					usuario_tipo_id='".$usuario_tipo_id."',
					obra_id='".$obra_id."',
					login='".$login."',
					senha='".$senha."'
					");
			return 1;
		}
	}else{
		alert("Login e senha nуo podem ser cadastrados, Por favor Digite outro login e senha");
	}
	
	return 0;
}

function alteraUsuario($id,$nome,$usuario_tipo_id,$obra_id,$login,$senha){
	global $vkt_id;
	global $usuario_id;
	
	$existe_usuario = verifica_usuario($login,$senha);
	
	if(!$existe_usuario>0||$existe_usuario==$usuario_id){
		$erro=0;
		if($nome!=""){
			$nome=limitaTexto($nome,255);
		}else return 0;
		if(!validaNumero($usuario_tipo_id))$erro=1;
		if(!validaNumero($obra_id))$erro=1;
		$login=limitaTexto($login,45);
		$senha=limitaTexto($senha,45);
		
		if($erro==0){
			mysql_query($trace="
					UPDATE usuario SET
					nome='".$nome."',
					usuario_tipo_id='".$usuario_tipo_id."',
					cliente_vekttor_id ='$vkt_id',
					obra_id='".$obra_id."',
					login='".$login."',
					senha='".$senha."'
					WHERE
					id='".$id."'
					");
			return 1;
		}
	}else{
		alert("Login e senha nуo podem ser cadastrados, Por favor Digite outro login e senha");
	}
	
		return 0;
}

function excluiUsuario($id){
	
	//if($reserva->id>0) return 0;
	if($id>0){
		mysql_query("
					DELETE FROM usuario
					WHERE id='".$id."'
					");
					
		return 1;
	}
	
	return 0;
}

?>