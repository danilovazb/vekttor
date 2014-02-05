<?
//include("_functions.php");
//include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var convenio_id = $(this).attr('convenio_id');
		var data_inicio = $(this).attr('data_inicio');
		var data_fim    = $(this).attr('data_fim');
		
		window.open('modulos/odonto/relatorios/form_convenios.php?data_inicio='+data_inicio+'&data_fim='+data_fim+'&convenio_id='+convenio_id,'carregador');
	});
});

$("#impressao").live('click',function(){
	var data_inicio = $("#de").val();
	var data_fim    = $("#ate").val();
    window.open('modulos/odonto/relatorios/impressao_relatorios.php?data_inicio='+data_inicio+'&data_fim='+data_fim+'&acao=todos_convenios');
});

$("#imprimir_atendimentos").live('click',function(){
	
	var id = $("#id").val();
	var data_inicio = $("#data_inicio").val();
	var data_fim    = $("#data_fim").val();
	window.open('modulos/odonto/relatorios/impressao_relatorios.php?id='+id+'&data_inicio='+data_inicio+'&data_fim='+data_fim+'&acao=atendimentos_convenio');
});

$(".vlr_convenio").live('keyup',function(){
	var total_convenio=0;
	var item_id=$(this).attr('item_id');
	var valor = moedaBrToUsa($(this).val())*1;
	//alert(item_id);
	window.open('modulos/odonto/relatorios/_ctrl.php?acao=altera_valor_convenio&id='+item_id+"&valor="+valor,"carregador");
	
	$(".vlr_convenio").each(function() {
        total_convenio+= moedaBrToUsa($(this).val())*1; 
    });
		
	$("#total_convenio").html(moedaUsaToBR(total_convenio));
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	Sistema
</a>
<a href="?" class='s2'>
  	Odontólogo
</a>
<a href="?tela_id=302" class='navegacao_ativo'>
<span></span> Convenio X Servicos
</a>
<form class='form_busca' action="" method="get">
   	 <a id="clickbusca"></a>
	<?php 
	if(empty($_GET["de"])&&empty($_GET["ate"])){ 
		$data_inicio = "01/".date("m/Y");
		$data_fim    =date("t/m/Y");
	}else{
		$data_inicio = $_GET['de'];
		$data_fim    = $_GET['ate'];
	}?>
    
    <input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" id="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
    
</form>
</div>

<div id="barra_info">
 <button style="float:right; margin-top:2px; margin-right:5px;" class="botao_imprimir" id="impressao" type="button">
	<img src="../fontes/img/imprimir.png">
	</button>
 <form method="get" autocomplete="off">
	De:<input type="text" id='de' name="de" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' value="<?=$data_inicio;?>" style="width:80px;height:10px;"/>
    Ate:<input type="text" id='ate' name="ate" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' value="<?=$data_fim;?>" style="width:80px;height:10px;"/>
    <input type="submit" value="Filtrar" />
    <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	</form>
</div>

<script>
	$(document).ready(function(){
		$("tr:odd").addClass('al');
	});
	
	$(".valor_convenio").live('click',function(){
		var data_inicio = $(this).parent().parent().attr('data_inicio');
		var data_fim    = $(this).parent().parent().attr('data_fim');
		var convenio_id = $(this).parent().parent().attr('convenio_id');
		window.open("modulos/odonto/relatorios/form_convenios.php?convenio_id="+convenio_id+"&data_inicio="+data_inicio+"&data_fim="+data_fim,"carregador");
	});
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="60"><?=linkOrdem("Codigo","Codigo",1)?></td>
          <td width="200">Procedimento</td>
          <td width="110">Valor Procedimento</td>
          <td width="110">Valor Convenio</td>
           <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
		if(!empty($_GET['de'])&&!empty($_GET['ate'])){
			$filtro      = " AND data_cadastro BETWEEN '".dataBrToUsa($_GET['de'])."' AND '".dataBrToUsa($_GET['ate'])."'";
			$data_inicio = $_GET['de'];
			$data_fim    = $_GET['ate'];
		}else{
			$mes_atual=date("m");
			$filtro      = " AND MONTH(data_cadastro) = '$mes_atual'";
			$data_inicio = date("Y")."-$mes_atual-01";
			$data_fim = date("Y")."-$mes_atual-".date("t");
		}
		
		if(!empty($_GET['busca'])){
			$busca = "AND razao_social LIKE '%".$_GET['busca']."%'";
		}
		
		$registros= mysql_result(mysql_query("SELECT COUNT(*), cf.id as convenio_id 
							   FROM
							   	odontologo_convenio oc, 
								cliente_fornecedor cf														
							   WHERE 
							   		oc.vkt_id                = '$vkt_id' AND
									oc.cliente_fornecedor_id =  cf.id	 $busca"),0,0);
		echo mysql_error();
		$sql = mysql_query($t="SELECT *, cf.id as convenio_id 
							   FROM
							   	odontologo_convenio oc, 
								cliente_fornecedor cf														
							   WHERE 
							   		oc.vkt_id                = '$vkt_id' AND
									oc.cliente_fornecedor_id =  cf.id																
							   LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
		
		$cont=0;
		
		$valor_os_funcionario=0;
		while($r=mysql_fetch_object($sql)){
			
			$valor_procedimentos = 
			mysql_fetch_object(mysql_query($t="
			SELECT 
				SUM(oai.valor) as valor, SUM(oai.valor_convenio) as valor_convenio
			FROM 
				odontologo_atendimentos oa,
				odontologo_atendimento_item oai
			WHERE
				oa.id         = oai.odontologo_atendimento_id AND
				oa.convenio_id = '$r->convenio_id' AND
				oai.data_cadastro BETWEEN '".$data_inicio."' AND '".$data_fim."'
			"));
			//echo $t." ".mysql_error();
			//$ultimo_atendimento = mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_atendimento_item WHERE cliente_fornecedor_id = '$r->id' AND data_cadastro < CURRENT_DATE() AND status = '2' ORDER BY id DESC LIMIT 1"));
			//echo $t;	 
	?>
    		<tr data_inicio="<?=$data_inicio?>" data_fim="<?=$data_fim?>" class="valor_convenio" convenio_id='<?=$r->cliente_fornecedor_id?>'>
            	<td width="60"><?=$r->cliente_fornecedor_id?></td>
            	<td width="200"><?=$r->razao_social?></td>
                <td width="110" style="text-align:right;"><?php if($valor_procedimentos->valor>0){ echo MoedaUsaToBr($valor_procedimentos->valor);}else{ echo "0,00";}?></td>
                <td width="110" style="text-align:right;"><?php if($valor_procedimentos->valor_convenio>0){ echo MoedaUsaToBr($valor_procedimentos->valor_convenio);}else{ echo "0,00";}?></td>
                <td></td>
	<?php
			$valor_total+=$valor_procedimentos->valor;
			$valor_total_convenio+=$valor_procedimentos->valor_convenio;
		}
	?>
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
          <td width="60"></td>
          <td width="200"></td>
          <td width="110" style="text-align:right"><?=MoedaUsaToBr($valor_total)?></td>
          <td width="110" style="text-align:right"><?=MoedaUsaToBr($valor_total_convenio)?></td>
           <td></td>
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
