<?
session_start();
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<link href="../../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />


<div id='conteudo'>
<div id='navegacao'>
<a href="?" class='s1'>
  	Sistema NV
</a>
<a href="?" class='s1'>
  	Escolar
</a>
<a href="?" class='s1'>
  	Área do Professor
</a>
<a href="?" class='s2'>
  	Aula 
</a>
<a href="" class='navegacao_ativo'>
<span></span>    Upload
</a>
</div>
<?php
	/*$s_info = mysql_fetch_object(mysql_query(" 
		SELECT * FROM escolar2_aula AS aula
			JOIN escolar2_professor_has_turma AS professor_turma 
				ON	ea.professor_turma = aula.professor_as_turma_id
			JOIN escolar_materias AS em 
				ON smp.materia_id=em.id
			AND ea.id = '".$_GET['aula']."' 
			AND ea.vkt_id = '".$vkt_id."' "));*/
											
	
	$s_info = mysql_fetch_object(mysql_query($a="
		SELECT *,
			ept.id as professor_has_turma_id,
			em.id as materia_id,
			et.unidade_id as unidade_id
		FROM 
			escolar2_aula as ea,
			escolar2_professor_has_turma as ept,
			escolar2_professores as ep,
			escolar2_serie_has_materias as esm,
			escolar2_materias as em,
			escolar2_turmas as et
		WHERE
			ea.vkt_id='$vkt_id'
		AND
			ea.id	= '{$_GET['aula']}'
		AND
			ept.id	= ea.professor_as_turma_id
		AND
			ep.id = ept.professor_id
		AND
			ep.usuario_id='$usuario_id'
		AND
			esm.id = ept.serie_has_materia_id
		AND
			em.id = esm.materia_id
		AND
			et.id = ept.turma_id
	"));

	echo mysql_error();
	
?>
<div id="barra_info">
  <button onclick="location.href='<?=$_SESSION["url_voltar"]?>'">&laquo; Voltar </button> 
  
  <a href="modulos/escolar2/area_professor/aula/arquivo/form_arquivo.php?aula=<?=$_GET['aula']?>" target="carregador" class="mais"></a>
  <strong>Descriçao Aula:</strong> <?=$s_info->descricao;?> | <strong>Mat&eacute;ria:</strong> <?= $s_info->nome;?>
</div>
<iframe name="upload_progresso" style=" display:none;" id="upload_progresso"></iframe>
<script type="text/javascript">

$('#form_arquivo').live('submit',function(){
	checaprogresso();
});

function checaprogresso(){
	id_chave=$("#id_chave").val();
	
	d = new Date();
	s = d.getTime();
	url = '<?=$tela->caminho?>/informacao_do_progresso.php?id_progresso='+id_chave+'&'+s;	
	carregabarra(url);
}


function carregabarra(url){
	console.log(url);
	if($("#vkt_barra").css('display')=='none'){
		$("#vkt_barra").slideDown();
	}
	$("#progresso").load(url, function() {
		porcentagem = $("#progresso").html();
		console.log(porcentagem);
		$("#vkt_barra_progresso").css("width",porcentagem.replace(',','.')+'%');
	
		if($("#vkt_barra_progresso").css("width")!=100){
  			carregabarra(url);
		}

	});
}
	

function chegouao100porcento(){
	$('#vkt_barra_progresso').css('width','100%');
}

</script>
<script>
$("#excluir").live('click',function(){		
  var d = $(this).parent().parent();
  var id = $(this).parent().parent().attr('id');
  var dados = 'id='+id;
		   $.ajax({
			  url: 'modulos/escolar2/area_professor/aula/arquivo/recebe_dados.php?acao=excluir',
			  type: 'POST',
			  data: dados,
			  success: function(data){ d.hide(); }					 
		   });
})
/*$(document).ready(function (){ 
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
	
		window.open('modulos/corretor/corretor/form.php?id='+id,'carregador');
	});
});*/
</script>
<script>
	$(document).ready(function(){
			$("tr:odd").addClass('al');
	});
</script>
<table cellpadding="0" cellspacing="0" width="100%" >
<thead>
    	<tr>
          <td width="50">N&deg;</td>
          <td width="200">Aquivo</td>
          <td width="200">Observa&ccedil;&atilde;o</td>
          <td width="85">Data Envio</td>
          <td width="100">Op&ccedil;&otilde;es</td>
          <td></td>
        </tr>
    </thead>
</table>
<div id='dados' >
<script>resize()</script><!-- Isso é Necessário para a criaçao o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados" >
    <tbody>
        <?
        	$sql_arquivo = mysql_query(" SELECT * FROM escolar2_upload WHERE vkt_id = '$vkt_id' AND aula_id = '".$_GET['aula']."'  ");
				while($upload = mysql_fetch_object($sql_arquivo)){
		?> 
    	<tr id="<?=$upload->id?>">
          <td width="50"><?=$upload->id;?></td>
          <td width="200"><?=$upload->extensao;?></td>
          <td width="200"><?=$upload->observacao;?></td>
          <td width="85"><?=dataUsaToBr($upload->data_envio);?></td>
          <td width="100"><a href="<? echo '../'.$upload->localizacao.$upload->arquivo;?>" target="_blank">Download</a> | <a href="#" id="excluir">Excluir</a> </td>
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
        <td width="20"></td>
          <td width="120">&nbsp;</td>
          <td width="120">&nbsp;</td>
          <td width="50">&nbsp;</td>
          <td width="580">&nbsp;</td>
          <td width="80">&nbsp;</td>
          <td ></td>
        </tr>
    </thead>
</table>

</div>

<div id='rodape'>
	
</div>
