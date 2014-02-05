<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="60">Data</td>
            <td width="60" >Entrada</td>
            <td width="90" >Saída Almoço</td>
            <td width="90" >Retorno Almoço</td>
       	 	<td width="60" >Saída</td>
            <td width="35" >Faltas</td>
            <td width="35" >Total</td>
            <td width="35" >Saldo</td>
            <td width="100" >Adicional noturno</td>
          	<td width=""></td>
			
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<input type="hidden" name="listagem" id="listagem" value="2" />
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
<?php
	$utlimo_dia= date('t',mktime(01,01,01,$mes,01,$_GET[ano]));
	 for($i=1;$i<=$utlimo_dia;$i++){
			if($i<10){
				$dia = '0'.$i;	
			}else{
				$dia = $i;
			}
		$data = "$dia/".$mes.'/'.$_GET[ano];
		$data_folha = dataBrToUsa($data);
			
		$hora_extra = mysql_fetch_object(mysql_query($t="SELECT * FROM rh_hora_extra WHERE empresa_id='".$_GET[empresa1id]."' AND funcionario_id='".$_GET[funcionario_id]."' AND data='$data_folha' AND vkt_id='$vkt_id'"));
		$hora_entrada = substr($hora_extra->hora_entrada,0,-3);
		$hora_saida_almoco = substr($hora_extra->hora_saida_almoco,0,-3);
		$hora_retorno_almoco = substr($hora_extra->hora_retorno_almoco,0,-3);
		$hora_saida = substr($hora_extra->hora_saida,0,-3);
		//echo $t.mysql_error();
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
	?>       
    	<tr <?=$sel ?>>
    	  <td width="60">
    	    <?
			echo $data;
			 ?>
          <input type="hidden" name="data_hora_extra" class="data_hora_extra" value="<?=$data?>" />
          <input type="hidden" name="funcionario_id" class="funcionario_id" value="<?=$_GET[funcionario_id]?>" />
          
  	    </td>
          	<td width="60" ><input type="text" name="hora_entrada" class="hora_entrada" style="width:40px;height:10px;" sonumero="1" mascara="__:__" value="<?=$hora_entrada?>"></td>
            <td width="90" align="center"><input type="text" class="hora_saida_almoco" style="width:40px;height:10px;" sonumero="1" mascara="__:__" value="<?=$hora_saida_almoco?>"></td>
            <td width="90" align="center"><input type="text" class="hora_retorno_almoco" style="width:40px;height:10px;" sonumero="1" mascara="__:__" value="<?=$hora_retorno_almoco?>"></td>
       	 	<td width="60" ><input type="text" name="hora_saida" class="hora_saida" style="width:40px;height:10px;" sonumero="1" mascara="__:__" value="<?=$hora_saida?>"></td>
            <td width="35" ><input type="checkbox" name="faltas" class="faltas" ></td>
            <td width="35" id="t<?=$dia?>"><?=MoedaUsaToBr($hora_extra->total)?></td>
            <td width="35" id="s<?=$dia?>"><?=MoedaUsaToBr($hora_extra->saldo_horas)?></td>
            <td width="100" id="n<?=$dia?>"><?=MoedaUsaToBr($hora_extra->adicional_noturno)?></td>
          	<td width=""></td>
        </tr>
      
<?
	}
?>
    	
    </tbody>
</table>
<?
//print_r($_POST);
?>

</div>

<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="209"></td>
            <td width="98"align="right"></td>
            <td width=""></td>
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
<script>
$('#sub93').show();
$('#sub418').show()
</script>