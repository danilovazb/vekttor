<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");

include("_functions.php");
include("_ctrl.php");
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>SEFIP</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" id="form_sefip" method="post" autocomplete='off'>
    <input type="hidden" name="empresa_id" id="empresa_id" value="<?=$_GET[empresa_id]?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<a onclick="aba_form(this,0)"><strong>Informa&ccedil;&otilde;es</strong></a>
          
		</legend>
       
       <label style="width:270px;">
       	Empresa
        <input type="text" name="empresa" id="empresa" disabled="disabled" value="<?=$_GET[empresa]?>" busca='modulos/rh/sefip/busca_empresa.php,@r2 @r0,@r1-value>empresa_id,0'>
       </label> 
       <div style="clear:both"></div>
       <label style="width:120px;">
         Mês/Ano Compet&ecirc;ncia<br/>       
       	 <input type="text" name="competencia" id="competencia" value="<?=$_GET[competencia]?>" style="width:55px;" mascara="__/____">
       </label>
           
        <div style="clear:both"></div>
       	<label style="width:120px;">
            Tipo de Remessa
            <select name="tipo_remessa" id="tipo_remessa">
            	<option value="1">GFIP</option>
                <option value="2">DERF</option>
            </select>           	           
        </label>
        <div style="clear:both"></div>
        <label style="width:105px;">
        Salário Maternidade
        	<input type="text" name="salario_maternidade" id="salario_maternidade" sonumero="1" decimal="2 ">
            	
        </label>
        <div style="clear:both"></div>
        <label>
        Modalidade do Arquivo
        	<select name="modalidade_arquivo" id="modalidade_arquivo">
            	<option value=""> Branco - Recolhimento ao FGTS e Declaração à Previdência</option>
                <option value="1"> 1 - Declaração ao FGTS e à Previdência</option>
                <option value="9"> 9 - Confirmação Informações anteriores</option>
            </select>
        </label>
        
        <div style="clear:both"></div>
         <label>
         	Indicador de Recolhimento da Previdência Social
            <select name="indicador_recolhimento_ps" id="indicador_recolhimento_ps">
            	<option value="1">No Prazo</option>
                <option value="2">Em atraso</option>
				<option value="3">Não gera GPS</option>
            </select>
         </label>
                
	</fieldset>
	
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="gera_sefip" id="gera_sefip" type="button"  value="Gerar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>