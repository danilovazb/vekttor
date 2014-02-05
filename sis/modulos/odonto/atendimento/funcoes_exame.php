<?php
include("../../../_config.php");
include("../../../_functions_base.php");

if($_POST['acao']=='remove'){
	
	$ultimo = mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_exames WHERE id=".$_POST['id']));
	echo $t;
	unlink("arquivo_exame/".$ultimo->id.".".$ultimo->extensao);
	mysql_query("DELETE FROM odontologo_exames WHERE id=".$_POST['id']);

}else{
	
	mysql_query($t="INSERT INTO odontologo_exames SET 
				vkt_id                    ='$vkt_id', 
				cliente_fornecedor_id     ='".$_POST['cliente_id']."',
				odontologo_atendimento_id ='".$_POST['id']."',
				observacao                ='".$_POST['obs_exame']."',
				data                      ='".DataBrToUsa($_POST['data_exame'])."'");
	
	$id = mysql_insert_id();
	
	if(strlen($_FILES['imagem']['name'])>0){
		
		upload_imagem($id);
	
	}
	
}

function upload_imagem($id){
	
	$filis_autorizados = array('jpg','gif','png','pdf');
	
	$infomovimento = mysql_fetch_object(mysql_query("SELECT * FROM odontologo_exames WHERE id='$id'"));
	
	$pasta 	= 'arquivo_exame/';
	  $extensao = strtolower(substr($_FILES['imagem']['name'],-3));
	  $arquivo 	= $pasta.$id.'.'.$extensao;
	  //alert($arquivo);
	  $arquivodel= $pasta.$produto_id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['imagem'][tmp_name],$arquivo)){
			  mysql_query($f="UPDATE odontologo_exames SET extensao='$extensao' WHERE id='$id'");
			  //alert($f);
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticaчуo Inadequado: $extensao");  
	  }
}
?>