<?
$caminho =$tela->caminho; 
include("modulos/financeiro/_functions_financeiro.php");
include("modulos/financeiro/_ctrl_financeiro.php");



if(empty($_GET[filtro_inicio])&&empty($_GET[filtro_fim])){
  $filtro_inicio 	= date("Y-m-").'01';
  $filtro_fim		= date("Y-m-t");
  
}else{
  $filtro_inicio 	= dataBrToUsa($_GET[filtro_inicio]);
  $filtro_fim		= dataBrToUsa($_GET[filtro_fim]);
}



?>
<script src="modulos/financeiro/financeiro.js"></script>
<script src="modulos/financeiro/contas_a_receber/contas_a_receber.js"></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<link href="modulos/financeiro/contas_a_receber/contas_a_receber.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>
<a href="?" class='s2'>
  	Financeiro
</a>
<a href="?tela_id=52" class='navegacao_ativo'>
<span></span>    Contas a Receber
</a>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" id="busca"/>
</form>
</div>
<div id="barra_info">
    <a href="modulos/financeiro/form_movimentacao.php" target="carregador" class="mais"></a>
<form style="float:left; margin:0; padding:0"> 
    
     <?
    	$selected_exibe = 'selected="selected"';
		if(isset($_GET["exibicao"])){
			$selected_exibe = "";	
		}
	?>
    
      <input type="button" value="Coluna" >
         <input type="button" value="Lista" >
      <select name="tipo" id="tipo">
      	<option value="nulo">Escolha o filtro</option>
        <option value="centro" id="centro_escolha" title="Centro de Custo" <? if($_GET[tipo]=='centro')echo 'selected="selected"'; ?> >Centro de Custo</option>
        <option value="plano" id="plano_escolha" title="Plano de Conta" <? if($_GET[tipo]=='plano')echo 'selected="selected"'; ?> >Plano de Contas</option>
      </select> 
      <label id="centro" <? if($_GET[tipo]!='centro'){ ?> style="display:none;" <? } ?> >
      <select name="centro" id="s_centro">
      <option>- Centro de Custo -</option>
		  <? 
          $query_escolha = mysql_query("SELECT id,nome FROM financeiro_centro_custo WHERE centro_custo_id='0' AND cliente_id='$vkt_id' AND plano_ou_centro='centro' "); 
          while($f = mysql_fetch_object($query_escolha)){
			  
		  $query_sub = mysql_query("SELECT id, nome FROM financeiro_centro_custo WHERE  centro_custo_id='{$f->id}' AND cliente_id='$vkt_id'"); 
		  if(mysql_num_rows($query_sub)>0){$tem_sub=true;}
          ?>
          <option <? if($tem_sub){?> style="font-weight:bolder;" <? } ?> <? if($_GET[centro]==$f->id)echo "selected"; ?> value="<?=$f->id?>"> <?=$f->nome?> </option>
          <? 
		  
		  if($tem_sub){
			  while($sub=mysql_fetch_object($query_sub)){
				  ?><option style="margin-left:10px;" <? if($_GET[centro]==$sub->id)echo "selected"; ?>  value="<?=$sub->id?>"> - <?=$sub->nome?> </option> <?
			  }
		  }
		  $tem_sub=false;
		  
          } ?>
      </select>
  </label>
  <label id="plano" <? if($_GET[tipo]!='plano'){ ?> style="display:none;" <? } ?> >
      <select name="plano" id="s_plano">
      <option>- Plano de Conta -</option>
		  <? 
          $query_escolha = mysql_query("SELECT id,nome FROM financeiro_centro_custo WHERE centro_custo_id='0' AND plano_ou_centro = 'plano' AND cliente_id='$vkt_id'"); 
          while($f = mysql_fetch_object($query_escolha)){
			  
		  $query_sub = mysql_query("SELECT id, nome FROM financeiro_centro_custo WHERE centro_custo_id='{$f->id}' AND cliente_id='$vkt_id'"); 
		  if(mysql_num_rows($query_sub)>0){$tem_sub=true;}
          ?>
          <option <? if($tem_sub){?> style="font-weight:bolder;" <? } ?> <? if($_GET[plano]==$f->id)echo "selected"; ?> value="<?=$f->id?>"> <?=$f->nome?> </option>
          <? 
		  
		  if($tem_sub){ 
			  while($sub=mysql_fetch_object($query_sub)){
				  ?><option style="margin-left:10px;" <? if($_GET[plano]==$sub->id)echo "selected"; ?> value="<?=$sub->id?>"> - <?=$sub->nome?> </option> <?
			  }
		  }
		  $tem_sub=false;
		  
          } ?>
      </select>
  </label>
    De
    <?
    if(empty($_GET[filtro_inicio])&&empty($_GET[filtro_fim])){
		$filtro_inicio 	= date("Y-m-").'01';
		$filtro_fim		= date("Y-m-t");
		
	}else{
		$filtro_inicio 	= dataBrToUsa($_GET[filtro_inicio]);
		$filtro_fim		= dataBrToUsa($_GET[filtro_fim]);
	}
		$total_dias		= mysql_result(mysql_query($trace="SELECT DATEDIFF('$filtro_fim','$filtro_inicio')"),0,0);
	
	?>
    <input name="filtro_inicio" id="filtro_inicio" value="<?=dataUsaToBr($filtro_inicio)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0" >
    
     a
    <input name="filtro_fim" id="filtro_fim" value="<?=dataUsaToBr($filtro_fim)?>" size="9" maxlength="10"  mascara='__/__/____' calendario='1' style="height:11px;  margin:0; padding:0">
    <label>
        <select name="forma_pagamento" id="forma_pagamento">
        	<option>Forma de pagamento:</option>
            <option value="0" <? if($_GET[forma_pagamento]=='0')echo 'selected'; ?> >Todas</option>
            <option value="1" <? if($_GET[forma_pagamento]=='1')echo 'selected'; ?> >Dinheiro</option>
            <option value="2" <? if($_GET[forma_pagamento]=='2')echo 'selected'; ?> >Cheque</option>
            <option value="3" <? if($_GET[forma_pagamento]=='3')echo 'selected'; ?> >Cartao</option>
            <option value="4" <? if($_GET[forma_pagamento]=='4')echo 'selected'; ?> >Boleto</option>
            <option value="5" <? if($_GET[forma_pagamento]=='5')echo 'selected'; ?> >Permuta</option>
            <option value="6" <? if($_GET[forma_pagamento]=='6')echo 'selected'; ?> >Outros</option>
        </select>
    </label>
    <input type="hidden" name="tela_id" value="53" />
<input type="submit" name="button" id="button" value="Ir" />
</form>
</div>
<?

// for semanas

for($s=0;$s<5;$s++){

if($s==0){
?>
  <table cellpadding="0" cellspacing="0" width="100%"  >
    <thead>
      <tr>
<?
	for($i=0;$i<7;$i++){ 
		if($i==0&&$s==0){
			$primeiro_dia_semana = mysql_result(mysql_query("SELECT DATE_FORMAT('$filtro_inicio','%w')"),0,0);
			
			$dia = mysql_result(mysql_query("SELECT DATE_FORMAT('$filtro_inicio','%d')"),0,0);
		}
	

?>
        <td width="160"  ><?=$semana_abreviado[$i]?></td>
     <? } ?>
        <td align="center">Total</td>
        </tr>
    </thead>
  </table>
  <div id='dados' >
<script>resize()</script>

  <? }// fim do if semana
  ?>
  <table cellpadding="0" cellspacing="0" width="100%"  >
    <tbody>
      <tr>
        <?
       for($i=0;$i<7;$i++){ 
	   		if($primeiro_dia_semana<=$i||$s>0){
				$dia++;
			}
			if($s==0&&$i<$primeiro_dia_semana){
				$dia = -$primeiro_dia_semana+$i;
			}
			
			$data_info = mysql_result(mysql_query("SELECT DATE_ADD('$filtro_inicio', INTERVAL $dia DAY) "),0,0);
			$mes_info = mysql_result(mysql_query("SELECT date_format('$data_info', '%c') "),0,0);
			$dia_info = mysql_result(mysql_query("SELECT date_format('$data_info', '%d') "),0,0);

		?><td width="160"  class='smn<?=$i?>' >
		<b><?=$dia_info?>, <?=$mes_abreviado[$mes_info-1]?></b><?
			$q=mysql_query("SELECT * FROM financeiro_movimento WHERE cliente_id='$vkt_id' AND data_vencimento='$data_info' AND extorno='0' AND tipo='receber'");
			echo mysql_error();
		   while($r= mysql_fetch_object($q)){ 
		   	$total_seman["$s,$i"][]= $r->valor_cadastro;
		   	$total_seman["$s"][]= $r->valor_cadastro;
		   	$c = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id='$r->internauta_id'"));
			//echo mysql_error().$t;
			?><a class='opn' i='<?=$r->id?>' title="<?=$r->descricao ?>"><u><?=$c->razao_social?></u><i><s>R$</s> <?=$r->valor_cadastro?></i></a><?
		   }
		?></td> <?
	   } ?>
        <td  align="center">R$</td>
        </tr>
    </tbody>
  </table>
  <!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0"width="100%" >
  <thead>
    <tr>
    <?
       for($i=0;$i<7;$i++){ 
		?>
       	  <td width="160" style=""><?=@array_sum($total_seman["$s,$i"])?></td>
        <?
	   }
			
			?>
          	<td  align="right"><?=@array_sum($total_seman["$s"])?></td>
        </tr>
  </thead>
</table>

<?
}
?>

<script>
$('.opn').click(function(){
		window.open('modulos/financeiro/form_movimentacao.php?id='+$(this).attr('i'),'carregador')

	});
</script>
<script> 
 $(function() {
	$( document ).tooltip({
		track: true
	});
});
</script>

</div>

</div>
