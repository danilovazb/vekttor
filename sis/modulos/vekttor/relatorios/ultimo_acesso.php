<?

$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
     
     <label style="width:300px;">
	
    </label>
    <input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
	
	$(".exibe_modulos").live('click',function(){
		id = $(this).attr('r');
		$(".exibe_modulos").css('font-weight','normal');
		$(this).css('font-weight','bold');
		$(".submodulos").hide();

		$("#div"+id).show();
			
	
	})
	
	$("#marcarTodos").live("click",function(){
		//alert(this.checked);
		if(this.checked==true){
			$(this).parent().parent().find(".modulo_id").attr("checked","checked");			
		}else{
			$(this).parent().parent().find(".modulo_id").removeAttr("checked");
			
		}
	});
	$("#revendedor_id").live("change",function(){
		var status = $("#status").val();
		
		location.href='?tela_id=<?=$_GET['tela_id']?>&revendedor_id='+$(this).val()+'&status='+status;
	});
	
	$("#status").live("change",function(){
		var revendedor_id = $("#revendedor_id").val();
		
		location.href='?tela_id=<?=$_GET['tela_id']?>&revendedor_id='+revendedor_id+'&status='+$(this).val();
	});
</script>
<div id="some">&laquo;</div>
<a href="./" class='s1' >
  	Sistema
</a>
<a href="./" class='s2'>
    Vekttor 
</a>
<a href="?tela_id=15" class="navegacao_ativo">
<span></span>    Clientes 
</a>
</div>
<div id="barra_info">

	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="230"><?=linkOrdem("Nome","nome_fantasia",1)?></td>
            <td width="150">&Uacute;ltimo acesso</td>
             <td width="50">Dias</td>
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?php
	$filtro = '';
	if(strlen($_GET[busca])>0){
		$busca_add = "AND cliente.nome_fantasia like '%{$_GET[busca]}%'";
	}
		
	// colocar a funcao da paginação no limite
	$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM clientes_vekttor $filtro"),0,0);
	//$q= mysql_query($t="SELECT * FROM clientes_vekttor $filtro LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	$q=mysql_query($t="
	SELECT v.nome, d.dt, date_format(d.dt,'%d/%m/%Y às %H:%i') as dth
FROM (
		
		SELECT vkt_id, max( `datahora` ) AS dt
		FROM `sis_modulos_avaliacao`
		GROUP BY vkt_id
		ORDER BY datahora
	) AS d, clientes_vekttor AS v
WHERE d.vkt_id = v.id ORDER BY d.dt DESC
	");
	//echo $t;
	while($r=mysql_fetch_object($q)){
		
		$data_ultimo_acesso = explode("/",substr($r->dth,0,10));
		$data_ultimo_acesso = $data_ultimo_acesso[2]."-".$data_ultimo_acesso[1]."-".$data_ultimo_acesso[0];
		//echo $data_ultimo_acesso;
		$diferenca_dias = mysql_result(mysql_query("SELECT DATEDIFF(NOW(),'$data_ultimo_acesso') as diferenca"),0,0);
		//echo mysql_error();
		
		//verifica de qual venda o cliente veio
		//echo $venda->id."<br>";
		
		//echo $t;
	?>
<tr <?=$sel?>onclick="window.open('<?=$caminho?>form.php?cliente_id=<?=$r->id?>','carregador')">
<td width="230"><?=$r->nome?></td>
<td width="150"><?=$r->dth?></td>
<td width="50"><?=$diferenca_dias?></td>
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
   <!-- <select name="limitador" id="select" style="margin-left:10px" onchange="location='?tela_id=<?=$_GET[tela_id]?>&pagina=<?=$_GET[pagina]?>&busca=<?=$_GET[busca]?>&ordem=<?=$_GET[ordem]?>&ordem_tipo=<?=$_GET[ordem_tipo]?>&limitador='+this.value">
        <option <?=$qtd_selecionado[15]?> >15</option>
        <option <?=$qtd_selecionado[30]?>>30</option>
        <option <?=$qtd_selecionado[50]?>>50</option>
        <option <?=$qtd_selecionado[100]?>>100</option>
  </select>-->
  Por P&aacute;gina 
  
  
    <div style="float:right; margin:0px 20px 0 0">
    <?=paginacao_links($_GET[pagina],$registros,$_GET[limitador])?>
    </div>
</div>
