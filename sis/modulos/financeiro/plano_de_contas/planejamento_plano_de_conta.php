<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");
include("_ctrl.php"); 

$tabela = 'financeiro_centro_custo';
$plano_ou_centro = 'plano';

$ano=date('Y');
if($_GET[ano]){
	$ano = $_GET[ano];
}
$mes_atual=date('m');

function retornaFilhos($id){
	global $plano_ou_centro;
	$filho[]=$id;
	$q=mysql_query($tt="SELECT id FROM financeiro_centro_custo WHERE plano_ou_centro='$plano_ou_centro' AND centro_custo_id='$id' ") or die(mysql_error());
	while($f=mysql_fetch_object($q)){
		$filho[]=$f->id;
		$filhos=mysql_query("SELECT id FROM financeiro_centro_custo WHERE centro_custo_id='{$f->id}' ");
		if(mysql_num_rows($filhos)>0){
			
			$filho=array_merge($filho,retornaFilhos($f->id));
			
		}
		
	}
	return array_unique($filho);
}
?>
<style>
.pln input{ border:0; background:none; text-align:right; width:64px;}
</style>
<script src="<?=$caminho?>"></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>


<a href="?" class='s1'>
  	Sistema NV
</a>
<a href="?" class='s2'>
  	Financeiro
</a>
<a href="?tela_id=49" class='navegacao_ativo'>
<span></span>    Centro de Custos
</a>
</div>
<div id="barra_info">
 <!--<input name="" type="button" value="Salvar" onclick="location='?tela_id=83'" style="float:right; margin:3px 10px 0 0">-->
    
    Periodo
      
      <select name="anop" onchange="location='?tela_id=<?=$_GET[tela_id]?>&ano='+this.value">
      <?
      for($a=date(Y);$a<=date(Y)+3;$a++){
		  if($_GET[ano]==$a){$sel = 'selected="selected"';}else{$sel = '';}
	  ?>
    	<option value="<?=$a?>" <?=$sel?>><?=$a?></option>
       <?
       }
	   ?>
    </select>
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
          	<td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" class="pln">
    <thead>
    	<tr>
            <td width="209"><?=linkOrdem("Identificação","nome",1)?></td>
          	<td width="98">Janeiro</td>
          	<td width="98">Fevereiro</td>
          	<td width="98">Mar&ccedil;o</td>
          	<td width="98">Abril</td>
          	<td width="98">Maio</td>
          	<td width="98">Junho</td>
          	<td width="98">Julho</td>
          	<td width="98">Agosto</td>
          	<td width="98">Setembro</td>
          	<td width="98">Outubro</td>
          	<td width="98">Novemrbo</td>
          	<td width="98">Dezembro</td>
          	<td width="98">Total</td>
          	<td width=""></td>
			
        </tr>
    </thead>
    <tbody id="dados_tabela">
    <?
	function listarCentrosPlanejamento($id,$nivel){
	global $total;
	global $tabela; 
	global $plano_ou_centro;
	global $ano;
	global $total_ano;
	global $total_no_mes;
	global $totalgeral;
	
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
		
	/************ Filtros ************/
	$filtro_ano=" AND ano='$ano' ";
	if($_GET[ano]){$filtro_ano= " AND ano='$_GET[ano]' ";}
	/*********************************/
	
	while($r=mysql_fetch_object($q)){
		//retorna os filhos
		$pais_e_filhos=implode(',',retornaFilhos($r->id));
		
		//aplica cores
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		
		?>
    	<tr <?=$sel?>  >
        <td ><span style=" display:block; min-width:150px; overflow:hidden; margin-left:<?=$nivel*20?>px"><?=$r->ordem." - ".$r->nome?> </span></td>
        <?
		$valor_total=0;
		for($mes=0;$mes<12;$mes++){
				if($mes<10){$mes_q = '0'.$mes+1;}else{$mes_q=$mes+1;}
		$filtro_mes= " AND mes='$mes_q' ";
		
		$planejados = mysql_query($trace1="
		SELECT 
			SUM(valor) as valor
		FROM 
			financeiro_orcamento_centro
		WHERE 
		centro_plano_id in ($pais_e_filhos)
		$filtro_ano
		$filtro_mes
		") or die($trace1);
		
		$planejado=mysql_fetch_object($planejados);
		
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
		if($filhos->qtd>0){
			$dis='disabled="disabled"';
		}else{$dis='';}
		
		$valor_total+=$planejado->valor;
			if($nivel == 0)
				$total_no_mes[$mes]+=$planejado->valor;
		
		 ?>
          <td align="right" title="<?=$planejado->valor?>" ><input <?=$dis?> class="registro" onblur="atualizaDado(<?=$r->id?>,this,<?=$mes_q?>,<?=$ano?>)" type="text" value="<?=number_format($planejado->valor,2,',','.')?>"  /></td> 	
        <?	
		}

		
		
		
		?>
        <td align="right"><?
        $totalgeral[]=$valor_total;
		echo number_format($valor_total,2,',','.');
		?></td>
        <td>&nbsp;</td>
        
        </tr>
		<?
		
		
		if($filhos->qtd>0){
			listarCentrosPlanejamento($r->id,$nivel+1);
		}

		
	}
	
	
}//fim function listarCentros
listarCentrosPLanejamento(0,0);
	?>
    
    
    
    </tbody>
        <thead>
    	<tr id="linha_total">
            <td ><span style=" display:block; min-width:150px; overflow:hidden; margin-left:">Total</span></td>
            <td width="93"align="right"><?=number_format($total_no_mes[0],2,',','.')?></td>
          <td width="93"align="right"><?=number_format($total_no_mes[1],2,',','.')?></td>
          <td width="93"align="right"><?=number_format($total_no_mes[2],2,',','.')?></td>
          <td width="93"align="right"><?=number_format($total_no_mes[3],2,',','.')?></td>
          <td width="93"align="right"><?=number_format($total_no_mes[4],2,',','.')?></td>
          <td width="93"align="right"><?=number_format($total_no_mes[5],2,',','.')?></td>
          <td width="93"align="right"><?=number_format($total_no_mes[6],2,',','.')?></td>
          <td width="93"align="right"><?=number_format($total_no_mes[7],2,',','.')?></td>
          <td width="93"align="right"><?=number_format($total_no_mes[8],2,',','.')?></td>
          <td width="93"align="right"><?=number_format($total_no_mes[9],2,',','.')?></td>
            <td width="93"align="right"><?=number_format($total_no_mes[10],2,',','.')?></td>
        <td width="93"align="right"><?=number_format($total_no_mes[11],2,',','.')?></td>
        <td width="93"align="right"><?=number_format(@array_sum($totalgeral),2,',','.')?>&nbsp;</td>
          	<td>&nbsp;</td>
      </tr>
    </thead>

</table>
<?
//print_r($_POST);
?>
</div>



</div>
<script>
function atualizaDado(id,t,mes,ano){
	valor = t.value;
	
	
	window.open('modulos/financeiro/atualiza.php?id='+id+'&valor='+valor+'&mes='+mes+'&ano='+ano,'carregador');
	
	tabela = document.getElementById('dados_tabela');
	colunas= tabela.getElementsByTagName('tr');
	
	linha_atual = t.parentNode.parentNode;
	total = linha_atual.getElementsByTagName('td')[13];
	inputs=linha_atual.getElementsByTagName('input');
	
	
	coluna_totais=document.getElementById('linha_total').getElementsByTagName('td');
	
	valor_total_linha=0;
	
	for(i=0;i<12;i++){
		valor_total_linha += parseFloat(inputs[i].value.replace(',','.'));
		valor_total_coluna=0;
		for(y=0;y<colunas.length;y++){
			valor_total_coluna+= parseFloat(colunas[y].getElementsByTagName('input')[i].value.replace(',','.'));
		}
		coluna_totais[i+1].innerHTML=valor_total_coluna.toString().replace('.',',');
	}
	
	total.innerHTML = valor_total_linha.toString().replace('.',',');
	
	
	
}
</script>
<div id='rodape'>
	
</div>
