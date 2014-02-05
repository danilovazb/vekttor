<?php

function ManipulaConfiguracao($dados,$vkt_id){
	
	
	if($dados['ContaID'] > 0){
			UpdateConta($dados);	
	} else{
			CadastraConta($dados);
	}
	
	
	
	if($dados[id]>0){
		$inicio="UPDATE";
		$fim="WHERE id=".$dados[id];
		//UpdateConta($dados);
	}else{
		$inicio="INSERT INTO";
		$fim="";
		//CadastraConta($dados);
	}
	
	$sql = mysql_query($t="$inicio os_configuracao SET
		id='$vkt_id',
		texto_adicional='$dados[texto]',
		comissao_vendedor='".moedaBrToUsa($dados[comissao_vendedor])."',
		valor_total_desconto = '".moedaBrToUsa($dados[total_desconto])."'
		$fim ");
	//echo $t;
	if(strlen($_FILES['img1']['name'])>3){
		
		$posicao='_c';
		$coluna='img_cabecalho';
		if($dados[id]>0){
			
			Envia_imagem($dados[id],$coluna,$posicao,$_FILES['img1']['name'],$_FILES['img1'][tmp_name]);
		}else{
			Envia_imagem($vkt_id,$coluna,$posicao,$_FILES['img1']['name'],$_FILES['img1'][tmp_name]);
		}
	}
	
	if(strlen($_FILES['img2']['name'])>3){
		$posicao='_r';
		$coluna='img_rodape';
		if($dados[id]>0){
			Envia_imagem($dados[id],$coluna,$posicao,$_FILES['img2']['name'],$_FILES['img2'][tmp_name]);
		}else{
			//alert("img2");
			Envia_imagem($vkt_id,$coluna,$posicao,$_FILES['img2']['name'],$_FILES['img2'][tmp_name]);
		}
	}
	
}

function Envia_imagem($id,$coluna,$posicao,$img,$tmp_img){
	
	$filis_autorizados = array('jpg','gif','png');
	
	$infomovimento = mysql_fetch_object(mysql_query("SELECT * FROM os_configuracao WHERE id='$id'"));
	if(strlen($img)>4){
	  
	  $pasta 	= 'modulos/ordem_servico/configuracao/img/';
	  $extensao = strtolower(substr($img,-3));
	  $arquivo 	= $pasta.$id.$posicao.'.'.$extensao;
	  $arquivodel= $pasta.$produto_id.'.';
	  //alert($extensao);
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		 //alert($arquivo);
		  if(move_uploaded_file($tmp_img,$arquivo)){
			 //alert("oi");
			  mysql_query($f="UPDATE os_configuracao SET $coluna='$extensao' WHERE id='$id'");
			  //echo $f;
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
}

function UpdateConta($campos){
			global $vkt_id;
			$CentroCusto = $campos['centro_custo_id'];
			$PlanoConta  = $campos['plano_de_conta_id'];
			for($i=0;$i<sizeof($CentroCusto);$i++){
			$UpdateConta = " UPDATE os_conta 
										  SET 
											conta_id        = '$campos[conta_id]',
											centro_custo_id = '$CentroCusto[$i]',
											plano_conta_id  = '$PlanoConta[$i]',
											obs_conta       = '$campos[obsConta]'
										  WHERE 
										  	id = $campos[ContaID] 
			";
			}
			//echo $UpdateConta;
	mysql_query($UpdateConta);
}


function CadastraConta($campos){
	global $vkt_id;
	
			$CentroCusto = $campos['centro_custo_id'];
			$PlanoConta  = $campos['plano_de_conta_id'];
			for($i=0; $i <sizeof($CentroCusto);$i++){
							$InsertConta = " INSERT INTO  os_conta
										SET
											vkt_id          = '$vkt_id',         
											conta_id        = '$campos[conta_id]',
											centro_custo_id = '$CentroCusto[$i]',
											plano_conta_id  = '$PlanoConta[$i]',
											obs_conta       = '".$campos[obsConta]."'
							";
				//echo $InsertConta;
			   mysql_query($InsertConta);			
			}
}
?>