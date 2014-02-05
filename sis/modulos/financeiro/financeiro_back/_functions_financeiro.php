<?

//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];

//Funções de Geral de Financeiro

$tabela ='financeiro_movimento';
function pagarReceberInsert($cliente_id,
							$id,
							$conta_id,
							$internauta_id,
							$centro_custo_id,
							$centro_custo,
							$centro_valor,
							$data_vencimento,
							$ano_mes_referencia,
							$descricao,
							$nota,
							$doc,
							$forma_pagamento,
							$valor_cadastro,
							$tipo,
							$cliente,
							$plano_de_conta_id,
							$plano_de_conta,
							$plano_valor,
							$action,
							$efetivar_movimento,
							$data_info_movimento,
							$origem_id=NULL,
							$origem_tipo=NULL
							){
	if($origem_id==NULL){
		$origem_id=$_POST['origem_id'];
	}
	if($origem_tipo==NULL){
		$origem_tipo=$_POST['origem_tipo'];
	}
								
	if($id<1){
		$sql_inicio = "insert into ";
		$sql_fim = "";
	}else{
		$sql_inicio = "UPDATE ";
		$sql_fim = " WHERE id ='$id'";
		salvaUsuarioHistorico("Formulário - Contas",'alterou','financeiro_movimento',$id);
	}
	
	
	$financeiro_movimento = mysql_fetch_object(mysql_query("SELECT * FROM financeiro_movimento WHERE id='$id'"));
	if($action=='Excluir'){
			$movimento_id = $id;
		
			if($financeiro_movimento->status=='0'){
				mysql_query ($trace="UPDATE financeiro_movimento SET `status`='2' WHERE id='$movimento_id'");
				//alert($trace);
				
				return 'ok';
			}else{
				return 'Este registro já foi efetivado, podendo somente ser extornado e não deletado';
			}
			
	}elseif($action=='Salvar'){
		
		if($financeiro_movimento->status!=1){
			$adicional = "
			  	,conta_id='$conta_id', 
			  	valor_cadastro='$valor_cadastro',
			  	tipo='$tipo',
			  	status='0'
				";
		}
		
		$info = mysql_query($trace="$sql_inicio financeiro_movimento SET
					cliente_id='$cliente_id',
					internauta_id='$internauta_id',
					data_registro=now(),
					data_vencimento='$data_vencimento',
					ano_mes_referencia='$ano_mes_referencia',
					descricao='$descricao',
					nota='$nota',
					doc='$doc',
					forma_pagamento='$forma_pagamento',
					data_info_movimento='$data_info_movimento',
					origem_tipo='$origem_tipo',
					origem_id='$origem_id',
					autorizado='0'
					$adicional
				
					$sql_fim
					") or die(mysql_error());
	//echo $trace;
		if($id<1){
			$movimento_id = mysql_insert_id();
			salvaUsuarioHistorico("Formulário - Contas",'cadastrou','financeiro_movimento',mysql_insert_id());
		}else{
			$movimento_id = $id;
			mysql_query ("DELETE FROM financeiro_centro_has_movimento WHERE movimento_id='$movimento_id'") or die(mysql_error());
			mysql_query ("DELETE FROM financeiro_plano_has_movimento WHERE movimento_id='$movimento_id'")or die(mysql_error());
		}
		//echo "(".count($plano_valor). ")";
		financeiro_envia_arquivos($movimento_id);
		for($i=0;$i<count($plano_valor);$i++){
			if(moedaBrToUsa($plano_valor[$i])>0){
				mysql_query($trace="INSERT INTO financeiro_plano_has_movimento SET movimento_id='$movimento_id',plano_id='".$plano_de_conta_id[$i]."',valor='".moedaBrToUsa($plano_valor[$i])."'");

			}
				//echo "Não entrou (".$plano_valor[$i]. ")".moedaBrToUsa($plano_valor[$i]);
		}
	
		for($i=0;$i<count($centro_valor);$i++){
			if(moedaBrToUsa($centro_valor[$i])>0){
				mysql_query($trace="INSERT INTO financeiro_centro_has_movimento SET movimento_id='$movimento_id',plano_id='".$centro_custo_id[$i]."',valor='".moedaBrToUsa($centro_valor[$i])."'");
	
				//echo "entrou".mysql_error();
			}
		}
		
		if($info==true){
			if($efetivar_movimento=='1'){
				if($tipo=='receber'){
					$entrada=$valor_cadastro;
					$saida =0;
				}else{
					$entrada=0;
					$saida =$valor_cadastro;
				}
				if(movimenta($cliente_id,$conta_id,$movimento_id,$entrada,$saida,'financeiro')){
					return 'ok';
				}else{
					return 'Erro na Movimentação';
				}
			}else{
				return 'ok';
			}
		}else{
			return 'Erro de Mysql'.str_replace("'","\'",mysql_error());
		}
	
	}
}

function checaSaldo($cliente_id,$conta_id){
	return @mysql_result(mysql_query("
	SELECT 
		saldo 
	FROM
		financeiro_movimento
	WHERE 
			cliente_id='$cliente_id' 
		AND 
			conta_id='$conta_id'
		AND
			`status`='1'
	ORDER BY
		data_movimento DESC
	LIMIT 1
	"),0,0);
}

function movimenta($cliente_id,$conta_id,$movimento_id,$entrada,$saida,$tipo_movimento){
	
	$saldo = checaSaldo($cliente_id,$conta_id);
	
	$novo_saldo = $entrada-$saida+$saldo;
	if(mysql_query($trace_m="
	UPDATE 
		financeiro_movimento 
	SET 
		data_movimento=now(),
		entrada='$entrada',
		saida='$saida',
		saldo='$novo_saldo',
		movimentacao='$tipo_movimento',
		conta_id='$conta_id',
		`status`='1'
	WHERE
		id='$movimento_id'
	AND
		cliente_id='$cliente_id'
		")){
		return true	;	
	}else{
		return false;		
	}
	echo $trace_m;
}

function financeiro_envia_arquivos($movimento_id){
	
	$filis_autorizados = array('jpg','gif','png','pdf');
	
	$infomovimento = mysql_fetch_object(mysql_query("SELECT * FROM financeiro_movimento WHERE id='$movimento_id'"));
	
	if(strlen($_FILES['autenticacao']['name'])>4){
	  $pasta 	= 'modulos/financeiro/arquivo_autenticacao/';
	  $extensao = strtolower(substr($_FILES['autenticacao']['name'],-3));
	  $arquivo 	= $pasta.$movimento_id.'.'.$extensao;
	  $arquivodel= $pasta.$movimento_id.'.'.$infomovimento->arquivo_autentica_ext;
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['autenticacao'][tmp_name],$arquivo)){
			  mysql_query("UPDATE financeiro_movimento SET arquivo_autentica_ext='$extensao' WHERE id='$movimento_id'");
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	
	if(strlen($_FILES['arquivo']['name'])>4){
	  $pasta 	= 'modulos/financeiro/arquivo_conta/';
	  $extensao = strtolower(substr($_FILES['arquivo']['name'],-3));
	  $arquivo 	= $pasta.$movimento_id.'.'.$extensao;
	  $arquivodel= $pasta.$movimento_id.'.'.$infomovimento->arquivo_conta_ext;
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['arquivo'][tmp_name],$arquivo)){
			  mysql_query("UPDATE financeiro_movimento SET  arquivo_conta_ext='$extensao' WHERE id='$movimento_id'");
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de arquivo Inadequado: $extensao");  
	  }
	}
	
}

function financeiro_remove_arquivos($movimento_id,$tipo,$extencao){
	if($tipo== 'arquivo'){
	  $infosql = 'arquivo_conta_ext';
	  $pasta 	= 'arquivo_conta/';
	}else{
	  $pasta 	= 'arquivo_autenticacao/';
	  $infosql = 'arquivo_autentica_ext';
	}
	$arquivodel= $pasta.$movimento_id.'.'.$extencao;
	//echo $arquivodel;
	@unlink($arquivodel);
  	mysql_query("UPDATE financeiro_movimento SET  $infosql='' WHERE id='$movimento_id'");

}

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

function exibe_option_sub_plano_ou_centro2($plano_ou_centro,$pai_id,$id_do_selecionado,$nivel,$pai_ordem=null){
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
	if(strlen($pai_ordem)>0){
		$paiordem= "$pai_ordem.$r->ordem";
	}else{
		$paiordem= "$r->ordem";
	}
	echo  "<option $sel style=\"padding-left:".($nivel*10)."px\" ordenacao='$paiordem' value='$r->id'>$paiordem $r->nome</option>";
	if($filhos>0){
		exibe_option_sub_plano_ou_centro2($plano_ou_centro,$r->id,$id_do_selecionado,$nivel,$pai_ordem);
	}
  }
}

function extorno_cria_movimento($movimento_id){
	global $vkt_id;
	
	
}

function extorno($movimento_id,$recria){
	global $vkt_id;
	/*
	atualiza o tipo de movimentacao  do movimento selecionado
	cria outra movimentação  con valor invertido informando que foi extornado
	*/
	
	$movimento = mysql_fetch_object(mysql_query("SELECT * FROM financeiro_movimento WHERE id='$movimento_id' AND cliente_id ='$vkt_id'"));	
	if($movimento->extorno==0){
		
		if($tipo=='receber'){
			$tipo ='pagar';
		}else{
			$tipo ='receber';
		}
		
		$entrada= $movimento->saida;
		$saida	= $movimento->entrada;
		mysql_query("INSERT INTO financeiro_movimento SET
						cliente_id='$vkt_id',
						internauta_id='$movimento->internauta_id',
						data_registro=now(),
						data_vencimento='$movimento->data_vencimento',
						ano_mes_referencia='$movimento->ano_mes_referencia',
						descricao='(R) $movimento->descricao',
						nota='$movimento->nota',
						doc='$movimento->doc',
						forma_pagamento='$movimento->forma_pagamento',
						data_info_movimento=NOW(),
						origem_tipo='Extorno',
						origem_id='$movimento->id',
						autorizado='1',
						conta_id='$movimento->conta_id', 
						valor_cadastro='$movimento->valor_cadastro',
						tipo='$tipo',
						extorno='1',
						status='0'");
		$movimento_criado_id =mysql_insert_id();
		$qmhc=mysql_query("SELECT * FROM financeiro_centro_has_movimento WHERE movimento_id='$movimento_id'");
		while($r= mysql_fetch_object($qmhc)){
			mysql_query("INSERT INTO financeiro_centro_has_movimento SET movimento_id='$movimento_criado_id', plano_id='$r->plano_id', valor='$r->valor'");
		}
		$qmhp=mysql_query("SELECT * FROM financeiro_plano_has_movimento WHERE movimento_id='$movimento_id'");
		while($r= mysql_fetch_object($qmhp)){
			mysql_query("INSERT INTO financeiro_plano_has_movimento SET movimento_id='$movimento_criado_id', plano_id='$r->plano_id', valor='$r->valor'");
		}
		movimenta($vkt_id,$movimento->conta_id,$movimento_criado_id,$entrada,$saida,'fisico');
	
		mysql_query("UPDATE financeiro_movimento SET extorno='1',movimentacao='fisico',descricao='(E) $movimento->descricao' WHERE id='$movimento_id' AND cliente_id ='$vkt_id'");
		
		if($recria==1&&$movimento->transferencia==0){
			mysql_query("INSERT INTO financeiro_movimento SET
							cliente_id='$vkt_id',
							internauta_id='$movimento->internauta_id',
							data_registro=now(),
							data_vencimento='$movimento->data_vencimento',
							ano_mes_referencia='$movimento->ano_mes_referencia',
							descricao='$movimento->descricao',
							nota='$movimento->nota',
							doc='$movimento->doc',
							forma_pagamento='$movimento->forma_pagamento',
							data_info_movimento='$movimento->data_info_movimento',
							origem_tipo='$movimento->origem_tipo',
							origem_id='$movimento->origem_id',
							autorizado='0',
							conta_id='$movimento->conta_id', 
							valor_cadastro='$movimento->valor_cadastro',
							tipo='$movimento->tipo',
							status='0'");
			$movimento_criado_id =mysql_insert_id();
			$qmhc=mysql_query("SELECT * FROM financeiro_centro_has_movimento WHERE movimento_id='$movimento_id'");
			while($r= mysql_fetch_object($qmhc)){
				mysql_query("INSERT INTO financeiro_centro_has_movimento SET movimento_id='$movimento_criado_id', plano_id='$r->plano_id', valor='$r->valor'");
			}
			$qmhp=mysql_query("SELECT * FROM financeiro_plano_has_movimento WHERE movimento_id='$movimento_id'");
			while($r= mysql_fetch_object($qmhp)){
				mysql_query("INSERT INTO financeiro_plano_has_movimento SET movimento_id='$movimento_criado_id', plano_id='$r->plano_id', valor='$r->valor'");
			}
			return $movimento_criado_id;
		}else{
			if($movimento->transferencia==1){
				extorno($movimento->doc,0);
			}
			return "extornou";
		}
	}
	
}

function transferencia_entre_contas($conta_origem_id,$conta_destino_id,$valor_transferido,$data){
	global $vkt_id;
	$valor_transferido = str_replace(".",'',$valor_transferido);
	$valor_transferido = str_replace(",",'.',$valor_transferido)*1;
	$conta_origem = mysql_fetch_object(mysql_query("SELECT * FROM financeiro_contas WHERE id ='$conta_origem_id'"));
	$conta_destino = mysql_fetch_object(mysql_query("SELECT * FROM financeiro_contas WHERE id ='$conta_destino_id'"));
	
	$internauta_id = '';
	
	// insere movimento origem
	mysql_query($d="INSERT INTO financeiro_movimento SET
					cliente_id='$vkt_id',
					internauta_id='$internauta_id',
					data_registro=now(),
					data_vencimento=now(),
					ano_mes_referencia=date_format(now(),'%Y/%m'),
					descricao='(TE) Transferencia entre contas: $conta_origem->nome para  $conta_destino->nome',
					nota='$conta_origem->nome $conta_origem->agencia $conta_origem->conta para  $conta_destino->nome $conta_destino->agencia $conta_destino->conta ',
					doc='',
					forma_pagamento='0',
					data_info_movimento='".dataBrToUsa($data)."',
					origem_tipo='Transferencia',
					origem_id='',
					autorizado='1',
					conta_id='$conta_origem_id', 
					valor_cadastro='$valor_transferido',
					tipo='pagar',
					extorno='0',
					transferencia='1'");			
	$movimento_origem = mysql_fetch_object(mysql_query("SELECT * FROM financeiro_movimento WHERE id ='".mysql_insert_id()."'"));
	
	// insere movimento Destino
	mysql_query("INSERT INTO financeiro_movimento SET
					cliente_id='$vkt_id',
					internauta_id='$internauta_id',
					data_registro=now(),
					data_vencimento=now(),
					ano_mes_referencia=date_format(now(),'%Y/%m'),
					descricao='(TR) Transferencia entre contas: $conta_origem->nome para  $conta_destino->nome',
					nota='$movimento_origem->id',
					doc='$movimento_origem->id',
					forma_pagamento='0',
					data_info_movimento='".dataBrToUsa($data)."',
					origem_tipo='Transferencia',
					origem_id='$movimento_origem->id',
					autorizado='1',
					conta_id='$conta_destino_id', 
					valor_cadastro='$valor_transferido',
					tipo='receber',
					extorno='0',
					transferencia='1'");
					
	$movimento_destino = mysql_fetch_object(mysql_query("SELECT * FROM financeiro_movimento WHERE id ='".mysql_insert_id()."'"));
	
	mysql_query("UPDATE financeiro_movimento SET doc='$movimento_destino->id' WHERE id='$movimento_origem->id'");
	
	movimenta($vkt_id,$movimento_origem->conta_id,$movimento_origem->id,0,$movimento_origem->valor_cadastro,'financeiro');
	movimenta($vkt_id,$movimento_destino->conta_id,$movimento_destino->id,$movimento_destino->valor_cadastro,0,'financeiro');
}

function conscilia($movimento_id,$consilia_desconsilia){
	global $vkt_id;
	echo "$movimento_id,$consilia_desconsilia";
	if($movimento_id>0){
	echo "Entrou na funcao";
		mysql_query($t="UPDATE financeiro_movimento SET conciliado='$consilia_desconsilia' WHERE id='$movimento_id' AND cliente_id='$vkt_id' ");
		echo $t;
	}
}


?>