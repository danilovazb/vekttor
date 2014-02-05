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
<a href="?tela_id=279" class='s2'>
  	OS
</a>
<a href="?tela_id=279" class='navegacao_ativo'>
<span></span>    CARGOS E SAL&Aacute;RIOS
</a>
</div>

<div id="barra_info">
  <a href="modulos/ordem_servico/cargos_salarios/form.php" target="carregador" class="mais"></a>
</div>
<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
	
		window.open('modulos/ordem_servico/cargos_salarios/form.php?id='+id,'carregador');
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
          <td width="60"><?=linkOrdem("Codigo","Codigo",1)?></td>
          <td width="200">Cargo</td>
          <td width="50">Sal&aacute;rio</td>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
		/*if($cliente_tipo_id!='7'){
			$filtro_servicos=" WHERE c.imobiliaria_id='$login_id' ";
		}else{
			$filtro_corretores=' WHERE 1=1 ';
		}*/
		$sql = mysql_query($t="SELECT
								*
							FROM cargo_salario WHERE vkt_id='$vkt_id'
							
						");
						
		echo mysql_error();	
				while($r=mysql_fetch_object($sql)){
		
	?>      
    	<tr <?=$sel?> id="<?=$r->id?>" >
          <td width="60"><?=$r->id?></td>
          <td width="200"><?=$r->cargo;?></td>
          <td width="50"><?=moedaUsaToBr($r->valor_salario);?></td>
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
