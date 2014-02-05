<?
/*
@autor: Moacir Selínger Fernandes
@email: hassed@hassed.com
Qualquer dúvida é só mandar um email
*/


function manipulaColaborador($dados,$vkt_id,$id){
	if($id==''){ $sql_in = " INSERT INTO "; $sql_fim="";}
	if($id>0){ $sql_in = " UPDATE "; $sql_fim = " WHERE id='$id'";}
	if($dados['profissao_id']>0){ $profissao_id= $dados['profissao_id']; }elseif(trim($dados['profissao_nome_busca'])!='' && $dados['profissao_id']==''){
		mysql_query("INSERT INTO eleitoral_profissoes SET descricao='{$_POST['profissao_nome_busca']}', vkt_id='$vkt_id'");
		$profissao_id=mysql_insert_id();
	}
	$zona = mysql_query($trace="select * from eleitoral_zonas WHERE zona='".$dados['zona_nome_busca']."' and secao='".$dados['secao_nome_busca']."'");
	//echo $trace;
	if(mysql_num_rows($zona)==0){
		$dados['zona_nome_busca']='';
		$dados['secao_nome_busca']='';
		$dados['local_nome_busca']='';
	}
	if(count($dados['imovel_servicos'])>0){$imovel_servicos=implode(',',$dados['imovel_servicos']);}else{$imovel_servicos=0;}
	if(count($dados['carro_gasolina_servicos'])>0){$carro_gasolina_servicos=implode(',',$dados['carro_gasolina_servicos']);}else{$carro_gasolina_servicos=0;}
	if(count($dados['carro_diesel_servicos'])>0){$carro_diesel_servicos=implode(',',$dados['carro_diesel_servicos']);}else{$carro_diesel_servicos=0;}
	if(count($dados['lancha_servicos'])>0){$lancha_servicos=implode(',',$dados['lancha_servicos']);}else{$lancha_servicos=0;}
	if(count($dados['barco_servicos'])>0){$barco_servicos=implode(',',$dados['barco_servicos']);}else{$barco_servicos=0;}
	if(count($dados['moto_servicos'])>0){$moto_servicos=implode(',',$dados['moto_servicos']);}else{$moto_servicos=0;}
	$turnos='';
	if(!empty($dados['turno'])){
		foreach($dados['turno'] as $turno){
			$turnos.=$turno.",";
		}
	}
	if(empty($dados['coordenador_id'])){
		$tipo_colaborador=0;
	}else{
		$tipo_colaborador=1;
	}
	$sql="
	$sql_in eleitoral_colaboradores SET
	vkt_id='$vkt_id',
	tipo_colaborador='$tipo_colaborador',
	nome='{$dados['nome']}',
    apelido='{$dados['apelido']}',
	data_nascimento='".dataBrToUsa($dados['data_nascimento'])."',
	telefone1='{$dados['telefone1']}',
	telefone2='{$dados['telefone2']}',
	email='{$dados['email']}',
	estado_civil='{$dados['estado_civil']}',
	naturalidade='{$dados['naturalidade']}',
	sexo='{$dados['sexo']}',
	endereco='{$dados['endereco']}',
	bairro='{$dados['bairro_nome_busca']}',
	cidade='{$dados['cidade']}',
	uf='{$dados['uf']}',
	cep='{$dados['cep']}',
	regiao_id='{$dados['regiao_id']}',
	coordenador_id='{$dados['coordenador_id']}',
	vinculo_coordenador_id='{$dados['vinculo_coordenador_id']}',
	funcao_id='{$dados['funcao_id']}',
	valor='".moedaBrToUsa($dados['valor'])."',
	turno='{$turnos}',
	qtd_voto='{$dados['qtd_voto']}',
	data_inicio = '".DataBrToUsa($dados['data_inicio'])."',
	data_fim = '".DataBrToUsa($dados['data_fim'])."',
	periodo = '{$dados['periodo']}',
	area_atuacao='{$dados['area_atuacao']}',
	cpf='{$dados['cpf']}',
	titulo_eleitor='{$dados['titulo_eleitor']}',
	zona='{$dados['zona_nome_busca']}',
	secao='{$dados['secao_nome_busca']}',
	local='{$dados['local_nome_busca']}',
	status_voto='{$dados['status_voto']}',
	profissao_id='{$dados['profissao_id']}',
	empresa='{$dados['empresa']}',
	renda_familiar='".moedaBrToUsa($dados['renda_familiar'])."',
	num_integrantes_familia='{$dados['num_integrantes_familia']}',
	grau_instrucao='{$dados['grau_instrucao']}',
	grupo_social_id='{$dados['grupo_social_id']}',
	religiao_id='{$dados['religiao_id']}',
	filiacao_partidaria_id='{$dados['filiacao_partidaria_id']}',
	doenca='{$dados['doenca']}',
	medicamentos='{$dados['medicamentos']}',
	esporte='{$dados['esporte']}',
	time='{$dados['time']}',
	imovel_qtd='{$dados['imovel_qtd']}',
	imovel_servicos='$imovel_servicos',
	carro_gasolina_qtd='{$dados['carro_gasolina_qtd']}',
	carro_gasolina_servicos='$carro_gasolina_servicos',
	carro_diesel_qtd='{$dados['carro_diesel_qtd']}',
	carro_diesel_servicos='$carro_diesel_servicos',
	moto_qtd='{$dados['moto_qtd']}',
	moto_servicos='$moto_servicos',
	lancha_qtd='{$dados['lancha_qtd']}',
	lancha_servicos='$lancha_servicos',
	barco_qtd='{$dados['barco_qtd']}',
	barco_servicos='$barco_servicos',
	descricao_bens='{$dados['descricao_bens']}'
	$sql_fim
	";
	//echo $sql."<br><br>";
	//echo '<pre>';
	//print_r($_POST);
	//if($dados['dependente_nome'][0]!=''){echo "OLHA O CARA AQUI:";echo $dados['dependente_nome'][0];}else{ echo 'nao tem';}
	//echo '</pre>';
	
	
	if(mysql_query($sql)){
	/* pegar o id para relacionamento entre tabelas, de acordo com a ação */
	if($id==''){$colaborador_id=mysql_insert_id();}
	if($id>0){$colaborador_id=$id;}
	
	//echo $sql.'<br>';
	//echo mysql_error().'<br>';
		if($dados['dependente_nome'][0]!=''){
			mysql_query($sql_dep="DELETE FROM eleitoral_dependentes_colaboradores WHERE eleitor_id='$eleitor_id'");
			for($i=0;$i<count($dados['dependente_nome']);$i++){
				adicionaDependenteColaborador
				(
				$dados['dependente_nome'][$i],
				$dados['dependente_nascimento'][$i],
				$dados['dependente_vinculo'][$i],
				$dados['dependente_ocupacao'][$i],
				$dados['dependente_instituicao'][$i],
				$dados['dependente_doenca'][$i],
				$dados['dependente_medicamentos'][$i],
				$colaborador_id,
				$vkt_id
				);
			}
		}
		mysql_query($sql_dep="DELETE FROM eleitoral_intencoes_voto WHERE colaborador_id='$colaborador_id'");
/* adiciona intenção de voto para o candidato */
		adicionaIntencao($colaborador_id,0,$vkt_id,$dados['status_voto']);
		if($dados['politico_id'][0]!=''){
			
			/* adiciona intenção de voto para outros políticos */
			for($i=0;$i<count($dados['politico_id']);$i++){
				adicionaIntencao($colaborador_id,$dados['politico_id'][$i],$vkt_id);
			}
		}
	}else{
		echo mysql_error();
	}
}

function adicionaDependenteColaborador($nome,$nascimento, $vinculo, $ocupacao,$instituicao, $doenca,$medicamentos,$colaborador_id,$vkt_id){
		mysql_query($sql_dep="INSERT INTO eleitoral_dependentes_colaboradores SET
		nome='$nome',
		dt_nascimento='".dataBrToUsa($nascimento)."',
		vinculo_id='$vinculo',
		ocupacao='$ocupacao',
		instituicao='$instituicao',
		doenca='$doenca',
		medicamentos='$medicamentos',
		vkt_id='$vkt_id',
		colaborador_id='$colaborador_id'
			");
		//echo $sql_dep.'<br>';
		//echo mysql_error().'<br>';
}
/* Adicionar intenção de voto */
function adicionaIntencao($colaborador_id,$politico_id,$vkt_id,$status_voto=NULL){
	if($status_voto!=NULL){$add_status=", status_voto='$status_voto' ";}else{$status_voto=NULL;}
	mysql_query($sql_int="INSERT INTO eleitoral_intencoes_voto SET colaborador_id='$colaborador_id', politico_id='$politico_id', status='1', data=NOW(), vkt_id='$vkt_id' $add_status ");
	//echo $sql_int.'<br>';
}
function deletaColaborador($id){
	mysql_query("DELETE FROM eleitoral_colaboradores WHERE id='$id' ");
	mysql_query("DELETE FROM eleitoral_intencoes_voto WHERE colaborador_id='$id' ");
	mysql_query("DELETE FROM eleitoral_dependentes_colaboradores WHERE colaborador_id='$id' ");
}
?>