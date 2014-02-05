<?
$caminho =$tela->caminho;
	include("modulos/financeiro/_functions_financeiro.php");
if($_POST[conta_id]){
	include("modulos/financeiro/_ctrl_financeiro.php");
}


if($_GET[mes]){$mes=$_GET[mes];}else {$mes=date('m');}

if($_GET[ano]){$ano=$_GET[ano];}else {$ano=date('Y');}
//Includes
// configuração inicial do sistema
// funções base do sistema
include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script src="modulos/financeiro/financeiro.js"></script>
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="?" class='s2'>
  	Financeiro
</a>
<a href="?tela_id=86" class='navegacao_ativo'>
<span></span>    Contas Fixas
</a>
</div>
<div id="barra_info">
    <a href="modulos/financeiro/contas_fixas/form_conta_fixa.php" target="carregador" class="mais"></a>
<form style="float:left; margin:0; padding:0"> 
    
      <select name="mes">
    	<option value="1" <? if($mes=='1')echo "selected"; ?> >Janeiro</option>
    	<option value="2" <? if($mes=='2')echo "selected"; ?> >Fevereiro</option>
    	<option value="3" <? if($mes=='3')echo "selected"; ?> >Março</option>
    	<option value="4" <? if($mes=='4')echo "selected"; ?> >Abril</option>
    	<option value="5" <? if($mes=='5')echo "selected"; ?>>Maio</option>
    	<option value="6" <? if($mes=='6')echo "selected"; ?>>Junho</option>
    	<option value="7" <? if($mes=='7')echo "selected"; ?>>Julho</option>
    	<option value="8" <? if($mes=='8')echo "selected"; ?>>Agosto</option>
    	<option value="9" <? if($mes=='9')echo "selected"; ?>>Setembro</option>
    	<option value="10" <? if($mes=='10')echo "selected"; ?>>Outubro</option>
    	<option value="11" <? if($mes=='11')echo "selected"; ?>>Novembro</option>
    	<option value="12" <? if($mes=='12')echo "selected"; ?>>Dezembro</option>
    </select>
    <select name="ano" style="width:60px">
          <?
		  $anoi= date("Y")+1;
      for($i=$anoi;$i>date("Y")-5;$i--){
		  if($ano==$i){$sel= 'selected'; }else{$sel ='';}
		echo "<option value='$i'".$ano_s[$i]." $ano>$i</option>";  
		}
	  ?>
    </select>
    <input type="hidden" name="tela_id" value="86" />
        
    </label>
<input type="submit" name="button" id="button" value="Filtrar" />
</form>
</div>


<?

/* FILTROS DE CONSULTA */
if($_GET[tipo] && $_GET[tipo]!='nulo'){
	$tabela_tipo=", financeiro_{$_GET[tipo]}_has_movimento as fhm";
	$filtro_tipo=" AND fm.id=fhm.movimento_id AND fhm.plano_id='{$_GET[$_GET[tipo]]}' ";
}
if($_GET[forma_pagamento] && $_GET[forma_pagamento]!=0)$filtro_forma=" AND fm.forma_pagamento ='{$_GET[forma_pagamento]}'"; 
if(isset($_GET[autorizado]) && $_GET[autorizado]!=2)$filtro_autorizado=" AND fm.autorizado='{$_GET['autorizado']}' ";else $filtro_autorizado="";
if($_GET[forma_pagamento] && $_GET[forma_pagamento]!=0)$filtro_forma=" AND fm.forma_pagamento ='{$_GET[forma_pagamento]}'";

/*  FILTRO DE EXIBICAO */
?>

<table cellpadding="0" cellspacing="0" width="100%" >
    <thead>
    	<tr>	
        	<td width="60" align="center">Dia Venc.</td>
            <td width="250">Cliente/Fornecedor</td>
    	  	<td width="250">Descricao</td>
			<td width="100" style="margin:0; padding-left:10px; text-align:center">Valor Previsto</td>
            <td width="100">Valor Cadastrado</td>
            <td></td>
        </tr>
    </thead>
</table>

<script>
function opf(id){
	window.open('modulos/financeiro/contas_fixas/form_conta_fixa.php?id='+id,'carregador')
}
function openMovimentacao(id){
	window.open('modulos/financeiro/form_movimentacao.php?id='+id,'carregador')
}

</script>
<div id="dados">
<table cellpadding="0" cellspacing="0" width="100%"  >
    <tbody id="tabela_dados">
    <?
    $contas_q=mysql_query(
	$t="
	SELECT * 
	FROM financeiro_contas_fixas WHERE vkt_id='$vkt_id' 
	ORDER BY dia_vencimento ASC
	");
	//echo $t;
	//echo  mysql_error();
	$linha=0;
	$total_previsto;
	while($conta=mysql_fetch_object($contas_q)){
		if($linha%2)$sel="";else $sel=' class="al" ';
		$cliente=mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='".$conta->fornecedor_id."' LIMIT 1"));
		$diavencimento = $conta->dia_vencimento;
		if($diavencimento<10){$diavencimento="0".$diavencimento;}
		
		$verifica_q=mysql_query($trace=
		"SELECT * FROM financeiro_movimento 
		WHERE  origem_id='{$conta->id}' AND DATE_FORMAT(data_vencimento,'%m')='$mes' AND DATE_FORMAT(data_vencimento,'%Y')='$ano' AND origem_tipo='Conta Fixa' ");
		$verifica=mysql_num_rows($verifica_q);
		$valor=mysql_fetch_object($verifica_q);
		$valor_cadastrado=moedaUsaToBr($valor->valor_cadastro);
		$status;
		if($verifica<1){
			/* nao cadastrou conta no contas a pagar ainda */
			if($mes<date('m')||($mes==date('m')&&$diavencimento<date('d'))  ){
				/* ultrapassou data de vencimento */
				$status='pendente'; $v=' style="color:red;" '; $v2='color:black';
			}else{
				/* ainda nao chegou data de vencmento */
				$v='';$v2='';$status='pendente';
			}
		}else{
			if($valor->status=='1'){$status='pago';$v=' style="color:green;" '; $v2='color:green;cursor:pointer';}
			if($valor->status=='0'){$status='cadastrado'; $v=' style="color:black;" '; $v2='color:black;cursor:pointer';}
		}
		
		if($linha%2){$sel= 'class="al" ';}else{$sel='';}
		
		/* manipular javascript */
		$atualizador= "onchange=\"atualizaDado(this,{$conta->id},{$conta->dia_vencimento},$mes,$ano)\" ";
		$form= "onclick=\"openMovimentacao({$valor->id})\""; $input= "disabled " ;
		?>
			<tr  <?=$v?> <?=$sel?>  >

				<td width="60" align="center"><?=$diavencimento?></td>
                <td width="250" onclick="opf(<?=$conta->id?>)"><?=$cliente->razao_social?></td>
				<td width="250" onclick="opf(<?=$conta->id?>)"><?=$conta->descricao?></td>
				<td width="100" align="right"><?=moedaUsaToBr($conta->valor)?> </td>
				
				<td width="100" align="right" <?=$v?> >
                    <input type="text"
                    <? if($status=='pendente'){echo $atualizador; } ?>
                    style="width:80px; border:none; background:none; text-align:right; <?=$v2?>"  value="<?=$valor_cadastrado?>"
                    <? if($status=='pago' || $status=='cadastrado'){ echo $form; } ?> />
                </td>
				<td></td>
			</tr>
		<? 
		$linha++; 
		$total_previsto+=$conta->valor;
		unset($valor_cadastrado);
	} ?>
    </tbody>
</table>
<span class="lembrete"><br />
</span>
</div>
<table cellpadding="0" cellspacing="0" width="100%" >
  <thead>
    <tr>
        <td width="60"></td>
      <td width="250">Total</td>
      <td width="250">Total</td>
      <td width="100" style="margin:0; padding:0; text-align:right"><?=moedaUsaToBr($total_previsto)?></td>
      <td width="100" align="right" style="margin:0; padding:0; ">&nbsp;</td>
      <td></td>
    </tr>
  </thead>
</table>

<script>resize()</script><!-- Isso é Necessário para a criação o resize -->

</div>
<div id='rodape'>
<script>
function atualizaDado(t,id,dia,mes,ano){
	valor = t.value;
	window.open(
	'modulos/financeiro/contas_fixas/atualiza.php?id='+id
	+'&dia='+dia
	+'&mes='+mes
	+'&ano='+ano
	+'&valor='+valor,'carregador');
	t.disabled='disabled';
	t.parentNode.parentNode.style.color='black';
}
</script>
<script>
	$("#centro_escolha").click(function(){
		$("#centro").show();$("#plano").hide();
	})
	
	$("#plano_escolha").click(function(){
		$("#centro").hide();$("#plano").show();
	})

</script>
</div>
