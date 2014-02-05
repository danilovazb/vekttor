<?php
	define("VENDA","rh_venda_funcionario");
	define("PARCELA","rh_venda_funcionario_parcela");
	
	
	function get_nome($nome = NULL, $tamanho = NULL){
	
			if( !empty($nome) and !empty($tamanho) ){
			if( strlen($nome) > $tamanho )
				echo substr($nome,0,$tamanho)."...";
			else
				echo $nome;
			}
			
	}
	
	function Salvar($campos){
		global $vkt_id;
		
		$sql = " INSERT INTO ".VENDA." SET 
		funcionario_id = '".$campos["funcionario_id"]."',
		empresa_id = '".$campos["empresa_id"]."',
		vkt_id = '$vkt_id',
		descricao = '".$campos["descricao"]."',
		valor_total = '".moedaBrToUsa($campos["valor_total"])."',
		data_hora_cadastro = now(),
		status= '1' ";
		
		mysql_query($sql);
		$campos['lastID'] = mysql_insert_id();
		
		SalvarItens($campos);
	}
	
	function SalvarItens($campos){
		global $vkt_id;
		$valParcela = $campos["valor_parcela"];
		$dtaParcela = $campos["data_parcela"];
		
		for($i=0; $i< count($valParcela); $i++){
			
			$sql = " INSERT INTO ".PARCELA." SET 
			venda_id = '".$campos['lastID']."',
			valor_parcela = '".moedaBrToUsa($valParcela[$i])."',
			data_vencimento = '".dataBrToUsa($dtaParcela[$i])."',
			status = '1' ";
			
			mysql_query($sql);
		
		}
	}
	
	function CancelarVenda($id){
		$sql = " UPDATE  ".VENDA." SET status = '2' WHERE id = '$id' ";
		mysql_query($sql);
	}
