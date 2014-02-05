<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
$disabled_ferias = ""; 
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:512px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    <span>Demiss&atilde;o de Funcion&aacute;rio</span></div>
    </div>
	<form onSubmit="return validaForm(this)" target="_blank" class="form_float" method="post">
    <input type="hidden" name="data_admissao" id="data_admissao" value="<?=$registro->data_admissao?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
            <a onclick="aba_form(this,0)"> <strong>Informa&ccedil;&otilde;es</strong></a>
    		<a onclick="aba_form(this,1)"> Dedu&ccedil;&otilde;es </a>
            <a onclick="aba_form(this,2)"> Impressões </a>
		</legend>
       <? 
	   	if($fun_ferias > 0){
			$disabled_ferias = 'disabled="disabled"';
	   ?> 
        <div style="background:#EB2D37; color:#FFF; text-align:center; border:1px solid #666; padding:5px;">
        	<span>Funcion&aacute;rio de Ferias </span>
        </div>
        <div style="margin-top:8px;"></div>
       <?
		}
	   ?>
       <label style="width:300px">
            Funcionário 
            <input type="text" id='funcionario' name="funcionario" value="<?=$registro->nome?>" disabled="disabled"/>
           	<input type="hidden" name="funcionario_id" id='funcionario_id' value="<?=$registro->id?>"/>           
        </label>
        
        <label style="width:100px">
            CPF
            <input type="text" id='cpf_funcionario' name="cpf_funcionario" value="<?=$registro->cpf?>" disabled="disabled"/>
           	           
        </label>
        
        <div style="clear:both"></div>
        
        <label style="width:300px">
            Empresa
            <input type="text" id='empresa' name="empresa" value="<?=$empresa->razao_social?>" disabled="disabled"/>
           	<input type="hidden" name="empresa_id" id='empresa_id' value="<?=$empresa->id?>"/>           
        </label>
        
               
        
        
        <label style="width:90px;">
        	Saldo FGTS
		<input type="text" name="saldo_fgts" style="width:80px;" <?=$disabled_ferias;?> decimal="2" sonumero="1" value="<?=MoedaUsaToBr($demissao->saldo_fgts)?>"/>
        </label>
        <!--*-->
        <label style="width:108px;">
        	Tipo de Demissao
			<select name="tipo_demissao" <?=$disabled_ferias;?>/>
        		<option value="demissao_com_justa_causa" <? if($demissao->tipo_demissao=="demissao_com_justa_causa"){ echo "selected='selected'";}?>>Demissão com Justa Causa</option>
                <option value="demissao_sem_justa_causa" <? if($demissao->tipo_demissao=="demissao_sem_justa_causa"){ echo "selected='selected'";}?>>Demissão Sem Justa Causa</option>
                <option value="pedido_demissao" <? if($demissao->tipo_demissao=="pedido_demissao"){ echo "selected='selected'";}?>>Pedido de Demiss&atilde;o</option>
                <option value="fim_contrato" <? if($demissao->tipo_demissao=="fim_contrato"){ echo "selected='selected'";}?>>Fim de Contrato</option>
            </select>
        </label>
        <!--*-->
        <label style="width:95px;">
          Data Aviso Pr&eacute;vio
		  <input type="text" name="data_aviso_previo" id="data_aviso_previo" valida_minlength='8' retorno='focus|Informe data de demissao' rel="tip" <?=$disabled_ferias;?> title="Data Para o Aviso Pr&eacute;vio" calendario="1" style="width:80px;" mascara="__/__/____" value="<?=DataUsaToBr($demissao->data_aviso_previo)?>"/>
        </label>
        <div style=" float:left; color:#666;">
         <span style="color:#666;float:right;" >Cumprir aviso pr&eacute;vio?</span>
         <div style="clear:both; "></div>
         	<?
            	if($demissao->cumprir_aviso_previo == "sim"){
					$cumprir_sim = 'checked="checked"';	
				} else if($demissao->cumprir_aviso_previo == "nao"){
					$cumprir_nao = 'checked="checked"';
				}
			?>       
            Sim <input type="radio" name="cumprir_aviso_previo" id="cumprir_aviso_previo" value="sim"  <?=$cumprir_sim?> <?=$disabled_ferias;?> >
            N&atilde;o <input type="radio" name="cumprir_aviso_previo" value="nao" <?=$cumprir_nao?> <?=$disabled_ferias;?> id="cumprir_aviso_previo">
        </div>
        <!--*-->
        <div style="clear:both;"></div>
         <!--*-->
        <label style="width:108px;">
         C&oacute;d.Afastamento
		  <input type="text" name="codigo_afastamento" id="codigo_afastamento" <?=$disabled_ferias;?> rel="tip" title="C&oacute;digo do Afastamento"  style="width:80px; text-align:right"  value="<?=$demissao->cod_afastamento;?>"/>
        </label>
        <!--*-->
        <label style="width:108px;">
        	Data Afastamento
		<input type="text" name="data_demissao" id="data_demissao" <?=$disabled_ferias;?> style="width:80px;" maxlength="10" valida_minlength="3" value="<?=DataUsaToBr($demissao->data_demissao)?>" calendario="1" mascara="__/__/____"/>
        </label>
         <!--*-->
         <label style="width:108px;">	
          Adicional Noturno<br/>
		  <input type="text" name="adicional_noturno" id="adicional_noturno" <?=$disabled_ferias;?> style="width:80px; text-align:right"  sonumero="1"  value="<?=moedaUsaToBr($demissao->adicional_noturno)?>"/>
         </label>
        <div style="clear:both"></div>
        <!--*-->
         <label style="width:108px;">
          Horas Extras 50 %
		  <input type="text" name="horas_extras_50" id="horas_extras_50" <?=$disabled_ferias;?> style="width:80px; text-align:right;"  sonumero="1"  value="<?=$demissao->horas_extras_50;?>"/> 
         </label>
        <!--*-->
         <label style="width:108px;">
          Horas Extras 100 %
		  <input type="text" name="horas_extras_100" id="horas_extras_100" <?=$disabled_ferias;?> style="width:80px; text-align:right;"  sonumero="1"  value="<?=$demissao->horas_extras_100;?>"/> 
         </label>
          <!--*-->
         <label style="width:108px;">
          Comiss&atilde;o
		  <input type="text" name="comissao" id="comissao" <?=$disabled_ferias;?> style="width:80px;text-align:right" decimal="2" sonumero="1"  value="<?=moedaUsaToBr($demissao->comissao)?>"/>
         </label>
        <!--<label style="width:90px;">
          Insalubridade
		  <input type="text" name="adicional_insalubridade" id="adicional_insalubridade" decimal="2" sonumero="1" style="width:80px;"  value=""/>
        </label>-->
        
        <div style="clear:both;"></div>
        
         <!--*-->
         <!--<label style="width:108px; ">
          Periculosidade
		  <input type="text" name="periculosidade" id="periculosidade" style="width:80px;" decimal="2" sonumero="1"  value=""/>
         </label>-->
         <!--*-->
         <label style="width:108px;">
          Gorjetas<br>
		  <input type="text" name="gorjeta" id="gorjeta" style="width:80px;text-align:right" <?=$disabled_ferias;?> decimal="2" sonumero="1"  value="<?=moedaUsaToBr($demissao->gorjeta)?>"/>
         </label>
         <!--*-->
         <label style="width:108px;">
          Gratifica&ccedil;&otilde;es <br/>
		  <input type="text" name="gratificacao" id="gratificacao" <?=$disabled_ferias;?> style="width:80px; text-align:right" decimal="2" sonumero="1"  value="<?=moedaUsaToBr($demissao->gratificacao)?>"/>
         </label>
         <!--*-->
         <!--<label style="width:108px;">
          Descanso (DSR) <br/>
		  <input type="text" name="descanso_dsr" id="descanso_dsr" style="width:80px;text-align:right;" decimal="2" sonumero="1"  value="<?moedaUsaToBr($demissao->descanso_dsr)?>"/>
         </label>-->
          <!--*-->
         <label style="width:130px;">
          Multa Art.477,&sect;8&ordm;/CLT<br>
		  <input type="text" name="multa_artigo_477" id="multa_artigo_477" <?=$disabled_ferias;?> style="width:80px; text-align:right;" decimal="2" sonumero="1"  value="<?=moedaUsaToBr($demissao->multa_477)?>"/>
         </label>
         <!--*-->
         <div style="clear:both"></div>
         <label style="width:108px;">
         Férias Proporcionais<br/>
         	<input type="text" name="ferias_proporcional" id="ferias_proporcional" style="width:80px;" sonumero="1" value="<?=$demissao->ferias_proporcional?>">
         </label>
          <label style="width:132px;">
         	13º Salário Proporcional<br/>
            <input type="text" name="decimo_proporcional" id="decimo_proporcional" style="width:80px;" sonumero="1" value="<?=$demissao->decimo_proporcional?>">
         </label>
         <!--*-->
         <?php
         	if($demissao->saldo_dias_trabalho == "mes"){
				$checked = 'checked="checked"';
				$disable_dias = 'disabled="disabled"';
			}
		 ?>
         <label style="width:50px;">
         	Dias <br/>
            <input type="text" <?=$disable_dias?> name="dias"  id="dias" style="width:50px;" value="<?=$demissao->qtd_dias_trabalhado?>">
         </label><br/>
         
         <input type="checkbox" <?=$checked?>  name="mes_inteiro" id="mes_inteiro" value="mes"> Mês Inteiro
         
         <!--<input type="radio" name="dm_calculo" id="dm_calculo" value="mes"> Mês 
         <input type="radio" name="dm_calculo" id="dm_calculo" value="dia"> Dias-->
     
         <div style="margin-bottom:5px;"></div><br/>
         <!--<label id="dm_calculo_result">
         	<input type="text" name="mes_referencia" value="<?=$demissao->meses_trabalhado?>" style="display:none;">
            <input type="text" name="dia_referencia" value="<?=$demissao->dias_trabalhado?>" style="display:none;">
         </label>-->
        
         
       
         
         <!--*-->
         <div style="clear:both;"></div>
         <!--<label>
         	Motivo
            <textarea name="motivo" id="motivo"><?=$demissao->motivo?></textarea>
         </label>-->
         <div style="clear:both; "></div>
         <h5 style="color:#666;float:left;">13&ordm; Sal&aacute;rio Atrasado</h5>
         <div style="clear:both; "></div>
         <label>
         	Ano<br/>
            <input type="text" style="width:80px;" sonumero="1" maxlength="4" <?=$disabled_ferias;?> name="ano_decimo_terceiro_atrasado" id="ano_decimo_terceiro_atrasado" value="<?=$demissao->ano_decimo_terceiro_atrasado;?>">
         </label>
           
         <label>
          M&ecirc;s<br/>
          <input type="text" name="mes_decimo_terceiro_atrasado" style="width:80px;" <?=$disabled_ferias;?> sonumero="1" maxlength="2" id="mes_decimo_terceiro_atrasado" value="<?=$demissao->mes_decimo_terceiro_atrasado;?>">
         </label>
         <!-- * -->
       
    </fieldset>
    <fieldset style="display:none">
    	<legend>
            <a onclick="aba_form(this,0)"> Informa&ccedil;&otilde;es</a>
    		<a onclick="aba_form(this,1)"> <strong>Dedu&ccedil;&otilde;es</strong> </a>
            <a onclick="aba_form(this,2)"> Impressões </a>
		</legend>
          <!--*-->
           <label style="width:120px;">
            Adiantamento Salarial<br/>
            <input type="text" name="adiantamento_salarial"  id="adiantamento_salarial" decimal="2" sonumero="1" style="width:80px; text-align:right"  value="<?=moedaUsaToBr($demissao->adiantamento_salarial)?>"/>
           </label>
           <!--*-->
           <label style="width:140px;">
            Adiantamento 13&ordm; Salario<br/>
            <input type="text" name="adiantamento_decimo" id="adiantamento_decimo" decimal="2" sonumero="1" style="width:80px; text-align:right"  value="<?=moedaUsaToBr($demissao->adiantamento_decimo_salario)?>"/>
           </label>
            <!--*-->
           <label style="width:120px;">
            Outros Descontos<br/>
            <input type="text" name="outro_desconto" id="outro_desconto" decimal="2" sonumero="1" style="width:80px; text-align:right"  value="<?=moedaUsaToBr($demissao->outro_desconto)?>"/>
           </label>		
           <!--*-->
           <label style="width:160px;">
            Empr&eacute;stimo em Consigna&ccedil;&atilde;o <br/>
            <input type="text" name="emprestimo_consignado" id="emprestimo_consignado" decimal="2" sonumero="1" style="width:80px; text-align:right"  value="<?=moedaUsaToBr($demissao->emprestimo_consignacao)?>"/>
           </label>
           <div style="clear:both"></div>
    </fieldset>
    <fieldset style="display:none">
    	<legend>
            <a onclick="aba_form(this,0)"> Informa&ccedil;&otilde;es</a>
    		<a onclick="aba_form(this,1)"> Dedu&ccedil;&otilde;es </a>
            <a onclick="aba_form(this,2)"> <strong>Impressões</strong> </a>
		</legend>
          
           <input type="button" id="seguro_desemprego" name="seguro_desemprego" value="Seguro Desemprego" />
           
           <div style="clear:both"></div>
           
           <input type="button" id="comunicado_dispensa" name="comunicado_dispensa" value="Comunicado de Dispensa" />
           
           <div style="clear:both"></div>
           
            <input type="button" value="Ficha de Empregado (Frente)" class="imprimir_relatorio"/>
            
           <div style="clear:both"></div>
           
            <input type="button" id="resumo_funcionario" value="Resumo Funcionário"/>
<!--<input type="button" value="Ficha de Empregado (Verso)" class="imprimir_relatorio"  />

			<div style="clear:both"></div>

<input type="button" value="Imprimir PIS" class="imprimir_relatorio"  />

			<div style="clear:both"></div>

<input type="button" value="Termo de Opçao" class="imprimir_relatorio"/>-->
           
           
           <div style="clear:both"></div>
    </fieldset>
	<input name="id" type="hidden" value="<?=$demissao->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($demissao->id > 0){
?>
<input name="action" type="submit" value="Cancelar Demissão" style="float:left" />
<?
}

?>
<input name="action" type="submit" value="Salvar" style="float:right" <?=$disabled_ferias;?>  />
<?php
 if($registro->status == 'demitidos'){
?> <input name="action" type="submit"  value="Imprimir Rescisão" onclick="window.open('modulos/rh/demissao_funcionario/rescisao.php?funcionario=<?=$registro->id?>&id=<?=$demissao->id?>','_BLANK')"   /><?php	
}
?>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>