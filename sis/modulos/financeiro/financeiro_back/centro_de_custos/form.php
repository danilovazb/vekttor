<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("../_functions_financeiro.php");
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
    
    <span>Centro de Custo</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informações</strong>
		</legend>
		<label style="width:50px;">
			ordem
			  <br />
		    <input type="text" id='ordem' name="ordem" value="<?=$obj->ordem?>" autocomplete='off' maxlength="44"/>
		</label>
        <label style="width:240px;">
			Centro de Custo
			
		      <input type="text" id='nome' name="nome" value="<?=$obj->nome?>" autocomplete='off' maxlength="44"/>
		</label>
        
        
        <label style="width:311px;">
			É um Sub-Centro 
			  <br />
			  <select name="centro_custo_id">
              <option value="0">Não</option>
              	<?
				 exibe_option_sub_plano_ou_centro2('centro',0,$obj->centro_custo_id,0);
				?>
              </select>
		</label>
		<label style="width:311px;">
		  Descricao
		    <textarea name="descricao"><?=$obj->descricao?></textarea>
		</label>
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