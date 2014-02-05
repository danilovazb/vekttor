<?
$tela = mysql_fetch_object(mysql_query($trace="SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'"));
$caminho =$tela->caminho; 
include("_functions.php");
include("_ctrl.php");
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<style>
.status{
  display: inline-block;
  padding: 2px 4px 2px;
  font-size: 9.844px;
  font-weight: bold;
  color: #ffffff;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
  vertical-align: baseline;
  width:60px;
  text-align:center;
}
.finalizado{ background-color: #b94a48;}
.aberta{ background-color: #468847;}
.coluna_ocorrencia:hover{
	background:#000;
	color:#000;
	cursor:auto;
}
</style>
<script type="text/javascript">
$(function(){
	$("tr:odd").addClass('al');
	/*.:some barra lateral :.*/
	//some_menu();
	/*.: carrega janela :.*/
	$("#tabela_dados tr").live("click",function(){
		var id = $(this).attr('id');
		var exibe = $("#modo_exibicao").val();
		window.open('modulos/escolar2/aulas/form.php?id='+id+'&exibe='+exibe,'carregador');
	});
});
</script>
<div id='conteudo'>
<div id='navegacao'>
<div id="some">&laquo;</div>
<form class='form_busca' action="" method="get">
   	 <a></a>
	<input type="hidden" name="limitador" value="<?=$_GET['limitador']?>" />
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
	<input type="hidden" name="pagina" value="<?=$_GET['pagina']?>" />
    <input type="text" value="<?=$_GET[busca]?>" name="busca" onkeydown="if(event.keyCode==13){this.parentNode.submit()}"/>
</form>

<a href="" class='s1'>
  	Sistema NV
</a>
<a href="#" class='s2'>
    Escolar 
</a>
<a href="#" class="navegacao_ativo">
<span></span>Todas Aulas
</a>
</div>
<div id="barra_info">
<form action="" method="get">
	<?php
     $tipo = "aula";
	if(!empty($_GET["tipo"]))
	 $tipo = $_GET["tipo"];
	?>
	<input type="hidden" name="tela_id" value="<?=$_GET['tela_id']?>" />
    <input type="hidden" name="modo_exibicao" id="modo_exibicao" value="<?=$tipo?>" />
    <!--<input type="text" name="dtaInicio" style="width:75px;"> &agrave; <input type="text" name="dtaFim" style="width:75px;">-->
    
    <!-- SELECT PARA AULA / AVALIAÇÕES -->
    <select name="tipo" id="tipo">
    	<option <? if($_GET['tipo'] == "aula"){echo 'selected="selected"';} ?> value="aula">Aulas</option>
        <option <? if($_GET['tipo'] == "aval"){echo 'selected="selected"';} ?> value="aval">Avalia&ccedil;&otilde;es</option>
    </select>
    
    <!-- SELECT PARA TURMA -->
    <!--<select name="turma_id" id="turma_id" style="width:130px;">
        <option value="0">Turma</option>
		<?
        	$sql_turma = mysql_query(" SELECT * FROM escolar2_turmas WHERE vkt_id = '$vkt_id' ORDER BY nome ASC");
			while($turmas=mysql_fetch_object($sql_turma)){
				if($_GET['turma_id'] == $turmas->id){ $selt = 'selected="selected"';} else{$selt = "";}
		?>
        <option value="<?=$turmas->id?>" <?=$selt?>> <?=$turmas->nome?></option>
        <?
			}
		?>    
    </select>-->
    
    <!-- SELECT PROFESSOR --->
    <select name="professor_id" style="width:130px;">
        <option value="0">Professor</option>
        <?
        $sqlProf = mysql_query(" SELECT *,funcionario.nome AS nome_professor, professor.id AS id_prof FROM escolar2_professores AS professor
		JOIN
			rh_funcionario AS funcionario ON funcionario.id = professor.funcionario_id
		WHERE 
			professor.vkt_id = '$vkt_id' ");
			while($professores = mysql_fetch_object($sqlProf)){
				if($_GET['professor_id'] == $professores->id_prof){ $self = 'selected="selected"';} else{$self = "";}
		?>
        <option value="<?=$professores->id_prof?>" <?=$self?>  ><?=$professores->nome_professor?></option>
        <?
			}
		?>
    </select> 
     
    <input type="submit" value="Filtrar">
</form>  
</div>
<!--<div id="result"></div>-->
<input type="hidden" name="aula" id="aula" value="<?=$aula?>">
<table cellpadding="0" cellspacing="0" width="100%">
    <thead>
    	 <tr>
               <td width="50">N&ordm;</td>
               <td width="180">Descri&ccedil;&atilde;o</td>
               <td width="90">Turma</td>
               <td width="90">Mat&eacute;ria</td>
               <td width="90">Professor</td>
               <td width="70">Data</td>
               <td width="70">Ocorrencias</td>
               <td width="80">Aula</td>
               <!--<td width="70">Per&iacute;odo</td>-->
               <td></td>
         </tr>
    </thead>
</table>
<div id='dados'>
<script>resize()</script><!-- Isso é Necessário para a criação o resize -->
<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">
    <tbody>
      <?
		
		$tabela = "escolar2_aula";
		$filter = "";
		
		if($_GET['tipo'] == "aval"){
			$tabela = "escolar2_avaliacao";	
		} if(!empty($_GET["turma_id"])){
		  $filter .="
			JOIN 
				escolar2_professor_has_turma AS professor_turma ON professor_turma.id = $tabela.professor_as_turma_id
			JOIN
				escolar2_turmas AS turma ON turma.id = professor_turma.turma_id	
			AND 
				professor_turma.turma_id= ".$_GET["turma_id"];
				
		} if(!empty($_GET["professor_id"])){
		   
		   if(!empty($_GET["turma_id"])){
			  $filter .="
			  AND 
			  	professor_turma.professor_id = ".$_GET["professor_id"];
		   }
		   else {
		
		   $filter .="
			JOIN 
				escolar2_professor_has_turma AS professor_turma ON professor_turma.id = $tabela.professor_as_turma_id
			JOIN
				escolar2_turmas AS turma ON turma.id = professor_turma.turma_id	
			AND 
				professor_turma.professor_id = ".$_GET["professor_id"];
		   }
		   
		}
		
		$filtervkt = " AND $tabela.vkt_id = '$vkt_id' ";
		$consulta = "SELECT *,$tabela.id AS id_current FROM $tabela $filter WHERE 1 $filtervkt ";
		
		
		/*. SQL PRINCIPAL .*/
		$sql = $consulta;
		
		$rows = mysql_query($sql);
		
		while($aulas=mysql_fetch_object($rows)){
			
		  /*. TURMA .*/
		  $turma = mysql_fetch_object(mysql_query($ty=" SELECT *, turma.nome AS turma FROM $tabela
		  JOIN 
			  escolar2_professor_has_turma AS professor_turma ON professor_turma.id = $tabela.professor_as_turma_id
		  JOIN
			  escolar2_turmas AS turma ON turma.id = professor_turma.turma_id	
		  WHERE 
			  $tabela.id = '$aulas->id_current'
		  "));
		  
		  /*. MATERIA .*/
		  $result2 = mysql_fetch_object(mysql_query(" SELECT *, materia.nome AS nome_materia FROM escolar2_serie_has_materias AS serie_materia
		  JOIN
		  		escolar2_materias AS materia ON materia.id = serie_materia.materia_id
		  WHERE 
		  		serie_materia.id = '$turma->serie_has_materia_id'
		  "));
		  
		  /*. PROFESSOR .*/	
		  $result3 = mysql_fetch_object(mysql_query("SELECT *,funcionario.nome AS nome_professor FROM escolar2_professores AS professor
		  JOIN
		  		rh_funcionario AS funcionario ON funcionario.id = professor.funcionario_id
		  WHERE 
		  		professor.id = '$turma->professor_id'	
		"));
				
			if($aulas->status == 1)
				$status = "<span class='status aberta'>Aberta</span>";
			else 
				$status = "<span class='status finalizado'>Fechada</span>";
		
		/*. QUANTIDADE DE OCORRÊNCIAS .*/
		$qtd_ocorrencias = mysql_result(mysql_query("SELECT COUNT(*) as qtd FROM escolar2_obs_aluno_aula WHERE aula_id='$aulas->id_current'"),0,0);												
	  	echo mysql_error();
	  ?>
      <tr id="<?=$aulas->id_current?>">
          <td width="50"><?=$aulas->id_current?></td>
          <td width="180"><?=LimitarString($aulas->descricao,31);?></td>
          <td width="90"><?=LimitarString($turma->turma,14);?></td>
          <td width="90"><?=LimitarString($result2->nome_materia,14);?></td>
          <td width="90"><?=LimitarString($result3->nome_professor,15);?></td>
          <td width="70"><?=dataUsaToBr($aulas->data);?></td>
          <td width="70"><?=$qtd_ocorrencias?></td>
          <td width="80"><?=$status;?></td>
          <!--<td width="70"><?LimitarString($periodo->nome,11);?></td>-->
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
