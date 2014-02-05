<?
session_start();
// funçoes do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
?>
<script>
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
  	Aulas Online
</a>
<a href="?" class='s2'>
  	Aulas do Módulo
</a>
<a href="" class='navegacao_ativo'>
<span></span>Arquivos da aula
</a>
</div>
<?php
	
?>
<div id="barra_info">
  <button type="button" onclick="location.href='?tela_id=325&modulo_id=<?=$modulo_id?>&materia_id=<?=$materia_id?>'">&laquo;</button>
  <a href="<?=$tela->caminho?>form_arquivo.php?aula_id=<?=$aula_id?>" target="carregador" class="mais"></a>
  <strong>Descriçao Aula:</strong> <?=$s_info->descricao;?> | <strong>Mat&eacute;ria:</strong> <?= $s_info->nome;?>
</div>
<iframe name="upload_progresso" style="display:none;" id="upload_progresso"></iframe>
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
				var dados = 'id='+id
				 $.ajax({
					url: '<?=$tela->caminho?>recebe_dados.php?acao=excluir',
					type: 'POST',
					data: dados,
					success: function(data){
									//$("#result").html(data);
									d.hide();
					}					 
				 })
})

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
        		$sql_arquivo = mysql_query(" SELECT * FROM escolar_upload_online WHERE vkt_id = '$vkt_id' AND aula_online_id = '$aula_id'  ");
					while($upload = mysql_fetch_object($sql_arquivo)){
		?> 
    	<tr id="<?=$upload->id?>">
          <td width="50"><?=$upload->id;?></td>
          <td width="200"><?=$upload->arquivo;?></td>
          <td width="200"><?=$upload->observacao;?></td>
          <td width="85"><?=dataUsaToBr($upload->data_envio);?></td>
          <td width="100"><a href="<? echo $tela->caminho.'arquivos/'.$upload->localizacao.$upload->arquivo;?>" target="_blank">Download</a> | <a onclick="window.open()" href="#" id="excluir">Excluir</a> </td>
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
