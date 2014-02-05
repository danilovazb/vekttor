<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("../../../modulos/financeiro/_functions_financeiro.php");
include("_functions.php");
include("_ctrl.php");

 
$mostra_total_tabela = 0;
$cont = 0;
$negrito = 'style="font-weight:bold"';
$aprovado = 0;
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
input,textarea{ display:block;}
tbody tr{ background:#999;}
</style>

<div>
<div id='aSerCarregado'>
<div style="width:700px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Aprova&ccedil;&atilde;o e Pagamento</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" id="form_odonto_pagamento" method="post" enctype="multipart/form-data">
    <input name="id" id="id" type="hidden" value="<?=$atendimento_id?>" />
    <input type="hidden" name="cliente_id" value="<?=$paciente->id?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
		<legend><strong>Hist&oacute;rico</strong></legend>
          <label style="width:300px; padding:10px 10px 10px 3px;">
        	<span >Nome Paciente: <strong><?=$paciente->nome_fantasia;?></strong></span>
		  </label >
    <div style="clear:both"></div>
    	<table cellpadding="0" cellspacing="0" width="100%" id="procedimento" style="background:#FFF">
            <thead>
                <tr>
                    <td style="border-left:1px solid #CCC;" width="10"></td>
                    <td width="200">Procedimento Aprova&ccedil;&atilde;o com ordem de data</td>
                    <td width="20" >Debito</td>
                    <td width="20" >Credito</td>
                    <td width="20" >Saldo</td>
                    <td width="20" ></td>
                </tr>
            </thead>
    <tbody>
	  <?php
          $sql = mysql_query($t=" SELECT * FROM odontologo_atendimento_item 
		  WHERE vkt_id = '$vkt_id' AND odontologo_atendimento_id = '$atendimento_id' AND status != '3' ");
		  
		  $ultimo = mysql_num_rows($sql);
		  $total_saldo = 0;
          while($item=mysql_fetch_object($sql)){	
                  $cont++;
				  
				  $servico = mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE id = '$item->servico_id' "));
				  if($item->aprovado == 1){
				  	$aprovado = 1;
					$saldo += ($item->valor);
					$total_saldo += ($item->valor);
				  }
				  
      ?>
        <tr  <?php if($item->aprovado == '1') {echo 'class="marcado"';}?> id="<?=$item->id?>">
            <td style="border-left:1px solid #CCC;">
             	<input type="hidden" name="todos_item[]" value="<?=$item->id?>">
            	<input type="checkbox" value="<?=$item->id?>" name="marcar[]"  <?php if($item->aprovado == '1') {echo "checked='checked'";} if($item->financeiro == "sim"){ echo 'disabled="disabled"';} else { echo '';}?>   >
            </td> 
            <td><?=dataUsaToBr($item->data_cadastro);?> - <?=$servico->nome;?> &nbsp; <?=$item->id?> </td>
            <td id="valor_item"><?=moedaUsaToBr($item->valor);?></td>
            <td id="creddito"></td>
            <td><span <? if($cont == $ultimo){ echo $negrito;} ?> ><?=moedaUsaToBr($saldo);?></span></td>
            <td width="20" >
            	
            </td>
        </tr>		
    <?php
			}
			
	        /* Financeiro */
			$sqlFinance = mysql_query(" SELECT * FROM financeiro_movimento WHERE internauta_id = '$paciente->id' AND cliente_id = '$vkt_id' AND doc = '$atendimento_id' AND extorno != '1' AND status != '2' ORDER BY status ASC ");
			
			while($finance=mysql_fetch_object($sqlFinance)){
				
				$sinal = "";
				if($finance->id > 0){
					$mostra_total_tabela = 1;
					$exibe_botao_imprimir = "<button type='button' onclick='window.open(\"modulos/odonto/pagamento/nota_promissoria.php?id=$finance->id&atendimento_id=$atendimento_id\")' class='botao_imprimir' style='float:right; margin-top:2px; margin-right:5px;' ><img src='../fontes/img/imprimir.png' /> </button> ";
				}
				
				if($finance->status == 1){
					$sinal = "-";
					$valor_credito =  $finance->valor_cadastro;
					$valor_debido = "";
					$status = "<span class='font-aprovado'>pago</span>";
					$salatual = ($saldo - $finance->valor_cadastro);
					$saldo = $salatual; 
				} else{
					$status = "<span class='font-important'>pendente</span>";
					$valor_credito  =  "";
					$valor_debido = $finance->valor_cadastro;
				}
					
	?>
    
    <tr class="parcela">
    	  <td width="10" style="border-left:1px solid #CCC;"></td>
          <td id="descParcela" style="color:<?=$cor?>; "><?=dataUsaToBr($finance->data_vencimento)?> <?=$finance->descricao;?> &nbsp; <?=$status?> </td>
          <td style="font-weight:bold;"><?=moedaUsaToBr($valor_debido);?></td>
          <td style="color:<?=$cor?>; font-weight:bold;"><?=$sinal?><?=moedaUsaToBr($valor_credito);?></td>
          <td><?=moedaUsaToBr($saldo);?></td>
          <td width="20" ><?=$exibe_botao_imprimir?></td>
          <!--<td></td>-->
    </tr>
    		<?php } ?>
    </tbody>
    <!-- foot-->
    <thead>
    	<tr>
           	<td style="border-left:1px solid #CCC;"></td>
            <td align="right" style="padding-right:5px;">Total</td>
            <td></td>
            <td></td>
            <td id="total-table"><? if($aprovado == 1){ echo moedaUsaToBr($total_saldo);}?></td> <!--  <?if($aprovado == 1){ echo moedaUsaToBr($saldo);}?>?>-->
            <td>
            	
            </td>
      	</tr>
    </thead>
</table>
<div style="clear:both"></div>
<div style="padding:5px;">
        <label style="width:120px;">
			Forma de Pagamento
			  <select name="forma_pagamento" id="forma_pagamento">
              <?
              $select_pagamento[$obj->forma_pagamento]='selected="selected"';
			  ?>
			    <option value="1" <? if($formaPagamento->forma_pagamento == '1'){echo 'selected="selected"';}?> >Dinheiro</option>
			    <option value="2" <? if($formaPagamento->forma_pagamento == '2'){echo 'selected="selected"';}?>>Cheque</option>
			    <option value="4" <? if($formaPagamento->forma_pagamento == '4'){echo 'selected="selected"';}?>>Boleto</option>
			    <option value="5" <? if($formaPagamento->forma_pagamento == '5'){echo 'selected="selected"';}?>>Permuta</option>
			    <option value="6" <? if($formaPagamento->forma_pagamento == '6'){echo 'selected="selected"';}?>>Outros</option>
                <option value="7" <? if($formaPagamento->forma_pagamento == '7'){echo 'selected="selected"';}?>>Transferencia</option>
                <option value="8" <? if($formaPagamento->forma_pagamento == '8'){echo 'selected="selected"';}?>>Dep&oacute;sito</option>
                <option value="3" <? if($formaPagamento->forma_pagamento == '3'){echo 'selected="selected"';}?>>Cartao Cr&eacute;dito Visa</option>
                <option value="9" <? if($formaPagamento->forma_pagamento == '9'){echo 'selected="selected"';}?>>Cartao Cr&eacute;dito Mastar</option>
                <option value="10" <? if($formaPagamento->forma_pagamento == '10'){echo 'selected="selected"';}?>>D&eacute;bito Mastar</option>
                <option value="11" <? if($formaPagamento->forma_pagamento == '11'){echo 'selected="selected"';}?>>D&eacute;bito Visa</option>
                
		      </select>
		   </label>
        
<label style="width:65px;">Valor
	
	<input type="text" name="valor_total[]" id="valor_total" decimal="2" sonumero="1" value="<? if($aprovado == 1 and $mostra_total_tabela == 0) { echo moedaUsaToBr(trim($saldo,'-'));}?>" style="text-align:right;"> <!-- <?moedaUsaToBr(trim($saldo,'-'));?>-->
</label>
<label style="width:88px;">Primeira Parcela
    <input type="text" name="pri_parcela[]" id="pri_parcela" value="<?php echo date('d/m/Y');?>">
</label>
<label>Parcelas<br/>
	<select name="parcelas" id="parcelas" style="width:85px;">
        <option value="1">1x</option>
        <option value="2">2x</option>
        <option value="3">3x</option>
        <option value="4">4x</option>
        <option value="5">5x</option>
        <option value="6">6x</option>
        <option value="7">7x</option>
        <option value="8">8x</option>
    </select>
</label>
</div>
<div style="clear:both;"></div>    
<label style="width:150px;">
			Conta
			  <select name="conta_id" id="conta_id">
					<option value='0'  >Selecione 1 Conta</option> 
              <?
              $q= mysql_query("select * from financeiro_contas WHERE  cliente_vekttor_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'order by preferencial DESC,nome");
			  while($r= mysql_fetch_object($q)){
				$saldo=checaSaldo($r->cliente_vekttor_id ,$r->id );
				$saldo=number_format($saldo,2,',','.');
				if($obj->id>0){
					if($r->id==$obj->conta_id){$sel = "selected='selected'";}else{$sel = "";}
				}else{
					if($r->id==$sqlConta->conta_id){$sel = "selected='selected'";}else{$sel = "";}
				}
					echo "<option value='$r->id' $sel >$r->nome   $saldo</option>";  
				}
			  ?>		    
		    </select>
        </label>
        <label style="width:120px;">
            
			Centro de Custos
			<select name="centro_custo_id[]" id=''>
              	<?
				exibe_option_sub_plano_ou_centro('centro',0,$sqlConta->centro_custo_id,0);
				?>
              </select>
        </label>
        <label style="width:120px;">
			Plano de Conta
			<select name="plano_de_conta_id[]">
              	<?
				exibe_option_sub_plano_ou_centro('plano',0,$sqlConta->plano_conta_id,0);
				?>
              </select>
        </label>
<div style="clear:both;"></div>
<div id="info_parcela"></div>
</fieldset>
<div style="display:none;" id="result_loading"><span><strong>Carregando...</strong></span></div>
<div id="result" style=" float:left;"></div>     	
<!--Fim dos fiels set-->
<div style="width:100%; text-align:center; height:20px;" id="btn_info" >

<input type="button" onclick="window.open('modulos/odonto/atendimento/impressao_orcamento.php?atendimento_id=<?=$atendimento_id?>&acao=comprovante','_BLANK')" value="Imprimir Or&ccedil;amento" style="float:left;" />
<button type="button" onclick="window.open('modulos/odonto/atendimento/impressao_orcamento.php?atendimento_id=<?=$atendimento_id?>&acao=orcamento','_BLANK')" style="float:left;">Comprovante </button>


<input type="hidden" name="action" value="MandarFinanceiro">
<button type="button" id='botao_salvar'  style="float:right" />Enviar ao Financeiro</button>
</div>
<div style="clear:both"></div>
</form>
</div>
</div>
</div>
<script>
top.openForm();

</script>