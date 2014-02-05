<?
include("../../../../../_config.php");
function exibe_option_sub_plano_ou_centro_modelo($plano_ou_centro,$pai_id,$id_do_selecionado,$nivel,$pai_ordem=null,$filtro=null){
  $pai = mysql_fetch_object(mysql_query($a="SELECT * FROM financeiro_centro_custo_modelo WHERE id='$pai_id'"));
  
  $q= mysql_query($r="SELECT * FROM 
  							financeiro_centro_custo_modelo 
						WHERE 
							cliente_id ='".$_SESSION[usuario]->cliente_vekttor_id ."' 
						AND 
							plano_ou_centro='$plano_ou_centro'  
						AND  
							centro_custo_id = '$pai_id'
						$filtro
						ORDER BY ordem,nome");
  $nivel++;
  if(strlen($pai_ordem)>0){
  	$pai_ordem = $pai_ordem.'.'.$pai->ordem;
  }else{
  	$pai_ordem = $pai->ordem;
  }
	
  while($r= mysql_fetch_object($q)){
	$filhos = @mysql_result(mysql_query("SELECT count(*) FROM 
  							financeiro_centro_custo_modelo 
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
	echo  "<option $sel style=\"padding-left:".($nivel*10)."px\" ordenacao='$paiordem' value='$r->id'>$paiordem ".utf8_encode($r->nome)."</option>";
	if($filhos>0){
		exibe_option_sub_plano_ou_centro_modelo($plano_ou_centro,$r->id,$id_do_selecionado,$nivel,$pai_ordem);
	}
  }
}
if($_GET['id_grupo']>0){
	$grupo_id=$_GET['id_grupo'];
	$filtro=" AND modelo_grupo_id='$grupo_id'";
}else{
	$filtro="";
}

exibe_option_sub_plano_ou_centro_modelo('plano',0,$obj->centro_custo_id,0,'', $filtro);