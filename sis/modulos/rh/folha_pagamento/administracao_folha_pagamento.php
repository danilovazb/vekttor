<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
include("_functions.php");
include("_ctrl.php"); 
$folha_pagamento= mysql_fetch_object(mysql_query("SELECT * from rh_folha_empresa WHERE id='".$_GET[folha_id]."'"));

//print_r($folha_pagamento);
$folha_numero = $folha_pagamento->mes+1;
if($folha_numero<10){
	$mes_folha = '0'.$folha_numero;
}else{
	$mes_folha = $folha_numero;
}

$ano_folha =$folha_pagamento->ano;

if($folha->mes==12){
	$folha_mes = "13&deg; Integral";
}
if($folha->mes==13){
	$folha_mes = "13&deg; Parcela 1";
}
if($folha->mes==14){
	$folha_mes = "13&deg; Parcela 2";
}
if(empty($folha_mes)){
	$folha_mes = $mes_extenso[$folha->mes];
}
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>
	$("#imprimir_contracheque_individual").live('click',function(){
		var folha_id = <?=$_GET['folha_id']?>;
		var folha_funcionario_id =  $(this).attr("funcionario_id");
		window.open('modulos/rh/folha_pagamento/impressao_contracheque.php?folha_id='+folha_id+'&funcionario_id='+folha_funcionario_id);
	});

	$("#gera_sefip").live('click',function(){
		
		var competencia = $("#competencia").val();
		var n = competencia.split("/");
		var empresa_id      = $("#empresa_id").val();
		var mes_competencia = n[0];
		var ano_competencia = n[1]; 
		var tipo_remessa    = $("#tipo_remessa").val();
		var modalidade_arquivo = $("#modalidade_arquivo").find("option").filter(":selected").val();
		var indicador_recolhimento_ps = $("select#indicador_recolhimento_ps").val();
		var salario_maternidade = moedaBrToUsa($("#salario_maternidade").val());
		
		window.open('modulos/rh/sefip/sefip.php?mes_competencia='+mes_competencia+'&salario_maternidade='+salario_maternidade+'&ano_competencia='+ano_competencia+'&empresa_id='+empresa_id+'&tipo_remessa='+tipo_remessa+'&modalidade_arquivo='+modalidade_arquivo+'&indicador_recolhimento_ps='+indicador_recolhimento_ps);
	});
</script>
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
  	Folha de pagamento
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
<input type="button" id="voltar" onclick="location.href='?tela_id=439&empresa_id=&empresa_id=<?=$folha->empresa_id?>'" value="<<"/>
<strong>EMPRESA:</strong> <?=$empresa->razao_social?> <strong>CNPJ:</strong><?=$empresa->cnpj_cpf?> <strong>Folha de Pagamento:</strong> <?=$folha_mes?> <?=$folha->ano?>
<button class="botao_imprimir" style="float:right; margin-top:2px; margin-right:5px;" onclick="window.open('modulos/rh/folha_pagamento/impressao_folha.php?folha_id=<?=$folha_id?>&ano=<?=$folha->ano?>&mes=<?=$folha->mes?>&empresa_id=<?=$folha->empresa_id?>')" type="button">
<img src="../fontes/img/imprimir.png">
</button>

<?
$mes_x=$folha->mes+1;
if($mes_x<10){
	$mes_x= '0'.$mes_x;
}
?>
<input type="button" value="Sefip" style="float:right; margin-top:2px;" onclick="window.open('modulos/rh/sefip/form.php?empresa_id=<?=$empresa->id?>&competencia=<?=$mes_x.'/'.$folha->ano?>&empresa=<?=$empresa->razao_social?>','carregador');" />

<button class="botao_imprimir" style="float:right; margin-top:2px; margin-right:5px;" onclick="window.open('modulos/rh/folha_pagamento/impressao_contracheque.php?folha_id=<?=$folha_id?>')" type="button">
Contracheques
</button>


<? if($folha->status=='em aberto'){ ?>
<button class="botao_imprimir" style="float:right; margin-top:2px; margin-right:5px;" onclick="location.href='?tela_id=439&action=confirmarFolha&folha_id_confirmar=<?=$folha->id?>&empresa_id=<?=$folha->empresa_id?>'" type="button">
Confirmar Folha
</button>
<? } ?>

<button <?=$permite_excluir?> class="botao_imprimir" style="float:right; margin-top:2px; margin-right:5px;" onclick="location.href='?tela_id=<?=$link_exclusao[$tela->id]?>&action=excluirFolha&folha_id_deletar=<?=$folha->id?>&empresa_id=<?=$folha->empresa_id?>'" type="button">
Excluir Folha
</button>

  </div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
            <td width="150"><?=linkOrdem("Funcionário","nome",1)?></td>
          	<td width="60" >Salário R$</td>
            <td width="60" >Horas</td>
            <td width="70" >Horas 50%</td>
            <td width="80" >Horas 100%</td>
            <td width="80" >Adc. Noturno</td>
            <td width="60" >Comissão</td>
            <td width="70" >Gratificação</td>
            <td width="40" >Faltas</td>
            <td width="80" >Adiantamento</td>
          	<td width=""></td>
        </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%">
    <tbody>
    <?
	if(!empty($_GET['busca'])){
		$filtro = " AND nome like '%".$_GET['busca']."%'";
	}
	
	
	$registros= mysql_result(mysql_query($t="SELECT COUNT(*) FROM 
						rh_folha_funcionarios as ff,
					  	rh_funcionario f
					  WHERE
						  ff.empresa_id='".$empresa->id."' AND
						  ff.rh_folha_id='{$folha->id}' AND
						  ff.vkt_id='$vkt_id' AND
						  ff.funcionario_id=f.id
						  $filtro"),0,0);
					  echo mysql_error();
	$q = mysql_query($t="SELECT f.id as id, ff.id as folha_id, ff.salario as salario, f.*, ff.* , TIME_FORMAT(horas_trabalhadas,'%k:%i') as horas_trabalhadas, f.id as funcionario_id,f.adicional_noturno
					FROM 
					  	rh_folha_funcionarios as ff,
					  	rh_funcionario f
					  WHERE
						  ff.empresa_id='".$empresa->id."' AND
						  ff.rh_folha_id='{$folha->id}' AND
						  ff.vkt_id='$vkt_id' AND
						  ff.funcionario_id=f.id
						  $filtro
						ORDER BY nome
						LIMIT ".paginacao_limite($registros,$_GET[pagina],$_GET[limitador]));
	while($r=mysql_fetch_object($q)){
		$horas_trabalhadas=$r->horas_trabalhadas;
		
		/* cálculo da quantidade de filhos menores de 14 anos */
		$total++;
		if($total%2){$sel='class="al folha_funcionario"';}else{$sel='class="folha_funcionario"';}
		
		 $ferias_sql = mysql_fetch_object(mysql_query($t="SELECT * FROM `rh_ferias` WHERE  funcionario_id ='$r->funcionario_id' AND month(data_inicio)=$mes_folha AND YEAR(data_inicio)=$ano_folha"));  

if($ferias_sql->id<1){
	$infoferias = '';
}else{
	$infoferias = 'Ferias';
}
	?>
    	<tr <?=$sel?> >
          	<td width="150" title="<?=$r->nome?>" rel='tip' data-placement='right' >
            	<input class="folha_funcionario_id" value="<?=$r->folha_id?>" type="hidden" />
                <input class="salario" value="<?=$r->salario?>" type="hidden" />
                <input class="filhos_salario_familia" value="<?=$r->salario_familia_qtd?>" type="hidden" />
                <input class="porcentagem_periculosidade" value="<?=$r->adicional_periculosidade?>" type="hidden" />
                <input class="porcentagem_insalubridade" value="<?=$r->adicional_insalubridade?>" type="hidden" />
                <input class="adicional_noturno" value="<?=$r->adicional_noturno?>" type="hidden" />
                <input class="vale_transporte" value="<?=$r->vale_transporte?>" type="hidden" />
                <?=substr($r->nome,0,30)?>
            </td>
          	<td width="60" align="right"><?=moedaUsaToBR($r->salario)?></td>
            <td width="60" ><input <?=$d?> class="horas_trabalhadas" value="<?=$horas_trabalhadas?>" style="width:40px; height:10px;" /></td>
            <td width="70" ><input <?=$d?> class="horas_50" value="<?=substr($r->horas_extras_horas_50,0,strpos($r->horas_extras_horas_50,':',4))?>" style="width:40px; height:10px;" /></td>
            <td width="80" ><input <?=$d?> class="horas_100" value="<?=substr($r->horas_extras_horas_100,0,strpos($r->horas_extras_horas_100,':',4))?>" style="width:40px; height:10px;"  /></td>
            <td width="80" ><input <?=$d?> class="horas_trabalhadas_noite" value="<?=substr($r->horas_trabalhadas_noite,0,-3)?>" style="width:40px; height:10px;" /></td>
            <td width="60" ><input <?=$d?> class="comissao" value="<?=MoedaUsaToBr($r->comissao)?>" style="width:50px; height:10px;" /></td>
            <td width="70" ><input <?=$d?> class="gratificacao" value="<?=MoedaUsaToBr($r->gratificacao)?>" style="width:50px; height:10px;" /></td>
            <td width="40" ><input <?=$d?> class="faltas" value="<?=qtdUsaToBr_($r->faltas*1)?>" style="width:30px; height:10px;" /></td>
            <td width="80" ><input <?=$d?> class="adiantamento" value="<?=MoedaUsaToBr($r->deducao_adiantamento)?>" style="width:70px; height:10px;" /></td>
            <td><?=$infoferias?> <input type="button" name="imprimir_contracheque_individual" id="imprimir_contracheque_individual" value="Contracheque" funcionario_id="<?=$r->funcionario_id?>"/></td>
        </tr>
<?
	}
?>
    	
    </tbody>
</table>
<?
if(strlen($folha->mes)==1){
	$mes='0'.$folha->mes;
}else{
	$mes=$folha->mes;
}
?>
<input type="hidden" id="mes" value="<?=$folha->mes?>" />
<input type="hidden" id="ano" value="<?=$folha->ano?>" />
<script>
function salvaFolha(t){
	mes=$("#mes").val();
	ano=$("#ano").val();
	salario=$(t.parentNode.parentNode).find('.salario').val()
	horas_trabalhadas=$(t.parentNode.parentNode).find('.horas_trabalhadas').val()
	horas_trabalhadas_noite=$(t.parentNode.parentNode).find('.horas_trabalhadas_noite').val()
	folha_funcionario_id=$(t.parentNode.parentNode).find('.folha_funcionario_id').val()
	horas_50=$(t.parentNode.parentNode).find('.horas_50').val()
	horas_100=$(t.parentNode.parentNode).find('.horas_100').val()
	comissao=$(t.parentNode.parentNode).find('.comissao').val()
	gratificacao=$(t.parentNode.parentNode).find('.gratificacao').val()
	faltas=$(t.parentNode.parentNode).find('.faltas').val()
	adiantamento=$(t.parentNode.parentNode).find('.adiantamento').val()
	filhos=$(t.parentNode.parentNode).find('.filhos_salario_familia').val()
	porcentagem_periculosidade=$(t.parentNode.parentNode).find('.porcentagem_periculosidade').val()
	porcentagem_insalubridade=$(t.parentNode.parentNode).find('.porcentagem_insalubridade').val()
	porcentagem_valetransporte=$(t.parentNode.parentNode).find('.vale_transporte').val();
	adicional_noturno=$(t.parentNode.parentNode).find('.adicional_noturno').val()
	
	
	/*console.log(horas_50 + ' | '+horas_100+' | '+comissao+ ' | '+gratificacao+ ' | '+faltas+' | '+adiantamento);*/
	window.open('<?=$caminho?>acao.php?folha_id=<?=$folha->id?>&action=atualizaFolha&folha_funcionario_id='+folha_funcionario_id+'&salario='+salario+'&horas_trabalhadas='+horas_trabalhadas+'&horas_trabalhadas_noite='+horas_trabalhadas_noite+'&horas_extras_horas_50='+horas_50+'&horas_extras_horas_100='+horas_100+'&comissao='+comissao+'&gratificacao='+gratificacao+'&faltas='+faltas+'&deducao_adiantamento='+adiantamento+'&mes='+mes+'&ano='+ano+'&filhos_salario_familia='+filhos+'&pct_periculosidade='+porcentagem_periculosidade+'&pct_insalubridade='+porcentagem_insalubridade+'&pct_valetransporte='+porcentagem_valetransporte+'&adicional_noturno='+adicional_noturno,'carregador');
}

$(".folha_funcionario input").blur(function(){
	salvaFolha(this);
});

</script>
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
<div style="clear:both;"></div>
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

/*
$('#sub93').show();
$('#sub418').show()
*/
some_menu();
</script>