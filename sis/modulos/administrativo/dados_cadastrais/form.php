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
    
    <span>Clientes</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post"  autocomplete='off' enctype="multipart/form-data">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1'/>
			<legend>
				<a onclick="aba_form(this,0)"><strong>Cliente</strong></a>
			
			</legend>

			<label style="width:294px; margin-right:23px;">
				Nome
				<input type="text" id='cliente_nome' onkeyup="document.getElementById('cliente_nome_fantasia').value=this.value" name="cliente_nome" value="<?=$cliente_vekttor->nome?>" />
			</label>
			<label style="width:294px;">
				Nome Fantasia
				<input type="text" id='cliente_nome_fantasia' name="cliente_nome_fantasia" value="<?=$cliente_vekttor->nome_fantasia?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				CNPJ
				<input type="text" id='cliente_cnpj' name="cliente_cnpj" value="<?=$cliente_vekttor->cnpj?>" mascara="__.___.___/____-__" sonumero='1' retorno='focus|Coloque o CNPJ corretamente!' />
			</label>
			<label style="width:136px; margin-right:23px;">
				CEP
				<input type="text" id='cliente_cep' name="cliente_cep" value="<?=$cliente_vekttor->cep?>" busca='modulos/vekttor/clientes/busca_endereco.php,@r0,@r0-value>cliente_cep|@r1-value>cliente_endereco|@r2-value>cliente_bairro|@r3-value>cliente_cidade|@r4-value>cliente_estado,0' autocomplete="off"/>
			</label>
			<label style="width:290px; margin-right:22px;">
				Endereco
				<input type="text" id='cliente_endereco' name="cliente_endereco" value="<?=$cliente_vekttor->endereco?>" />
			</label>
            <label style="width:136px; margin-right:22px;">
				Bairro
				<input type="text" id='cliente_bairro' name="cliente_bairro" value="<?=$cliente_vekttor->bairro?>" />
			</label>
			<label style="width:136px; margin-right:23px;">
				Cidade
				<input type="text" id='cliente_cidade' name="cliente_cidade" value="<?=$cliente_vekttor->cidade?>" />
			</label>
			<label style="width:30px; margin-right:23px;">
				Estado
				<input type="text" id='cliente_estado' name="cliente_estado" value="<?=$cliente_vekttor->estado?>"/>
			</label>
            <label style="width:90px; margin-right:23px;">
				Telefone
				<input type="text" id='cliente_telefone' name="cliente_telefone" mascara="(__)____-____" sonumero="1" value="<?=$cliente_vekttor->telefone?>"/>
			</label>
            <input type="hidden" name="cliente_id" id="cliente_id" value="<?= $cliente_vekttor->id?>" />
            <label style="width:200px">
            	Logomarca<input type="file" name="foto" id="foto" value="<?=$cliente_vekttor->img?>" />
            	<div style="clear:both"></div>Obs.: A extensão deve ser .PNG
            </label>
             <div style="position:relative; left:15%">
             <img src="<? if($cliente_vekttor->id>0)echo "modulos/vekttor/clientes/img/".$cliente_vekttor->id.".png"?>" width="10%" height="10%"/>
             </div>
		</fieldset>
		
        <input type="hidden" name="id_usuario" id="id_usuario" value="<?=$usuario->id?>" />
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >

<input name="action" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
<script>top.openForm()</script>