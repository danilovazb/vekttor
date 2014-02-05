<?
	include("../../../_config.php");
	include("../../../_functions_base.php");
	global $vkt_id;

$meses = array('1'=>"Janeiro",
						'2'=>"Fevereiro",
						'3'=>"Março",
						'4'=>"Abril",
						'5'=>"Maio",
						'6'=>"Junho",
						'7'=>"Julho",
						'8'=>"Agosto",
						'9'=>"Setembro",
						'10'=>"Outubro",
						'11'=>"Novembro",
						'12'=>"Dezembro");
?>
<style>
	*{
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
	}
	table{
		border-left:solid 1px #000000;
		border-top:solid 1px #000000;
	}
	thead{
		background-color:#CCC;
	}
	table tr td{
		border-right:solid 1px #000000;
		border-bottom:solid 1px #000000;
	}
	tbody{
		font-size:8px;
	}
</style>
<div id='dados'>
<?=date('d/m/Y')?><br>
<?=date('H:i:s')?>
<strong style="margin-left:200px;">
<?php
if(empty($_GET['status_ferias'])||$_GET['status_ferias']=='periodo_ferias'){
	echo "PREVISÃO DE FÉRIAS - REF : ".date('d/m/Y');
}else{
	echo "FUNCIONÁRIO EM FÉRIAS - REF : ".date('d/m/Y');
}
?>
</strong>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="60%">
    <thead>
    	<tr align="center">
            <td width="230">Funcionário</td>
            <td width="200">Funcão</td>
            <td width="50">Direito</td>
            <td width="50">Tiradas</td>
            <td width="60">Admissão</td>
            <td width="150">Período Vencido</td>
            <td width="130">Últimas Férias</td>
            <td width="130">Previsão Férias</td>
            <td width="100">Data Limite</td>
                     	
          
        </tr>
    </thead>
    <tbody>
	
	<?php
	
	$fim = "ORDER BY cf.id LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]);
	
	if(!empty($_GET['ano'])){
		$ano_filtro = $_GET['ano'];
		$ano = "YEAR(rf.data_admissao) < '$ano_filtro' AND";
	}else{
		$ano_filtro = date('Y');
		$ano = "YEAR(rf.data_admissao) < '$ano_filtro' AND";
	}
	
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND cf.razao_social like '%{$_GET[busca]}%'";
	}
	
	if($_GET['status_ferias']=='ferias'){
		$ano='';
		$tabela_ferias=", rh_ferias as rh_fe";
		$juncao_tabela_ferias="rf.id=rh_fe.funcionario_id AND";
		$mes_ferias = $_GET['mes_ferias'];
		$mes="MONTH(rh_fe.data_inicio) = '".$mes_ferias."' AND YEAR(rh_fe.data_inicio)='$ano_filtro' AND";
		$fim = " ORDER BY data_inicio_aquisicao DESC LIMIT 1";
	}
	
	//$_GET['mes_ferias'];
	if($_GET['status_ferias']=='periodo_ferias'){
		//echo $_GET['mes_ferias'];
		if($_GET['mes_ferias']==13){
			//echo "oi";
			$mes='';
		}else{
			$mes_ferias = $_GET['mes_ferias'];
			$mes="MONTH(rf.data_admissao) = '".$mes_ferias."' AND";
		}
		
	}
	
	
	if(empty($_GET['status_ferias'])){
		$mes_ferias = date('m')+1;
				
		$mes="MONTH(rf.data_admissao) = '".$mes_ferias."' AND";
		
	}
	
	
	
	if((empty($_GET['status_ferias'])||$_GET['status_ferias']=='periodo_ferias')&&$_GET['cliente_id']>0){
		$cliente = "cf.id='".$_GET['cliente_id']."' AND";
	}
	
	if($_GET['status_ferias']=='ferias'&&$_GET['cliente_id']>0){
		$cliente = "rh_fe.empresa_id='".$_GET['cliente_id']."' AND";
	}
		
	/*$registros= mysql_result(mysql_query("SELECT COUNT(*) FROM 
		rh_funcionario 
		WHERE 
		$mes
		vkt_id='$vkt_id'
		"),0,0);*/
	// colocar a funcao da paginaçao no limite
	$q= mysql_query($t="SELECT *, rf.id as funcionario_id FROM 
			rh_funcionario rf,
			cliente_fornecedor cf
			$tabela_ferias
		WHERE
		rf.status !='demitidos' AND
		rf.empresa_id = cf.id AND
		$juncao_tabela_ferias
		$cliente
		$mes
		$ano	
		rf.vkt_id='$vkt_id'
		$busca_add 
		$fim
		");
	$empresa_anterior = '';
	while($r=mysql_fetch_object($q)){
		
		//verifica há tempo o funcionário está na empresa
		$tempo_empresa = mysql_fetch_object(mysql_query($t="SELECT DATEDIFF(NOW(),'$r->data_admissao')/365 as diferenca"));
		
		//verifica quantas férias o funcionário tirou;
		$tirou_ferias = mysql_fetch_object(mysql_query($t="SELECT COUNT(*) as qtd_ferias FROM rh_ferias WHERE funcionario_id='$r->funcionario_id'"));
		
		$direito_ferias = $tempo_empresa->diferenca - $tirou_ferias->qtd_ferias;
		$direito_ferias = (int)$direito_ferias;
		
		if(!$tirou_ferias->qtd_ferias>0){
			
			$proximo_periodo_ferias = mysql_fetch_object(mysql_query($t="SELECT DATE_ADD('$r->data_admissao',INTERVAL 1 YEAR) as data_inicio,
																	 DATE_ADD(SUBDATE(DATE_ADD('$r->data_admissao',INTERVAL 1 MONTH),INTERVAL 1 DAY),INTERVAL 1 YEAR) as data_fim,
																	 DATE_ADD('$r->data_admissao',INTERVAL 22 MONTH) as data_inicio_maximo,
																	 DATE_ADD(SUBDATE(DATE_ADD('$r->data_admissao',INTERVAL 1 MONTH),INTERVAL 1 DAY),INTERVAL 22 MONTH) as data_fim_maximo"));
			
		}else{
			//verifica qual foi a última férias, para obter o período de aquisição
			$ultimo_periodo_ferias = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_ferias WHERE funcionario_id='$r->funcionario_id' ORDER BY id DESC LIMIT 1"));
			
			$proximo_periodo_ferias = mysql_fetch_object(mysql_query($t="SELECT DATE_ADD('$ultimo_periodo_ferias->data_inicio_aquisicao',INTERVAL 1 YEAR) as data_inicio,
																	DATE_ADD('$ultimo_periodo_ferias->data_fim_aquisicao',INTERVAL 1 YEAR) as data_fim,
																	DATE_ADD('$ultimo_periodo_ferias->data_inicio_aquisicao',INTERVAL 22 MONTH) as data_inicio_maximo,
																	DATE_ADD(SUBDATE(DATE_ADD('$ultimo_periodo_ferias->data_fim_aquisicao',INTERVAL 1 MONTH),INTERVAL 1 DAY),INTERVAL 22 MONTH) as data_fim_maximo"));
												
		}
		
		if((empty($_GET['status_ferias']) ||$_GET['status_ferias']=='periodo_ferias')&&($tirou_ferias->id>0)){
		}else{
						
			$total++;
			if($total%2){$sel='class="al"';}else{$sel='';}
		if($empresa_anterior!=$r->empresa_id){	
	?>
    <tr >
    	<td style="background-color:#999;color:#FFF;" colspan="10"><?=$r->razao_social?></td>
    </tr>
    <?
    		$empresa_anterior = $r->empresa_id;
		}
	?>
<tr <?=$sel?> onclick="window.open('modulos/rh/ferias/form.php?id=<?=$r->funcionario_id?>&data_admissao=<?=$r->data_admissao?>','carregador')">
			<td width="230"><?=$r->nome?>&nbsp;</td>
            <td width="200"><?=$r->cargo?>&nbsp;</td>
             <td width="50" align="center"><?=$direito_ferias?>&nbsp;</td>
            <td width="50" align="center"><?=$tirou_ferias->qtd_ferias?>&nbsp;</td>
            <td width="60" align="center"><?=DataUsaToBr($r->data_admissao)?>&nbsp;</td>
            <td width="150" style="font-size:10px;" align="center"><?php if($direito_ferias>0){ echo DataUsaToBr($proximo_periodo_ferias->data_inicio_maximo)." à ".DataUsaToBr($proximo_periodo_ferias->data_fim_maximo);}else{ echo "-";}?>&nbsp;</td>
            <td width="130"><?php if(isset($ultimo_periodo_ferias->data_inicio)){ echo DataUsaToBr($ultimo_periodo_ferias->data_inicio);}else{ echo "-";}?>&nbsp;</td>
            <td width="130"><?=DataUsaToBr($proximo_periodo_ferias->data_inicio)?>&nbsp;</td>
            <td width="100"><?=DataUsaToBr($proximo_periodo_ferias->data_inicio_maximo)?>&nbsp;</td>
            
           
           
</tr>
<?
		}
	}
	?>	
    </tbody>
 
</table>

</div>

</div>