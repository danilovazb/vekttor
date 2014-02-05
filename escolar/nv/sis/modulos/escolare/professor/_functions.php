<?
//Cadastar/Altera na tabela usuários
function ManipulaUsuario($dados){
	global $vkt_id;
	$erro=0;
	if($nome!=""){
		$nome=limitaTexto($nome,255);
	};
	//if(!validaNumero($usuario_tipo_id))$erro=1;
	//if(!validaNumero($obra_id))$erro=1;
	
	$login=limitaTexto($login,45);
	$senha=limitaTexto($senha,45);
	
	//verifica se usuário já existe com base no cpf
	$cpf=mysql_fetch_object(mysql_query($t="SELECT * FROM 
										cliente_fornecedor cf 
										INNER JOIN usuario u ON cf.usuario_id=u.id
										WHERE cf.cnpj_cpf='".$dados['f_cnpj_cpf']."' 																												                                        AND cf.cliente_vekttor_id='$vkt_id'"));
	
	if($erro==0){
				
		if(empty($cpf)){
			//verifica se já existe usuário com login e senha digitados
			$login = mysql_fetch_object(mysql_query($t="SELECT * FROM usuario WHERE login='{$dados['login']}' AND   senha='{$dados['senha']}'"));
			$inicio="INSERT INTO";$fim="";
		}else{
			$inicio="UPDATE";$fim=" WHERE id='{$dados['usuario']}'";
		}//$cpf
		
		if(empty($login)){	
			mysql_query($t="
				$inicio
				 usuario SET
				nome='".$dados['f_nome_contato']."',
				cliente_vekttor_id ='$vkt_id',
				usuario_tipo_id='".$dados['usuario_tipo']."',
				obra_id='".$dados['obra']."',
				login='".$dados['login']."',
				senha='".$dados['senha']."'
				$fim
				");
		}else{
			alert("Digite outro login e senha!");
			return -1;
		}//$login
		
		if(empty($dados['usuario'])){
			return mysql_insert_id();
		}else{
			return $dados['usuario'];
		}//$dados['usuario']
	
	}//$erro
}

//Cadastar/Altera na tabela Cliente_Fornecedor
function manipulaFornecedor($dados,$idusuario){
	global $vkt_id;
	//verifica se o cpf já está cadastrado
	$cpf=mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor
										WHERE cnpj_cpf='".$dados['f_cnpj_cpf']."' 																												                                        AND cliente_vekttor_id='$vkt_id' ORDER BY id DESC LIMIT 1"));
	//echo $t."<br>";
	if(empty($cpf)){ $sql_in = " INSERT INTO "; $sql_fim="";}
	else if(!empty($cpf)){ $sql_in = "UPDATE"; $sql_fim = "WHERE id='$cpf->id'";}
												
	mysql_query($t="$sql_in cliente_fornecedor SET 
		cliente_vekttor_id='$vkt_id',
		usuario_id='$idusuario',
		tipo='Cliente',
		tipo_cadastro='Físico',
		nome_contato='".$dados['f_nome_contato']."',
		razao_social='".$dados['f_nome_contato']."',
		nome_fantasia='".$dados['f_nome_contato']."',
		ramo_atividade='".$dados['f_ramo_atividade']."',
		nascimento='".DataBrToUsa($dados['f_nascimento'])."',
		estado_civil='".$dados['f_estado_civil']."',
		naturalidade='".$dados['f_naturalidade']."',
		nacionalidade='".$dados['f_nacionalidade']."',
		cnpj_cpf='".$dados['f_cnpj_cpf']."',
		rg='".$dados['f_rg']."',
		local_emissao='".$dados['f_local_emissao']."',
		data_emissao='".DataBrToUsa($dados['f_data_emissao'])."',
		email='".$dados['f_email']."',
		telefone1='".$dados['f_telefone1']."',
		telefone2='".$dados['f_telefone2']."',
		fax='".$dados['f_fax']."',
		cep='".$dados['f_cep']."',
		endereco='".$dados['f_endereco']."',
		bairro='".$dados['f_bairro']."',
		cidade='".$dados['f_cidade']."',
		estado='".$dados['f_estado']."',
		grau_instrucao='".$dados['f_grau_instrucao']."'
		$sql_fim
	");
	
	if(empty($cpf)){
		return mysql_insert_id();
	}else{
		return $cpf->id;
	}
}

//Cadastar/Altera na tabela escolar_professor
function ManipulaProfessor($idfornecedor,$idusuario,$id,$dados){
	global $vkt_id;
	
	$cpf=mysql_fetch_object(mysql_query($t="SELECT *,p.id as p_id,p.status as status FROM escolar_professor p 
										INNER JOIN cliente_fornecedor cf ON p.cliente_fornecedor_id=cf.id
										WHERE cf.cnpj_cpf='".$dados['f_cnpj_cpf']."' 																												                                        AND cf.cliente_vekttor_id='$vkt_id'"));
	//echo $t;
	if(!empty($cpf)){
		$inicio="UPDATE";$fim="WHERE id='$cpf->p_id'";
	}else{
		$inicio="INSERT INTO";$fim="";
	}
		
	mysql_query($t="$inicio escolar_professor 
		SET	vkt_id='$vkt_id',
		usuario_id='$idusuario',
		cliente_fornecedor_id='$idfornecedor',
		status='1'
		$fim"
	);
	//echo $t;

		
}
function AtualizaProfessor($dados,$status,$id){
	
	mysql_query($t="DELETE FROM usuario WHERE id='{$dados[usuario]}'");
	
	mysql_query($t="UPDATE escolar_professor set status='$status' WHERE id='$id'");
	
}

function verificaCPF($cpf){
	global $vkt_id;
	
	$pessoa=mysql_fetch_object(mysql_query($t="SELECT *,id as f_id FROM cliente_fornecedor WHERE cnpj_cpf='$cpf' AND cliente_vekttor_id=$vkt_id ORDER BY id DESC LIMIT                                            1"));
	
	if(!empty($pessoa)){
		return $pessoa;
	}else{
		return 0;
	}
}
?>  