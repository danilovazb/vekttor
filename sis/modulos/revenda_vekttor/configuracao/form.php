<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='aSerCarregado'>
<div style="width:710px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Vendedor</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post"  autocomplete='off' enctype="multipart/form-data">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1'/>
			<legend>
				<a onclick="aba_form(this,0)"><strong>Vendedor</strong></a>
                <a onclick="aba_form(this,1)">Usuário</a>
			</legend>

			<label style="width:294px; margin-right:23px;">
				Cliente Fornecedor
				<input type="text" id='cliente_fornecedor' onkeyup="document.getElementById('cliente_nome_fantasia').value=this.value" name="cliente_fornecedor" value="<?=$cliente_vekttor->nome?>" />
			</label>
            <div style="clear:both"></div>
			<label style="width:294px;">
				Cliente Vekttor
				<input type="text" id='cliente_vekttor' name="cliente_vekttor" value="<?=$cliente_vekttor->nome_fantasia?>" />
			</label>
            <div style="clear:both"></div>
            <label style="width:294px; margin-right:23px;">
            	Porcentagem de Servi&ccedil;o
            		<input type="text" name="porcent_servico" id="porcent_servico">
            </label>
            <div style="clear:both"></div>
            <label style="width:294px; margin-right:23px;">
            	Porcentagem de Implanta&ccedil;&atilde;o
                	<input type="text" name="porcent_implantacao" id="porcent_implantacao">
            </label>
		</fieldset>
		<div style="display:block"></div>        
        <fieldset  id='campos_2' style="display:none;" >
			<legend>
				<a onclick="aba_form(this,0)">Vendedor</a>
                <a onclick="aba_form(this,1)"><strong>Usuário</strong></a>
			</legend>
           	<label style="width:294px; margin-right:23px;">
				Nome
			<input type="text" id='nome_usuario' name="nome_usuario" value="<?=$usuario->nome?>"/>
            </label>
            <div style="clear:both"></div>
            <label style="width:135px; margin-right:23px;">
				Login
			<input type="login" id='login_usuario' name="login_usuario" value="<?=$usuario->login?>"/>
            </label>
            <label style="width:135px; margin-right:23px;">
				Senha
			<input type="password" id='senha_usuario' name="senha_usuario" value="<?=$usuario->senha?>"/>
            </label>
             <input type="hidden" name="id_usuario" id="id_usuario" value="<?=$usuario->id?>" />
		</fieldset>
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
<?
	if($cliente_vekttor_id>0){
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
<script>top.openForm()</script>

