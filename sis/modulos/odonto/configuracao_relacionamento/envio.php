<?
//Includes
include("../../../_config.php");
include_once("../../sysms/SendSms.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
//echo "oi";
//seleciona os clientes que já configuraram o envio automático
$clientes = mysql_query($t="SELECT 
							* 
						FROM 
							configuracao_relacionamento cc,
							clientes_vekttor cv
						WHERE
							cc.vkt_id = cv.id");
//echo $t."<br>";
while($cliente = mysql_fetch_object($clientes)){
	//echo "Nome: ".$cliente->nome;
	//$cliente_vekttor = mysql_fetch_object(mysql_query("SELECT * FROM clientes_vekttor WHERE id='$cliente->vkt_id'"));
	
	if($cliente->email_agendamento=='sim'){
		//echo "oi";
		//chama a funcao email_agendamento
		email_agendamento($cliente->vkt_id,$cliente->de_email_agendamento,$cliente->assunto_email_agendamento,$cliente->texto_email_agendamento);
	}
	
	if($cliente->sms_agendamento=='sim'){
		
		$disponivel = quantidade_sms($cliente->vkt_id);
		
		if($disponivel > 0){
			
			sms_agendamento($cliente->vkt_id,$cliente->de_sms_mensagem,$cliente->texto_sms_mensagem,$config);
		}
	}
	
	if($cliente->email_aniversario=='sim'){
		
		//chama a funcao email_agendamento
		email_aniversario($cliente->nome_fantasia,$cliente->vkt_id,$cliente->de_email_aniversariante,$cliente->assunto_email_aniversariante,$cliente->texto_email_aniversariante);
	}
	
	if($cliente->sms_aniversario=='sim'){
		
		$disponivel = quantidade_sms($cliente->vkt_id);
		
		if($disponivel>0){
			echo $cliente_vekttor->nome_fantasia;
			//chama a funcao email_agendamento
			sms_aniversario($cliente->nome_fantasia,$cliente->vkt_id,$cliente->de_sms_aniversario,$cliente->texto_sms_aniversario,$config);
			
		}
	}
	
	if($cliente->email_visita=='sim'){
		
		//verifica quando último email de visita foi enviado
		$data_ultimo_envio = mysql_result(mysql_query($t="SELECT DATEDIFF(NOW(),(SELECT data_envio as data_ultimo_envio FROM relacionamento_email WHERE vkt_id='$cliente->vkt_id' AND tipo='paciente_inativo' ORDER BY id DESC LIMIT 1)) as dias"),0,0);		
				
		//chama a funcao email_agendamento
		//echo $data_ultimo_envio." - ".$cliente->dias_envio_email_visita."<br>";
		if(empty($data_ultimo_envio)||$data_ultimo_envio>=$cliente->dias_envio_email_visita){
			
			email_visita($cliente->vkt_id,$cliente->de_email_visita,$cliente->assunto_email_visita,$cliente->texto_email_visita,$cliente->dias_envio_email_visita);
		}
	}
	
	if($cliente->sms_visita=='sim'){
		
		//verifica quando último sms de visita foi enviado
		$data_ultimo_envio = mysql_result(mysql_query($t="SELECT DATEDIFF(NOW(),(SELECT data_envio as data_ultimo_envio FROM relacionamento_sms WHERE vkt_id='$cliente->vkt_id' AND tipo='paciente_inativo' ORDER BY id DESC LIMIT 1)) as dias"),0,0);		
				
		//chama a funcao email_agendamento
		//echo $data_ultimo_envio." - ".$cliente->dias_envio_email_visita."<br>";
		if(empty($data_ultimo_envio)||$data_ultimo_envio>=$cliente->dias_envio_sms_visita){
			
			sms_visita($cliente->vkt_id,$cliente->texto_sms_visita,$cliente->dias_envio_sms_visita,$config);
		}
	}
}

?>