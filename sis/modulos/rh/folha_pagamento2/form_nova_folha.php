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
    
    <span>Nova Folha de Pagamento 2</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<a onclick="aba_form(this,0)"><strong>Informa&ccedil;&otilde;es</strong></a>
		</legend>
        
       <label style="width:200px">
            Mês
            <select name="mes" id="mes">
                <? 
				foreach($mes_abreviado as $i=>$v){
					if($folha->mes==$i){$sel='selected="selected"';}else{$sel='';}
					?>
                    <option <?=$sel?> value="<?=$i?>"><?=$v?></option>
                    <?					
				}
			
				?>
                <!-- Parcelas Referentes ao décimo terceiro -->
                <option value="12" <? if($folha->mes==12){echo "selected='selected'";}?>>13&ordm; Integral</option>
                <option value="13" <? if($folha->mes==13){echo "selected='selected'";}?>>13&ordm; Percela 1</option>
                <option value="14" <? if($folha->mes==14){echo "selected='selected'";}?>>13&ordm; Percela 2</option>
            </select>
        </label>
        <label style="width:100px">
            Ano
            <input type="text" id='ano' sonumero="1" maxlength="4" name="ano" value="<?=date('Y')?>"/>    
        </label>
       	<div style="clear:both"></div>
	</fieldset>
	<input name="empresa_id" type="hidden" value="<?=$empresa_id?>" />
    <input name="folha_id" type="hidden" value="<?=$folha->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($folha->id > 0){
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