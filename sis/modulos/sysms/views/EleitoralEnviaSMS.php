<?php
	$dados = array();
	
	if(isset($_GET['acao'])){	
		include('../InstanceViews.php');
			$control = new EleitoralSMSController;			
			exit;
	} 
	if(isset($_GET['inicio'])){
		include("modulos/sysms/Instance.php");
		$dados = $EleitoralSMS->listagem_data($_GET['inicio'],$_GET['fim']);	
	}
	else {
	include("modulos/sysms/Instance.php");
	$dados = $EleitoralSMS->listagem();
		
	$total = $EleitoralSMS->Enviados();
	
	$totalCreditos = $EleitoralSMS->SMSCreditos($vkt_id);
	
	$disponivel = ($totalCreditos - $total);
	}
?>
<script type="text/javascript">
$(document).ready(function(){
	$(document).ready(function(){
	var iconCarregando = $('<img src="img/ico/ajaxload.gif" /> <span class="font">Carregando. Por favor aguarde...</span>');
	$('#enviaAdd').live('click',function(e) {
	e.preventDefault();
	var serializeDados = $('#smsEnvia').serialize();
	$('#resultSMS').css('display', 'block');
	$.ajax({
			url: 'modulos/sysms/views/EleitoralEnviaSMS.php?acao=envia', 
			dataType: 'html',
			type: 'POST',
			data: serializeDados,
			beforeSend: function(){ $('#resultSMS').html(iconCarregando);},
			complete: function() {$(iconCarregando).remove();},
			success: function(data, textStatus) {$('#resultSMS').html('<p>' + data + '</p>');},
			error: function(xhr,er) {
				$('#resultSMS').html('<p class="destaque">Lamento! Ocorreu um erro. Por favor tente mais tarde.')
			}		
		});
	});	
})
	
})
/*---- FORM REENVIA -----*/
$(document).ready(function(){
	$(document).ready(function(){
	var iconCarregando = $('<img src="img/ico/ajaxload.gif" /> <span class="font">Carregando. Por favor aguarde...</span>');
	$('#reenviaform').live('click',function(e) {
	e.preventDefault();
	var serializeDados = $('#smsEnviaEdit').serialize();
	$('#resultSMS').css('display', 'block');
	$.ajax({
			url: 'modulos/sysms/views/EleitoralEnviaSMS.php?acao=reenvia', 
			dataType: 'html',
			type: 'POST',
			data: serializeDados,
			beforeSend: function(){
			$('#resultSMS').html(iconCarregando);
			},
			complete: function() {
			$(iconCarregando).remove();
			},
			success: function(data, textStatus) {
			$('#resultSMS').html('<p>' + data + '</p>');
			},
			error: function(xhr,er) {
				$('#resultSMS').html('<p class="destaque">Lamento! Ocorreu um erro. Por favor tente mais tarde.')
			}		
		});
	});	
});	
});
$("#aba_envia_unico").live("click",function(){
	aba_form(this,1);
	$("#enviaAdd").hide();
	$("#enviaUnic").show();
});
$("#aba_envia").live("click",function(){
	$("#enviaUnic").hide();
	$("#enviaAdd").show();
});
</script>
<script>
$(document).ready(function(){
	$("tr:odd").addClass('al');
})
$("#tabela_dados tr").live("click",function(){
	var id_msg = $(this).attr('id');
	var msg    = $(this).attr('title');
	window.open('modulos/sysms/views/forms/EleitoralEditSMS.php?idMsg='+id_msg+'&msg='+msg,'carregador');
});
$("#enviaUnic").live("click",function(){
	if( $.trim($("#celular_unico").val()) != ""){
		var telefone = $("#celular_unico").val();
		var cliente_id = $("#cliente_id").val();
		var msg = $("#msg_unica").val();
		$.post('modulos/sms/enviasms.php',{tel_unico:telefone,cliente_id:cliente_id,msg:msg},function(data){
			$("#resultSMS").show();
			$("#resultSMS").html(data);
		});
		
	} else{
		alert("Não existe telefone!");
		return false;	
	}
});
//$("input:radio:checked")
</script>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="" class='s1'>
  	Sistema
</a>
<a href="" class='s2'>
  	Envio de SMS
</a>
<a href="" class='navegacao_ativo'>
<span></span>    Enviar SMS
</a>
</div>
<script>

</script>
<div id="barra_info">
    
<form method="get"  >
<input type="hidden" name="tela_id" value="155" /> 
    Data 
    <input id='inicio' type="text" name="inicio" size="10" value="<?php echo $_GET['inicio'];?>" mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0"  >
    <input id='fim'  type="text" name="fim" size="10" value="<?php echo $_GET['fim'];?>" mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0" > 
    <input type="submit" name="Submit" value="Filtrar">	
	<div style="float:left;width:130px;padding:1px;">Total Enviado: <b><?php echo $total;?></b></div>
    <div style="float:left;width:130px;padding:1px;">Total Adquiridos: <b><?php echo $totalCreditos;?></b></div>
    <div style="float:left;width:130px;padding:1px;">Total Dispon&iacute;vel: <b><?php echo $disponivel;?></b></div>
    <a href="modulos/sysms/views/forms/EleitoraladdSMS.php" target="carregador" class="mais"></a>
</form>

</div>

<table cellpadding="0" cellspacing="0" width="100%" >
   <thead>
    	<tr>
          <td width="300"></td>
          <td width="100" colspan="2" style="padding-left:0" align="center">Eleitor</td>
          <td width="100" colspan="2" style="padding-left:0" align="center">Politico</td>
          <td width="100" colspan="2" style="padding-left:0" align="center">Colaborador</td>
          <!--<td width="120">Nao Enviado</td>-->
          <td width="80"></td>
          <td ></td>
        </tr>
    </thead>
    <tr>
        <td width="300"><strong>Mensagem Enviada</strong></td>
        <!-- eleitor -->
        <td width="50">Enviado</td>
        <td width="50">Perdido</td>
        <!-- politico -->
        <td width="50">Enviado</td>
        <td width="50">Perdido</td>
        <!-- politico -->
        <td width="50">Enviado</td>
        <td width="50">Perdido</td>
        <td width="80"><strong>Data Envio</strong></td>
        <td ></td>
    </tr>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
    
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
		<?php 
			
			$result = sizeof($dados);
			
				if($result > 0){
				foreach($dados as $r){
		?>      
    	<tr <?=$sel?> id="<?php echo $r->id?>" title="<?php echo $r->msg_enviada;?>">
          <td width="300"><?php echo $r->msg_enviada;?></td>
          	
			<?php  
			$t_enviado_eleitor = $EleitoralSMS->VerificaNumMsg($r->id,'eleitor_id','eleitoral_sms_envios');
					if($t_enviado_eleitor > 0)
						$cor='#009900';
					 else
						$cor='#C40000';	
					
			$t_naoenviado_eleitor = $EleitoralSMS->VerificaNumMsg($r->id,'eleitor_id','eleitoral_sms_falhou');
				if($cor_naoenviado_eleitor == 0 or $cor_naoenviado_eleitor > 0)
					$cor_naoenviado_eleitor='#C40000';	
				
			?>
            
          <td width="50" style="color:<?=$cor?>; font-weight:bold;">
		  	<?php echo $t_enviado_eleitor;?>
          </td>
          
          <td width="50" style="color:<?=$cor_naoenviado_eleitor?>; font-weight:bold;">
		  	<?php echo $t_naoenviado_eleitor;?>
          </td>
          
            <?php 
			
			$t_enviado_politico = $EleitoralSMS->VerificaNumMsg($r->id,'politico_id','eleitoral_sms_envios');
						
						if($t_enviado_politico > 0)
							$cor='#009900';
						 else
							$cor='#C40000';	
							
			$t_naoenviado_politico = $EleitoralSMS->VerificaNumMsg($r->id,'politico_id','eleitoral_sms_falhou');
			
				if($t_naoenviado_politico == 0 or $t_naoenviado_politico > 0)
						$cor_naoenviado_politico = '#C40000';
			?>
            
          <td width="50" style="color:<?=$cor?>; font-weight:bold;">
		  	<?php echo $t_enviado_politico;?>
          </td>
          <td width="50" style="color:<?=$cor_naoenviado_politico?>; font-weight:bold;">
		  	<?php echo $t_naoenviado_politico;?>
          </td>          
            <?php 
				
				$t_enviado_coladorador = $EleitoralSMS->VerificaNumMsg($r->id,'colaborador_id','eleitoral_sms_envios');
						
						if($t_enviado_coladorador > 0)
							$cor='#009900';
						 else
							$cor='#C40000';
							
				$t_naoenviado_coladorador = $EleitoralSMS->VerificaNumMsg($r->id,'colaborador_id','eleitoral_sms_falhou');
					if($t_naoenviado_coladorador == 0 or $t_naoenviado_coladorador > 0)
								$cor_naoenviado_coladorador = '#C40000';
						
			
			?>
          <td width="50" style="color:<?=$cor?>; font-weight:bold;">
          	<?php echo $t_enviado_coladorador;?>
          </td>
          
           <td width="50" style="color:<?=$cor_naoenviado_coladorador?>; font-weight:bold;">
          	<?php echo $t_naoenviado_coladorador;?>
          </td>
          
          <td width="80"><?php $EleitoralSMS->DateTime($r->data);?></td>
          <td ></td>
        </tr>
	<?php
			}
		}
	?>
    	
    </tbody>
</table>
<input type="hidden" name="vkt" id="vkt" value="<?php echo $vkt_id;?>">
<?
//print_r($_POST);
?>
</div>
<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        	<td width="20"></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td width="50"><?php //$q_total->horas?></td>
          <td width="580">&nbsp;</td>
          <td width="80">&nbsp;</td>
          <td ></td>
        </tr>
    </thead>
</table>


</div>

<div id='rodape'>
	
</div>
