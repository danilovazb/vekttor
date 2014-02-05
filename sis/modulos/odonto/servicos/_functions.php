<?php
function manipulaServico($dados,$vkt_id){
	global $vkt_id;
	if($dados[id]<=0){
		
		$inicio="INSERT INTO";$fim="";
	}else{
		$inicio="UPDATE";$fim="WHERE id='$dados[id]'";
	}
	
	mysql_query($t="$inicio servico SET
		vkt_id='$vkt_id',
		nome='$dados[descricao]',
		und='$dados[unidade]',
		valor_normal='".moedaBrToUsa($dados[vl_normal])."',
		valor_colaborador='".moedaBrToUsa($dados[vl_colaborador])."',
		tempo_execucao='$dados[tempo_execucao]',
		observacao='$dados[obs]',
		grupo_id='$dados[grupo_servico]',
		codigo_interno = '$dados[codigo_interno]'
		$fim");
	   //echo $t;
			
		if($dados[id]<=0){
			$id=mysql_insert_id();
		}else{
			$id=$dados[id];
		}
		
		mysql_query("DELETE FROM odontologo_procedimento_convenio WHERE vkt_id='$vkt_id' AND servico_id='{$dados['id']}'");
		
		
	
	if(sizeof($dados['valor_convenio'])>0){
		foreach($dados['valor_convenio'] as $convenio_id=>$valor){
			if($valor!=''){
				mysql_query($t="INSERT INTO odontologo_procedimento_convenio SET vkt_id='$vkt_id' ,servico_id='$id', convenio_id='$convenio_id', valor='".moedaBrToUsa($valor)."'");
		
			}
		}
	}
	
	if(strlen($_FILES['foto_servico']['name'])>0){
		upload_foto($id);
	}
		
}

function excluiServico($_POST,$vkt_id){
	global $vkt_id;
	$t=mysql_query("DELETE FROM servico WHERE id='$_POST[id]' AND vkt_id='$vkt_id'");
}

function manipulaGrupo($dados){
	global $vkt_id;
	if(!$dados['id']>0){
		$inicio = "INSERT INTO";$fim="";
	}else{
		$inicio = "UPDATE";$fim="WHERE id={$dados['id']}";
	}
	mysql_query($t="$inicio servico_grupo  SET nome='{$dados['nome_grupo']}',vkt_id='$vkt_id',observacao='{$dados['observacao_grupo']}' $fim");
	//echo $t;
}
function ExcluirGrupo($dados){
	$existe = @mysql_num_rows(mysql_query("SELECT * FROM servico WHERE grupo_id={$dados['id']}"));
	
	if(!$existe>0){
		mysql_query($t="DELETE FROM servico_grupo WHERE id={$dados['id']}");
		//echo $t;
	}else{
		alert("Grupo não pode ser excluído! Há servicos neste grupo.");
	}
}

function upload_foto($id){

	global $vkt_id;
	
	$filis_autorizados = array('jpg','gif','png','pdf','jpeg');
	
	if(strlen($_FILES['foto_servico']['name'])>4){
	  $pasta 	= 'modulos/odonto/servicos/fotos/';
	  $extensao = strtolower(substr($_FILES['foto_servico']['name'],-3));
	  $arquivo 	= $pasta.$id.'.'.$extensao;
	  $arquivodel= $pasta.$id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['foto_servico'][tmp_name],$arquivo)){
			  mysql_query($f="UPDATE servico SET extensao='$extensao' WHERE id='$id'");
			  
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	
	return $foto_id;
}

function realizar_importacao($dados){

	global $vkt_id;
	
	foreach($dados['grupo'] as $grupo_id){

		$info_grupo = mysql_fetch_object(mysql_query("SELECT * FROM servico_grupo WHERE id='$grupo_id'"));
		
		mysql_query($t="INSERT INTO servico_grupo SET vkt_id='$vkt_id',nome='$info_grupo->nome',observacao='$info_grupo->observacao'");
		$grupo_inserido_id = mysql_insert_id();
		echo mysql_error()."<br>";
	
		foreach($dados['servico'] as $servico_id){
			 
			$info_servico = mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE id='$servico_id'"));
			if($grupo_id==$info_servico->grupo_id){
				
				mysql_query($t="INSERT INTO servico SET vkt_id='$vkt_id',nome='$info_servico->nome', valor_normal='$info_servico->valor_normal', grupo_id='$grupo_inserido_id', codigo_interno='$info_servico->codigo_interno'");
			
				echo mysql_error();
			}	
		}
	}
	alert("Importação Realizada Com Sucesso!");
	echo "<script>location.href='?tela_id=373'</script>";
}
?>