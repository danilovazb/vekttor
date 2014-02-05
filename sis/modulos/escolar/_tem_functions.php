<?
function cadastra_aluno ($responsavel_id,$dados,$i) {
	
	global $tabela;
	$vkt_id=7;
	$acao = "";
	$where = "";
	
	if ( $dados['aluno_id'][$i]>0 ){
		$acao = "UPDATE";
		$where = "WHERE id = '" . mysql_real_escape_string($dados['aluno_id'][$i]) . "'";
	} else {
		$acao = "INSERT INTO";	
	}
	
	mysql_query ($ty="$acao escolar_alunos SET
	 vkt_id                 = '$vkt_id',
	 cor                    = '".$dados['cor'][$i]."',
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
	 
	 turma                  = '".$dados['turma'][$i]."',
	 turno                  = '".$dados['turno'][$i]."',
	 responsavel_id         = '".$responsavel_id."',
	 
	 mae                    = '".$dados['mae'][$i]."',
	 cpf_mae                = '".$dados['cpf_mae'][$i]."',
	 tel_mae                = '".$dados['telefone_mae'][$i]."',
	 profissao_mae          = '".$dados['profissao_mae'][$i]."',
	 local_trabalho_mae     = '".$dados['local_trabalho_mae'][$i]."',
	 tel_trabalho_mae       = '".$dados['tel_trabalho_mae'][$i]."',
	 email_mae              = '".$dados['email_mae'][$i]."',
	 
	 pai                    = '".$dados['pai'][$i]."',
	 cpf_pai                = '".$dados['cpf_pai'][$i]."',
	 tel_pai                = '".$dados['telefone_pai'][$i]."',
	 profissao_pai          = '".$dados['profissao_pai'][$i]."',
	 local_trabalho_pai     = '".$dados['local_trabalho_pai'][$i]."',
	 tel_trabalho_pai       = '".$dados['tel_trabalho_pai'][$i]."',
	 email_pai              = '".$dados['email_pai'][$i]."',
	 
	 pessoa_trazer_buscar_1 = '".$dados['pessoa_trazer_buscar_1'][$i]."',
	 pessoa_trazer_buscar_2 = '".$dados['pessoa_trazer_buscar_2'][$i]."',
	 pessoa_trazer_buscar_3 = '".$dados['pessoa_trazer_buscar_3'][$i]."',
	 pessoa_trazer_buscar_4 = '".$dados['pessoa_trazer_buscar_4'][$i]."',
	 
	 pessoa_caso_emergencia_1 = '".$dados['pessoa_emergencia_1'][$i]."',
	 telefone_caso_emergencia_1  = '".$dados['fone_emergencia_1'][$i]."',
	 
	 pessoa_caso_emergencia_2   = '".$dados['pessoa_emergencia_2'][$i]."',
	 telefone_caso_emergencia_2 = '".$dados['fone_emergencia_2'][$i]."',
	 restricao_alimentar        = '".$dados['restricao_alimentar'][$i]."'
	 
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
	//echo '<br/>'.$aluno_id;
	
} /*fim*/


function manipulaResponsavel($dados,$vkt_id,$id){
	//520.597.402-82
	//12345678901234
	
	$infor = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id ='$vkt_id' AND cnpj_cpf='{$dados['f_cnpj_cpf']}'"));
	if($infor->id>0){
		$id=$infor->id;
	}
	  
	  
	  
	if($id==''){ $sql_in = " INSERT INTO "; $sql_fim="";}
	if($id>0){ $sql_in = " UPDATE "; $sql_fim = " WHERE id='$id'";}

	$responsaveis_duplicados = @mysql_result(mysql_query(" SELECT count(*)  cliente_fornecedor WHERE cliente_vekttor_id ='$vkt_id' AND id<>'$id' AND cnpj_cpf='".$dados['f_cnpj_cpf']."'"),0,0);
	
	if($responsaveis_duplicados<1){
	mysql_query($t="$sql_in cliente_fornecedor SET 
						cliente_vekttor_id='$vkt_id',
						usuario_id='$usuario_id',
						razao_social='".$dados['f_nome_contato']."',
						tipo='Cliente',
						tipo_cadastro='Físico',
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



function mantem_matricula($responsavel_id,$dados,$i){
	global $tabela;
	$vkt_id=7;

	
	if ( $dados[matricula_id][$i]>0 ){
		$acao = "UPDATE";
		$where = "WHERE id = '" . mysql_real_escape_string($dados['matricula_id'][$i]) . "'";
	} else {
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
			pago			=	'S',
			tipo_matricula	=	'".$dados[tipo_matricula][$i]."',
			valor			=	'".$dados[valor][$i]."',
			data_criacao	=	'".$dados[data_criacao][$i]."'

		 $where
				
	");
		
}

?>



