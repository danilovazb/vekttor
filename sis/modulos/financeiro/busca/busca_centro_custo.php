<?
/*
separacao por | campo
e  linha separado por qubra de linha ou para os leigos "\n"
@r0 = Mário Flávios JR
@r1 = 29/01/1983
@r2 = 10/10/2010

*/

include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento

//$cpf_cnpj =  str_replace =
global $vkt_id;
$busca = $_GET['busca_auto_complete'];

function exibe_option_sub_plano_ou_centro2_1($plano_ou_centro,$pai_id,$id_do_selecionado,$nivel,$pai_ordem=null){
	global $vkt_id;
	global $busca;
  $pai = mysql_fetch_object(mysql_query("SELECT * FROM financeiro_centro_custo WHERE id='$pai_id' AND nome LIKE '%$_GET[busca_auto_complete]%' AND cliente_id = '$vkt_id' "));
  
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
	
	
	if($filhos>0){
		//$sel = $sel.' disabled="disabled" ';
		$click = "";
		$plano = "<span class='plano_pai'> $paiordem $r->nome </span>";
		
	}else{
		$click = "id='click_centro_custo'";
		$plano = " <strong><span id='desc'> $paiordem <span id='descentro'> $r->nome </span></span> </strong> ";
		echo urlencode("$r->id|$r->nome|\n");
	}
	
	
	/*echo  "<tr  style='border:0;' class='$r->id' $click > 
				<td style=\"border:0;padding-left:".($nivel*10)."px\">$plano</td> 
		  </tr>";*/
	
	if($filhos>0){
		exibe_option_sub_plano_ou_centro2_1($plano_ou_centro,$r->id,$id_do_selecionado,$nivel,$pai_ordem);
	}
  }
}

exibe_option_sub_plano_ou_centro2_1('centro',0,0,0);	
/*$q=mysql_query($t="SELECT * FROM financeiro_centro_custo WHERE nome LIKE '%$_GET[busca_auto_complete]%' AND plano_ou_centro = 'plano' AND cliente_id = '$vkt_id' LIMIT 15");
$i=0;
while($r= mysql_fetch_object($q)){
	
		$pai = (mysql_query("SELECT * FROM financeiro_centro_custo WHERE centro_custo_id ='$r->id'"));
		
		if($r->centro_custo_id != 0){
			echo urlencode("$r->id|$r->nome|\n");
		} 
	//echo $t;
	$i++;
}
if($i==0){
	echo urlencode("Não Encontrado|0|0\n");
}*/
?> 