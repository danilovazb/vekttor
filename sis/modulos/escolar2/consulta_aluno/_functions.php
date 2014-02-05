<?php

$tabela = "escolar2_alunos";

// Controlador

function cadastra () {
	
	global $tabela,$vkt_id;
	
	$acao = "";
	$where = "";
	
	if (!empty($_POST['aluno_id']) ){
		$acao = "UPDATE";
		$where = "WHERE id = '" . mysql_real_escape_string($_POST['aluno_id']) . "'";
	} else {
		$acao = "INSERT INTO";	
	}
	
	mysql_query ($ty="$acao $tabela SET
	 vkt_id                 = '$vkt_id',
	 cor                    = '{$_POST['cor']}',
	 codigo_interno         = '{$_POST['codigo_interno']}',
	 nome 					= '{$_POST['nome']}',
	 data_nascimento		= '".dataBrToUsa($_POST['data_nascimento'])."',
	 endereco				= '{$_POST['endereco']}',
	 bairro					= '{$_POST['bairro']}',
	 escolaridade			= '{$_POST['escolaridade']}',
	 profissao				= '{$_POST['profissao']}',
	 complemento			= '{$_POST['complemento']}',
	 telefone1				= '{$_POST['telefone1']}',
	 telefone2				= '{$_POST['telefone2']}',
	 cep					= '{$_POST['cep']}',
	 cidade					= '{$_POST['cidade']}',
	 uf						= '{$_POST['uf']}',
	 rg						= '{$_POST['rg']}',
	 rg_dt_expedicao		= '{$_POST['rg_dt_expedicao']}',
	 cpf					= '{$_POST['cpf']}',
	 email					= '{$_POST['email']}',
	 
	 turma                  = '{$_POST['turma']}',
	 turno                  = '{$_POST['turno']}',
	 responsavel_id         = '{$_POST['responsavel_id']}',
	 
	 mae                    = '{$_POST['mae']}',
	 cpf_mae                = '{$_POST['cpf_mae']}',
	 tel_mae                = '{$_POST['telefone_mae']}',
	 profissao_mae          = '{$_POST['profissao_mae']}',
	 local_trabalho_mae     = '{$_POST['local_trabalho_mae']}',
	 tel_trabalho_mae       = '{$_POST['tel_trabalho_mae']}',
	 email_mae              = '{$_POST['email_mae']}',
	 
	 pai                    = '{$_POST['pai']}',
	 cpf_pai                = '{$_POST['cpf_pai']}',
	 tel_pai                = '{$_POST['telefone_pai']}',
	 profissao_pai          = '{$_POST['profissao_pai']}',
	 local_trabalho_pai     = '{$_POST['local_trabalho_pai']}',
	 tel_trabalho_pai       = '{$_POST['tel_trabalho_pai']}',
	 email_pai              = '{$_POST['email_pai']}',
	 
	 pessoa_trazer_buscar_1 = '{$_POST['pessoa_trazer_buscar_1']}',
	 pessoa_trazer_buscar_2 = '{$_POST['pessoa_trazer_buscar_2']}',
	 pessoa_trazer_buscar_3 = '{$_POST['pessoa_trazer_buscar_3']}',
	 pessoa_trazer_buscar_4 = '{$_POST['pessoa_trazer_buscar_4']}',
	 
	 pessoa_caso_emergencia_1 = '{$_POST['pessoa_emergencia_1']}',
	 telefone_caso_emergencia_1  = '{$_POST['fone_emergencia_1']}',
	 
	 pessoa_caso_emergencia_2   = '{$_POST['pessoa_emergencia_2']}',
	 telefone_caso_emergencia_2 = '{$_POST['fone_emergencia_2']}',
	 restricao_alimentar        = '{$_POST['restricao_alimentar']}',
	 senha	 					= '{$_POST['senha']}',
	 observacao                 = '{$_POST['observacao']}'
	 
	 $where");
	 //echo $ty;
	 
	  if($_POST['aluno_id'] > 0){
		 $aluno_id = $_POST['aluno_id'];
	 }else{
		$aluno_id = mysql_insert_id();
	 }
	 
	 
	 $extensao = getExtensao($_FILES['file']['name'][0]);
	if($extensao!='php'){
		
		if(move_uploaded_file($_FILES['file']['tmp_name'][0], "modulos/escolar/alunos_inscritos/img/".$aluno_id.".$extensao")){
			
			mysql_query($ql="UPDATE $tabela set extensao = '$extensao' WHERE id = '$aluno_id' AND vkt_id='$vkt_id'");
		}
	}	
	
	//echo '<br/>'.$aluno_id;
	
} /*fim*/

function remove_imgem($id){
	global $tabela,$vkt_id;
	$info = mf(mq("SELECT * FROM $tabela WHERE id='$id' AND vkt_id='$vkt_id'"));
	$extensao = $info->extensao;
	if($info->id>0){
		unlink("modulos/escolar/alunos_inscritos/img/".$id.".$extensao");
		mysql_query($q="UPDATE $tabela set extensao ='' WHERE id= '$id' AND vkt_id='$vkt_id'");
	}
	
	
}

function remover () {
	global $tabela,$vkt_id;
	$info = mf(mq("SELECT * FROM escolar_matriculas WHERE aluno_id='{$_POST[aluno_id]}' AND vkt_id='$vkt_id'"));
	if($info->id<1){
		$q = mysql_query ($trace = "DELETE FROM $tabela WHERE id = '" . mysql_real_escape_string($_POST['aluno_id']) . "' AND vkt_id='$vkt_id'");	
	}
}
?>