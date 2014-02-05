<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 

?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js" type="text/javascript"></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='conteudo'>
<div id='navegacao'>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET['busca']?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<a href="./" class='s1'>
  	Sistema NV
</a>
<a href="./" class='s1'>
  	Eleitoral
</a>
<a href="./" class='s2'>
    Relatórios 
</a>
<a href="?tela_id=103" class="navegacao_ativo">
Relatório Outros Candidatos</a></div>
<?
if($_GET['politico_id']>0){ $filtro_politico=" AND ev.politico_id='{$_GET['politico_id']}' ";}else{ $filtro_politico='';}
$politico_q = mysql_query($trace="SELECT * FROM eleitoral_politicos ORDER BY nome ASC "); 
$votos_totais_eleitores=mysql_fetch_object(mysql_query("SELECT COUNT(*) as total FROM eleitoral_intencoes_voto as ev WHERE 1=1 AND status='1' AND eleitor_id!='0'"));
$votos_totais_colaboradores=mysql_fetch_object(mysql_query("SELECT COUNT(*) as total FROM eleitoral_intencoes_voto as ev WHERE 1=1 AND status='1' AND colaborador_id!='0'"));
$votos_totais = $votos_totais_eleitores->total + $votos_totais_colaboradores->total;
?>
<div id="barra_info">
    <a href="<?=$caminho?>/form_eleitor.php" target="carregador" class="mais"></a>
    <form id="politico">
    <label>Filtros
    	<select name="politico_id"><option>Todos</option>
        <? while($politico=mysql_fetch_object($politico_q)){ ?>
        	<option <? if($_GET['politico_id']==$politico->id){ echo "selected='selected'";} ?> value="<?=$politico->id?>"><?=$politico->nome?></option>
        <? } ?>
        </select>
      </label>
        <input type="hidden" name="tela_id" value="148" />
        <input type="submit" value="Filtrar" />
    </form>
</div>
<div id="dados">
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
	<div style="margin-left:15px; margin-top:10px;">Total Cadastrados:<?=$votos_totais?> </div>
    <div style="float:left; width:360px; height:200px; margin-left:15px; margin-top:20px; border:#CCC solid thin;">
<h4>Eleitores por Grupo Social</h4>
<?
	 $classe_social_votos_q=mysql_query(
	"SELECT * FROM eleitoral_grupos_sociais
		 "); 
		 echo mysql_error(); 
	while($classes=mysql_fetch_object($classe_social_votos_q)){
		
		$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(*) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
		WHERE
		ev.eleitor_id = e.id
		$filtro_politico
		AND e.grupo_social_id='{$classes->id}' 
		AND ev.status='1'
		"
		));
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(*) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_colaboradores as e 
		WHERE
		ev.colaborador_id = e.id
		$filtro_politico
		AND e.grupo_social_id='{$classes->id}' 
		AND ev.status='1'
		"
		));
		$total_classes=$votos_eleitores->qtd+$votos_colaboradores->qtd;
		$porcentagem_classes=(100*$total_classes)/$votos_totais;
		?>
		<span style="display:block;">
		<?=$classes->nome?> - Votos : <?=$total_classes?><? if($total_classes>0)echo ' | <strong>'.number_format($porcentagem_classes,2,',','.').'%</strong>';?>
        </span>
    <? }
	?>
    
    </div>
    
    <div style="float:left; width:360px; height:200px; margin-left:15px; margin-top:20px; border:#CCC solid thin;">
<h4>Eleitores por Grau de Instrução</h4>
<?		$graus_instrucao= array('analfabeto','fundamental incompleto','fundamental completo','superior incompleto','superior completo');
		foreach($graus_instrucao as $grau){
		$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
		WHERE
		ev.eleitor_id = e.id 
		$filtro_politico
		AND e.grau_instrucao='$grau'
		AND ev.status='1'
		"
		));
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_colaboradores as e 
		WHERE
		ev.colaborador_id = e.id 
		$filtro_politico
		AND e.grau_instrucao='$grau'
		AND ev.status='1'
		"
		));
		$total_graus=$votos_eleitores->qtd+$votos_colaboradores->qtd;
		$porcentagem_graus=(100*$total_graus)/$votos_totais;
		?>
		<span style="display:block;">
		<?=$grau?> - Votos : <?=$total_graus?><? if($total_graus>0)echo ' | '. number_format($porcentagem_graus,2,',','.').'%'?>
        </span>
    <? }
	?>
    
    </div>
    
    <div style="float:left; width:360px; height:200px; margin-left:15px; margin-top:20px; border:#CCC solid thin;">
<h4>Eleitores por Sexo</h4>
<?		$sexos= array('0','1');
		foreach($sexos as $sexo){
		$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
		WHERE
		ev.eleitor_id = e.id 
		$filtro_politico
		AND e.sexo='$sexo'
		AND ev.status='1'
		"
		));
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_colaboradores as e 
		WHERE
		ev.colaborador_id = e.id 
		$filtro_politico
		AND e.sexo='$sexo'
		AND ev.status='1'
		"
		));
		$total_sexo=$votos_eleitores->qtd+$votos_colaboradores->qtd;
		$porcentagem_sexo=(100*$total_sexo)/$votos_totais;
		?>
		<span style="display:block;">
		<? if($sexo=='1'){echo 'Masculino';}elseif($sexo=='0'){echo 'Feminino';}?> - <? if($total_sexo>0) echo 'Votos: '. $total_sexo.' | '.number_format($porcentagem_sexo,2,',','.').'%'?>
        </span>
    <? }
	?>
    
    </div>
    
    <div style="float:left; width:360px; height:200px; margin-left:15px; margin-top:20px; border:#CCC solid thin;">
<h4>Eleitores por Faixa Etária</h4>

		<span style="display:block;">
		16-24 : 289 | 15%
        </span>
        <span style="display:block;">
		25-32 : 1.524 | 15%
        </span>
        <span style="display:block;">
		33-46 : 2.512 | 15%
        </span>
        <span style="display:block;">
		47-52 : 532 | 15%
        </span>
        <span style="display:block;">
		53-62 : 120 | 15%
        </span>
        <span style="display:block;">
		63-72 : 21 | 15%
        </span>
        <span style="display:block;">
		73-120 : 1 | 15%
        </span>
    
    </div>
    
    
    
    <div style="float:left; width:360px; height:200px; margin-left:15px; margin-top:20px; border:#CCC solid thin;">
<h4>Eleitores por Bairro</h4>
<?
	 $bairro_votos_q=mysql_query(
	"SELECT * FROM eleitoral_bairros
		 "); 
		 echo mysql_error(); 
		while($bairro=mysql_fetch_object($bairro_votos_q)){
		$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
		WHERE
		ev.eleitor_id = e.id 
		$filtro_politico
		AND e.bairro_id='{$bairro->id}'
		AND ev.status='1'
		"
		));
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_colaboradores as e 
		WHERE
		ev.colaborador_id = e.id 
		$filtro_politico
		AND e.bairro_id='{$bairro->id}'
		AND ev.status='1'
		"
		));
		//echo $votossql;
		echo mysql_error();
		
		$total_bairros=$votos_eleitores->qtd+$votos_colaboradores->qtd;
		$porcentagem_bairros=(100*$total_bairros)/$votos_totais;
		?>
		<span style="display:block;">
		<?=$bairro->nome?> - Votos : <?=$total_bairros?><? if($total_bairros>0)echo ' | <strong>'.number_format($porcentagem_bairros,2,',','.').'%</strong>'?>
        </span>
    <? }
	?>
    
    </div>
    
    <div style="float:left; width:360px;  margin-left:15px; margin-top:20px; border:#CCC solid thin;">
<h4>Eleitores por Profissão</h4>
<?
	 $profissao_votos_q=mysql_query(
	"SELECT * FROM eleitoral_profissoes
		 "); 
		 echo mysql_error(); 
		while($profissao=mysql_fetch_object($profissao_votos_q)){
		$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
		WHERE
		ev.eleitor_id = e.id 
		$filtro_politico
		AND e.profissao_id='{$profissao->id}'
		AND ev.status='1'
		"
		));
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_colaboradores as e 
		WHERE
		ev.colaborador_id = e.id 
		$filtro_politico
		AND e.profissao_id='{$profissao->id}'
		AND ev.status='1'
		"
		));
		//echo $votossql;
		echo mysql_error();
		$total_profissoes=$votos_eleitores->qtd+$votos_colaboradores->qtd;
		$porcentagem_profissoes=(100*$total_profissoes)/$votos_totais;
		?>
		<span style="display:block;">
		<?=$profissao->descricao?> - Votos : <?=$total_profissoes?><? if($total_profissoes>0)echo ' | '. number_format($porcentagem_profissoes,2,',','.')?>
        </span>
    <? }
	?>
    
    </div>

</div>


</div>
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