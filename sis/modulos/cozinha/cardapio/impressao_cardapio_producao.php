<?
require '../../../_config.php';
include '../../../_functions_base.php';

		$contrato_id=$_GET[contrato_id];
		$filtro_inicio 	= $_GET[filtro_inicio];
		$filtro_fim		= $_GET[filtro_fim];
	
		$total_dias		= mysql_result(mysql_query($trace="SELECT DATEDIFF('$filtro_fim','$filtro_inicio')"),0,0);
		++$total_dias;
		echo $total_dias;
	?>
<style type="text/css">
body,td,th {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 11px;
}
pre{ display:none}
</style>


<div id="retorno">

<div  style="padding:10px 0px 10px 0px"><strong>Período:</strong> <?=dataUsaToBr($filtro_inicio)?> - <?=dataUsaToBr($filtro_fim)?> <br/>
<strong>Unidade: </strong>Central <strong>Pedido: </strong>075000</div>
<?
$produtos=array();
$contratos_q=mysql_query($a="SELECT * FROM cozinha_contratos WHERE vkt_id='$vkt_id' AND id='{$_GET['contrato_id']}' ");
//echo $a;
while($contrato=mysql_fetch_object($contratos_q)){
	  //selecionar fichas do contrato e seus respectivos pessoas, e a soma da quantidade de pessoas q vao comer
	  $fichas_contrato_q=mysql_query($q="
	  SELECT
		  cf.id as ficha_id, cf.nome as ficha_nome, cf.peso as peso_receita, ccr.tipo_refeicao as refeicao, cg.nome as grupo_cardapio,
		  cf.percapta_leve as peso_leve, cf.percapta_medio as peso_medio, cf.percapta_pesado as peso_pesado, cf.percapta_extra as peso_extra,
		  ccr.pessoas as pessoas, ccr.data as data_ficha, DATE_FORMAT(ccr.data,'%w') as data_ficha_semana, cc.pesagem as pesagem_contrato, cc.unidade_id as unidade_id
	  FROM
		  cozinha_cardapio_dia_refeicao as ccr,
		  cozinha_fichas_tecnicas as cf,
		  cozinha_cardapios_grupos as cg,
		  cozinha_contratos as cc
	  WHERE
		  ccr.ficha_tecnica_id=cf.id
		  AND cg.id=cf.grupo_cardapio_id
		  AND ccr.contrato_id = cc.id
		  AND cc.id='{$contrato->id}'
		  AND ccr.data >= '$filtro_inicio' AND ccr.data <= '$filtro_fim'	
	  ");
	  //listar fichas e calcular o fator multiplicador para qtd de ingredientes
	  while($fichas_contrato=mysql_fetch_object($fichas_contrato_q)){	
		  //echo '<b>Ficha ID</b>: '.$fichas_contrato->ficha_id.' <b>Pessoas que vão comer</b> : '.$fichas_contrato->pessoas;
		  //echo " <b>peso da receita:</b> ".$fichas_contrato->peso_receita.' ';
		  //echo " <b>pesagem contrato:</b> ".$fichas_contrato->pesagem_contrato.' ';
		  if($fichas_contrato->pesagem_contrato=='leve'){
			  $fator_multiplicador = @($fichas_contrato->peso_leve/$fichas_contrato->peso_receita);
		  }
		  if($fichas_contrato->pesagem_contrato=='medio'){
			  $fator_multiplicador = @($fichas_contrato->peso_medio/$fichas_contrato->peso_receita);
		  }
		  if($fichas_contrato->pesagem_contrato=='pesado'){
			  $fator_multiplicador = @($fichas_contrato->peso_pesado/$fichas_contrato->peso_receita);
		  }
		  if($fichas_contrato->pesagem_contrato=='muito pesado'){
			  $fator_multiplicador = @($fichas_contrato->peso_extra/$fichas_contrato->peso_receita);
		  }
		  //echo "<b>Fator Multiplicador</b>: ".$fator_multiplicador.'<br>';
		  //pegar os produtos de cada ficha
		  if($_GET['grupo_id']>0){$filtro_grupo=" AND p.produto_grupo_id='{$_GET['grupo_id']}' ";}
		  $ingredientes_q=mysql_query($xi="
		  SELECT 
			  p.id as produto_id, p.nome as nome, cfp.qtd as qtd, p.estoque_min as estoque_min, p.unidade_uso as unidade_uso, p.unidade_embalagem as unidade_embalagem, p.conversao2 as conversao2, pg.nome as grupo
		  FROM
			  cozinha_ficha_has_produto as cfp, produto as p, produto_grupo as pg
		  WHERE 
			  cfp.ficha_id='{$fichas_contrato->ficha_id}' AND p.id=cfp.produto_id AND pg.id =p.produto_grupo_id
			  $filtro_grupo ");
			  //echo $xi;
		  //listar os produtos e fazer o calculo de qtd de ingredientes de cada produto
		  $produtos[$fichas_contrato->data_ficha][$fichas_contrato->refeicao][$fichas_contrato->grupo_cardapio][$fichas_contrato->ficha_nome]['pessoas']+=$fichas_contrato->pessoas;
		  while($ingrediente=mysql_fetch_object($ingredientes_q)){
			  $produtos[$fichas_contrato->data_ficha][$fichas_contrato->refeicao][$fichas_contrato->grupo_cardapio][$fichas_contrato->ficha_nome][$ingrediente->nome]['qtd']=($ingrediente->qtd*$fator_multiplicador*$fichas_contrato->pessoas);
			  $produtos[$fichas_contrato->data_ficha][$fichas_contrato->refeicao][$fichas_contrato->grupo_cardapio][$fichas_contrato->ficha_nome][$ingrediente->nome]['unidade_uso']=$ingrediente->unidade_uso;
		  }
		  
	  }
  }
  ksort($produtos);
 // print_r($produtos);
  $x=1;
  ?>
  <div style="width:800px;">
  <style>
  table tr td{border-bottom:solid 1px black;border-right:solid 1px black;}
  </style>
  <?
  foreach($produtos as $data=>$refeicoes){
	  ?>
      <div style="float:left; width:250px; margin-right:20px ">
      <strong><?
	  echo dataUsaToBR($data);
	  ?></strong>
      <table width="100%" style="border-top:solid 1px black;border-left:solid 1px black;"  cellpadding="0" cellspacing="0" >
      <tbody>
      <?
	  if(count($refeicoes['cafe'])>0){
		  echo "<tr><td colspan='2'><strong>Café</strong></td></tr>";
		  foreach($refeicoes['cafe'] as $grupo_cardapio=>$fichas){
			  
			  echo "<tr><td colspan='2'>&nbsp;$grupo_cardapio</td></tr>";
			  
			  foreach($fichas as $ficha=>$ingredientes){
				  
				  echo "<tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;$ficha {$ingredientes['pessoas']} pessoas</td></tr>";
				  
				  foreach($ingredientes as $ingrediente=>$campo){
				 	 if($ingrediente!='pessoas'){echo "<tr><td align='right'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ingrediente</td> <td align='right'>".qtdUsaToBR($campo[qtd],3)." {$campo['unidade_uso']}</td></tr>";} 
				  }
			  }
		  }
	  }
	  
	  
	  ?>
      </tbody>
      </table>
      <table width="100%" style="border-top:solid 1px black;border-left:solid 1px black;"  cellpadding="0" cellspacing="0">
      <tbody>
      <?
	  if(count($refeicoes['almoco'])>0){
		  echo "<tr><td colspan='2'><strong>Almoço</strong></td></tr>";
		  foreach($refeicoes['almoco'] as $grupo_cardapio=>$fichas){
			  
			  echo "<tr><td colspan='2'>&nbsp;$grupo_cardapio</td></tr>";
			  
			  foreach($fichas as $ficha=>$ingredientes){
				  
				  echo "<tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;$ficha {$ingredientes['pessoas']} pessoas</td></tr>";
				  
				  foreach($ingredientes as $ingrediente=>$campo){
				 	 if($ingrediente!='pessoas'){echo "<tr><td align='right'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ingrediente</td> <td align='right'>".qtdUsaToBR($campo[qtd],3)." {$campo['unidade_uso']}</td></tr>";} 
				  }
			  }
		  }
	  }
	  
	  
	  ?>
      </tbody>
      </table>
       <table width="100%" style="border-top:solid 1px black;border-left:solid 1px black;"  cellpadding="0" cellspacing="0">
      <tbody>
      <?
	  if(count($refeicoes['lanche'])>0){
		  echo "<tr><td colspan='2'><strong>lanche</strong></td></tr>";
		  foreach($refeicoes['lanche'] as $grupo_cardapio=>$fichas){
			  
			  echo "<tr><td colspan='2'>&nbsp;$grupo_cardapio</td></tr>";
			  
			  foreach($fichas as $ficha=>$ingredientes){
				  
				  echo "<tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;$ficha {$ingredientes['pessoas']} pessoas</td></tr>";
				  
				  foreach($ingredientes as $ingrediente=>$campo){
				 	 if($ingrediente!='pessoas'){echo "<tr><td align='right'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ingrediente</td> <td align='right'>".qtdUsaToBR($campo[qtd],3)." {$campo['unidade_uso']}</td></tr>";} 
				  }
			  }
		  }
	  }
	  
	  
	  ?>
      </tbody>
      </table>
      <table width="100%" style="border-top:solid 1px black;border-left:solid 1px black;"  cellpadding="0" cellspacing="0">
      <tbody>
      <?
	  if(count($refeicoes['janta'])>0){
		  echo "<tr><td colspan='2'><strong>janta</strong></td></tr>";
		  foreach($refeicoes['janta'] as $grupo_cardapio=>$fichas){
			  
			  echo "<tr><td colspan='2'>&nbsp;$grupo_cardapio</td></tr>";
			  
			  foreach($fichas as $ficha=>$ingredientes){
				  
				  echo "<tr><td colspan='2'>&nbsp;&nbsp;&nbsp;&nbsp;$ficha {$ingredientes['pessoas']} pessoas</td></tr>";
				  
				  foreach($ingredientes as $ingrediente=>$campo){
				 	 if($ingrediente!='pessoas'){echo "<tr><td align='right'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ingrediente</td> <td align='right'>".qtdUsaToBR($campo[qtd],3)." {$campo['unidade_uso']}</td></tr>";} 
				  }
			  }
		  }
	  }
	  
	  
	  ?>
      </tbody>
      </table>
      </div>
      <?
	  if($x%2==0){echo "<div style='clear:both'></div>";}
	  $x++;
  }
?>       
</div>

</div>
<br /><br /><br />
<div style="page-break-before: always;"> </div>

