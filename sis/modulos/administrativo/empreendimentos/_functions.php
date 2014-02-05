<?

//Empreendimento

function exibe_option_sub_plano_ou_centro($plano_ou_centro,$pai_id,$id_do_selecionado,$nivel,$pai_ordem=null){
  $pai = mysql_fetch_object(mysql_query("SELECT * FROM financeiro_centro_custo WHERE id='$pai_id'"));
  
  $q= mysql_query($r="SELECT * FROM 
  							financeiro_centro_custo 
						WHERE 
							cliente_id ='".$_SESSION[usuario]->cliente_vekttor_id ."' 
						AND 
							plano_ou_centro='$plano_ou_centro'  
						AND  
							centro_custo_id = '$pai_id'  
						ORDER BY ordem,nome");
	$nivel++;
  if(strlen($pai_ordem)>0){
  	$pai_ordem = $pai_ordem.'.'.$pai->ordem;
  }else{
  	$pai_ordem = $pai->ordem;
  }
  while($r= mysql_fetch_object($q)){
	$filhos = @mysql_result(mysql_query("SELECT count(*) FROM 
  							financeiro_centro_custo 
						WHERE 
							cliente_id ='".$_SESSION['usuario']->cliente_vekttor_id."' 
						AND 
							plano_ou_centro='$plano_ou_centro'  
						AND  
							centro_custo_id = '$r->id'  
						"),0,0);
	if($id_do_selecionado==$r->id){
		$sel='selected="selected"';
	}else{
		$sel='';
	}
	if($filhos>0){
		$sel = $sel.' disabled="disabled" ';
	}
	if(strlen($pai_ordem)>0){
		$paiordem= "$pai_ordem.$r->ordem";
	}else{
		$paiordem= "$r->ordem";
	}
	echo  "<option $sel style=\"padding-left:".($nivel*10)."px\" value='$r->id'>$paiordem $r->nome</option>";
	if($filhos>0){
		exibe_option_sub_plano_ou_centro($plano_ou_centro,$r->id,$id_do_selecionado,$nivel,$pai_ordem);
	}
  }
}
function cadastraEmpreendimento($dados,$vkt_id){
	
	$inicio=validaDataUsa($dados['inicio']);
	$fim=validaDataUsa($dados['fim']);
	$obs=limitaTexto($dados['obs'],255);
	$orcamento = moedaBrToUsa($dados['orcamento']);

	if(mysql_query($t="
				INSERT INTO empreendimento SET
				nome='".$dados['nome']."',
				razao_social='".$dados['razao_social']."',
				cnpj='".$dados['cnpj']."',
				logradouro='".$dados['logradouro']."',
				bairro='".$dados['bairro']."',
				cidade='".$dados['cidade']."',
				estado='".$dados['estado']."',
				complemento='".$dados['complemento']."',
				tipo='Empreendimento',
				orcamento='".$orcamento."',
				inicio='".$inicio."',
				fim='".$fim."',
				administrador='".$dados['administrador']."',	
				administrador_naturalidade='".$dados['administrador_naturalidade']."',
				administrador_profissao='".$dados['administrador_profissao']."',
				administrador_estado_civil='".$dados['administrador_estado_civil']."',
				administrador_rg='".$dados['administrador_rg']."',
				administrador_orgao_expedidor='".$dados['administrador_orgao_expedidor']."',
				administrador_cpf='".$dados['administrador_cpf']."',
				administrador_endereco='".$dados['administrador_endereco']."',
				administrador_bairro='".$dados['administrador_bairro']."',
				administrador_cidade='".$dados['administrador_cidade']."',
				administrador_estado='".$dados['administrador_estado']."',
				obs='".$obs."',
				vkt_id='".$vkt_id."'
				")){
		salvaUsuarioHistorico("Formulário - Empreendimento",'cadastrou','empreendimento',mysql_insert_id());
		return 1;
	}
	//echo $t.mysql_error();	
	return 0;
}



function alteraEmpreendimento($id,$dados){
	
	if($dados['nome']!=""){
		$nome=limitaTexto($dados['nome'],255);
	}else return 0;
	$inicio=validaDataUsa($dados['inicio']);
	$fim=validaDataUsa($dados['fim']);
	$obs=limitaTexto($dados['obs'],255);
	$orcamento = moedaBrToUsa($dados['orcamento']);
	//echo "Tipo".$dados['tipo'];
	if(mysql_query($trace="
				UPDATE empreendimento SET
				nome='".$dados['nome']."',
				razao_social='".$dados['razao_social']."',
				cnpj='".$dados['cnpj']."',
				logradouro='".$dados['logradouro']."',
				bairro='".$dados['bairro']."',
				cidade='".$dados['cidade']."',
				estado='".$dados['estado']."',
				complemento='".$dados['complemento']."',
				tipo='Empreendimento',
				orcamento='".$orcamento."',
				inicio='".$inicio."',
				fim='".$fim."',
				administrador='".$dados['administrador']."',	
				administrador_naturalidade='".$dados['administrador_naturalidade']."',
				administrador_profissao='".$dados['administrador_profissao']."',
				administrador_estado_civil='".$dados['administrador_estado_civil']."',
				administrador_rg='".$dados['administrador_rg']."',
				administrador_orgao_expedidor='".$dados['administrador_orgao_expedidor']."',
				administrador_cpf='".$dados['administrador_cpf']."',
				administrador_endereco='".$dados['administrador_endereco']."',
				administrador_bairro='".$dados['administrador_bairro']."',
				administrador_cidade='".$dados['administrador_cidade']."',
				administrador_estado='".$dados['administrador_estado']."',
				obs='".$obs."'
				WHERE
				id='".$id."'
				")){
		//echo $trace.mysql_error();
		salvaUsuarioHistorico("Formulário - Empreendimento",'alterou','empreendimento',$id);
		return 1;
	}
	
	return 0;
}

function excluiEmpreendimento($id){
	
	$negociacao=mysql_fetch_object(mysql_query("SELECT * FROM negociacao WHERE empreendimento_id='".$id."' LIMIT 1"));
	if($negociacao->id>0)return 0;
	$disponibilidade=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade WHERE empreendimento_id='".$id."' LIMIT 1"));
	if($disponibilidade->id>0)return 0;
	
	if($id>0){
		salvaUsuarioHistorico("Formulário - Empreendimento",'deletou','empreendimento',$id);
		mysql_query("
					DELETE FROM empreendimento
					WHERE id='".$id."'
					");

		return 1;
	}
	
	return 0;
}
?>