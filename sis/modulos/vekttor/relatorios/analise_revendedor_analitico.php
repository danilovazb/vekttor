<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});
$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		
		//window.open('modulos/aluguel/relatorios/receitas/form.php?id='+id,'carregador');
});
$("#clickbusca").live("click",function(e) {
	busca=$("#busca").val();
	location.href="?tela_id=<?=$_GET['tela_id']?>&busca="+busca;
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<a href="#" class='s1'>
  	Vektor
</a>
<a href="#" class='s2'>
  	Relatórios
</a>
<a href="#" class='navegacao_ativo'>
<span></span>    Análise de Revendedor
</a>
</div>

<div id="barra_info">
  <input type="button" value="<<" onclick="location.href='?tela_id=337&de=<?=DataUsaToBr($_GET['data_ini'])?>&ate=<?=DataUsaToBr($_GET['data_fim'])?>'"
  <?php
  	$revendedor = mysql_fetch_object(mysql_query("SELECT *, rf.cliente_vekttor_id as rf_vkt_id FROM 
													revenda_franquia rf,
													cliente_fornecedor cf
												WHERE
													rf.cliente_fornecedor_id = cf.id AND
													rf.id = '".$_GET['revendedor_id']."'"));
  echo "<strong>".$revendedor->razao_social."</strong>";
  ?>
  <span style="float:right">
  Período: 
  	<?php 
		if(empty($_GET["de"])&&empty($_GET["ate"])){ 
			echo "01/".date("m/Y")." a ".date("t/m/Y");
		}else{
			echo $_GET['de']." a ".$_GET['ate'];
		}?>
  </span>
</div>

<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="150">Cliente</td>
          <td width="100">Data Negociação</td>
          <td width="65">Vlr Implant</td>
          <td width="65">% Implant</td>
          <td width="65">Vlr Mensal</td>
          <td width="65">% Mensal</td>
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
			$filtro = " AND data_negociacao BETWEEN '".dataBrToUsa($_GET['de'])."' AND '".dataBrToUsa($_GET['ate'])."'";
		}
		
		$mes_atual=date("m");
		$registros= @mysql_result(mysql_query($t=" SELECT DISTINCT(revenda_franquia_id) as franquia_id FROM 
							vekttor_venda
							$busca"),0,0);
							//echo $t;
		$sql = mysql_query($t="SELECT * FROM
							vekttor_venda WHERE
							revenda_franquia_id = $revendedor->rf_vkt_id
							$filtro 
							LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
		//echo $t;
		$soma_vlr_implantacao = 0;
		$soma_vlr_mensalidade = 0;
		
		$valores_vendas = mysql_fetch_object(mysql_query("SELECT SUM(valor_implantacao) as vi,SUM(valor_mensalidade) as vm FROM vekttor_venda WHERE revenda_franquia_id = $revendedor->rf_vkt_id $filtro"));
		
		while($r=@mysql_fetch_object($sql)){
			//echo $t;
			$cliente = mysql_fetch_object(mysql_query("SELECT * FROM clientes_vekttor WHERE id = $r->cliente_vekttor_id"));
			$valores = @mysql_num_rows(mysql_query("SELECT SUM(valor_implantacao) as vi,SUM(valor_mensalidade) as vm FROM vekttor_venda WHERE revenda_franquia_id = $r->vkt_id $filtro"));
			$soma_vlr_implantacao += $r->valor_implantacao;
			$soma_vlr_mensalidade += $r->valor_mensalidade; 
			if($valores_vendas->vi>0){
				$porcentagem_implantacao = ($r->valor_implantacao*100)/$valores_vendas->vi;
			}
			if($valores_vendas->vm>0){
				$porcentagem_mensalidade = ($r->valor_mensalidade*100)/$valores_vendas->vm;
			}
?>      
    	<tr <?=$sel?> id="<?=$r->id?>">
          <td width="150"><?=$cliente->nome?></td>
          <td width="100"><?=DataUsaToBr($r->data_negociacao)?></td>
          <td width="65"><?php if(!$r->valor_implantacao>0){echo "0";}else{ echo MoedaUsaToBr($r->valor_implantacao);}?></td>
          <td width="65"><?php if(!$porcentagem_implantacao>0){echo "0";}else{ echo $porcentagem_implantacao;}?></td>
          
          <td width="65"><?php if(!$r->valor_mensalidade>0){echo "0";}else{ echo MoedaUsaToBr($r->valor_mensalidade);}?></td>
          <td width="65"><?php if(!$porcentagem_mensalidade>0){echo "0";}else{ echo $porcentagem_mensalidade;}?></td>
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
    		<tr <?=$sel?> id="<?=$r->id?>">
          <td width="50"></td>
          <td width="200"></td>
          <td width="70"><?=$soma_qtd?></td>
          <td width="65"><?=moedaUsaToBr($soma_vlr_implantacao)?></td>
          <td width="65"></td>
          <td width="65"><?=$soma_qtd?></td>
          <td width="65"><?=moedaUsaToBr($soma_vlr_mensalidade)?></td>
          <td width="65"></td>
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
