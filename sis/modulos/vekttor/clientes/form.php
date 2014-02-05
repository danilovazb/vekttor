<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">

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
				<a onclick="aba_form(this,1)">Tipo de Usuário</a>
                <a onclick="aba_form(this,2)">Usuário</a>
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
            <label style="width:90px; margin-right:23px;">
				Grupo
				<select name="grupo_id" id="grupo_id">
                	<?php
						$grupos = mysql_query("SELECT * FROM clientes_vekttor_grupos WHERE vkt_id='$vkt_id' ORDER BY nome");
						while($grupo=mysql_fetch_object($grupos)){
					?>
                    <option value="<?=$grupo->id?>" <?php if($grupo->id==$cliente_vekttor->grupo_id){ echo "selected='$selected'";}?>><?=$grupo->nome?></option>
                	<?php
						}
					?>
                </select>
			</label>
            <label style="width:90px; margin-right:23px;">
				Situacao
    <select name="status" id="status">
    	
    	<option value='1' <? if($cliente_vekttor->status=='1'){echo "selected='selected'";}?>>Ativo</option>
		<option value='2' <? if($cliente_vekttor->status=='2'){echo "selected='selected'";}?>>Inativo</option>	
    </select>
			</label>
            <label style="width:90px; margin-right:23px;">
				SMS Mensal 
                <input type="text" name='quantidade_sms_mes' value="<?=$cliente_vekttor->quantidade_sms_mes?>">
			</label>
            <div style="clear:both"></div>            
            <input type="hidden" name="cliente_id" id="cliente_id" value="<?= $cliente_vekttor->id?>" />
            <label style="width:200px">Logomarca<input type="file" name="foto" id="foto" value="<?=$cliente_vekttor->img?>" /></label>
             <div style="position:relative; left:15%">
             <img src="<? if($cliente_vekttor->id>0)echo "modulos/vekttor/clientes/img/".$cliente_vekttor->id.".png"?>" width="10%" height="10%"/>
             </div>
		</fieldset>
		<div style="display:block"></div>
        <fieldset  id='campos_2' style="display:none;" >
			<legend>
				<a onclick="aba_form(this,0)">Cliente</a>
				<a onclick="aba_form(this,1)"><strong>Tipo de Usuário</strong></a>
                <a onclick="aba_form(this,2)">Usuário</a>
			</legend>
            <label style="width:294px; margin-right:23px;">
				Nome
				<input type="text" id='nome_tipo_usuario' name="nome_tipo_usuario" value="<?=$tipo_usuario->nome?>"/>
                <input type="hidden" name="id_tipo" value="<?=$tipo_usuario->id?>" />
       		</label>
            <div style="clear:both"></div>
         <div style="float:left; width:200px;clear:none; background:#F2F2F2; border-radius:5px; margin-right:10px; padding:10px 0 10px 10px;" class='formcheck'>
           <?
		   
            $qasdas= mysql_query($trace="SELECT * FROM sis_modulos WHERE modulo_id ='0' order by ordem_menu ");
            	while($modulo=mysql_fetch_object($qasdas)){
					
			?>
			<a href="#" class='exibe_modulos' r='<?=$modulo->id?>'  style="text-decoration:none;color:black; display:block;"><?=$modulo->nome?></a>
           	<?
				}
			?>
            </div>
            <div class="divisao_options" style="float:left; width:380px;padding:10px; clear:none; height:380px; overflow:auto; background:#F2F2F2; border-radius:5px">
  			<?

// funcao submenu

		   	function submenusform($pai,$tipo_usuario,$nivel,$parentes=NULL){
				  $nivel++;
                $q1= mysql_query("SELECT * FROM sis_modulos WHERE modulo_id ='$pai'");
				$parentes = $parentes." sub$pai";
                while($r1=mysql_fetch_object($q1)){
					
					$seTem = @mysql_result(mysql_query($t="SELECT modulo_id FROM usuario_tipo_modulo WHERE modulo_id ='$r1->id' AND usuario_tipo_id='$tipo_usuario->id'"),0,0);
	                $rs= mysql_fetch_object(mysql_query("SELECT * FROM sis_modulos WHERE modulo_id ='$r1->id' limit 1"));
					if($rs->id>0){$nome ="<strong>$r1->nome</strong>";}else{$nome ="$r1->nome";}
					if($seTem>0){$check = 'checked="checked"';}else{$check ='';}
                ?>
					<label style="width:290px; margin-left:<?=(($nivel-1)*20)?>px">
						<input type="checkbox"  value="<?=$r1->id?>" class="modulo_id <?=$parentes?>" name="modulo_id[]" <?=$check?>>
						<?=$nome?>
					</label>
                    
                <?
					submenusform($r1->id,$tipo_usuario,$nivel,$parentes);
				}
				}


			
			// chamdada submenu
            $qasdas= mysql_query($trace="SELECT * FROM sis_modulos WHERE modulo_id ='0' order by ordem_menu ");
            	while($modulo=mysql_fetch_object($qasdas)){
					
			?>
            <div id="div<?=$modulo->id?>" class='submodulos' style="display:none;float:left; ">
                <div style="clear:both"></div>
                    <label style="width:159px">
						<input type="checkbox"  id="marcarTodos">Marcar Todos
						
					</label>
             	<? submenusform($modulo->id,$tipo_usuario,0); ?>
             </div>
         	<? } ?>            
            </div>
        </fieldset>
        
        <fieldset  id='campos_3' style="display:none;" >
			<legend>
				<a onclick="aba_form(this,0)">Cliente</a>
				<a onclick="aba_form(this,1)">Tipo de Usuário</a>
                <a onclick="aba_form(this,2)"><strong>Usuário</strong></a>
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
			<input type="text" id='senha_usuario' name="senha_usuario" value="<?=$usuario->senha?>"/>
            </label>
             
		</fieldset>
        <input type="hidden" name="id_usuario" id="id_usuario" value="<?=$usuario->id?>" />
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
<?
	if($cliente_vekttor_id>0&&$usuario->status=='1'){
	?>
	<input name="action" type="submit" value="Inativar" style="float:left" />
	<?
	}
	if($cliente_vekttor_id>0&&$usuario->status=='2'){
	?>
		<input name="action" type="submit" value="Ativar" style="float:left" />
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

