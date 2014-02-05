<?
session_start();
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
			
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<a href="?" class='s1'>
  	Sistema NV
</a>
<a href="?" class='s2'>
  	Corretor
</a>
<a href="?tela_id=96" class='navegacao_ativo'>
<span></span>    Corretor
</a>
</div>

<div id="barra_info">
  <a href="modulos/escolar/area_professor/aula/arquivo/form_arquivo.php?aula=<?=$_GET['aula']?>" target="carregador" class="mais"></a>
</div>
<script>
/*$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
	
		window.open('modulos/corretor/corretor/form.php?id='+id,'carregador');
	});
});*/
</script>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="200">Aquivo</td>
          <td width="200">Observa&ccedil;&atilde;o</td>
          <td width="85">Data Envio</td>
          <td width="100">Op&ccedil;&otilde;es</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
        <?
        		$sql_arquivo = mysql_query("");
		?> 
    	<tr>
          <td width="200">Arquivo</td>
          <td width="200">Observaçao</td>
          <td width="85">12/12/2012</td>
          <td width="100"><a href="">Download</a> | <a href="#">Excluir</a></td>
          <td></td>
        </tr>
         	
    </tbody>
</table>
<script>


</script>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        <td width="20"></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td width="50">&nbsp;</td>
          <td width="580">&nbsp;</td>
          <td width="80">&nbsp;</td>
          <td ></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
	
</div>
