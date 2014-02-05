<?php

function manipulaPergunta($dados,$vkt_id){
		$inicio = "INSERT";$fim="";	
		$mensagem_origem_id="0";
		
		mysql_query($t="$inicio INTO escolar_mensagens_privadas SET
			  vkt_id='$vkt_id',
			  aluno_id='$dados[aluno_id]',
			  professor_id='$dados[professor_id]',
			  de='$dados[aluno_id]',
			  para='$dados[professor_id]',
			  materia_id='$dados[materia_id]',
			  aula_id='$dados[aula_id]',
			  sala_id='$dados[sala_id]',
			  assunto='$dados[aula]',
			  mensagem='$dados[mensagem]',
			  data_envio='".date('Y-m-d H:i:s')."',
			  mensagem_origem_id='$dados[mensagem_id]',
			  status='2'
			   $fim")			   
			;
			
			$pergunta_id=mysql_insert_id();
			//echo $t."<br>";
			mysql_query($t="UPDATE escolar_mensagens_privadas SET status='2'
			WHERE mensagem_origem_id='$dados[mensagem_id]' OR id='$dados[mensagem_id]'");
		//echo $t."<br>";	
		if(strlen($_FILES['arquivo']['name'])>3){
			
			aluno_envia_arquivo($pergunta_id,$vkt_id);
		}

}

function aluno_envia_arquivo($pergunta_id,$vkt_id){
	
	
	$filis_autorizados = array('jpg','gif','png','pdf','txt');
	
	$infomovimento = mysql_fetch_object(mysql_query("SELECT * FROM escolar_mensagens_privadas WHERE id='$pergunta_id' AND vkt_id='$vkt_id'"));
	
	if(strlen($_FILES['arquivo']['name'])>4){
	  $pasta 	= 'modulos/escolar/area_aluno/aulas/arquivos/';
	  $extensao = strtolower(substr($_FILES['arquivo']['name'],-3));
	  $arquivo 	= $pasta.$pergunta_id.'.'.$extensao;
	  $arquivodel= $pasta.$pergunta_id.'.';
	  
	  if(in_array($extensao,$filis_autorizados)){
		  @unlink($arquivodel);
		  if(move_uploaded_file($_FILES['arquivo'][tmp_name],$arquivo)){
			  echo "Moveu";
			  mysql_query($f="UPDATE escolar_mensagens_privadas SET
			  		extensao='.$extensao' WHERE id='$pergunta_id'
					AND vkt_id='$vkt_id'
			  ");
				echo $f;
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	
}
?>