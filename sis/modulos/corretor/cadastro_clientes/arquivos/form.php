<?
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");
// funções do modulo interesses
include("_functions.php");
// funções do modulo interesses
include("_ctrl.php"); 

?><link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div id='aSerCarregado'>
<div style="width:600px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Interesses</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' style="display:" >
		<legend>
			<strong>Informações</strong>
		</legend>
		<label style="width:200px;">
			Tipo
			<?
			if(!$r->id>0){
			?>
				<select name="tipo">
					<option value="CPF">CPF</option>
					<option value="RG">RG</option>
					<option value="Comprovante de Residência">Comprovante de Residência</option>
					<option value="Comprovante de Renda">Comprovante de Renda</option>
					<option value="Imposto de Renda">Imposto de Renda</option>
					<option value="Outros Documentos">Outros Documentos</option>
				</select>
			<?
			}else{
				echo "<b>".$r->tipo."</b>";
			}
			?>
		</label>
		<?
		if(!$r->id>0){
		?>
		<label style="width:160px;">
			Arquivo 
			<input type="file" id='arquivo' name="arquivo" />
		</label>
		<?
		}
		?>
		<label style="width:515px;">
			Obs:
			<textarea name="obs" id="obs"><?=$r->obs?></textarea>
		</label>
		<input name="id" type="hidden" value="<?=$r->id?>" />
	</fieldset>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($r->id>0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}else{
?>
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<?
}
?>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
<script>top.openForm()</script>