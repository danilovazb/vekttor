<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho;

include ("_functions.php");
include ("_ctrl.php");

$professor = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_professor WHERE usuario_id = '$usuario_id'"));
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="conteudo">
<script>
$("select#options").live('change',function(){
	        var tela            = $(this).val();
			
			var turma      = $(this).parents().find('#sala_turma').val();
			var materia    = $(this).parents().find('#materia_id').val();
			var periodo_id = $(this).parents().find('#periodo_id').val();
			var sala_materia       = $(this).parents().find('#sala_materia').val();
				//alert(periodo_materia);
				location.href='?tela_id='+tela+'&materia='+materia+'&periodo_id='+periodo_id+'&sala='+turma+'&sala_materia='+sala_materia;
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
        
        <a href="./" class='s2'>Escolar</a>
        <a href="./?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo">Área do Aluno<span></span></a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
       
        
       
      
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabeçalho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="360">Horarios</td>
                <td width="110">A&ccedil;&atilde;o</td>
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
			if(!empty($_GET['periodo_id'])){
				$filtro_p="AND escolar_periodos.id=".$_GET['periodo_id'];
			}
			 $s_periodo = (mysql_query($p=" SELECT distinct(h.periodo_id),p.nome 
			 									FROM escolar_periodos as p
												
	  										JOIN escolar_horarios as h ON h.periodo_id=p.id
	  										JOIN escolar_salas as s ON s.horario_id=h.id
	  										JOIN escolar_sala_materia_professor as smp ON smp.sala_id=s.id  
											
											WHERE 
												p.vkt_id='$vkt_id'
											AND 
												smp.professor_id = '$professor->id' "));
			     			
							
							
							
							while($periodo=mysql_fetch_object($s_periodo)){
							/*---------------------*/
?>
                <tr <?php echo $cl; ?> >
                	<td width="360" class='cz'><?php echo $periodo->nome; ?></td>                   
                	<td width="110">&nbsp;</td>                   
                	<td >&nbsp;</td>
               	</tr>

<?												
			if(!empty($_GET['escola_id'])){
				$filtro_e="AND e.id=".$_GET['escola_id'];
			}			
							
								$s_escola = (mysql_query($e="SELECT distinct(s.escola_id), e.nome 
																FROM escolar_escolas as e
	
																	JOIN escolar_horarios as h ON h.periodo_id = '$periodo->periodo_id'
																	JOIN escolar_salas as s  ON s.escola_id=e.id
																	JOIN escolar_sala_materia_professor as smp ON smp.sala_id=s.id 
																
																WHERE 
																	e.vkt_id='$vkt_id'
																AND 
																	smp.professor_id = '$professor->id' "));
								//echo $t;
									while($escola=mysql_fetch_object($s_escola)){
								/*----------------------*/
?>
                <tr <?php echo $cl; ?> >
                	<td width="360" class="cz" ><blockquote><?php echo $escola->nome; ?></blockquote></td>                   
                	<td width="110">&nbsp;</td> 
                	<td >&nbsp;</td>
               	</tr>

<?									
			if(!empty($_GET['curso_id'])){
				$filtro_c="AND c.id=".$_GET['curso_id'];
			}			
									$s_cursos = (mysql_query($t=" SELECT distinct(s.curso_id), c.nome 
																	 FROM escolar_cursos as c
	
																		JOIN escolar_horarios as h ON h.escola_id = '$escola->escola_id'
																			 AND h.periodo_id = '$periodo->periodo_id'
																		JOIN escolar_salas as s  ON s.curso_id=c.id
																		JOIN escolar_sala_materia_professor as smp ON smp.sala_id=s.id 
	
																	WHERE 
																		c.vkt_id='$vkt_id'
																	AND 
																		smp.professor_id = '$professor->id'"));	
									//echo $t."<br>";	
										while($curso=mysql_fetch_object($s_cursos)){
										/*-------------------------*/
?>
                <tr <?php echo $cl; ?> >
                	<td width="360" class="cz"><blockquote><blockquote><?php echo $curso->nome; ?></blockquote></blockquote></td>                   
                	<td width="110">&nbsp;</td>                   
                	<td >&nbsp;</td>
               	</tr>

<?												
										$s_modulos =mysql_query($t =" SELECT distinct(s.modulo_id), m.nome 
																		FROM escolar_horarios as h
	
																			JOIN escolar_salas as s ON s.horario_id = h.id 
																			JOIN escolar_modulos as m ON s.modulo_id=m.id 	
																			JOIN escolar_sala_materia_professor as smp ON smp.sala_id=s.id		
																		WHERE 
																			h.periodo_id = '$periodo->periodo_id' AND h.curso_id = '$curso->curso_id'	    
																		AND 
																			smp.professor_id = '$professor->id'
																		AND 
																			m.vkt_id = '$vkt_id'");
											while($modulos=mysql_fetch_object($s_modulos)){
												/*----------------------*/
?>
                <tr <?php echo $cl; ?> >
                	<td width="360" class="cz"><blockquote><blockquote><blockquote><?php echo $modulos->nome; ?></blockquote></blockquote></blockquote></td>  
                	<td width="110">&nbsp;</td>
                	<td >&nbsp;</td>
               	</tr>

<?												
														$s_horario = mq($t=" SELECT distinct(s.horario_id), h.nome
																				FROM escolar_horarios as h 
																				
																				JOIN escolar_salas as s ON s.horario_id=h.id 
																				JOIN escolar_sala_materia_professor as smp ON smp.sala_id=s.id 
																				
																				WHERE 
																					h.periodo_id = '$periodo->periodo_id'
																				AND
																					h.curso_id = '$curso->curso_id' 
																				");

														while($horarios=mf($s_horario)){

?>
                <tr>
                	<td width="360" class="cz"><blockquote><blockquote><blockquote><blockquote><?
					 if(strlen($horarios->nome)>0){
						 echo $horarios->nome; 
					 }else{
					 	echo converte_numeros_comvirgula_em_dias_semanas($horarios->dias_semana ,$semana_abreviado)." ".substr($horarios->horario_inicio,0,5)." às ".substr($horarios->horario_fim ,0,5); 
					 }
					 
					 ?>
                	</blockquote></blockquote></blockquote></blockquote></td>                   
                	<td width="110" class="cz"></td>
                	<td class="cz"></td>
               	</tr>

				<?
						if(!empty($_GET['de'])&&!empty($_GET['ate'])){
							$filtro_i = "AND idade_minima='".$_GET['de']."' AND idade_maxima='".$_GET['ate']."'";
						}
						//$s_salas = mysql_query($tv="SELECT * FROM escolar_salas WHERE horario_id='$horarios->id' ");
						$s_turma = mysql_query("SELECT distinct(esm.sala_id) FROM escolar_salas as es 
													JOIN 
														escolar_sala_materia_professor as esm ON es.id=esm.sala_id
													WHERE 
														es.horario_id='$horarios->horario_id' AND esm.professor_id = '$professor->id' AND esm.vkt_id = '$vkt_id'");
											//echo $t;
											while($turma=mysql_fetch_object($s_turma)){
												//$salas++;
												$sala = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_salas WHERE id = '$turma->sala_id'"));
									
				?>
                 
                 <tr>
                	<td width="360"><blockquote><blockquote><blockquote><blockquote><blockquote><strong><?php echo $sala->nome; ?></strong></blockquote></blockquote></blockquote></blockquote></blockquote></td>
                    
                    <td width="110" align="center"><strong><?php //echo $sala->idade_minima; ?></strong></td>
                	<td></td>                   
               	</tr>
                
                						<?php
                                        	
											$mat_turma_professor = mysql_query($g="SELECT 
																			*,
																			es.id as periodo_materia_id
																		FROM 
																			escolar_sala_materia_professor es 
																		JOIN 	
																			escolar_materias  m on es.materia_id = m.id	
																	 	WHERE 
																			es.professor_id = '$professor->id' 
																	 	AND 
																			es.sala_id  = '$turma->sala_id'
																	 	AND 
																			es.vkt_id = '$vkt_id' " );
														while($r_materia=mysql_fetch_object($mat_turma_professor)){
																	$sala_materia=mysql_fetch_object(mysql_query("SELECT 
																							*,
																							sm.id as sala_materia 
																						FROM 
																							escolar_sala_materia_professor sm 
																						JOIN 
																							escolar_salas s on sm.sala_id = s.id
																						WHERE 
																							sala_id = '$r_materia->sala_id'
																						AND 
																							sm.professor_id = '$professor->id' 
																						AND materia_id = '$r_materia->materia_id'	
																						"));
										?>
                
                <tr>
                	<td width="360">
                    	<input type="hidden" name="sala_turma" id="sala_turma" value="<?=$r_materia->sala_id?>">
                    	<input type="hidden" name="materia_id" id="materia_id" value="<?=$r_materia->materia_id?>">
         
                        <input type="hidden" name="periodo_id" id="periodo_id" value="<?=$periodo->periodo_id?>">
                        <input type="hidden" name="sala_materia" id="sala_materia" value="<?=$sala_materia->sala_materia?>">
                    <blockquote><blockquote><blockquote><blockquote><blockquote><blockquote><?php echo $r_materia->nome; ?></blockquote></blockquote></blockquote></blockquote></blockquote></blockquote></td>
                    
                    <td width="110"><select name="options" id="options">
                            <option>Selecione</option>
                        	<option value="256">Avaliaçao</option>
                            <option value="259">Aula</option>
                            <option value="266">Média Final</option>
                            <option value="270">Recuperaçao</option>
                        </select></td>
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
<div id="rodape">

	
    
</div>