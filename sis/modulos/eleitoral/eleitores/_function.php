<?
/*
@autor: Moacir Selínger Fernandes
@email: hassed@hassed.com
Qualquer dúvida é só mandar um email
*/



function manipulaEleitor($dados,$vkt_id,$id,$via_site="nao"){
	//$dados = utf8_encode($dados);
	if($id==''){ $sql_in = " INSERT INTO "; $sql_fim="";}
	if($id>0){ $sql_in = " UPDATE "; $sql_fim = " WHERE id='$id'";}
	
	/*if($dados['profissao_id']>0){ $profissao_id= $dados['profissao_id']; }elseif(trim($dados['profissao_nome_busca'])!='' && $dados['profissao_id']==''){
		mysql_query($trace="INSERT INTO eleitoral_profissoes SET descricao='{$_POST['profissao_nome_busca']}', vkt_id='$vkt_id'");
		//echo $trace.'<br>';
		$profissao_id=mysql_insert_id();
	}*/
	$profissao_id=$dados['profissao_id'];
	$zona = mysql_query($trace="select * from eleitoral_zonas WHERE zona='".$dados['zona_nome_busca']."' and secao='".$dados['secao_nome_busca']."'");
	//echo $trace;
	if(mysql_num_rows($zona)==0){
		$dados['zona_nome_busca']='';
		$dados['secao_nome_busca']='';
		$dados['local_nome_busca']='';
	}
	
	if($dados['receber_email']=="on"){
		$receber_email="sim";
	}else{
		$receber_email="nao";
	}
	
	if($dados['receber_sms']=="on"){
		$receber_sms="sim";
	}else{
		$receber_sms="nao";
	}
	
	$apelido = str_replace("'","`",$dados['apelido']);	
	//echo $apelido;
	if(count($dados['imovel_servicos'])>0){$imovel_servicos=implode(',',$dados['imovel_servicos']);}else{$imovel_servicos=0;}
	if(count($dados['carro_gasolina_servicos'])>0){$carro_gasolina_servicos=implode(',',$dados['carro_gasolina_servicos']);}else{$carro_gasolina_servicos=0;}
	if(count($dados['carro_diesel_servicos'])>0){$carro_diesel_servicos=implode(',',$dados['carro_diesel_servicos']);}else{$carro_diesel_servicos=0;}
	if(count($dados['lancha_servicos'])>0){$lancha_servicos=implode(',',$dados['lancha_servicos']);}else{$lancha_servicos=0;}
	if(count($dados['barco_servicos'])>0){$barco_servicos=implode(',',$dados['barco_servicos']);}else{$barco_servicos=0;}
	if(count($dados['moto_servicos'])>0){$moto_servicos=implode(',',$dados['moto_servicos']);}else{$moto_servicos=0;}
	
	if($via_site=="sim"){
		$nome =    utf8_decode($dados['nome']);
		$apelido = utf8_decode($apelido);
		$endereco = utf8_decode($dados['endereco']);
		$bairro = utf8_decode($dados['bairro']);
		$cidade = utf8_decode($dados['cidade']);
		$estado = utf8_decode($dados['estado']);
		$profissao_id=utf8_decode($dados['profissao_id']);
	}else{
		$nome =    $dados['nome'];
		$apelido = $apelido;
		$endereco = $dados['endereco'];
		$bairro = $dados['bairro'];
		$cidade = $dados['cidade'];
		$estado = $dados['estado'];
		$profissao_id=$dados['profissao_id'];
	}
	$sql="
	$sql_in eleitoral_eleitores SET
	vkt_id='$vkt_id',
	nome='$nome',
	apelido='".$apelido."',
	sexo='{$dados['sexo']}',
	data_nascimento='".dataBrToUsa($dados['data_nascimento'])."',
	telefone1='{$dados['telefone1']}',
	telefone2='{$dados['telefone2']}',
	email='{$dados['email']}',
	estado_civil='{$dados['estado_civil']}',
	naturalidade='{$dados['naturalidade']}',
	endereco='$endereco',
	bairro='$bairro',
	cidade='$cidade',
	estado='$estado',
	local='{$dados['local_nome_busca']}',
	cep='{$dados['cep']}',
	regiao_id='{$dados['regiao_id']}',
	coordenador_id='{$dados['coordenador_id']}',
	vinculo_coordenador_id='{$dados['vinculo_coordenador_id']}',
	cpf='{$dados['cpf']}',
	rg='{$dados['rg']}',
	titulo_eleitor='{$dados['titulo_eleitor']}',
	zona='{$dados['zona_nome_busca']}',
	secao='{$dados['secao_nome_busca']}',
	status_voto='{$dados['status_voto']}',
	profissao_id='$profissao_id',
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
	descricao_bens='{$dados['descricao_bens']}',
	origem = '{$dados['origem']}',
	recebe_email='$receber_email',
	recebe_sms='$receber_sms'
	$sql_fim
	";
	//echo $sql."<br>";
	//alert($sql);
	//echo '<pre>';
	//print_r($_POST);
	//echo '</pre>';
	//if($dados['dependente_nome'][0]!=''){echo "OLHA O CARA AQUI:";echo $dados['dependente_nome'][0];}else{ echo 'nao tem';}
	
	
	
	if(mysql_query($sql)){
	/* pegar o id para relacionamento entre tabelas, de acordo com a ação */
	if($id==''){$eleitor_id=mysql_insert_id();}
	if($id>0){$eleitor_id=$id;}
	
	
	
	//echo $sql.'<br>';
	//echo mysql_error().'<br>';
		if($dados['dependente_nome'][0]!=''){
			//echo 'TA FUNCIONANDO';
			mysql_query($sql_dep="DELETE FROM eleitoral_dependentes WHERE eleitor_id='$eleitor_id'");
			for($i=0;$i<count($dados['dependente_nome']);$i++){
				adicionaDependente
				(
				$dados['dependente_nome'][$i],
				$dados['dependente_nascimento'][$i],
				$dados['dependente_vinculo'][$i],
				$dados['dependente_ocupacao'][$i],
				$dados['dependente_instituicao'][$i],
				$dados['dependente_doenca'][$i],
				$dados['dependente_medicamentos'][$i],
				$eleitor_id,
				$vkt_id
				);
			}
		}elseif($dados['dependente_nome'][0]==''){
			mysql_query($sql_dep="DELETE FROM eleitoral_dependentes WHERE eleitor_id='$eleitor_id'");
		}
		/* invalida para contagem(relatórios,etc..) os votos antigos */
		mysql_query($sql_dep="UPDATE eleitoral_intencoes_voto SET status='0' WHERE eleitor_id='$eleitor_id'");
		
		/* adiciona intenção de voto para o candidato */
		adicionaIntencao($eleitor_id,0,$vkt_id,$dados['status_voto']);
		if($dados['politico_id'][0]!=''){
			
			/* adiciona intenção de voto para outros políticos */
			for($i=0;$i<count($dados['politico_id']);$i++){
				//echo 'funcionou';
				adicionaIntencao($eleitor_id,$dados['politico_id'][$i],$vkt_id);
				echo mysql_error();
			}
		}
	}else{
		echo mysql_error();
	}
	return $eleitor_id;
}

function adicionaDependente($nome,$nascimento, $vinculo, $ocupacao,$instituicao, $doenca,$medicamentos,$eleitor_id,$vkt_id){
		mysql_query($sql_dep="INSERT INTO eleitoral_dependentes SET
		nome='$nome',
		dt_nascimento='".dataBrToUsa($nascimento)."',
		vinculo_id='$vinculo',
		ocupacao='$ocupacao',
		instituicao='$instituicao',
		doenca='$doenca',
		medicamentos='$medicamentos',
		vkt_id='$vkt_id',
		eleitor_id='$eleitor_id'
		");
		//echo $sql_dep.'<br>';
		//echo mysql_error().'<br>';
}
/* Adicionar intenção de voto */
function adicionaIntencao($eleitor_id,$politico_id,$vkt_id,$status_voto=NULL){
	if($status_voto!=NULL){$add_status=", status_voto='$status_voto' ";}else{$status_voto=NULL;}
	mysql_query($sql_int="INSERT INTO eleitoral_intencoes_voto SET eleitor_id='$eleitor_id', politico_id='$politico_id', status='1', data=NOW(), vkt_id='$vkt_id' $add_status ");
	//echo $sql_int.'<br>';
}
function deletaEleitor($id){
	mysql_query("DELETE FROM eleitoral_eleitores WHERE id='$id' ");
	mysql_query("DELETE FROM eleitoral_intencoes_voto WHERE eleitor_id='$id' ");
	mysql_query("DELETE FROM eleitoral_dependentes WHERE eleitor_id='$id' ");
}
function retira_caracteres($texto){
	$acentos = array("Ã©","Ã§","Ã","Ã³","Ã£","Ã¡","Ãº","Ã¢","Ãµ","Ãª");
	$vogais  = array("é","ç","í","ó","ã","á","ú","â","õ","ê");
	
	$texto   = str_replace($acentos,$vogais,$texto);
	
	return $texto; 
	
}

function select_eleitores($dados=NULL){
	global $vkt_id;
	/* Filtros */

if($dados['mes_aniversariante']>0){ $filtro_grupo =" AND MONTH(e.data_nascimento) = '".$dados['mes_aniversariante']."'";}
if($dados['grupo_social_id']>0){ $filtro_grupo =" AND e.grupo_social_id = '{$dados[grupo_social_id]}'";}
if($dados['regiao_id']>0){ $filtro_regiao =" AND e.regiao_id= '{$dados['regiao_id']}'";}
if($dados['bairro']>0){ $filtro_bairro=" AND e.bairro= '{$dados['bairro']}'";}
if($dados['profissao_id']>0){ $filtro_profissao=" AND e.profissao_id= '{$dados['profissao_id']}'";}
if($dados['sexo']=='m'){ $filtro_sexo=" AND e.sexo= 'masculino'";}
if($dados['sexo']=='f'){ $filtro_sexo=" AND e.sexo= 'feminino'";}
if(!empty($dados['cidade'])){ $filtro_cidade=" AND e.cidade= '{$dados['cidade']}'";}
if(!empty($dados['estado'])){ $filtro_estado=" AND e.estado= '{$dados['estado']}'";}
if(!empty($dados['cep_inicio'])&&!empty($dados['cep_fim'])){
	
	$filtro_cep = "AND e.cep BETWEEN '".$dados['cep_inicio']."' AND '".$dados['cep_fim']."'";

}else if(!empty($dados['cep_inicio'])){
	
	$filtro_cep = "AND e.cep >= '".$dados['cep_inicio']."'";
	
}

$eleitores_q=mysql_query($t="
SELECT 
	e.id,
	e.nome,
	e.data_nascimento,
	e.cep,
	e.endereco,
	e.bairro,
	e.cidade,
	e.estado,
	e.telefone1,
	e.telefone2,
	email
	$exibe_email 
	$exibe_endereco
	$exibe_tel
	
	
FROM 
	eleitoral_eleitores as e
WHERE 
	e.vkt_id='$vkt_id' AND
	(e.telefone1 !='' OR e.telefone2 !=''
	OR e.email!='')
	
$filtro_bairro
$filtro_grupo
$filtro_profissao
$filtro_regiao
$filtro_sexo
$filtro_cidade
$filtro_estado
$filtro_cep
");

//	echo mysql_error();
	//return $eleitores_q;
	return $eleitores_q;
}

function exportar_eleitores($eleitores,$dados){

	//echo print_r($dados);

	while($eleitor = mysql_fetch_object($eleitores)){
		if(strlen($eleitor->nome)>0){
		  if($dados['opcao'][0]=='2'){
			  //$a="$eleitor->telefone1;$eleitor->telefone2";
			  if(strlen($eleitor->telefone1)>3){
				  $telefone=$eleitor->telefone1;
			  }else if(strlen($eleitor->telefone2)>3){
				  $telefone=$eleitor->telefone2;
			  }
			  
			  if(strlen($telefone)>3){
				  $info[] = strtoupper("$eleitor->nome;$telefone\n");
			  }
		  }
		}
		
		
		if($dados['opcao'][0]=='1' && $eleitor->email!=''){
		$info[] = strtoupper("$eleitor->nome;$eleitor->email\n");
		
		}
		
	
		
	}
	$infos = @implode("",$info);
	
	$file = "modulos/eleitoral/eleitores/eleitores.csv";
	@unlink("$file");
	$handle = fopen($file, 'a');
	fwrite($handle,$infos);
	fclose($handle);

	$i =date("Ymdhis");
	echo "<script>window.open('$file?$i')</script>";
	//exit();				
	


}

?>