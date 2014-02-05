<?
include("../../../_config.php");
include("../../../_functions_base.php");
?>
<style>
	*{
		font-size:12px;
		font-family:Arial, Helvetica, sans-serif;
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
</style>
<div id='dados'>
<div>
	<?=date('d/m/Y')?>
    <strong style="margin-left:200px;">Relação de Vencimentos de Contrato de Experiência</strong>
 	<div style="clear:both"></div>
    <?=date('H:i:s')?>
</div>
<table cellpadding="0" cellspacing="0" width="60%">
    <thead>
    	<tr align="center">
        	<td colspan="6">&nbsp;</td>
            <td colspan="3">Contrato</td>
            <td colspan="3">Prorrogação</td>
          	
			
        </tr>
    	<tr>
        	<td width="50">Codigo</td>
            <td width="250">Funcionário</td>
            <td width="200">Empresa</td>            
            <td width="100" >CPF</td>
            <td width="80">Admissão</td>
            <td width="100" >Função</td>
          	<td width="70" >Prazo</td>
            <td width="80" >Vencto</td>
            <td width="60" >Dias</td>
       	 	<td width="60" >Prazo</td>
            <td width="80" >Vencto</td>
            <td width="60" >Dias</td>
          
			
        </tr>
    </thead>
    <tbody>
    <?
	//$empresa_id=$_GET['empresa_id'];
	if(!empty($_GET['busca'])){
		$filtro = " AND nome like '%".$_GET['busca']."%'";
	}
	if($_GET[limitador]<1){
		$_GET[limitador]	=100;
	}
	if(strlen($_GET[ordem])>0){
		$ordem = $_GET[ordem];
	}else{
		$ordem =  'nome';
	}
	$registros= mysql_result(mysql_query("SELECT count(*) FROM 
					  	rh_funcionario f,
						cliente_fornecedor cf					  	
					  WHERE 
					  	f.vkt_id='$vkt_id' AND
						f.empresa_id = cf.id AND						
						f.status != 'demitidos' AND
						(SELECT DATEDIFF(NOW(),f.data_admissao) <= f.dias_experiencia) 
						$filtro"),0,0);
	$q = mysql_query($t="
					  SELECT *,f.id as funcionario_id, cf.razao_social as nome_empresa,DATE_ADD(f.data_admissao, INTERVAL f.dias_experiencia DAY) as prazo_experiencia FROM 
					  	rh_funcionario f,
						cliente_fornecedor cf					  	
					  WHERE 
					  	f.vkt_id='$vkt_id' AND
						f.empresa_id = cf.id AND						
						f.status != 'demitidos' AND
						(SELECT DATEDIFF(NOW(),f.data_admissao) <= f.dias_experiencia)  
						$filtro
						ORDER BY $ordem
						LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
		echo mysql_error();
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$vencimento_contrato = mysql_fetch_object(mysql_query($t=
		"SELECT ADDDATE('$r->data_admissao',INTERVAL $r->dias_experiencia DAY) as prazo,
		DATEDIFF(ADDDATE('$r->data_admissao',INTERVAL $r->dias_experiencia DAY),NOW()) as dias_restante
		"));
		$vencimento_prorrogacao = mysql_fetch_object(mysql_query($t=
		"SELECT ADDDATE('$vencimento_contrato->prazo',INTERVAL $r->dias_experiencia DAY) as prazo_prorrogacao,
		DATEDIFF(ADDDATE('$vencimento_contrato->prazo',INTERVAL $r->dias_experiencia DAY),NOW()) as dias_restante_prorrogacao
		"));
		echo mysql_error();
			if($ultimo_salario->salario>0){
			$salario = $ultimo_salario->salario;
		}else{
			$salario = $r->salario;
		}
	?>       
    	<tr <?=$sel ?> onclick="window.open('<?=$tela->caminho?>/form.php?id=<?=$r->id?>&empresa1id=<?=$cliente_fornecedor->id?>','carregador')" >
      		<td width="50"><?=str_pad($r->numero_sequencial_empresa,6,'0',STR_PAD_LEFT)?></td>
        	<td width="250"><?=$r->nome?></td>
            <td width="200"><?=$r->razao_social?></td>
            
            <td width="100" ><?=$r->cpf?></td>
            <td width="80"><?=DataUsaToBr($r->data_admissao)?></td>
           	<td width="100" ><?=$r->cargo?></td>
            <td width="70" ><?=$r->dias_experiencia?></td>
            <td width="80" ><?=DataUsaToBr($vencimento_contrato->prazo)?></td>
            <td width="60" ><?=$vencimento_contrato->dias_restante?></td>
       	 	<td width="60" ><?=$r->dias_experiencia?></td>
            <td width="80" ><?=DataUsaToBr($vencimento_prorrogacao->prazo_prorrogacao)?></td>
            <td width="60" ><?=$vencimento_prorrogacao->dias_restante_prorrogacao?></td>
          	
        </tr>
      
<?
	}
?>
    	
    </tbody>
</table>

</div>
<div id='rodape'></div>