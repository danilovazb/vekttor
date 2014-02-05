<?
	
$face[1]="lingual/palatina";
$face[2]="mesial";
$face[3]="distal";
$face[4]="lingual/palatina";
$face[5]="oclusal/incisal";
function adicionaAnaliseDente($tipo,$info_dente){
	global $vkt_id;
	if($tipo=='procedimento'){
		$campo_procedimento="procedimento_id";
		$campo_obs="obs_procedimento";
		$tabela="odontologo_atendimento_item";
		$sql_add=" , valor='{$info_dente[procedimento_valor]}', status='0',aprovado='2'";
	}
	if($tipo=='historico'){
		$campo_procedimento="procedimento_passado_id";
		$campo_obs="obs_procedimento_passado";
		$tabela="odontologo_atendimento_analise";
	}
	if($info_dente['convenio_id']>0){
		$verifica_preco_convenio=mysql_fetch_object(mysql_query($a="SELECT opc.valor FROM odontologo_procedimento_convenio as opc, odontologo_convenio as oc WHERE opc.vkt_id='$vkt_id' AND oc.cliente_fornecedor_id='{$info_dente['convenio_id']}' AND opc.convenio_id=oc.id AND opc.servico_id='{$info_dente[$campo_procedimento]}' "));
		echo $a;
		if($verifica_preco_convenio->valor > 0){
			echo '00--'.$verifica_preco_convenio->valor.'---';
			$sql_add=" , valor='$verifica_preco_convenio->valor', status='0',aprovado='2'";
		}
	}
	
	
	
	
	$sql="INSERT INTO $tabela SET vkt_id='$vkt_id', cliente_fornecedor_id='{$info_dente['cliente_id']}', odontologo_id='".$_SESSION['usuario']->id."', odontologo_atendimento_id='{$info_dente['atendimento_id']}', data_cadastro=NOW(), servico_id='{$info_dente[$campo_procedimento]}', dente_id='{$info_dente['dente_id']}', face_id='{$info_dente['face_id']}', obs='{$info_dente[$campo_obs]}'";
	$sql.=$sql_add;
	//echo $sql;
	mysql_query($sql);
	echo '<script>top.atualizaProcedimentos()</script>';
}


function editaAnaliseDente($tipo,$info_dente){
	global $vkt_id;
	if($tipo=='novo'){$tabela='odontologo_atendimento_item';}if($tipo=='passado'){$tabela='odontologo_atendimento_analise';}
	//seleciona o valor do novo servico
	$valor_servico = mysql_result(mysql_query("SELECT valor_normal FROM servico WHERE id='$info_dente[procedimento_editavel_id]' AND vkt_id='$vkt_id'"),0,0);
	mysql_query("UPDATE $tabela SET  servico_id='{$info_dente[procedimento_editavel_id]}', obs='{$info_dente[obs_procedimento_editavel]}', valor='$valor_servico' WHERE id='{$info_dente[procedimento_editavel_item_id]}'");
	echo '<script>top.atualizaProcedimentos()</script>';
}
function excluirAnaliseDente($tipo,$info_dente){
	global $vkt_id;
	if($tipo=='novo'){$tabela='odontologo_atendimento_item';}if($tipo=='passado'){$tabela='odontologo_atendimento_analise';}
	mysql_query($a="DELETE FROM $tabela WHERE id='{$info_dente[procedimento_editavel_item_id]}'");
	echo '<script>top.atualizaProcedimentos()</script>';
}
function manipulaAprovacao($acao,$procedimento_id){
	if($acao=='aprova')mysql_query("UPDATE odontologo_atendimento_item SET aprovado='1' WHERE id='$procedimento_id'");
	if($acao=='desaprova')mysql_query("UPDATE odontologo_atendimento_item SET aprovado='2' WHERE id='$procedimento_id'");
	echo '<script>top.atualizaProcedimentosAprovados();</script>';
}

function incluirConsulta($dados){
	global $vkt_id;
	
	if($dados['consulta_id']>0){
		$consulta_id=$dados['consulta_id'];
		mysql_query($t="UPDATE odontologo_consultas SET data_fim=NOW(), obs='{$dados['obs_consulta']}' WHERE id='$consulta_id' ");
	}else{
		mysql_query($a="INSERT INTO odontologo_consultas SET vkt_id='$vkt_id', cliente_fornecedor_id='{$dados['cliente_id']}', odontologo_id='".$_SESSION['usuario']->id."', odontologo_atendimento_id='{$dados['atendimento_id']}', data=NOW(), obs='{$dados['obs_consulta']}', status='em andamento' ");
		$consulta_id=mysql_insert_id();
		echo "<script>top.document.getElementById('consulta_id').value='".$consulta_id."'</script>";
	}
	if(!$dados[status_item_consulta]){
		$status=1;
	}else{
		$status=$dados[status_item_consulta];
		if($dados[status_item_consulta]=='2'){$sql_conclusao_item=" ,data_conclusao=NOW()";}
	}
	mysql_query($b="INSERT INTO odontologo_consulta_has_odontologo_atendimento_item SET odontologo_consulta_id='$consulta_id', odontologo_atendimento_item_id='{$dados['procedimento_aprovado_id']}', odontologo_id='".$_SESSION['usuario']->id."', obs='{$dados['obs_procedimento_consulta']}', vkt_id='$vkt_id'");	
	
	mysql_query($t="UPDATE odontologo_atendimento_item SET  status ='$status' $sql_conclusao_item WHERE id='{$dados['procedimento_aprovado_id']}'");
	echo "<script>top.atualizaProcedimentosAprovados();</script>";
	echo "<script>top.atualizaHistoricoConsultas();</script>";
}


function concluirConsulta($dados){
	global $vkt_id;
	$consulta_id=$dados['consulta_id'];	
	$tempo_atendimento = mysql_fetch_object(mysql_query("SELECT TIMEDIFF('".date('H:i')."',hora_atendimento) tempo_atendimento FROM odontologo_fila_espera WHERE id='$id'"));
	if($consulta_id>0){
		mysql_query($t="UPDATE odontologo_consultas SET status='concluido',data_fim=NOW() WHERE id='$consulta_id' AND vkt_id='$vkt_id' ");
	}else{
		mysql_query("INSERT INTO odontologo_consultas SET vkt_id='$vkt_id', cliente_fornecedor_id='{$dados['cliente_id']}', odontologo_id='".$_SESSION['usuario']->id."', odontologo_atendimento_id='{$dados['atendimento_id']}', data=NOW(), data_fim=NOW(), obs='{$dados['obs_consulta']}', status='concluido'");
	}
	
	mysql_query($a="UPDATE odontologo_fila_espera SET status='Concluido', data_conclusao=DATE(NOW()), hora_conclusao=TIME(NOW()),tempo_atendimento = '$tempo_atendimento->tempo_atendimento' WHERE vkt_id='$vkt_id' AND cliente_fornecedor_id='{$dados[cliente_id]}' ");
	echo $a;
	echo "<script>top.document.getElementById('consulta_id').value='';</script>";
	echo "<script>top.atualizaProcedimentosAprovados()</script>";
	echo "<script>top.location.href='../../../index.php?tela_id=387'</script>";
}

function excluirConsulta($consulta_id){
	mysql_query("DELETE FROM odontologo_consulta_has_odontologo_atendimento_item WHERE id='$consulta_id'");
	echo "<script>top.atualizaHistoricoConsultas();</script>";
}

function upload_imagem($id){
	
	$filis_autorizados = array('jpg','gif','png','pdf','jpeg');
	
	$infomovimento = mysql_fetch_object(mysql_query("SELECT * FROM odontologo_exames WHERE id='$id'"));
	
	$pasta 	= '../../../modulos/odonto/atendimento/arquivo_exame/';
	  $extensao = str_replace('.','',strtolower(substr($_FILES['imagem']['name'],-4)));
	  $arquivo 	= $pasta.$id.'.'.$extensao;
	  //alert($arquivo);
	  $arquivodel= $pasta.$produto_id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['imagem'][tmp_name],$arquivo)){
			  mysql_query($f="UPDATE odontologo_exames SET extensao='$extensao' WHERE id='$id'");
			  //alert($f);
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
}


function incluirExame($dados){
	global $vkt_id;
	mysql_query($t="INSERT INTO odontologo_exames SET 
				vkt_id                    ='$vkt_id', 
				cliente_fornecedor_id     ='".$dados['cliente_id']."',
				odontologo_atendimento_id ='".$dados['id']."',
				observacao                ='".$dados['obs_exame']."',
				data                      ='".DataBrToUsa($dados['data_exame'])."'");
	
	$id = mysql_insert_id();
	
	if(strlen($_FILES['imagem']['name'])>0){
		
		upload_imagem($id);
	
	}
	
	return $id;
}

function excluirExame($dados){
	$ultimo = mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_exames WHERE id=".$dados['id']));
	unlink("arquivo_exame/".$ultimo->id.".".$ultimo->extensao);
	mysql_query("DELETE FROM odontologo_exames WHERE id=".$_POST['id']);
}

function manipulaCliente($acao,$dados){
  global $vkt_id;
  //if($acao=="add"){
   if(!$dados['cliente_id']>0){	  
	  $sql_inicio="INSERT INTO ";
  }elseif($acao=="editar"){
	  $sql_inicio="UPDATE ";
	  $sql_fim_cliente="WHERE id ='{$dados['cliente_id']}'";
  }
  $erro=0;
  $razao_social=limitaTexto($dados['razao_social'],255);
  $nome_fantasia=limitaTexto($dados["razao_social"],255);
  $nome_contato=limitaTexto($dados["nome_contato"],255);
  $ramo_atividade=limitaTexto($dados["ramo_atividade"],255);
  $rg=limitaTexto($dados["rg"],20);
  $suframa=limitaTexto($dados["suframa"],255);
   $sql_cliente=" $sql_inicio cliente_fornecedor SET
	cliente_vekttor_id='".$_SESSION['usuario']->cliente_vekttor_id."',
	usuario_id='".$_SESSION['usuario']->id."',
	razao_social='".$razao_social."',
	nome_fantasia='".$nome_fantasia."',
	nome_contato='".$nome_contato."',
	ramo_atividade='".$ramo_atividade."',
	cnpj_cpf='".$dados["cnpj_cpf"]."',
	nascimento='".dataBrToUsa($dados['nascimento'])."',
	rg='".$dados['rg']."',
	local_emissao='".$dados['local_emissao']."',
	data_emissao='".dataBrToUsa($dados["data_emissao"])."',
	nacionalidade='".$dados['nacionalidade']."',
	naturalidade='".$dados['naturalidade']."',
	endereco_comercial='".$dados['endereco_comercial']."',
	telefone_comercial='".$dados['telefone_comercial']."',
	email='".$dados['email']."',
	telefone1='".$dados['telefone1']."',
	telefone2='".$dados['telefone2']."',
	fax='".$dados['fax']."',
	cep='".$dados["cep"]."',
	endereco='".$dados["endereco"]."',
	bairro='".$dados["bairro"]."',
	cidade='".$dados["cidade"]."',
	estado='".$dados["estado"]."',
	limite='".$dados["limite"]."',
	tipo='Cliente',
	tipo_cadastro='Físico',
	estado_civil='".$dados["estado_civil"]."',
	conjugue_nome='".$dados["conjugue_nome"]."',
	conjugue_data_nascimento='".$dados["conjugue_data_nascimento"]."',
	conjugue_ramo_atividade='".$dados["conjugue_ramo_atividade"]."',
	conjugue_cpf='".$dados["conjugue_cpf"]."',
	conjugue_rg='".$dadps["conjugue_rg"]."',
	conjugue_local_emissao='".$dados["conjugue_local_emissao"]."',
	conjugue_data_emissao='".$dados["conjugue_data_emissao"]."',
	conjugue_telefone='".$dados["conjugue_telefone"]."',
	conjugue_email='".$dados["conjugue_email"]."',
	conjugue_naturalidade='".$dados["conjugue_naturalidade"]."',
	conjugue_nacionalidade='".$dados["conjugue_nacionalidade"]."',
	conjugue_endereco_comercial='".$dados["conjugue_endereco_comercial"]."',
	conjugue_telefone_comercial='".$dados["conjugue_telefone_comercial"]."'
	$sql_fim_cliente
	";
	//print_r($dados);
	
	mysql_query($sql_cliente);
	if($acao=='add'){
		$cliente_id=mysql_insert_id();
		$sql_fim_cliente_atendimento=", data_cadastro=NOW()";
	}elseif($acao=='editar'){
		$cliente_id=$dados['cliente_id'];
		$sql_fim_cliente_atendimento="WHERE cliente_fornecedor_id ='$cliente_id'";
	}
	
	
	$sql_atendimento="$sql_inicio 
		odontologo_atendimentos 
	SET 
		vkt_id='$vkt_id', 
		cliente_fornecedor_id='$cliente_id', 
		convenio_id='{$dados['convenio_id']}',
		indicacao='{$dados['indicacao']}',
		numero_segurado='{$dados['numero_segurado']}',
		anamnese_anemia='{$dados['anamnese_anemia']}',
		anamnese_hepatite='{$dados['anamnese_hepatite']}',
		anamnese_sifilis='{$dados['anamnese_sifilis']}',
		anamnese_hiv='{$dados['anamnese_hiv']}',
		anamnese_tuberculose='{$dados['anamnese_tuberculose']}',
		anamnese_asma='{$dados['anamnese_asma']}',
		anamnese_fumante='{$dados['anamnese_fumante']}',
		anamnese_hormonio='{$dados['anamnese_hormonio']}',
		anamnese_alcolista='{$dados['anamnese_alcolista']}',
		anamnese_tatuagem='{$dados['anamnese_tatuagem']}',
		anamnese_herpes='{$dados['anamnese_herpes']}',
		anamnese_gravidez='{$dados['anamnese_gravidez']}',
		anamnese_desmaio='{$dados['anamnese_desmaio']}',
		anamnese_febre_reumatica='{$dados['anamnese_febre_reumatica']}',
		anamnese_diabetes='{$dados['anamnese_diabetes']}',
		anamnese_epilepsia='{$dados['anamnese_epilepsia']}',
		anamnese_cicatrizacao_ruim='{$dados['anamnese_cicatrizacao_ruim']}',
		anamnese_disturbios_psico='{$dados['anamnese_disturbios_psico']}',
		anamnese_endocardite_bact='{$dados['anamnese_endocardite_bact']}',
		anamnese_problema_hepatico='{$dados['anamnese_problema_hepatico']}',
		anamnese_problema_renal='{$dados['anamnese_problema_renal']}',
		anamnese_problema_cardiaco='{$dados['anamnese_problema_cardiaco']}',
		anamnese_tensao_arterial='{$dados['anamnese_tensao_arterial']}',
		anamnese_cirurgia='{$dados['anamnese_cirurgia']}',
		anamnese_tumor='{$dados['anamnese_tumor']}',
		anamnese_internacao_hospital ='{$dados['anamnese_internacao_hospital']}',
		anamnese_febre_reumatica2='{$dados['anamnese_febre_reumatica2']}',
		anamnese_tratamento_medico='{$dados['anamnese_tratamento_medico']}',
		anamnese_medicacao='{$dados['anamnese_medicacao']}',
		anamnese_alergia='{$dados['anamnese_alergia']}',
		anamnese_obs_medicacao='{$dados['anamnese_obs_medicacao']}',
		anamnese_obs_tratamento_medico='{$dados['anamnese_obs_tratamento_medico']}',		
		anamnese_obs_alergia='{$dados['anamnese_obs_alergia']}',
		anamnese_outra_doenca='{$dados['anamnese_outra_doenca']}',
		anamnese_observacao_geral='{$dados['anamnese_observacao_geral']}'
		 ";
		 
	/*for($i=1;$i<=20;$i++){
		$sql_atendimento.=", pergunta$i='".$dados["pergunta$i"]."'";
		$sql_atendimento.=", resposta$i='".$dados["resposta$i"]."'";
	}*/
	$sql_atendimento.=" $sql_fim_cliente_atendimento";
	mysql_query($sql_atendimento);
	if($acao=='add'){
		$atendimento_inserido=mysql_insert_id();
			
	}elseif($acao=='editar'){
		$atendimento_inserido=$dados['atendimento_id'];
	}
	
	if(strlen($_FILES['foto_cliente']['name'])>3){
		upload_foto($cliente_id);
	
	}
  
	echo "<script>top.document.getElementById('atendimento_id').value='".$atendimento_inserido."'</script>";
	echo "<script>top.document.getElementById('cliente_id').value='".$cliente_id."'</script>";
	if($dados['fila_espera']!=''&&$dados['agenda_id']>0){
		$ultimo_numero_fila = mysql_fetch_object(mysql_query($t="SELECT ordem_de_atendimento FROM 
		odontologo_fila_espera 
		WHERE
		data_chegada =  '".date('Y-m-d')."' AND
		usuario_id='".$_SESSION['usuario']->id." ' AND
		vkt_id='$vkt_id' ORDER BY ordem_de_atendimento DESC LIMIT 1"));
		$proximo = $ultimo_numero_fila->ordem_de_atendimento+1;
		mysql_query($t="INSERT INTO odontologo_fila_espera SET vkt_id='$vkt_id', usuario_id='".$_SESSION['usuario']->id."', cliente_fornecedor_id='$cliente_id', agenda_id='{$dados['agenda_id']}', data_chegada=NOW(), hora_chegada=NOW(), status='".$dados['fila_espera']."', ordem_de_atendimento='$proximo'");
		echo "<script>top.location.href='../../../index.php?tela_id=383'</script>";
	}
}

function manipulaPreco($procedimento_id,$valor){
	global $vkt_id;
	if(mysql_query($a="UPDATE odontologo_atendimento_item SET valor='$valor' WHERE vkt_id='$vkt_id' AND id='$procedimento_id' ")){
	}else{
		echo "nao foi : ".mysql_error();
	}
}
function retornaInfoProcedimento($procedimento_id,$tipo){
	global $vkt_id;
	if($tipo=='novo'){$tabela='odontologo_atendimento_item';}if($tipo=='passado'){$tabela='odontologo_atendimento_analise';}
	$proc=mysql_fetch_object(mysql_query($a="SELECT * FROM $tabela WHERE vkt_id='$vkt_id' AND id='$procedimento_id'"));
	$servico=mysql_fetch_object(mysql_query($b="SELECT * FROM servico WHERE id='$proc->servico_id' "));
	echo utf8_encode($proc->id.'|'.$servico->id.'|'.$servico->nome.'|'.$proc->dente_id.'|'.$proc->obs.'|'.$tipo);
}

function upload_foto($cliente_id){
	
	$filis_autorizados = array('jpg','gif','png','jpeg');
	
	$infomovimento = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id='$cliente_id' "));
	
	if(strlen($_FILES['foto_cliente']['name'])>0){
	  $pasta 	  = "../../../modulos/administrativo/clientes/fotos_clientes/";
	  //echo $pasta;
	  $extensao = strtolower(substr($_FILES['foto_cliente']['name'],-3));
	  $arquivo 	  = $pasta.$cliente_id.'.'.$extensao;
	  
	  $arquivodel= $pasta.$cliente_id.'.';
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  
		  if(move_uploaded_file($_FILES['foto_cliente'][tmp_name],$arquivo)){
			  mysql_query($f="UPDATE cliente_fornecedor SET extensao='$extensao' WHERE id='$cliente_id'");
			 // alert($f);
			  chmod($pasta,0777);  
		 	
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	
}

function ExcluirFoto($dados){
	
	$foto = mysql_fetch_object(mysql_query($t="SELECT id,extensao FROM cliente_fornecedor WHERE id='$dados[cliente_id]'"));

	unlink("../../../modulos/administrativo/clientes/fotos_clientes/".$foto->id.".".$foto->extensao);
	mysql_query($t="UPDATE cliente_fornecedor SET extensao='' WHERE id=$foto->id");
}

function manipulaContratoCliente($dados){
	
	global $vkt_id;
	
	$texto = $dados[tx_contrato];
	
		if($dados['contrato_id']>0){
			$inicio="UPDATE";
			$fim=" WHERE id=".$dados['contrato_id'];
		}else{
			$inicio="INSERT INTO";
			
		}
	$sql=mysql_query($t="$inicio odontologo_contrato_cliente SET 
			vkt_id='$vkt_id',
			contrato_modelo_id='{$dados['modelo_id']}',
			cliente_id='{$dados['cliente_id']}',
			nome='{$dados['nome']}',
			html_contrato='$texto',			
			status='1'
			$fim");
	//}
		
		if($dados['contrato_id']<=0){
			$id = mysql_insert_id();
			echo "<script>nl= top.document.getElementById('dados_contratos').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length-1;top.document.getElementById('dados_contratos').getElementsByTagName('tbody')[0].getElementsByTagName('tr')[nl].setAttribute('id_contrato','$id')</script>";
		}
			
}