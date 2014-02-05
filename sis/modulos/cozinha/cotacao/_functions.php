<?
	function cadastraCotacao($necessidade_id,$fornecedor_id,$vkt_id){
		$sql=mysql_query($t="INSERT INTO cozinha_cotacao SET 			                                 																																														             vkt_id='$vkt_id',necessidade_id='$necessidade_id',fornecedor_id='$fornecedor_id', almoxarifado_id='5', data_cotacao='".date('Y-m-d')."'");
		
		
				
		return mysql_insert_id();  
		
	}
	
	function manipula_necessidade($dados){
	
		global $vkt_id;
		
		mysql_query($t="INSERT INTO cozinha_necessidade 
		SET
			vkt_id='$vkt_id', necessidade_inicio='".DataBrToUsa($dados[data_inicio])."', necessidade_fim='".DataBrToUsa($dados[data_fim])."'");
		
		return mysql_insert_id();
	}
	
	function associaProdutoForencedor($produto_id, $fornecedor_id){
		global $vkt_id;
		
		//seleciona os itens da necessidade
		//$itens_necessidades = mysql_query("SELECT * FROM cozinha_necessidade_item WHERE necessidade_id='".$necessidade_id."' AND vkt_id='$vkt_id'");
		
		//while($item = $itens_necessidades){
			
			$pf = mysql_fetch_object(mysql_query($t="SELECT * FROM produto_has_fornecedor WHERE produto_id='$produto_id' AND fornecedor_id='$fornecedor_id'"));
			//echo $t." ".mysql_error()."<br>";
			if(!$pf->id>0){
				mysql_query("INSERT INTO produto_has_fornecedor SET vkt_id='$vkt_id',produto_id='$produto_id', fornecedor_id='$fornecedor_id'");
				//echo $t." ".mysql_error()."<br>";
			}
			
		//}
	
	}
	
	function manipula_necessidade_item($dados){
		global $vkt_id;
		mysql_query($t=" INSERT INTO
						  cozinha_necessidade_item 
					  SET 
						  vkt_id='$vkt_id',
						  necessidade_id = '$dados[necessidade_id]',
						  produto_id='$dados[produto_id]',
						  cotar='sim'
					 ");
					 //echo $t;
		return mysql_insert_id();
	}
	
	function manipulaPlanejamento($dados){
		global $vkt_id;
		
		$contrato_id=$dados['contrato_id'];
		$qtd_pessoas=$dados['qtd_pessoas'];
		$gramatura  =$dados['f_gramatura'];
		$planejamento_id = $dados['planejamento_id'];
		$item_id=$dados[item_id];
		$c=0;
		
		/*if($dados[item_id]>0){
			
		}else{
			$item_id=manipula_necessidade_item($dados);
		}*/		
		
		foreach($contrato_id as $contrato){
			if($planejamento_id[$c]>0){
				$sql_inicio="UPDATE";
				$sql_fim   ="WHERE id='$planejamento_id[$c]'"; 	
			}else{
				$sql_inicio="INSERT INTO";
				$sql_fim   ="";
			}
			
			mysql_query($t="
			$sql_inicio
				cozinha_cotacao_planejamento
			SET
				vkt_id='$vkt_id',
				item_necessidade_id='$item_id',
				qtd_pessoas='".qtdBrToUsa($qtd_pessoas[$c],3)."',
				gramatura='".qtdBrToUsa($gramatura[$c],3)."',
				contrato_id='$contrato'
			$sql_fim
			");	
			$nova_gramatura = qtdBrToUsa($gramatura[$c],3);
			//echo $nova_gramatura." ".mysql_error()."<br>";
			$c++;
			
		}
		if(!$dados['gramatura_produto']>0){
			mysql_query($t="UPDATE produto SET gramatura='$nova_gramatura' WHERE id='$dados[produto_id]' AND vkt_id='$vkt_id'"); 
			//echo $t;
		}
	}

function cadastrar_fornecedor($dados){
	global $vkt_id;
	global $vkt_id;
	if($dados['tipo_cadastro']=='F'){
		$tipo_cadastro="Físico";
	}else{
		$tipo_cadastro="Jurídico";
	}
	mysql_query($t="INSERT INTO cliente_fornecedor SET cliente_vekttor_id='$vkt_id', cnpj_cpf='$dados[cnpj_cpf]', razao_social='$dados[nome]', nome_fantasia='$dados[nome]', tipo='Fornecedor', tipo_cadastro='$tipo_cadastro'");
}
?>