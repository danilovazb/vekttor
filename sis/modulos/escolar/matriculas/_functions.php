<?php

$tabela = "matriculas";


function AtualizarValor($campos){
		$sql = " UPDATE escolar_matriculas SET valor = '".moedaBrToUsa($campos['valor_matricula'])."' WHERE id = '$campos[matricula]' ";
		mysql_query($sql);
		//echo $sql;
		//print_r($campos);
}

// Controlador
function cadastra ($dados) {
	global $tabela,$vkt_id;
	$responsavel_id = manipulaResponsavel($dados,$vkt_id,$dados[responsavel_id]);
	if($responsavel_id>0){
		for($i=0;$i<$dados[alunos_a_ser_matriculados];$i++){
			$aluno_id = mantem_matricula ($responsavel_id,$dados,$i);
		}
	}
}

function converte_numeros_comvirgula_em_dias_semanas($dias,$semana_abreviado){
	
	$dias = explode(',',$dias );
	
	for($i=0;$i<count($dias);$i++){
		$dias_semana[] = $semana_abreviado[$dias[$i]];	
	}
	return implode(', ',$dias_semana);
}

function mantem_matricula($responsavel_id,$dados,$i){
	global $tabela,$vkt_id;
	if ( $dados[matricula_id][$i]>0 ){
		//echo "TEM MATRICULA ID";
		$acao = "UPDATE";
		$where = "WHERE id = '" . mysql_real_escape_string($dados['matricula_id'][$i]) . "'";
	} else {
		//echo "NAO TEM MATRICULA ID";
		$acao = "INSERT INTO";	
	}
	$aluno_id = cadastra_aluno ($responsavel_id,$dados,$i);
	mysql_query($t="
			$acao escolar_matriculas SET
			vkt_id			=	'$vkt_id',
			responsavel_id	=	'$responsavel_id',
			aluno_id		=	'$aluno_id',
			periodo_id		=	'".$dados[periodo_id][$i]."',
			escola_id		=	'".$dados[escola_id][$i]."',
			curso_id		=	'".$dados[curso_id][$i]."',
			modulo_id		=	'".$dados[modulo_id][$i]."',
			horario_id		=	'".$dados[horario_id][$i]."',
			sala_id			=	'".$dados[sala_id][$i]."',
			data_vencimento	=	'".dataBrToUsa($dados[data_vencimento][$i])."',
			pago			=	'".$dados[pago]."',
			tipo_matricula	=	'".$dados[tipo_matricula][$i]."',
			valor			=	'".$dados[valor][$i]."',
			data_criacao	=	now()
		 $where
	");
	echo mysql_error();
	//echo $t;
		
}

function cadastra_aluno ($responsavel_id,$dados,$i) {
	
	global $tabela,$vkt_id;
	
	$acao = "";
	$where = "";
	
	if ( $dados['aluno_id'][$i]>0 ){
		//echo "TEM ALUNO ID";
		$acao = "UPDATE";
		$where = "WHERE id = '" . mysql_real_escape_string($dados['aluno_id'][$i]) . "'";
	} else {
		//echo "NAO TEM ALUNO ID";
		$acao = "INSERT INTO";	
	}
	
	mysql_query ($ty="$acao escolar_alunos SET
	 vkt_id                 = '$vkt_id',
	 codigo_interno         = '".$dados['codigo_interno'][$i]."',
	 nome 					= '".$dados['nome'][$i]."',
	 data_nascimento		= '".dataBrToUsa($dados['data_nascimento'][$i])."',
	 endereco				= '".$dados['endereco'][$i]."',
	 bairro					= '".$dados['bairro'][$i]."',
	 escolaridade			= '".$dados['escolaridade'][$i]."',
	 profissao				= '".$dados['profissao'][$i]."',
	 complemento			= '".$dados['complemento'][$i]."',
	 telefone1				= '".$dados['telefone1'][$i]."',
	 telefone2				= '".$dados['telefone2'][$i]."',
	 cep					= '".$dados['cep'][$i]."',
	 cidade					= '".$dados['cidade'][$i]."',
	 uf						= '".$dados['uf'][$i]."',
	 rg						= '".$dados['rg'][$i]."',
	 rg_dt_expedicao		= '".dataBrToUsa($dados['rg_dt_expedicao'][$i])."',
	 cpf					= '".$dados['cpf'][$i]."',
	 email					= '".$dados['email'][$i]."',
	 senha					= '".$dados['senha'][$i]."',
	 responsavel_id         = '".$responsavel_id."'
	 
	 
	 $where");
	 //echo $ty;
	 
	  if($dados['aluno_id'][$i] > 0){
		 $aluno_id = $dados['aluno_id'][$i];
	 }else{
		$aluno_id = mysql_insert_id();
	 }
	 
	 
	 $extensao = getExtensao($_FILES['file']['name'][$i]);

	if($extensao!='php'){
		
		if(move_uploaded_file($_FILES['file']['tmp_name'][$i], "modulos/escolar/alunos_inscritos/img/".$aluno_id.".$extensao")){
			
			mysql_query($ql="UPDATE escolar_alunos set extensao = '$extensao' WHERE id = '$aluno_id' AND vkt_id='$vkt_id'");
		}
	}	
	return $aluno_id;
	//echo '<br/>aluno_id='.$aluno_id;
	
} /*fim*/

function manipulaResponsavel($dados,$vkt_id,$id){
	if($id==''){ $sql_in = " INSERT INTO "; $sql_fim="";}
	if($id>0){ $sql_in = " UPDATE "; $sql_fim = " WHERE id='$id'";}
	
	$responsaveis_duplicados = @mysql_result(mysql_query(" SELECT COUNT(*)  cliente_fornecedor WHERE vkt_id='$vkt_id' AND id<>'$id' AND cnpj_cpf='".$dados['f_cnpj_cpf']."'"),0,0);
	
	if($responsaveis_duplicados<1){
	mysql_query($t="$sql_in cliente_fornecedor SET 
						cliente_vekttor_id='$vkt_id',
						usuario_id='$usuario_id',
						razao_social='".$dados['f_nome_contato']."',
						tipo='Cliente',
						tipo_cadastro='".$dados['tipo_cadastro']."',
						nome_fantasia='".$dados['f_nome_contato']."',
						nome_contato='".$dados['f_nome_contato']."',
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
	//pr($_POST);
	//echo $t;
	if($id>0){
		$responsavel_id= $id;	
	}else{
		$responsavel_id=mysql_insert_id();	
	}
	
		return $responsavel_id;
	}else{
		return 0;	
	}
	//echo $t."<br>";
	//echo mysql_error();
}

function delete_matricula($matricula_id){
	/*
	1 verifia o reponsavel se tem mais de 1 aluno
		se tem nao deltea
		Se nao, deleta o responsavel
		
	2 deleta o aluno
	3 deleta a Matricula
	

	*/
	global $vkt_id;
	$matricula = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_matriculas WHERE vkt_id='$vkt_id' AND id='$matricula_id'"));
	//echo $t."<br>";
	$q_alunos = @mysql_result(mysql_query($t=" SELECT   COUNT(*)  FROM escolar_matriculas WHERE responsavel_id = '$matricula->responsavel_id' AND id<>'$matricula->id' "),0,0);
	//echo $t."<br>";
	/*if($q_alunos<1){
		mysql_query($t="DELETE FROM cliente_fornecedor WHERE id='$matricula->responsavel_id'");
	//echo $t."<br>";
	}
	
	mysql_query($t="DELETE FROM escolar_alunos WHERE id='$matricula->aluno_id'");
	//echo $t."<br>";
	
	//echo $t."<br>";
	*/
	mysql_query($t="DELETE FROM escolar_matriculas WHERE id='$matricula->id'");
}




?>