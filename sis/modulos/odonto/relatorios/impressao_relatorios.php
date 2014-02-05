<?php
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
global $vkt_id;
$cliente_vekttor = mysql_fetch_object(mysql_query("SELECT * FROM clientes_vekttor WHERE id='$vkt_id'"));
$id = $_GET['id'];
$data_inicio=$_GET['data_inicio'];
$data_fim=$_GET['data_fim'];
$acao=$_GET['acao'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Odontologo - Relatórios</title>
<style>
*{
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
}
#tbl_procedimentos{
	border-collapse:collapse;
}
#tbl_procedimentos thead, #tbl_procedimentos tfoot{
	background-color:#CCC;
}

#tbl_procedimentos tr{
	border-left:solid 1px #000000;
	border-top:solid 1px #000000;
}
#tbl_procedimentos tr td{
	border-right:solid 1px #000000;
	border-bottom:solid 1px #000000;
}
</style>
</head>

<body>
<?=strtoupper($cliente_vekttor->nome)?></strong>

<div style="clear:both"></div>

<strong >Endereço:</strong><?=$cliente_vekttor->endereco.", ".$cliente_vekttor->bairro." - ".$cliente_vekttor->cidade."/".$cliente_vekttor->estado?>

<div style="clear:both"></div>

<strong >Telefone:</strong><?=$cliente_vekttor->telefone?>
<strong style="margin-left:200px;">CNPJ:</strong><?=$cliente_vekttor->cnpj?>

<div style="clear:both"></div>

<strong >Email:</strong><?=$cliente_vekttor->email?>

<div style="clear:both"></div>

<strong >Período:</strong> <?=$_GET['data_inicio']?> à <?=$_GET['data_fim']?>

<?php
	if($acao=='impressao_odonto'){
		$cliente_fornecedor = mysql_fetch_object(mysql_query("SELECT 
														* 
														FROM 
															usuario u,
															odontologo_odontologo oo 
														WHERE
															u.id=oo.usuario_id AND 
															u.id='".$_GET['id']."'"));
?>

<strong style="margin-left:20px;">Odontólogo:</strong> <?=$cliente_fornecedor->nome;?>
<strong style="margin-left:20px;">Porcentagem:</strong> <?=$cliente_fornecedor->porcentagem_recebimento;?>%
<table id="tbl_procedimentos">
                <thead>
                        <tr>
                          <td width="70">Data</td>
                          <td width="150">Cliente</td>
                          <td width="200">Convênio</td>
                          <td width="200">Procedimento</td>
                          <td width="110">Vlr Procedimento</td>
                          <td width="110">Valor Porcentagem</td>
                          <td width="110">Observação</td>                                        
                        </tr>
               </thead>
                <tbody id="tbody" style="background-color:white;">
                	<?php
						$cont=0;
						
						$odontologo_atendimento_item = mysql_query($t="SELECT oa.*, s.nome as servico, s.valor_normal FROM  odontologo_atendimento_item as oa, servico as s WHERE oa.vkt_id='$vkt_id' AND oa.odontologo_id='".$_GET['id']."' AND oa.data_cadastro BETWEEN '".DataBrToUsa($_GET['data_inicio'])."' AND '".DataBrToUsa($_GET['data_fim'])."' AND s.id = oa.servico_id");
						$porcentagem_odontologo = mysql_result(mysql_query($t="SELECT 
																					oo.porcentagem_recebimento as porcentagem_recebimento 
																				FROM 
																					odontologo_odontologo oo,
																					usuario u
																				WHERE
																					u.cliente_vekttor_id AND
																					oo.usuario_id = u.id AND 
																					u.id='".$_GET['id']."'"),0,0);
						$valor=0;
						$valor_odontologo=0;
						while($atendimento=mysql_fetch_object($odontologo_atendimento_item)){	
						$valor+=$atendimento->valor_normal;	
						$cont++;
						if($cont%2==0){$c="al";}else{$c="";}
							$cliente = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id = '$atendimento->cliente_fornecedor_id'"));
							
							if($atendimento->cliente_fornecedor_id==$cliente_anterior){
								$count_cliente++;
							}else{
								$count_cliente=0;
							}
							
							$servico = mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE id = '$atendimento->servico_id'"));
							$valor_odontologo+=$servico->valor_colaborador;
							$porcentagem_servico_odontologo = ($porcentagem_odontologo * $servico->valor_normal)/100;
							$porcentagem_servico_odontologo_total+=$porcentagem_servico_odontologo;
							$convenio = mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_atendimentos oa, cliente_fornecedor cf
																		WHERE
																			oa.vkt_id='$vkt_id' AND 
																			oa.convenio_id=cf.id AND
																			oa.id = '$atendimento->odontologo_atendimento_id'"));
							$movimento_financeiro = mysql_fetch_object(mysql_query($t="SELECT 
																						* 
																					FROM 
																						financeiro_movimento 
																					WHERE 
																						internauta_id='$atendimento->cliente_fornecedor_id' AND 
																						doc='$atendimento->odontologo_atendimento_id' AND
																						origem_tipo='odonto'
																						LIMIT $count_cliente,1
																					"));
							$cliente_anterior = $atendimento->cliente_fornecedor_id;
					?>
                    		<tr class="<?=$c?>">
                            	<td>
                                	<?=DataUsaToBr($atendimento->data_cadastro)?>
                                </td>
                                <td >
                                	<?=$cliente->razao_social?>
                                                                                         	
                                </td>
                                <td width="200"><?=$convenio->razao_social?></td>
                                <td>
                                	<?=$servico->nome?>                                               	
                                </td>
                                <td style="text-align:right;">
                                	<?=moedaUsaToBR($servico->valor_normal)?>                                               	
                                </td>
                                <td style="text-align:right;"><?=moedaUsaToBR($porcentagem_servico_odontologo)?></td>
                               
                                <td width="200"><?=$movimento_financeiro->nota?></td>
                            </tr>
                   <? } ?>
                </tbody>
                <tfoot>
            			<tr style="font-weight:bold;">
							  <td></td>
							  <td></td>
                              <td></td>
                              <td style="text-align:right;">Total</td>
                              <td style="text-align:right;"><?=moedaUsaToBR($valor)?></td>
                              <td width="110" style="text-align:right;"><?=moedaUsaToBR($porcentagem_servico_odontologo_total)?></td>
                              <td style="text-align:right;"></td>
                              
						</tr>
                </tfoot> 
             </table>
<?
}//acao

//----------------------------------------------------------------------------------------------------------------------------------------

if($acao=='impressao'){
?>
<table id="tbl_procedimentos">
<thead>
    	<tr>
          <td width="60"><Codigo</td>
          <td width="200">Nome</td>
          <td width="160">Procedimentos concluídos</td>
          <td width="160">Procedimentos incompletos</td>
          <td width="60">Total</td>
 
        </tr>
    </thead>
<tbody>
	<?php 
		if(!empty($_GET['de'])&&!empty($_GET['ate'])){
			$filtro      = " AND data_cadastro BETWEEN '".dataBrToUsa($_GET['de'])."' AND '".dataBrToUsa($_GET['ate'])."'";
			$data_inicio = dataBrToUsa($_GET['de']);
			$data_fim    = dataBrToUsa($_GET['ate']);
		}else{
			$mes_atual=date("m");
			$filtro      = " AND MONTH(data_cadastro) = '$mes_atual'";
			$data_inicio = date("Y")."-$mes_atual-01";
			$data_fim = date("Y")."-$mes_atual-".date("t");
		}
		
		
		$registros= mysql_result(mysql_query("SELECT *
							   FROM 
								odontologo_odontologo oo,
								cliente_fornecedor cf
								
							   WHERE 
							   		oo.cliente_fornecedor_id = cf.id AND
							  		oo.vkt_id='$vkt_id' $busca"),0,0);

		$sql = mysql_query($t="SELECT 
								*, oo.id as dentista_id,
								cf.razao_social,
								u.id as usuario_id
							   FROM 
								odontologo_odontologo oo,
								cliente_fornecedor cf,
								usuario as u
							   WHERE
							   	oo.cliente_fornecedor_id = cf.id AND 
							  	oo.vkt_id = '$vkt_id' AND
								u.id = oo.usuario_id
								$busca
							   LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
		echo mysql_error();	
		$cont=0;
		$valor_os_funcionario=0;
		while($r=mysql_fetch_object($sql)){
			 $cont++;
			 if($cont%2==0){$c="al";}else{$c="";}
			$quantidade_item_incompletos = mysql_fetch_object(mysql_query($t="SELECT COUNT(*) as qtd FROM odontologo_atendimento_item WHERE vkt_id='$vkt_id' AND odontologo_id = '$r->usuario_id' AND status!='2' $filtro"));
			$quantidade_item_completos= mysql_fetch_object(mysql_query($t="SELECT COUNT(*) as qtd FROM odontologo_atendimento_item WHERE vkt_id='$vkt_id' AND odontologo_id = '$r->usuario_id' AND status='2' $filtro"));
echo mysql_error();
			$quantidade_total   = $quantidade_item_completos->qtd + $quantidade_item_incompletos->qtd; 
	?>
    		<tr id="<?=$r->usuario_id?>" data_inicio="<?=$data_inicio?>" data_fim="<?=$data_fim?>">
            	<td width="60"><?=$r->usuario_id?></td>
            	<td width="200"><?=$r->razao_social?></td>
                <td width="160"><?=$quantidade_item_completos->qtd?></td>
                <td width="160"><?=$quantidade_item_incompletos->qtd?></td>
                <td width="60"><?=$quantidade_total?></td>
               
	<?php
		}
	?>
    </tr>
    	
    </tbody>
</table>
<?
}
if($acao=='todos_convenios'){
?>
<table id="tbl_procedimentos" >
<thead>
    	<tr>
          <td width="60">Codigo</td>
          <td width="200">Procedimento</td>
          <td width="110">Valor Procedimento</td>
     	  <td width="110">Valor Convênio</td>
        </tr>
    </thead>
    <tbody>
	<?php 
		if(!empty($_GET['de'])&&!empty($_GET['ate'])){
			$filtro      = " AND data_cadastro BETWEEN '".dataBrToUsa($_GET['de'])."' AND '".dataBrToUsa($_GET['ate'])."'";
			$data_inicio = $_GET['de'];
			$data_fim    = $_GET['ate'];
		}else{
			$mes_atual=date("m");
			$filtro      = " AND MONTH(data_cadastro) = '$mes_atual'";
			$data_inicio = date("Y")."-$mes_atual-01";
			$data_fim = date("Y")."-$mes_atual-".date("t");
		}
		
		if(!empty($_GET['busca'])){
			$busca = "AND razao_social LIKE '%".$_GET['busca']."%'";
		}
		
		$registros= mysql_result(mysql_query("SELECT COUNT(*)
							   FROM 
								cliente_fornecedor																
							   WHERE 
							   		tipo = 'Cliente' AND
							  		cliente_vekttor_id='$vkt_id' $busca"),0,0);
		echo mysql_error();
		$sql = mysql_query($t="SELECT *, cf.id as convenio_id 
							   FROM
							   	odontologo_convenio oc, 
								cliente_fornecedor cf														
							   WHERE 
							   		oc.vkt_id                = '$vkt_id' AND
									oc.cliente_fornecedor_id =  cf.id																
							   LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
		
		$cont=0;
		$valor_total=0;
		$valor_os_funcionario=0;
		while($r=mysql_fetch_object($sql)){
			
			$valor_procedimentos = 
			mysql_fetch_object(mysql_query($t="
			SELECT 
				SUM(oai.valor) as valor,SUM(oai.valor_convenio) as valor_convenio
			FROM 
				odontologo_atendimentos oa,
				odontologo_atendimento_item oai
			WHERE
				oa.id         = oai.odontologo_atendimento_id AND
				oa.convenio_id = '$r->convenio_id' AND
				oai.data_cadastro BETWEEN '".$data_inicio."' AND '".$data_fim."'
			"));
			$valor_total+=$valor_procedimentos->valor;
			$valor_total_convenio+=$valor_procedimentos->valor_convenio;
			//echo $t." ".mysql_error();
			//$ultimo_atendimento = mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_atendimento_item WHERE cliente_fornecedor_id = '$r->id' AND data_cadastro < CURRENT_DATE() AND status = '2' ORDER BY id DESC LIMIT 1"));
			//echo $t;	 
	?>
    		<tr data_inicio="<?=$data_inicio?>" data_fim="<?=$data_fim?>" class="valor_convenio" convenio_id='<?=$r->cliente_fornecedor_id?>'>
            	<td width="60"><?=$r->cliente_fornecedor_id?></td>
            	<td width="200"><?=$r->razao_social?></td>
                <td width="110" style="text-align:right"><?php if($valor_procedimentos->valor>0){ echo MoedaUsaToBr($valor_procedimentos->valor);}else{ echo "0,00";}?></td>
                <td width="110" style="text-align:right"><?php if($valor_procedimentos->valor_convenio>0){ echo MoedaUsaToBr($valor_procedimentos->valor_convenio);}else{ echo "0,00";}?></td>
	<?php
		}
	?>
    </tr>
    	
    </tbody>
    <tfoot>
    	<tr>
        	<td colspan="2" style="text-align:right;font-weight:bold;">Total</td>
            <td style="text-align:right"><?=MoedaUsaToBr($valor_total)?></td>
            <td style="text-align:right"><?=MoedaUsaToBr($valor_total_convenio)?></td>
        </tr>
    </tfoot>
</table>
<?
}
if($acao=='atendimentos_convenio'){
	
	$convenio = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$id'"));
	$sql="SELECT * FROM 
												  odontologo_atendimentos oa, 
												  odontologo_atendimento_item oai 
											  WHERE 
												  oa.id = oai.odontologo_atendimento_id AND
												  oa.convenio_id = '$id' AND
												  oai.aprovado   = '1' AND
												  oai.data_cadastro BETWEEN '".DataBrToUsa($data_inicio)."' AND '".DataBrToUsa($data_fim)."'";
												  
	$odontologo_atendimento_item = mysql_query($sql);	
	echo "<strong>Contas: </strong>";
	
	$nome_contas = array();
	while($atendimento=mysql_fetch_object($odontologo_atendimento_item)){	
		$contas = mysql_query($t="SELECT 
							DISTINCT(fm.conta_id), fc.nome
						  FROM
						  	financeiro_movimento fm,
							financeiro_contas fc
						  WHERE
						  	fm.conta_id = fc.id AND
						  	fm.internauta_id = '$atendimento->cliente_fornecedor_id' AND 
							fm.cliente_id = '$vkt_id' AND 
							fm.doc = '$atendimento->odontologo_atendimento_id'
						  ");//echo $t."<br>";
		
		while($conta=mysql_fetch_object($contas)){	
			if(!in_array($conta->nome,$nome_contas)){
				echo $conta->nome."";
				$nome_contas[] = $conta->nome;
			}
		}
	}
	echo "<div style='clear:both'></div>";
	echo "<strong>Convênio: </strong>$convenio->razao_social";
	
?>
<table id="tbl_procedimentos" >
<thead>
        <tr>
          <td width="60">Data</td>
          <!--<td width="150">Odontologo</td>-->
          <td width="150">Cliente</td>
          <td width="200">PROCEDIMENTO</td>
          <!--<td width="110">Valor Procedimento</td>-->
          <td width="90">Valor Convenio</td>             
        </tr>
</thead>
<tbody>
<?php
$cont=0;

//$odontologo_atendimento_item = mysql_query($t="SELECT oa.*, s.nome as servico, s.valor_normal FROM  odontologo_atendimento_item as oa, servico as s WHERE oa.vkt_id='$vkt_id' AND oa.odontologo_id='".$_GET['id']."' AND oa.data_cadastro BETWEEN '".$_GET['data_inicio']."' AND '".$_GET['data_fim']."' AND s.id = oa.servico_id");
$valor=0;
$odontologo_atendimento_item = mysql_query($sql);
while($atendimento=mysql_fetch_object($odontologo_atendimento_item)){	
$valor+=$atendimento->valor;
$valor_convenio+=$atendimento->valor_convenio;	
$cont++;
if($cont%2==0){$c="al";}else{$c="";}
	$cliente    = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id = '$atendimento->cliente_fornecedor_id'"));
	$servico    = mysql_fetch_object(mysql_query("SELECT * FROM servico WHERE id = '$atendimento->servico_id'"));
	$odontologo = mysql_fetch_object(mysql_query($t="SELECT 
														* 
												 FROM 
														odontologo_odontologo oo,
														cliente_fornecedor cf 
												WHERE 
														oo.cliente_fornecedor_id = cf.id AND
														oo.usuario_id = '$atendimento->odontologo_id'"));
														//echo $t." ".mysql_error();
										
?>
	<tr class="<?=$c?>">
		<td>
			<?=DataUsaToBr($atendimento->data_cadastro)?>
		</td>
		 <!--<td width="150"><?=$odontologo->razao_social?></td>-->
		<td >
			<?=$cliente->razao_social?>                                                                                         	
		</td>
        <td>
			<?=$servico->nome?>                                               	
		</td>
		<!--<td style="text-align:right;">
			<?=moedaUsaToBR($atendimento->valor)?>                                               	
		</td >-->
		<td style="text-align:right;"><?=moedaUsaToBR($atendimento->valor_convenio)?></td>
	</tr>
<? } ?>
</tbody>
<tfoot>
<tr>
	  <td colspan="3" style="text-align:right;font-weight:bold;">Total</td>
	  
	  <!--<td style="text-align:right;"><?=moedaUsaToBR($valor)?></td>-->
      <td style="text-align:right;"><?=moedaUsaToBR($valor_convenio)?></td>
	  
</tr>
</tfoot> 
</table>
<?
}
?>
</body>
</html>