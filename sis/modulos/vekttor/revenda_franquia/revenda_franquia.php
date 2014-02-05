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
  <a href="modulos/vekttor/revenda_franquia/form.php" target="carregador" class="mais"></a>
</div>
<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
	
		window.open('modulos/vekttor/revenda_franquia/form.php?id='+id,'carregador');
	});
});
</script>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="300">Cliente</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
		if($cliente_tipo_id!='7'){
			$filtro_corretores=" WHERE c.imobiliaria_id='$login_id' ";
		}else{
			$filtro_corretores=' WHERE 1=1 ';
		}
		$sql = mysql_query($t="SELECT *,f.id as idf FROM revenda_franquia f 
								JOIN cliente_fornecedor c ON f.cliente_id = c.id
						");
						
		echo mysql_error();	
				while($r=mysql_fetch_object($sql)){
		
	?>      
    	<tr <?=$sel?> id="<?=$r->idf?>" >
          <td width="300"><?=$r->nome_fantasia;?></td>
          <td></td>
        </tr>
<?php
				}
?>
    	
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
          <td width="50"><?=$q_total->horas?></td>
          <td width="580"><?=$q_total->hora_final?></td>
          <td width="80">&nbsp;</td>
          <td ></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
	
</div>
