<?
if($_GET['empresa_id']>0){
	$empresa_id=$_GET['empresa_id'];
	$cliente_empresa=mysql_fetch_object(mysql_query("SELECT *, cf.id as id, re.id as empresa_id FROM cliente_fornecedor as cf, rh_empresas as re WHERE cf.cliente_vekttor_id='$vkt_id' AND cf.id='$empresa_id' AND re.cliente_fornecedor_id = cf.id LIMIT 1"));
	$configuracao=mysql_fetch_object(mysql_query($a="SELECT * FROM rh_folha_ponto_configuracao WHERE vkt_id='$vkt_id' AND empresa_id='$cliente_empresa->empresa_id' LIMIT 1"));
}
if(strlen($_GET['data_ini'])>0 && strlen($_GET['data_fim'])>0){
	$data_ini=dataBrTousa($_GET['data_ini']);
	$data_fim=dataBrTousa($_GET['data_fim']);
	$data_ini_br=$_GET['data_ini'];
	$data_fim_br=$_GET['data_fim'];
	$str_info_data="$data_ini_br à $data_fim_br";
}else{
	if($empresa_id>0){
		$hoje_dia_semana=mysql_result(mysql_query("SELECT DATE_FORMAT(NOW(),'%w')"),0);
		$inicio_dia_semana_config=$configuracao->semana_inicio;
		if($hoje_dia_semana<$inicio_dia_semana_config){
			$dif=$inicio_dia_semana_config-$hoje_dia_semana;
			$data_ini=mysql_result(mysql_query($a="SELECT DATE_ADD(DATE_SUB(NOW(), INTERVAL 1 WEEK), INTERVAL $dif DAY) "),0);
			$data_fim=mysql_result(mysql_query($b="SELECT DATE_ADD('$data_ini', INTERVAL 6 DAY) "),0);
		}else{
			$dif=$hoje_dia_semana-$inicio_dia_semana_config;
			$data_ini=mysql_result(mysql_query($a="SELECT DATE(DATE_SUB(NOW(), INTERVAL $dif DAY)) "),0);
			$data_fim=mysql_result(mysql_query($b="SELECT DATE_ADD('$data_ini', INTERVAL 6 DAY) "),0);
			echo mysql_error();
		}
		$data_ini_br=dataUsaToBr($data_ini);
		$data_fim_br=dataUsaToBr($data_fim);
		$str_info_data="$data_ini_br à $data_fim_br";
	}else{
		$data_ini_br='';
		$data_fim_br='';
	}
}

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id='form_documento'></div>
<div id="some">«</div>
<a href="?" class='s1'>
  	Sistema
</a>
<a href="?" class='s1'>
  	RH
</a>
<a href="?" class='s2'>
  	Relatórios
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
<style>
.btf{ display:block; float:left; width:15px; height:15px; background-image:url(../fontes/img/formatacao.gif);margin-top:5px;text-decoration:none;}
	.bold{ background-position:-2px -17px;}
	.italic{ background-position:-20px -17px; }
	.underline{ background-position:-58px -16px;}
	.justifyleft{ background-position:-2px 0px;margin-left:50px}
	.justifycenter{ background-position:-20px 0px;}
	.justifyright{ background-position:-38px 0px;}
	.justifyfull{ background-position:-57px 0px;}
	.insertunorderedlist{background-position:-19px -51px;margin-left:50px;}
	.insertorderedlist{ background-position:-37px -51px;}
</style>

<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" /><input type="hidden" name="empresa1id" value="<?=$_GET['empresa1id']?>" />
   
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>
<div id="barra_info"> 
<form style="float:left; margin:0; padding:0;">
<input type="hidden" value="<?=$tela->id?>" name="tela_id" />
<label>Empresa
    <select name="empresa_id">
    <?
$empresas= mysql_query($t="
		SELECT 
			*, 
			cf.id as cliente_forencedor_id, 
			re.id as empresa_id 
		FROM 
			rh_empresas re,
			cliente_fornecedor cf 
		WHERE 
			re.cliente_fornecedor_id = cf.id AND
			cf.tipo='Cliente' AND 
			cf.tipo_cadastro='Jurídico' AND 
			re.vkt_id ='$vkt_id' AND 
			re.status='1' 
			$busca_add 
			$filtro 
		ORDER BY 
			razao_social 
		ASC
		
		");
			while($empresa=mysql_fetch_object($empresas)){
				if($empresa_id==$empresa->id){$sel="selected='selected'";$emp_sel=$empresa->nome_fantasia;}else{$sel='';}
?>
    	<option <?=$sel?> value="<?=$empresa->cliente_forencedor_id?>"><?=$empresa->nome_fantasia?></option>
        <? } ?>
    </select>
</label>  
<label>
Data início <input id="data_ini" name="data_ini" style="width:80px; height:11px; margin:0; padding:0;" calendario="1" mascara="__/__/____" type="text" value="<?=($data_ini_br)?>" />
</label>
<label>
Data fim <input id="data_fim" name="data_fim" style="width:80px; height:11px;margin:0; padding:0;" calendario="1" mascara="__/__/____" type="text" value="<?=($data_fim_br)?>" />
</label>
<input type="submit" name="acao" value="Filtrar" />
</form>   
	<button style="float:right; margin-top:2px; margin-right:5px;" class="botao_imprimir" onclick="window.open('modulos/tela_impressao.php?url=')" type="button">
	<img src="../fontes/img/imprimir.png">
	</button>
  </div>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
 <div id="info_filtro">
 	<h1>Relatório de Faltas</h1>
	<div style="clear:both"></div>
    <strong>Empresa:</strong>
    <?=$emp_sel?> 
	<div style="clear:both"></div>
    <strong>De:</strong> <?=$data_ini_br?> <strong>Até:</strong> <?=$data_fim_br?>
	<div style="clear:both"></div>
	<?=date('d/m/Y')?>
 	<div style="clear:both"></div>
    <?=date('H:i:s')?>
    
 </div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	
    	<tr>
        	
            <td width="250">Funcion&aacute;rio</td>
            <td width="100">Faltas <!--no período<?=$str_info_data?>--></td>
             <td width="100">Justificadas</td>
             <td width="100">Não Justificadas</td>
          	<td class="wp"></td>
			
        </tr>
    </thead>
</table>
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <?

	if($empresa_id>0){
		
		
		$empresa_id=$_GET['empresa_id'];
		$registros=@mysql_result(mysql_query($t="
		SELECT
			COUNT(rx.falta_integral) as faltas, COUNT(rx.falta_justificada) as falta_justificada 
		FROM
			rh_hora_extra as rx,
			rh_funcionario as rf
		WHERE
			rx.vkt_id='$vkt_id'
		AND
			rx.empresa_id='$cliente_empresa->id'
		AND
			(rx.falta_integral=1 
				OR
			 rx.falta_justificada=1)
		AND
			rx.data BETWEEN '$data_ini' AND '$data_fim'
		AND
			rx.funcionario_id=rf.id
		AND
			rf.status='admitidos'
		GROUP BY rf.id
		ORDER BY rf.nome ASC"),0);
		//echo mysql_error().' - '.$t;
		$funcionarios_q= mysql_query($t="
		SELECT
			rf.id, rf.nome as nome,
			COUNT(rx.falta_integral) as faltas
		FROM
			rh_hora_extra as rx,
			rh_funcionario as rf
		WHERE
			rx.vkt_id='$vkt_id'
		AND
			rx.empresa_id='$cliente_empresa->id'
		AND
			(rx.falta_integral='1' 
				OR
			rx.falta_justificada='1')			
		AND
			rx.data BETWEEN '$data_ini' AND '$data_fim'
		AND
			rx.funcionario_id=rf.id
		AND
			rf.status='admitidos'
		GROUP BY rx.funcionario_id
		ORDER BY rf.nome ASC
			");
		//	echo mysql_error().' - <br/>'.$t;
			
			$total=0;
			$total_faltas = 0;
			$total_justificadas = 0;
			$total_integrais = 0;
			while($funcionario=mysql_fetch_object($funcionarios_q)){
				$justificadas = mysql_result(mysql_query($t="SELECT COUNT(*) as falta FROM rh_hora_extra WHERE funcionario_id=$funcionario->id AND falta_justificada='1' AND
				data BETWEEN '$data_ini' AND '$data_fim'"),0,0); echo mysql_error();
				$total_justificadas+=$justificadas;
				
				$integral = mysql_result(mysql_query($t="SELECT COUNT(*) as falta FROM rh_hora_extra WHERE funcionario_id=$funcionario->id AND falta_integral='1' AND
				data BETWEEN '$data_ini' AND '$data_fim'"),0,0); echo mysql_error();	
				$total_integrais+=$integral;
				
				$total_faltas +=($justificadas+$integral);
				
				if($total%2){$sel='class="al"';}else{$sel='';}
				$total++;
				?>
				<tr <?=$sel?> align="center">
					<td width="250"><?=$funcionario->nome?></td>
					<td width="100"><?=$funcionario->faltas?></td>
                    <td width="100"><?=$justificadas?></td>
             		<td width="100"><?=$integral?></td>
					<td class="wp"></td>
				</tr>
				<?
		}
	}else{
		?>
        <tr>
        	<td colspan="3">Escolha uma empresa</td>
        </tr>
        <?
	}
	
?>
    	
    
</table>
<?
//print_r($_POST);
?>
</div>
<div id="total">
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr <?=$sel?> align="center">
					<td width="250" style="font-weight:bold" align="right">TOTAL: </td>
					<td width="100"><?=$total_faltas?></td>
                    <td width="100"><?=$total_justificadas?></td>
             		<td width="100"><?=$total_integrais?></td>
					<td class="wp"></td>
				</tr>
     </thead>
</table>
</div>
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
<script>
$('#sub93').show();
$('#sub418').show()
</script>