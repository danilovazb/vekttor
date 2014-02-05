<?
session_start();
// funçoes do modulo empreendimento
include("_function_colaborador.php");
include("_ctrl_colaborador.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

$(document).ready(function(){	
		$("#situ3").live("click",function(){
		$('#tempo_gasto').attr('disabled','disabled');
		$('#data_fim').attr('disabled','disabled');
		$('#hora_fim').attr('disabled','disabled');
		$('#v2').attr('disabled','disabled');
		$('#data_inicio').attr('disabled','disabled');
		$('#hora_inicio').attr('disabled','disabled');
		$('#v1').attr('disabled','disabled');
		$('#situ2').attr('checked',false);
	});
	$("#situ2").live("click",function(){
		$('#data_inicio').attr('disabled','disabled');
		$('#hora_inicio').attr('disabled','disabled');
		$('#v1').attr('disabled','disabled');
		//$('#situ3').attr('disabled','disabled');
		$('#situ3').attr('checked',false);
		//desabilitar
		$('#tempo_gasto').removeAttr('disabled');
		$('#data_fim').removeAttr('disabled');
		$('#hora_fim').removeAttr('disabled');
		$('#v2').removeAttr('disabled');
	});	
	
});
</script>

<div id='conteudo'>
<div id='navegacao'>
<a href="?" class='s1'>
  	Sistema NV
</a>
<a href="?" class='s2'>
  	Projetos
</a>
<a href="?tela_id=96" class='navegacao_ativo'>
<span></span>    Colaborador
</a>
</div>

<div id="barra_info">

<form method="get">
<input type="hidden" name="tela_id" value="96" />

<!-- select na tabela projetos -->
<select name="projeto_id" id='projeto_id' onchange="this.parentNode.submit()">
<option value="0">Todos os Projetos</option>
<?php 
	$sql = mysql_query("SELECT * FROM projetos ");
	
		while($p=mysql_fetch_object($sql)){
		if($_GET['projeto_id']==$p->id){$projeto_sel='selected="selected"';}else{$projeto_sel='';}
?>
	<option <?=$projeto_sel?> value="<?php echo $p->id;?>"><?php echo $p->nome;?></option>
<?php 	}?>
</select>

<!-- select na tabela projetos_atividades_tipos -->
<select name="tipo_atividade_id" id='tipo_atividade_id' onchange="this.parentNode.submit()">
<option value="0">Tipos de Atividade</option>
<? 
	$sql = mysql_query("SELECT * FROM projetos_atividades_tipos ");
	
		while($ptt=mysql_fetch_object($sql)){
		if($_GET['tipo_atividade_id']==$ptt->id){$ptt_sel='selected="selected"';}else{$ptt_sel='';}
?>
	<option <?=$ptt_sel?> value="<?=$ptt->id;?>"><?=$ptt->nome; ?></option>
<? }?>
</select>

<!-- select na tabela projetos_atividades_tipos por status -->
<select name="situacao_id" id='situacao_id' onchange="this.parentNode.submit()">
<option value="99"> Tipo Status </option>
<?php
	$situacao = array('Aguardando','Finalizado');
	foreach($situacao as $chave=>$valor){
		if($_GET['situacao_id']==$chave && isset($_GET['situacao_id']) && $_GET['situacao_id'] != '99' ){
			$marca="selected";}else{$marca='';}
		?>
    
		<option <?=$marca?> value="<?=$chave;?>"><?=$valor?></option>
		<?
    }
	
?>
<?php 
			
	?>
</select>

</form>
</div>

<script>

$("#tabela_dados tr").live("click",function(){
	var atividade_id = $(this).attr('id');
	
	window.open('<?=$tela->caminho?>/form.php?id='+atividade_id,'carregador');
});

</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
    	  <td width="580"><?=linkOrdem("Atividade","nome",1)?></td>
          <td width="140">Tipo de Atividade</td>
          <td width="60">Estimado</td>
          <td width="60">Gasto</td>
          <td width="60">Situaçao</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
	<?php 
	if(isset($_GET['projeto_id'])&&$_GET['projeto_id']!='0'){
		$filtro_projeto=" AND projeto_id='{$_GET['projeto_id']}' ";
	}
	
	if(isset($_GET['tipo_atividade_id'])&&$_GET['tipo_atividade_id']!='0'){
		$filtro_tipo_atividade=" AND atividade_tipo_id='{$_GET['tipo_atividade_id']}' ";
	}
	
	
	// SQL PARA LISTAR TODOS OS REGISTROS
	
	
	if(isset($_GET['projeto_id'])&&$_GET['projeto_id']!='0'){
		$filtro_projeto=" AND projeto_id='{$_GET['projeto_id']}' ";
	}
	
	if(isset($_GET['tipo_atividade_id'])&&$_GET['tipo_atividade_id']!='0'){
		$filtro_tipo_atividade=" AND atividade_tipo_id='{$_GET['tipo_atividade_id']}' ";
	}
	if(isset($_GET['situacao_id']) && $_GET['situacao_id'] != '99'   ){
		$filtro_tipo_situacao=" AND situacao='{$_GET['situacao_id']}'  ";
	}
	
	
	$q = mysql_query($t="
			SELECT * FROM 
				projetos_atividades 
			WHERE 
				vkt_id='$vkt_id' 
			AND 
				funcionario_id = $login_id	
				$filtro_projeto 
				$filtro_tipo_atividade 
				$filtro_tipo_situacao  
			ORDER BY 
				ordenacao_funcionario ");
			
	$q_total=mysql_fetch_object(mysql_query("
	SELECT
		TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(tempo_estimado_horas))),'%H:%i') AS horas,

		TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(tempo_finalizado_hora))),'%H:%i') AS hora_final	
	FROM 
		projetos_atividades 
	WHERE 
		vkt_id='$vkt_id' 
	AND 
		funcionario_id = $login_id 
		$filtro_funcionario 
		$filtro_projeto 
		$filtro_tipo_atividade"));
	
	while($r=mysql_fetch_object($q)){
		$total++;
		if($total%2){$sel='class="al"';}else{$sel='';}
		$atividade=mysql_fetch_object(mysql_query("SELECT nome FROM projetos_atividades_tipos WHERE id='{$r->atividade_tipo_id}'"));	
	?>      
    	<tr <?=$sel?> id="<?=$r->id?>" >
    	  <td width="580"><?=$r->nome;?></td>
          <td width="140"><?=$atividade->nome?></td>
          <td width="60"><?php
          $estimado = substr($r->tempo_estimado_horas,0,5); echo $estimado;
		  ?></td>
          <td width="60"><?php
		  $gasto = substr($r->tempo_finalizado_hora,0,5); echo $gasto;
          ;?></td>
          <td width="60"><?php
		   if($r->situacao == 1){ 
		  	 echo "<img src='../fontes/img/accept.png'>";} 
		   else if($r->situacao == 2){
			   echo "<img src='../fontes/img/exclamation.png'>";
		   } else{
			   echo "<img src='../fontes/img/_error.png'>";
		   }
			?>
          </td>
          <td></td>
        </tr>
<?
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

<table cellpadding="0" cellspacing="0" width="100%" style="border-top:solid thin black">
    <thead>
    	<tr>
    	  <td width="580">&nbsp;</td>
          <td width="140">&nbsp;</td>
          <td width="60">&nbsp;</td>
          <td width="60">&nbsp;</td>
          <td width="60">&nbsp;</td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
	
</div>
