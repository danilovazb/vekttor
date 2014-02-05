<?
include("_functions.php");
include("_ctrl.php"); 
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id='form_documento'></div>
<div id="some">«</div>

<a href="?" class='s1'>
  	Sistema
</a>
<a href="?" class='s2'>
  	RH
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>
<script>
	$("#confirma_pagamento").live('click',function(){
		
		if($(this).is(":checked")){
			$("#div_data_pagamento").css('display','block');
		}else{
			$("#div_data_pagamento").css('display','none');
		}
		
	});
	
	$("#imprimir_boletos").live('click',function(){
		window.open('modulos/rh/cobranca/form_impressao.php','carregador');
	});
	
	$("#imprimir_todos_boletos").live('click',function(){
		
		var data_vencimento = $("#data_vencimento").val();
		
		window.open('modulos/rh/cobranca/impressao_boletos.php?acao=todos&data_vencimento='+data_vencimento);
	});
	$("#imprimir_1_boletos").live('click',function(){
		
		var cobranca= $("#id").val();
		
		window.open('modulos/rh/cobranca/impressao_boletos.php?acao=um&cobranca='+cobranca);
	});
</script>
<div id="barra_info">    
<a href="modulos/rh/cobranca/form.php" target="carregador" class="mais"></a>
<input type="button" id="imprimir_boletos" value="Imprimir Boletos" style="float:right;margin-right:15px;margin-top:3px;"/>

<input type="button" onclick="window.open('modulos/rh/cobranca/empresas.php','_blank')"  value="Lista empresas" style="float:right;margin-right:15px;margin-top:3px;"/>

<input type="button" onclick="window.open('modulos/rh/cobranca/iphone.php','_blank')" value="Iphone" style="float:right;margin-right:15px;margin-top:3px;"/>
<form action="" method="get">
   	
    <select name="situacao">
    	<option value="0" <? if($_GET['situacao']=="0"){ echo "selected='selected'";}?>>Nao Pagos</option>
        <option value="1" <? if($_GET['situacao']=="1"){ echo "selected='selected'";}?>>Pagos</option>
    </select>
    
    De <input type="text" name="de" id="de" value="<?=$_GET['de']?>" style="width:80px;height:10px;"calendario="1" mascara="__/__/____"/>
    
     
     Até <input type="text" name="ate" id="ate" value="<?=$_GET['ate']?>" style="width:80px;height:10px;" calendario="1" mascara="__/__/____"/>
     
      <label>
        <input type="submit" value="Filtrar" />
    </label>
        <input type="hidden" name = "tela_id" value="<?=$_GET['tela_id']?>" />
    
</form>

  </div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="250">Empresa</td>
            <td width="80">Vencimento</td>
          	<td width="80">Valor</td>
          	
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND cf.nome_fantasia like '%{$_GET[busca]}%'";
	}
	
	$filtro = '';
	
	if(!empty($_GET['situacao'])){
		$situacao.=" AND rc.situacao='".$_GET['situacao']."'";
	}else{
		$situacao = " AND rc.situacao='0'"; 
	}
	
	if(!empty($_GET['de']) && !empty($_GET['ate'])){
		$filtro.=" AND rc.data_vencimento BETWEEN '".DataBrToUsa($_GET['de'])."' AND '".DataBrToUsa($_GET['ate'])."'";
	}
	
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="cf.nome_fantasia";
	}
	$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM 
		rh_cobranca_empresas
		WHERE 
		vkt_id='$vkt_id' AND
		situacao='0'"),0,0);
		echo mysql_error();
	// colocar a funcao da paginaçao no limite
	$q= mysql_query($t="SELECT *, rc.id as cobranca_id FROM 
		rh_cobranca_empresas rc,
		cliente_fornecedor cf
		WHERE 
		rc.cliente_fornecedor_id = cf.id AND
		rc.vkt_id ='$vkt_id' 
		$situacao
		$busca_add 
		$filtro 
		ORDER BY rc.data_vencimento,rc.valor DESC LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
		//echo $t;
		//echo mysql_error();
	//echo $t;
	while($r=mysql_fetch_object($q)){
		$empresa = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$r->cliente_fornecedor_id'"));	
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}

	?>
<tr <?=$sel?>onclick="window.open('modulos/rh/cobranca/form.php?id=<?=$r->cobranca_id?>','carregador')">
<td width="250"><?=$empresa->razao_social?></td>
<td width="80" align="right"><?=DataUsaToBr($r->data_vencimento)?></td>
<td width="80" align="right"><?=MoedaUsaToBr($r->valor)?></td>
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