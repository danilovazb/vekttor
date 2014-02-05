<?php

function manipulaPergunta($dados,$vkt_id){
		$inicio = "INSERT";$fim="";	
				
		mysql_query($t="$inicio INTO escolar_mensagens_privadas SET
			  vkt_id='$vkt_id',
			  aluno_id='$dados[aluno_id]',
			  professor_id='$dados[professor_id]',
			  de='$dados[professor_id]',
			  para='$dados[aluno_id]',
			  materia_id='$dados[materia_id]',
			  aula_id='$dados[aula_id]',
			  sala_id='$dados[sala_id]',
			  assunto='$dados[aula]',
			  mensagem='$dados[mensagem]',
			  data_envio='".date('Y-m-d H:i:s')."',
			  mensagem_origem_id='$dados[mensagem_id]',
			  status='1'
			   $fim")			   
			;
		envia_email($dados[professor_id],$dados[aluno_id],$dados[sala_id],$dados[aula_id],$dados[mensagem]);
		
		$pergunta_id=mysql_insert_id();
		//echo $pergunta_id;		
		mysql_query($t="UPDATE escolar_mensagens_privadas SET status='1' WHERE id='$dados[mensagem_id]'");
		//echo $t;
		if(strlen($_FILES['arquivo']['name'])>3){
			
			professor_envia_arquivo($pergunta_id,$vkt_id);
		}

}

function professor_envia_arquivo($pergunta_id,$vkt_id){
	
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
			  //echo "Moveu";
			  mysql_query($f="UPDATE escolar_mensagens_privadas SET
			  		extensao='.$extensao' WHERE id='$pergunta_id'
			  AND vkt_id='$vkt_id'");
				echo $t;
			  chmod($arquivo,0777);
		  }
	  }else{
		alert("Formato de atutenticação Inadequado: $extensao");  
	  }
	}
	
}

function atualizaStatus($id,$vkt_id){
	mysql_query($t="UPDATE escolar_mensagens_privadas SET
				data_recebimento='".date('Y-m-d H:i:s')."' WHERE id='$id' AND vkt_id='$vkt_id'");
				
	//echo $t."<br>";
	
}

function envia_email($professor_id, $aluno_id, $sala_id, $aula_id, $mensagem){
	
$professor = mysql_fetch_object(mysql_query("SELECT 
																			cf.email 
																		FROM 
																			cliente_fornecedor cf,
																			escolar_professor ep
																		WHERE
																			cf.id = ep.cliente_fornecedor_id AND
																			cf.id = '$professor_id'			
																"));
	$aluno = mysql_fetch_object(mysql_query("SELECT 
																			nome 
																		FROM 
																			escolar_alunos
																		WHERE
																			id = '$aluno_id'
																"));
	$sala = mysql_fetch_object(mysql_query("SELECT 
																			nome 
																		FROM 
																			escolar_salas
																		WHERE
																			id = '$sala_id'
																"));
	$aula = mysql_fetch_object(mysql_query("SELECT 
																			descricao, data 
																		FROM 
																			escolar_aula
																		WHERE
																			id = '$aula_id'
																"));
		
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$destinatario = $aluno->email;
	alert($aluno_id);
	$assunto = "O Professor $professor->razao_social respondeu sua pegunta";
	$texto = $mensagem;
	$email = mail($destinatario,$assunto,$texto,$headers);
}	
?>