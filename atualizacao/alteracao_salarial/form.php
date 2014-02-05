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
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>ALTERAÇAO DE SALÁRIO</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<a onclick="aba_form(this,0)"><strong>Informa&ccedil;&otilde;es</strong></a>
            <a onclick="aba_form(this,1)">Histórico de Alterações</a>
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
        
        <label style="width:90px;">
        	Salário Atual
		<input type="text" name="vlr_salario_atual" valida_minlength="3" value="<?=moedaUsaToBr($salario_atual)?>" decimal="2" disabled="disabled"/>
        </label>
        
        <label style="width:90px;">
        	Novo Salário
		<input type="text" name="vlr_salario_novo" valida_minlength="3" decimal="2" sonumero="1"/>
        </label>
        
         <label style="width:90px;">
        	Data
		<input type="text" name="data_alteracao" id="data_alteracao" calendario="1" sonumero="1" mascara="__/__/____"/>
        </label>
        
	</fieldset>
    
    <fieldset  id='campos_2' style="display:none">
		<legend>
			<a onclick="aba_form(this,0)">Informa&ccedil;&otilde;es</a>
            <a onclick="aba_form(this,1)"><strong>Histórico de Alterações</strong></a>
		</legend>
        
        <table cellpadding="0" cellspacing="0" width="100%">
    	<thead>
    	<tr>
            <td width="100">Data</td>
          	<td width="98" >De</td>
       	 	<td width="98" >Para</td>       	
			
        </tr>
    </thead>
	</table>
    <table cellpadding="0" cellspacing="0" width="100%">    
       <?php
	   
	   		//consulta alteraçoes salariais
			$alteracoes_salarias = mysql_query($t="SELECT * FROM rh_alteracao_salario WHERE funcionario_id='$registro->id' ORDER BY id");
			//echo $t.mysql_error();
			//consulta salario cadastrado para o funcionário na admissão
			$salario_antigo      = mysql_fetch_object(mysql_query("SELECT * FROM rh_funcionario WHERE id='$registro->id'"));
			$salario_antigo      = MoedaUsaToBr($salario_antigo->salario);
			
			while($alteracao=mysql_fetch_object($alteracoes_salarias)){
		?>
        	<tr>
            <td width="100"><?=DataUsaToBr($alteracao->data)?></td>
          	<td width="98" ><?=$salario_antigo?></td>
       	 	<td width="98" ><?=MoedaUsaToBr($alteracao->salario)?></td>       	
			
        </tr>
        
        <?
				$salario_antigo = MoedaUsaToBr($alteracao->salario);	
				
			}
	   
	   ?>
     </table>   
	</fieldset>
	<!--<input name="id" type="hidden" value="<?=$cargo_salario->id?>" />-->
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($cargo_salario->id > 0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
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