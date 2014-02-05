<?
include("_functions.php");
include("_ctrl.php"); 

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

<script>

	$("#imprimir_recibo").live('click',function(){
	
	
		id = $(this).parent().parent().attr('id_ferias');
		
		window.open('modulos/rh/ferias/recibo_ferias.php?id='+id);
	
	});

</script>

<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>
<div id="barra_info">
<form method="get">
	<select name="status_ferias" id="status_ferias" style="margin-top:3px;"/>
      
		<option value="periodo_ferias">Previsão de Férias</option>
        <option value="ferias" <? if($_GET['status_ferias']=='ferias'){ echo "selected='selected'";}?>>Em Férias</option>
    </select>
        
	<select name="mes_ferias" id="mes_ferias" style="margin-top:3px;"/>
      <option value="13">Todos os Meses</option>
	<?php
    	for($i=1;$i<=sizeof($meses);$i++){
 			if(empty($_GET['mes_ferias'])&&$i==(date('m')+1)){
				
				$selected="selected='selected'";
				
			}else if($_GET['mes_ferias']==$i){
				
				$selected="selected='selected'";
				
			}
			echo "<option value='$i' $selected>".$meses[$i]."</option>";
			$selected='';
		}
	?>
    </select>
    
    <?
		$cliente_fornecedor = mysql_query($t=
		"SELECT 
			*, cf.id as cliente_id 
		FROM 
			rh_empresas re,
			cliente_fornecedor cf
		WHERE
			re.cliente_fornecedor_id = cf.id AND
			re.vkt_id='$vkt_id'
		");
		
	?>
    
    <labeL>
     <select name="cliente_id" id="cliente_id">
    	<option value="">Selecione uma Empresa</option>
        <?php
			while($cliente = mysql_fetch_object($cliente_fornecedor)){
				if($_GET['cliente_id']==$cliente->cliente_id){
					$selected = "selected='selected'";
				}
				echo "<option value='$cliente->cliente_id' $selected>$cliente->razao_social</option>";
				$selected='';
			}
		?>
    </select>
    </labeL>
    Ano: <input type="text" name="ano" id="ano" value="<?=$_GET['ano']?>" style="width:30px; height:10px;"/>
    <input type="submit" value="Filtrar"/>
    
    <button style="float:right; margin-top:2px; margin-right:5px;" class="botao_imprimir" onclick="window.open('modulos/rh/ferias/impressao_ferias.php?status_ferias='+$('#status_ferias').val()+'&mes_ferias='+$('#mes_ferias').val()+'&cliente_id='+$('#cliente_id').val()+'&ano='+$('#ano').val())" type="button">
	<img src="../fontes/img/imprimir.png">
</button>
    
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
</form>
  </div>

<div id='dados'>

<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="230">Funcionário</td>
            <td width="200">Funcão</td>
            <td width="50">Direito</td>
            <td width="50">Tiradas</td>
            <td width="60">Admissão</td>
            <td width="150">Período Vencido</td>
            <td width="130">Últimas Férias</td>
            <td width="130">Previsão Férias</td>
            <td width="100">Data Limite</td>
                     	
          
             <td></td>
        </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?php
	
	$fim = "ORDER BY cf.id LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]);
	
	if(!empty($_GET['ano'])){
		$ano_filtro = $_GET['ano'];
		$mes_filtro = $_GET['mes_ferias'];
		$ano = "YEAR(rf.data_admissao) < '$ano_filtro' AND";
	}else{
		$ano_filtro = date('Y');
		$mes_filtro = date('m')+1;
		$ano = "YEAR(rf.data_admissao) < '$ano_filtro' AND";
	}
	
	
	
	if($_GET['status_ferias']=='ferias'){
		$ano='';
		$tabela_ferias=", rh_ferias as rh_fe";
		$juncao_tabela_ferias="rf.id=rh_fe.funcionario_id AND";
		$mes_ferias = $_GET['mes_ferias'];
		$mes="MONTH(rh_fe.data_inicio) = '".$mes_ferias."' AND YEAR(rh_fe.data_inicio)='$ano_filtro' AND";
		$fim = " ORDER BY data_inicio_aquisicao";
	}
	if($_GET['status_ferias']=='periodo_ferias'){
			$mes_ferias = $_GET['mes_ferias'];
			$mes="MONTH(rf.data_admissao) = '".$mes_ferias."' AND";		
	}
	if(empty($_GET['status_ferias'])){
		$mes_ferias = date('m')+1;			
		$mes="MONTH(rf.data_admissao) = '".$mes_ferias."' AND";
		
	}
	// se eu selecionar um cliente em perioddo de ferias eu seleciono eu adiciono o cline
	if((empty($_GET['status_ferias'])||$_GET['status_ferias']=='periodo_ferias')&&$_GET['cliente_id']>0){
		$cliente = "cf.id='".$_GET['cliente_id']."' AND";
	}
	
	if($_GET['status_ferias']=='ferias'&&$_GET['cliente_id']>0){
		$cliente = "rh_fe.empresa_id='".$_GET['cliente_id']."' AND";
	}
		
	if(strlen($_GET[busca])>0){
		$busca_add = "AND cf.razao_social like '%{$_GET[busca]}%'";
	}
	
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
	//	echo $t;
	$empresa_anterior = '';
	while($r=mysql_fetch_object($q)){
		
		//verifica há tempo o funcionário está na empresa
		$tempo_empresa = mysql_fetch_object(mysql_query($t="SELECT DATEDIFF(NOW(),'$r->data_admissao')/365 as diferenca"));
		$emferias = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_ferias WHERE funcionario_id='$r->funcionario_id' AND YEAR(data_inicio)='$ano_filtro' AND MONTH (data_inicio)= '$mes_filtro'"));
		//echo $t." ".$emferias->id;
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
		
		if($_GET[status_ferias]=='ferias' || 
			(
				($_GET[status_ferias]=='periodo_ferias' || empty($_GET[status_ferias])) && $emferias->id<1
			)
		){
	?>
<tr <?=$sel?> onclick="window.open('modulos/rh/ferias/form.php?id=<?=$r->funcionario_id?>&data_admissao=<?=$r->data_admissao?>','carregador')">
			<td width="230"><?=$r->nome?></td>
            <td width="200"><?=$r->cargo?></td>
             <td width="50"><?=$direito_ferias?></td>
            <td width="50"><?=$tirou_ferias->qtd_ferias?></td>
            <td width="60"><?=DataUsaToBr($r->data_admissao)?></td>
            <td width="150"><?php if($direito_ferias>0){ echo DataUsaToBr($proximo_periodo_ferias->data_inicio_maximo)." à ".DataUsaToBr($proximo_periodo_ferias->data_fim_maximo);}else{ echo "-";}?></td>
            <td width="130"><?php if(isset($ultimo_periodo_ferias->data_inicio)){ echo DataUsaToBr($ultimo_periodo_ferias->data_inicio);}else{ echo "-";}?></td>
            <td width="130"><?=DataUsaToBr($proximo_periodo_ferias->data_inicio)?></td>
            <td width="100"><?=DataUsaToBr($proximo_periodo_ferias->data_inicio_maximo)?></td>
            
           
            <td></td>
</tr>
<?
		}
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