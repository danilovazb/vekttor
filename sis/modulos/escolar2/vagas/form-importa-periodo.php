<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="exibe_formulario" class="exibe_formulario"  style="top:30px; left:50px;">
<style>
label#responsavel:hover{ cursor:crosshair;}
</style>
<div id='aSerCarregado'>
<div style="width:380px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a> <!-- ;location.href='?tela_id=460&escola_id=<?=$_GET['escola_id']?>&ano=<?=$_GET['ano']?> -->
    
    <span>Importação</span></div>
</div>
	<form onsubmit="return validaForm(this)" class="form_float" id="form_importar_periodo_letivo"  method="post" >

		<input type="hidden" id="id" name="id" value="<?=$horario->id?>" />
		<input type="hidden" name="acao_form_importacao" value="importar_periodo_letivo">
		

         <fieldset>
          <legend>
            <a onclick="aba_form(this,0)"><strong>Importação de período</strong></a>
          </legend>
			          
			<label>Exportar de:
            	<select name="periodo_exportacao_id" id="periodo_exportacao_id">
                 <? 
				  $perido_letivo = mysql_query(" SELECT * FROM escolar2_periodo_letivo WHERE vkt_id = '$vkt_id' ");
				  while($periodo = mysql_fetch_object($perido_letivo)){
				 ?>
                	<option value="<?=$periodo->id?>"><?=$periodo->nome?></option>
                <?  } ?>
                </select>
            </label>
            
            <div style="clear:both"></div>
            
            <label>Importar para:
            	<select name="periodo_importacao_id" id="periodo_importacao_id">
                 <? 
				  $perido_letivo = mysql_query(" SELECT * FROM escolar2_periodo_letivo WHERE vkt_id = '$vkt_id' ");
				  while($periodo_exportar = mysql_fetch_object($perido_letivo)){
				 ?>
                	<option value="<?=$periodo_exportar->id?>" ><?=$periodo_exportar->nome?></option>
                <?  } ?>
                </select>
            </label>
        
        </fieldset>
        <label ><button type="button" id="realizar-importacao" style="float:right"> Importar </button></label>
        <div style="clear:both"></div>
        
    </form>
</div>
</div>
</div>
<script>top.openForm()</script>