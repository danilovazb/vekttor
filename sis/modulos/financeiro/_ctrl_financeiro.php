<?

//Ações do Formulário
$tabela = "financeiro_movimento";
//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];

if($_POST['Action_Duplicar'] == "Duplicar"){
	$result = Duplicar();
	
	if($result){
		echo "<script> window.open('modulos/financeiro/form_movimentacao.php?id=".$result."','carregador'); </script>";	
	}
}

//Cadastra Registro
if(isset($_POST['action'])){
	
	if($_POST['repetir']=='0'){
		
		$retorno = pagarReceberInsert($_SESSION[usuario]->cliente_vekttor_id,
							$_POST['id'],
							$_POST['conta_id'],
							$_POST['internauta_id'],
							$_POST['centro_custo_id'],
							$_POST['centro_custo'],
							$_POST['centro_valor'],
							dataBrToUsa($_POST['data_vencimento']),
							$_POST['ano_mes_referencia'],
							$_POST['descricao'],
							$_POST['nota'],
							$_POST['doc'],
							$_POST['forma_pagamento'],
							moedaBrToUsa($_POST['valor_cadastro']),
							$_POST['tipo_f'],
							$_POST['cliente'],
							$_POST['plano_de_conta_id'],
							$_POST['plano_de_conta'],
							$_POST['plano_valor'],
							$_POST['action'],
							$_POST['efetivar_movimento'],
							dataBrToUsa($_POST['data_info_movimento']));
		if($retorno!='ok'){
			echo "<script>alert('Erro $retorno')</script>";	
		}
	}else{
		
		for($i=0;$i<=$_POST['repetir'];$i++){
			
			$data_split=explode("/",$_POST[data_vencimento]);			
			
			if($_POST['tipo_repetir']=='semana'){
				$sintax_sql = "INTERVAL $i WEEK";
			}
			
			if($_POST['tipo_repetir']=='quinzenas'){
				$dias = $i*15;
				
				$sintax_sql = "INTERVAL $dias DAY";
			}
			if($_POST['tipo_repetir']=='mes'){
				$sintax_sql = "INTERVAL $i MONTH";
			}
			
			$data_venc = mysql_result(mq($q="SELECT DATE_FORMAT( DATE_ADD('{$data_split[2]}-{$data_split[1]}-{$data_split[0]}', $sintax_sql ),'%Y-%m-%d')"),0,0);
			
			
			//echo "$q((".$data_venc."))<br />\n\n\n\n\n\n\n\n";
			$retorno = pagarReceberInsert($_SESSION[usuario]->cliente_vekttor_id,
								$_POST['id'],
								$_POST['conta_id'],
								$_POST['internauta_id'],
								$_POST['centro_custo_id'],
								$_POST['centro_custo'],
								$_POST['centro_valor'],
								$data_venc,
								$_POST['ano_mes_referencia'],
								$_POST['descricao'],
								$_POST['nota'].($i+1)."/".($_POST['repetir']+1),
								$_POST['doc'],
								$_POST['forma_pagamento'],
								moedaBrToUsa($_POST['valor_cadastro']),
								$_POST['tipo_f'],
								$_POST['cliente'],
								$_POST['plano_de_conta_id'],
								$_POST['plano_de_conta'],
								$_POST['plano_valor'],
								$_POST['action'],
								$_POST['efetivar_movimento'],
								dataBrToUsa($_POST['data_info_movimento'])
								);

			if($retorno!='ok'){
				echo "<script>alert('Erro $retorno')</script>";	
			}
		}
	}
}
if($_GET['extorno']>0&&$_GET['conta_id']>0){
	$retorno_do_extorno = extorno($_GET['extorno'],$_GET['recria']);
	if($_GET['conta_id']&&$retorno_do_extorno>0){
		echo "<script>window.open('modulos/financeiro/form_movimentacao.php?id=$retorno_do_extorno','carregador');</script>";
	}
}
if($_POST['transferencia_entrecontas']==1){
	transferencia_entre_contas($_POST['conta_id_origem'],$_POST['conta_id_destino'],$_POST['valor_transferido'],$_POST['data_transferencia']);
}

//Pega informações
if($id>0){
	$obj=mysql_fetch_object(mysql_query($t="SELECT *,date_format(data_movimento,'%d/%m/%Y às %H:%i') dtmov,date_format(data_registro,'%d/%m/%Y às %H:%i') dtregistro FROM $tabela WHERE  cliente_id='$vkt_id' AND id='".$id."' LIMIT 1"));
	//echo $t;
	//pr($obj);
	$cliente=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='".$obj->internauta_id."' LIMIT 1"));
	$forma_de_pagemento=mysql_fetch_object(mysql_query("SELECT * FROM financeiro_formas_pagamento WHERE vkt_id='$vkt_id' AND id='".$obj->forma_pagamento."' LIMIT 1"));
	if($forma_de_pagemento->id>0){
		$taxas=array();
		if($forma_de_pagemento->valor_percentual>0||$forma_de_pagemento->valor_fixo>0){
			if($forma_de_pagemento->valor_percentual>0){
				$taxas[]=moedaUsaToBr($forma_de_pagemento->valor_percentual)."%";
				
			}
			if($forma_de_pagemento->valor_fixo>0) {
				$taxas[]="R$".moedaUsaToBr($forma_de_pagemento->valor_fixo);
			}
			$taxas=implode(" + ",$taxas);
			$valor_taxas = "Taxas: R$".moedaUsaToBr(($obj->valor_cadastro*($forma_de_pagemento->valor_percentual/100))+$forma_de_pagemento->valor_fixo);
		}
		
		if($forma_de_pagemento->prazo_efetivacao>0){
			//$data_vencimento = mysql_result(mysql_query($a="SELECT DATE_FORMAT(DATE_ADD('$vencimento', INTERVAL $prazo_efetivacao DAY),'%d/%m/%Y')"),0,0);
			echo mysql_error();
			$data_vencimento_info="Vencimento + $forma_de_pagemento->prazo_efetivacao dias";
		}
	}
	salvaUsuarioHistorico("Formulário - Conta a pagar",'Exibe',$tabela,$id);
}


	$forma_pagamento = array("1"=>"Dinheiro",
							 "2"=>"Cheque",
							 "7"=>"Transferência",
							 "4"=>"Boleto",
							 "5"=>"Permuta",
							 "6"=>"Outros",
							 "8"=>"Depósito",
							 "3"=>"Cartão Crédito Visa",
							 "9"=>"Cartão Crédito Master",
							 "10"=>"Débito Master",
							 "11"=>"Débito Visa",
							 "12"=>"Cielo Débito",
							 "13"=>"Cielo Crédito");


?>