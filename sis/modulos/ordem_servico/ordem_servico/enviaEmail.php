<?php
include("../../../_config.php");  
		//ini_set("allow_url_fopen", TRUE);
		$id = $_POST['id']; 
		$emailDestino = $_POST['emailDestino'];  	
        $texto        = $_POST['msg'];
	    $texto .= file_get_contents("http://vkt.srv.br/~nv/sis/modulos/ordem_servico/ordem_servico/impressao_orcamento.php?id=".$id."&vkt_id=".$vkt_id."&email=1");
		
		
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		mail($emailDestino, 'Envio de Orcamento', $texto, $headers);

?>