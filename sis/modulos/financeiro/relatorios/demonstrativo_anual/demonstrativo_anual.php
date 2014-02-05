<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");
include("modulos/financeiro/_ctrl_financeiro.php");
?>
<script src="../../../../modulos/financeiro/financeiro.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<script>
	$("#grafico").live("click",function(event){
		event.preventDefault();
		
		$(this).html("<strong>Fechar</strong>");
		$(this).addClass("fechar_grafico");
		$("#container_grafico").show();
		//$("#div_grafico").show();
		
	});//
	
	$(".fechar_grafico").live("click",function(){
		$("#container_grafico").hide();
		$(this).removeClass("fechar_grafico");
		$(this).html("Gráfico");
	});
	
	$("#up_saida").live("click",function(event){
		event.preventDefault();
		//$("#div_grafico").show();
		updateChart();
	});//
	
	$("#up_entrada").live("click",function(event){ //
		event.preventDefault();
		$("#div_grafico").show();
		drawChart();
	});//
	
	$("#saldo_up").live("click",function(event){ //saldo_up
		event.preventDefault();
		
		updateChart_1();
	});//
	
	
	
</script>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
#container_grafico{
position:absolute;float:right; right:5%; display:none; border:1px solid #999; background:#FFF; margin-top:4px;
-moz-box-shadow: 10px 10px 5px #888;
-webkit-box-shadow: 7px 7px 5px #888;
box-shadow: 7px 7px 5px #888; 	
}
</style>
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="?" class='s1'>
  	Financeiro
</a>
<a href="?" class='s2'>
  	Relatórios
</a>
<a href="?tela_id=82" class='navegacao_ativo'>
<span></span>    Demonstrativo Anual
</a>
</div>
<div id="barra_info">
    <a href="modulos/financeiro/form_movimentacao.php" target="carregador" class="mais"></a>
<button style="float:right; margin-top:2px; margin-right:5px;" class="botao_imprimir" onclick="window.open('modulos/tela_impressao.php?url=')" type="button">
	<img src="../fontes/img/imprimir.png">
</button>
<form style=" margin:0; padding:0; " method="get"> 
    Filtrar:
      <select name="tipo" id="tipo">
      	<option value="nulo">Escolha o filtro</option>
        <option value="centro" id="centro_escolha" title="Centro de Custo" <? if($_GET[tipo]=='centro'){echo 'selected="selected"';$tipo_escolhido = "Centro de Custo";} ?> >Centro de Custo</option>
        <option value="plano" id="plano_escolha" title="Plano de Conta" <? if($_GET[tipo]=='plano'){echo 'selected="selected"';$tipo_escolhido = "Plano de Contas";} ?> >Plano de Contas</option>
        <option value="cliente" id="cliente_escolha" title="Cliente/Fornecedor" <? if($_GET[tipo]=='cliente'){echo 'selected="selected"';$tipo_escolhido = "Cliente/Fornecedor";} ?> >Cliente/Fornecedor</option>
      </select> 
      <label id="centro" <? if($_GET[tipo]!='centro'){ ?> style="display:none;" <? } ?> >Centro de Custo:
      <select name="centro">
		  <? 
          $query_escolha = mysql_query("SELECT id,nome FROM financeiro_centro_custo WHERE centro_custo_id='0' AND plano_ou_centro='centro' AND cliente_id='$vkt_id'"); 
          while($f = mysql_fetch_object($query_escolha)){
			  
		  $query_sub = mysql_query("SELECT id, nome FROM financeiro_centro_custo WHERE centro_custo_id='{$f->id}' AND cliente_id='$vkt_id'"); 
		  if(mysql_num_rows($query_sub)>0){$tem_sub=true;}
          ?>
          <option <? if($tem_sub){?> style="font-weight:bolder;" <? } ?> <? if($_GET[centro]==$f->id){echo "selected";$tipo_escolhido2=$f->nome;} ?> value="<?=$f->id?>"> <?=$f->nome?> </option>
          <? 
		  
		  if($tem_sub){
			  while($sub=mysql_fetch_object($query_sub)){
				  ?><option style="margin-left:10px;" <? if($_GET[centro]==$sub->id){echo "selected";$tipo_escolhido2=$sub->nome;} ?>  value="<?=$sub->id?>"> - <?=$sub->nome?> </option> <?
			  }
		  }
		  $tem_sub=false;
		  
          } ?>
      </select>
  </label>
  
  <label id="plano" <? if($_GET[tipo]!='plano'){ ?> style="display:none;" <? } ?> >Plano de Conta:
      <select name="plano">
		  <? 
          $query_escolha = mysql_query("SELECT id,nome FROM financeiro_centro_custo WHERE centro_custo_id='0' AND plano_ou_centro = 'plano' AND  cliente_id='$vkt_id'"); 
          while($f = mysql_fetch_object($query_escolha)){
			  
		  $query_sub = mysql_query("SELECT id, nome FROM financeiro_centro_custo WHERE centro_custo_id='{$f->id}' AND cliente_id='$vkt_id'"); 
		  if(mysql_num_rows($query_sub)>0){$tem_sub=true;}
          ?>
          <option <? if($tem_sub){?> style="font-weight:bolder;" <? } ?> <? if($_GET[plano]==$f->id){echo "selected";$tipo_escolhido3=$f->nome;} ?> value="<?=$f->id?>"> <?=$f->nome?> </option>
          <? 
		  
		  if($tem_sub){
			  while($sub=mysql_fetch_object($query_sub)){
				  ?><option style="margin-left:10px;" <? if($_GET[plano]==$sub->id){echo "selected";$tipo_escolhido3=$sub->nome;} ?> value="<?=$sub->id?>"> - <?=$sub->nome?> </option> <?
			  }
		  }
		  $tem_sub=false;
		  
          } ?>
      </select>
  </label>
  
  <label id="cliente" <? if($_GET[tipo]!='cliente'){ ?> style="display:none;" <? } ?> >Cliente:
      <input name="cliente" type="hidden" id="internauta_id" title='<?=$cliente->razao_social?>' value="<?=$_GET[cliente]?>" />
			  <input name="cliente_nome" id="cliente_nome" value="<?=$_GET[cliente_nome]?>" busca='modulos/financeiro/busca_clientes.php,@r0 @r2,@r1-value>internauta_id|@r0-title>internauta_id,0' valida_minlength='5'retorno='focus|Busque o nome do Cliente' autocomplete='off'>
  </label>
  <? if($_GET[ano]){$ano_inicial=$_GET[ano];}else{$ano_inicial=date('Y');}?>
  <label>Contas
  	<select name="conta">
    <option value="0" <? if($_GET[conta]==0||empty($_GET[conta])){echo "selected='seelcted'";$conta_escolhida="Todas";} ?>>Todas</option>
    <? $contas_q=mysql_query("SELECT * FROM financeiro_contas WHERE cliente_vekttor_id ='$vkt_id' ORDER BY nome ASC"); while($contas=mysql_fetch_object($contas_q)){ ?>
    <option <? if($_GET[conta]==$contas->id){echo "selected";$conta_escolhida=$contas->nome;} ?> value="<?=$contas->id?>"><?=$contas->nome?></option>
    <? 
		
	} ?>
    </select>
  </label>
  
  <input name="ano" value="<?=$ano_inicial?>" size="5" maxlength="4"  mascara='____' style="height:11px;  margin:0; padding:0" >
    
    <input type="hidden" name="tela_id" value="82" />
<input type="submit" name="button" id="button" value="Filtrar" />

 <button style="float:right; margin-top:3px;" id="grafico">Gráfico</button>
    <div id="container_grafico" style="">
    	<div style="padding:5px 8px 7px; border-bottom:1px solid #CCC;">
        	<button style="border:1px solid #CCC;"  id="up_entrada">Entrada</button>
        	<button style="border:1px solid #CCC;"  id="up_saida">Saída</button>
            <button style="border:1px solid #CCC;"  id="saldo_up" >Saldo</button>
            <div style="float:right; color:#999; text-transform:capitalize;"><?=$_SESSION['usuario']->login?></div>	
        </div>
        
    	<div id='div_grafico'></div> 
    </div>

</form>


</div>

<div id="dados">
<div id="info_filtro">
<?=$template_cabecalho_impressao?>
Relatório Anual.<br />

<?php
 if($_GET['tipo']=='plano'){
 	$sub_plano = $tipo_escolhido3;
 }else
 if($_GET['tipo']=='centro'){
 	$sub_plano = $tipo_escolhido2;
 }
 echo "$tipo_escolhido $sub_plano $_GET[cliente_nome] <strong>Conta: </strong>
$conta_escolhida <strong>Ano: </strong>$ano_inicial";?>
</div>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<script>
function opf(id){
	window.open('modulos/financeiro/form_movimentacao.php?id='+id,'carregador')
}
</script>
	<table cellpadding="0" cellspacing="0" width="100%" >
    <thead>
    	<tr>
    	  <td width="200">Mês</td>
		  <td width="140" align="right" style="padding-right:5px;" >Entrada</td>
          <td width="140" align="right" style="padding-right:5px;" >Saída</td>
          <td width="140" align="right" style="padding-right:5px;" >Saldo</td>
          <td></td>
        </tr>
    </thead>
</table>
    <table cellpadding="0" cellspacing="0" width="100%"  >
        <tbody>
        <?
			
			if($_GET[tipo]=='centro'){$filtro_pai = $_GET[centro];$filtro_tabela='centro';}
			if($_GET[tipo]=='plano'){$filtro_pai = $_GET[plano];$filtro_tabela='plano';}
			if(!isset($_GET[tipo]) || $_GET[tipo]=='nulo'){$filtro_pai=0;$filtro_tabela='centro';}else {$filtro_tabela_ex=" AND plano_ou_centro='{$filtro_tabela}' ";}
			
			/**************função para fazer a soma incluindo as subcategorias***********/
			function retornaFilhos($id){
				global $vkt_id;
				global $filtro_tabela_ex;
				global $filtro_tabela;
				global $plano_ou_centro;
				global $total_entrada;
				global $total_saida;
				global $total_saldo;
				global $nomea;
				global $valorentrada;
				global $valorsaida;
				global $valorsaldo;
				$filho[]=$id;
				$q=mysql_query($tt="SELECT id FROM financeiro_centro_custo WHERE cliente_id='$vkt_id'  AND centro_custo_id='$id' $filtro_tabela_ex   ") or die(mysql_error());
				
				while($f=mysql_fetch_object($q)){
					$filho[]=$f->id;
					/*
					*/
					$filhos=mysql_query("SELECT id FROM financeiro_centro_custo WHERE  cliente_id='$vkt_id' AND centro_custo_id='{$f->id}' ");
					if(mysql_num_rows($filhos)>0){
						
						$filho=array_merge($filho,retornaFilhos($f->id));
						
					}
					
				}
				return array_unique($filho);
			}
			/***************************************************/
			
			if($_GET[conta]!=0){
				$filtro_conta=" AND m.conta_id='{$_GET[conta]}'";
			}
			$linha_contagem=0;
			$meses_extenso=array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
			if($_GET[ano])$ano=$_GET[ano];else $ano=date('Y');
			for($mes=0;$mes<12;$mes++){
				if($mes<10){$mes_q = '0'.$mes+1;}else{$mes_q=$mes+1;}
				if($linha_contagem%2){$class=" class = 'al' ";}else{$class="";}
			
			
			
        ?>	
            <tr <?=$class?> >
          	<?
			/*
			
			
			
			*/
			
			
			//if($_GET[tipo]=='centro'){
			if($_GET[tipo]!='cliente' || !isset($_GET[tipo])){
			$pais_e_filhos=implode(',',retornaFilhos($filtro_pai));
			$q_entradas = mysql_query($tracecentro="
				SELECT
					SUM(c.valor) as valor
				FROM
					financeiro_{$filtro_tabela}_has_movimento as c,
					financeiro_movimento as m
				WHERE
					c.plano_id IN ($pais_e_filhos)
				AND
					c.movimento_id = m.id
				AND
					m.tipo='receber'
				AND
					month(m.data_info_movimento)='$mes_q'
				AND
					YEAR(m.data_info_movimento)='$ano'
				AND 
					m.status ='1' 
				AND 
					m.movimentacao = 'financeiro' 
				AND
					m.cliente_id='$vkt_id'
				$filtro_conta
				") or die(mysql_error());
				//echo $tracecentro.'<br>';
			$q_saidas = mysql_query($tracecentro="
				SELECT
					SUM(c.valor) as valor
				FROM
					financeiro_{$filtro_tabela}_has_movimento as c,
					financeiro_movimento as m
				WHERE
					c.plano_id IN ($pais_e_filhos)
				AND
					c.movimento_id = m.id
				AND
					m.tipo='pagar'
				AND
					month(m.data_info_movimento)='$mes_q'
				AND
					YEAR(m.data_info_movimento)='$ano'
					AND 
					m.status ='1' 
				AND 
					m.movimentacao = 'financeiro' 
				AND
					m.cliente_id='$vkt_id'

			$filtro_conta
				") or die(mysql_error());
				//echo $tracecentro.'<br>';
			}
			
			if($_GET[tipo]=='cliente'){
			$q = mysql_query($tracecliente="
				SELECT
					SUM(m.entrada) as entrada, SUM(m.saida) as saida
				FROM
					financeiro_movimento as m
				WHERE
					m.internauta_id='$_GET[cliente]'
				AND
					month(m.data_info_movimento)='$mes_q'
				AND
					YEAR(m.data_info_movimento)='$ano'
				AND 
					m.status ='1' 
				AND 
					m.movimentacao = 'financeiro' 
				AND
					m.cliente_id='$vkt_id'
				$filtro_conta
			") or die(mysql_error());
			//echo $tracecliente;
			}	
			?>
			<td width="200"><?=$nomea[] = $meses_extenso[$mes*1]?></td>
            <?
			if($_GET[tipo]!='cliente' || !isset($_GET[tipo])){
				$entradas=mysql_fetch_object($q_entradas);
				$saidas=mysql_fetch_object($q_saidas);
			}elseif($_GET[tipo]=='cliente')$cliente=mysql_fetch_object($q);
			?>
            <td width="140" style="text-align:right; padding-right:5px;">
            <?
			if($_GET[tipo]!='cliente' || !isset($_GET[tipo])){
				$entrada=$entradas->valor;
				$valorentrada[] =$entradas->valor;
			}elseif($_GET[tipo]=='cliente')$entrada=$cliente->entrada;
			echo number_format($entrada,2,',','.');
			?>
            </td>
            <td width="140" style="text-align:right; padding-right:5px;">
            <?
			if($_GET[tipo]!='cliente' || !isset($_GET[tipo])){
				$saida=$saidas->valor;
				$valorsaida[] = $saidas->valor;
			}elseif($_GET[tipo]=='cliente')$saida=$cliente->saida;
			echo number_format($saida,2,',','.');
			?>
            </td>
            <td width="140" style="text-align:right; padding-right:5px;">
            
            <? 
			 
			$saldo=$entrada-$saida; echo number_format($saldo,2,',','.'); 
			$valorsaldo[] = $saldo;
			?>
            
            </td>
            <td></td>
            
            </tr>
           <?
		   $total_entrada += $entrada; 
		   $total_saida += $saida;
		   $total_saldo += $saldo;
		   $linha_contagem++; } ?>
            
        </tbody>
    </table>
</div>
<script>
	  
	  google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
	  
	  function drawChart() {
        // Create the data table.
        
		var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Entrada');
        data.addRows([
		
         <? for($i= 0; $i < count($nomea);$i++){ 
			if(!empty($valorentrada[$i])){
		 ?>
          ['<?=$nomea[$i]?>', <?=$valorentrada[$i]?>],
         
		<? 
			}
		}
		?> 
		  
        ]);
		
		
        var options = {
          width: 350, height: 200,
          title: '% Centro de custos - ENTRADA'
        };	

        var chart = new google.visualization.ColumnChart(document.getElementById('div_grafico'));
        chart.draw(data, options);
      }
	  
	  // function to update the chart with new data.
      function updateChart() {
       
          dataTable = new google.visualization.DataTable();
		  
		  var data = new google.visualization.DataTable();
		  data.addColumn('string', 'Topping');
		  data.addColumn('number', 'Saída ');
		  data.addRows([
		
         <? for($i= 0; $i < count($nomea);$i++){ 
			if(!empty($valorsaida[$i])){
		 ?>
          ['<?=$nomea[$i]?>', <?=$valorsaida[$i]?>],
         
		<? 
			}
		}
		?> 
		  
        ]);

        var options = {
          width: 350, height: 200,
          title: '% Centro de custos - SAÍDA'
        };	

        var chart = new google.visualization.ColumnChart(document.getElementById('div_grafico'));
        chart.draw(data, options);
      } //
	   // function to update the chart with new data.
      function updateChart_1() {
       		
		
		
		 dataTable = new google.visualization.DataTable();
		  
		  var data = new google.visualization.DataTable();
		  data.addColumn('string', 'Topping');
		  data.addColumn('number', 'Saldo ');
		  data.addRows([
		
         <? for($i= 0; $i < count($nomea);$i++){ 
			if(!empty($valorsaldo[$i])){
		 ?>
          ['<?=$nomea[$i]?>', <?=$valorsaldo[$i]?>],
         
		<? 
			}
		}
		?> 
		  
        ]);
     

        var options = {
          width: 350, height: 200,
          title: '% Centro de custos - SALDO'
        };	

        var chart = new google.visualization.ColumnChart(document.getElementById('div_grafico'));
        chart.draw(data, options);
      }
</script>


<div id="total">
<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
        	<td width="200">Total dos meses</td>
          <td width="140" style="text-align:right; padding-right:5px;">R$<?=number_format($total_entrada,2,',','.')?></td>
          <td width="140" style="text-align:right; padding-right:5px;">R$<?=number_format($total_saida,2,',','.')?></td>
          <td width="140" style="text-align:right; padding-right:5px;">R$<?=number_format($total_saldo,2,',','.')?></td>
            <td></td>
        </tr>
    </thead>
</table>
</div>
<p>&nbsp;</p>
</div>
<div id='rodape'>
	<div id='rodape'>
	<script>
	$("#centro_escolha").click(function(){
		$("#centro").show();$("#plano").hide();$("#cliente").hide();
	})
	
	$("#plano_escolha").click(function(){
		$("#centro").hide();$("#plano").show();$("#cliente").hide();
	})
		
	
		
	$("#cliente_escolha").click(function(){
		$("#centro").hide();$("#plano").hide();$("#cliente").show();
	})
		
</script>
</div>
