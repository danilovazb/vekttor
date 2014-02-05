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
  <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="" class='s2'>
  	Imobiliária
</a>
<a href="" class='navegacao_ativo'>
<span></span>    Corretor
</a>
</div>

<div id="barra_info">
  <a href="modulos/corretor/corretor/form.php" target="carregador" class="mais"></a>
</div>
<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
	
		window.open('modulos/corretor/corretor/form.php?id='+id,'carregador');
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
          <td width="580"><?=linkOrdem("Corretor","nome",1)?></td>
          <td width="140"><div>Imobili&aacute;ria</div></td>
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
		$sql = mysql_query($t="SELECT
								c.id,  
								c.nome as vendedor,
								u.nome as imobiliaria
							FROM corretor as c, usuario as u 
							$filtro_corretores AND vkt_id='$vkt_id'
							AND u.id = c.imobiliaria_id
						");
						
		echo mysql_error();	
				while($r=mysql_fetch_object($sql)){
		
	?>      
    	<tr <?=$sel?> id="<?=$r->id?>" >
          <td width="580"><?=$r->vendedor;?></td>
          <td width="140"><?=$r->imobiliaria?></td>
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