<?
//Includes
// configura��o inicial do sistema
include("../../../_config.php");
// fun��es base do sistema
include("../../../_functions_base.php");
// fun��es do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:420px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Licen�a de Funcion�rio</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			
			<a onclick="aba_form(this,0)"><strong>Informa&ccedil;&otilde;es</strong></a>
            
		</legend>
		
        
      
       <label style="width:300px">
            Funcion�rio:
            <select name="funcionario_id" id="funcionario_id">
            	<option value="">Selecione um Funcion�rio</option>
				<?php
                	$funcionarios_empresas = mysql_query($t="SELECT * FROM rh_funcionario WHERE empresa_id='".$_GET['empresa_id']."'");
					echo $t;
					while($funcionario_empresa = mysql_fetch_object($funcionarios_empresas)){
						if($funcionario_empresa->id==$funcionario->id){
							$selected="selected='selected'";
						}
						echo "<option value='$funcionario_empresa->id' $selected>$funcionario_empresa->nome</option>";
						$selected='';
					}
            	?>
			</select>
           
        </label>
        
        <div style="clear:both"></div>
        
        <label style="width:300px">
            Licen�a
        <?php
			$q= mysql_query($t="
		SELECT * FROM 
			rh_licencas
		WHERE vkt_id='$vkt_id' ORDER BY codigo");
		?>
            <select name="licenca_id" id="licenca_id">
            	<option value="">Selecione uma Licen�a</option>
                <?php
					while($r=mysql_fetch_object($q)){
						if($licenca_funcionario->licenca_id==$r->id){
							$selected="selected='selected'";
						}
						echo "<option value='$r->id' $selected>$r->codigo $r->nome</option>";
						$selected='';
					}
				?>
            </select>
           	           
        </label>
        
        <div style="clear:both"></div>
        
        <label style="width:80px;">
            In�cio
           <input type="text" name="data_inicio" id="data_inicio" value="<?=DataUsaToBr($licenca_funcionario->data_inicio)?>" calendario="1" sonumero="1"/>           
        </label>
        
        <label style="width:80px;">
            Fim
           <input type="text" name="data_fim" id="data_fim" calendario="1" sonumero="1" value="<?=DataUsaToBr($licenca_funcionario->data_fim)?>"/>           
        </label>
        
        
        <div style="clear:both"></div>
        
                
                                
	</fieldset>
    
	<input name="id" type="hidden" value="<?=$licenca_funcionario->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($licenca_funcionario->id > 0){
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