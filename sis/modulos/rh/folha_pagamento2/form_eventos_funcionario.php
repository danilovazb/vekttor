<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 
?>
<style>
input,textarea{ display:block;}

</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:900px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Eventos Adicionais </span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<a onclick="aba_form(this,0)"><strong>Eventos</strong></a>
		</legend>
        <label>
        	<strong>Funcionário:</strong> <?=$funcionario->nome?> <strong>Salário:</strong>R$<?=moedaUsaToBr($funcionario->salario)?>
        </label>
        <table width="100%" cellspacing="0" cellpadding="0">
        	<thead>
            	<tr>
                	<td align="center">Evento</td>
                    <td align="center">Valor</td>
                    <td align="center">Desconto</td>
                    <td align="center">Desconto faltas</td>
                    <td align="center">Desconto mês anterior</td>
                    <td align="center">Desconto compartilhado</td>
                    <td align="center">Saldo</td>
                    <td align="center">Saldo Devedor</td>
                     <td align="center">&nbsp;</td>
                </tr>
            </thead>
            <tbody style="background-color:white;">
            
            <? 
			$valor_total=0;
			$saldo_devedor_total=0;
			while($funcionario_evento=mf($funcionario_eventos_q)){ 
				$evento=mf(mq($xy="SELECT * FROM rh_eventos WHERE id='$funcionario_evento->evento_id' LIMIT 1"));
				//if($evento->forma_valor==0){$valor=$funcionario_evento->valor_real;}
				//if($evento->forma_valor==1){$valor=($funcionario_evento->valor_real/100)*$funcionario->salario;}//$premio = $funcionario_evento->valor_real;
				
				/*
				$valor=$funcionario_evento->valor_real;
				$valor_total+=$funcionario_evento->premio;
				$saldo_devedor_total+=$funcionario_evento->saldo_devedor;*/
				$premio=$funcionario_evento->premio;
				$valor=$funcionario_evento->valor_real;
				$valor_total+=$funcionario_evento->valor_real;
				$saldo_devedor_total+=$funcionario_evento->saldo_devedor;
				$i++;
				if($i%2){$al='class="al"';}else{$al='';}
			?>
            	<tr <?=$al?>>
                	<td align="center">
                    	<input type="hidden" class="evento_funcionario_id" value="<?=$funcionario_evento->id?>" />
                        <input type="hidden" class="valor_original" value="<?=$premio?>" />
                        <input type="hidden" class="folha_funcionario_id" value="<?=$folha_funcionario->id?>" />
						<span rel="tip" title="<?php if($funcionario_evento->tributaveis=="sim"){ echo "Tributado";}else{ echo "Não Tributado";}?>"><?=$funcionario_evento->nome?></span> 
                    </td>
                    <td align="center"><span class="valor_original_br"><?=moedaUsaToBr($premio)?></span></td>
                    <td align="center"><input  style=" width:80px; text-align:right"type="text" class="desconto calculavel"  value="<?=$funcionario_evento->desconto?>" size="5" sonumero="1" decimal="2"></td>
                    <td align="center"><input sonumero="1" value="<?=$funcionario_evento->desconto_faltas?>" style=" width:80px; text-align:right" decimal="2" class="desconto_faltas calculavel"  type="text"></td>
                    <td align="center"><input sonumero="1" value="<?=$funcionario_evento->desconto_mes_anterior?>" decimal="2" class="desconto_mes_anterior calculavel" style=" width:80px; text-align:right"  type="text"></td>
                    <td align="center"><input sonumero="1" value="<?=$funcionario_evento->desconto_grupo?>" decimal="2" class="desconto_compartilhado calculavel" style=" width:80px; text-align:right" type="text"></td>
                    <td align="center"><span class="saldo"><?=moedaUsaToBr($funcionario_evento->valor_real)?></span></td>
                    <td align="center"><span class="saldo_devedor"><?=moedaUsaToBr($funcionario_evento->saldo_devedor)?></span></td>
                    <td>
                    	<button type="button" funcionario_id="<?=$funcionario_evento->funcionario_id?>" 
                        onclick="window.open('modulos/rh/relatorios/relatorio_eventos/impressao_relatorio_eventos.php?eventos=<?=$funcionario_evento->evento_id?>&empresa_id=<?=$folha->empresa_id?>&mes=<?=$folha->mes?>&ano=<?=$folha->ano?>')"
                        name="imprimir_relatorio_eventos" title="Imprimir Realtório de Eventos" class="botao_imprimir">
							<img src="../fontes/img/imprimir.png">
						</button>
                    </td>
                </tr>
            <? } ?>
            </tbody>
        	<tfoot>
            	<tr>
                	<td align="center">
                    	
                    </td>
                    <td align="center"></td>
                    <td align="center" class="desconto_total"></td>
                    <td align="center" class="desconto_faltas_total"></td>
                    <td align="center" class="desconto_mes_anterior_total"></td>
                    <td align="center" class="desconto_compartilhado_total"></td>
                    <td align="center" class="saldo_total"><?=$valor_total?></td>
                    <td align="center" class="saldo_devedor_total"><?=$saldo_devedor_total?></td>
                    <td align="center">&nbsp;</td>
                </tr>
            </tfoot>
        </table>

        
       	<div style="clear:both"></div>
	</fieldset>
	<input name="empresa_id" type="hidden" value="<?=$empresa_id?>" />
    <input name="folha_id" type="hidden" value="<?=$folha->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >


<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>