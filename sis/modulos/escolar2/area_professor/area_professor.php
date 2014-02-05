<?php

$array_tempo = array(0=>" 1ª Tempo",1=>" 2ª Tempo",2=>" 3º Tempo",3=>" 4º Tempo",4=>" 5º Tempo",5=>" 6º Tempo",6=>" 7º Tempo",7=>"8º Tempo ",8=>" 9º Tempo",9=>" 10º Tempo");
$array_dia_semana = array(1=>"Segunda-Feira",2=>"Terça-Feira",3=>"Quarta-Feira",4=>"Quinta-Feira",5=>"Sexta-Feira",6=>"Sábado",7=>"Domingo");

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho;

include ("_functions.php");
include ("_ctrl.php");
$_SESSION["url_voltar"] =  $_SERVER['REQUEST_URI'];

$professor = mysql_fetch_object(mysql_query($yu=" SELECT * FROM escolar2_professores WHERE usuario_id = '$usuario_id'"));
 
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="conteudo">
<script>
$(function(){
	//some_menu();
});
</script>
<script>
$("select#bimestre_id").live('change',function(){
		
	var bimestre_id       = $(this).val();
	var professor_has_turma = $(this).parents().find('#professor_has_turma').val();
	var unidade_id = $(this).parents().find('#unidade_id').val();
	var turma_id   = $(this).parents().find('#turma_id').val();
	var ensino_id   = $(this).parents().find('#ensino_id').val();
	var serie_has_materia   = $(this).parents().find('#serie_has_materia').val();
	//console.log(professor_has_turma);
	//location.href='?tela_id='+tela+'&professor_as_turma='+professor_as_turma+"&unidade_id="+unidade_id+"&turma_id="+turma_id+"&serie_has_materia="+serie_has_materia+"&ensino_id="+ensino_id;
	location.href="?tela_id=494&turma_id="+turma_id+"&bimestre_id="+bimestre_id+"&unidade_id="+unidade_id+"&ensino_id="+ensino_id+"&professor_has_turma="+professor_has_turma;
			
})
</script>
<style>
	blockquote{margin-top:0; margin-bottom:0; margin-right:0; margin-left:15px; padding:0;}
	tbody td{ vertical-align:top; line-height:14px;}
	.cz{ color:#999999; cursor:default}
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
    <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="./?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo">Área do Professor<span></span></a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
       <!--<button type="button" name="todas_perguntas" onclick="location.href='?tela_id=296&professor=<?=$professor->id?>'"> <img src="modulos/escolar/area_aluno/forum/img/group.png" align="absbottom"> Perguntas Forum</button>
       <button type="button" name="mensagens_privadas" onclick="location.href='?tela_id=297&professor=<?=$professor->id?>'">  Mensagens Privadas</button>-->
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="360"></td>
                <td width="129"></td>
                <td width="60" style="padding-left:0;" align="center">Qtd Aluno</td>
                <td width="50"></td>
                <td></td>
            </tr>
        </thead>
         
            <!--<tr>
                <td width="360"><strong>Horarios</strong></td>
                <td width="129"><strong>A&ccedil;&atilde;o</strong></td>
                <td width="50" style="border-bottom:1px solid #E2E2E2;"><span style="padding-left:5px;">Qtd Alunos</span></td>
                <td width="50" style="border-bottom:1px solid #E2E2E2;">&nbsp;</td>
                        
                <td></td>
            </tr>-->
        
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
			if(!empty($_GET['periodo_id'])){
				$filtro_p="AND escolar_periodos.id=".$_GET['periodo_id'];
			}
			
			 $sql_professor_turma = mysql_query($p1=" 
			  SELECT *,periodo.nome AS nome_periodo FROM 
				  escolar2_professor_has_turma AS professor_turma
			  JOIN 
				  escolar2_turmas AS turma ON professor_turma.turma_id = turma.id
			  JOIN 
				  escolar2_periodo_letivo AS periodo ON periodo.id = turma.periodo_letivo_id
			  WHERE 
				  professor_turma.professor_id = '$professor->id'
			  GROUP BY 
				  turma.periodo_letivo_id ");
							
			//echo $p1."<br/>";				
		    while($periodo_turma=mysql_fetch_object($sql_professor_turma)){
				 
        ?>
                <tr <?php echo $cl; ?> >
                	<td width="360" class='cz'><?php echo $periodo_turma->nome; ?></td>                   
                	<td width="110">&nbsp;</td>                   
                	<td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                    <td >&nbsp;</td>
               	</tr>

		<?												
			  $sql_unidade = mysql_query($p2=" SELECT * FROM escolar2_professor_has_turma AS professor_turma							   
			   
			   JOIN escolar2_turmas AS turma 
			   		ON turma.id = professor_turma.turma_id
			   
			   WHERE 
					professor_turma.professor_id = '$professor->id'
				AND
					turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id'
				GROUP BY 
					turma.unidade_id "); //ok   
				 
				 //echo $p2."<br/>"; 
				while($unidade = mysql_fetch_object($sql_unidade)){
					 $unidade_nome = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_unidades WHERE id = '$unidade->unidade_id' "));
								
		?>
                <tr <?php echo $cl; ?> >
                	<td width="360" class="cz" ><blockquote><?php echo $unidade_nome->nome." ".$unidade->unidade_id; ?></blockquote></td>                   
                	<td width="110">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                	<td >&nbsp;</td>
               	</tr>

        <?									
			$sql_ensino = mysql_query($p3=" 
			SELECT * FROM 
				escolar2_professor_has_turma AS professor_turma							
			JOIN 
				escolar2_turmas AS turma ON turma.id = professor_turma.turma_id
			JOIN 
				escolar2_series AS serie ON serie.id = turma.serie_id	
			JOIN 
				escolar2_ensino AS ensino ON ensino_id = serie.ensino_id
			WHERE 
				professor_turma.professor_id = '$professor->id'
			AND
				turma.unidade_id = '$unidade->unidade_id'
			AND
				turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id'
			GROUP BY 
				serie.ensino_id");  //ok  
				//echo $p3."<br/>";
				while($ensino=mysql_fetch_object($sql_ensino)){
					$ensino_nome = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_ensino WHERE id = '$ensino->ensino_id' "));
					
								
		?>
                <tr <?php echo $cl; ?> >
                	<td width="360" class="cz"><blockquote><blockquote><?php echo $ensino_nome->nome." - ".$ensino->ensino_id; ?></blockquote></blockquote></td>                   
                	<td width="110">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>                 
                	<td >&nbsp;</td>
               	</tr>

		<?												
		  $s_serie = mysql_query($p4=" 
		  SELECT * FROM 
		   		escolar2_professor_has_turma AS professor_turma  
		  JOIN 
				escolar2_turmas AS turma ON professor_turma.turma_id = turma.id
		  JOIN 
				escolar2_series AS serie ON serie.id = turma.serie_id
		  WHERE 
				professor_turma.professor_id = '$professor->id'
		  AND
				serie.ensino_id = '$ensino->ensino_id'
		  AND
				turma.unidade_id = '$unidade->unidade_id'  
		  GROUP BY 
				turma.serie_id "); 
				//echo "<p>".$p4."</p><br/>";	
				while($serie=mysql_fetch_object($s_serie)){
					$serie_nome = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_series WHERE id = '$serie->serie_id' "));	
               ?>
                <tr <?php echo $cl; ?> >
                	<td width="360" class="cz"><blockquote><blockquote><blockquote><?php echo $serie_nome->nome; ?></blockquote></blockquote></blockquote></td>  
                	<td width="110">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                	<td >&nbsp;</td>
               	</tr>

               <?												
								
				$sql_horarios = mysql_query($p5=" 
				  SELECT * FROM 
				  	  escolar2_professor_has_turma AS professor_turma
				  JOIN 
				  	  escolar2_turmas AS turma ON professor_turma.turma_id = turma.id
				  WHERE 
					  professor_turma.professor_id = '$professor->id'
				  AND 
					  turma.serie_id = '$serie->serie_id'	
				  AND
					  turma.unidade_id = '$unidade->unidade_id'
				  GROUP BY 
				  	  turma.horario_id");			
				
				//echo $p5."<br/>";
				while($horarios=mysql_fetch_object($sql_horarios)){
					
						$nome_horario = mysql_fetch_object(mysql_query(" SELECT * FROM escolar2_horarios WHERE id = '$horarios->horario_id' "));
                ?>
               <tr>
                	<td width="360" class="cz"><blockquote><blockquote><blockquote><blockquote><?php echo $nome_horario->nome;?>
                	</blockquote></blockquote></blockquote></blockquote></td>                   
                	<td width="110" class="cz"></td>
                    <td width="50">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                	<td class="cz"></td>
               	</tr>

				<?
					
					$sql_turma = mysql_query($p6=" 
						SELECT *,turma.nome AS nome_turma FROM 
							escolar2_professor_has_turma AS professor_turma
						JOIN 
							escolar2_turmas AS turma ON professor_turma.turma_id = turma.id
						WHERE 
							professor_turma.professor_id = '$professor->id'
						AND
							turma.horario_id = '$horarios->horario_id'
						AND
							turma.serie_id = '$serie->serie_id'
						AND
							turma.unidade_id = '$unidade->unidade_id'
						AND
						  turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id'
						
						GROUP BY 
							professor_turma.turma_id "); //ok
					  
					//echo $p6."<br/>";
					 while($turma=mysql_fetch_object($sql_turma)){		  
				?>
                 
           <tr>
              <td width="360"><blockquote><blockquote><blockquote><blockquote><blockquote> Turma: <strong><?php echo $turma->nome_turma; ?></strong></blockquote></blockquote></blockquote></blockquote></blockquote></td>
              <td width="110" align="center"><strong><?php //echo $sala->idade_minima; ?></strong></td>
              <td width="50">&nbsp;</td>
              <td width="50">&nbsp;</td>
              <td></td>                   
          </tr>
				<?php
                $sql_materia = mysql_query($p7="
						
						SELECT *,turma.nome AS nome_turma, professor_turma.id AS id_pht FROM 
							escolar2_professor_has_turma AS professor_turma
						JOIN 
							escolar2_turmas AS turma ON professor_turma.turma_id = turma.id
						JOIN
						    escolar2_serie_has_materias AS serie_materia ON  serie_materia.id =  professor_turma.serie_has_materia_id
						WHERE 
							professor_turma.professor_id = '$professor->id'
						AND
							turma.horario_id = '$horarios->horario_id'
						AND
							turma.periodo_letivo_id = '$periodo_turma->periodo_letivo_id'	
						AND
							turma.unidade_id = '$unidade->unidade_id'
						AND
							turma.id = '$turma->turma_id'
						GROUP BY 
							professor_turma.serie_has_materia_id  ");//ok
                 
					   //echo $p7."<br/>";	
					   while($serie_materia=mysql_fetch_object($sql_materia)){
						
						$materia = mysql_fetch_object(mysql_query($r=" SELECT * FROM escolar2_materias WHERE id = '$serie_materia->materia_id' ")); 
						$professor_turma = mysql_fetch_object(mysql_query($pt=" SELECT * FROM escolar2_professor_has_turma WHERE professor_id = '$serie_materia->professor_id' AND turma_id = '$turma->turma_id' AND serie_has_materia_id = '$serie_materia->serie_has_materia_id' "));
						
                ?>
            
                 <tr>
                      <td width="360">
                        <input type="hidden" name="sala_turma" id="sala_turma" value="<?=$r_materia->sala_id?>">
                        <input type="hidden" name="serie_has_materia" id="serie_has_materia" value="<?=$serie_materia->serie_has_materia_id?>">
                        <input type="hidden" name="periodo_id" id="periodo_id" value="<?=$periodo->periodo_id?>">
                        <input type="hidden" name="turma_id"   id="turma_id"   value="<?=$turma->turma_id?>">
                        <input type="hidden" name="ensino_id" id="ensino_id" value="<?=$ensino->ensino_id?>">
                        <input type="hidden" name="unidade_id" id="unidade_id" value="<?=$unidade->unidade_id?>">
                        <input type="hidden" name="professor_has_turma" id="professor_has_turma" value="<?php echo $professor_turma->id?>">
                          
                      <blockquote><blockquote><blockquote><blockquote><blockquote><blockquote><?php echo $materia->nome;?></blockquote></blockquote></blockquote></blockquote></blockquote></blockquote></td>
                      
                      <td style="padding-left:0px;">
                         <label>
                            <select name="bimestre_id" id="bimestre_id">
                            <option>Selecione bimestre:</option>
                                <?
                                  $sql_bimestre = mysql_query(" SELECT * FROM escolar2_periodos_avaliacao WHERE vkt_id = '$vkt_id' AND unidade_id = {$unidade->unidade_id} ORDER BY id");
                                      while($r_bimestre=mysql_fetch_object($sql_bimestre)){
        
                                ?>
                                        <option  value="<?=$r_bimestre->id?>"><?=$r_bimestre->nome?></option>
                                <?
                                        }
                                ?>
                            </select>
                    	</label>
                      </td>
                     
                      <?php
                          //$qtdAula = mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS qtd FROM  escolar_aula WHERE sala_materia_professor_id = '$sala_materia->sala_materia'"));
                          //$smp = mysql_fetch_object(mysql_query(" SELECT *  FROM  escolar_sala_materia_professor WHERE id = '$sala_materia->sala_materia' AND vkt_id = '$vkt_id'"));
                      ?>
                      <td width="50" style="padding-left:0; padding:0" align="center">
                      	<div><strong><? $sqlqtdAluno = mysql_fetch_object(mysql_query(" SELECT COUNT(*) AS qtd FROM escolar2_matriculas WHERE turma_id = '$turma->turma_id' AND status != 'cancelada' "));
						echo $sqlqtdAluno->qtd;
						?></strong></div>
                      </td>
                      <td width="50" style="padding-left:0; padding:0" align="center"><div><strong><?php //echo $smp->limite_aula ;?></strong></div></td>      
                      <td>&nbsp;</td>                   
                  </tr>
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
