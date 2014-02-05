<?
	include("../../../_config.php");
	include("../../../_functions_base.php");
	global $vkt_id;
	$cliente_fornecedor= mysql_query($t="SELECT *, cf.id as cliente_forencedor_id FROM 
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
	ORDER BY cf.razao_social");
	//echo $t.mysql_error();	

?>
<style>
	*{
		font-family:Arial, Helvetica, sans-serif;
		font-size:10px;
	}
	table{
		border-left:1px solid #000;
		border-top:1px solid #000;	
	}
	table thead{
		text-align:center;
		font-weight:bold;
		background-color:#CCC;
	}
	table tr td{
		border-right:1px solid #000;
		border-bottom:1px solid #000;
		padding:2px;	
	}
	#cabecalho{
		width:800px;
		font-size:12px;
	}
	#logo{
		float:right;
	}
</style>
<div id="cabecalho">
<div style="width:90%;float:left">
    <div style="font-size:14px;font-weight:bold">Relatório de Movimentação</div>
    <div style="clear:both"></div>
	<?=$empresa[nome]?>
    <div style="clear:both"></div>
    <div style="font-weight:bold;float:left">Mês: </div><?=$mes_extenso[$_GET['mes']-1]?>
     <div style="clear:both"></div>
    <div style="font-weight:bold;float:left">Ano: </div><?=$_GET['ano']?>
</div>
<div id="logo">
	<?php
		if(is_file("../../vekttor/clientes/img/$cliente_id.png")){
	?>
    <img src="../../vekttor/clientes/img/<?=$cliente_id?>.png" width="60">
	<?php
		}
    ?>
</div>
</div>
<div style="clear:both"></div>
<table cellpadding="0" cellspacing="0">
    <thead>
    	<tr>
           <td width="180">Empresa</td>
            <td width="80">CNPJ</td>
          	<td width="180">Funcionario</td>
          	<td width="80">Nascimento</td>
          	<td width="90">CPF</td>
			<td width="100">Carteira</td>
			<td width="80">PIS</td>
           
        </tr>
    </thead>
    <tbody>
	
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND cf.nome_fantasia like '%{$_GET[busca]}%'";
	}
	
	$filtro = '';
	
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="cf.nome_fantasia";
	}
	
	$filtro_empresa = '';
	
	if(!empty($_GET['cliente_fornecedor'])){
		$filtro_empresa = "cf.id='".$_GET['cliente_fornecedor']."' AND"; 
	}
	
	// colocar a funcao da paginaçao no limite
	$q= mysql_query($t="SELECT *, cf.id as cliente_fornecedor_id FROM 
		rh_empresas re,
		cliente_fornecedor cf 
		WHERE 
		re.cliente_fornecedor_id = cf.id AND
		$filtro_empresa
		re.vkt_id ='$vkt_id' 
		$busca_add 
		$filtro 
		ORDER BY ".$ordem);
	//echo $t.mysql_error();
	while($r=mysql_fetch_object($q)){
		if($total%2){$sel='class="al"';}else{$sel='';}
		$total++;

		$empresa =	"<strong>$r->nome_fantasia</strong>";
		$cnpj	 = "<strong>$r->cnpj_cpf</strong>";
	
		
		if(empty($_GET['mes'])){
			$filtro_mes = "month(now())";
		}else{
			$filtro_mes = $_GET['mes'];
		}
		
		if(empty($_GET['ano'])){
			$filtro_ano = "YEAR(now())";
		}else{
			$filtro_ano = $_GET['ano'];
		}
		
		//consulta datas de admissoes
		$mq = mysql_query($t="SELECT * FROM rh_funcionario WHERE empresa_id='$r->id' AND month(data_admissao) = $filtro_mes AND YEAR(data_admissao) = $filtro_ano ");
		//echo $t.mysql_error();

		//consulta demissoes
		$mq2 = mysql_query($t="SELECT 
					* 
				   FROM 
					rh_funcionario_demitidos rh_fd,
					rh_funcionario rh_f 
				   WHERE
				   rh_fd.funcionario_id = rh_f.id AND 
					rh_fd.empresa_id='$r->id' AND 
					month(rh_fd.data_demissao) = $filtro_mes AND 
					YEAR(rh_fd.data_demissao) = $filtro_ano");


		$qt = mysql_num_rows($mq);
		$qt2 = mysql_num_rows($mq2);
		if($qt>0||$qtd2>0){
	?>
<tr <?=$sel?>>
<td ><?=$empresa?></td>
<td ><?=$cnpj?></td>
<td >&nbsp;</td>
<td >&nbsp;</td>
<td >&nbsp;</td>
<td >&nbsp;</td>
<td >&nbsp;</td>
</tr>
<?
		
		$ff=0;
		while($rr = mysql_fetch_object($mq)){
			
		if($total%2){$sel='class="al"';}else{$sel='';}
			$total++;
			$ff++;
?>
<tr <?=$sel?>id="admissao" funcionario_id="<?=$rr->id?>" empresa_id="<?=$r->id?>">
<td align="right">Admissao</td>
<td > <?=DataUsaToBr($rr->data_admissao)?></td>
<td ><?=$rr->nome?></td>
<td ><?=DataUsaToBr($rr->data_nascimento)?></td>
<td ><?=$rr->cpf?></td>
<td ><?="$rr->carteira_profissional_numero/$rr->carteira_profissional_serie - $rr->carteira_profissional_estado_emissor"?></td>
<td ><?=$rr->pis?>&nbsp;</td>
</tr>
<?
		}
		//echo $t;					
		while($rr = mysql_fetch_object($mq2)){
		if($total%2){$sel='class="al"';}else{$sel='';}
			$total++;
			$ff++;
?>
<tr <?=$sel?> id="demissao" funcionario_id="<?=$rr->id?>" empresa_id="<?=$r->id?>">
<td align="right">Demissao</td>
<td > <?=DataUsaToBr($rr->data_demissao)?></td>
<td ><?=$rr->nome?></td>
<td ><?=DataUsaToBr($rr->data_nascimento)?></td>
<td ><?=$rr->cpf?></td>
<td ><?="$rr->carteira_profissional_numero/$rr->carteira_profissional_serie - $rr->carteira_profissional_estado_emissor"?></td>
<td ><?=$rr->pis?>&nbsp;</td>

</tr>
<?
		}
		}//if $qtd >0
	}
	?>	
    </tbody>
   
</table>
