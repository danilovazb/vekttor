<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
?>
<script></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div>
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
   
    <span>Importa&ccedil;&atilde;o</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Dados da Importa&ccedil;&atilde;o</strong>
		</legend>
        <div style="clear:both;"><br />
          <br />
        Data Inicio : <?=DataUsaToBr($_GET['filtro_inicio'])?><br>
        <br>
        Data Fim: <?=DataUsaToBr($_GET['filtro_fim'])?><br>
        <br>
        Contrato de onde ser&aacute; importado<br>
        
        <select name="outro_contrato_id" >
<? 
$contratos_q=mysql_query($x="SELECT c.id as id, cf.razao_social as cliente, c.* FROM cozinha_contratos as c, cliente_fornecedor as cf WHERE c.vkt_id='$vkt_id' AND c.cliente_id=cf.id AND c.id!='$contrato_id' " );
while($contrato=mysql_fetch_object($contratos_q)){
 ?>
          <option value="<?=$contrato->id?>" ><?=$contrato->id?> - <?=$contrato->cliente?></option>
    <? } ?>
    </select>
<br />
        </div>
	<input type="hidden" name="filtro_inicio" id="filtro_inicio" value="<?=DataUsaToBr($_GET['filtro_inicio'])?>" />
    <input type="hidden" name="filtro_fim" id="filtro_fim" value="<?=DataUsaToBr($_GET['filtro_fim'])?>" />
	</fieldset>
	<input type="hidden" name="contrato_id" value="<?=$_GET[contrato_id]?>" />
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input type="submit"  value="Importar" style="float:right" id="importar"  name="action"/>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>

<script>top.openForm()</script>