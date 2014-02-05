<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");
include("modulos/financeiro/_ctrl_financeiro.php");
?>
<script src="modulos/financeiro/financeiro.js"></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
a{ text-decoration:none;}
</style>
<script>
$(".atl_natureza input:radio").live('click',function(){
	$("#atl_nome").val("");
	$("#atl_cnpf_cpf").val("");
	$("#atl_nome").attr("disabled","disabled");
	$("#atl_cnpf_cpf").attr("disabled","disabled");
	$("#atl_cadastrar").attr("disabled","disabled");
	
	for( i=0; i < $(this).length; i++ ){
			if($(this).is(":checked")){
				var liberado = true;
			}
	}
	if(liberado == true){
		$("#atl_nome").removeAttr("disabled");
		$("#atl_cnpf_cpf").removeAttr("disabled");
		$("#atl_cadastrar").removeAttr("disabled");
		$("#tipo").removeAttr("disabled");
	}
	if($(this).val() == '1'){
		$("#atl_cnpf_cpf").val('');
		$("#atl_cnpf_cpf").attr('mascara','___.___.___-__');
	}else{
		$("#atl_cnpf_cpf").val('');
		$("#atl_cnpf_cpf").attr('mascara','__.___.___/____-__'); // 05.535.221/0001-88
	}
});
$("div").on("click","#cad_cliente",function(){
	$(".modal").toggle();
});
$("div").on('click','#atl_cadastrar',function(){
		//Físico - Jurídico
		var natureza = $(".atl_natureza").find(":radio");
			for(i=0; i < natureza.length; i++){
				if($(natureza[i]).is(":checked")){
					var tipo_cadastro = $(natureza[i]).val();
				}
			}
	 
		  var nome = $("#atl_nome").val();
		  var cnpj_cpf = $("#atl_cnpf_cpf").val();
		  var tipo = $("select#tipo").val();
		//alert(tipo_cliente);
		$.post('modulos/ordem_servico/ordem_servico/tabela_item.php?acao=atl_cliente',{tipo_cadastro:tipo_cadastro,tipo:tipo,nome:nome,cnpjCpf:cnpj_cpf},function(data){
				$("#internauta_id").val(data);
				$("#cliente").val(nome);
				$("#atl_nome").attr("disabled","disabled");
				$("#atl_cnpf_cpf").attr("disabled","disabled");
				$("#atl_cadastrar").attr("disabled","disabled");
				$(".modal").hide("slow");	
		})
		
})
</script>
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="?" class='s2'>
  	Financeiro
</a>
<a href="?tela_id=52" class='navegacao_ativo'>
<span></span>    Contas a Receber
</a>
</div>
<div id="barra_info">
    <a href="modulos/financeiro/form_movimentacao.php" target="carregador" class="mais"></a>
<form style="float:left; margin:0; padding:0"> 
    <select name="exibicao">
    <option>Exibição</option>
        <option value="coluna" >Colunas</option>
        <option value="lista" <? if($_GET[exibicao]=='lista')echo 'selected="selected"'; ?> >Lista</option>
    </select> 
      <select name="tipo" id="tipo">
      	<option value="nulo">Escolha o filtro</option>
        <option value="centro" id="centro_escolha" title="Centro de Custo" <? if($_GET[tipo]=='centro')echo 'selected="selected"'; ?> >Centro de Custo</option>
        <option value="plano" id="plano_escolha" title="Plano de Conta" <? if($_GET[tipo]=='plano')echo 'selected="selected"'; ?> >Plano de Contas</option>
      </select> 
      <label id="centro" <? if($_GET[tipo]!='centro'){ ?> style="display:none;" <? } ?> >
      <select name="centro">
      <option>- Centro de Custo -</option>
		  <? 
          $query_escolha = mysql_query("SELECT id,nome FROM financeiro_centro_custo WHERE centro_custo_id='0' AND cliente_id='$vkt_id' AND plano_ou_centro='centro' "); 
          while($f = mysql_fetch_object($query_escolha)){
			  
		  $query_sub = mysql_query("SELECT id, nome FROM financeiro_centro_custo WHERE  centro_custo_id='{$f->id}' AND cliente_id='$vkt_id'"); 
		  if(mysql_num_rows($query_sub)>0){$tem_sub=true;}
          ?>
          <option <? if($tem_sub){?> style="font-weight:bolder;" <? } ?> <? if($_GET[centro]==$f->id)echo "selected"; ?> value="<?=$f->id?>"> <?=$f->nome?> </option>
          <? 
		  
		  if($tem_sub){
			  while($sub=mysql_fetch_object($query_sub)){
				  ?><option style="margin-left:10px;" <? if($_GET[centro]==$sub->id)echo "selected"; ?>  value="<?=$sub->id?>"> - <?=$sub->nome?> </option> <?
			  }
		  }
		  $tem_sub=false;
		  
          } ?>
      </select>
  </label>
  <label id="plano" <? if($_GET[tipo]!='plano'){ ?> style="display:none;" <? } ?> >
      <select name="plano">
      <option>- Plano de Conta -</option>
		  <? 
          $query_escolha = mysql_query("SELECT id,nome FROM financeiro_centro_custo WHERE centro_custo_id='0' AND plano_ou_centro = 'plano' AND cliente_id='$vkt_id'"); 
          while($f = mysql_fetch_object($query_escolha)){
			  
		  $query_sub = mysql_query("SELECT id, nome FROM financeiro_centro_custo WHERE centro_custo_id='{$f->id}' AND cliente_id='$vkt_id'"); 
		  if(mysql_num_rows($query_sub)>0){$tem_sub=true;}
          ?>
          <option <? if($tem_sub){?> style="font-weight:bolder;" <? } ?> <? if($_GET[plano]==$f->id)echo "selected"; ?> value="<?=$f->id?>"> <?=$f->nome?> </option>
          <? 
		  
		  if($tem_sub){
			  while($sub=mysql_fetch_object($query_sub)){
				  ?><option style="margin-left:10px;" <? if($_GET[plano]==$sub->id)echo "selected"; ?> value="<?=$sub->id?>"> - <?=$sub->nome?> </option> <?
			  }
		  }
		  $tem_sub=false;
		  
          } ?>
      </select>
  </label>
    De
    <?
    if(empty($_GET[filtro_inicio])&&empty($_GET[filtro_fim])){
		$filtro_inicio 	= date("Y-m-").'01';
		$filtro_fim		= date("Y-m-t");
		
	}else{
		$filtro_inicio 	= dataBrToUsa($_GET[filtro_inicio]);
		$filtro_fim		= dataBrToUsa($_GET[filtro_fim]);
	}
		$total_dias		= mysql_result(mysql_query($trace="SELECT DATEDIFF('$filtro_fim','$filtro_inicio')"),0,0);
	
	?>
    <input name="filtro_inicio" id="filtro_inicio" value="<?=dataUsaToBr($filtro_inicio)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0" >
    
     a
    <input name="filtro_fim" id="filtro_fim" value="<?=dataUsaToBr($filtro_fim)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0">
    <label>
        <select name="forma_pagamento">
        	<option>Forma de pagamento:</option>
            <option value="0" <? if($_GET[forma_pagamento]=='0')echo 'selected'; ?> >Todas</option>
            <option value="1" <? if($_GET[forma_pagamento]=='1')echo 'selected'; ?> >Dinheiro</option>
            <option value="2" <? if($_GET[forma_pagamento]=='2')echo 'selected'; ?> >Cheque</option>
            <option value="3" <? if($_GET[forma_pagamento]=='3')echo 'selected'; ?> >Cartao</option>
            <option value="4" <? if($_GET[forma_pagamento]=='4')echo 'selected'; ?> >Boleto</option>
            <option value="5" <? if($_GET[forma_pagamento]=='5')echo 'selected'; ?> >Permuta</option>
            <option value="6" <? if($_GET[forma_pagamento]=='6')echo 'selected'; ?> >Outros</option>
        </select>
    </label>
    <input type="hidden" name="tela_id" value="53" />
<input type="submit" name="button" id="button" value="Ir" />
</form>
</div>


<? 
/* FILTROS DE CONSULTA */
if($_GET[tipo] && $_GET[tipo]!='nulo'){
	$tabela_tipo=", financeiro_{$_GET[tipo]}_has_movimento as fhm";
	$filtro_tipo=" AND fm.id=fhm.movimento_id AND fhm.plano_id='{$_GET[$_GET[tipo]]}' ";
}
if($_GET[forma_pagamento] && $_GET[forma_pagamento]!=0)$filtro_forma=" AND fm.forma_pagamento ='{$_GET[forma_pagamento]}'";


/* FILTRO DE EXIBICAO*/
if($_GET[exibicao]=='coluna' || empty($_GET[exibicao])){ ?>

<div id='dados' style="clear:both;">
<table cellpadding="0" cellspacing="0"  width="<?=300+(($total_dias+1)*70)?>">
    <thead>
    	<tr>
    	  <td width="209" style="padding:1px;"><div style="width:206px; position:fixed; height:18px; background:url(../fontes/img/bb.jpg) 5px  -2px ; margin:-3px 0 0 -10x; border-right:1px solid  #CCC ">Descricao</div>Descricao</td>
<?
            for($i=0;$i<=$total_dias;$i++){
				$diainfo 	= mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
				$semanainfo = mysql_result(mysql_query($trace="SELECT date_format('$diainfo','%w')"),0,0);
				$dtinfo 	= mysql_result(mysql_query($trace="SELECT date_format('$diainfo','%d')"),0,0);
				;
			?>
          	<td width="70" style="margin:0; padding:0; text-align:center"><?=$semana_abreviado[$semanainfo].', '.$dtinfo?></td>
            <?
			}
			?>
            <td width="70" align="center">Total</td>
            <td width=""></td>
			
        </tr>
    </thead>
</table><script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<script>
function opf(id){
	window.open('modulos/financeiro/form_movimentacao.php?id='+id,'carregador')
}
</script>

<table cellpadding="0" cellspacing="0" width="<?=300+(($total_dias+1)*70)?>" >
    <tbody>
	<?
	
	
	$q= mysql_query("
	SELECT 
		fm.*,
		date_format(fm.data_vencimento,'%d') as dia_vencimento 
	FROM 
		financeiro_movimento as fm
		$tabela_tipo
	WHERE 
		cliente_id='".$_SESSION[usuario]->cliente_vekttor_id."' 
	$filtro_tipo
	AND 
		fm.tipo='receber'
	AND
		fm.extorno='0'  
	AND 
		fm.status='0'
	AND
		transferencia='0'
	AND 
		data_vencimento  between '$filtro_inicio' AND '$filtro_fim'
	$filtro_forma
	ORDER BY  
		fm.data_vencimento ");
	
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM `cliente_fornecedor` WHERE id ='$r->internauta_id ' "));

	?>      
    	<tr <?=$sel?> onclick="opf(<?=$r->id?>)">
          	<td width="200" ><div class='sobre' style="width:205px;"><?=$cliente_fornecedor->nome_fantasia.' - '.$r->descricao?></div>&nbsp;</td>
            <?
            for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
			$color='';
			if($r->data_vencimento==$diainfo){
				$somadia[$diainfo][]=$r->valor_cadastro ;
				if($r->status ==1){
					$somapago[$diainfo][]=$r->valor_cadastro ;
					$color = 'color:#00F';

				}
				if($r->status ==0){
					if($diainfo<date("Y-m-d")){
						$color = 'color:#F00';
					}
					$somaPendente[$diainfo][]=$r->valor_cadastro ;
				}
				
				$val=  moedaUsaToBr($r->valor_cadastro);
				$somatotal[$r->id]=$r->valor_cadastro;
			}else{
				$val = '';
			}

			?><td style="width:70px;margin:0;padding:0;text-align:right;<?=$color?>"><?=$val?></td><?
			}
			?>
          	<td width="70" align="right"><?=moedaUsaToBr($somatotal[$r->id])?></td>
          	<td width=""></td>
        </tr>
<?
	}
?>
    	
    </tbody>
</table>

<table cellpadding="0" cellspacing="0" width="<?=300+(($total_dias+1)*70)?>">
  <thead>
    	<tr>
       	  <td width="200">Total</td>
            <?
            for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
			?>
       	  <td width="70" style="margin:0; padding:0; text-align:right"><?
            $totalna= @array_sum($somadia[$diainfo]);
			if($totalna>0){
				$totaln[]= $totalna;
				echo moedaUsaToBr($totalna);
			}else{
			echo "&nbsp;";
			}
			?></td>
            <?
			}
			?>
          	<td width="70" align="right"><?=moedaUsaToBr(@array_sum($totaln));?></td>
          	<td width=""></td>
      </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0"width="<?=300+(($total_dias+1)*70)?>" >
  <thead>
    <tr>
      <td width="200">Pago</td>
            <?
			$totaln=array();
            for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
			?>
       	  <td width="70" style="margin:0; padding:0; text-align:right"><?
            $totalna= @array_sum($somapago[$diainfo]);
			if($totalna>0){
				$totaln[]= $totalna;
				echo moedaUsaToBr($totalna);
			}else{
			echo "&nbsp;";
			}
			
			$totalna=0;
			?></td>
            <?
			}
			?>
          	<td width="70" align="right"><?=moedaUsaToBr(@array_sum($totaln));?></td>
	      <td width=""></td>
    </tr>
  </thead>
</table>
<table cellpadding="0" cellspacing="0" width="<?=300+(($total_dias+1)*70)?>">
  <thead>
    <tr>
      <td width="200">Pendente</td>
            <?
			$totaln=array();
            for($i=0;$i<=$total_dias;$i++){
				$diainfo = mysql_result(mysql_query($trace="SELECT date_add('$filtro_inicio', INTERVAL $i DAY)"),0,0);
			?>
          	<td width="70" style="margin:0; padding:0; text-align:right"><?
            $totalna= @array_sum($somaPendente[$diainfo]);
			if($totalna>0){
				$totaln[]= $totalna;
				echo moedaUsaToBr($totalna);
			}else{
			echo "&nbsp;";
			}
			?></td>
            <?
			}
			?>
           	<td width="70" align="right"><?=moedaUsaToBr(@array_sum($totaln));?></td>
     <td width=""></td>
    </tr>
  </thead>
</table>

<? }elseif($_GET[exibicao]=='lista'){ ?>

<table cellpadding="0" cellspacing="0" width="100%" >
    <thead>
    	<tr>
    	  <td width="400">Descricao</td>
          	<td width="90" align="right" style="margin:0; padding:0; ">Data</td>
			<td width="120" align="right" style="margin:0; padding:0; ">Valor</td>
            <td></td>
           
			
        </tr>
    </thead>
</table>
<script>
function opf(id){
	window.open('modulos/financeiro/form_movimentacao.php?id='+id,'carregador')
}
</script>

<table cellpadding="0" cellspacing="0" width="100%"  >
    <tbody>
	<?
	
	
	
	$q= mysql_query("
	SELECT 
		*,
		date_format(fm.data_vencimento,'%d') as dia_vencimento 
	FROM 
		financeiro_movimento as fm
		$tabela_tipo
	WHERE 
		fm.cliente_id='".$_SESSION[usuario]->cliente_vekttor_id."' 
		$filtro_tipo
	AND 
		fm.tipo='receber'  
	AND
		fm.transferencia='0'
	AND 
		fm.status='0'
	AND 
		fm.extorno='0'
	AND 
		fm.data_vencimento  between '$filtro_inicio' AND '$filtro_fim'
	ORDER BY  
		fm.data_vencimento ");
	$valor_total=0;
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$valor_total+=$r->valor_cadastro;
		$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT * FROM `cliente_fornecedor` WHERE id ='$r->internauta_id' "));
	?>  
    	<tr <?=$sel?> onclick="opf(<?=$r->id?>)">
       	  <td width="400"><?=$cliente_fornecedor->nome_fantasia.' - '.$r->descricao?></td>
            <td width="80" align="right"><?=strftime('%d/%m',strtotime($r->data_vencimento))?></td>
            <td style="width:120px;margin:0;padding:0;text-align:right;"><?=number_format($r->valor_cadastro,2,',','.')?></td>
          <td></td>
        </tr>
<?
}
?>
</tbody>
</table>

<table cellpadding="0" cellspacing="0" width="100%" >
  <thead>
    <tr>
      <td width="400">Total</td>
      <td width="90" style="margin:0; padding:0; text-align:center">&nbsp;</td>
      <td width="120" align="right" style="margin:0; padding:0; "><?=number_format($valor_total,2,',','.')?></td>
      <td></td>
    </tr>
  </thead>
</table>
<?
}
//echo"<pre>";print_r($_POST);echo"</pre>";
?>

</div>

</div>
<div id='rodape'>
	<script>
	$("#centro_escolha").click(function(){
		$("#centro").show();$("#plano").hide();
	})
	
	$("#plano_escolha").click(function(){
		$("#centro").hide();$("#plano").show();
	})
		
	
	
</script>
</div>
