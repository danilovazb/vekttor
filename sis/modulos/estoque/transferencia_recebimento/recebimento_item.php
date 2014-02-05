<?php
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
/*- Variaveis Globais -*/
var caminho = 'modulos/estoque/transferencia_recebimento/item_recebimento.php?acao=';

$("#qtd_recebida").live('blur',function(e){
	var transferencia_id = $("#transferencia_id").val();
	var conversao2       = $(this).parent().parent().find("#conversao2").val();
	var unidade_tipo     = $(this).parent().parent().find("#tipo_unidade").val();
	var qtd = $(this).val();
	var produto_id = $(this).parent().parent().attr('id');
	$.post(caminho+'recebe_upqtd',{qtd:qtd,id_p:produto_id,t:transferencia_id,conversao2:conversao2,unidade_tipo:unidade_tipo});
											
});/* Fim Script */
		
/* OCORRENCIA ITEM DO RECEBIMENTO */
$("#oc_recebimento_item").live("blur",function(){			
	var transferencia_id = $("#transferencia_id").val();
	var produto_id       = $(this).parent().parent().attr('id');
	var ocorrencia_item  = $(this).val();
	$.post(caminho+'oc_item',{trans_id:transferencia_id,p_id:produto_id,oc:ocorrencia_item});
			
}); /* Fim Script*/
/* OCORRENCIA DO RECEBIMENTO */
$("#oc_recebimento").live('blur',function(e){
	var transferencia_id = $("#transferencia_id").val();
	var ocorrencia = $("#oc_recebimento").val();			
	$.post(caminho+'oc_recebimento',{trans_id:transferencia_id,oc_recebimento:ocorrencia});
});/* Fim Script */

/*RECEBIMENTO */
$("#recebido").live('click',function(){
	$("#form_recebimento").submit();							
});/* Fim Script */
</script>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<div id='conteudo'>
<div id='navegacao'>
<a href="?" class='s1'>
  	Sistema NV
</a>
<a href="?" class='s2'>
  	Estoque
</a>
<a href="?tela_id=96" class='navegacao_ativo'>
<span></span>Transfer&ecirc;ncia de Mercadoria
</a>
</div>
<div id="barra_info">
  <?php
  	if(isset($_GET['id_origem']) and isset($_GET['id_destino']) and ($_GET['acao'] == 'edit_recebimento')){
			
			$origem = $_GET['id_origem'];
			$destino = $_GET['id_destino'];
			
		$origem_nome = mysql_fetch_object(mysql_query(" SELECT * FROM cozinha_unidades WHERE id = ".$_GET['id_origem']));
		$destino_nome = mysql_fetch_object(mysql_query(" SELECT * FROM cozinha_unidades WHERE id = ".$_GET['id_destino']));
	
	}
  ?>
  <div style="float:left;"><strong>Origem:</strong> <?=$origem_nome->nome;?></div>
  <div style="float:left;margin-left:15px;"><strong>Destino:</strong> <?=$destino_nome->nome;?></div>
  <div style="float:left;margin-left:15px;"><strong>N&ordm; Transfer&ecirc;ncia: </strong><?=$transferencia_id?></div>
  <div style="float:left;margin-left:15px;"><strong>Data: </strong><?=dataUsaToBr($transferencia->data_inicio)?></div>
  <div style="float:left;margin-left:15px;"><strong>Status: </strong><?=$status_transferencia[$transferencia->status]?></div>
  	
 	<div style="float:right; margin-right:15px;"> 
    	<? if($_GET['acao'] == 'edit_recebimento'){
			if($transferencia->status == '2')
				$disable = 'disabled="disabled"';
			?>    	
			<input <?=$disable?> name="action" id="recebido" type="button"  value="Recebido" />
        <? }?>
        	  <input type="button" value="Imprimir" onclick="window.open('modulos/estoque/transferencia/impressao_transferencia.php?id=<?=$transferencia_id?>','_BLANK')" /> 
   </div>
</div>

<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="190">Produto</td>
          <td width="55">Enviado</td>
          <td width="65">Recebido</td>
          <!--<td width="60">UND</td>-->
          <!--<td width="75">Embalagem</td>-->
          <td width="180">Ocorrencia</td>
          <td width="200">Ocorrencia de Envio</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<form id="form_recebimento"  method="post">
<input type="hidden" name="acao" value="receber">
<input type="hidden" name="id_origem" id="id_origem" value="<?=$_GET['origem']?>">
<input type="hidden" name="id_destino" id="id_destino" value="<?=$_GET['destino']?>">
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody id="tbody">
        <?
        	if($_GET['acao'] == 'edit_recebimento'){
				$display = 'compact';
				while($r=mysql_fetch_object($item)){
					if($r->unidade_tipo=='unidade_uso'){
						$qtd_enviada  = $r->qtd_enviada * $r->conversao2;
						$qtd_recebida = $r->qtd_recebida * $r->conversao2;
						$unidade = $r->unidade_uso;
					}else{
						$qtd_enviada = $r->qtd_enviada;
						$qtd_recebida = $r->qtd_recebida;
						$unidade = $r->unidade_embalagem;
					}
				
		?>
        <input type="hidden"  name="transferencia_id" id="transferencia_id" value="<?=$transferencia_id;?>">     
        <tr id="<?=$r->produto_id;?>">
          <td width="190"><?=$r->nome;?></td>
          <td width="55">
          <input type="hidden" name="conversao2[]" id="conversao2" value="<?=$r->conversao2;?>" style="width:50px;">
          <input type="hidden"  name="produto_id[]" id="produto_id" value="<?=$r->produto_id;?>">
          <input type="hidden" name="qtd_enviada[]" id="qtd_enviada" size="5" style="height:10px;font-size:11px;" value="<?=$r->qtd_enviada?>">
          <input type="hidden" name="tipo_unidade[]" id="tipo_unidade" size="5" style="height:10px;font-size:11px;" value="<?=$r->unidade_tipo?>">
          <?=$qtd_enviada." ".substr($unidade,0,3)?> 
          </td>
          <td width="65">
          <!-- <input type="text" <?=$disable?> lang="<?=$r->produto_id;?>" name="qtd_recebida[]" id="qtd_recebida" size="3" style="height:9px;font-size:11px;" value="<? if($transferencia->status == 1) {echo $qtd;} else { echo $r->qtd_recebida; } ?>">--> 
		  <input type="text" <?=$disable?> lang="<?=$r->produto_id;?>" name="qtd_recebida[]" id="qtd_recebida" size="3" style="height:9px;font-size:11px;" value="<? if(empty($r->qtd_recebida)) {echo $qtd_enviada;} else { echo qtdUsaToBr($qtd_recebida,2); } ?>">
		  <?=substr($unidade,0,3)?>
          </td>
          <!--<td width="60"><?$r->unidade?></td>-->
          <!--<td width="75"><?$r->unidade_embalagem?></td>-->
          <td width="180"><input type="text" <?=$disable?> lang="<?=$r->produto_id;?>" name="oc_recebimento_item" id="oc_recebimento_item" style="height:10px; width:160px;font-size:11px;"  value="<?=$r->oc_recebimento?>">
            
          </td>
           <td width="200"><?=$r->ocorrencia?></td>
          <td></td>
          
        </tr>
    	<? 		}
			}
		?>
    </tbody>
</table>
</form>
<div>
	<div style="margin:5px;"> <span>Ocorr&ecirc;ncia de Envio:</span>
    	<div>
        	<?=$transferencia->ocorrencia_pedido?>
        </div>
    </div>
</div>

<div>
	<div style="margin:5px;"> <span style="#">Ocorr&ecirc;ncia Recebimento</span>
    	<div>
        <label>
    		<input type="text" style="height:14px;"  name="oc_recebimento" id="oc_recebimento" size="40" value="<?=$transferencia->ocorrencia_recebimento?>">
        </label>
        </div>
    </div>
</div>

<script>
</script>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
          <td width="300"></td>
          <td width="70">&nbsp;</td>
          <td ></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>

</div>
