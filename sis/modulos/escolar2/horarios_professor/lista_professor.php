<?
include("_functions.php");
include("_ctrl.php");
$professor = mysql_fetch_object(mysql_query($yu=" SELECT *, p.id as professor_id FROM escolar2_professores as p, rh_funcionario as f WHERE p.usuario_id = '$usuario_id' AND p.funcionario_id=f.id"));


if(!$_GET[data_referencia]){
	$data_inicio = date("Y-m-d");
}else{
	$data_inicio = $_GET[data_referencia];
}
$dia_semana_depois =  mysql_result(mysql_query($t="SELECT DATE_ADD('$data_inicio', INTERVAL 7 DAY)"),0,0);
$dia_semana_antes =  mysql_result(mysql_query($t="SELECT DATE_ADD('$data_inicio', INTERVAL -7 DAY)"),0,0);
$_SESSION["url_voltar"] =  $_SERVER['REQUEST_URI'];
?>

<style>
tbody tr:nth-child(even){ background:#F1F5FA;}
div.turma{
	padding:5px 20px;	
}
.content-turmas-header{
	font-size:12px; color:#666; font-weight:800;	
	padding:5px;
}
.content-turmas{ 
	max-height:200px; 
	overflow:auto;
}
.body-turmas{ 
	background:#FFFFFF; 
	padding:3px;
}
.body-turmas:nth-child(even){ 
	background:#F1F5FA;
}
.frequencia{
	display:inline-block; 
	text-decoration:none; 
	padding:4px 6px 4px; font-size:11px;  font-weight:bold;  color:#fff;  text-shadow:0 -1px 0 rgba(0,0,0,0.25);  vertical-align:baseline;  width:115px;  
	text-align:center;
	border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;
}
.realizada{
	background-color:#b94a48;
	display:inline-block;text-decoration:none; 
	padding:4px 6px 4px; font-size:11px;  
	font-weight:bold;  color:#fff;  
	text-shadow:0 -1px 0 rgba(0,0,0,0.25);  vertical-align:baseline;  width:115px;  text-align:center;
	border-radius:3px;-moz-border-radius:3px;-webkit-border-radius:3px;
}

.lancar{background-color:#468847;}

</style>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<script>

$("#tabela_dados tr").live("click",function(){
	var id = $(this).attr("id");
	//location.href(); 
	location.href=("?tela_id=542&id=" +id+ "");
});

</script>
<div id='conteudo'>
<div id='navegacao'>
 <div id="some">«</div>
<a href="?tela_id=231" class='s1'>
  	Inicio
</a>
<a href="#" class='s2'>
    Educcare 
</a>
<a href="?tela_id=<?=$tela->id?>" class="navegacao_ativo">
<span></span> Professores Horários </a>

<form class='form_busca' action="" method="get">
     <a></a>
    <input type="hidden" name="limitador" value="<?php echo $_GET['limitador']; ?>" />
    <input type="hidden" name="tela_id" value="<?php echo $_GET['tela_id']; ?>" />
    <input type="hidden" name="pagina" value="<?php echo $_GET['pagina']; ?>" />
    <input type="text" value="<?php echo $_GET[busca]; ?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>
</div>

<div id="barra_info">
	<input type="hidden" name="professor_id" id="professor_id" value="<?=$professor->professor_id?>">
    
</div>

<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td width="30"> N&ordm; </td>
           <td width="200" > Professor </td>
           <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>

<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
    <?php
	    $cont=0;
		$filter = "";
		
		if( !empty($_GET["busca"]) ){
			$filter = " AND funcionario.nome LIKE '%".$_GET["busca"]."%'" ;	
		}
		
		
    	$sql = mysql_query($t="
		SELECT 
			funcionario.nome        AS prof_nome,
			prof_turma.professor_id AS professor_id,
			prof.usuario_id         AS usuario_id
		
		FROM escolar2_professor_has_turma AS prof_turma
		
		JOIN escolar2_turmas AS turma
			ON prof_turma.turma_id = turma.id  
		
		JOIN escolar2_professores AS prof
			ON prof_turma.professor_id = prof.id
		
		JOIN rh_funcionario AS funcionario
			ON prof.funcionario_id = funcionario.id
		
		WHERE	
			prof_turma.vkt_id = '$vkt_id'
		$filter
			
		GROUP BY 
			prof_turma.professor_id
		
		ORDER BY funcionario.nome ASC  
		");
		
		 while( $professores = mysql_fetch_object($sql) ){
			 $cont++;
	?>
        <tr id="<?=$professores->usuario_id?>">
          <td width="30"> <?=$cont?> </td>
          <td width="200"> <?=$professores->prof_nome?> </td>
          <td></td>
        </tr>
    <?php
		 }
	
	?>
    
    </tbody>
</table>

</div>

<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	<tr>
           <td>&nbsp;</td>
      </tr>
    </thead>
</table>

</div>
<div id='rodape'>
</div>
