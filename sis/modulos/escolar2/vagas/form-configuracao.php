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
<div style="width:480px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a> <!-- ;location.href='?tela_id=460&escola_id=<?=$_GET['escola_id']?>&ano=<?=$_GET['ano']?> -->
    
    <span>Configuração</span></div>
</div>
	<form onsubmit="return validaForm(this)" class="form_float"   method="post" >

		<input type="hidden" name="turma_id" value="<?=$_GET["turma"]?>">
		

         <fieldset>
          <legend> <a onclick="aba_form(this,0)"><strong>Configuração - Tela</strong></a> </legend>
			 
            
            <?  $arr_periodos = lista_periodo_letivo(); ?>
            <label style="margin-top:3px; width:150px">Selecione Período abertura
                <select> 
                	<option value="0">-Selecione-</option>
                     <?
                       for($i=0;$i <count($arr_periodos);$i++){
					 ?>
                    <option><?=$arr_periodos[$i]["nome"]?></option>
                    <? }?> 
                </select>
            </label>
            
            <label style="margin-top:3px;">Seleciona Unidade abertura
               
            </label>
            
            <div style="clear:both;"></div><br/>  
        </fieldset>
        
        <button type="button" onclick="location.href='?tela_id=474&turma_id=<?=$_GET["turma"]?>'">Organizar Professor</button>
        <input type="submit" style="float:right" name="Cadastra_Turma" value="Atualizar">
        <div style="clear:both"></div>
        
    </form>
</div>
</div>
</div>
<script>top.openForm()</script>