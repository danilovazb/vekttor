<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");


?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Usuários</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
		  <strong>Informações</strong></legend>
		<label style="width:311px;">
			Nome Completo
			<input type="text" id='nome' name="nome" value="<?=$usuario->nome?>" autocomplete='off' maxlength="44"/>
		</label><br />
		<label style="width:151px">
			Tipo de Usuário
            <select name="usuario_tipo">
				<?
				$q=mysql_query("SELECT * FROM usuario_tipo WHERE vkt_id='$vkt_id'");
				while($r=mysql_fetch_object($q)){
				?>
            	<option <? if($r->id==$usuario->usuario_tipo_id)echo 'selected="selected"'; ?>  value="<?=$r->id?>"><?=$r->nome?></option>
				<?
				}
				?>
            </select>
        </label>
		<label style="width:151px; display:none;">
			Obra
            <select name="obra">
            	<option value="0">Nenhuma</option>
				<?
				$q=mysql_query("SELECT * FROM empreendimento");
				while($r=mysql_fetch_object($q)){
				?>
            	<option <? if($r->id==$usuario->obra_id)echo 'selected="selected"'; ?>  value="<?=$r->id?>"><?=$r->nome?></option>
				<?
				}
				?>
            </select>
        </label><br />
		<label style="width:144px; margin-right:23px;">
			Login
			<input type="text" name="login" id="login" value="<?=$usuario->login?>" maxlength="23"  />
		</label>
		<label style="width:144px">
			Senha
			<input name="senha" id='senha' type="password" value="<?=$usuario->senha?>" maxlength="23" />
		</label>
		<input name="usuario_id" type="hidden" value="<?=$usuario_id?>" />
	</fieldset>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($usuario->id>0){
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