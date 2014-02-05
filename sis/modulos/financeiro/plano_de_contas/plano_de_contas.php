<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");
include("_functions.php"); 
include("_ctrl.php"); 
	if($_GET[ano]){$ano=$_GET[ano];}else{$ano=date('Y');}
	if($_GET[mes]){$mes=$_GET[mes];if($_GET[mes]<10){$mes='0'.$mes;}}else{$mes=date('m');}
?>
<!--<script type="text/javascript" src="https://www.google.com/jsapi"></script>-->
<script>
$(".plano_id").live('change',function(){
	info = $(".plano_id option:selected").attr('ordenacao');
	if(info.length>0){
	 $("#plano_ordem").html(info+'.');
	}else{
	 $("#plano_ordem").html(info);
	}
	
});
</script>

<script>
	$("#grafico").live("click",function(event){
		event.preventDefault();
		$("#container_grafico").show();
		
	});//
	
	$("#container_grafico .close").live("click",function(){
		$("#container_grafico").hide();
	});
	
	/* ENTRADA */
	$("#up_entrada").live("click",function(event){
		event.preventDefault();
		updateChart_6();
	});
	$("#up_entrada_pai").live("click",function(event){
		event.preventDefault();
		//updateChart_6();
		drawChart();
	});
	
	/* Valor SAIDA */
	$("#up_saida").live("click",function(event){
		event.preventDefault();
		updateChart();
	});
	$("#up_saida_pai").live("click",function(event){
		event.preventDefault();
		updateChart_5();
	});// up_saida_pai
	
	/* SALDO */
	$("#saldo_up").live("click",function(event){
		event.preventDefault();
		updateChart_1();
	});
	
	$("#saldo_up_pai").live("click",function(event){
		event.preventDefault();
		updateChart_4();
	});
	
	/* Planejado */
	$("#planejado_up_pai").live("click",function(event){
		event.preventDefault();
		updateChart_2();
	});
	$("#planejado_up_filho").live("click",function(event){
		event.preventDefault();
		updateChart_3();
	}); 
	
	// planejado_x_realizado
	$("#planejado_x_realizado").live("click",function(event){
		event.preventDefault();
		updateChart_7();
	}); //
	$("#planejado_x_realizado_filho").live("click",function(event){
		event.preventDefault();
		updateChart_8();
	}); //planejado_x_realizado_filho
	
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
#container_grafico{position:absolute; top:10%; left:22%;display:none; border:1px solid #999; background:#FFF; margin-top:4px;width:790px;max-height:650px;-moz-box-shadow: 0 0 5px #888;-webkit-box-shadow: 0 0 5px#888;box-shadow: 0 0 5px #888;}
#container_grafico .close{color:#CCC;float:right;padding-right:10px;font-size:16px;}
#container_grafico .close:hover{cursor:pointer;}
#container_grafico span { color:#CCC; }
.btn-group{position: relative; display: inline-block;*display: inline;*margin-left: .3em;font-size: 0;white-space: nowrap;vertical-align: middle;*zoom: 1;}
.btn-group:first-child {*margin-left: 0;}
.btn-group + .btn-group {margin-left: 5px;}
.btn-group .btn{margin-left: 5px; padding:2px;}
.btn-group > .btn {position: relative;-webkit-border-radius: 0;-moz-border-radius: 0;border-radius: 0;}
.btn-group > .btn + .btn {margin-left: -1px;}
.btn-group + .btn-group {margin-left: 5px;}
.btn-group > .btn:last-child {-webkit-border-top-right-radius: 4px;border-top-right-radius: 4px;-webkit-border-bottom-right-radius: 4px;border-bottom-right-radius: 4px;-moz-border-radius-topright: 4px;-moz-border-radius-bottomright: 4px;}
.btn-group > .btn:first-child {margin-left: 0;-webkit-border-bottom-left-radius: 4px;border-bottom-left-radius: 4px;-webkit-border-top-left-radius: 4px;border-top-left-radius: 4px;-moz-border-radius-bottomleft: 4px;
 -moz-border-radius-topleft: 4px;}
.btn-group > .btn:hover,
.btn-group > .btn:focus,
.btn-group > .btn:active,
.btn-group > .btn.active {z-index: 3;}

/* para outra tela*/
@media only screen
and (min-width : 1440px) {
	#container_grafico{
		width:1100px;
		left:20%;
	}
}
</style>
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="?" class='s2'>
  	Financeiro
</a>
<a href="?tela_id=51" class='navegacao_ativo'>
<span></span>    Plano de Contas
</a>
</div>
<div id="barra_info">
    <a href="modulos/financeiro/plano_de_contas/form.php" target="carregador" class="mais"></a>

    <input name="" type="button" value="Planejamento" onclick="location='?tela_id=84'" style="float:right; margin:3px 10px 0 0">

    
    <form method="get">
    
    <? 
	if($_GET[ano]){$ano=$_GET[ano];}else{$ano=date('Y');}
	if($_GET[mes]){$mes=$_GET[mes];if($_GET[mes]<10){$mes='0'.$mes;}}else{$mes=date('m');}
	 ?>
       <select name="mes">
    	<option value="1" <? if($mes=='1')echo "selected='selected'";?> >Janeiro</option>
    	<option value="2" <? if($mes=='2')echo "selected='selected'"; ?> >Fevereiro</option>
    	<option value="3" <? if($mes=='3')echo "selected='selected'"; ?> >Março</option>
    	<option value="4" <? if($mes=='4')echo "selected='selected'"; ?> >Abril</option>
    	<option value="5" <? if($mes=='5')echo "selected='selected'"; ?>>Maio</option>
    	<option value="6" <? if($mes=='6')echo "selected='selected'"; ?>>Junho</option>
    	<option value="7" <? if($mes=='7')echo "selected='selected'"; ?>>Julho</option>
    	<option value="8" <? if($mes=='8')echo "selected='selected'"; ?>>Agosto</option>
    	<option value="9" <? if($mes=='9')echo "selected='selected'"; ?>>Setembro</option>
    	<option value="10" <? if($mes=='10')echo "selected='selected'"; ?>>Outubro</option>
    	<option value="11" <? if($mes=='11')echo "selected='selected'"; ?>>Novembro</option>
    	<option value="12" <? if($mes=='12')echo "selected='selected'"; ?>>Dezembro</option>
    </select>
      <input type="text" name="ano" id="ano" style=" width:40px;height:10px;" value="<?=$ano?>">
      <!--  <? $ano_atual=date('Y'); ?>
         <?
      for($i=date("Y");$i>date("Y")-5;$i--){
		  if($ano==$i){$sel= 'selected'; }else{$sel ='';}
		echo "<option value='$i'".$ano_s[$i]." $ano>$i</option>";  
		}
	  ?>
      </select>-->
      <label>
  	<select name="conta" style=" width:120px">
    <option value="0">Todas as Contas</option>
    <? $contas_q=mysql_query("SELECT * FROM financeiro_contas WHERE cliente_vekttor_id  ='$vkt_id' ORDER BY nome ASC"); while($contas=mysql_fetch_object($contas_q)){ ?>
    <option <? if($_GET[conta]==$contas->id)echo "selected"; ?> value="<?=$contas->id?>"><?=$contas->nome?></option>
    <? } ?>
    </select>
  </label>
  <label>
  	<select name="centro" style=" width:120px">
    	<option value="0">Centro de Custos</option>
        <? 
		$plano_q=mysql_query("SELECT * FROM  financeiro_centro_custo WHERE  cliente_id='$vkt_id'  AND plano_ou_centro='centro' "); 
		while($plano=mysql_fetch_object($plano_q)){?>
        <option <? if($_GET[centro]==$plano->id)echo "selected"; ?> value="<?=$plano->id?>"><?=$plano->nome?></option>
		<? }
		?>
    </select>
  </label>
   <label>
  	<select name="efetivado">
    	<option value="" <? if(empty($_GET[efetivado])){ echo "selected='selected'";}?>>Efetivado</option>
        <option value="2" <? if($_GET[efetivado]==2)echo "selected='selected'"; ?>>Ambos</option>
        <option value="1" <? if($_GET[efetivado]=='1')echo "selected"; ?>>Sim</option>
        <option value="0" <? if($_GET[efetivado]=='0')echo "selected"; ?>>Não</option>
    </select>
  </label>
  
  <label>
  	<select name="exibir_soma">
    	<option value="">Exibir</option>
    	<option value="sim" <? if($_GET[exibir_soma]=='sim')echo "selected"; ?>>Sim</option>
        <option value="nao" <? if($_GET[exibir_soma]=='nao')echo "selected"; ?>>Não</option>
    </select>
  </label>
    <input type="hidden" name="tela_id" value="51" />
    
    <input type="submit" name="filtrar" value="filtrar" />
    <button type="button" onclick="window.open('modulos/tela_impressao.php?url=<? //$url?>')" class="botao_imprimir" style="float:right; margin-top:2px; margin-right:5px;" >
	<img src="../fontes/img/imprimir.png" />
	</button>
    
    
     <button style="float:right; margin-top:3px;" rel="tip" id="grafico" title="Gráfico" data-placement="bottom" ><img src="../fontes/img/grafico.ico" height="15"></button>
    <div id="container_grafico">
    	<div style="padding:5px 8px 7px; border-bottom:1px solid #CCC;">
            
            <div class="btn-group">
        	<button style="border:1px solid #CCC;" class="btn" id="up_entrada_pai">Entrada Pai</button>
        	<button style="border:1px solid #CCC;" class="btn" id="up_entrada">Entrada</button> 
            </div>
            
            <div class="btn-group">
            <button style="border:1px solid #CCC;" class="btn"  id="up_saida_pai">Saída Pai</button>
            <button style="border:1px solid #CCC;" class="btn"  id="up_saida">Saída</button> 
            </div>
            
            <div class="btn-group">
            <button style="border:1px solid #CCC;" class="btn"  id="saldo_up_pai">Saldo Pai </button>
            <button style="border:1px solid #CCC;" class="btn" id="saldo_up">Saldo</button> 
            </div>
           
           <div class="btn-group">
        	<button style="border:1px solid #CCC;" class="btn" id="planejado_up_pai">Planejado Pai</button>
            <button style="border:1px solid #CCC;" class="btn"  id="planejado_up_filho">Planejado</button>
            <button style="border:1px solid #CCC;" class="btn"  id="planejado_x_realizado">Pla. x Rea.</button>
            <button style="border:1px solid #CCC;" class="btn"  id="planejado_x_realizado_filho">Pla. x Rea. filhos</button>
           </div>
           
           
            <div class="close"> x </div>
        </div>
    	<div id='div_grafico' ></div>
        
        
         
    </div>
    
	</form>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="209"><?=linkOrdem("Identificação","nome",1)?></td>
          	<td width="98" align="right">Entradas</td>
       	  <td width="98" align="right">Saidas</td>
       	  <td width="98" align="right">Saldo</td>
       	  <td width="98" align="right">Planejado</td>
       	  <td width="98" align="right">Diferen;ca</td>
       	  <td width="110" align="right">% entrada</td>
          <td width="110" align="right">% saída</td>
          	<td class="wp"></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<div id="info_filtro">
<?=$template_cabecalho_impressao?>
<?php
if(empty($_GET['mes'])){
	$mes_filtro = date('m');
	
}else{
	$mes_filtro = $_GET['mes'];
}
if(empty($_GET['ano'])){
	$ano_filtro = date('Y');
}else{
	$ano_filtro = $_GET['ano'];
}	
	$ultimo_dia = date('t',	"$ano_filtro-$mes_filtro-01");
	echo "<h3><strong>Plano de Contas <br />De 01/$mes_filtro/$ano_filtro até $ultimo_dia/$mes_filtro/$ano_filtro</strong></h3>";
?>
</div>


<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_valores">
    <tbody>
    
    <?
		function retornaFilhos($id,$tipo){
			
			$filho[]=$id;
			$q=mysql_query($tt="SELECT id FROM financeiro_centro_custo WHERE plano_ou_centro='$tipo' AND centro_custo_id='$id' ") or die(mysql_error());
			while($f=mysql_fetch_object($q)){
				$filho[]=$f->id;
				/*
				*/
				$filhos=mysql_query($t="SELECT id FROM financeiro_centro_custo WHERE centro_custo_id='{$f->id}' ");
				if(mysql_num_rows($filhos)>0){
					$filho=array_merge($filho,retornaFilhos($f->id,$tipo));
					
				}
				
			}
			return array_unique($filho);
		}	
	// necessario para paginacao
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="nome";
	}
	
	function listarCentros($id,$nivel,$pai){
		
	global $total_entrada;
	global $total_saida;
	global $caminho;
	global $tabela; 
	global $plano_ou_centro;
	global $total;
	global $mes;
	global $ano;
	
	global $valorentrada;
	
	global $valorentrada_pai;
	global $valorsaida;
	global $valorsaida_pai;
	global $valorsaldo;
	global $valorsaldo_pai;
	global $valorsaldo_filho;
	
	global $valorplanejado;
	global $valorplanejado_pai;
	global $nomea;
	global $nomepai;
	global $nomefilho;
	
	global $valorplanejado_filho;
	
	global $pl_saldo;
	global $pl_planejado;

	if(isset($_GET[exibir_soma])){$filtro_exibir_soma="exibir_soma='{$_GET[exibir_soma]}' AND";}else{$filtro_exibir_soma="exibir_soma='sim' AND ";}	
	$filtro_centro_custo=" AND centro_custo_id='$id'"; 
	
	// colocar a funcao da paginação no limite
	$q= mysql_query($trace="
	SELECT 
	 *
	FROM
		$tabela
	WHERE
		$filtro_exibir_soma
		plano_ou_centro='$plano_ou_centro' AND 
		cliente_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'
	$filtro_centro_custo
	ORDER BY 
		ordem,nome") or die(mysql_error());
		
	if(isset($_GET[efetivado]) && $_GET[efetivado]!=2){$filtro_efetivado=" AND fm.status='{$_GET[efetivado]}' ";}else{ $filtro_efetivado=" AND fm.status<'2' ";}
	if($_GET[conta]!=0){$filtro_conta=" AND fm.conta_id='{$_GET[conta]}'";}
		
	
	$filtro_ano="AND DATE_FORMAT(fm. data_info_movimento ,'%Y')='$ano'";
	$filtro_p_ano="AND ano='$ano' ";
	$filtro_mes= " AND DATE_FORMAT(fm. data_info_movimento ,'%m')='$mes' ";
	$filtro_p_mes="AND mes='$mes'";
	
	while($r=mysql_fetch_object($q)){
		
		$temfilhos = count(retornaFilhos($r->id,'plano'));
		
		$pais_e_filhos=implode(',',retornaFilhos($r->id,'plano'));
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		
		if($_GET['centro']!=0){
			$filhos=implode(', ',retornaFilhos($_GET['centro'],'centro'));
			$adc_tabela=", financeiro_centro_has_movimento as fcm";
			$filtro="AND fpm.movimento_id = fcm.movimento_id AND fcm.plano_id in ($filhos) ";
		}
		
		$entradas = mysql_query($trace1="
		SELECT 
			SUM(fpm.valor) as valor
		FROM 
			financeiro_plano_has_movimento as fpm, financeiro_movimento as fm 
			$adc_tabela
		WHERE 
			fpm.plano_id in ($pais_e_filhos)
		AND 
			fpm.movimento_id = fm.id
		AND
			fm.tipo='receber'
		AND 
			fm.extorno='0'
		$filtro
		$filtro_ano $filtro_mes
		$filtro_conta
		$filtro_efetivado
		");
		//echo $trace1;
		$saidas = mysql_query($trace2="
		SELECT 
			SUM(fpm.valor) as valor
		FROM 
			financeiro_plano_has_movimento as fpm, financeiro_movimento as fm
			$adc_tabela
		WHERE 
			fpm.plano_id in ($pais_e_filhos)
		AND 
			fpm.movimento_id = fm.id
		AND
			fm.tipo='pagar'
		AND 
			fm.extorno='0'
		$filtro
		$filtro_ano $filtro_mes
		$filtro_conta
		$filtro_efetivado
		");
		
		$planejado= mysql_query(
		" SELECT *, SUM(valor) AS valor FROM financeiro_orcamento_centro WHERE centro_plano_id in ($pais_e_filhos) $filtro_p_ano $filtro_p_mes "
		);
		$entrada=mysql_fetch_object($entradas);
		$saida=mysql_fetch_object($saidas) or die(mysql_error());
		$valor_planejado=mysql_fetch_object($planejado);
		
		//if(  (($_GET[efetivado]==1||$_GET[efetivado]==0)&&($entrada->valor!=0 || $saida->valor!=0)) || ($_GET[efetivado]==2||!isset($_GET[efetivado]))   ){
		if(  (($_GET[efetivado]==1||$_GET[efetivado]==0)) || ($_GET[efetivado]==2||!isset($_GET[efetivado]))   ){
			if(strlen($pai)>0){
				$ordenacao = $pai.'.'.$r->ordem;
			
			}else{
				$ordenacao = $r->ordem;
			}
		
		?>
		
    	<tr <?=$sel?> >
          <td width="209" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')" ><span style="margin-left:<?=$nivel*20?>px">
		  <? 
		  	$nomea[]=$r->nome;
			if($nivel==0){
				$nomepai[]=$r->nome;
		 	 echo "<strong>".$ordenacao." - ".$r->nome. "</strong>";
			} else {
				$nomefilho[]=$r->nome;
				echo $ordenacao." - ".$r->nome;	
			}
		  ?> </span></td>
          <td width="98" align="right" title="<?=$entrada->valor?>" >
		  <? // VALOR ENTRADA 
           if($temfilhos>1){
			  $valorentrada[]=0;
			  echo number_format($entrada->valor,2,',','.');
		   } else {
			 echo number_format($valorentrada[]=$entrada->valor,2,',','.');
		   }
		  //verifia o nivel
		  if($nivel==0){
			  $valorentrada_pai[] = $entrada->valor;
		  }else{
			  $valorentrada_pai[] = 0;
		  }
		  //number_format($valorentrada[]=$entrada->valor,2,',','.')?>
          </td>
       	  <td width="98" align="right" title="<?=$saida->valor?>" >
		  <? 
		  // VALOR SAIDA  
		  
		  if($temfilhos>1){
			  $valorsaida[]=0;
			  echo number_format($saida->valor,2,',','.');
		   } else {
			 echo number_format($valorsaida[]=$saida->valor,2,',','.');
		   }
		  //verifia o nivel
		  if($nivel==0){
			  $valorsaida_pai[] = $saida->valor;
		  }else{
			  $valorsaida_pai[] = 0;
		  }
		  ?>
          </td>
       	  <td width="98" align="right" title="<?=$entrada->valor - $saida->valor?>" onclick="abrirHistorico(<?=$r->id?>,'<?=$plano_ou_centro?>')" >
		  <?
		  // SALDO
		  
		  if($temfilhos>1){
			  $valorsaldo[]=0;
			  echo number_format($entrada->valor - $saida->valor,2,',','.');
		   } else {
			 echo number_format($valorsaldo[]=$entrada->valor - $saida->valor,2,',','.'); 
			 $valorsaldo_filho[]=$entrada->valor - $saida->valor;
		   }
		  //verifia o nivel
		  if($nivel==0){
			  $valorsaldo_pai[] = $entrada->valor - $saida->valor;
			  $pl_saldo[] = $entrada->valor - $saida->valor;
		  }else{
			  $valorsaldo_pai[] = 0;
		  }
		  
		  ?>
          </td>
          
       	  <td width="98" align="right" ><?
		 // echo "($temfilhos)"; PLANEJADO
		  if($temfilhos > 1){
			$valorplanejado[]=0;
		  	echo "<b>".number_format($valor_planejado->valor,2,',','.')."</b>";
			
		  }else{
		  	echo "(".number_format($valor_planejado->valor,2,',','.'). ")";
			$valorplanejado[] = abs($valor_planejado->valor);
			$valorplanejado_filho[] = abs($valor_planejado->valor);
		  }
		  
			 
		  if($nivel==0){
			  $pl_planejado[] = $valor_planejado->valor;
			  $valorplanejado_pai[] = abs($valor_planejado->valor);
		  }else{
			  $valorplanejado_pai[] = 0;
		  }
			 
		  ?></td>
       	  <td width="98" align="right" ><?=number_format(($entrada->valor-$saida->valor)-$valor_planejado->valor,2,',','.')?></td>
       	  <td width="110" align="right" >(calcular)</td>  	
          <td width="110" align="right" >(calcular)</td>  	
          	
        
<?
			
		$filhos_query=mysql_query($conta="
		SELECT 
			COUNT(*) as qtd 
		FROM 
			$tabela 
		WHERE 
			
			plano_ou_centro='$plano_ou_centro' 
		AND 
			cliente_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'
		AND 
			centro_custo_id='{$r->id}' 
		");
		$filhos=mysql_fetch_object($filhos_query);
		
		?>
        	<td class="wp"></td>
        </tr>
		<?
		if($nivel==0){$total_entrada+=$entrada->valor;$total_saida+=$saida->valor; }
			if($filhos->qtd>0){
				if(strlen($pai)>0){
					$ordenacao =$pai.'.'.$r->ordem;
				}else{
					$ordenacao =$r->ordem;
				}
				listarCentros($r->id,$nivel+1,$ordenacao);
			}
		}else{
			$total--;
		}
		
	}
	
	
}//fim function listarCentros

listarCentros(0,0,'');

?>
    	
    </tbody>
</table>
<?
//print_r($_POST);

?>
<table cellpadding="0" cellspacing="0" width="100%" >
    <thead>
    	<tr>
            <td width="209">Total</td>
            <td width="98"align="right" id="total_entrada" title="<?=$total_entrada?>"><?=number_format($total_entrada,2,',','.')?></td>
            <td width="98"align="right" id="total_saida" title="<?=$total_saida?>"><?=number_format($total_saida,2,',','.')?></td>
            <td width="98"align="right" id="total_saldo" title="<?=$total_entrada-$total_saida?>"><?=number_format($total_entrada-$total_saida,2,',','.')?></td>
            <td width="98"align="right"><?=number_format(@array_sum($valorplanejado_pai),2,',','.')?></td>
            <td width="98"align="right">&nbsp;</td>
            <td width="98"align="right">&nbsp;</td>
          	<td class="wp"></td>
      </tr>
    </thead>
</table>
</div>
<script>
	  
	  google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
	  
	  function drawChart() {
        // Create the data table.
        
		var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Entrada Pai');
        data.addRows([
		<? 
		 //arsort($valorentrada);
		 arsort($valorentrada_pai);
		 
		 $nova_ordem = array_keys($valorentrada_pai);
		 for($i= 0; $i < count($nomea);$i++){
			 
			 $nome = $nomea[$nova_ordem[$i]];
			 $valor = $valorentrada_pai[$nova_ordem[$i]];
			 
			 if(!empty($valor)){
		 ?>
          ['<?=$nome?>', <?=$valor?>],
		 <? 
			 }
		    }
		?> 
        ]);
		
		

        var options = {
          width: 605, height: 500,
          title: '% Centro de custos - ENTRADA PAI'
        };	

        var chart = new google.visualization.PieChart(document.getElementById('div_grafico'));
        chart.draw(data, options);
      }
	  
	  //Valor Entrada Pai
	  function updateChart_6() {
       
        dataTable = new google.visualization.DataTable();  
		var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Entrada');
        data.addRows([
         <? 
		
		 arsort($valorentrada);
		
		 $nova_ordem = array_keys($valorentrada);
		 for($i= 0; $i < count($nomea);$i++){
			 
			 $nome = $nomea[$nova_ordem[$i]];
			 $valor = $valorentrada[$nova_ordem[$i]];
			 
			 if(!empty($valor)){
		 ?>
          ['<?=$nome?>', <?=$valor?>],
         
		<? 
			 }
		    }
		?> 
        ]);

        var options = {
          width: 600, height: 500,
          title: '% Centro de custos - ENTRADA'
        };	

        var chart = new google.visualization.PieChart(document.getElementById('div_grafico'));
        chart.draw(data, options);
      
      }
	  
	  // function to update the chart with new data.
      function updateChart() {
       
          dataTable = new google.visualization.DataTable();
		  
		 var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
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
          width: 605, height: 500,
          title: '% Centro de custos - SAÍDA'
        };	

        var chart = new google.visualization.PieChart(document.getElementById('div_grafico'));
        chart.draw(data, options);
      
      }
	  // Valor Saida PAI
	   function updateChart_5() {
       
        dataTable = new google.visualization.DataTable();  
		var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Saída pai');
        data.addRows([
         <? 
		
		 arsort($valorsaida_pai);
		
		 $nova_ordem = array_keys($valorsaida_pai);
		 for($i= 0; $i < count($nomea);$i++){
			 
			 $nome = $nomea[$nova_ordem[$i]];
			 $valor = $valorsaida_pai[$nova_ordem[$i]];
			 
			 if(!empty($valor)){
		 ?>
          ['<?=$nome?>', <?=$valor?>],
         
		<? 
			 }
		    }
		?> 
        ]);

        var options = {
          width: 600, height: 500,
          title: '% Centro de custos - SAÍDA PAI'
        };	

        var chart = new google.visualization.PieChart(document.getElementById('div_grafico'));
        chart.draw(data, options);
      
      } 
	  
	  // Valor SALDO 
      function updateChart_1() {
       
        dataTable = new google.visualization.DataTable();  
		var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Saldo filhos');
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
          width: 600, height: 500,
          title: '% Centro de custos - SALDO - FILHO'
        };	

        var chart = new google.visualization.ColumnChart(document.getElementById('div_grafico'));
        chart.draw(data, options);
      
      }
	  // Valor Saldo PAI 
	  function updateChart_4() {
       
        dataTable = new google.visualization.DataTable();  
		var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Saldo pai');
        data.addRows([
         <? 
		 echo "/*";
		 print_r($valorsaldo_pai);
		 echo "*/";
		 
		 arsort($valorsaldo_pai);
		 
		
		 $nova_ordem = array_keys($valorsaldo_pai);
		 for($i= 0; $i < count($nomea);$i++){
			 
			 $nome = $nomea[$nova_ordem[$i]];
			 $valor = $valorsaldo_pai[$nova_ordem[$i]];
			 
			 if(!empty($valor)){
		 ?>
          ['<?=$nome?>', <?=$valor?>],
         
		<? 
			 }
		    }
		?> 
        ]);

        var options = {
          width: 600, height: 500,
          title: '% Centro de custos - SALDO - PAI'
        };	

        var chart = new google.visualization.ColumnChart(document.getElementById('div_grafico'));
        chart.draw(data, options);
      
      }
	  
	  // Planejado Pai
      function updateChart_2() {
       
        dataTable = new google.visualization.DataTable();  
		var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
         <? 
		 echo "/*";
		 //print_r($nomea);
		 //print_r($valorplanejado_pai);
		 arsort($valorplanejado_pai);
		 //print_r($valorplanejado_pai);
		 echo "*/";
		 $nova_ordem = array_keys($valorplanejado_pai);
		 for($i= 0; $i < count($nomea);$i++){
			 
			 $nome = $nomea[$nova_ordem[$i]];
			 $valor = $valorplanejado_pai[$nova_ordem[$i]];
			 
			 if(!empty($valor)){
		 ?>
          ['<?=$nome?>', <?=$valor?>],
         
		<? 
			 }
		    }
		?> 
        ]);

        var options = {
          width: 600, height: 500,
          title: '% Centro de custos - PLANEJADO'
        };	

        var chart = new google.visualization.PieChart(document.getElementById('div_grafico'));
        chart.draw(data, options);
      
      }
	  
	  // Planejado Filho
      function updateChart_3() {
       
        dataTable = new google.visualization.DataTable();  
		var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
         <? 
		
		 arsort($valorplanejado);
		 
		 $nova_ordem = array_keys($valorplanejado);
		   for($i= 0; $i < count($nomea);$i++){
					 
		   $nome = $nomea[$nova_ordem[$i]];
		   $valor = $valorplanejado[$nova_ordem[$i]];
					 
			 if(!empty($valor)){
				 ?>
				  ['<?=$nome?>', <?=$valor?>],
				 
				<? 
			  }
		    }
				?> 
        ]);

        var options = {
          width: 600, height: 500,
          title: '% Centro de custos - PLANEJADO-FILHO'
        };	

        var chart = new google.visualization.PieChart(document.getElementById('div_grafico'));
        chart.draw(data, options);
      
      }
	  
	  //PLANEJADO VS REALIZADO
	  function updateChart_7() {
       
       				// Create and populate the data table.
			  var data = google.visualization.arrayToDataTable([
				['Mês', 'Saldo', 'Planejados'],
				<?
					arsort($pl_planejado);
					
					$nova_ordem = array_keys($pl_planejado);
					
					for($i=0;$i < count($pl_planejado);$i++){
						 
						 $valor = $pl_planejado[$nova_ordem[$i]];
						 $valor_saldo = $pl_saldo[$nova_ordem[$i]];
								 
				?>
				['<?=$nomepai[$nova_ordem[$i]]?>', <?=abs($valor_saldo)?>, <?=abs($valor)?> ],
				<?	
						
					}
				?>
			  ]);

			  // Create and draw the visualization.
			  var ac = new google.visualization.ComboChart(document.getElementById('div_grafico'));
			  ac.draw(data, {
				title : 'Planejados VS Realizados',
				chartArea:{left:15,top:30,width:"80%",height:"80%"},
				vAxis: {title: "Cups"},
				seriesType: "bars",
				series: {2: {type: "line"}}
			  });
      
      }
	  
	  //PLANEJADO VS REALIZADO FILHO
	  function updateChart_8() {
       
       				// Create and populate the data table.
			  var data = google.visualization.arrayToDataTable([
				['Mês', 'Saldo', 'Planejados'],
				<?
					echo "/* ";
					//print_r($valorplanejado_filho);
					echo "*/";
					arsort($valorplanejado_filho);
					
					$nova_ordem = array_keys( $valorplanejado_filho );
					
					for($i=0;$i < count($valorplanejado_filho);$i++){
						 
						 $valor = $valorplanejado_filho[$nova_ordem[$i]];
						 $valor_saldo = $valorsaldo_filho[$nova_ordem[$i]];
						//if(!empty($valor) and !empty($valor_saldo)){		 
				?>
				['<?=$nomefilho[$nova_ordem[$i]]?>', <?=abs($valor_saldo)?>, <?=abs($valor)?> ],
				<?	
						//}
					}
				?>
			  ]);

			  // Create and draw the visualization.
			  var ac = new google.visualization.ComboChart(document.getElementById('div_grafico'));
			  ac.draw(data, {
				title : 'Planejados VS Realizados',
				chartArea:{left:15,top:30,width:"80%",height:"80%"},
				vAxis: {title: "Cups"},
				seriesType: "bars",
				series: {2: {type: "line"}}
			  });
      
      }

</script>
<div id="rodape_plano_contas">
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="209">Total</td>
            <td width="98"align="right" id="total_entrada" title="<?=$total_entrada?>"><?=number_format($total_entrada,2,',','.')?></td>
            <td width="98"align="right" id="total_saida" title="<?=$total_saida?>"><?=number_format($total_saida,2,',','.')?></td>
            <td width="98"align="right" id="total_saldo" title="<?=$total_entrada-$total_saida?>"><?=number_format($total_entrada-$total_saida,2,',','.')?></td>
            <td width="98"align="right"><?=number_format(@array_sum($valorplanejado_pai),2,',','.')?></td>
            <td width="98"align="right">&nbsp;</td>
            <td width="98"align="right">&nbsp;</td>
          	<td width=""></td>
      </tr>
    </thead>
</table>
</div>
<script>
var linhas = document.getElementById('tabela_valores').getElementsByTagName('tr');
var total_entrada = parseFloat(document.getElementById('total_entrada').getAttribute('title'));
var total_saida = parseFloat(document.getElementById('total_saida').getAttribute('title'));
for(var i=0;i<linhas.length;i++){
	saldo_entrada = parseFloat(linhas[i].getElementsByTagName('td')[1].getAttribute('title'));
	saldo_saida = parseFloat(linhas[i].getElementsByTagName('td')[2].getAttribute('title'));
	
	if(!isNaN(saldo_entrada)){
		
	perc_entrada=(saldo_entrada*100)/total_entrada;}else{perc_entrada=0;}
	if(!isNaN(saldo_saida)){
	perc_saida=(saldo_saida*100)/total_saida;}else{perc_saida=0;}
	
	linhas[i].getElementsByTagName('td')[6].innerHTML=perc_entrada.toFixed(2).replace('.',',');
	linhas[i].getElementsByTagName('td')[7].innerHTML=perc_saida.toFixed(2).replace('.',',');
}
function abrirHistorico(id,tipo){
	window.location="?tela_id=85&tipo="+tipo+"&"+tipo+"="+id+"&filtro=historico&filtro_inicio=01/<?="$mes/$ano"?>&filtro_fim=31/<?="$mes/$ano"?>&data_informativo=data_info_movimento";
}
</script>
</div>
<div id='rodape'>
	
</div>
