<?
session_start();

//include("_functions.php");
//include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id          = $(this).attr('id');
		var data_inicio = $(this).attr('data_inicio');
		var data_fim    = $(this).attr('data_fim');
		
		window.open('modulos/odonto/relatorios/form_atendimento_odontologo.php?id='+id+'&data_inicio='+data_inicio+'&data_fim='+data_fim+'&acao=odontologo','carregador');
	});
});
$("#imprimir_atendimentos").live('click',function(){
	var id = $("#id").val();
	var data_inicio = $("#data_inicio").val();
	var data_fim    = $("#data_fim").val();
	window.open('modulos/odonto/relatorios/impressao_relatorios.php?id='+id+'&data_inicio='+data_inicio+'&data_fim='+data_fim+'&acao=impressao_odonto');
});
$("#impressao").live('click',function(){
	var data_inicio = $('#de').val();
	var data_fim    = $('#ate').val();
	window.open('modulos/odonto/relatorios/impressao_relatorios.php?acao=impressao&data_inicio='+data_inicio+'&data_fim='+data_fim);
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	Sistema
</a>
<a href="?" class='s2'>
  	Odontologo
</a>
<a href="?tela_id=302" class='navegacao_ativo'>
<span></span>    Atendimento Odontólogo
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
  	<?php 
		if(empty($_GET["de"])&&empty($_GET["ate"])){ 
			$data_inicio="01/".date("m/Y");
			$data_fim=date("t/m/Y");
		}else{
			$data_inicio=$_GET['de'];
			$data_fim=$_GET['ate'];
		}?>
  <button style="float:right; margin-top:2px; margin-right:5px;" class="botao_imprimir" id="impressao" type="button">
	<img src="../fontes/img/imprimir.png">
	</button>
  <form method="get" autocomplete="off">
	De:<input type="text" id='de' name="de" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$data_inicio;?>" style="height:8px;"/>
    Ate:<input type="text" id='ate' name="ate" autocomplete='off' maxlength="44" 
	mascara='__/__/____' calendario='1' size="8"  value="<?=$data_fim;?>" height="7" style="height:8px;"/>
    <input type="submit" value="Filtrar" />
    <input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	</form>
    
</div>

<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="60"><?=linkOrdem("Codigo","Codigo",1)?></td>
          <td width="200">Nome</td>
          <td width="160">Procedimentos concluídos</td>
          <td width="160">Procedimentos incompletos</td>
          <td width="60">Total</td>
          
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
			$data_inicio = dataBrToUsa($_GET['de']);
			$data_fim    = dataBrToUsa($_GET['ate']);
		}else{
			$mes_atual=date("m");
			$filtro      = " AND MONTH(data_cadastro) = '$mes_atual'";
			$data_inicio = date("Y")."-$mes_atual-01";
			$data_fim = date("Y")."-$mes_atual-".date("t");
		}
		
		if(!empty($_GET['busca'])){
			$busca = "AND cf.razao_social LIKE '%".$_GET['busca']."%' OR cf.id LIKE '%".$_GET['busca']."%'";
		}
		
		$registros= @mysql_result(mysql_query("SELECT *
							   FROM 
								odontologo_odontologo oo,
								cliente_fornecedor cf
								
							   WHERE 
							   		oo.cliente_fornecedor_id = cf.id AND
							  		oo.vkt_id='$vkt_id' $busca"),0,0);

		$sql = mysql_query($t="SELECT 
								*, oo.id as dentista_id,
								cf.razao_social,
								u.id as usuario_id
							   FROM 
								odontologo_odontologo oo,
								cliente_fornecedor cf,
								usuario as u
							   WHERE
							   	oo.cliente_fornecedor_id = cf.id AND 
							  	oo.vkt_id = '$vkt_id' AND
								u.id = oo.usuario_id
								$busca
							   LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
		echo mysql_error();	
		$cont=0;
		$valor_os_funcionario=0;
		while($r=mysql_fetch_object($sql)){
			 $cont++;
			 if($cont%2==0){$c="al";}else{$c="";}
			$quantidade_item_incompletos = mysql_fetch_object(mysql_query($t="SELECT COUNT(*) as qtd FROM odontologo_atendimento_item WHERE vkt_id='$vkt_id' AND odontologo_id = '$r->usuario_id' AND status!='2' $filtro"));
			$quantidade_item_completos= mysql_fetch_object(mysql_query($t="SELECT COUNT(*) as qtd FROM odontologo_atendimento_item WHERE vkt_id='$vkt_id' AND odontologo_id = '$r->usuario_id' AND status='2' $filtro"));
echo mysql_error();
			$quantidade_total   = $quantidade_item_completos->qtd + $quantidade_item_incompletos->qtd; 
	?>
    		<tr id="<?=$r->usuario_id?>" data_inicio="<?=$data_inicio?>" data_fim="<?=$data_fim?>">
            	<td width="60"><?=$r->usuario_id?></td>
            	<td width="200"><?=$r->razao_social?></td>
                <td width="160"><?=$quantidade_item_completos->qtd?></td>
                <td width="160"><?=$quantidade_item_incompletos->qtd?></td>
                <td width="60"><?=$quantidade_total?></td>
                <td></td>
	<?php
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
