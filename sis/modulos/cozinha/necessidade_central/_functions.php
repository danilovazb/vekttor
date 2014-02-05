<?

function criaNecessidade($dados){
	global $vkt_id;
	if(count($dados['produto_id'])>0){
	/// cozinha necessidade é igual 1 cotacao a ser feita
		if(mysql_query("
		INSERT INTO cozinha_necessidade 
		SET
			vkt_id='$vkt_id', necessidade_inicio='{$dados[necessidade_inicio]}', necessidade_fim='{$dados[necessidade_fim]}'
			")){
				echo mysql_error();
				$necessidade_id=mysql_insert_id();
				
				
			for($i=0;$i<count($dados['produto_id']);$i++){
				if(isset($dados['produto_id'][$i])){	
					$qtd_embalagem=moedaBrToUsa($dados['qtd_digitada'][$i]);
					mysql_query($t="INSERT INTO 
				cozinha_necessidade_item SET vkt_id='$vkt_id', necessidade_id='$necessidade_id', produto_id='{$dados['produto_id'][$i]}', qtd_digitada='$qtd_embalagem', qtd_sistema='{$dados['qtd_sistema'][$i]}' ");
					//echo $t."<br>";
					//echo mysql_error();
				}
			}
			location("?tela_id=118&necessidade_id=$necessidade_id&acao=necessidade");
		}
	}
}


function checaEstoque($produto_id,$status_inventario,$almoxarifado_id=NULL,$inventario_id=NULL){
	global $vkt_id;
	if($status_inventario==1){
			$estoque=mysql_fetch_object(mysql_query($opa="
			SELECT * FROM estoque_inventario_item WHERE produto_id='$produto_id' AND inventario_id='$inventario_id'  ORDER BY id DESC LIMIT 1"));
		if($estoque->id>0){
			$qtd=$estoque->qtd_estoque;
		}else{
			$qtd=0;
		}
	}else{
		$estoque=mysql_fetch_object(mysql_query($trace="SELECT * FROM estoque_mov WHERE produto_id='$produto_id' AND almoxarifado_id='$almoxarifado_id' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));
		//echo $trace."<br>";
		/*$estoque=$produto_saldo = mysql_fetch_object(mysql_query($t="
					SELECT 
						(SELECT SUM(saldo) as saldo FROM estoque_mov WHERE produto_id=p.id AND vkt_id='$vkt_id' ORDER BY id DESC) as saldo
					FROM 
						produto p, 
						estoque_mov em 
					WHERE 
						em.vkt_id='$vkt_id' AND
						em.produto_id = p.id AND 
						em.produto_id='$produto_id'						 
					ORDER BY 
						em.id DESC LIMIT 1"));*/
				
		if($estoque->saldo>0){
			$qtd=$estoque->saldo;
		}else{
			$qtd=0;
		}
	}
	return $qtd;
}