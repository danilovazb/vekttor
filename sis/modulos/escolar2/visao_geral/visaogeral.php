<?php

$array_tempo = array(0=>" 1ª Tempo",1=>" 2ª Tempo",2=>" 3º Tempo",3=>" 4º Tempo",4=>" 5º Tempo",5=>" 6º Tempo",6=>" 7º Tempo",7=>"8º Tempo ",8=>" 9º Tempo",9=>" 10º Tempo");
$array_dia_semana = array(1=>"Segunda-Feira",2=>"Terça-Feira",3=>"Quarta-Feira",4=>"Quinta-Feira",5=>"Sexta-Feira",6=>"Sábado",7=>"Domingo");

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho;

include ("_functions.php");
include ("_ctrl.php");

$professor = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_professores WHERE usuario_id = '$usuario_id'"));
$_SESSION["url_voltar"] =  $_SERVER['REQUEST_URI'];
 
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="conteudo">
<script>
$(function(){
	//some_menu();
	
	/*$("select#periodo_letivo_id option:selected").each(function(){
		
	});*/
	
});
</script>
<script>
$("select#options").live('change',function(){
	var tela       = $(this).val();
	var professor_as_turma = $(this).parents().find('#professor_as_turma').val();
	var unidade_id = $(this).parents().find('#unidade_id').val();
	var turma_id   = $(this).parents().find('#turma_id').val();
	var serie_has_materia   = $(this).parents().find('#serie_has_materia').val();
	location.href='?tela_id='+tela+'&professor_as_turma='+professor_as_turma+"&unidade_id="+unidade_id+"&turma_id="+turma_id+"&serie_has_materia="+serie_has_materia;
});

$(".qtd_mat").live("click",function(){
	var turma_id = ($(this).parent().attr("id"));
	location.href=('?tela_id=524&turma_id='+turma_id+'&tipo=matricula');
});

$(".qtd_remat").live("click",function(){
	var turma_id = ($(this).parent().attr("id"));
	location.href=('?tela_id=524&turma_id='+turma_id+'&tipo=rematricula');
});

$(".click_turma").live("click",function(){
	var turma_id = ($(this).parent().attr("id"));
	location.href=('?tela_id=524&turma_id='+turma_id+'&tipo=todos');
});

$(".click_serie").live("click",function(){
	var serie_id = ($(this).attr("id"));
	var periodo_letivo = $(this).attr("periodo-letivo");
	
	location.href=('?tela_id=524&serie_id='+serie_id+"&periodo_letivo="+periodo_letivo);
});

$(".click_sala").live("click",function(){
	var sala_id = ($(this).attr("id"));
	var periodo_letivo = $(this).attr("periodo-letivo");
	var serie_id = $(this).attr("serie_id");
	location.href=('?tela_id=524&sala_id='+sala_id+"&periodo_letivo="+periodo_letivo+"&serie_id="+serie_id);
});

$(".click_turma_horario").live("click",function(){
	var turma_id   = ($(this).attr("turma"));
	var horario_id = ($(this).attr("horario"));
	var periodo_letivo = $(this).attr("periodo-letivo");
	location.href=('?tela_id=524&turma_id='+turma_id+'&horario_id='+horario_id+"&periodo_letivo="+periodo_letivo);
});

$("#serie_id,#sala_id,#periodo_letivo_id,#escola_id").live("change",function(){
	$("form#form_filtro").submit();
});

/*$.each("#periodo_letivo_id > option",function(key, value){
	console.log("Periodo:"+key.value);
});*/

</script>
<style>
  blockquote{margin-top:0; margin-bottom:0; margin-right:0; margin-left:15px; padding:0;}
  tbody td{ vertical-align:top; line-height:14px;}
  .cz{ color:#999999; cursor:default}
  .disabilitado{ color:#999999;}
  .qtd_mat{}
  .qtd_remat{}
  .td_serie,.click_turma{}
  .td_serie:hover,click_turma:hover{cursor:pointer;}
  
</style>
<?
//pr($_POST);
?>
	<!--
        ///////////////////////////////////////
        Barra de Navegação
        ///////////////////////////////////////
    -->
    <div id="navegacao">
    <div id="some">&laquo;</div>
        <a href="#" class='s1'>
  			SISTEMA 
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="./?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo">Vis&atilde;o Geral<span></span></a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
    <input type="hidden" name="ano_corrente" id="ano_corrente" value="<?=date("Y")?>">
    <form method="get" id="form_filtro" style="float:left;">
	 <input type="hidden" name="tela_id" value="<?=$_GET[tela_id]?>" />
     
      	<select name="periodo_letivo_id" id="periodo_letivo_id" style="width:120px;">
          	<option value="0">Per&iacute;odo</option>
            <?php
			
				$periodos_letivos = mysql_query("SELECT * FROM escolar2_periodo_letivo WHERE vkt_id='$vkt_id'");
				
				while($periodo_letivo = mysql_fetch_object($periodos_letivos)){
				
					if($_GET['periodo_letivo_id']==$periodo_letivo->id){
						$selected = "selected='selected'";
					} 
					
					if( empty($_GET['periodo_letivo_id']) and $periodo_letivo->id == 17  ){
						$selected = "selected='selected'";
					}
				
					echo "<option value='$periodo_letivo->id' $selected>$periodo_letivo->nome</option>";
					$selected='';
				}
			?>
        </select> 
        
        <select name="escola_id" id="escola_id" style="width:120px;">
          	<option value="0">Escola</option>
          	<?php
				$escolas = mysql_query("SELECT * FROM escolar2_unidades WHERE vkt_id='$vkt_id' ");
				
				while($escola = mysql_fetch_object($escolas)){
					
					if($_GET['escola_id']==$escola->id)
						$selected="selected='selected'";
					
					echo "<option value='$escola->id' $selected>$escola->nome</option>";
					$selected='';
					
				} ?>
      	</select>
          
        <select name="serie_id" id="serie_id" style="width:90px; margin-top:2px;">
        	<option value="0"> S&eacute;rie  </option>
        	<?php
				$sql = mysql_query(" SELECT 
				*,serie.nome AS nome_serie, 
				serie.id AS serie_id
				
				FROM escolar2_series AS serie 
				
				JOIN escolar2_turmas AS turma
					ON serie.id = turma.serie_id
					
				WHERE serie.vkt_id = '$vkt_id'  GROUP BY turma.serie_id ORDER BY serie.nome  ");
				while($serie = mysql_fetch_object($sql)){
					if( $_GET["serie_id"] == $serie->serie_id ) { $selSerie = 'selected="selected"'; } else { $selSerie = ''; }
            ?>    
            <option <?=$selSerie?> value="<?=$serie->serie_id?>"><?=$serie->nome_serie?></option>
        	<?php
				}
			?>
        </select>
        
        <select name="sala_id" id="sala_id" style="width:90px; margin-top:2px;">
        	<option value="0"> Sala  </option>
        	<?php
				$sqlSala = mysql_query(" SELECT 
				*,sala.nome AS nome_sala, sala.id AS sala_id
				
				FROM escolar2_salas AS sala 
				JOIN escolar2_turmas AS turma ON sala.id = turma.sala_id
				WHERE sala.vkt_id = '$vkt_id'  GROUP BY turma.sala_id ORDER BY sala.nome  ");
				
				while($sala = mysql_fetch_object($sqlSala)){
					if( $_GET["sala_id"] == $sala->sala_id ) { $selSala = 'selected="selected"'; } else { $selSala = ''; }
            ?>    
            <option <?=$selSala?> value="<?=$sala->sala_id?>"><?=$sala->nome_sala?></option>
        	<?php
				}
			?>
        </select>
        
        
       </form> 
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="360"><strong>Horarios</strong></td>
                <td style="width:70px;"> M </td>
                <td style="width:70px;"> R </td>
                <td style="width:70px;">Total</td>
                <td></td>
            </tr>
        </thead>
    </table>
    <!--
        ///////////////////////////////////////
        Tabela de Dados
        ///////////////////////////////////////
    -->
    <div id="dados">
    
	  <script>resize()</script><!-- Isso é Necessário para a criação o resize -->
        <table cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            
            <?php
			
			$filterSerie = !(empty($_GET["serie_id"])) ? " AND turma.serie_id = '".trim($_GET["serie_id"])."' " : NULL;
			$filterSala  = !(empty($_GET["sala_id"])) ? " AND t.sala_id = '".trim($_GET["sala_id"])."' " : NULL; 
			$filterPeriodo  = !(empty($_GET["periodo_letivo_id"])) ? " AND periodo.id = '".trim($_GET["periodo_letivo_id"])."' " : NULL;
			$filterEscola  = !(empty($_GET["escola_id"])) ? " AND turma.unidade_id = '".trim($_GET["escola_id"])."' " : NULL; 
			
			  //Período de abertura
			  $periodoAbertura =  empty($_GET["periodo_letivo_id"]) ? " AND periodo.id = '17' " : NULL;	
			
			  $sqlPeriodo = mysql_query(" 
			  SELECT *,periodo.id AS periodo_letivo_id  FROM escolar2_periodo_letivo AS periodo 
				 WHERE periodo.vkt_id = '$vkt_id'
				 $periodoAbertura
				 $filterPeriodo 
				 ORDER BY periodo.data_inicio DESC ");
							
		    while($periodo_turma=mysql_fetch_object($sqlPeriodo)){
				
			  //Quantidade de Matriculas
			   $count_periodo_matricula = mysql_fetch_object(mysql_query($cn=" 
			   SELECT COUNT(*) AS qtd_mat_periodo FROM escolar2_turmas AS turma 
			   JOIN escolar2_matriculas AS matricula ON matricula.turma_id = turma.id
			    
			   AND matricula.matricula_rematricula = 'matricula' 
			   AND matricula.status = 'matricula' 
			   AND turma.vkt_id = '$vkt_id' 
			   AND turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id' "));
			 
			 //Quantidade de Rematriculas
			   $count_periodo_rematricula = mysql_fetch_object(mysql_query($cn=" 
			   SELECT COUNT(*) AS qtd_mat_periodo FROM escolar2_turmas AS turma 
				
				JOIN escolar2_matriculas AS matricula ON matricula.turma_id = turma.id 
			   	AND matricula.matricula_rematricula = 'rematricula'
			   	AND matricula.status = 'matricula' 
			   	AND turma.vkt_id = '$vkt_id' 
				AND turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id'"));
				  
			 $total_mat_periodo =  $count_periodo_matricula->qtd_mat_periodo + $count_periodo_rematricula->qtd_mat_periodo;
        ?>
                <tr <?php echo $cl; ?> >
                	<td width="360" class='cz'><i><b>Per&iacute;odo Letivo: </b></i>&nbsp; <?php echo $periodo_turma->nome; ?></td>                   
                	<td width="110" style="width:70px;"><span style="padding-left:15px;"><?=$count_periodo_matricula->qtd_mat_periodo;?></span></td>                   
                	<td width="50" style="width:70px;"><span style="padding-left:15px;"><?=$count_periodo_rematricula->qtd_mat_periodo;?></span></td>
                    <td width="50" style="width:70px;"><span style="padding-left:15px;"><?=$total_mat_periodo?></span></td>
                    <td>&nbsp;</td>
               	</tr>

		<?												
			  $sql_unidade = mysql_query($p2=" 
			   SELECT * FROM escolar2_turmas AS turma						   
			    WHERE turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id'
			    AND turma.vkt_id = '$vkt_id'
			    $filterEscola
			    GROUP BY turma.unidade_id "); //ok   
				
				while($unidade = mysql_fetch_object($sql_unidade)){
					 
					 $unidade_nome = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_unidades WHERE id = '$unidade->unidade_id' "));
					 
					 //Quantidade de Matriculas
					 $count_unidade_matricula = mysql_fetch_object(mysql_query($cn=" SELECT COUNT(*) AS qtd_mat_unidade FROM escolar2_turmas AS turma 
					 JOIN escolar2_matriculas AS matricula ON matricula.turma_id = turma.id
					 WHERE turma.unidade_id = '$unidade->unidade_id' 
					 AND matricula.matricula_rematricula = 'matricula' 
					 AND matricula.status = 'matricula' 
					 AND turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id' "));
						
					//Quantidade de Rematriculas
					 $count_unidade_rematricula = mysql_fetch_object(mysql_query($cn=" 
					 SELECT COUNT(*) AS qtd_mat_unidade FROM escolar2_turmas AS turma 
					 JOIN escolar2_matriculas AS matricula ON matricula.turma_id = turma.id
					 WHERE turma.unidade_id = '$unidade->unidade_id' 
					 AND matricula.matricula_rematricula = 'rematricula' 
					 AND matricula.status = 'matricula'	
					 AND turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id'"));
					
					$total_mat_unidade =  $count_unidade_matricula->qtd_mat_unidade + $count_unidade_rematricula->qtd_mat_unidade;
								
		?>
                <tr <?php echo $cl; ?> >
                	<td class="cz" style="text-transform:uppercase;"><blockquote> <i><b>Escola:</b></i> &nbsp; <?php echo $unidade_nome->nome." ";//$unidade->unidade_id; ?></blockquote></td>                   
                	<td style="padding-left:0;" align="center"><div><?=$count_unidade_matricula->qtd_mat_unidade;?></div></td>
                    <td style="padding-left:0;" align="center"><?=$count_unidade_rematricula->qtd_mat_unidade;?></td>
                    <td style="padding-left:0;" align="center"><?=$total_mat_unidade?></td>
                	<td>&nbsp;</td>
               	</tr>

        <?									
		  $sql_ensino = mysql_query($p3=" 
		  SELECT *, ensino.nome AS nome_ensino FROM escolar2_turmas AS turma 
		  
		  JOIN escolar2_series AS serie ON serie.id = turma.serie_id	
		  JOIN escolar2_ensino AS ensino ON ensino_id = serie.ensino_id
		  WHERE turma.unidade_id = '$unidade->unidade_id'
		  AND turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id'
		  GROUP BY serie.ensino_id");  //ok  
	  
	  	while($ensino=mysql_fetch_object($sql_ensino)){
		    $ensino_nome = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_ensino WHERE id = '$ensino->ensino_id' "));
		  
		   //Quantidade de Matriculas no Ensino
		   $count_ensino_matricula = mysql_fetch_object(mysql_query($cn=" SELECT COUNT(*) AS qtd_ensino_unidade FROM escolar2_turmas AS turma 
		   
		   JOIN escolar2_matriculas AS matricula ON matricula.turma_id = turma.id
		   JOIN escolar2_series AS serie ON serie.id = turma.serie_id
		   JOIN escolar2_ensino AS ensino ON ensino_id = serie.ensino_id	
		   WHERE turma.unidade_id = '$unidade->unidade_id'
		   AND ensino.id        =  '$ensino_nome->id'
		   AND matricula.matricula_rematricula = 'matricula'
		   AND matricula.status = 'matricula' 
		   AND turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id' "));
			  
		   //Quantidade de Rematriculas no Ensino
		   $count_ensino_rematricula = mysql_fetch_object(mysql_query($cn=" SELECT COUNT(*) AS qtd_ensino_unidade FROM escolar2_turmas AS turma 
		   JOIN escolar2_matriculas AS matricula ON matricula.turma_id = turma.id
		   JOIN escolar2_series AS serie ON serie.id = turma.serie_id	
		   JOIN escolar2_ensino AS ensino ON ensino_id = serie.ensino_id	
		   WHERE turma.unidade_id = '$unidade->unidade_id'
		   AND ensino.id =  '$ensino_nome->id'
		   AND matricula.matricula_rematricula = 'rematricula'
		   AND matricula.status = 'matricula' 
		   AND turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id' "));
			  
		   $total_mat_ensino = $count_ensino_matricula->qtd_ensino_unidade + $count_ensino_rematricula->qtd_ensino_unidade;
									
		?>
                <tr <?php echo $cl; ?> >
                	<td class="cz"><blockquote><blockquote><?php echo $ensino_nome->nome; ?></blockquote></blockquote></td>                   
                	<td style="padding-left:0;" align="center"><?=$count_ensino_matricula->qtd_ensino_unidade?></td>
                    <td style="padding-left:0;" align="center"><?=$count_ensino_rematricula->qtd_ensino_unidade?></td>
                    <td style="padding-left:0;" align="center"><?=$total_mat_ensino?></td>                 
                	<td>&nbsp;</td>
               	</tr>

		<?												
				$s_serie = mysql_query($p4=" SELECT * FROM  escolar2_turmas AS turma 
				  JOIN escolar2_matriculas AS matricula ON matricula.turma_id = turma.id
				  JOIN escolar2_series AS serie ON serie.id = turma.serie_id
				  WHERE serie.ensino_id = '$ensino->ensino_id'
				  AND turma.unidade_id = '$unidade->unidade_id' 
				  $filterSerie 
				  GROUP BY turma.serie_id "); 
					  
				while($serie=mysql_fetch_object($s_serie)){
				
					$serie_nome = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_series WHERE id = '$serie->serie_id' "));
					
					//Quantidade de Matriculas no Ensino
					 $count_serie_matricula = mysql_fetch_object(mysql_query($cn=" SELECT COUNT(*) AS qtd_serie_unidade FROM escolar2_turmas AS turma 
					 
					 JOIN escolar2_matriculas AS matricula ON matricula.turma_id = turma.id
					 JOIN escolar2_series AS serie ON serie.id = turma.serie_id	
					 JOIN escolar2_ensino AS ensino ON ensino_id = serie.ensino_id	
					 
					 WHERE turma.unidade_id = '$unidade->unidade_id'
					 AND ensino.id =  '$ensino_nome->id'
					 AND turma.serie_id = '$serie->serie_id'
					 AND matricula.matricula_rematricula = 'matricula' 
					 AND matricula.status = 'matricula' 
					 AND turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id' "));
					
					//Quantidade de Rematriculas no Ensino
					 $count_serie_rematricula = mysql_fetch_object(mysql_query($cn=" SELECT COUNT(*) AS qtd_serie_unidade FROM escolar2_turmas AS turma 
					 
					 JOIN escolar2_matriculas AS matricula ON matricula.turma_id = turma.id
					 JOIN escolar2_series AS serie ON serie.id = turma.serie_id	
					 JOIN escolar2_ensino AS ensino ON ensino_id = serie.ensino_id	
					 
					 WHERE turma.unidade_id = '$unidade->unidade_id'
					 AND ensino.id =  '$ensino_nome->id'
					 AND turma.serie_id = '$serie_nome->id'
					 AND matricula.matricula_rematricula = 'rematricula' 
					 AND matricula.status = 'matricula'
					 AND turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id' "));	
						
					 $total_serie_matricula = $count_serie_matricula->qtd_serie_unidade + $count_serie_rematricula->qtd_serie_unidade;
               
			   ?>
                <tr <?php echo $cl; ?> id="<?=$serie_nome->id;?>" class="click_serie" periodo-letivo="<?=$periodo_turma->periodo_letivo_id?>"  >
                	<td class="td_serie cz"><blockquote><blockquote> <i><b>S&eacute;rie: &nbsp; </b></i> <?php echo $serie_nome->nome; ?> &nbsp; </blockquote></blockquote></td>  
                	<td style="padding-left:0;" align="center"><?=$count_serie_matricula->qtd_serie_unidade;?></td>
                    <td style="padding-left:0;" align="center"><?=$count_serie_rematricula->qtd_serie_unidade?></td>
                    <td style="padding-left:0;" align="center"><strong><?=$total_serie_matricula?></strong></td>
                	<td>&nbsp;</td>
               	</tr>
 				<?
 
 				$sql_salas = mysql_query($t="SELECT s.id, s.nome, t.horario_id AS horario_id FROM escolar2_turmas as t
				JOIN escolar2_salas as s ON s.id = t.sala_id
				JOIN escolar2_series AS serie ON serie.id = t.serie_id
				
				WHERE t.serie_id='$serie_nome->id'  
				AND t.periodo_letivo_id = '$periodo_turma->id' 
				AND t.unidade_id        = '$unidade_nome->id' 
				AND serie.ensino_id = '$ensino->ensino_id'
				$filterSala
				# AND s.id = t.sala_id 
				
				group by t.sala_id ");
				
				
 				while($sala = mysql_fetch_object($sql_salas)){
					
				$count_sala_matriculado = mysql_fetch_object(mysql_query( " 
				SELECT COUNT(*) AS qtd_sala_mat FROM escolar2_matriculas AS matricula
				JOIN escolar2_turmas AS turma ON turma.id = matricula.turma_id
				JOIN escolar2_series AS serie ON serie.id = turma.serie_id
				
				AND matricula.matricula_rematricula = 'matricula'  
				AND matricula.status != 'cancelada' 
				AND matricula.vkt_id = '$vkt_id'
				AND serie.ensino_id = '$ensino->ensino_id'
				AND turma.sala_id = '$sala->id'
				AND turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id' "));
				
				$count_sala_rematriculado = mysql_fetch_object(mysql_query( " 
				SELECT COUNT(*) AS qtd_sala_remat FROM escolar2_matriculas AS matricula
				JOIN escolar2_turmas AS turma ON turma.id = matricula.turma_id
				JOIN escolar2_series AS serie ON serie.id = turma.serie_id
				
				AND matricula.matricula_rematricula = 'rematricula'  
				AND matricula.status != 'cancelada'
				AND serie.ensino_id = '$ensino->ensino_id'
				AND turma.sala_id = '$sala->id'
				AND turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id' "));
				
				$total_sala = $count_sala_matriculado->qtd_sala_mat + $count_sala_rematriculado->qtd_sala_remat;
				
 				?>               
                <tr id="<?=$sala->id?>" serie_id="<?=$serie_nome->id?>" class="click_sala" periodo-letivo="<?=$periodo_turma->periodo_letivo_id?>">
                    <td  style="padding-left:70px;"><?=$sala->nome?> </td>
                    <td style="padding-left:0;" align="center"><?=$count_sala_matriculado->qtd_sala_mat?></td>
                    <td style="padding-left:0;" align="center"><?=$count_sala_rematriculado->qtd_sala_remat?></td>
                    <td style="padding-left:0;" align="center"><?=$total_sala?></td>
                    <td></td>
                </tr>
                <?
                
 
 			$sql_turmas = mysql_query($t="SELECT * FROM escolar2_turmas AS t  
			WHERE t.serie_id='$serie_nome->id'  
			AND t.periodo_letivo_id='$periodo_turma->id' AND t.unidade_id='$unidade_nome->id' AND  t.sala_id='$sala->id'");

 			while($turma = mysql_fetch_object($sql_turmas)){
	 			$horario = mysql_fetch_object(mysql_query("SELECT * FROM escolar2_horarios WHERE id='$turma->horario_id'"));
				
				$count_turma_horario_mat = mysql_fetch_object(mysql_query( " 
				SELECT COUNT(*) AS qtd_horario_mat FROM escolar2_matriculas AS matricula
				
				JOIN escolar2_turmas AS turma ON turma.id = matricula.turma_id
					
				AND turma.horario_id = '$horario->id'
				AND matricula.turma_id = '$turma->id'
				AND matricula.matricula_rematricula = 'matricula'  
				AND matricula.status != 'cancelada'
				AND matricula.vkt_id = '$vkt_id'
				" )); 
				
				$count_turma_horario_remat = mysql_fetch_object(mysql_query( " 
				SELECT COUNT(*) AS qtd_horario_remat FROM escolar2_matriculas AS matricula
				
				JOIN escolar2_turmas AS turma ON turma.id = matricula.turma_id
					
				AND turma.horario_id = '$horario->id'
				AND matricula.turma_id = '$turma->id'
				AND matricula.matricula_rematricula = 'rematricula'  
				AND matricula.status != 'cancelada'
				AND matricula.vkt_id = '$vkt_id'
				" )); 
				
				$totam_turma_horario = $count_turma_horario_mat->qtd_horario_mat + $count_turma_horario_remat->qtd_horario_remat;
 ?>               
                <tr horario="<?=$horario->id?>" turma="<?=$turma->id?>" class="click_turma_horario" periodo-letivo="<?=$periodo_turma->periodo_letivo_id?>">
                  <td style="padding-left:90px;"><?=$turma->nome." - $horario->nome"?></td>
                  <td style="padding-left:0;" align="center"><?=$count_turma_horario_mat->qtd_horario_mat?></td>
                  <td style="padding-left:0;" align="center"><?=$count_turma_horario_remat->qtd_horario_remat?></td>
                  <td style="padding-left:0;" align="center"><?=$totam_turma_horario?></td>
                  <td></td>
                </tr>
               <?												
 			}
 }

				$sql_horarios = mysql_query($p5=" 
				  SELECT * FROM escolar2_turmas AS turma
				  	JOIN escolar2_matriculas AS matricula ON matricula.turma_id = turma.id
				  	WHERE turma.serie_id = '$serie->serie_id'	
				  	AND turma.unidade_id = '$unidade->unidade_id'
				  	GROUP BY turma.horario_id");			
				
				//echo $p5."<br/>";
				while($horarios=mysql_fetch_object($sql_horarios)){
					
				   $nome_horario = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_horarios WHERE id = '$horarios->horario_id' "));
				  
				  /* Quantidade de Matriculas no Ensino */
				   $count_horario_matricula = mysql_fetch_object(mysql_query($cn=" 
				   SELECT COUNT(*) AS qtd_horario_matricula FROM escolar2_turmas AS turma 
				   
				   JOIN escolar2_matriculas AS matricula ON matricula.turma_id = turma.id
				   
				   JOIN escolar2_series AS serie ON serie.id = turma.serie_id	
				   
				   JOIN escolar2_ensino AS ensino ON ensino_id = serie.ensino_id	
				   
				   WHERE turma.unidade_id = '$unidade->unidade_id'
				   AND ensino.id =  '$ensino_nome->id'
				   AND turma.serie_id = '$serie_nome->id'
				   AND turma.horario_id = '$nome_horario->id'
				   AND matricula.matricula_rematricula = 'matricula' 
				   AND matricula.status = 'matricula'
				   AND turma.vkt_id = '$vkt_id' "));
					  
				  //Quantidade de Rematriculas no Ensino
				   $count_horario_rematricula = mysql_fetch_object(mysql_query($cn=" 
				   SELECT COUNT(*) AS qtd_horario_rematricula FROM escolar2_turmas AS turma 
				   
				   JOIN escolar2_matriculas AS matricula ON matricula.turma_id = turma.id
				   
				   JOIN escolar2_series AS serie ON serie.id = turma.serie_id	
				   
				   JOIN escolar2_ensino AS ensino ON ensino_id = serie.ensino_id	
				   
				   WHERE turma.unidade_id = '$unidade->unidade_id'
				   AND ensino.id        =  '$ensino_nome->id'
				   AND turma.serie_id   = '$serie_nome->id'
				   AND turma.horario_id = '$nome_horario->id'
				   AND matricula.matricula_rematricula = 'rematricula' 
				   AND matricula.status = 'matricula'
				   AND turma.vkt_id = '$vkt_id'
				   "));
						
					$total_mat_horario = $count_horario_matricula->qtd_horario_matricula + $count_horario_rematricula->qtd_horario_rematricula;
                ?>

				<?
					
					$sql_turma = mysql_query($p6=" 
						SELECT *,turma.nome AS nome_turma, turma.id AS id_turma FROM 
							escolar2_turmas AS turma
						
						JOIN escolar2_matriculas AS matricula 
							ON matricula.turma_id = turma.id
						
						WHERE turma.horario_id = '$horarios->horario_id'
						AND turma.serie_id = '$serie->serie_id'
						AND turma.unidade_id = '$unidade->unidade_id'
						AND turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id'
						GROUP BY matricula.turma_id "); //ok
					  
					 //echo $p6."<br/>";
					 while($turma=mysql_fetch_object($sql_turma)){
						
						 /*Quantidade de Matriculas na Turma*/
						 $count_turma_matricula = mysql_fetch_object(mysql_query($cn=" 
						 SELECT COUNT(*) AS qtd_turma_matricula FROM escolar2_turmas AS turma 
						 
						 JOIN escolar2_matriculas AS matricula ON matricula.turma_id = turma.id
						 
						 JOIN escolar2_series AS serie ON serie.id = turma.serie_id	
						 
						 JOIN escolar2_ensino AS ensino ON ensino_id = serie.ensino_id	
						 
						 WHERE turma.unidade_id = '$unidade->unidade_id'
						 AND ensino.id =  '$ensino_nome->id'
						 AND turma.serie_id = '$serie_nome->id'
						 AND turma.horario_id = '$nome_horario->id'
						 AND turma.id = '$turma->id_turma'
						 AND matricula.matricula_rematricula = 'matricula' 
						 AND matricula.status = 'matricula'
						 AND turma.vkt_id = '$vkt_id'
						 "));		  
							
						/* Quantidade de Rematriculas na Turma */
						 $count_turma_rematricula = mysql_fetch_object(mysql_query($cn=" 
						 SELECT COUNT(*) AS qtd_turma_rematricula FROM escolar2_turmas AS turma 
						 
						 JOIN escolar2_matriculas AS matricula ON matricula.turma_id = turma.id
						 
						 JOIN escolar2_series AS serie ON serie.id = turma.serie_id	
						 
						 JOIN escolar2_ensino AS ensino ON ensino_id = serie.ensino_id	
						 
						 WHERE turma.unidade_id = '$unidade->unidade_id'
						 AND ensino.id        =  '$ensino_nome->id'
						 AND turma.serie_id   = '$serie_nome->id'
						 AND turma.horario_id = '$nome_horario->id'
						 AND turma.id         = '$turma->id_turma'
						 AND matricula.matricula_rematricula = 'rematricula' 
						 AND matricula.status = 'matricula'
						 AND turma.vkt_id = '$vkt_id'
						 "));
							
						$total_mat_turma = $count_turma_matricula->qtd_turma_matricula + $count_turma_rematricula->qtd_turma_rematricula;
				?>
				<?php
			  
			  $sql_materia = mysql_query($p7="
				  SELECT *,turma.nome AS nome_turma, professor_turma.id AS id_pht FROM 
					  escolar2_professor_has_turma AS professor_turma
				  
				  JOIN escolar2_turmas AS turma ON professor_turma.turma_id = turma.id
				  
				  JOIN escolar2_serie_has_materias AS serie_materia ON serie_materia.id =  professor_turma.serie_has_materia_id
				  
				  WHERE professor_turma.professor_id = '$professor->id'
				  AND turma.horario_id = '$horarios->horario_id'
				  AND turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id'	
				  AND turma.unidade_id = '$unidade->unidade_id'
				  AND turma.id = '$turma->turma_id'
				  GROUP BY professor_turma.serie_has_materia_id  ");
                 
					   while($serie_materia=mysql_fetch_object($sql_materia)){
						
						$materia = mysql_fetch_object(mysql_query($r=" SELECT * FROM escolar2_materias WHERE id = '$serie_materia->materia_id' ")); 
						$professor_turma = mysql_fetch_object(mysql_query($pt=" SELECT * FROM escolar2_professor_has_turma WHERE professor_id = '$serie_materia->professor_id' AND turma_id = '$turma->turma_id' AND serie_has_materia_id = '$serie_materia->serie_has_materia_id' "));
						
                ?>
				<?						
							}
						} /*fecha while sala*/
					} /* fecha while horário */
				}/* fecha while módulos */
			}
		}
	}
            ?>	
            </tbody>
        </table>
        
  </div>
    
    <!--
        ///////////////////////////////////////
        Linha de layout
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
               <td width="100%"><?=$salas?></td>
            </tr>
        </thead>
    </table>
    <script>
    $("tr:odd").addClass('al');
    </script>
</div>

<!--
    ///////////////////////////////////////
    Rodapé
    ///////////////////////////////////////
-->
<div id="rodape"></div>
