<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho;


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
   <div id="some">«</div>
        <a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="./?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo">Aulas Online<span></span></a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de Ações
        ///////////////////////////////////////
    -->
    <div id="barra_info">
       <button type="button" name="todas_perguntas" onclick="location.href='?tela_id=296&professor=<?=$professor->id?>'"> <img src="modulos/escolar/area_aluno/forum/img/group.png" align="absbottom"> Perguntas Forum</button>
       <button type="button" name="mensagens_privadas" onclick="location.href='?tela_id=297&professor=<?=$professor->id?>'">  Mensagens Privadas</button>
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
                	<td >&nbsp;</td>
               	</tr>

<?												
										$s_modulos =mysql_query($t =" SELECT distinct(s.modulo_id) as id, m.nome 
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
                	<td >&nbsp;</td>
               	</tr>

<?												
														$materias_q= mq($t=" SELECT * FROM escolar_materias 
																				WHERE 
																					modulo_id = '$modulos->id'
																				AND
																					vkt_id = '$vkt_id' 
																				");
																				while($materia=mysql_fetch_object($materias_q)){
																					?>
																					<tr <?php echo $cl; ?> onclick="location='?tela_id=325&modulo_id=<?=$modulos->id?>&materia_id=<?=$materia->id?>'">
                                                                                    	<td><blockquote><blockquote><blockquote><blockquote><?=$materia->nome?></blockquote></blockquote></blockquote></blockquote></td>
                                                                                        <td></td>
                                                                                    </tr>
                                                                                    
                                                                                    
																					<?
																				}
																				

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