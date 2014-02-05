<?php
date_default_timezone_set('America/Manaus');
//Includes
// configuração inicial do sistema
include("../../_config.php");
// funções base do sistema
include("../../_functions_base.php");


	$q=mysql_query(" 
		SELECT m.modulo_id, mm . * FROM usuario AS u, `usuario_tipo_modulo` AS t, sis_modulos AS m, sis_modulos AS mm
		  WHERE u.id = '".$usuario_id. "'
		  AND t.`usuario_tipo_id` = u.usuario_tipo_id
		  AND t.modulo_id = m.id
		  AND m.modulo_id = mm.id
		  GROUP BY m.modulo_id ");

$contador = 0;
 
  function Notificacao(array $dados){
		  
		  for($i=0; $i < count($dados); $i++){
			  $array[] = $dados[$i];	
			  $result = $array;
		  }
		  //echo json_encode($result);
		  echo '{"result":' . json_encode($result) . '}';
  
  }
 
while($r=mysql_fetch_object($q)){	
	
	
	if($r->id == '1'){
				$dia = date('d');
				$mes = date('m');
				$sql = mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS qtd FROM  cliente_fornecedor WHERE cliente_vekttor_id = '$vkt_id' AND day(nascimento) = '$dia' AND month(nascimento) = '$mes'"));
				
				$notificacao[] = array("qtd"=>$sql->qtd,"titulo"=> " Aniversariantes de hoje","descricao"=>" Existem aniversariantes hoje ","tela_id"=>"tela_id=15&aniversariantes=sim");
				$contador += $sql->qtd;
	}
	if($r->id == '122'){
		
				$dia = date('d');
				$mes = date('m');
				$sql = mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS qtd FROM  eleitoral_eleitores WHERE vkt_id = '$vkt_id' AND day(data_nascimento) = '$dia' AND month(data_nascimento) = '$mes'"));
				
				$notificacao[] = array("qtd"=>$sql->qtd,"titulo"=> " Aniversariantes de hoje","descricao"=>" Existem aniversariantes hoje ","tela_id"=>"tela_id=405");
				$contador += $sql->qtd;
	}
	
	if($r->id == '3'){
			
			$almoxarifado_id = mysql_query( $cus=" SELECT * FROM cozinha_unidades WHERE vkt_id = '$vkt_id' "); // Seleciona todas as unidades
						
						while($almoxarifado=mysql_fetch_object($almoxarifado_id)){
							
								$sql = mysql_query($t=" SELECT * FROM produto JOIN estoque_mov AS estoque ON produto.id = estoque.produto_id
								  						WHERE estoque.almoxarifado_id = '".$almoxarifado->id."' AND estoque.vkt_id = '$vkt_id' ORDER BY (estoque.id) DESC "); // Seleciona os produtos por almoxarifado
								$j = 0;									
								while($produto=mysql_fetch_object($sql)){
									
										$r = mysql_fetch_object(mysql_query(" SELECT * FROM produto JOIN estoque_mov AS estoque ON produto.id = estoque.produto_id
													WHERE estoque.almoxarifado_id = '".$produto->almoxarifado_id."' AND estoque.produto_id = '".$produto->produto_id."' ORDER BY (estoque.id) DESC LIMIT 1 "));
										
										$qtd_produto = ($r->saldo / $r->conversao2);
										if($r->estoque_min >= $qtd_produto){
												$j++;
										} else {
											$j--;
										}			
								}
								
								if($j > 0){ // $cu LimitarString(utf8_encode($almoxarifado->nome),15)
									$notificacao[] = array("qtd"=>$j,"titulo"=> LimitarString(utf8_encode($almoxarifado->nome),15)." - estoque m&iacute;nimo","descricao"=>" Existem produtos em estoque m&iacute;nimo ","tela_id"=>"almoxarifado_id=".$almoxarifado->id."&estoque_minimo=true&limitador=&pagina=&tela_id=107");
									$contador += $j;
								}
								
						}
			
					
	}
	
	
	
	
	if($r->id=='5'){
		/* SQL ORDEM DE SERVIÇO */
	  	/*$os = mysql_fetch_object(mysql_query(" SELECT count(id) AS qtd_os FROM os WHERE vkt_id = '$vkt_id' AND orcado = 'nao' "));
		
		if($os->qtd_os>0){
			$notificacao[] = array("qtd"=>$os->qtd_os,"titulo"=>" Ordem de Servi&ccedil;o ","descricao"=>" Existem o.s n&atilde;o or&ccedil;adas ","tela_id"=>"orcado=nao&AprStatus=0&tela_id=276"); 		
			$contador += $os->qtd_os;
		}*/
		$contas_q=mysql_query(
	$t="
	SELECT * 
	FROM financeiro_contas_fixas WHERE vkt_id='$vkt_id' 
	ORDER BY dia_vencimento ASC
	");
	//echo $t;
	//echo  mysql_error();
	$linha=0;
	$total_previsto;
	$mes=date('m');
	$ano=date('Y');
	$contador_fixa = 0;
	while($conta=mysql_fetch_object($contas_q)){
		
		//if($linha%2)$sel="";else $sel=' class="al" ';
		
		//$cliente=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='".$conta->fornecedor_id."' LIMIT 1"));
		
		$diavencimento = $conta->dia_vencimento;
		
		if($diavencimento<10){$diavencimento="0".$diavencimento;}
		
		$verifica_q=mysql_query($trace=
		"SELECT * FROM financeiro_movimento 
		WHERE  origem_id='{$conta->id}' AND DATE_FORMAT(data_vencimento,'%m')='$mes' AND DATE_FORMAT(data_vencimento,'%Y')='$ano' AND origem_tipo='Conta Fixa'  ");
		
		$verifica=mysql_num_rows($verifica_q);
		
		
		
		if($verifica<1){
			/* nao cadastrou conta no contas a pagar ainda */
			$contador_fixa += 1;
		}
		
		
	 } //fim while
		if($contador > 0){
			$notificacao[] = array("qtd"=>$contador_fixa,"titulo"=>" Contas Fixas ","descricao"=>" Contas N&atilde;o Cadastradas","tela_id"=>"tela_id=86"); 		
			$contador += $contador_fixa;
		}
	}
	
	
	if($r->id=='275'){
		/* SQL ORDEM DE SERVIÇO */
	  	$os = mysql_fetch_object(mysql_query(" SELECT count(id) AS qtd_os FROM os WHERE vkt_id = '$vkt_id' AND orcado = 'nao' "));
		if($os->qtd_os>0){
			$notificacao[] = array("qtd"=>$os->qtd_os,"titulo"=>" Ordem de Servi&ccedil;o ","descricao"=>" Existem o.s n&atilde;o or&ccedil;adas ","tela_id"=>"orcado=nao&AprStatus=0&tela_id=276"); 		
			$contador += $os->qtd_os;
		}

	}
	if($r->id == "5"){
		
		/*- SQL CONTAS A PAGAR -*/
		$f_pagar = mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS qtd_pagar FROM financeiro_movimento WHERE cliente_id = '$vkt_id' AND tipo = 'pagar' AND status = '0' AND data_vencimento<now()"));
		
		if($f_pagar->qtd_pagar>0){
			$notificacao[] = array("qtd"=>$f_pagar->qtd_pagar,"titulo"=>"Financeiro - Contas &agrave; Pagar","descricao"=>"Existem contas a pagar financeiro","tela_id"=>"exibicao=lista&tela_id=52&filtro_inicio=01/01/2000&filtro_fim=".date("d/m/Y"));
		
		}
		
		/*- SQL CONTAS A RECEBER -*/
		$f_receber = mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS qtd_receber FROM financeiro_movimento WHERE cliente_id = '$vkt_id' AND tipo = 'receber' AND status = '0' AND data_vencimento<now()"));
		
		if($f_receber->qtd_receber>0){
			$notificacao[] = array("qtd"=>$f_receber->qtd_receber,"titulo"=>"Financeiro - Contas &agrave; Receber","descricao"=>"Existem contas a receber financeiro","tela_id"=>"exibicao=lista&tela_id=53&filtro_inicio=01/01/2000&filtro_fim=".date("d/m/Y"));
			
		}
			$contador += $f_pagar->qtd_pagar;
			$contador += $f_receber->qtd_receber;
					
	}
	
	if($r->id == "3"){
			$sql = mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS qtd FROM estoque_compras WHERE data_chegada_prevista <= NOW() AND status = 'Em aberto' AND vkt_id = '$vkt_id' "));
			$notificacao[] = array("qtd"=>$sql->qtd,"titulo"=>("Estoque - Recebimento de compras"),"descricao"=>"Existem recebimentos Pendentes","tela_id"=>"tela_id=197&filt_status=Em+aberto");
			$contador += $sql->qtd;
	}
	
	/*Funcionários Aniversariantes*/
	if($r->id == "93"){
		
		$sql = mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS qtd FROM rh_funcionario WHERE data_nascimento = NOW() AND status = 'admitidos' AND vkt_id = '$vkt_id' "));
		if($sql->sql > 0){
			$notificacao[] = array("qtd"=>$sql->sql,"titulo"=>"Funcionários Aniversariantes","descricao"=>"Funcionários aniversariantes de hoje","tela_id"=>"tela_id=475&aniversariantes=sim");
			$contador += $sql->sql;	
		}
		
	}
	
	/*Alunos Aniversariantes*/
	if($r->id == "454"){
		
		$sql = mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS qtd FROM escolar2_alunos WHERE data_nascimento = NOW() AND vkt_id = '$vkt_id' "));
		if($sql->sql > 0){
			$notificacao[] = array("qtd"=>$sql->sql,"titulo"=>"Alunos Aniversariantes","descricao"=>"Alunos aniversariantes de hoje");
			$contador += $sql->sql;	
		}
		
	}
	
	
}
	
	
	$notificacao[] = array("totalreg"=>$contador,"titulo"=>"contagem");
	Notificacao($notificacao);

?>