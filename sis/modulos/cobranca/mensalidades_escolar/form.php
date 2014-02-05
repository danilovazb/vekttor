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
<div style="width:630px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Gerar Mensalidades</span></div>
    </div>
	<form onSubmit="return formBoleto(this)" action="modulos/cobranca/mensalidades_escolar/retorno_geracao_boletos.php" target="_blank" class="form_float" method="POST" autocomplete='off'>
    <input type="hidden" name="id" id="id" value="<?=$equipamento->equipamento_id?>">
    
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
		 <legend>
            <a onclick="aba_form(this,0)"><strong>Geração de boletos por período</strong></a>
         </legend>
         <label style="width:500px">Período de
        	<input type="text" style="width:110px; display:block;" id="de" name="de" mascara="__/__/____" calendario='1'>
        </label>
        <label style="width:500px">a
        	<input type="text" style="width:110px; display:block;" id="a" name="a" mascara="__/__/____" calendario='1'>
        </label>
        
        <div style="clear:both"></div>
    	<label style="width:200px;">
        	<select id="periodo_id" name="periodo_id" onChange="carrega_matriculas(this)">
            <option value="0">Escolha o período</option>
            <?
            $periodos_q=mysql_query("SELECT * FROM escolar2_periodo_letivo WHERE vkt_id='$vkt_id' ORDER BY nome ASC");
			while($periodo=mysql_fetch_object($periodos_q)){
			?>
            	<option value="<?=$periodo->id?>"><?=$periodo->nome?></option>
            <? } ?>
            </select>
        </label>
        <div style="clear:both"></div>
        <span id="qtd_matriculas"></span>
    </fieldset>
	  
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="action" type="submit" id="gerar_boleto" disabled value="Gerar Boletos" style="float:right"/>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>