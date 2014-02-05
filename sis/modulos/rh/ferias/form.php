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
<div style="width:700px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>FÉRIAS</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<a onclick="aba_form(this,0)"><strong>Informa&ccedil;&otilde;es</strong></a>
            <a onclick="aba_form(this,1)">Férias Gozadas</a>
		</legend>
        
       <label style="width:300px">
            Funcionário
            <input type="text" id='funcionario' name="funcionario" value="<?=$registro->nome?>" disabled="disabled"/>
           	<input type="hidden" name="funcionario_id" id='funcionario_id' value="<?=$registro->id?>"/>           
        </label>
        
        <label style="width:300px">
            Empresa
            <input type="text" id='empresa' name="empresa" value="<?=$empresa->razao_social?>" disabled="disabled"/>
           	<input type="hidden" name="empresa_id" id='empresa_id' value="<?=$empresa->id?>"/>           
        </label>
        
        <label style="width:20px;">
        	Faltas
		<input type="text" name="faltas" id="faltas" sonumero="1" value="<?=$tirou_ferias->faltas?>"/>
        </label>
        
        <label style="width:80px;">
        	Salário Base
		<input type="text" name="salario_base" id="salario_base"  value="<? if(empty($tirou_ferias->id)){ echo MoedaUsaToBr($ultimo_salario);}else{ echo MoedaUsaToBr($tirou_ferias->salario_base);}?>" decimal="2"/>
        </label>
       
       	<div style="clear:both"></div>
       <?php
	   	if(!$tirou_ferias->id>0){
			$data_admissao = $_GET['data_admissao'];
			$proximo_periodo_ferias = mysql_fetch_object(mysql_query($t="SELECT DATE_ADD('$data_admissao',INTERVAL 1 YEAR) as data_inicio,
																	 DATE_ADD(SUBDATE(DATE_ADD('$data_admissao',INTERVAL 1 MONTH),INTERVAL 1 DAY),INTERVAL 1 YEAR) as data_fim
																	 "));
			
		}else{
			//verifica qual foi a última férias, para obter o período de aquisição
			$ultimo_periodo_ferias = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_ferias WHERE funcionario_id='$registro->id' ORDER BY id DESC LIMIT 1"));
			$proximo_periodo_ferias = mysql_fetch_object(mysql_query($t="SELECT DATE_ADD('$ultimo_periodo_ferias->data_inicio_aquisicao',INTERVAL 1 YEAR) as data_inicio,
																	DATE_ADD('$ultimo_periodo_ferias->data_fim_aquisicao',INTERVAL 1 YEAR) as data_fim"));
												
		}
	   ?>
          <label style="width:120px;">
        	Dt Início Aquisiçao
		<input type="text" name="data_inicio_aquisicao" style="width:80px;" id="data_inicio_aquisicao"  valida_minlength="3" mascara="__/__/____" value="<?=DataUsaToBr($proximo_periodo_ferias->data_inicio)?>" calendario="1"/>
        </label>
        
        <label style="width:120px;">
        	Dt Final Aquisiçao
		<input type="text" name="data_final_aquisicao" style="width:80px;" id="data_final_aquisicao" valida_minlength="3" mascara="__/__/____" sonumero="1" value="<?=DataUsaToBr($proximo_periodo_ferias->data_fim)?>" calendario="1"/>
        </label>
        
        <div style="clear:both"></div>
        
        <label style="width:120px;">
        	Data de Início Férias
		<input type="text" name="data_inicio" style="width:80px;" id="data_inicio"  valida_minlength="3" mascara="__/__/____" value="" calendario="1"/>
        </label>
        
        <label style="width:120px;">
        	Data Final Férias
		<input type="text" name="data_final" style="width:80px;" id="data_final" valida_minlength="3" mascara="__/__/____" sonumero="1" value="" calendario="1"/>
        </label>
        
	</fieldset>
    
    <fieldset  style="display:none">
		<legend>
			<a onclick="aba_form(this,0)">Informa&ccedil;&otilde;es</a>
            <a onclick="aba_form(this,1)"><strong>Férias Gozadas</strong></a>
		</legend>
        
      <table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="110"></td>
           <td width="110">Início Aquisição</td>
           <td width="110">Fim Aquisição</td>
           <td width="110">Data Final</td>
           <td width="110">Data de Início</td>
           
           <td>Imprimir</td>
        </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <?
		while($ferias = mysql_fetch_object($ferias_tiradas)){
	?>
    	<tr id_ferias="<?=$ferias->id?>">
        <td width="110"><a href="modulos/rh/ferias/form.php?deleta_ferias=<?=$ferias->id?>&id=<?=$_GET[id]?>&data_admissao=<?=$_GET[data_admissao]?>" target="carregador">X</a></td>
        <td width="110"><?=DataUsaToBr($ferias->data_inicio_aquisicao)?></td>
           <td width="110"><?=DataUsaToBr($ferias->data_fim_aquisicao)?></td>
    	<td width="110"><?=DataUsaToBr($ferias->data_inicio)?></td>
            <td width="110"><?=DataUsaToBr($ferias->data_fim)?></td>
              <td align="center">
              	<button id="imprimir_recibo"  onClick="return false"/>
               		<img src="../fontes/img/imprimir.png" />
                </button>
               </td>
		</tr>
	<?
		}
	?>
      </tbody>
</table>	  
        
	</fieldset>
	<input name="id" type="hidden" value="<?=$tirou_ferias->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($tirou_ferias->id > 0){
?>
<!--<input name="action" type="submit" value="Excluir" style="float:left" />-->
<?
}
?>
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>