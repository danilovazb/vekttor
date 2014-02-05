<?php
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
global $vkt_id;
?>
<style>
	#pagina{
		width:840px;
		background:#FFFFFF;
		margin:0px auto;
	}
</style>
<div id='conteudo'>
<!-- -->
<table cellpadding="0" cellspacing="0" width="100%"  >
<thead>
    	<tr>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >

<script>
</script>
<div id="pagina" style="text-align:justify">
<?php
	$contrato = mysql_fetch_object(mysql_query($t="SELECT 
														* 
													FROM
														odontologo_contrato_modelo
													 WHERE
													 	id='".$_GET['id']."'
														"));
	 													
		
	$texto = $contrato->contrato;

	//foreach ($mods as $key => $value) {
		//$texto = str_replace($key,$value,$texto);
	//}
	
	
?>
<div id="titulo" style="text-align:center;width:100%;font-weight:bold;font-size:20px;"><?=$contrato->nome?></div>
<div style="clear:both"></div>
<?php
	echo $texto;
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
          <td ></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
 </div>