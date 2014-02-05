<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div id='aSerCarregado'>
<div style="width:400px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Usuário</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post"  autocomplete='off' enctype="multipart/form-data">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1'/>
			<legend>
				<a onclick="aba_form(this,0)"><strong>Cliente</strong></a>
			
			</legend>

			<label style="width:294px; margin-right:23px;">
				Nome
				<input type="text" id='cliente_nome' onkeyup="document.getElementById('cliente_nome_fantasia').value=this.value" name="cliente_nome" value="<?=$usuario->nome?>" disabled="disabled"/>
			</label>
            <div style="clear:both"></div>
			<label style="width:140px;">
				Login
				<input type="text" id='login' name="login" value="<?=$usuario->login?>" disabled="disabled"/>
			</label>
			<label style="width:140px; margin-right:22px;">
				Senha
				<input type="password" id='senha' name="senha" value="<?=$usuario->senha?>" retorno='focus|Coloque a Senha corretamente!' />
			</label>
            
            <label style="width:140px; margin-right:22px;">
				Tela Inicial
                <select name="tela_inicial_id" id="tela_inicial_id">
				
				<?php
					//seleciona os módulos do usuário
					$modulos = mysql_query($t="
					SELECT 
						sm.id, sm.nome, utm.modulo_id, sm.modulo_id as modulo_pai	 
					FROM 
						usuario_tipo_modulo utm,
						sis_modulos sm
					WHERE
						utm.modulo_id=sm.id AND
						utm.usuario_tipo_id='$cliente_tipo_id'
					ORDER BY 
						sm.modulo_id,sm.ordem_menu");
					 echo mysql_error();
					 
					 
					while($modulo = mysql_fetch_object($modulos)){
						if($usuario->tela_inicial==$modulo->id){
							$selected="selected='selected'";
						}
						if($modulo->modulo_pai==$modulo_pai_antigo){
							echo "<option value='$modulo->modulo_id' style='margin-left:10px;' $selected>$modulo->nome</option>";	
						}else{
							$nome_modulo_pai = mysql_fetch_object(mysql_query("SELECT * FROM sis_modulos WHERE id='$modulo->modulo_pai'"));
							echo "<option disabled='disabled' >$nome_modulo_pai->nome</option>";
							echo "<option value='$modulo->modulo_id' style='margin-left:10px;' $selected>$modulo->nome</option>";
							$modulo_pai_antigo = $modulo->modulo_pai;
						}
						$selected='';
					}
				?>
                		
				</select>
            </label>
            <div style="clear:both"></div>
            
			Obs.: O campo tela inicia indica em qual terá o sistema abrirá quando você logar. 
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