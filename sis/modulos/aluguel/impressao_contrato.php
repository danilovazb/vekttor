<?php
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
?>
<style>
	#pagina{
		border:1px solid #000;
		width:840px;
		background:#FFFFFF;
		margin:0px auto;
		box-shadow:2px 1px 2px #333333;
		white-space: pre-wrap;
		word-wrap:break-word;
		page-break-after:auto;
	}
</style>
<div id='conteudo'>
<script type="text/javascript" src="js/jquery.FCKEditor.js"></script>
<!-- -->
<table cellpadding="0" cellspacing="0" width="100%"  >
<thead>
    	<tr>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->

<script>
</script>
<div id="pagina">
<?php
	$contrato = mysql_fetch_object(mysql_query($t="SELECT * FROM aluguel_locacao WHERE id='".$_GET['id']."'"));
	echo "<pre>$contrato->contrato</pre>"
?>
</p>
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