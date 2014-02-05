<?
//Funções 
function verifica_usuario($usuario,$senha){

	$usuario = mysql_fetch_object(mysql_query("SELECT * FROM usuario WHERE login='$usuario' AND senha='$senha'"));
	
	return $usuario->id;
}


//Cadastra Cliente
function ManipulaUsuario($dados){
	
	global $usuario_id;
	
	$existe_usuario = verifica_usuario($dados['usuario'],$dados['senha']);
	
	if(!$existe_usuario>0||$existe_usuario==$usuario_id){
		mysql_query($t="UPDATE usuario SET senha='$dados[senha]', tela_inicial='$dados[tela_inicial_id]' WHERE id='$dados[id_usuario]'");
	}else{
		alert("Login e senha não podem ser cadastrados, Por favor Digite outro login e senha");
	}
}
?>