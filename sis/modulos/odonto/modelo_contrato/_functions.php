<?php
function manipulaContrato($dados,$vkt_id){
	
	$texto = $dados[texto];
	
	if($dados['id']>0){
		$inicio="UPDATE";
		$fim="WHERE id=".$dados['id'];
	}else{
		$inicio="INSERT INTO";
		$fim="";
	}
	$sql=mysql_query($t="$inicio odontologo_contrato_modelo SET 
			vkt_id='$vkt_id',
			nome='{$dados['nome']}',
			contrato='$texto'
			$fim");
			//echo $t;
			
}

function exclui_contrato($id){
	mysql_query($t="DELETE FROM odontologo_contrato_modelo WHERE id=$id");
	//echo $t." ".mysql_error();
}

function incluirImagem($dados){
	
	global $vkt_id;
	
	if($dados['id']<=0){
		$id = manipulaEmailmarketing($dados,$vkt_id,'imagem');
		echo "<script>top.document.getElementById('id').value= '$id'</script>";
	}else{
		$id = $dados['id'];
	}
	
	$filis_autorizados = array('jpg','gif','png','pdf','jpeg');
	
	$infomovimento = mysql_fetch_object(mysql_query("SELECT ordem as ordem FROM modelo_contrato_imagens WHERE modelo_contrato_id='$id' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));
	
	$ordem = $infomovimento->ordem+1;
	//alert($ordem);
	$pasta 	= '../upload/odonto/imagens_contrato/';
	  $extensao = str_replace('.','',strtolower(substr($_FILES['imagem']['name'],-4)));
	  $arquivo 	= $pasta.$id.'.'.$extensao;
	  //alert($arquivo);
	  $arquivodel= $pasta.$produto_id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['imagem'][tmp_name],$arquivo)){
			  mysql_query($f="INSERT INTO modelo_contrato_imagens SET vkt_id='$vkt_id', ordem='$ordem',extensao='$extensao',modelo_contrato_id='$id'");
			  $imagem_id = mysql_insert_id();
			  //alert($imagem_id);
			  @rename("../upload/odonto/imagens_contrato/$id.$extensao","../upload/odonto/imagens_contrato/$imagem_id.$extensao");
			  //alert($f);
			  echo "<script>top.document.getElementById('d_imagens').innerHTML += '<div style=\"height:70px;float:left;\" id=\"$imagem_id\"><img src=\"../upload/odonto/imagens_contrato/$imagem_id.$extensao\" width=\"50\" height=\"50\" class=\"imagens\"/><div style=\"clear:both\"></div><a href=\"#\" id=\"remover_imagem\">Remover</a></div>'</script>";
			  @chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
}

?>