<?php
// funções base do sistema
include("../../_functions_base.php");
// funções do modulo empreendimento
include("_functions_financeiro.php");
	
	
	function exibe_option_sub_plano_ou_centro_1($plano_ou_centro,$pai_id,$id_do_selecionado,$nivel,$pai_ordem=null){
   
			  $pai = mysql_fetch_object(mysql_query("SELECT * FROM financeiro_centro_custo WHERE id='$pai_id'"));
			  
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
	
	$plano_movimento = mysql_fetch_object(mysql_query(" SELECT SUM(valor) AS valor_plano 
			
			FROM financeiro_plano_has_movimento AS f_plano, financeiro_movimento AS f_movimento WHERE f_plano.movimento_id = f_movimento.id AND plano_id =  '$r->id' AND status = '1' ")); //fiancneiro_moviemto 
	
	$valor = $plano_movimento->valor_plano - $planejado->valor;
	
	if($filhos>0){
		$sel = $sel.' disabled="disabled" ';
		$click = "";
		$plano = "<span class='plano_pai'> $paiordem $r->nome </span>";
		
	}else{
		$click = "id='click_plano_contas'";
		$plano = " <strong><span id='desc'> $paiordem <span id='descplano'> $r->nome </span></span> </strong>";
	}
			
			
	echo "<tr style='border:0;background:#F1F5FA;'class='$r->id' $click ><td style=\"border:0;padding-left:".($nivel*10)."px\">$plano</td><td align='right' style=\"border:0; padding-right:3px\">".moedaUsaToBr($valor)."$gh</td></tr>";			
	
	
	if($filhos>0){
		
		exibe_option_sub_plano_ou_centro_3($plano_ou_centro,$r->id,$id_do_selecionado,$nivel,$pai_ordem);
	}
	
  }
  
	}
	
	$acao = $_POST["acao"];
	
	switch($acao){
		
		case "exibe_plano_contas":
		
		break;
	}

?>