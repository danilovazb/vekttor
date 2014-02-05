<?
//Funчѕes 

//Cadastra Cliente
function ManipulaCliente($dados,$cliente_vekttor_id,$modulo_id){
	if($cliente_vekttor_id<=0){$inicio ="INSERT INTO";$data=',data_cadastro="'.date('Y-m-d').'"';}else{$inicio ="UPDATE";$data='';}
	if($cliente_vekttor_id<=0){$fim="";}else{$fim = "WHERE id='".$cliente_vekttor_id."'";}
	
	$query = mysql_query($t="$inicio clientes_vekttor  SET nome='".$dados['cliente_nome']."', nome_fantasia='".$dados['cliente_nome_fantasia']."',
	cnpj='".$dados['cliente_cnpj']."', cep='".$dados['cliente_cep']."', endereco='".$dados['cliente_endereco']."', bairro='".$dados['cliente_bairro']."',
	cidade='".$dados['cliente_cidade']."', estado='".$dados['cliente_estado']."', telefone='".$dados['cliente_telefone']."' $data $fim"); 
	
	if($cliente_vekttor_id==0){
		$aux=1;
		$cliente_vekttor_id=mysql_insert_id();
	}
	
	//echo "Foto: ".$_FILES['foto']['name'];
	if(strlen($_FILES['foto']['name'])>3){
		logomarca_envia_arquivo($cliente_vekttor_id);
	}	
}

function logomarca_envia_arquivo($cliente_vekttor_id){
	
	$filis_autorizados = array('jpg','gif','png');
	
	$infomovimento = mysql_fetch_object(mysql_query($t="SELECT * FROM clientes_vekttor WHERE id='$cliente_vekttor_id'"));
	
	if(strlen($_FILES['foto']['name'])>3){
	  
	  $pasta 	= 'modulos/vekttor/clientes/img/';
	  $extensao = strtolower(substr($_FILES['foto']['name'],-3));
	  $arquivo 	= $pasta.$cliente_vekttor_id.".".$extensao;
	  $arquivodel = $pasta.$cliente_vekttor_id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['foto'][tmp_name],$arquivo)){
			  
			  mysql_query($f="UPDATE clientes_vekttor SET img='1' WHERE id='$cliente_vekttor_id'");
			  //echo $f;
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticaчуo Inadequado: $extensao");  
	  }
	}	
}
?>