<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");
include("_functions.php"); 
include("_ctrl.php"); 
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="?" class='s2'>
  	Financeiro
</a>
<a href="?tela_id=50" class='navegacao_ativo'>
<span></span>Centro de Custos
</a>
</div>
<div id="barra_info">
    <a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
    <input name="" type="button" value="Planejamento" onclick="location='?tela_id=83'" style="float:right; margin:3px 10px 0 0">

    
    
    <form method="get">
      <? 
	  if($_GET['mes']>0){
		  $mes_atual=$_GET['mes'];
	  }else{
		  $mes_atual=date('m'); 
	  }
	  if($_GET['ano']>0){
		  $ano_atual=$_GET['ano'];
	  }else{
		  $ano_atual=date('Y');
	  }
	  
	  ?>
      <select name="mes">
    	<option value="1" <? if($mes_atual=='1')echo "selected='selected'";?> >Janeiro</option>
    	<option value="2" <? if($mes_atual=='2')echo "selected='selected'"; ?> >Fevereiro</option>
    	<option value="3" <? if($mes_atual=='3')echo "selected='selected'"; ?> >Março</option>
    	<option value="4" <? if($mes_atual=='4')echo "selected='selected'"; ?> >Abril</option>
    	<option value="5" <? if($mes_atual=='5')echo "selected='selected'"; ?>>Maio</option>
    	<option value="6" <? if($mes_atual=='6')echo "selected='selected'"; ?>>Junho</option>
    	<option value="7" <? if($mes_atual=='7')echo "selected='selected'"; ?>>Julho</option>
    	<option value="8" <? if($mes_atual=='8')echo "selected='selected'"; ?>>Agosto</option>
    	<option value="9" <? if($mes_atual=='9')echo "selected='selected'"; ?>>Setembro</option>
    	<option value="10" <? if($mes_atual=='10')echo "selected='selected'"; ?>>Outubro</option>
    	<option value="11" <? if($mes_atual=='11')echo "selected='selected'"; ?>>Novembro</option>
    	<option value="12" <? if($mes_atual=='12')echo "selected='selected'"; ?>>Dezembro</option>
    </select>
    <select name="ano" style="width:60px">
              <?
      for($i=date("Y");$i>date("Y")-5;$i--){
		  if($ano==$i){$sel= 'selected'; }else{$sel ='';}
		echo "<option value='$i'".$ano_s[$i]." $ano>$i</option>";  
		}
	  ?>

    </select>
     <label>
  	<select name="conta" style="width:120px">
    <option value="0">Todas as Contas</option> 
    <? $contas_q=mysql_query("SELECT * FROM financeiro_contas WHERE cliente_vekttor_id  ='$vkt_id' ORDER BY nome ASC"); while($contas=mysql_fetch_object($contas_q)){ ?>
    <option <? if($_GET[conta]==$contas->id)echo "selected"; ?> value="<?=$contas->id?>"><?=$contas->nome?></option>
    <? } ?>
    </select>
    </label>
  <label>
  	<select name="plano" style="width:120px">
    	<option value="0">Plano de Contas</option>

		<? 
		
		exibe_option_sub_plano_ou_centro2('plano',0,$_GET['plano'],0,'');
		?>
    </select>
  </label>
   <label>Efetivado:
  	<select name="efetivado">
    	<option value="2" <? if(empty($_GET[efetivado])||$_GET[efetivado]==2)echo "selected"; ?>>Ambos</option>
        <option value="1" <? if($_GET[efetivado]=='1')echo "selected"; ?>>Sim</option>
        <option value="0" <? if($_GET[efetivado]=='0')echo "selected"; ?>>Não</option>
    </select>
  </label>
  

  
   </label>
    <input type="hidden" name="tela_id" value="50" />
    <input type="submit" name="filtrar" value="filtrar" />
	</form>
	
</div>


<?
		function retornaFilhos($id,$tipo){
			$filho[]=$id;
			$q=mysql_query($tt="SELECT id FROM financeiro_centro_custo WHERE plano_ou_centro='$tipo' AND centro_custo_id='$id' ") or die(mysql_error());
			
			while($f=mysql_fetch_object($q)){
				$filho[]=$f->id;
				/*
				*/
				$filhos=mysql_query("SELECT id FROM financeiro_centro_custo WHERE centro_custo_id='{$f->id}' ");
				if(mysql_num_rows($filhos)>0){
					
					$filho=array_merge($filho,retornaFilhos($f->id,$tipo));
					
				}
				
			}
			return array_unique($filho);
		}
?>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="209"><?=linkOrdem("Identificação","nome",1)?></td>
          	<td width="98" align="right">Entradas</td>
       	  <td width="98" align="right">Saidas</td>
       	  <td width="98" align="right">Saldo</td>
       	  <td width="98" align="right">Planejado</td>
       	  <td width="98" align="right">Diferença</td>
          <td width="110" align="right">% entrada</td>
          <td width="110" align="right">% saída</td>
          	<td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_valores">
    <tbody>
	<?
	
	
	
	// necessario para paginacao
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="nome";
	}
	
	
	function listarCentros($id,$nivel){
	global $total_entrada;
	global $total_saida;
	global $caminho;
	global $tabela; 
	global $plano_ou_centro;
	global $total;
	global $mes_atual;
	global $ano_atual;
	$filtro_centro_custo=" AND centro_custo_id='$id'"; 
	// colocar a funcao da paginação no limite
	$q= mysql_query($trace="
	SELECT 
	 *
	FROM
		$tabela
	WHERE 
		plano_ou_centro='$plano_ou_centro'  
	AND 
		cliente_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'
		
	$filtro_centro_custo
	
	ORDER BY 
		ordem,nome") or die(mysql_error());
	if(isset($_GET[efetivado]) && $_GET[efetivado]!=2){$filtro_efetivado=" AND fm.status='{$_GET[efetivado]}' ";}else{ $filtro_efetivado=" AND fm.status<'2' ";}
	if($_GET[conta]!=0){$filtro_conta=" AND fm.conta_id='{$_GET[conta]}'";}
	
	if($_GET[ano]){$ano=$_GET[ano];}else{$ano=date('Y');}
	if($_GET[mes]){$mes=$_GET[mes];if($_GET[mes]<10){$mes='0'.$mes;}}else{$mes=date('m');}
	
	$filtro_ano="AND DATE_FORMAT(fm. data_movimento ,'%Y')='$ano'";
	$filtro_p_ano="AND ano='$ano' ";
	$filtro_mes= " AND DATE_FORMAT(fm. data_movimento ,'%m')='$mes' ";
	$filtro_p_mes="AND mes='$mes'";
	
	while($r=mysql_fetch_object($q)){
		$pais_e_filhos=implode(',',retornaFilhos($r->id,'centro'));
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		
		if($_GET['plano']!=0){
			$filhos=implode(',',retornaFilhos($_GET[plano],'plano'));
			$adc_tabela=", financeiro_plano_has_movimento as fpm";
			$filtro="AND fcm.movimento_id = fpm.movimento_id AND fpm.plano_id in ($filhos)";
		}
		
		$entradas = mysql_query($trace1="
		SELECT 
			SUM(fcm.valor) as valor
		FROM 
			financeiro_centro_has_movimento as fcm, financeiro_movimento as fm
			$adc_tabela
		WHERE 
			fcm.plano_id in ($pais_e_filhos)
		AND 
			fcm.movimento_id = fm.id
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
			SUM(fcm.valor) as valor
		FROM 
			financeiro_centro_has_movimento as fcm, financeiro_movimento as fm
			$adc_tabela
		WHERE 
			fcm.plano_id in ($pais_e_filhos)
		AND 
			fcm.movimento_id = fm.id
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
		" SELECT * FROM financeiro_orcamento_centro WHERE centro_plano_id in ($pais_e_filhos) $filtro_p_ano $filtro_p_mes "
		);
		$entrada=mysql_fetch_object($entradas);
		$saida=mysql_fetch_object($saidas) or die(mysql_error());
		$valor_planejado=mysql_fetch_object($planejado);
		
		if(  (($_GET[efetivado]==1||$_GET[efetivado]==0)&&($entrada->valor!=0 || $saida->valor!=0)) || ($_GET[efetivado]==2||!isset($_GET[efetivado]))   ){
		?>
    	<tr <?=$sel?>>
          <td width="209" onclick="window.open('<?=$caminho?>form.php?id=<?=$r->id?>','carregador')"><span style="margin-left:<?=$nivel*20?>px"><?=$r->ordem." - ".$r->nome?> </span></td>
          <td width="98" align="right" title="<?=$entrada->valor?>" ><?=number_format($entrada->valor,2,',','.')?></td>
       	  <td width="98" align="right" title="<?=$saida->valor?>" ><?=number_format($saida->valor,2,',','.')?></td>
       	  <td width="98" align="right" title="<?=$entrada->valor - $saida->valor?>"  onclick="abrirHistorico(<?=$r->id?>,'<?=$plano_ou_centro?>');" ><?=number_format($entrada->valor - $saida->valor,2,',','.')?></td>
       	  <td width="98" align="right" ><?=number_format($valor_planejado->valor,2,',','.')?></td>
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
			centro_custo_id='{$r->id}' ");
		$filhos=mysql_fetch_object($filhos_query);
		
		
		?>
        <td width=""></td>
        
        </tr>
		<?
		/* Somar total somente pelas categorias "pai", que tem o nivel 0 */
		if($nivel==0){$total_entrada+=$entrada->valor;$total_saida+=$saida->valor;}	
				if($filhos->qtd>0){
					listarCentros($r->id,$nivel+1);
				}
		}else{$total--;}
		
	}
	
	
}//fim function listarCentros

listarCentros(0,0);
?>
    	
    </tbody>
</table>
<?
//print_r($_POST);
?>
</div>

<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="209">Total</td>
            <td width="98"align="right" id="total_entrada" title="<?=$total_entrada?>"><?=number_format($total_entrada,2,',','.')?></td>
            <td width="98"align="right" id="total_saida" title="<?=$total_saida?>"><?=number_format($total_saida,2,',','.')?></td>
            <td width="98"align="right" id="total_saldo" title="<?=$total_entrada-$total_saida?>"><?=number_format($total_entrada-$total_saida,2,',','.')?></td>
            <td width="98"align="right">&nbsp;</td>
            <td width="98"align="right">&nbsp;</td>
            <td width="98"align="right">&nbsp;</td>
          	<td width=""></td>
      </tr>
    </thead>
</table>
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
	window.location="?tela_id=85&tipo="+tipo+"&centro="+id+"&filtro=historico";
}
</script>
</div>
<div id='rodape'>
	
</div>
