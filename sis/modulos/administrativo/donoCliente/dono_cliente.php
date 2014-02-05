<?php
//$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
//$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>

<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id='some'>«</div>
<a href="./" class='s1'>
  	Sistema
</a>
<a href="./" class='s2'>
    Administrativo 
</a>
<a href="" class="navegacao_ativo">
<span></span>    <?=$tela->nome?> 
</a>
</div>
<div id="barra_info">
 
</div>
<script type="text/javascript">
		
$(document).ready(function() {
		
		$("#tabela_dados tr").live("click",function(){
			var id = $(this).attr('id');
			window.open('modulos/administrativo/vendas/donoCliente/form_altera.php?id='+id,'carregador');
			//alert(id);
		});
		
		$("#al_corretor").live("click",function(){
				$("#container_select").toggle();
		})
		
		$("select#imobiliario_id").live("change",function(){
				var idc =  $(this).val();
				$('#label_corretor').load('modulos/administrativo/vendas/donoCliente/select_corretores.php?imobiliario_id='+idc);
		});
    		

});

</script>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="130">Indetifica&ccedil;&atilde;o</td>
          	<td width="200">Cliente</td>
            <td width="130">Corretor</td>
          	<td width="80">Situa&ccedil;&atilde;o</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
	
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND identificacao like '%{$_GET[busca]}%'";
	}
	
	if($_GET['situacao']>0)
		 $situacao="WHERE contrato.situacao='".($_GET['situacao']-1)."'";
	else 
		$situacao="WHERE contrato.situacao IS NOT NULL";
	
	// necessario para paginacao
    $registros= mysql_result(mysql_query("SELECT count(*) FROM contrato JOIN disponibilidade ON contrato.disponibilidade_id=disponibilidade.id $situacao $busca_add ORDER BY identificacao"),0,0);
	
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="identificacao";
	}
	
	// colocar a funcao da paginação no limite
	/*$q= mysql_query("SELECT *,contrato.situacao as sit FROM contrato  JOIN disponibilidade ON contrato.disponibilidade_id=disponibilidade.id  WHERE contrato.situacao = '1' $situacao $busca_add ORDER BY ".$ordem." ".$_GET['ordem_tipo']." LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));*/
	
	$q= mysql_query($t="SELECT *,contrato.situacao as sit FROM contrato  JOIN disponibilidade ON contrato.disponibilidade_id=disponibilidade.id  WHERE contrato.situacao = '1'");
	 
	while($r=mysql_fetch_object($q)){
		$total++;
		
		$cliente=mysql_fetch_object(mysql_query("SELECT nome_fantasia FROM cliente_fornecedor WHERE id='".$r->cliente_fornecedor_id."'"));
		
		$corretor=mysql_fetch_object(mysql_query("SELECT * FROM corretor WHERE id='".$r->corretor_id."'"));
		
		if($r->sit==0)$situacao="Pr&eacute;-Venda";
		if($r->sit==1)$situacao="Aprovado";
		if($r->sit==2)$situacao="Confirmado";
		if($r->sit==3)$situacao="Cancelado";
	?>
	
    	<tr id="<?=$r->id?>">
            <td width="130"><?=$r->identificacao?></td>
          	<td width="200"><?=$cliente->nome_fantasia?></td>
            <td width="130"><?=$corretor->nome;?></td>
          	<td width="80"><?=$situacao?></td>
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
           <td width="130"><a>Total: <?=$total?></a></td>
           <td width="130">&nbsp;</td>
           <td width="80">&nbsp;</td>
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
