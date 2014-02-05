<?


function cadastraUsuario($dados){
	global $vkt_id;
	if($dados['usuario_id']>0){
		
		//echo " user aqui 1 ";
		
		$sql_inicio=" UPDATE ";
		$sql_fim=" WHERE id='{$dados['id']}' ";
		$ja_existe=mysql_result(mysql_query("SELECT COUNT(*) FROM usuario WHERE cliente_vekttor_id='$vkt_id' AND login='{$dados['login']}' "),0);
		
		if($ja_existe>0&&$dados['login']!=$dados['login_antigo']){
			alert("Login já existente, selecione outro");
			return 0;
		}
		
		$id=$dados['usuario_id'];
		$funcao_retorna_id=" $usuario_id = $id ";
		
	}else{
		//echo " user aqui 2 ";
		$ja_existe=mysql_result(mysql_query("SELECT COUNT(*) FROM usuario WHERE cliente_vekttor_id='$vkt_id' AND login='{$dados['login']}' "),0);
		
		if($ja_existe>0){
			alert("Login já existente, selecione outro");
			return 0;
		}
		if(strlen(trim($dados['login']))>0 && strlen(trim($dados['senha']))>1 ){
			$sql_inicio="INSERT INTO";
			$funcao_retorna_id="$usuario_id = mysql_insert_id()";	
		}else{
			return 0;
		}
		
	}
	$sql=mysql_query($a=" $sql_inicio usuario SET cliente_vekttor_id='$vkt_id', nome='{$dados['nome']}', usuario_tipo_id='{$dados['usuario_tipo_id']}', login='{$dados['login']}', senha='{$dados['senha']}' $sql_fim");
	
	if($dados['usuario_id']>0){
		$usuario_id=$dados['usuario_id'];
	}else{
		$usuario_id=mysql_insert_id();
	}
	
	
	return $usuario_id;
}

function cadastraFuncionario($dados){
	global $vkt_id;
	if($dados['funcionario_id']>0){
		$sql_inicio_professor=" UPDATE ";
		$sql_fim_professor="WHERE id='{$dados['funcionario_id']}'";
	}else{
		$sql_inicio_professor="INSERT INTO"; 
	}
	
	$usuario_id=cadastraUsuario($dados);
	
	$sql=" $sql_inicio_professor rh_funcionario SET 
		vkt_id='$vkt_id', 
		usuario_id='$usuario_id', 
		unidade_id='{$dados['escola_id']}', 
		nome='{$dados['nome']}', 
		cpf='{$dados['cpf']}', 
		data_nascimento='".dataBrToUsa($dados['data_nascimento'])."', 
		rg='{$dados['rg']}', 
		rg_orgao_emissor='{$dados['rg_orgao_emissor']}', 
		rg_data_emissao='".dataBrToUsa($dados['rg_data_emissao'])."', 
		grau_instrucao = '{$dados['grau_instrucao']}', 
		estado_civil = '{$dados['estado_civil']}', 
		naturalidade = '{$dados['naturalidade']}', 
		nacionalidade = '{$dados['nacionalidade']}', 
		salario='".moedaBrToUsa($dados['salario'])."', 
		email='{$dados['email']}', 
		cargo_id = '{$dados['cargo_id']}', 
		telefone1 = '{$dados['telefone1']}', 
		telefone2 = '{$dados['telefone2']}', 
		cep = '{$dados['cep']}', 
		endereco = '{$dados['endereco']}', 
		bairro = '{$dados['bairro']}', 
		cidade = '{$dados['cidade']}', 
		estado = '{$dados['estado']}', 
		data_admissao='".dataBrToUsa($dados['data_admissao'])."', 
		data_termino_contrato='".dataBrToUsa($dados['data_termino_contrato'])."' 
		$sql_fim_professor";
		
	mysql_query($sql);

	//if(mysql_query($sql)){
			
			if($dados["funcionario_id"] > 0)
				$funcionario_id=$dados["funcionario_id"];
			else 
				$funcionario_id=mysql_insert_id();
		
		if($dados["eh_professor"]> 0 ){
			
			
			if($dados['professor_id'] > 0){
				$professor_id=$dados['professor_id'];
				mysql_query($pup=" UPDATE  escolar2_professores SET vkt_id='$vkt_id', funcionario_id='$funcionario_id', usuario_id='$usuario_id' WHERE id =  '$professor_id' ");
				//echo $pup;
			}else{
				
				mysql_query($oi="INSERT INTO  escolar2_professores SET vkt_id='$vkt_id', funcionario_id='$funcionario_id', usuario_id='$usuario_id' ");
				$professor_id=mysql_insert_id();
				//echo $oi;
				
			}
			mysql_query("DELETE FROM escolar2_unidade_has_professor_horario WHERE vkt_id='$vkt_id' AND professor_id='$professor_id' ");
			foreach($dados['horario_escola'] as $v){
				$v=explode('_',$v);
				if($v[1]!=''){
					mysql_query("INSERT INTO escolar2_unidade_has_professor_horario SET vkt_id='$vkt_id', professor_id='$professor_id', horario_id='{$v[0]}', unidade_id='{$v[1]}' ");	
				}
			}
		}
	//}
	
}/* Fim da Funcao */

function deletaFuncionario($professor_id,$usuario_id,$funcionario_id){
	global $vkt_id;
	if($professor_id>0){
		mysql_query("DELETE FROM escolar2_professores WHERE vkt_id='$vkt_id' AND id='$professor_id'");
	}
	if($usuario_id>0){
		mysql_query("DELETE FROM usuario WHERE cliente_vekttor_id='$vkt_id' AND id='$usuario_id'");
	}
	if($funcionario_id>0){
		mysql_query("DELETE FROM rh_funcionario WHERE vkt_id='$vkt_id' AND id='$funcionario_id'");
	}
}