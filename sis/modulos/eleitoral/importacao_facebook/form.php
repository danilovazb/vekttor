<?
//Includes
// configuraçao inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 
print_r($_POST);
print_r($_GET);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript"></script>


<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    <span>Politicos</span></div>
    </div>
<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off" enctype="multipart/form-data">
<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
<fieldset id='campos_1' >
<legend>
 		<a onclick="aba_form(this,0)"><strong>Importaçao Facebook</strong></a>
	
</legend>
  <label style="width:400px;">
    Selecione um arquivo
    <input type="file" id='arquivo' name="arquivo"/>
  </label>
  <div style="clear:both"></div>
  <label style="width:200px;">
    Selecione um grupo social
    <select id='grupo_social' name="grupo_social"/>
    	<?php
			$grupos_sociais = mysql_query("SELECT * FROM eleitoral_grupos_sociais WHERE vkt_id='$vkt_id'");
			while($grupo_social = mysql_fetch_object($grupos_sociais)){
        ?>
        	<option value="<?=$grupo_social->id?>"><?=$grupo_social->nome?></option>
        <?php
			}
		?>
    </select>
  </label>
  <div style="clear:both"></div>
 <!-- <div style="width:400px;">
  	<strong>Obs.:</strong> O arquivo deve está no formato CSV, separado por vírgula e valores com aspas(" ").
  Ex.: "2012.11.22 05:56", "+5592949111", "OIá, tudo bem?"
  </div>-->
</fieldset>
<input name="idvereador" type="hidden" value="<?=$vereador_q->id?>" />

<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" ></div>
<!---------------------------------------------------Dados cadastrais----------------------->
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<?
if($vereador_q->id>0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="action" type="submit" value="Salvar" style="float:right"/>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>