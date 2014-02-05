<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
$opcoes = array('1'=>'block','2'=>'none');
include("_functions.php");
include("_ctrl.php"); 
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:830px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Ordem de Servi&ccedil;o</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float"  method="post" autocomplete='off'>
    <input type="hidden" name="id" id="id" value="<?=$reg_os->id?>">
    
	<!-- AQUI ENVIO DE ORÇAMENTO POR EMAIL -->
	<fieldset>
		 <legend>
            <a onclick="aba_form(this,0)"> Ordem de Servi&ccedil;o </a>
    		<a onclick="aba_form(this,1)"> Custos/Pe&ccedil;as Utilizadas   </a>
    		<a onclick="aba_form(this,2)"> Servi&ccedil;os Executados </a>
    		<a onclick="aba_form(this,3)"> Or&ccedil;amento </a>
            <a onclick="aba_form(this,4)"> <strong>Enviao de Or&ccedil;amento</strong> </a>
          </legend>
          <input type="hidden" name="cliente_id" id="cliente_id" value="<?=$reg_os->cliente_id?>">
          <label style="display:<?=$opcoes[1]?>">Situa&ccedil;&atilde;o Atual <br/>
        	<select name="opcao_1" id="opcao_1">
                <option <? if($reg_os->status_os == '1'){echo 'selected="selected"';}?>value="1">Orçamento</option>
            </select>
          </label>
          
           <label style="display:<?=$opcoes[2]?>;">Op&ccedil;&otilde;es <br/>
        	<select name="opcao_2" id="opcao_2">
            	<option ></option>
            	<!--<option value="6">Editar</option>-->
                <option <? if($reg_os->situacao  == '2'){ echo 'selected="selected"';}?> value="2">
					<? if($reg_os->situacao  == '2'){ echo 'Aprovado';} else{echo 'Aprovar';}?>
                </option>
            	<option <? if($reg_os->situacao  == '3'){ echo 'selected="selected"';}?> value="3">
                	<? if($reg_os->situacao  == '3'){ echo 'Cancelado';} else {echo 'Cancelar';}?>
                </option>
            </select>
          </label>
          <div style="clear:both;"></div>
          <label>
          	<input type="file" name="file" id="file">
          </label>       
	</fieldset>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->       

<!--Fim dos fiels set-->
<div style="width:100%; text-align:center" >
<? 
if($reg_os->id == 0){
?>
<div style="float:left">
<input type="checkbox" name="imprimir_ok" id="imprimir_ok" checked="checked" value="1"> Imprimir ap&oacute;s cadastro
</div>
<? }?>
<?

if($reg_os->id > 0){
?>
<input type="button" value="Enviar Orçamento por E-mail" style="float:left;" id="envia_email">
<!--<input name="action" type="submit" value="Excluir" style="float:left" />-->
<input type="button" value="Imprimir" onclick="window.open('modulos/ordem_servico/ordem_servico/rel_os.php?id=<?=$reg_os->id?>','_BLANK')" />
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