<?php
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

//include("_functions.php");
//include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
$("div").on('click','#importar',function(){
	window.open('modulos/escolar/Inadimplentes/form_importar.php','carregador');
	//teste({a: [1 ,2 ,3, 4, 5]}, 'b', 'c', {hey: 'you', got: 'that?'});
});
$("#import_aluno").live('click',function(){
	window.open('modulos/escolar/alunos_reprovados/form_import_aluno.php','carregador');
});
</script>
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<div id="some">&laquo;</div>
<a href="#" class='s1'>SISTEMA</a>
        <a href="./" class='s2'>
    Escolar 
</a>
<a href="?tela_id=219" class="navegacao_ativo">
<span></span>Extrato Financeiro
</a>
</div>
<div id="barra_info">
	 
    <a href="<?=$caminho?>form.php" target="carregador" class="mais"></a>
    <!--<button style="float:right; margin-top:3px;" id="importar">Importar</button>-->
    <button type="button" id="import_aluno" style="float:left; margin-top:3px;" title="Importar alunos reprovados" data-placement="right">Importar</button>
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="50">Vencimento</td>
            <td width="75">Valor</td>
            <td width="190">Curso</td>
            <td width="190">Imprimir</td>
			<td></td>
        </tr>
    </thead>
</table>
<div id='dados'> 
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
	
	<?
	
	if(strlen($_GET[busca])>0){
		$busca_add = "AND a.nome like '%{$_GET[busca]}%'";
	}
	// necessario para paginacao
    $registros= mysql_result(mysql_query($t="SELECT count(*) FROM escolar_alunos a, escolar_alunos_bolsistas ab WHERE ab.vkt_id=$vkt_id $busca_add ORDER BY a.id DESC"),0,0);
   //echo $t;
	if($_GET['ordem']){
		$ordem=$_GET['ordem'];
	}else{
		$ordem="codigo_interno";
	}
	// colocar a funcao da paginação no limite 
	$sql = " SELECT * FROM financeiro_movimento AS financeiro 
				JOIN cliente_fornecedor AS responsavel ON financeiro.internauta_id = responsavel.id
				JOIN escolar_alunos AS aluno ON aluno.responsavel_id = responsavel.id
			WHERE financeiro.cliente_id = '$vkt_id'";
	echo $sql;
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$matricula = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_matriculas WHERE aluno_id = '$r->aluno_id'"));
		$turma = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_salas WHERE id = '$matricula->sala_id'"));
	?>
<tr <?=$sel?>onclick="window.open('<?=$caminho?>form.php?id=<?=$r->aluno_id?>','carregador')">
<td width="50"><?=str_pad($r->id,5,"0",STR_PAD_LEFT)?></td>
<td width="75"><?=$r->codigo_totvs?></td>
<td width="190"><?=LimitarString($r->nome,30)?></td>
<td width="90"><?=$r->telefone1?></td>
<td width="140"><?=LimitarString($r->email,20)?></td>
<td width="100"><?=LimitarString($turma->nome,15);?></td>
<td width="100"><?=$r->turno?></td>
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
           <td width="230"><a>Total: <?=$total?></a></td>
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
