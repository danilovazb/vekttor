<?
session_start();
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 

include("_functions.php");
include("_ctrl.php");

$_SESSION["url_voltar"] =  $_SERVER['REQUEST_URI'];
$materia = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_materias WHERE id = '{$_GET['materia']}'"));
$dados = consulta_materia($_GET);
?>
<script>
$(document).ready(function(){
	
	$("#dados tr:nth-child(2n+1)").addClass('al');
	
});

$('#modulo_mais').live('click',function(){
	var html = $('<div> <label>Materia<input type="text" name="nome" size="30"></label></div><div style="clear:both"></div>');
	$("#result_mateira").append(html);
});
	
$(document).ready(function(){
	$("#tabela_dados tr td#descricao").live("click",function(){
		var id = $(this).parent().attr('id');
		var unidade_id = $("#unidade_id").val();
		var professor_as_turma = $("#professor_as_turma").val();
		window.open('modulos/escolar2/area_professor/aula/form_nova_aula.php?id='+id+'&unidade_id='+unidade_id+'&professor='+professor_as_turma,'carregador');
	});
});

$('#clickChamada').live('click',function(){
	var status     = $(this).prev('input').val();
	var aula       = $(this).parent().parent().attr('id'); 
	  if(status == 1){
		location.href='?tela_id=489&aula_id='+aula;  
	  }
	  else{
		  alert('A chamda já foi finalizada, para acessar comunique a Coordenação');
		  return false;
	  }
});

$("#clickObservacao").live("click",function(){
	var tr   = $(this).parent().parent();
	var aula = $(this).parent().parent().attr('id'); 
	var status = tr.find(".s_aula input").val();
	console.log(status);
	
	 if(status == 1){
		location.href='?tela_id=522&aula_id='+aula;  
	  }
	   else{
		  alert('A chamda já foi finalizada, para acessar comunique a Coordenação');
		  return false;
	   }
		
});

	
</script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
.frequencia{display:inline-block; padding:2px 4px 2px; font-size:9.844px;  font-weight:bold;  color:#fff;  text-shadow:0 -1px 0 rgba(0,0,0,0.25);  vertical-align:baseline;  width:60px;  text-align:center}
.realizada{background-color:#b94a48}
.lancar{background-color:#468847}
.obs{text-shadow:0 -1px 0 rgba(0,0,0,0.25); text-decoration:none; background-color:#faa732; background-image:-moz-linear-gradient(top,#fbb450,#f89406); background-image:-webkit-gradient(linear,0 0,0 100%,from(#fbb450),to(#f89406)); background-image:-webkit-linear-gradient(top,#fbb450,#f89406); background-image:-o-linear-gradient(top,#fbb450,#f89406); background-image:linear-gradient(to bottom,#fbb450,#f89406); background-repeat:repeat-x; filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#fffbb450',endColorstr='#fff89406',GradientType=0); filter:progid:DXImageTransform.Microsoft.gradient(enabled=false)}
</style>

<div id='conteudo'>
<div id='navegacao'>
<div id="some">«</div>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
<a href="?tela_id=231" class='s1'>
  	Sistema NV
</a>
<a href="?tela_id=231" class='s1'>
  	Escolar
</a>
<a href="?tela_id=231" class='s2'>
    Turma 
</a>
<a href="?tela_id=231" class="navegacao_ativo">
<span></span>Aulas
</a>
</div>
<div id="barra_info">
	<!-- input hidden -->
    	<!--<input type="hidden" name="limitAula" id="limitAula" value="">
        <input type="hidden" name="qtdAula" id="qtdAula" value="">-->
        <input type="hidden" name="turma" id="turma" value="<?=$sala?>">
        <input type="hidden" name="unidade_id" id="unidade_id" value="<?=$_GET["unidade_id"]?>">
        <input type="hidden" name="professor_as_turma" id="professor_as_turma" value="<?=$_GET["professor_as_turma"]?>">
        
    <!-- -->
	Mat&eacute;ria: <strong style="text-transform:capitalize;"> <?=$dados["materia"]?></strong> | <?=$dados["professor"]?> - Turma: <strong><?=$dados["turma"];?></strong>
    
    <a href="modulos/escolar2/area_professor/aula/form_nova_aula.php?professor_as_turma=<?=$_GET["professor_as_turma"]?>&unidade_id=<?=$_GET["unidade_id"]?>" target="carregador" class="mais"></a>
	
    <!--<button type="button" onclick="location.href='?tela_id=267&materia=<?=$_SESSION['materia_id']?>&turma=<?=$sala?>&professor=<?=$professor->id?>'">Total Faltas</button>
    <input type="button" name="todas_perguntas" onclick="location.href='?tela_id=292&professor=<?=$professor->id?>'" value="Todas Perguntas Forum">-->
	
</div>
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="40">N&deg;</td>
           <td width="250">Descriçao Aula</td>
           <td width="70">Data</td>
           <td width="80">Frequência</td>
           <!--<td width="70">Aula</td>-->
           <td width="90">Observações</td>
           <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
   	<?php
    		$sql_aula = mysql_query($ui=" SELECT *,aula.id AS id_aula FROM escolar2_aula AS aula 
			JOIN
				escolar2_professor_has_turma AS professor_turma ON 	professor_turma.id = aula.professor_as_turma_id	
			WHERE 
				aula.vkt_id = '$vkt_id' 
			AND 
				aula.professor_as_turma_id = '{$_GET['professor_as_turma']}' 
			AND
				professor_turma.turma_id = '{$_GET['turma_id']}' ");
			
				
			$total = 0;
			while($r=mysql_fetch_object($sql_aula)){
				$total++;
	?> 
            <tr id="<?=$r->id_aula?>">
               <td width="40"><?=$r->id_aula?></td>
               <td width="250" id="descricao"><?=LimitarString($r->descricao,45);?></td>
               <td width="70"><?=dataUsaToBr($r->data)?></td>
               <td width="80" class="s_aula">
               	<input type="hidden" name="statusChamada" id="statusChamada" value="<?=$r->status?>">
                <a href="#" id="clickChamada"> 
				<? if($r->status == 1){ echo "<span class='frequencia lancar'> Lançar </span>";} else if($r->status == 2){ echo "<span class='frequencia realizada'>Fechada</span>";}?></a>
               </td>
               <td width="90">
               <a href="#" id="clickObservacao" class="frequencia obs" >  Lançar  </a>
               	<!--<a href="#" onclick="location.href='?tela_id=286&aula=<?=$r->id?>'">Arquivo</a> | 
                <a href="#" onclick="location.href='?tela_id=291&aula=<?=$r->id?>&professor=<?=$professor->id?>'">Responder Forum</a>-->
                </td>
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
