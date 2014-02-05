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
$("#unidade").live('change',function(){
	unidade = $(this).val();	
	
	if(unidade=="Metro_q"){
		$("#l_altura").css("display","block");
		$("#l_largura").css("display","block");
		$("<div style='clear:both;' id='a_l'></div>").insertAfter("#l_largura");
		$("#altura").attr("valida_minlength","1").attr("retorno","focus|Digite a altura");
		$("#largura").attr("valida_minlength","1").attr("retorno","focus|Digite a largura");
	}else{
		$("#altura").attr("valida_minlength","").attr("retorno","");
		$("#largura").attr("valida_minlength","").attr("retorno","");
		$("#l_altura").css("display","none");
		$("#l_largura").css("display","none");
		$("#a_l").remove();
	}
	
});
$("#clickbusca").live("click",function(e) {
	busca=$("#busca").val();
	location.href="?tela_id=<?=$_GET['tela_id']?>&busca="+busca;
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id='some'>«</div>
<a href="?" class='s1'>
  Sistema
</a>
<a href="?tela_id=277" class='s2'>
  	OS
</a>
<a href="?tela_id=<?=$_GET[tela_id]?>" class='navegacao_ativo'>
<span></span>    Atendimento
</a>
<form class='form_busca' action="" method="get">
   	  <a id="clickbusca"></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" id="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>

<div id="barra_info">
  <a href="modulos/ordem_servico/atendimento/form.php" target="carregador" class="mais"></a>
</div>
<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
	
		window.open('modulos/ordem_servico/atendimento/form.php?id='+id,'carregador');
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
          <td width="300">Nome</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
		$fim='';
		if(!empty($_GET['busca'])){
			$fim.=" AND descricao LIKE '%".$_GET['busca']."%'";	
		}
		$registros= @mysql_result(mysql_query("SELECT count(*) FROM os_atendimento WHERE vkt_id = '$vkt_id' $fim"),0,0);
		
		$sql = @mysql_query($t="SELECT
								*
							FROM os_atendimento WHERE vkt_id='$vkt_id' $fim ORDER BY id DESC
							
						LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));;
									
		//echo mysql_error();	
				while($r=@mysql_fetch_object($sql)){
		
	?>      
    	<tr <?=$sel?> id="<?=$r->id?>" >
          <td width="60"><?=$r->id?></td>
          <td width="300"><?=substr($r->descricao,0,100);?></td>
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
	<?=$registros?> Registros 
    <?
	if($_GET[limitador]<1){
		$limitador= 30;	
	}else{
		$limitador= $_GET[limitador];
	}
    $qtd_selecionado[$limitador]= 'selected="selected"'; 
	?>
    <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>