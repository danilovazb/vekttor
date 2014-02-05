<?
//Empreendimento
function novaVenda(){
	/*
	1 - Cadastra novo Contrato
	2 - Altera statutus do empreendimento para pre-venda e para quem vendeu
	3 - de acordo com a negociação id
		cria boleto de entrada
		cria os boletos da  contrutora (mensal Semestral ou anual)
	*/	

	if(mysql_query($trace="
				INSERT INTO contrato SET
				cliente_fornecedor_id='".$_POST[cliente_id]."',
				disponibilidade_id='".$_POST[disponibilidade_id]."',
				negociacao_id='".$_POST[negociacao_id]."',
				valor='".moedaBrToUsa($_POST[valor])."',
				entrada_valor='".moedaBrToUsa($_POST[valor_entrada])."',
				entrada_parcelas='".$_POST[entrada_parcelas]."',
				entrada_juros='".moedaBrToUsa($_POST[entrada_juros])."',
				entrada_valor_parcela='".moedaBrToUsa($_POST[entrada_valor_parcelas])."',
				construtora_valor='".moedaBrToUsa($_POST[valor_construtora])."',
				construtora_parcelas='".$_POST[construtora_parcelas]."',
				construtora_periodo='".$_POST[construtora_periodo]."',
				construtora_valor_parcela='".moedaBrToUsa($_POST[construtora_valor_parcelas])."',
				banco_valor='".moedaBrToUsa($_POST[valor_banco])."',
				situacao='0'")){
					echo $trace;
		$contrato_id=mysql_insert_id();
		mysql_query("UPDATE disponibilidade set situacao= '1' WHERE id='$_POST[disponibilidade_id]'");
		
		// entrada
		for($i=0;$i<$_POST[venda_entrada_parcelas];$i++){
			$parcela_fatura = $i+1; 
			$dias_a_mais = ($i*30)+2;
			mysql_query("insert into faturas  SET
			contrato_id='$contrato_id',
			cliente_id='$_POST[cliente_id]',
			disponibilidade_id='$_POST[disponibilidade_id]',
			descricao='Entrada conforme contrato Nº.$contrato_id  $parcela_fatura/$_POST[venda_entrada_parcelas]',
			data_criacao=now(),
			data_vencimento=DATE_ADD(CURDATE(), INTERVAL $dias_a_mais DAY),
			valor='".moedaBrToUsa($_POST[construtora_valor_parcelas])."',
			situacao='0'");
		}
		
		
		
		// parcelas
		for($i=0;$i<$_POST[venda_construtora_parcelas];$i++){
			$parcela_fatura = $i+1;
			$dias_a_mais = (($i+1)*(30*$_POST[construtora_periodo] ))+2;
			mysql_query("insert into faturas  SET
			contrato_id='$contrato_id',
			cliente_id='$_POST[cliente_id]',
			disponibilidade_id='$_POST[disponibilidade_id]',
			descricao='Parcela $parcela_fatura/$_POST[venda_construtora_parcelas]  conforme contrato Nº.$contrato_id',
			data_criacao=now(),
			data_vencimento=DATE_ADD(CURDATE(), INTERVAL $dias_a_mais DAY),
			valor='".moedaBrToUsa($_POST[entrada_valor_parcelas])."',
			situacao='0'");
		}
		
		
		
		salvaUsuarioHistorico("Formulário - Contrato",'cadastrou','contrato',mysql_insert_id());
		echo "<script>location='?tela_id=70&id=$contrato_id'</script>";
		exit();
		
		return 1;
	}
	
	return 0;
}



function alteraContrato($id,$nome,$tipo,$orcamento,$inicio,$fim,$obs){
	/*
	somente enquanto está em pré-venda
	
	*/
}

function excluiContrato($id){
	
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