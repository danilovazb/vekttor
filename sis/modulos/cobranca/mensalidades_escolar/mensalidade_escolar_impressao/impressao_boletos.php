<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
?>
<script src="<?=$caminho?>/mensalidade_escolar.js"></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
  <div id="some">«</div>
		<a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s1'>Escolar</a>
        <a href="./" class='s2'>
    Cobrança 
</a>
<a href="?tela_id=37" class="navegacao_ativo">
<span></span><?=$tela->nome?> 
</a>
</div>
<div id="barra_info">
    <a href="<?=$caminho?>/form.php" target="carregador" class="mais"></a>
	<form style=" float:left; padding:0; margin:0;" method="get">
    <label>
    	Aluno<input id="aluno_nome" name="aluno_nome" type="text" style="height:11px;" value="<?=$_GET['aluno_nome']?>" size="12" busca='<?=$caminho?>buscar_aluno.php,@r0 @r2,@r1-value>aluno_id,0' />
        <input type="hidden" name="aluno_id" id="aluno_id" value="<?=$_GET['aluno_id']?>">
    </label>
    <label>
        <select name="periodo_id">
        <option value="0">Todos os Períodos</option>
        <?
        $periodos_q=mysql_query("SELECT * FROM escolar2_periodo_letivo WHERE vkt_id='$vkt_id'");
		while($periodo=mysql_fetch_object($periodos_q)){
			if($_GET['periodo_id']==$periodo->id){$sel="selected='selected'";}else{$sel='';}
		?>
        	<option <?=$sel?> value="<?=$periodo->id?>"><?=$periodo->nome?></option>
        <? } ?>
        </select>
    </label>
    <label>
    <select name="ensino_id" style="width:120px;">
    <option value="0">Todos os Cursos</option>
     <?
        $cursos_q=mysql_query("SELECT * FROM escolar2_ensino WHERE vkt_id='$vkt_id'");
		while($curso=mysql_fetch_object($cursos_q)){
			if($_GET['curso_id']==$curso->id){$sel="selected='selected'";}else{$sel='';}
		?>
    	<option <?=$sel?> value="<?=$curso->id?>" ><?=$curso->nome?></option>
      <? } ?>
    </select>
    </label>
    <label>
    <select name="mes_vencimento">
    <option value="0">Mês Vencimento</option>
    <? foreach($mes_extenso as $i=>$m){ 
	if($_GET['mes_vencimento']==$i+1){$sel="selected='selected'";}else{$sel='';}
	?>
    	<option <?=$sel?> value="<?=$i+1?>"><?=$m?></option>
    <? } ?>
    </select>
    </label>
    <input type="hidden" name="tela_id" value="<?=$tela->id?>" />
    <input type="submit" value="Buscar" name="busca" />
</form>
</div>
<form action="<?=$caminho?>/tela_impressao.php" method="post" target="_blank">
<? if($_GET['busca']=='Buscar'){ ?>
<div id="barra_info"><input type="submit" formtarget="_blank" value="Imprimir" style="margin-top:3px;"/></div>
<? } ?>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="85">Cod. Cobrança</td>
            <td width="220">Aluno</td>
            <td width="75">Vencimento</td>
            <td width="70">Valor</td>
          <td width="75">Situação</td>
          <td width="70" align="center">Imprimir</td>
            <td></td>
        </tr>
    </thead>
</table>
<script type="text/javascript">
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
	<tbody>
    <?
	if($_GET['busca']=='Buscar'){
	$sql_add='';
	if($_GET['aluno_id']>0&&$_GET['aluno_nome']!=''){
		$sql_add.=" AND em.aluno_id='".$_GET['aluno_id']."'";
	}
	if($_GET['periodo_id']>0){
		$sql_add.=" AND et.periodo_letivo_id='".$_GET['periodo_id']."' ";
	}
	if($_GET['curso_id']>0){
		$sql_add.=" AND ee.id='".$_GET['curso_id']."' ";
	}
	if($_GET['cobranca_id']>0){
		$sql_add.=" AND em.origem_id='".$_GET['cobranca_id']."' ";
	}
	if($_GET['mes_vencimento']>0){
		$sql_add.=" AND MONTH(fm.data_vencimento)='".$_GET['mes_vencimento']."' ";
	}
	
	$boletos_q=mysql_query($x="
	SELECT
		fm.id as id,
		em.aluno_id as aluno_id,
		fm.valor_cadastro,
		fm.status as status,
		fm.origem_id as origem_id,
		DATE_FORMAT(fm.data_vencimento,'%d/%m/%Y') as data_vencimento 
	FROM
		financeiro_movimento as fm,
		escolar2_matriculas as em,
		escolar2_turmas as et,
		escolar2_series as es,
		escolar2_ensino as ee
	WHERE 
		fm.cliente_id='$vkt_id'
	AND
		et.id=em.turma_id
	AND
		es.id=et.serie_id
	AND
		ee.id=es.ensino_id
	$sql_add
	AND
		fm.doc=em.id
	");
	//echo $x;
	echo mysql_error();
	$sit[0]='pendente';
	$sit[1]='pago';
	$sit[2]='cancelado';
	while($boleto=mysql_fetch_object($boletos_q)){
		$aluno=mysql_fetch_object(mysql_query($x="SELECT * FROM escolar2_alunos WHERE id='$boleto->aluno_id'"));
	?>
    <tr>
    	<td width="85"><?=$boleto->origem_id?></td>
        <td width="220"><?=$aluno->nome?></td>
        <td width="75"><?=$boleto->data_vencimento?></td>
        <td width="70">R$<?=moedaUsaToBr($boleto->valor_cadastro)?></td>
        <td width="75"><?=$sit[$boleto->status]?></td>
        <td width="70" align="center"><input type="checkbox" name="boleto_id[]" value="<?=$boleto->id?>" checked /></td>
        <td></td>
    </tr>
    <? } 
	}?>
    </tbody>
</table>

</div>
</form>
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
