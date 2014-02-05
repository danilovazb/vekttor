<?
//Includes
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Tipo de Atividades</span></div>
    </div>
    <?php
    
		$imobiliaria = mysql_fetch_object(mysql_query(" SELECT * FROM usuario  WHERE id = ".$registro->usuario_id));
		$corretor    = mysql_fetch_object(mysql_query(" SELECT * FROM corretor WHERE imobiliaria_id = ".$registro->usuario_id." AND id = ".$registro->corretor_id));
	
	?>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" id="form_imo">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
        <label style="width:311px;">Imobili&aacute;ria
		  <input type="text" id='nome' name="nome" value="<?=$imobiliaria->nome?>" autocomplete='off' maxlength="44"/>
		</label>
        <label style="width:311px;">Corretor
		  
          <div>
          <input type="text" id='nome' name="nome" value="<?=$corretor->nome?>" autocomplete='off' maxlength="44"/>
          <button type="button" id="al_corretor">Alterar</button>
          </div>
		</label>
	
	<input name="id" type="hidden" value="<?=$registro->id?>" />
    	
      				
                    <div id="container_select" style="display:none">
                    
                    <div style="display:block;" id="container_imobiliario">
                    <div style="margin-top:30px;">&nbsp;</div>
       				<label> Imobili&aacute;ria
                    	<select name="imobiliario_id" id="imobiliario_id">
                        	<option> Selecione </option>
                        		 <?php 
	   							$sql = mysql_query(" SELECT * FROM usuario WHERE usuario_tipo_id = 12");
										while($usuario=mysql_fetch_object($sql)){	   
	   							?>
                                <option value="<?php echo $usuario->id;?>"><?php echo $usuario->nome;?></option>
                                  <?php
										}
	   							  ?>
                        </select>
                    </label>
                    </div>
                   <div style="clear:both;"></div>
                    <div>
                    <label id="label_corretor">
                    
                        
                    </label>
                    </div>
                    
                    <div id="container_corretor" style="margin-left:3px;">
                   
       				
                    </div>
                    
                    </div>
     
	</fieldset>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($registro->id > 0){
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