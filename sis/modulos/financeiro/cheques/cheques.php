<?
include("modulos/financeiro/_functions_financeiro.php");
$caminho =$tela->caminho;
$dia_atual = date('d');
$mes_atual=date('m');
$ano_atual=date('Y');
if($_GET[mes])$mes=$_GET[mes];else $mes=$mes_atual;
if($_GET[ano])$mes=$_GET[ano];else $ano=$ano_atual;
//Includes
// configuração inicial do sistema
// funções base do sistema
$conta_id =$_GET['conta_id'];
$q= mysql_query("select * from financeiro_contas WHERE  cliente_vekttor_id ='".$_SESSION[usuario]->cliente_vekttor_id ."'order by preferencial DESC,nome");
while($r= mysql_fetch_object($q)){
	$x++;
	if($x==1&&$_GET[conta_id]<1){
	  $conta_id= $r->id; 
	  }
	if($r->id==$_GET[conta_id]){$sel = "selected='selected'";}else{$sel = "";}
	  $saldo=checaSaldo($r->cliente_vekttor_id ,$r->id );
	  $saldo=number_format($saldo,2,',','.');
	  $conta_info[] = "<option value='$r->id' $sel >$r->nome - R$ $saldo</option>";  
  }

$infotipo[1]='pago'; 
$infotipo[2]='recebido'; 

if($_GET[emitidos]!=1&&$_GET[recebidos]!=1){
	$tipo = 'pagar';
}else{
	if($_GET[emitidos]==1){
		$tipo = 'pagar';
	}
	if($_GET[recebidos]==1){
		$tipo = 'receber';
	}
	
}
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<script src="modulos/financeiro/financeiro.js"></script>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="devolvidos" value="<?=$_GET['recebidos']?>" />
	<input type="hidden" name="emitidos" value="<?=$_GET['emitidos']?>" />
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id="some">«</div>
<a href="#" class='s1'>
  	SISTEMA
</a>

<a href="?" class='s2'>
  	Financeiro
</a>
<a href="?tela_id=88" class='navegacao_ativo'>
<span></span>    Cheques
</a>
</div>
<div id="barra_info">
<form method="get" action="">
<input type="hidden"  name="tela_id" value="88" /> 
Conta
	<input type="hidden" name="devolvidos" value="<?=$_GET['recebidos']?>" />
	<input type="hidden" name="emitidos" value="<?=$_GET['emitidos']?>"  />

 <select name="conta_id" id="conta_id"  onchange="location='?tela_id=88&conta_id='+this.value">
              <?
			  
				echo implode("\n",$conta_info);  

			  ?>
			    
    </select>
    
    <input type="button" value="Emitidos" <? if($tipo=='pagar'){echo 'disabled="disabled"';} ?> 
    	onclick="location='?tela_id=88&emitidos=1&conta_id=<?=$conta_id?>'"/>
    <input type="button" value="Recebidos" <? if($tipo=='receber'){echo 'disabled="disabled"';} ?>
    	onclick="location='?tela_id=88&amp;recebidos=1&amp;conta_id=<?=$conta_id?>'"/>



</form>  
  
 </div>


<?
//pr($_POST);
include("_functions.php");
include("_ctrl.php");
/* FILTROS DE CONSULTA */

?>

<table cellpadding="0" cellspacing="0" width="100%" >
    <thead>
    	<tr>
        	<td width="80">Data</td>
        	<td width="80">Numero</td>
    	  	<td width="200">Fornecedor</td>
    	  	<td width="200">Descri&ccedil;&atilde;o</td>
    	  	<td width="80" style="margin:0; padding-left:10px; text-align:center">R$ Valor</td>
   	  	  <td width="80">Compensado</td>
            <td width="80">Devolvido</td>
            <td width="80">&nbsp;</td>
            <td></td>
        </tr>
    </thead>
</table>

<div id="dados">
<table cellpadding="0" cellspacing="0" width="100%"  >
    <tbody id="tabela_dados">
    <?
	
	if($_GET[busca]){
		$busca_add = " AND doc like '{$_GET['busca']}' ";
	}
	
	
	    $registros= mysql_result(mysql_query("SELECT 
		count(*)
	FROM financeiro_movimento
	WHERE
		forma_pagamento='2'
	AND 
		conta_id= '$conta_id'
	$busca_add	
	"),0,0);

	
	
    $contas_q=mysql_query(
	"
	SELECT * ,date_format(data_info_movimento ,'%d/%m/%Y') as d_vence
	FROM financeiro_movimento
	WHERE
		forma_pagamento='2'
	AND 
		conta_id= '$conta_id'
	AND
		tipo='$tipo'
	AND
		status='1'
	AND
		origem_tipo!= 'Extorno'
	$busca_add	
	
	ORDER BY doc DESC
	LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador])."
	");
	$linha=0;
	$total_previsto;



	
	
	while($r=mysql_fetch_object($contas_q)){
		if($linha%2)$sel="";else $sel=' class="al" ';
		$cliente = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$r->internauta_id'"));
		
		//verifica se extorno
		if($r->extorno=='1'){
			$extorno = 'sim';	
		}else{
			$extorno = '';	
		}
		
		
		?>
			<tr <?=$sel?> >
				<td width="80" align="center"><?=$r->d_vence?></td>
				<td width="80" align="center"><?=$r->doc?></td>
				<td width="200" ><?=$cliente->razao_social ?></td>
				<td width="200" ><?=$r->descricao ?></td>
				<td width="80" align="right"><?=moedaUsaToBr($total_Cheque[]=$r->saida )?></td>
			  <td width="80" align="center"><input onclick="co(this,<?=$r->id?>)" type="checkbox"<? if($r->conciliado ==1){echo 'checked="checked"'; }?>></td>
				
				<td width="80" align="center"><?=$extorno?></td>
				
				<td width="80" align="right">&nbsp;</td>
				<td></td>
			</tr>
		<? 
		$linha++; 
	} ?>
    </tbody>
</table>
</div>
<table cellpadding="0" cellspacing="0" width="100%" >
  <thead>
    <tr>
    	<td width="80"></td>
    	<td width="80"></td>
      <td width="200">Total</td>
      <td width="200">&nbsp;</td>
      <td width="80" align="right" >&nbsp;</td>
      <td width="80" align="right" >&nbsp;</td>
      <td width="80" align="right" >&nbsp;</td>
      <td width="80" align="right" >&nbsp;</td>
      <td></td>
    </tr>
  </thead>
</table>

<script>resize()</script><!-- Isso é Necessário para a criação o resize -->

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
