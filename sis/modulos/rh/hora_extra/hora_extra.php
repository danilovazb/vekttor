<?php
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>
<div id='form_socio'></div>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
.btf{ display:block; float:left; width:15px; height:15px; background-image:url(../fontes/img/formatacao.gif);margin-top:5px;text-decoration:none;}
	.bold{ background-position:-2px -17px;}
	.italic{ background-position:-20px -17px; }
	.underline{ background-position:-58px -16px;}
	.justifyleft{ background-position:-2px 0px;margin-left:50px}
	.justifycenter{ background-position:-20px 0px;}
	.justifyright{ background-position:-38px 0px;}
	.justifyfull{ background-position:-57px 0px;}
	.insertunorderedlist{background-position:-19px -51px;margin-left:50px;}
	.insertorderedlist{ background-position:-37px -51px;}
</style>
<script>
	
	$("#impressao_relatorio").live('click',function(){
		window.open('modulos/rh/hora_extra/form.php','carregador')
	});
	
	$("#imprimir").live('click',function(){
		empresa_id = $("#empresa_id").val();
		mes = $("#mes").val();
		ano = $("#ano").val();
		
		if(!empresa_id>0||!ano>0){
			alert("SELECIONE A EMPRESA, O MÊS E O ANO DA FOLHA DE PAGAMENTO!");
		}else{
			window.open('modulos/rh/hora_extra/impressao_folha_ponto.php?mes='+mes+'&ano='+ano+'&empresa_id='+empresa_id);
		}
	});
	
</script>
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id="some">«</div>
<a href="./" class='s1'>
  	Sistema 
</a>
<a href="./" class='s2'>
    RH 
</a>
<a href="#" class="navegacao_ativo">
<span></span>    <?=$tela->nome?> 
</a>
</div>
<div id="barra_info">
Selecione uma empresa
	<!-- <input type="button" id="impressao_relatorio" value="Relatório de Ponto Por Mês" style="margin-top:3px;"/>  -->    
    <!--<a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>-->
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">Codigo</td>
            <td width="230">Nome</td>
          	<td width="130">Último Lançamento</td>
          	<td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND cf.nome_fantasia like '%{$_GET[busca]}%'";
	}
	
	$filtro = '';
	
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="cf.nome_fantasia";
	}
	$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM 
			rh_empresas re,
			cliente_fornecedor cf
		WHERE 
			re.cliente_fornecedor_id = cf.id AND
			cf.tipo='Cliente' AND 
			cf.tipo_cadastro='Jurídico' AND 
			re.vkt_id ='$vkt_id' AND 
			re.status='1'
		"),0,0);
	// colocar a funcao da paginaçao no limite
	$q= mysql_query($t="SELECT *, cf.id as cliente_fornecedor_id FROM 
		rh_empresas re,
		cliente_fornecedor cf 
		WHERE 
		re.cliente_fornecedor_id = cf.id AND
		cf.tipo='Cliente' AND 
		cf.tipo_cadastro='Jurídico' AND 
		re.vkt_id ='$vkt_id' AND 
		re.status='1' 
		$busca_add 
		$filtro 
		ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	//echo $t;
	while($r=mysql_fetch_object($q)){
		
		$ultimo_lancamento = mysql_fetch_object(mysql_query("SELECT * FROM rh_hora_extra WHERE empresa_id='$r->cliente_fornecedor_id' AND vkt_id='$vkt_id' ORDER BY id DESC LIMIT 1"));
				
		if(empty($ultimo_lancamento->data)){
			$data = "01/".date('m')."/".date('Y');
		}else{
			$data = mysql_result(mysql_query("SELECT DATE_ADD('$ultimo_lancamento->data', INTERVAL 1 DAY)"),0,0);
			$data = DataUsaToBr($data);
		}
		
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}

	?>
<tr <?=$sel?>onclick="location.href='?tela_id=442&empresa1id=<?=$r->cliente_fornecedor_id?>&data=<?=$data?>'">
<td width="50" align="right"><?=str_pad($r->cliente_fornecedor_id,5,"0",STR_PAD_LEFT)?></td>
<td width="230"><?=$r->nome_fantasia?></td>
<td width="130"><?=DataUsaToBr($ultimo_lancamento->data)?></td>
<td></td>
</tr>
<?
	}
	?>	
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">&nbsp;</td>
           <td width="230"><a>Total: <?=$total?></a></td>
           <td width="130">&nbsp;</td>
           <td width="110">&nbsp;</td>
           <td width="80">&nbsp;</td>
		   <td width="110">&nbsp;</td>
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
