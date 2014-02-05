<?php

$tabela = "escolar2_unidades";

// Controlador

function cadastra () {
	
	global $tabela,$vkt_id;
	
	$acao = "";
	$where = "";
	
	if (!empty($_POST['id']) ){
		$acao = "UPDATE";
		$where = "WHERE id = '" . mysql_real_escape_string($_POST['id']) . "' AND vkt_id='$vkt_id'";
	} else {
		$acao = "INSERT INTO";	
	}
	
	mysql_query($t="$acao $tabela SET 
	vkt_id='$vkt_id',
	 nome 			= '{$_POST['nome_unidade']}',
	 cep            = '{$_POST['cep']}',
	 endereco 		= '{$_POST['endereco']}', 
	 bairro 		= '{$_POST['bairro']}', 
	 cidade			= '{$_POST['cidade']}',
	 estado			= '{$_POST['estado']}',
	 numero			= '{$_POST['numero']}',
	 complemento	= '{$_POST['complemento']}',
	 telefone 		= '{$_POST['telefone']}', 
	 email 			= '{$_POST['email']}',
	 media          = '{$_POST['media']}',
	 qtd_salas      = '{$_POST['qtd_salas']}'
	 $where");
	 
	 if (!empty($_POST['id']) ){
		$id = $_POST['id'];
	} else {
		$id = mysql_insert_id();	
	}
	 
	 if(sizeof($_POST['nome'])>0){
	 	manipula_salas($id);
	 }
	 /*banco 			= '{$_POST['banco']}', 
	 agencia 		= '{$_POST['agencia']}', 
	 conta 			= '{$_POST['conta']}', 
	 tipo_boleto 	= '{$_POST['tipo_boleto']}',
	 conta_cedente 	= '{$_POST['conta_cedente']}',
	 conta_cedente_dv 	= '{$_POST['conta_cedente_dv']}',
	 convenio 	= '{$_POST['convenio']}',
	 contrato 	= '{$_POST['contrato']}',
	 carteira 	= '{$_POST['carteira']}',
	 termos		= '{$_POST['termos']}'*/
 
	 
	//echo $t;
	//echo mysql_error();
}

function manipula_salas($id){
	
	global $vkt_id;
	
	$salas                 = $_POST['nome'];
	$salas_id              = $_POST['sala_id'];
	$capacidade_max        = $_POST[capacidade_max];
	$capacidade_ped        = $_POST[capacidade_ped];	
	$c = 0;
	
	//seleciona a quantidade de salas
	$salas_cadastradas = mysql_query($t="SELECT * FROM escolar2_salas WHERE vkt_id='$vkt_id' AND unidade_id = '$id' ORDER BY id DESC");
	
	$qtd_salas = mysql_num_rows($salas_cadastradas);
	//$qtd_salas = mysql_result(mysql_query("SELECT COUNT(*) FROM escolar2_salas WHERE vkt_id='$vkt_id' AND unidade_id = '$id' ORDER BY id DESC"),0,0);
	
	if(sizeof($salas) >= $qtd_salas){
	
		foreach($salas as $sala){
			
			if(!empty($salas_id[$c])){
				
				$acao  = "UPDATE";
				$where = "WHERE id=".$salas_id[$c];
					
			}else{
				
				$acao  = "INSERT INTO";
				$where = "";
				
			}//if(!empty($salas_id[$c]))
			
			
			mysql_query($t="$acao escolar2_salas SET nome = '$sala', vkt_id='$vkt_id', unidade_id = '$id',capacidade_maxima = '".$capacidade_max[$c]."', capacidade_pedagogica = '".$capacidade_ped[$c]."' $where");
			//echo $t."<br>";
			$c++;
		}//foreach($salas as $sala)
	
	}else{
		
		$c=$qtd_salas;
		
		while($sala_cadastrada = mysql_fetch_object($salas_cadastradas)){
			
			mysql_query($t="DELETE FROM escolar2_salas WHERE id='$sala_cadastrada->id'");
			//echo $t."<br>";
			
			$c--;
			
			if($c==sizeof($salas)){
				break;
			}
			
		}//$sala = mysql_fetch_object($salas_cadastradas)
		
	}//if($qtd_salas >= sizeof($salas))
	
}

function remover () {
	global $tabela,$vkt_id;
	$q = mysql_query ($trace = "DELETE FROM $tabela WHERE id = '" . mysql_real_escape_string($_POST['id']) . "' AND vkt_id='$vkt_id'");	
}

?>