<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div>
<div id='aSerCarregado'>
<div style="width:400px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>SMS</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" id="form_odonto_sms" method="post" enctype="multipart/form-data" autocomplete="off">
    <input name="id" id="id" type="hidden" value="<?=$email->id?>" />
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
		<legend>
            <a onclick="aba_form(this,0)"> <strong>Enviar SMS</strong> </a>
    		<a onclick="aba_form(this,1)"> Enviar &Uacute;nico   </a>
          </legend>
          <label style="width:300px;">
        	Mes de Aniversario
            <select name="mes" id="mes">
				<option value=""></option>
                <option value="01" <?php if($mes_aniversario[1]=='01'){echo "selected='selected'";}?>>JANEIRO</option>
                <option value="02" <?php if($mes_aniversario[1]=='02'){echo "selected='selected'";}?>>FEVEREIRO</option>
                <option value="03" <?php if($mes_aniversario[1]=='03'){echo "selected='selected'";}?>>MARÇO</option>
                <option value="04" <?php if($mes_aniversario[1]=='04'){echo "selected='selected'";}?>>ABRIL</option>
                <option value="05" <?php if($mes_aniversario[1]=='05'){echo "selected='selected'";}?>>MAIO</option>
                <option value="06" <?php if($mes_aniversario[1]=='06'){echo "selected='selected'";}?>>JUNHO</option>
                <option value="07" <?php if($mes_aniversario[1]=='07'){echo "selected='selected'";}?>>JULHO</option>
                <option value="08" <?php if($mes_aniversario[1]=='08'){echo "selected='selected'";}?>>AGOSTO</option>
                <option value="09" <?php if($mes_aniversario[1]=='09'){echo "selected='selected'";}?>>SETEMBRO</option>
                <option value="10" <?php if($mes_aniversario[1]=='10'){echo "selected='selected'";}?>>OUTUBRO</option>
                <option value="11" <?php if($mes_aniversario[1]=='11'){echo "selected='selected'";}?>>NOVEMBRO</option>
                <option value="12" <?php if($mes_aniversario[1]=='12'){echo "selected='selected'";}?>>DEZEMBRO</option>
            </select>
	</label >
    <div style="clear:both"></div>
    <label style="width:300px;">
        	Bairro
            <select name="bairro" id="bairro">
            <option value=""></option>
			<?php
				$bairros = mysql_query($t="SELECT DISTINCT(bairro) FROM cliente_fornecedor WHERE cliente_vekttor_id='$vkt_id' ORDER BY bairro");
				//echo $t;
				while($b=mysql_fetch_object($bairros)){
					if($clientes->bairro==$b->bairro){
						$selected = "selected='selected'";
					}
					echo "<option value='$b->bairro' $selected>$b->bairro</option>";
					$selected='';
				}
			?>	                
            </select>
	</label >
    <div style="clear:both"></div>
    <label style="width:300px;">
        	Grupo
            <select name="grupo_id" id="grupo_id">
            <option value=""></option>
			<?php 
				$grupos = mysql_query("SELECT * FROM cliente_fornecedor_grupo WHERE vkt_id = '$vkt_id'");
				while($g=mysql_fetch_object($grupos)){
					if($clientes->grupo_id==$g->id){
						$selected = "selected='selected'";
					}
					echo "<option value='$g->id' $selected>$g->nome</option>";
					$selected='';
				}
			?>
            </select>
		</label >
        <div style="clear:both"></div>
        <label>Mensagem 
  		<textarea name="mensagem" id="mensagem" cols="25" rows="5"><?=$sms_edit->msg?></textarea>
        </label>
</fieldset>

<fieldset id="campos_2" style="display:none">
		 <legend>
            <a onclick="aba_form(this,0)"> Enviar SMS </a>
    		<a onclick="aba_form(this,1)"> <strong>Enviar &Uacute;nico</strong>   </a>
          </legend>
          <input type="hidden" name="cliente_id" id="cliente_id">
        <label style="width:285px;">Cliente
        	<input type="text" name="cliente" id="cliente" busca="modulos/odonto/buscas/busca_clientes.php,@r0,@r0-value>cliente|@r1-value>cliente_id|@r11-value>celular_unico,0" autocomplete="off">
        </label>
    	<div style="clear:both"></div>
        <label style="width:120px;">Celular
        	<input type="text" name="celular_unico" id="celular_unico" style="background:#F2F2F2; color:#999;" readonly >
        </label>
        <div style="clear:both"></div>
        <label>Mensagem 
  		<textarea name="msg_unica" id="msg_unica" cols="25" rows="5"><?=$sms_edit->msg?></textarea>
        </label>
</fieldset>
<div style="display:none;" id="result_loading"><span><strong>Carregando...</strong></span></div>
<div id="result" style=" float:left;"></div>     	
<!--Fim dos fiels set-->
<div style="width:100%; text-align:center; height:20px;" id="btn_info" >
<input name="action" type="button" id='botao_salvar' value="Enviar" style="float:right"  />
</div>
<div style="clear:both"></div>
</form>
</div>
</div>
</div>
<script>
top.openForm();

</script>