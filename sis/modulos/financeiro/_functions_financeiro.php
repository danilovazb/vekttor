<?

//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];


function criaFormaPagamento($forma_pagamento){
	global $vkt_id;
	$formas_qtd=mysql_result(mysql_query($a="SELECT COUNT(*) FROM financeiro_formas_pagamento WHERE vkt_id='$vkt_id'"),0,0);
	if($formas_qtd==0){
		foreach($forma_pagamento as $id=>$value){
			mysql_query("INSERT INTO financeiro_formas_pagamento SET vkt_id='$vkt_id', forma_pagamento_id='0', nome='$value', valor_percentual='0', valor_fixo='0', prazo_efetivacao='0', plano_conta_id='0', centro_custo_id='0', obs='$value'");
			$nova_forma_pagamento_id=mysql_insert_id();
			mysql_query("UPDATE financeiro_movimento SET forma_pagamento='$nova_forma_pagamento_id' WHERE cliente_id='$vkt_id' AND forma_pagamento='$id'");
		}
	}
	
}

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
	global $usuario_id;
	if($origem_id==NULL){
		$origem_id=$_POST['origem_id'];
	}
	if($origem_tipo==NULL){
		$origem_tipo=$_POST['origem_tipo'];
	}
	//$data_info_movimento=$data_vencimento;
	
	
	
	if($id<1){	
		$sql_inicio = "INSERT INTO ";
		$sql_fim = ",data_registro=NOW() ";
		
	}else{
		$sql_inicio = "UPDATE ";
		//$sql_fim = ",usuario_id_alterou='$usuario_id',data_alteracao=now() WHERE id ='$id'";
		$sql_fim = ",usuario_id_alterou='$usuario_id',data_alteracao=now() WHERE id ='$id'";
		salvaUsuarioHistorico("Formulário - Contas",'alterou','financeiro_movimento',$id);
		mysql_query("DELETE * FROM financeiro_movimento WHERE cliente_id='$cliente_id' AND origem_id='$id' ");
		/*if($forma_de_pagamento->id>0){
			$data_vencimento = mysql_result(mysql_query($b="SELECT DATE_ADD('$data_info_movimento', INTERVAL $forma_de_pagamento->prazo_efetivacao DAY) "),0,0);
		}*/

	}
	
	
	$financeiro_movimento = mysql_fetch_object(mysql_query("SELECT * FROM financeiro_movimento WHERE id='$id'"));
	/* SO PEGA O VALOR E ALTERA A DATA DE VCTO */
	$forma_de_pagamento=mysql_fetch_object(mysql_query($a="SELECT * FROM financeiro_formas_pagamento WHERE id='$forma_pagamento'"));
	/* pega a forma de pagamento */
	if($forma_de_pagamento->id>0){
		$valor_percentual 	= $valor_cadastro*($forma_de_pagamento->valor_percentual/100);
		$valor_fixo 		= $forma_de_pagamento->valor_fixo;
		$valor_total		= $valor_percentual+$valor_fixo;
		
		if($id>0){
			$data_vencimento = $data_vencimento;
		}else{
			/* cadastra a conta pra data de vencimento de acordo com o prazo de efetivação da forma de pagamento. (EX: cielo crédito cai depois de 30 dias na conta. data_vencimento + 30 dias) */
			$data_vencimento = mysql_result(mysql_query($b="SELECT DATE_ADD('$data_vencimento', INTERVAL $forma_de_pagamento->prazo_efetivacao DAY) "),0,0);
			//echo "$forma_de_pagamento->nome $forma_de_pagamento->prazo_efetivacao $b";
		}
	}
	
	
	
	if($action=='Excluir'){
			$movimento_id = $id;
			if($financeiro_movimento->status=='0'){
				mysql_query ($trace="UPDATE financeiro_movimento SET `status`='2' WHERE id='$movimento_id'");
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
			  	status='0',
				autorizado='0'
				";
		}
		$info = mysql_query($trace="
		$sql_inicio 
			financeiro_movimento 
		SET
					cliente_id='$cliente_id',
					internauta_id='$internauta_id',
					data_vencimento='$data_vencimento',
					ano_mes_referencia='$ano_mes_referencia',
					descricao='$descricao',
					nota='$nota',
					doc='$doc',
					forma_pagamento='$forma_pagamento',
					data_info_movimento='$data_info_movimento',
					origem_tipo='$origem_tipo',
					origem_id='$origem_id'
					$adicional	
		$sql_fim
					");
		//echo $trace.'<br>';
		//pr($_POST);
		if($id<1){
			//  id que acabou de cadastrar
			$movimento_id = mysql_insert_id();
			
			// SE FOR RECEBER VERIFICA SE TEM DEDUCAO E ADICIONA
			if($tipo=='receber'){
				if($forma_de_pagamento->id>0 && ($forma_de_pagamento->valor_percentual>0 || $forma_de_pagamento->valor_fixo>0 )){
					//$data_vencimento = mysql_result(mysql_query($b="SELECT DATE_ADD('$data_vencimento', INTERVAL $forma_de_pagamento->prazo_efetivacao DAY) "),0,0);
					pagarReceberInsert($cliente_id,0,$conta_id,$internauta_id,array($forma_de_pagamento->centro_custo_id),NULL,array(moedaUsaToBr($valor_total)),$data_vencimento,$ano_mes_referencia,$forma_de_pagamento->obs,$nota,$doc,$forma_de_pagamento->forma_pagamento_id,$valor_total,'pagar',$cliente,array($forma_de_pagamento->plano_conta_id),NULL,array(moedaUsaToBr($valor_total)),'Salvar',0,$data_info_movimento,$movimento_id,$forma_de_pagamento->nome);
				}
			}
			
			salvaUsuarioHistorico("Formulário - Contas",'cadastrou','financeiro_movimento',mysql_insert_id());
		}else{
			$seleciona_movimento_taxa=mysql_fetch_object(mysql_query($a="SELECT * FROM financeiro_movimento WHERE cliente_id='$cliente_id' AND origem_id='$id'  "));
			// id que veio do a
			$movimento_id = $id;
			mysql_query ("DELETE FROM financeiro_centro_has_movimento WHERE movimento_id='$movimento_id'") or die(mysql_error());
			mysql_query ("DELETE FROM financeiro_plano_has_movimento WHERE movimento_id='$movimento_id'")or die(mysql_error());
			if($tipo=='receber'){
				
				if(($forma_de_pagamento->valor_percentual>0 || $forma_de_pagamento->valor_fixo>0) && $seleciona_movimento_taxa->id>0 ){
					pagarReceberInsert($seleciona_movimento_taxa->cliente_id,$seleciona_movimento_taxa->id,$seleciona_movimento_taxa->conta_id,$seleciona_movimento_taxa->internauta_id,array($forma_de_pagamento->centro_custo_id),NULL,array(moedaUsaToBr($valor_total)),$seleciona_movimento_taxa->data_vencimento,$seleciona_movimento_taxa->ano_mes_referencia,$forma_de_pagamento->obs,$seleciona_movimento_taxa->nota,'',$seleciona_movimento_taxa->forma_pagamento,$valor_total,'pagar',$cliente,array($seleciona_movimento_taxa->plano_conta_id),NULL,array(moedaUsaToBr($valor_total)),'Salvar',0,$data_info_movimento,$movimento_id,$forma_de_pagamento->nome);
					
				}
			}
		}
		//echo "(".count($plano_valor). ")";
		
		for($i=0;$i<count($plano_valor);$i++){
			if(moedaBrToUsa($plano_valor[$i])>0){
				mysql_query($trace3="INSERT INTO financeiro_plano_has_movimento SET movimento_id='$movimento_id',plano_id='".$plano_de_conta_id[$i]."',valor='".moedaBrToUsa($plano_valor[$i])."'");

			}
				//echo "Não entrou (".$plano_valor[$i]. ")".moedaBrToUsa($plano_valor[$i]);
				//echo $trace3."<br/>";
		}
	
		for($i=0;$i<count($centro_valor);$i++){
			if(moedaBrToUsa($centro_valor[$i])>0){
				mysql_query($trace="INSERT INTO financeiro_centro_has_movimento SET movimento_id='$movimento_id',plano_id='".$centro_custo_id[$i]."',valor='".moedaBrToUsa($centro_valor[$i])."'");
				//echo "entrou".mysql_error()."<br/>";
				//echo $trace;
			}
		}
		financeiro_envia_arquivos($movimento_id);
		
		
		// SE TIVER NO CAIXA MANDA ELE PARA CONTAS A RECEBER OU A PAGAR 
		if($_GET[tela_id]==54&&$efetivar_movimento!=1){
			if($_POST[tipo]=='receber'){
				$numero_tela=53;
			}else{
				$numero_tela=52;
			}
			echo "<script>
			if(confirm('Conta enviadas para contas a ".$_POST[tipo].", deseja mudar de tela ?')){
				location='?tela_id=$numero_tela';
			}
			</script>";
		}
		
		
		/// INFORMAÇOES DE MOVIMENTACAO
		if($info==true){
			if($efetivar_movimento=='1'&&$financeiro_movimento->status==0){
				
				/// SE REBE DIMINUE SE PAGA ENTRA
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
function checaSaldo2($cliente_id,$conta_id){
	return @mysql_fetch_object(mysql_query("
	SELECT 
		saldo,id 
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
	"));
}

function movimenta($cliente_id,$conta_id,$movimento_id,$entrada,$saida,$tipo_movimento){
	
	$saldo = checaSaldo2($cliente_id,$conta_id);
	
	$novo_saldo = $entrada-$saida+$saldo->saldo;
	
	$calculo_aplicado = "$entrada-$saida+$saldo->saldo";
			
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
		status='1',
		id_anteiror='$saldo->id',
		saldo_anterior='$saldo->saldo',
		calculo_aplicado='$calculo_aplicado'
	WHERE
		id='$movimento_id'
	AND
		cliente_id='$cliente_id'
		")){
			
			/*
			criar campo id antes do movimento, saldo anterior, calculo aplicado
			*/
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

//add jaime

$tabela = ""; 
$controle = 0;

function exibe_option_sub_plano_ou_centro_1($plano_ou_centro,$pai_id,$id_do_selecionado,$nivel,$pai_ordem=null,$avo=NULL){
 global $vkt_id;
 
 $pai = mysql_fetch_object(mysql_query($p="SELECT * FROM financeiro_centro_custo WHERE id='$pai_id'"));
  $painome = $avo.'#@'.$pai->nome;
  $q= mysql_query($r="SELECT * FROM 
  							financeiro_centro_custo 
						WHERE cliente_id ='".$vkt_id."' 
						AND plano_ou_centro='$plano_ou_centro'  
						AND centro_custo_id = '$pai_id'  
						ORDER BY ordem,nome");
	$nivel++;
  if(strlen($pai_ordem)>0){
  	$pai_ordem = $pai_ordem.'.'.$pai->ordem;
  }else{
  	$pai_ordem = $pai->ordem;
  }
  
  $optgroup = "";	
  $cont = 0;
  while($r= mysql_fetch_object($q)){
	
	$filhos = @mysql_result(mysql_query($ff="SELECT count(*) FROM 
		  financeiro_centro_custo 
		  WHERE cliente_id ='".$vkt_id."' 
		  AND plano_ou_centro='$plano_ou_centro'  
		  AND centro_custo_id = '$r->id'"),0,0);			
						
						
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
	
	if($filhos > 0){
		$sel = $sel.' disabled="disabled" ';
	} 
	
	//echo "<select>  </select>";
	/*echo "<tr style='background:#F1F5FA'class='$r->id' $click >
			<td class='filter_centro' style=\"border:0;padding-left:".($nivel*10)."px\">$plano</td><td align='right' style=\"border:0; padding-right:3px;\">".moedaUsaToBr($valor)."</td>
		  </tr>";
	
	
	if($filhos>0){
		exibe_option_sub_plano_ou_centro_1($plano_ou_centro,$r->id,$id_do_selecionado,$nivel,$pai_ordem);
	}*/
	if($filhos > 0){
		
		echo "<optgroup label='$paiordem $r->nome' nivel='".$nivel."'> <option value='0' disabled='disabled'>  $paiordem $r->nome </option> ";
		exibe_option_sub_plano_ou_centro_1($plano_ou_centro,$r->id,$id_do_selecionado,$nivel,$pai_ordem,$painome);
		echo "</optgroup>";
		
	} else {
		
		//echo "<option value='$r->id'>y<div style='margin-left:".($nivel*15). "px'> x $paiordem $r->nome </div></option>\n"; 
		echo "<option $sel value='$r->id'> $painome#@$paiordem $r->nome </option>";
		//echo "<option value='$r->id'> $paiordem $r->nome </option>";  
	
	}
	
  }
  
  
}
function exibe_option_sub_plano_ou_centro_3($plano_ou_centro,$pai_id,$id_do_selecionado,$nivel,$pai_ordem=null,$vetor){
   
  global $vkt_id;
  
  
  $pai = mysql_fetch_object(mysql_query($t="SELECT * FROM financeiro_centro_custo WHERE cliente_id='$vkt_id' AND id='$pai_id' AND  plano_ou_centro ='$plano_ou_centro'"));
//  echo $t;
  
  $q= mysql_query($r="SELECT * FROM financeiro_centro_custo 
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
	
	
	$ano = date("Y");
	$mes = date("n");
	$planejado = mysql_fetch_object(mysql_query($g=" SELECT * FROM financeiro_orcamento_centro WHERE centro_plano_id = '$r->id' AND ano = '$ano' AND mes = '$mes' "));
	
	
	$plano_movimento = mysql_fetch_object(mysql_query($t=" SELECT SUM(valor) AS valor_plano 
			
			FROM financeiro_plano_has_movimento AS f_plano, financeiro_movimento AS f_movimento WHERE f_plano.movimento_id = f_movimento.id AND plano_id =  '$r->id' AND status = '1' ")); //fiancneiro_moviemto 
	//echo "$t\n";
	$valor = @$plano_movimento->valor_plano - @$planejado->valor;
	
		
	
	
	if($filhos>0){
		$sel = 0 ;
		$plano = "'$paiordem $r->nome',";
		
	}else{
		$sel = 1;
		$plano = " ' $paiordem $r->nome '";
	}
			
			
	$vetor[id][] 	= $r->id; 	
	$vetor[nome][]	=$plano;
	$vetor[valor][]	=moedaUsaToBr($valor);
	$vetor[clica][]	= $sel;
	
	if($filhos>0){
		
		$vetor = exibe_option_sub_plano_ou_centro_3($plano_ou_centro,$r->id,$id_do_selecionado,$nivel,$pai_ordem,$vetor);
	}
	
  }
  return $vetor;
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

//add 

function exibe_option_sub_plano_ou_centro2_1($plano_ou_centro,$pai_id,$id_do_selecionado,$nivel,$pai_ordem=null){
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
	
	
	$ano = date("Y");
	$mes = date("n");
	
	$planejado = mysql_fetch_object(mysql_query($g=" SELECT * FROM financeiro_orcamento_centro WHERE centro_plano_id = '$r->id' AND ano = '$ano' AND mes = '$mes' "));
	
	
	$centro_movimento = mysql_fetch_object(mysql_query($t=" SELECT SUM(valor) AS valor_plano 
	
	FROM financeiro_centro_has_movimento AS f_centro, financeiro_movimento AS f_movimento WHERE f_centro.movimento_id = f_movimento.id AND  plano_id =  '$r->id' AND status = '1' "));
	
	$valor = $centro_movimento->valor_plano - $planejado->valor;
	

	
	if($filhos>0){
		//$sel = $sel.' disabled="disabled" ';
		$click = "";
		$plano = "<span class='plano_pai'> $paiordem $r->nome </span>";
		
	}else{
		$click = "id='click_centro_custo'";
		$plano = " <strong> <span id='desc'> $paiordem <span id='descentro'> $r->nome </span></span> </strong>";
	}
	
	//echo "<select>  </select>";
	echo "<tr style='background:#F1F5FA'class='$r->id' $click >
			<td class='filter_centro' style=\"border:0;padding-left:".($nivel*10)."px\">$plano</td><td align='right' style=\"border:0; padding-right:3px;\">".moedaUsaToBr($valor)."</td>
		  </tr>";
	
	
	if($filhos>0){
		exibe_option_sub_plano_ou_centro2_1($plano_ou_centro,$r->id,$id_do_selecionado,$nivel,$pai_ordem);
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

function exibe_option_sub_plano_ou_centro_modelo($plano_ou_centro,$pai_id,$id_do_selecionado,$nivel,$pai_ordem=null,$filtro=null){
  $pai = mysql_fetch_object(mysql_query($a="SELECT * FROM financeiro_centro_custo_modelo WHERE id='$pai_id'"));
  
  $q= mysql_query($r="SELECT * FROM 
  							financeiro_centro_custo_modelo 
						WHERE 
							cliente_id ='".$_SESSION[usuario]->cliente_vekttor_id ."' 
						AND 
							plano_ou_centro='$plano_ou_centro'  
						AND  
							centro_custo_id = '$pai_id'
						$filtro
						ORDER BY ordem,nome");
  $nivel++;
  if(strlen($pai_ordem)>0){
  	$pai_ordem = $pai_ordem.'.'.$pai->ordem;
  }else{
  	$pai_ordem = $pai->ordem;
  }
	
  while($r= mysql_fetch_object($q)){
	$filhos = @mysql_result(mysql_query("SELECT count(*) FROM 
  							financeiro_centro_custo_modelo 
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
	echo  "<option $sel style=\"padding-left:".($nivel*10)."px\" ordenacao='$paiordem' value='$r->id'>$paiordem ".($r->nome)."</option>";
	if($filhos>0){
		exibe_option_sub_plano_ou_centro_modelo($plano_ou_centro,$r->id,$id_do_selecionado,$nivel,$pai_ordem);
	}
  }
}

function conscilia($movimento_id,$consilia_desconsilia){
	global $vkt_id;
	echo "$movimento_id,$consilia_desconsilia";
	if($movimento_id>0){
	echo "Entrou na funcao";
		mysql_query($t="UPDATE financeiro_movimento SET conciliado='$consilia_desconsilia' WHERE id='$movimento_id' AND cliente_id='$vkt_id' ");
		//echo $t;
	}
}

function Duplicar(){
	global $vkt_id;
	
	$Select = mysql_fetch_object(mysql_query(" SELECT * FROM financeiro_movimento WHERE cliente_id = '$vkt_id' AND id = '".$_POST["id"]."' "));
	
	$sqlMovimentacao = " INSERT INTO financeiro_movimento SET
	cliente_id = '".$Select->cliente_id."',
	conta_id   = '".$Select->conta_id."',
	internauta_id = '".$Select->internauta_id."',
	usuario_id_alterou = '".$Select->usuario_id_alterou."',
	data_registro = '".$Select->data_registro."',
	data_alteracao = '".$Select->data_alteracao."',
	data_vencimento = '".$Select->data_vencimento."',
	ano_mes_referencia = '".$Select->ano_mes_referencia."',
	descricao = '".$Select->descricao."',
	nota      = 'Duplicado',
	doc = '".$Select->doc."',
	forma_pagamento = '".$Select->forma_pagamento."',
	valor_cadastro = '".$Select->valor_cadastro."',
	tipo = '".$Select->tipo."',
	data_movimento = '".$Select->data_movimento."',
	data_info_movimento = '".$Select->data_info_movimento."',
	status = '".$Select->status."' ,
	entrada = '".$Select->entrada."',
	saida = '".$Select->saida."',
	saldo = '".$Select->saldo."',
	movimentacao = '".$Select->movimentacao."',
	autorizado = '".$Select->autorizado."',
	origem_id = '".$Select->origem_id."' ,
	origem_tipo = '".$Select->origem_tipo."',
	arquivo_conta_ext = '".$Select->arquivo_conta_ext."',
	arquivo_autentica_ext = '".$Select->arquivo_autentica_ext."',
	extorno = '".$Select->extorno."',
	transferencia = '".$Select->transferencia."' ,
	conciliado = '".$Select->conciliado."',
	id_anteiror = '".$Select->id_anteiror."',
	saldo_anterior = '".$Select->saldo_anterior."',
	calculo_aplicado = '".$Select->calculo_aplicado."'";
	mysql_query($sqlMovimentacao);
	$movID = mysql_insert_id();
	
	
	//Recebe os centros e planos		
	$centro_custo_id = $_POST['centro_custo_id'];
	$centro_valor    = $_POST['centro_valor'];
	
	for($i=0;$i < sizeof($centro_custo_id);$i++){
		
	  $sqlCentroAsMov = " INSERT INTO financeiro_centro_has_movimento SET movimento_id = '$movID', plano_id = '$centro_custo_id[$i]', valor = '".moedaBRToUsa($centro_valor[$i])."'";
	  mysql_query($sqlCentroAsMov); 
	  
	}
	
	$plano_contas_id = $_POST['plano_de_conta_id'];
	$plano_valor = $_POST['plano_valor'];
	
	for($i=0;$i < sizeof($plano_contas_id);$i++){
		
	  $sqlPlanoAsMov = " INSERT INTO financeiro_plano_has_movimento SET movimento_id = '$movID', plano_id = '$plano_contas_id[$i]', valor = '".moedaBRToUsa($plano_valor[$i])."'";
	  mysql_query($sqlPlanoAsMov); 
	  
	}
	
	return $movID;
	
}


?>