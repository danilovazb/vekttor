<?
//Ações do Formulário

//Recebe ID
if($_POST['id'])$id=$_POST['id'];
if($_GET['id'])$id=$_GET['id'];

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
							$_POST['tipo'],
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
				
			$data_venc=date("Y-m-d",mktime(0,0,0,$data_split[1]+$i,$data_split[0],$data_split[2]));
			
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
								$_POST['tipo'],
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
	$obj=mysql_fetch_object(mysql_query("SELECT * FROM $tabela WHERE id='".$id."' LIMIT 1"));
	$cliente=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='".$obj->internauta_id."' LIMIT 1"));
	//print_r($cliente);
	salvaUsuarioHistorico("Formulário - Conta a pagar",'Exibe',$tabela,$id);
}

?>