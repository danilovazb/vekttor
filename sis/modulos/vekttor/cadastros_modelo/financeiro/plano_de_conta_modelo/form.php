<?
//Includes
// configuração inicial do sistema
include("../../../../../_config.php");
// funções base do sistema
include("../../../../../_functions_base.php");
// funções do modulo empreendimento
include("../../../../../modulos/financeiro/_functions_financeiro.php");
include("_functions.php");
include("_ctrl.php"); 
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Plano de Conta</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informações</strong>
		</legend>
		<label style="width:90px;">
			Ordem
			  <br />
		   <span id='plano_ordem'></span> <input type="text" id='ordem' name="ordem" value="<?=$obj->ordem?>" autocomplete='off' maxlength="44" style="width:40px" sonumero= '1'/>
		</label>
        <label style="width:200px;">
			Plano de Conta
		      <input type="text" id='nome' name="nome" value="<?=$obj->nome?>" autocomplete='off' maxlength="44"/>
		</label>
        <input type="hidden" name="modelo_grupo_id" value="<?=$modelo_grupo->id?>" />
        <label>
        <strong style="color:black">Modelo: <?=$modelo_grupo->nome?></strong>
        </label>
        <label style="width:311px;">
			É um Sub-Plano 
			  <br />
			  <select name="centro_custo_id" class="plano_id" id="centro_custo_id">
              <option value="0" ordenacao='' >Não</option>
              	<?
				
				 exibe_option_sub_plano_ou_centro_modelo('plano',0,$obj->centro_custo_id,0,''," AND modelo_grupo_id='$modelo_grupo->id' ");
				?>
              </select>
		</label>
		<label style="width:311px;">
		  Descricao
		    <textarea name="descricao"><?=$obj->descricao?></textarea>
		</label>
        <div style="clear:both"></div>
        
		  
		    <input type="checkbox" name="visualiza_soma" value="sim" id="visualiza_soma" <? if($obj->exibir_soma=='sim'){echo "checked='checked'";} ?>>Exibir na soma
		
	</fieldset>
	<input name="id" type="hidden" value="<?=$obj->id?>" />
	
	<input name="plano_ou_centro" type="hidden" value="<?=$plano_ou_centro?>" />
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($obj->id>0){
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