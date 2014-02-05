<?
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});

$("#clickbusca").live("click",function(e) {
	busca=$("#busca").val();
	location.href="?tela_id=<?=$_GET['tela_id']?>&busca="+busca;
});

$("#grupo_id").live("change",function(){
		location.href='?tela_id=<?=$_GET['tela_id']?>&grupo_id='+$(this).val();
	});
	$("#edt_grupo").live("click",function(){
		var grupo_id = $("#grupo_id").val();
		//alert(grupo_id);
		window.open('modulos/odonto/servicos/form_grupo.php?grupo_id='+grupo_id,'carregador');
	});
	$("#filtrar").live("click",function(){
		var grupo_id = $("#grupo_id").val();
		location.href='?tela_id=<?=$_GET['tela_id']?>&grupo_id='+grupo_id+'&filtro=filtrar';
	});
	
	
	$("#remover_foto").live('click',function(){
		var id=$("#id").val();		
		
		$("#div_foto").hide("slow");
	
		$("#exibe_formulario > div").css("width","450px");
		
		window.open('modulos/odonto/servicos/remover_foto.php?id='+id,'carregador');
	});
	
	$("#realizar_importacao").live('click',function(){
		$("#form_procedimentos").submit();
	});
	
	$("#voltar").live('click',function(){
		location.href='?tela_id=373';
	});
	
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="" class='s1'>
  Sistema
</a>
<a href="" class='s1'>
  	Odonto
</a>
<a href="" class='s1'>
  	IMPORTAÇÃO DE PROCEDIMENTOS
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
	  
       <input type="button" value="<<" id="voltar" style="float:left;margin-top:3px;margin-right:5px;">
       
      <select name="grupo_id" id="grupo_id" style="float:left;margin-top:3px;" >
    	<option value="">Selecione um grupo</option>
       
		<?php
			$grupos = mysql_query("SELECT * FROM servico_grupo WHERE vkt_id='1'");
			while($grupo = mysql_fetch_object($grupos)){
		?>
        	<option value="<?=$grupo->id?>" <?php if($grupo->id==$_GET['grupo_id']){ echo "selected='selected'";}?>><?=$grupo->nome?></option>
        <?php
			}
		?>
    </select>
    
    <input type="button" value="Realizar Importação" id="realizar_importacao" style="float:right;margin-top:3px;margin-right:5px;">
   	
</div>
<script>
$(".grupo").live('click',function(){
	var id = $(this).val();
	if($(this).is(':checked')){
		$(".grupo_servico"+id).attr('checked','checked');
	}else{
		$(".grupo_servico"+id).removeAttr('checked');
	}
});
$(".servicos").live('click',function(){
	grupo_id = $(this).attr('grupo_id');
	if($(this).is(':checked')){
		$("#grupo"+grupo_id).attr('checked','checked');
	}else{
		$("#grupo"+grupo_id).removeAttr('checked');
	}
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
          <td width="60"></td>
          <td width="60">Codigo</td>
          <td width="300">PROCEDIMENTO</td>
          <td width="70">VALOR</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<form method="post" id="form_procedimentos">
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    
	<?php 
		$fim='';
		if(!empty($_GET['busca'])){
			$fim.=" AND nome LIKE '%".$_GET['busca']."%'";	
		}
		if(!empty($_GET['grupo_id'])){
			$fim.=" AND id='".$_GET['grupo_id']."'";	
		}
		// necessario para paginacao
   		$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM servico WHERE vkt_id='$vkt_id' $fim"),0,0);
		
		$sql = mysql_query($t="SELECT *	FROM servico_grupo WHERE vkt_id='1' $fim ORDER BY nome  LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
					
		echo mysql_error();	
				while($r=mysql_fetch_object($sql)){
		
	?>      
    	<thead>
        <tr>
        	<td colspan="1" style="text-align:center;"><input class="grupo" name="grupo[]" value="<?=$r->id?>" type="checkbox" id="grupo<?=$r->id?>"></td>
            <td colspan="5"><?php echo $r->nome?></td>
        </tr>
        </thead>
        		
<?php
		$servicos_grupo=mysql_query($t="SELECT * FROM servico WHERE vkt_id='1' AND grupo_id='$r->id' ORDER BY nome  LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));	
		echo mysql_error();	
				while($servico=mysql_fetch_object($servicos_grupo)){
?>
					<tbody>
                        <tr>
                          <td width="60" style="text-align:center;"><input class="grupo_servico<?=$r->id?> servicos" name="servico[]" value="<?=$servico->id?>" type="checkbox" grupo_id="<?=$r->id?>"></td>
                          <td width="60"><?=$servico->codigo_interno?></td>
                          <td width="300"><?=$servico->nome?></td>
                          <td width="70"><?=moedaUsaToBr($servico->valor_normal)?></td>
                          <td></td>
                        </tr>
    				</tbody>
<?php
				}
	}
?>
    
    
</table>
<input type="hidden" name="action" value="realizar_importacao">
</form>
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
