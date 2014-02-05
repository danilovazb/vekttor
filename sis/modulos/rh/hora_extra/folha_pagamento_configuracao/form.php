<?
//Includes
include("../../../../_config.php");
include("../../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

?>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script src="../../../../fontes/js/jquery.min.js"></script>
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div style="width:820px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this);"></a>
    
    <span>Configuração da Folha de ponto</span></div>
    </div>
   
	<form onsubmit="return validaForm(this)" class="form_float" method="post" id="form_cliente" action="">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<input type="hidden" name="empresa_id" value="<?=$empresa->id?>" />
    <input type="hidden" name="id" value="<?=$configuracao->id?>" />
		<fieldset  id='campos_1' <? if($cliente_fornecedor->tipo_cadastro=="Físico")echo 'style="display:none"'; ?> >
			<legend>
				<a class="form2"><strong>Configuração</strong></a>
			</legend>
			<input type="hidden" />
            <label style="width:150px;">
            	Dia de abertura da folha 
                <select name="dia_abertura_folha">
                <? 
				for($i=1;$i<=29;$i++){
					if($configuracao->dia_abertura==$i){$sel="selected='selected'";}else{$sel='';}
					echo "<option $sel value='$i'>$i</option>";
				}
				?>
                </select>
            </label>
            <label style="width:170px;">
            	Início da semana na empresa
            	<select name="dia_fechamento_folha">
                <? 
				for($i=0;$i<=6;$i++){
					if($configuracao->semana_inicio==$i){$sel="selected='selected'";}else{$sel='';}
					echo "<option $sel value='$i'>{$semana_extenso[$i]}</option>";
				}
				?>
                </select>
            </label>
            <div class="divisao_options"><!--  sempre usar um div pra dividir-->
                <span  class="titulo_options">Imprimir recibo de hora extra?</span>
                <? $checado[$configuracao->recibo_hora_extra]="checked='checked'"; ?>
                <label>
                    <input <?=$checado['sim']?> value="sim" name="recibo_hora_extra" type="radio" >
                    Sim
                </label>
                <label>
                    <input <?=$checado['nao']?> value="nao" name="recibo_hora_extra" type="radio" >
                    Não
                </label>
                <div style="clear:both"></div>
            </div>
		</fieldset>      
        
        
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($cliente_fornecedor_id>0){
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
<script>
top.openForm();
</script>