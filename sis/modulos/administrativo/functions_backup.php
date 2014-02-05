<?
//Funções 

//Validação de Dados para o Banco
function criaMenu($modulo_id){
}

function limitaTexto ($texto,$tamanho){
	return substr($texto,0,$tamanho);
}

function validaNumero ($numero){
	return is_numeric($numero);
}

function validaDataUsa ($data){
	$data_br=explode($data,"/");
	
	if(count($data_br)>0){
		$nova_data=dataBrToUsa($data);
		return $nova_data;
	}
	return 0;
}

function validaDataBr ($data){
	$data_usa=explode($data,"-");
	$data_br=explode($data,"/");
	
	if(count($data_usa)==3){
		$nova_data=dataUsaToBr($data);
		return $nova_data;
	}elseif(count($data_br)==3){
		return $data;
	}
	return 0;
}

function dataUsaToBr($d){// 2010-07-03 -> 03/07/2010

	$d1 = explode(" ",$d);
	if(count($d1)==2){
		$d2 = explode("-",$d1[0]);
	}else{
		$d2 = explode("-",$d);
	}
	if($d2[0]<1){$d2[0]='0000';}
	if($d2[1]<1){$d2[1]='00';}
	if($d2[2]<1){$d2[2]='00';}
	return $d2[2]."/".$d2[1]."/".$d2[0];
}

function dataBrToUsa($d){// 03/07/2010 -> 2010-07-03 
	
	$d2 = explode("/",$d);
	
	return $d2[2]."-".$d2[1]."-".$d2[0];
}

//Empreendimento
function cadastraEmpreendimento($nome,$tipo,$orcamento,$inicio,$fim,$obs){
	
	$erro=0;
	if($nome!=""){
		$nome=limitaTexto($nome,255);
	}else return 0;
	if($tipo!="Obra"&&$tipo!="Empreendimento")$erro=1;
	if(!validaNumero($orcamento))$erro=1;
	$inicio=validaDataUsa($inicio);
	$fim=validaDataUsa($fim);
	$obs=limitaTexto($obs,255);
	
	if($erro==0){
		mysql_query("
					INSERT INTO empreendimento SET
					nome='".$nome."',
					tipo='".$tipo."',
					orcamento='".$orcamento."',
					inicio='".$inicio."',
					fim='".$fim."',
					obs='".$obs."'
					");
		return 1;
	}
	
	return 0;
}

function alteraEmpreendimento($id,$nome,$tipo,$orcamento,$inicio,$fim,$obs){
	
	$erro=0;
	if($nome!=""){
		$nome=limitaTexto($nome,255);
	}else return 0;
	if($tipo!="Obra"&&$tipo!="Empreendimento")$erro=1;
	if(!validaNumero($orcamento))$erro=1;
	$inicio=validaDataUsa($inicio);
	$fim=validaDataUsa($fim);
	$obs=limitaTexto($obs,255);
	
	if($erro==0){
		mysql_query($trace="
					UPDATE empreendimento SET
					nome='".$nome."',
					tipo='".$tipo."',
					orcamento='".$orcamento."',
					inicio='".$inicio."',
					fim='".$fim."',
					obs='".$obs."'
					WHERE
					id='".$id."'
					");
					echo $trace;
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
		mysql_query("
					DELETE FROM empreendimento
					WHERE id='".$id."'
					");
		return 1;
	}
	
	return 0;
}



//Disponibilidade
function cadastraDisponibilidade($empreedimento_id,$identificacao,$tipo,$valor,$obs){
	
	$erro=0;
	if($empreedimento_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM empreendimento WHERE id='".$empreedimento_id."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	if($identificacao!=""){
		$identificacao=limitaTexto($identificacao,255);
	}else return 0;
	//if(!validaNumero($valor))$erro=1;
	
	if($erro==0){
		mysql_query($trace="
					INSERT INTO disponibilidade SET
					empreendimento_id='".$empreedimento_id."',
					identificacao='".$identificacao."',
					tipo='".$tipo."',
					valor='".$valor."',
					obs='".$obs."'
					");
		return 1;
	}
	
	return 0;
}

function alteraDisponibilidade($id,$empreedimento_id,$identificacao,$tipo,$valor,$obs){
	
	$erro=0;
	if($empreedimento_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM empreendimento WHERE id='".$empreedimento_id."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	if($identificacao!=""){
		$identificacao=limitaTexto($identificacao,255);
	}else return 0;
	if(!validaNumero($valor))$erro=1;
	
	if($erro==0){
		mysql_query($trace="
					UPDATE disponibilidade SET
					empreendimento_id='".$empreedimento_id."',
					identificacao='".$identificacao."',
					tipo='".$tipo."',
					valor='".$valor."',
					obs='".$obs."'
					WHERE
					id='".$id."'
					");
		return 1;
	}
	
	return 0;
}

function excluiDisponibilidade($id){
	
	$contrato=mysql_fetch_object(mysql_query("SELECT * FROM contrato WHERE disponibilidade_id='".$id."' LIMIT 1"));
	if($contrato->id>0)return 0;
	
	if($id>0){
		mysql_query("
					DELETE FROM disponibilidade
					WHERE id='".$id."'
					");
		return 1;
	}
	
	return 0;
}

//Reserva
function cadastraReserva($cliente_fornecedor_id,$disponibilidade_id,$negociacao_id,$entrada,$data_limite,$obs){
	
	$erro=0;
	if($cliente_fornecedor_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='".$cliente_fornecedor_id."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	if($disponibilidade_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade WHERE id='".$disponibilidade_id."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	if($negociacao_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM negociacao WHERE id='".$negociacao_id."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	
	//if(!validaNumero($entrada))$erro=1;
	$data_limite=validaDataUsa($data_limite);
	
	if($erro==0){
		mysql_query("
					INSERT INTO reserva SET
					cliente_fornecedor_id='".$cliente_fornecedor_id."',
					disponibilidade_id='".$disponibilidade_id."',
					negociacao_id='".$negociacao_id."',
					entrada='".$entrada."',
					data_limite='".$data_limite."',
					obs='".$obs."'
					");
		return 1;
	}
	
	return 0;
}

function alteraReserva($cliente_fornecedor_id,$disponibilidade_id,$negociacao_id,$entrada,$data_limite,$obs){
	
	$erro=0;
	if($cliente_fornecedor_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='".$cliente_fornecedor_id."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	if($disponibilidade_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade WHERE id='".$disponibilidade_id."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	if($negociacao_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM negociacao WHERE id='".$negociacao_id."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	
	//if(!$validaNumero($entrada))$erro=1;
	$data_limite=validaDataUsa($data_limite);
	
	if($erro==0&&$cliente_fornecedor_id>0&&$disponibilidade_id>0){
		mysql_query("
					UPDATE reserva SET
					cliente_fornecedor_id='".$cliente_fornecedor_id."',
					disponibilidade_id='".$disponibilidade_id."',
					negociacao_id='".$negociacao_id."',
					entrada='".$entrada."',
					data_limite='".$data_limite."',
					obs='".$obs."'
					WHERE cliente_fornecedor_id='".$cliente_fornecedor_id."' 
					AND disponibilidade_id='".$disponibilidade_id."' 
					");
		return 1;
	}
	
	return 0;
}

function excluiReserva($cliente_fornecedor_id,$disponibilidade_id){
	
	if($cliente_fornecedor_id>0&&$disponibilidade_id>0){
		mysql_query("
					DELETE FROM reserva
					WHERE cliente_fornecedor_id='".$cliente_fornecedor_id."' AND disponibilidade_id='".$disponibilidade_id."'
					");
		return 1;
	}
	
	return 0;
}

//Contrato
function cadastraContrato($cliente_fornecedor_id,$disponibilidade_id,$negociacao_id,$pagamento_id,$contrato_modelo_id,$entrada){
	
	$erro=0;
	if($cliente_fornecedor_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='".$cliente_fornecedor_id."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	if($disponibilidade_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade WHERE id='".$disponibilidade."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	if($negociacao_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM negociacao WHERE id='".$negociacao_id."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	if($pagamento_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM pagamento WHERE id='".$pagamento_id."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	if($contrato_modelo_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM contrato_modelo WHERE id='".$contrato_modelo_id."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	
	if(!$validaNumero($entrada))$erro=1;
	
	if($erro==0){
		mysql_query("
					INSERT INTO contrato SET
					cliente_fornecedor_id='".$cliente_fornecedor_id."',
					disponibilidade_id='".$disponibilidade_id."',
					negociacao_id='".$negociacao_id."',
					pagamento_id='".$pagamento_id."',
					contrato_modelo_id='".$contrato_modelo_id."',
					entrada='".$entrada."'
					");
		return 1;
	}
	
	return 0;
}

function alteraContrato($id,$cliente_fornecedor_id,$disponibilidade_id,$negociacao_id,$pagamento_id,$contrato_modelo_id,$entrada){
	
	$erro=0;
	if($cliente_fornecedor_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='".$cliente_fornecedor_id."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	if($disponibilidade_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM disponibilidade WHERE id='".$disponibilidade."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	if($negociacao_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM negociacao WHERE id='".$negociacao_id."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	if($pagamento_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM pagamento WHERE id='".$pagamento_id."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	if($contrato_modelo_id>0){
		$r=mysql_fetch_object(mysql_query("SELECT * FROM contrato_modelo WHERE id='".$contrato_modelo_id."' LIMIT 1"));
		if(!$r->id>0) return 0;
	}else return 0;
	
	if(!$validaNumero($entrada))$erro=1;
	
	if($erro==0&&$id>0){
		mysql_query("
					UPDATE contrato SET
					cliente_fornecedor_id='".$cliente_fornecedor_id."',
					disponibilidade_id='".$disponibilidade_id."',
					negociacao_id='".$negociacao_id."',
					pagamento_id='".$pagamento_id."',
					contrato_modelo_id='".$contrato_modelo_id."',
					entrada='".$entrada."'
					WHERE
					id='".$id."'
					");
		return 1;
	}
	
	return 0;
}

function excluiContrato($id){
	
	if($id>0){
		mysql_query("
					DELETE FROM contrato
					WHERE id='".$id."'
					");
		return 1;
	}
	
	return 0;
}

//Cliente Fornecedor
function cadastraClienteFornecedor($razao_social,$nome_fantasia,$nome_contato,$ramo_atividade,$cnpj_cpf,$rg,$suframa,$inscricao_municipal,$inscricao_estadual,$email,$telefone1,$telefone2,$fax,$cep,$endereco,$bairro,$cidade,$estado,$limite,$tipo,$tipo_cadastro){
	
	$erro=0;
	$razao_social=limitaTexto($razao_social,255);
	$nome_fantasia=limitaTexto($nome_fantasia,255);
	$nome_contato=limitaTexto($nome_contato,255);
	$ramo_atividade=limitaTexto($ramo_atividade,255);
	if($cnpj_cpf!=""){
		$cnpj_cpf=limitaTexto($cnpj_cpf,20);
	}else return 0;
	$rg=limitaTexto($rg,20);
	$suframa=limitaTexto($suframa,255);
	$inscricao_municipal=limitaTexto($inscricao_municipal,255);
	$inscricao_estadual=limitaTexto($inscricao_estadual,255);
	$email=limitaTexto($email,255);
	$telefone1=limitaTexto($telefone1,20);
	$telefone2=limitaTexto($telefone2,20);
	$fax=limitaTexto($fax,20);
	$cep=limitaTexto($cep,20);
	$endereco=limitaTexto($endereco,255);
	$bairro=limitaTexto($bairro,255);
	$cidade=limitaTexto($cidade,255);
	$estado=limitaTexto($estado,255);
	$limite=limitaTexto($limite,255);
	if($tipo!="Cliente"&&$tipo!="Fornecedor")return 0;
	if($tipo_cadastro!="Jurídico"&&$tipo_cadastro!="Físico")return 0;
	
	if($erro==0){
		mysql_query("
					INSERT INTO cliente_fornecedor SET
					razao_social='".$razao_social."',
					nome_fantasia='".$nome_fantasia."',
					nome_contato='".$nome_contato."',
					ramo_atividade='".$ramo_atividade."',
					cnpj_cpf='".$cnpj_cpf."',
					rg='".$rg."',
					suframa='".$suframa."',
					inscricao_municipal='".$inscricao_municipal."',
					inscricao_estadual='".$inscricao_estadual."',
					email='".$email."',
					telefone1='".$telefone1."',
					telefone2='".$telefone2."',
					fax='".$fax."',
					cep='".$cep."',
					endereco='".$endereco."',
					bairro='".$bairro."',
					cidade='".$cidade."',
					estado='".$estado."',
					limite='".$limite."',
					tipo='".$tipo."',
					tipo_cadastro='".$tipo_cadastro."'
					");
		return 1;
	}
	
	return 0;
}

function alteraClienteFornecedor($id,$razao_social,$nome_fantasia,$nome_contato,$ramo_atividade,$cnpj_cpf,$rg,$suframa,$inscricao_municipal,$inscricao_estadual,$email,$telefone1,$telefone2,$fax,$cep,$endereco,$bairro,$cidade,$estado,$limite,$tipo,$tipo_cadastro){
	
	$erro=0;
	$razao_social=limitaTexto($razao_social,255);
	$nome_fantasia=limitaTexto($nome_fantasia,255);
	$nome_contato=limitaTexto($nome_contato,255);
	$ramo_atividade=limitaTexto($ramo_atividade,255);
	if($cnpj_cpf!=""){
		$cnpj_cpf=limitaTexto($cnpj_cpf,20);
	}else return 0;
	$rg=limitaTexto($rg,20);
	$suframa=limitaTexto($suframa,255);
	$inscricao_municipal=limitaTexto($inscricao_municipal,255);
	$inscricao_estadual=limitaTexto($inscricao_estadual,255);
	$email=limitaTexto($email,255);
	$telefone1=limitaTexto($telefone1,20);
	$telefone2=limitaTexto($telefone2,20);
	$fax=limitaTexto($fax,20);
	$cep=limitaTexto($cep,20);
	$endereco=limitaTexto($endereco,255);
	$bairro=limitaTexto($bairro,255);
	$cidade=limitaTexto($cidade,255);
	$estado=limitaTexto($estado,255);
	$limite=limitaTexto($limite,255);
	if($tipo!="Cliente"&&$tipo!="Fornecedor")return 0;
	if($tipo_cadastro!="Jurídico"&&$tipo_cadastro!="Físico")return 0;
	
	if($erro==0){
		mysql_query($trace="
					UPDATE cliente_fornecedor SET
					razao_social='".$razao_social."',
					nome_fantasia='".$nome_fantasia."',
					nome_contato='".$nome_contato."',
					ramo_atividade='".$ramo_atividade."',
					cnpj_cpf='".$cnpj_cpf."',
					rg='".$rg."',
					suframa='".$suframa."',
					inscricao_municipal='".$inscricao_municipal."',
					inscricao_estadual='".$inscricao_estadual."',
					email='".$email."',
					telefone1='".$telefone1."',
					telefone2='".$telefone2."',
					fax='".$fax."',
					cep='".$cep."',
					endereco='".$endereco."',
					bairro='".$bairro."',
					cidade='".$cidade."',
					estado='".$estado."',
					limite='".$limite."',
					tipo='".$tipo."',
					tipo_cadastro='".$tipo_cadastro."'
					WHERE
					id='".$id."'
					");
		return 1;
	}
	
	return 0;
}

function excluiClienteFornecedor($id){
	
	$reserva=mysql_fetch_object(mysql_query("SELECT * FROM reserva WHERE cliente_fornecedor_id='".$id."' LIMIT 1"));
	if($reserva->id>0) return 0;
	if($id>0){
		mysql_query("
					DELETE FROM cliente_fornecedor
					WHERE id='".$id."'
					");
		return 1;
	}
	
	return 0;
}

//Usuário
function cadastraUsuario($nome,$usuario_tipo_id,$obra_id,$login,$senha){
	
	$erro=0;
	if($nome!=""){
		$nome=limitaTexto($nome,255);
	}else return 0;
	if(!validaNumero($usuario_tipo_id))$erro=1;
	if(!validaNumero($obra_id))$erro=1;
	$login=limitaTexto($login,45);
	$senha=limitaTexto($senha,45);
		
	if($erro==0){
		mysql_query("
					INSERT INTO usuario SET
					nome='".$nome."',
					usuario_tipo_id='".$usuario_tipo_id."',
					obra_id='".$obra_id."',
					login='".$login."',
					senha='".$senha."'
					");
		return 1;
	}
	
	return 0;
}

function alteraUsuario($id,$nome,$usuario_tipo_id,$obra_id,$login,$senha){
	
	$erro=0;
	if($nome!=""){
		$nome=limitaTexto($nome,255);
	}else return 0;
	if(!validaNumero($usuario_tipo_id))$erro=1;
	if(!validaNumero($obra_id))$erro=1;
	$login=limitaTexto($login,45);
	$senha=limitaTexto($senha,45);
		
	if($erro==0){
		mysql_query($trace="
					UPDATE usuario SET
					nome='".$nome."',
					usuario_tipo_id='".$usuario_tipo_id."',
					obra_id='".$obra_id."',
					login='".$login."',
					senha='".$senha."'
					WHERE
					id='".$id."'
					");
		return $trace;
	}
	
	return 0;
}

function excluiUsuario($id){
	
	$reserva=mysql_fetch_object(mysql_query("SELECT * FROM reserva WHERE cliente_fornecedor_id='".$id."' LIMIT 1"));
	if($reserva->id>0) return 0;
	if($id>0){
		mysql_query("
					DELETE FROM cliente_fornecedor
					WHERE id='".$id."'
					");
		return 1;
	}
	
	return 0;
}

//Tipo de Usuário
function cadastraUsuarioTipo($nome){
	
	if($nome!=""){
		$nome=limitaTexto($nome,20);
	}else return 0;
	
	mysql_query("
				INSERT INTO usuario_tipo SET
				nome='".$nome."
				");
	return 1;
}

function alteraUsuarioTipo($id,$nome){
	
	if($nome!=""){
		$nome=limitaTexto($nome,255);
	}else return 0;
	
	mysql_query("
				UPDATE usuario_tipo SET
				nome='".$nome."
				WHERE
				id='".$id."'
				");
				
	return 1;
}

function excluiUsuarioTipo($id){
	
	$usuario_tipo=mysql_fetch_object(mysql_query("SELECT * FROM usuario WHERE usuario_tipo_id='".$id."' LIMIT 1"));
	if($usuario_tipo->id>0) return 0;
	if($id>0){
		mysql_query("
					DELETE FROM usuario_tipo
					WHERE id='".$id."'
					");
		return 1;
	}
	
	return 0;
}

//Usuário Tipo com Módulos
function cadastraUsuarioTipoModulo($modulo_id,$usuario_tipo_id,$altera){
	
	$erro=0;
	
	if(!validaNumero($modulo_id))$erro=1;
	if(!validaNumero($usuario_tipo_id))$erro=1;
	if($altera>1||$altera<0)$erro=1;
	
	if($erro==0&&$modulo_id>0&&$usuario_tipo_id>0){
		mysql_query("
					INSERT INTO usuario_tipo_modulo SET
					modulo_id='".$modulo_id.",
					usuario_tipo_id='".$usuario_tipo_id.",
					altera='".$altera."
					");
		return 1;
	}
	return 0;
}

function alteraUsuarioTipoModulo($modulo_id,$usuario_tipo_id,$altera){
	
	$erro=0;
	
	if(!validaNumero($modulo_id))$erro=1;
	if(!validaNumero($usuario_tipo_id))$erro=1;
	if($altera>1||$altera<0)$erro=1;
	
	if($erro==0&&$modulo_id>0&&$usuario_tipo_id>0){
		mysql_query("
					UPDATE usuario_tipo_modulo SET
					altera='".$altera."
					WHERE
					modulo_id='".$modulo_id."
					AND
					usuario_tipo_id='".$usuario_tipo_id."
					");
		return 1;
	}
	return 0;
}

function excluiUsuarioTipoModulo($modulo_id,$usuario_tipo_id,$altera){
	
	$usuario_tipo=mysql_fetch_object(mysql_query("SELECT * FROM usuario WHERE usuario_tipo_id='".$id."' LIMIT 1"));
	if($usuario_tipo->id>0) return 0;
	if($id>0){
		mysql_query("
					DELETE FROM usuario_tipo
					WHERE id='".$id."'
					");
		return 1;
	}
	
	return 0;
}
?>