<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
include("../../../modulos/financeiro/_functions_financeiro.php");
// funções do modulo formas de pagamento
include("_functions.php");
include("_ctrl.php"); 
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:450px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Forma de Pagamento</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<a onclick="aba_form(this,0)"><strong>Informações</strong></a>
		</legend>
		<label style="width:150px;">
			Nome
			<input type="text" id='nome' name="nome" value="<?=$forma_pagamento->nome?>" autocomplete='off' maxlength="44"/>
		</label>
        <label style="width:150px;">
			Prazo de efetivação (dias)
			<input type="text" id='prazo_efetivacao' sonumero="1" name="prazo_efetivacao" value="<?=$forma_pagamento->prazo_efetivacao?>" autocomplete='off' maxlength="3"/>
		</label>
      <div style="clear:both"></div>
      
        <label style="width:150px;">
			Percentual de desconto (%)
			<input type="text" id='valor_percentual' decimal="2" name="valor_percentual" value="<?=moedaUsaToBr($forma_pagamento->valor_percentual)?>" autocomplete='off' />
		</label>
        <label style="width:150px;">
			Desconto fixo (R$)
			<input type="text" id='valor_fixo' decimal="2" name="valor_fixo" value="<?=moedaUsaToBr($forma_pagamento->valor_fixo)?>" autocomplete='off' />
		</label>
        <label style="width:150px;">
			Plano de conta
			<select id='plano_conta_id' name="plano_conta_id" value="<?=$forma_pagamento->plano_conta_id?>">
            <option value="0">Nenhum</option>
            <?
				exibe_option_sub_plano_ou_centro('plano',0,$forma_pagamento->plano_conta_id,0);
			?>
            </select>
		</label>
        <label style="width:150px;">
			Centro de custo
			<select type="text" id='centro_custo_id' name="centro_custo_id" value="<?=$forma_pagamento->centro_custo_id?>" >
            <option value="0">Nenhum</option>
            	<?
				exibe_option_sub_plano_ou_centro('centro',0,$forma_pagamento->centro_custo_id,0);
				?>
            </select>
		</label>
        <label style="width:150px;">
			Observação
            <textarea id='obs' name="obs">
            <?=nl2br($forma_pagamento->obs)?>
            </textarea>
		</label>
         <label style="width:150px;">
			Forma de pagamento
			<select id='forma_pagamento_id' name="forma_pagamento_id" value="<?=$forma_pagamento->forma_pagamento_id?>">
            <option value="0">Nenhum</option>
            <?
            $formas_pagamento=mysql_query("SELECT * FROM financeiro_formas_pagamento WHERE vkt_id='$vkt_id' ORDER BY nome ASC");
			while($f=mysql_fetch_object($formas_pagamento)){
				if($f->id==$forma_pagamento->forma_pagamento_id){$sel="selected='selected'";}else{$sel='';}
			?>
            	<option <?=$sel?> value="<?=$f->id?>"><?=$f->nome?></option>
            <? } ?>
                
            </select>
		</label>
	</fieldset>
	<input name="id" type="hidden" value="<?=$forma_pagamento->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($forma_pagamento->id>0){
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