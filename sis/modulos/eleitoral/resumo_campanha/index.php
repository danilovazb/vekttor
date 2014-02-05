<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho = $tela->caminho; 

?>
<style>
	#pagina{
			
			width:100%;
			height:1010px;
			background:#FFFFFF;
			overflow:auto;
		}
</style>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
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

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		
	
});
</script>

<div id='conteudo'>
<div id="some"><<</div>
<div id='navegacao'>
<a href="?" class='s1'>
  	Sistema
</a>
<a href="?" class='s2'>
  	Eleitoral
</a>
<a href="?tela_id=<?=$tela->id?>" class='navegacao_ativo'>
<span></span>    <?=$tela->nome?>
   	 </a>
    	
</div>

<div id="barra_info">
	
  <a href="modulos/rh/cargos_salarios/form.php" target="carregador" class="mais"></a>
</div>
<script>
$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
	
		window.open('modulos/rh/cargos_salarios/form.php?id='+id,'carregador');
	});
});
</script>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>

<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
		/*if($cliente_tipo_id!='7'){
			$filtro_servicos=" WHERE c.imobiliaria_id='$login_id' ";
		}else{
			$filtro_corretores=' WHERE 1=1 ';
		}*/
		if(!empty($_GET['busca'])){
			$filtro = " AND cargo like '%".$_GET['busca']."%'";
		}
		
		$registros= mysql_result(mysql_query("SELECT count(*) FROM cargo_salario WHERE vkt_id='$vkt_id'
							$filtro"),0,0);
		
		$sql = mysql_query($t="SELECT
								*
							FROM cargo_salario WHERE vkt_id='$vkt_id'
							$filtro
						");
						
		echo mysql_error();	
				while($r=mysql_fetch_object($sql)){
		
	?>      
    	<tr <?=$sel?> id="<?=$r->id?>" >
          <td width="60"><?=$r->id?></td>
          <td width="200"><?=$r->cargo;?></td>
          <td width="50"><?=moedaUsaToBr($r->valor_salario);?></td>
          <td></td>
        </tr>
<?php
				}
?>
    	
    </tbody>
</table>
<script>


</script>
<?
//print_r($_POST);
?>
</div>

</div>

</div>
<?

/* FILTROS */
//if(strlen($_GET['status_voto'])>0 && $_GET['status_voto']!='0'){ $filro_status_voto= " AND ev.status_voto='{$_GET['status_voto']}'";}else{$filro_status='';}
if(strlen($_GET['bairro'])>0){ $filro_bairro= " AND e.bairro='{$_GET['bairro']}' ";}else{$filro_bairro='';}
if($_GET['coordenador_id']>0){$filtro_coordenador="AND coordenador_id='{$_GET['coordenador_id']}'";}else{$filtro_coordenador='';}
if($_GET['grupo_social']>0){$filtro_grupo_social="AND grupo_social_id='{$_GET['grupo_social']}'";}else{$filtro_grupo_social='';}
/*********/

$filtro_sql_vkt=" AND vkt_id='$vkt_id'";
//$votos_totais_eleitores=mysql_fetch_object(mysql_query($y="SELECT COUNT(*) as total FROM eleitoral_intencoes_voto as ev WHERE 1=1 AND status='1' AND eleitor_id!='0' AND politico_id='0' $filtro_sql_vkt"));
//$votos_totais_colaboradores=mysql_fetch_object(mysql_query($g="SELECT COUNT(*) as total FROM eleitoral_intencoes_voto as ev WHERE 1=1 AND status='1' AND colaborador_id!='0' AND politico_id='0' $filtro_sql_vkt"));
$votos_eleitores = mysql_fetch_object(mysql_query($y="SELECT COUNT(*) as total FROM eleitoral_eleitores as ev WHERE vkt_id='$vkt_id'")); 
$votos_totais = $votos_eleitores->total;


?>
<div id="barra_info">
    <a href="<?=$caminho?>/form_eleitor.php" target="carregador" class="mais"></a>
    <form onsubmit="if(document.getElementById('bairro_existe').value!='1'&&document.getElementById('bairro').value!=''){alert('bairro nao cadastrado'); return false;}">
    <label>Coordenadores
    	<select name="coordenador_id" id="coordenador_id"><option value="0">Todos</option>
        <?	$coordenadores_q=mysql_query("SELECT * FROM eleitoral_colaboradores WHERE tipo_colaborador='0' $filtro_sql_vkt ");
			while($coordenador=mysql_fetch_object($coordenadores_q)){ ?>
        	<option <? if($_GET['coordenador_id']==$coordenador->id){ echo "selected='selected'";} ?> value="<?=$coordenador->id?>"><?=$coordenador->nome?></option>
        <? }
		 ?>
        </select>
      </label>
    <label>Bairro
        <input type="text" id='bairro' name="bairro" style="height:10px;" value="<?=$_GET['bairro']?>" busca='modulos/eleitoral/resumo_campanha/busca_bairro.php,@r0,@r0-value>bairro|@r1-value>bairro_existe,0'/>
        <input type="hidden" id="bairro_existe" name="bairro_existe" value="<?=$_GET['bairro_existe']?>" />
      </label>
      <label>Status do Voto
    	<select id="status_voto" name="status_voto">
        	<option value="0">Todos</option>
            <option value="sim">Sim</option>
            <option value="nao">Não</option>
            <option value="incerto">incerto</option>
            <option value="aberto">Em Aberto</option>
        </select>
      </label>
       <label style="width:200px;">
    Selecione um grupo social
    <select id='grupo_social' name="grupo_social"/>
    	<?php
			$grupos_sociais = mysql_query("SELECT * FROM eleitoral_grupos_sociais WHERE vkt_id='$vkt_id' LIMIT 10");
			while($grupo_social = mysql_fetch_object($grupos_sociais)){
        ?>
        	<option value="<?=$grupo_social->id?>"><?=$grupo_social->nome?></option>
        <?php
			}
		?>
    </select>
  </label>
        <input type="hidden" name="tela_id" value="148" />
        
        <input type="submit" value="Filtrar" />
        
    </form>
</div>
<div id="dados">
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<div id="pagina">
	<div style="margin-left:15px; margin-top:10px;">Total Cadastrados:<?=$votos_totais?>  </div>
    <div style=" width:585px;height:300px; margin-left:15px; margin-top:20px; border:#CCC solid thin;overflow:hidden;">
<center><h4>Eleitores por Grupo Social</h4></center>
            <div id='chart_div' style="float:right;"></div>

<?
	 $classe_social_votos_q=mysql_query(
	"SELECT * FROM eleitoral_grupos_sociais WHERE vkt_id='$vkt_id'
		 LIMIT 10"); 
		 echo mysql_error();
		 $cont=0;
		//unset($porc); 
	while($classes=mysql_fetch_object($classe_social_votos_q)){
		
		/*$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(*) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
		WHERE
		ev.eleitor_id = e.id
		AND ev.politico_id='0' 
		AND e.grupo_social_id='{$classes->id}' 
		AND ev.status='1'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		AND ev.vkt_id='$vkt_id'
		AND e.vkt_id='$vkt_id'
		"));
		//echo $votossql;
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(*) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_colaboradores as e 
		WHERE
		ev.colaborador_id = e.id
		AND ev.politico_id='0' 
		AND e.grupo_social_id='{$classes->id}' 
		AND ev.status='1'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		AND ev.vkt_id='$vkt_id'
		AND e.vkt_id='$vkt_id'
		"
		));*/
		$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(*) as qtd FROM eleitoral_eleitores 
		WHERE
		grupo_social_id='{$classes->id}' 
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		
		AND vkt_id='$vkt_id'
		"));
		//echo $votossql;
		$total_grupos=$votos_eleitores->qtd;
		//echo $votossql;
		$porc[$cont]['votos']=$total_grupos;
		$porcentagem=@((100*$porc[$cont]['votos'])/$votos_totais);
		$porc[$cont]['porc']=$porcentagem;
	//$porc[$cont]['religiao_id']=$religiao->id;
		$porc[$cont]['nome']=$classes->nome;
		$cont++;		
	}
		
	if(isset($porc)){
		array_multisort($porc,SORT_DESC);
		foreach($porc as $porcentagem){
			$dados_grafico1[] = "['{$porcentagem['nome']}', {$porcentagem['votos']} ]";
		?>
			<span style="display:block;">
            
            

		<?=$porcentagem['nome']?>  Votos : <?=$porcentagem['votos'];
		if($porcentagem['votos']>0){
			echo ' | <strong>'.number_format($porcentagem['porc'],2,',','.').'%</strong>';}
		else{
			echo " |<strong> 0.00%</strong>";
		}?>
        </span>
    	<?
       }
		}
		?>

    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
	  function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows([
			<?=implode(",",$dados_grafico1)?>         
        ]);

        var options = {
          width: 350, height: 200,
          title: '% de Votos por Grupo Social'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
    
    </div>
    
    <div style=" width:585px; height:300px; margin-left:15px; margin-top:20px; border:#CCC solid thin;">
<center><h4>Eleitores por Grau de Instrução</h4></center>
<div id='chart_grau' style="float:right;"></div>
<?		
		$graus_instrucao= array('analfabeto'=>'Analfabeto','fundamental incompleto'=>'Fundamental Incompleto','fundamental completo'=>'Fundamental Completo','emincompleto'=>'Ensino Médio Incompleto','Ensino Médio Completo','superior incompleto'=>'Superior Incompleto','superior completo'=>'Superior Completo','outros');

		foreach($graus_instrucao as $grau){
		
		/*$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
		WHERE
		ev.eleitor_id = e.id 
		AND ev.politico_id='0' 
		AND e.grau_instrucao='$grau'
		AND ev.status='1'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		AND ev.vkt_id='$vkt_id'
		AND e.vkt_id='$vkt_id'
		"
		));
		
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_colaboradores as e 
		WHERE
		ev.colaborador_id = e.id 
		AND ev.politico_id='0' 
		AND e.grau_instrucao='$grau'
		AND ev.status='1'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		AND ev.vkt_id='$vkt_id'
		AND e.vkt_id='$vkt_id'
		"
		));*/
		$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(id) as qtd FROM eleitoral_eleitores 
		WHERE
		grau_instrucao='$grau'
		AND vkt_id='$vkt_id'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		$filtro_grupo_social
		"
		));
		//echo $votossql;
		
		$total_graus=$votos_eleitores->qtd;
		$porcentagem_graus=@((100*$total_graus)/$votos_totais);
		//if($total_graus>0){
			$dados_grafico_grau[] = "['{$grau}', {$porcentagem_graus}]";
		?>
       <span style="display:block;">
		<?=$grau?> - Votos : <?=$total_graus?><? if($total_graus>0){echo ' | <strong>'. number_format($porcentagem_graus,2,',','.').'%</strong>';}else{echo $total_graus.' | <strong>0.00%</strong>';}?>
        </span>
    <? //}
	}
	?>
<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChartInstrucao);
	function drawChartInstrucao() {
    var data = new google.visualization.DataTable();
    data.addColumn('string', 'Task');
    data.addColumn('number', 'Hours per Day');
    data.addRows([
		<?=implode(",",$dados_grafico_grau)?>         
    ]);
    var options = {
		width: 350, height: 200,
        title: '% por religiao'
    };

        var chart = new google.visualization.PieChart(document.getElementById('chart_grau'));
        chart.draw(data, options);
      	}
</script>
    </div>
    
    <div style=" width:585px; height:260px; margin-left:15px; margin-top:20px; border:#CCC solid thin;">
<center><h4>Eleitores por Status voto</h4></center>
<div id='chart_voto' style="float:right;"></div>
		<? $status_todos=array('sim'=>'Sim','nao'=>'Não','incerto'=>'Incerto','aberto'=>'Em aberto'); 
			foreach($status_todos as $status=>$exib){
				/*$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
				WHERE
				ev.eleitor_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status_voto='$status'
				AND ev.status='1'
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
				"
				));
				$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_colaboradores as e 
				WHERE
				ev.colaborador_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status_voto='$status'
				AND ev.status='1'
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
				"
				));*/
				
				$total_status=$votos_eleitores->qtd+$votos_colaboradores->qtd;
				$porcentagem_status=@((100*$total_status)/$votos_totais);
				$dados_grafico_voto[] = "['{$status}', {$porcentagem_status}]";
		?>
			
            <span style="display:block;">
            <?=$exib?>: <?=$total_status?>  | <?='<strong>'.number_format($porcentagem_status,2,',','.').'</strong>'?>%
            </span>
            	
		<?	}
		?>
    	    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
	  function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows([
			<?=implode(",",$dados_grafico_voto)?>         
        ]);

        var options = {
          width: 350, height: 200,
          title: '% de Votos por Grau de Instruçao'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_voto'));
        chart.draw(data, options);
      }
	  
    </script>
    </div>
    
    
    
    
    <div style=" width:585px; height:260px; margin-left:15px; margin-top:20px; border:#CCC solid thin;">
<center><h4>Eleitores por Faixa Etária</h4></center>
<div id="chart_etaria" style="float:right;"></div>
		<? 
		/*$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
				WHERE
				ev.eleitor_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status='1'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) >= '16'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) <= '20'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
			
				"));
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
				WHERE
				ev.colaborador_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status='1'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) >= '16'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) <= '20'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
				"));*/
				$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(id) as qtd FROM eleitoral_eleitores  
				WHERE
				FLOOR(DATEDIFF(CURRENT_DATE, data_nascimento)/365.25) >= '16'
				AND FLOOR(DATEDIFF(CURRENT_DATE, data_nascimento)/365.25) <= '20' AND
				vkt_id='$vkt_id'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				$filtro_grupo_social
				
				
			
				"));
				$total_idade=$votos_eleitores->qtd;
				$porcentagem_idade=@((100*$total_idade)/$votos_totais);
				$faixa="16 a 20";
				$dados_grafico_faixa[]="['{$faixa}',{$porcentagem_idade}]";
		?>
		<span style="display:block; margin-bottom:8px;">
		16-20 : <?=$total_idade?>  <? //'<strong>'.$porcentagem_idade.'%</strong>'?>
        </span>
        <? 
		/*$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
				WHERE
				ev.eleitor_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status='1'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) >= '21'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) <= '24'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
			
				"));
				
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
				WHERE
				ev.colaborador_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status='1'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) >= '21'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) <= '24'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
				"));*/
				$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(id) as qtd FROM eleitoral_eleitores 
				WHERE
				
				FLOOR(DATEDIFF(CURRENT_DATE, data_nascimento)/365.25) >= '21'
				AND FLOOR(DATEDIFF(CURRENT_DATE, data_nascimento)/365.25) <= '24' AND
				vkt_id='$vkt_id'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				$filtro_grupo_social
				
			
				"));
				
				$total_idade=$votos_eleitores->qtd;
				$porcentagem_idade=@((100*$total_idade)/$votos_totais);
				$faixa="21 a 24";
				$dados_grafico_faixa[]="['{$faixa}',{$porcentagem_idade}]";
		?>
		<span style="display:block; margin-bottom:8px;">
		21-24 : <?=$total_idade?>  <? //'<strong>'.$porcentagem_idade.'%</strong>'?>
        </span>
         <? 
		/*$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
				WHERE
				ev.eleitor_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status='1'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) >= '25'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) <= '34'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
			
				"));
				
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
				WHERE
				ev.colaborador_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status='1'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) >= '25'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) <= '34'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
				"));*/
				$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(id) as qtd FROM eleitoral_eleitores 
				WHERE
				FLOOR(DATEDIFF(CURRENT_DATE, data_nascimento)/365.25) >= '25'
				AND FLOOR(DATEDIFF(CURRENT_DATE, data_nascimento)/365.25) <= '34' AND
				vkt_id='$vkt_id'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				$filtro_grupo_social
				
			
				"));
				//echo $votossql;
				$total_idade=$votos_eleitores->qtd;
				$porcentagem_idade=@((100*$total_idade)/$votos_totais);
				$faixa="25 a 34";
				$dados_grafico_faixa[]="['{$faixa}',{$porcentagem_idade}]";
		?>
		<span style="display:block; margin-bottom:8px;">
		25-34 : <?=$total_idade?>  <? //'<strong>'.$porcentagem_idade.'%</strong>'?>
        </span>
        <? 
		/*$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
				WHERE
				ev.eleitor_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status='1'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) >= '35'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) <= '44'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
			
				"));
				
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
				WHERE
				ev.colaborador_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status='1'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) >= '35'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) <= '44'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
				"));*/
				$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(id) as qtd FROM eleitoral_eleitores as e 
				WHERE
				FLOOR(DATEDIFF(CURRENT_DATE, data_nascimento)/365.25) >= '35'
				AND FLOOR(DATEDIFF(CURRENT_DATE, data_nascimento)/365.25) <= '44' AND
				vkt_id='$vkt_id'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				$filtro_grupo_social
				
			
				"));
				$total_idade=$votos_eleitores->qtd;
				$porcentagem_idade=@((100*$total_idade)/$votos_totais);
				$faixa="35 a 44";
				$dados_grafico_faixa[]="['{$faixa}',{$porcentagem_idade}]";
		?>
		<span style="display:block; margin-bottom:8px;">
		35-44 : <?=$total_idade?>  <? //'<strong>'.$porcentagem_idade.'%</strong>'?>
        </span>
        <? 
		/*$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
				WHERE
				ev.eleitor_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status='1'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) >= '45'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) <= '59'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
			
				"));
				
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
				WHERE
				ev.colaborador_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status='1'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) >= '45'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) <= '59'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
				"));*/
				$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(id) as qtd FROM eleitoral_eleitores 
				WHERE
				FLOOR(DATEDIFF(CURRENT_DATE, data_nascimento)/365.25) >= '45'
				AND FLOOR(DATEDIFF(CURRENT_DATE, data_nascimento)/365.25) <= '59' AND
				vkt_id='$vkt_id'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				$filtro_grupo_social
				
			
				"));
				//echo mysql_error();
				$total_idade=$votos_eleitores->qtd;
				$porcentagem_idade=@((100*$total_idade)/$votos_totais);
				$faixa = "45 a 59";
				$dados_grafico_faixa[]="['{$faixa}',{$porcentagem_idade}]";
		?>
		<span style="display:block; margin-bottom:8px;">
		45-59 : <?=$total_idade?>  <? //'<strong>'.$porcentagem_idade.'%</strong>'?>
        </span>
        <? 
		/*$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
				WHERE
				ev.eleitor_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status='1'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) >= '60'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) <= '69'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
			
				"));
				
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
				WHERE
				ev.colaborador_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status='1'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) >= '60'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) <= '69'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
				"));*/
				$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(id) as qtd FROM eleitoral_eleitores 
				WHERE
				FLOOR(DATEDIFF(CURRENT_DATE, data_nascimento)/365.25) >= '60'
				AND FLOOR(DATEDIFF(CURRENT_DATE, data_nascimento)/365.25) <= '69' AND
				vkt_id='$vkt_id'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				$filtro_grupo_social
				
			
				"));
				echo mysql_error();
				$total_idade=$votos_eleitores->qtd;
				$porcentagem_idade=@((100*$total_idade)/$votos_totais);
				$faixa="60 a 69";
				$dados_grafico_faixa[]="['{$faixa}',{$porcentagem_idade}]";
		?>
		<span style="display:block; margin-bottom:8px;">
		60-69 : <?=$total_idade?>  <? //'<strong>'.$porcentagem_idade.'%</strong>'?>
        </span>
        <? 
		/*$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
				WHERE
				ev.eleitor_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status='1'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) >= '70'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) <= '79'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
			
				"));
				
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
				WHERE
				ev.colaborador_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status='1'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) >= '70'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) <= '79'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
				"));*/
				$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(id) as qtd FROM eleitoral_eleitores 
				WHERE
				FLOOR(DATEDIFF(CURRENT_DATE, data_nascimento)/365.25) >= '70'
				AND FLOOR(DATEDIFF(CURRENT_DATE, data_nascimento)/365.25) <= '79' AND
				vkt_id='$vkt_id'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				$filtro_grupo_social
				
			
				"));
				$total_idade=$votos_eleitores->qtd;
				$porcentagem_idade=@((100*$total_idade)/$votos_totais);
				$faixa="70 a 79";
				$dados_grafico_faixa[]="['{$faixa}',{$porcentagem_idade}]";
		?>
		<span style="display:block; margin-bottom:8px;">
		70-79 : <?=$total_idade?>  <? //'<strong>'.$porcentagem_idade.'%</strong>'?>
        </span>
         <? 
		/*$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
				WHERE
				ev.eleitor_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status='1'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) >= '80'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
			
				"));
				
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
				WHERE
				ev.colaborador_id = e.id 
				AND ev.politico_id='0' 
				AND ev.status='1'
				AND FLOOR(DATEDIFF(CURRENT_DATE, e.data_nascimento)/365.25) >= '80'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				AND ev.vkt_id='$vkt_id'
				AND e.vkt_id='$vkt_id'
				"));*/
				$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(id) as qtd FROM eleitoral_eleitores 
				WHERE
				FLOOR(DATEDIFF(CURRENT_DATE, data_nascimento)/365.25) >= '80' AND
				FLOOR(DATEDIFF(CURRENT_DATE, data_nascimento)/365.25) <= '120' AND
				vkt_id='$vkt_id'
				$filro_status_voto
				$filro_bairro
				$filtro_coordenador
				$filtro_grupo_social
				
			
				"));
				$total_idade=$votos_eleitores->qtd;
				$porcentagem_idade=@((100*$total_idade)/$votos_totais);
				$faixa="80";
				$dados_grafico_faixa[]="['{$faixa}',{$porcentagem_idade}]";
		?>
		<span style="display:block; margin-bottom:8px;">
		Superior a 80 anos : <?=$total_idade?>  <? //'<strong>'.$porcentagem_idade.'%</strong>'?>
        </span>
      <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChartEtaria);
	  function drawChartEtaria() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows([
			<?=implode(",",$dados_grafico_faixa)?>         
        ]);

        var options = {
          width: 350, height: 200,
          title: '% de Votos por faixa Etária'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_etaria'));
        chart.draw(data, options);
      }
	  
    </script>
    
    </div>
    
    
    
    
    <div style=" width:585px; height:260px; margin-left:15px; margin-top:20px; border:#CCC solid thin;">
<center><h4>Eleitores por Religi&otilde;es</h4></center>
<div id='chart_religioes' style="float:right;"></div>
<?
	 $religiao_q=mysql_query(
	"SELECT * FROM eleitoral_religioes
		 where vkt_id=$vkt_id"); 
		 echo mysql_error(); 
		$cont=0;
		unset($porc);
		while($religiao=mysql_fetch_object($religiao_q)){
		/*$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
		WHERE
		ev.eleitor_id = e.id 
		AND ev.politico_id='0' 
		AND e.religiao_id='{$religiao->id}'
		AND ev.status='1'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		AND ev.vkt_id='$vkt_id'
		AND e.vkt_id='$vkt_id'
		"
		));
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_colaboradores as e 
		WHERE
		ev.colaborador_id = e.id 
		AND ev.politico_id='0' 
		AND e.religiao_id='{$religiao->id}'
		AND ev.status='1'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		AND ev.vkt_id='$vkt_id'
		AND e.vkt_id='$vkt_id'
		"
		));*/
		//echo $votossql;
		$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(id) as qtd FROM eleitoral_eleitores 
		WHERE
		religiao_id='{$religiao->id}' AND
		vkt_id='$vkt_id'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		$filtro_grupo_social
		
		"
		));
		echo mysql_error();
		
	$total_religioes=$votos_eleitores->qtd;
	$porc[$cont]['votos']=$total_religioes;
	$porcentagem_religioes=@((100*$total_religioes)/$votos_totais);
	$porc[$cont]['porc']=$porcentagem_religioes;
	//$porc[$cont]['religiao_id']=$religiao->id;
	$porc[$cont]['nome']=$religiao->nome;
	$cont++;		
	}
		
	if(isset($porc)){
		array_multisort($porc,SORT_DESC);
		foreach($porc as $porcentagem){
			$dados_grafico_religiao[] = "['{$porcentagem['nome']}', {$porcentagem['porc']} ]";
		?>
			<span style="display:block;">
		<?=$porcentagem['nome']?>  Votos : <?=$porcentagem['votos']?><? if($porcentagem['votos']>0){echo ' | <strong>'.number_format($porcentagem['porc'],2,',','.').'%</strong>';}else{echo "0.00%";}?>
        </span>
    	<?
       }
		}
		?>
    	<script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
      	google.setOnLoadCallback(drawChartReligiao);
		function drawChartReligiao() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows([
			<?=implode(",",$dados_grafico_religiao)?>         
        ]);

        var options = {
          width: 350, height: 200,
          title: '% de votos por religiao'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_religioes'));
        chart.draw(data, options);
      	}
	  	</script>
    </div>
    
    <div style=" width:585px; height:260px; margin-left:15px; margin-top:20px; border:#CCC solid thin;">
<center><h4>Eleitores por Sexo</h4></center>
<div id='chart_sexo' style="float:right;"></div>
<?		$sexos= array('masculino','feminino');
		foreach($sexos as $sexo){
		/*$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
		WHERE
		ev.eleitor_id = e.id 
		AND ev.politico_id='0' 
		AND e.sexo='$sexo'
		AND ev.status='1'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		AND ev.vkt_id='$vkt_id'
		AND e.vkt_id='$vkt_id'
		"
		));
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_colaboradores as e 
		WHERE
		ev.colaborador_id = e.id 
		AND ev.politico_id='0' 
		AND e.sexo='$sexo'
		AND ev.status='1'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		AND ev.vkt_id='$vkt_id'
		AND e.vkt_id='$vkt_id'
		"
		));*/
		$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(id) as qtd FROM eleitoral_eleitores 
		WHERE
		sexo='$sexo' AND 
		vkt_id='$vkt_id'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		$filtro_grupo_social
		
		"
		));
		//echo $votossql;
		$total_sexo=$votos_eleitores->qtd;
		$porcentagem_sexo=@((100*$total_sexo)/$votos_totais);
		if($sexo=='masculino'){$sexo_g='Masculino';}else{$sexo_g='Feminino';}
		$dados_grafico_sexo[] = "['{$sexo_g}',$total_sexo]"; 
		?>
		<span style="display:block;">
		<? if($sexo=='masculino'){echo 'Masculino';}elseif($sexo=='feminino'){echo 'Feminino';}?> - <? if($total_sexo>0) echo 'Votos: '. $total_sexo.' | <strong>'.number_format($porcentagem_sexo,2,',','.').'%</strong>'?>
        </span>
    <? }
	?>
        	<script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
      	google.setOnLoadCallback(drawChartReligiao);
		function drawChartReligiao() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows([
			<?=implode(",",$dados_grafico_sexo)?>         
        ]);

        var options = {
          width: 350, height: 200,
          title: '% de votos por sexo'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_sexo'));
        chart.draw(data, options);
      	}
	  	</script>
    </div>
    
   <div style=" width:585px; height:260px; margin-left:15px; margin-top:20px; border:#CCC solid thin;">
<center><h4>Eleitores por Regioes</h4></center>
<div id='chart_regioes' style="float:right;"></div>
<?
	 $regiao_q=mysql_query(
	"SELECT * FROM eleitoral_regioes
		 "); 
		 echo mysql_error(); 
		$cont=0;
		unset($porc);
		while($regiao=mysql_fetch_object($regiao_q)){
		/*$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
		WHERE
		ev.eleitor_id = e.id 
		AND ev.politico_id='0' 
		AND e.regiao_id='{$regiao->id}'
		AND ev.status='1'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		AND ev.vkt_id='$vkt_id'
		AND e.vkt_id='$vkt_id'
		"
		));
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_colaboradores as e 
		WHERE
		ev.colaborador_id = e.id 
		AND ev.politico_id='0' 
		AND e.regiao_id='{$regiao->id}'
		AND ev.status='1'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		AND ev.vkt_id='$vkt_id'
		AND e.vkt_id='$vkt_id'
		"
		));*/
		
		//echo $votossql;
		$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(id) as qtd FROM eleitoral_eleitores 
		WHERE
		regiao_id='{$regiao->id}' AND
		vkt_id='$vkt_id'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		$filtro_grupo_social
		
		"
		));
		echo mysql_error();
		
		$total_regioes=$votos_eleitores->qtd+$votos_colaboradores->qtd;
		$porc[$cont]['votos']=$total_regioes;
		$porcentagem_regioes=@((100*$total_regioes)/$votos_totais);
		$porc[$cont]['porc']=$porcentagem_regioes;
		//$porc[$cont]['religiao_id']=$religiao->id;
		$porc[$cont]['nome']=$regiao->sigla;
		$cont++;		
		}
		
		if(isset($porc)){
			array_multisort($porc,SORT_DESC);
			foreach($porc as $porcentagem){
			if($porcentagem['porc']>0){
			$dados_grafico_regiao[] = "['{$porcentagem['nome']}', {$porcentagem['porc']} ]";
		?>
			<span style="display:block;">
		<?=$porcentagem['nome']?>  Votos : <?=$porcentagem['votos']?><? if($porcentagem['votos']>0){echo ' | <strong>'.number_format($porcentagem['porc'],2,',','.').'%</strong>';}else{echo "0.00%";}?>
        </span>
    	<?
			}
		}
		}
		?>
    	    	<script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
      	google.setOnLoadCallback(drawChartRegiao);
		function drawChartRegiao() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows([
			<?=implode(",",$dados_grafico_regiao)?>         
        ]);

        var options = {
          width: 350, height: 200,
          title: '% de votos por regiao'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_regioes'));
        chart.draw(data, options);
      	}
	  	</script>
    </div>
    
    <div style=" width:585px; height:260px; margin-left:15px; margin-top:20px; border:#CCC solid thin;">
<center><h4>Eleitores por Cidades</h4></center>
<div id='chart_cidade' style="float:right;"></div>
<?
	 $cidade_q=mysql_query(
		"SELECT DISTINCT(cidade) FROM eleitoral_eleitores WHERE cidade !='' LIMIT 5
	  ");
		echo mysql_error(); 
		$cont=0;
		unset($porc);
		while($cidade=mysql_fetch_object($cidade_q)){
			
		//echo $votossql;
		$cidade_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(id) as qtd FROM eleitoral_eleitores 
		WHERE
		cidade='{$cidade->cidade}' AND
		vkt_id='$vkt_id'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		$filtro_grupo_social
		
		"
		));
		/*$cidade_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(id) as qtd FROM eleitoral_colaboradores 
		WHERE
		cidade='{$cidade->cidade}' AND
		vkt_id='$vkt_id'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		$filtro_grupo_social
		
		"
		));*/
		echo mysql_error();
		
		$total_cidade=$cidade_eleitores->qtd;
		$porc[$cont]['votos']=$total_cidade;
		$porcentagem_cidades=@((100*$total_cidade)/$votos_totais);
		$porc[$cont]['porc']=$porcentagem_cidades;
		$porc[$cont]['nome']=$cidade->cidade;
		$cont++;		
		}
		
		if(isset($porc)){
			array_multisort($porc,SORT_DESC);
			foreach($porc as $porcentagem){
			
							
			if($porcentagem['porc']>0){
			$dados_grafico_cidade[] = "['{$porcentagem['nome']}', {$porcentagem['porc']} ]";
		?>
			<span style="display:block;">
		<?=$porcentagem['nome']?>  Votos : <?=$porcentagem['votos']; if($porcentagem['votos']>0){echo ' | <strong>'.number_format($porcentagem['porc'],2,',','.').'%</strong>';}else{echo "0.00%";}?>
        </span>
    	<?
			}
		}
		}
		?>
    	<script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
      	google.setOnLoadCallback(drawChartRegiao);
		function drawChartRegiao() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows([
			<?=implode(",",$dados_grafico_cidade)?>         
        ]);

        var options = {
          width: 350, height: 200,
          title: '% de votos por cidade'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_cidade'));
        chart.draw(data, options);
      	}
	  	</script>
    </div>
    
   <div style=" width:585px; height:260px; margin-left:15px; margin-top:20px; border:#CCC solid thin;">
<center><h4>Eleitores por Bairro</h4></center>
<div id='chart_bairro' style="float:right;"></div>
<?	
	 $bairros_eleitores_q=mysql_query("SELECT DISTINCT(bairro) as bairro FROM eleitoral_eleitores WHERE vkt_id='$vkt_id' AND bairro !='' LIMIT 10");
     $bairros_colaboradores_q=mysql_query("SELECT DISTINCT(bairro) as bairro FROM eleitoral_colaboradores WHERE vkt_id='$vkt_id' AND bairro !='' LIMIT 10");	 
		$cont=0;
		unset($porc);
		while($bairros_eleitores=mysql_fetch_object($bairros_eleitores_q)){$bairros[]=$bairros_eleitores->bairro;}
		while($bairros_colaboradores=mysql_fetch_object($bairros_colaboradores_q)){$bairros[]=$bairros_colaboradores->bairro;}
		$bairros=array_unique($bairros);
		foreach($bairros as $bairro){
		/*$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores  as e 
		WHERE
		ev.eleitor_id = e.id 
		AND ev.politico_id='0' 
		AND e.bairro='$bairro'
		AND ev.status='1'
		$filro_status_voto
		$filtro_coordenador
		AND ev.vkt_id='$vkt_id'
		AND e.vkt_id='$vkt_id'
		"
		));
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_colaboradores as e 
		WHERE
		ev.colaborador_id = e.id 
		AND ev.politico_id='0' 
		AND e.bairro='$bairro'
		AND ev.status='1'
		$filro_status_voto
		$filtro_coordenador
		AND ev.vkt_id='$vkt_id'
		AND e.vkt_id='$vkt_id'
		"
		));*/
		//echo $votossql;
		$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(id) as qtd FROM eleitoral_eleitores 
		WHERE 
		bairro='$bairro' AND
		vkt_id='$vkt_id'
		$filro_status_voto
		$filtro_coordenador
		$filtro_grupo_social
		
		
		"
		));
		//echo $votossql;
		
		$total_bairros=$votos_eleitores->qtd;
		$porc[$cont]['votos']=$total_bairros;
		$porcentagem=@((100*$total_bairros)/$votos_totais);
		$porc[$cont]['porc']=$porcentagem;
		//$porc[$cont]['religiao_id']=$religiao->id;
		$porc[$cont]['nome']=$bairro;
		$cont++;		
		}
		
		if(isset($porc)){
			array_multisort($porc,SORT_DESC);
			foreach($porc as $porcentagem){
			if($porcentagem['porc']>0){
			$dados_grafico_bairro[] = "['{$porcentagem['nome']}',{$porcentagem['votos']}]";
		?>
			<span style="display:block;">
		<?=$porcentagem['nome']?>  Votos : <?=$porcentagem['votos']?><? if($porcentagem['votos']>0){echo ' | <strong>'.number_format($porcentagem['porc'],2,',','.').'%</strong>';}else{echo "0.00%";}?>
        </span>
    	<?
			}
		}
		}
		?>
    	<script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
      	google.setOnLoadCallback(drawChartRegiao);
		function drawChartRegiao() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows([
			<?=implode(",",$dados_grafico_bairro)?>         
        ]);

        var options = {
          width: 350, height: 200,
          title: '% de votos por Bairro'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_bairro'));
        chart.draw(data, options);
      	}
	  	</script>
    </div>
    
   <div style=" width:585px; height:260px; margin-left:15px; margin-top:20px; border:#CCC solid thin;">
<center><h4>Eleitores por Profissao</h4></center>
<div id='chart_profissao' style="float:right;"></div>
<?
	 $profissao_votos_q=mysql_query(
	"SELECT * FROM eleitoral_profissoes LIMIT 10
		 "); 
		 echo mysql_error(); 
		$cont=0;
				unset($porc);
		while($profissao=mysql_fetch_object($profissao_votos_q)){
		/*$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
		WHERE
		ev.eleitor_id = e.id 
		AND ev.politico_id='0' 
		AND e.profissao_id='{$profissao->id}'
		AND ev.status='1'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		AND ev.vkt_id='$vkt_id'
		AND e.vkt_id='$vkt_id'
		"
		));
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_colaboradores as e 
		WHERE
		ev.colaborador_id = e.id 
		AND ev.politico_id='0' 
		AND e.profissao_id='{$profissao->id}'
		AND ev.status='1'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		AND ev.vkt_id='$vkt_id'
		AND e.vkt_id='$vkt_id'
		"
		));*/
		//echo $votossql;
		$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(id) as qtd FROM eleitoral_eleitores 
		WHERE
		profissao_id='{$profissao->id}' AND
		vkt_id='$vkt_id'
		$filro_status_voto
		$filro_bairro
		$filtro_coordenador
		$filtro_grupo_social
		
		"
		));
		echo mysql_error();
		$total_profissoes=$votos_eleitores->qtd+$votos_colaboradores->qtd;
		$porc[$cont]['votos']=$total_profissoes;
		$porcentagem=@((100*$total_profissoes)/$votos_totais);
		$porc[$cont]['porc']=$porcentagem;
		//$porc[$cont]['religiao_id']=$religiao->id;
		$porc[$cont]['nome']=$profissao->descricao;
		$cont++;		
		}
		
		if(isset($porc)){
			array_multisort($porc,SORT_DESC);
			foreach($porc as $porcentagem){
				if($porcentagem['porc']>0){
					$dados_grafico_profissao[] = "['{$porcentagem['nome']}',{$porcentagem['porc']}]";
		?>
			<span style="display:block;">
		<?=$porcentagem['nome']?>  Votos : <?=$porcentagem['votos']?><? if($porcentagem['votos']>0){echo ' | <strong>'.number_format($porcentagem['porc'],2,',','.').'%</strong>';}else{echo "0.00%";}?>
        </span>
    	<?
				}
        }
		}
		?>
        	<script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
      	google.setOnLoadCallback(drawChartRegiao);
		function drawChartRegiao() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows([
			<?=implode(",",$dados_grafico_profissao)?>         
        ]);

        var options = {
          width: 350, height: 200,
          title: '% de votos por Bairro'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_profissao'));
        chart.draw(data, options);
      	}
	  	</script>
    </div>
    
    
   <div style=" width:585px; height:260px; margin-left:15px; margin-top:20px; border:#CCC solid thin;">
<center>
  <h4>Eleitores por Coordenadores</h4></center>
<div id='chart_coordenador' style="float:right;"></div>
<?
	 $coordenadores_votos_q=mysql_query(
	"SELECT * FROM eleitoral_colaboradores WHERE tipo_colaborador='0' AND vkt_id='$vkt_id'
		 "); 
		$cont=0;
		unset($porc);
		while($coordenador=mysql_fetch_object($coordenadores_votos_q)){
		/*$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_eleitores as e 
		WHERE
		ev.eleitor_id = e.id 
		AND ev.politico_id='0' 
		AND e.coordenador_id='{$coordenador->id}'
		AND ev.status='1'
		AND ev.vkt_id='$vkt_id'
		AND e.vkt_id='$vkt_id'
		"
		));
		//echo $votossql.'<br>';
		$votos_colaboradores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(ev.id) as qtd FROM eleitoral_intencoes_voto as ev, eleitoral_colaboradores as e 
		WHERE
		ev.colaborador_id = e.id
		AND e.coordenador_id='{$coordenador->id}'
		AND ev.politico_id='0' 
		AND ev.status='1'
		AND ev.vkt_id='$vkt_id'
		AND e.vkt_id='$vkt_id'
		"
		));*/
		//echo $votossql;
		$votos_eleitores=mysql_fetch_object(mysql_query($votossql="SELECT COUNT(id) as qtd FROM eleitoral_eleitores 
		WHERE
		coordenador_id='{$coordenador->id}' AND
		vkt_id='$vkt_id'
		$filtro_grupo_social
		"
		));
		$total_coordenadores=$votos_eleitores->qtd;
		$porc[$cont]['votos']=$total_coordenadores;
		$porcentagem=@((100*$total_coordenadores)/$votos_totais);
		$porc[$cont]['porc']=$porcentagem;
		//$porc[$cont]['religiao_id']=$religiao->id;
		$porc[$cont]['nome']=$coordenador->nome;
		$cont++;		
		}
		
		if(isset($porc)){
			array_multisort($porc,SORT_DESC);
			foreach($porc as $porcentagem){
				if($porcentagem['porc']>0){
				$dados_grafico_coordenador[] = "['{$porcentagem['nome']}',{$porcentagem['porc']}]";
				
		?>
			<span style="display:block;">
		<?=$porcentagem['nome']?>  Votos : <?=$porcentagem['votos']?><? if($porcentagem['votos']>0){echo ' | <strong>'.number_format($porcentagem['porc'],2,',','.').'%</strong>';}else{echo "0.00%";}?>
        </span>
    	<?
				}
        }
		}
		?>
         <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
      	google.setOnLoadCallback(drawChartRegiao);
		function drawChartRegiao() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows([
			<?=implode(",",$dados_grafico_coordenador)?>         
        ]);

        var options = {
          width: 350, height: 200,
          title: '% de votos por coordenador'
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_coordenador'));
        chart.draw(data, options);
      	}
	  	</script>
    </div>
    
</div>
</div>


</div>
</div>

<div id='rodape'>
</div>