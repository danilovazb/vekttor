<?
include("_functions.php");
include("_ctrl.php"); 

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
  	Cobranca
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
</a>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>
<div id="barra_info">   
<form action="" method="get">
   	
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <label>
    	Ano
    	<input type="text" value="<? if(empty($_GET['ano'])){ echo date('Y');}else{ echo $_GET['ano'];}?>" name="ano" onkeydown="if(event.keyCode==13){this.parentNode.submit()}" style="width:40px;height:10px;" maxlength="4" sonumero="1"/>
    </label>
    <input type="submit" value="Filtrar" onkeydown="if(event.keyCode==13){this.parentNode.submit()}" maxlength="4"/>
    
</form>  
  </div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="110">Mes</td>
            <td width="110">Valor Total</td>
          	<td width="110">Valor Pago</td>
            <td width="110">Valor Pendente</td>
          	
            <td></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
	if(empty($_GET['ano'])){
		$filtro =" AND YEAR(data_vencimento)=".date('Y');
		$ano=date('Y');
	}else{
		$filtro =" AND YEAR(data_vencimento)='".$_GET['ano']."'";
		$ano=$_GET['ano'];
	}
	
	
	for($i=1;$i<=12;$i++){
		
		$valor_total= mysql_fetch_object(mysql_query($t="SELECT SUM(valor) as total FROM 
		rh_cobranca_empresas
		WHERE 
		MONTH(data_vencimento)=$i
		$filtro AND
		vkt_id ='$vkt_id' 
		"));
		//echo $t;
		$pagos= mysql_fetch_object(mysql_query($t="SELECT SUM(valor) as total FROM 
		rh_cobranca_empresas
		WHERE 
		MONTH(data_vencimento)=$i
		$filtro AND
		situacao='1' AND
		vkt_id ='$vkt_id' 
		"));
		
		$naopagos= mysql_fetch_object(mysql_query($t="SELECT SUM(valor) as total FROM 
		rh_cobranca_empresas
		WHERE 
		MONTH(data_vencimento)=$i
		$filtro AND
		situacao='0' AND
		vkt_id ='$vkt_id' 
		"));
		//echo $t."<br>";
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
	?>
<tr <?=$sel?>>
<td width="110" align="right"><?=mes($i)?></td>
<td width="110"><? if($valor_total->total>0){ echo MoedaUsaToBr($valor_total->total);}else{ echo "0,00";}?></td>
<td width="110" onClick="location.href='?tela_id=431&mes=<?=$i?>&ano=<?=$ano?>&situacao=1'"><? if($pagos->total>0){ echo MoedaUsaToBr($pagos->total);}else{ echo "0,00";}?></td>
  <td width="110" onClick="location.href='?tela_id=431&mes=<?=$i?>&ano=<?=$ano?>&situacao=0'"><? if($naopagos->total>0){ echo MoedaUsaToBr($naopagos->total);}else{ echo "0,00";}?></td>
<td></td>
</tr>
<?
	}
	?>	
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="50">&nbsp;</td>
           <td width="230"><a></a></td>
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