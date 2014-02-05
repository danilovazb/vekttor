<?
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");



				$q = mq("SELECT * FROM  escolar_periodos WHERE vkt_id='$vkt_id' ORDER BY nome");
				while($r=mf($q)){
					$periodo_id= $r->id;
				}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Vis&atilde;o geral de Matriculas</title>
<style>
	blockquote{margin-top:0; margin-bottom:0; margin-right:0; margin-left:15px; padding:0;}
	tbody td{ vertical-align:top; line-height:14px;}
	.cz{ color:#999999; cursor:default}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
table{ border-top:1px solid #000; border-right:1px solid #000;}
td{ border-left:1px solid #000; border-bottom:1px solid #000;}
</style>

</head>

<body>


Resumo geral de Matriculas - <?=date('d/m/Y '.'-'.'H:i')?>
<table cellpadding="0" cellspacing="0" width="600">
            <tbody>
            
            <?php
			if(!empty($_GET['periodo_id'])){
				$filtro_p=" AND escolar_periodos.id=".$_GET['periodo_id'];
			}else{
				$filtro_p=" AND escolar_periodos.id='$periodo_id'";
				
			}
			 $s_periodo = (mysql_query($t=" SELECT * FROM escolar_periodos  WHERE vkt_id='$vkt_id' $filtro_p ORDER BY nome"));
			     			
							while($periodo=mysql_fetch_object($s_periodo)){
					$p_matricula = mysql_fetch_object(mysql_query("SELECT COUNT(*) as pm FROM escolar_matriculas as m, escolar_salas  as s
																	WHERE 
																		m.sala_id=s.id
																	AND
																		m.periodo_id = '$periodo->id'
																	AND 
																		m.tipo_matricula = 'MATRÍCULA'
																	AND 
																		m.pago = 'S'
																	"));
					$pr_matricula = mysql_fetch_object(mysql_query("SELECT COUNT(*) as pr FROM escolar_matriculas 
																	WHERE periodo_id = '$periodo->id'
																	AND tipo_matricula = 'REMATRÍCULA'
																	AND	pago = 'S'
																	"));
						$total_p = $p_matricula->pm + $pr_matricula->pr;
					
						$pm_n = mysql_fetch_object(mysql_query("SELECT COUNT(*) as pm_n FROM escolar_matriculas 
																	WHERE periodo_id = '$periodo->id'
																	AND pago = 'N'
																	"));
					
							//print_r($aluno); 
				
							/*---------------------*/
?>
                <tr >
                  <td bgcolor="#CCCCCC"><strong>Resumo</strong></td>
                  <td width="50" align="center" bgcolor="#CCCCCC"><strong>Matriculas</strong></td>
                  <td width="50" align="center" bgcolor="#CCCCCC"><strong>Rematriculas</strong></td>
                  <td width="50" align="center" bgcolor="#CCCCCC"><strong>Total</strong></td>
                  <td width="50" align="center" bgcolor="#CCCCCC"><strong>Pendentes</strong></td>
                </tr>
                <tr onclick="location='?tela_id=230&periodo=<?=$periodo->id?>'" >
                	<td><?php echo $periodo->nome;?></td>                   
                	<td width="50" align="center"><?php echo $p_matricula->pm;?></td>                   
                	<td width="50" align="center"><?php echo $pr_matricula->pr;?></td>
                	<td width="50" align="center"><?php echo $total_p?></td>
                    <td width="50" align="center"><?php echo $pm_n->pm_n?></td>
                </tr>

<?												
			if(!empty($_GET['escola_id'])){
				$filtro_e="AND e.id=".$_GET['escola_id'];
			}			
							
								$s_escola = (mysql_query($t="SELECT distinct(h.escola_id),e.nome FROM escolar_horarios as h, escolar_escolas as e WHERE h.escola_id =e.id AND h.periodo_id='$periodo->id' AND   h.vkt_id='$vkt_id' $filtro_e"));
								//echo $t;
									while($escola=mysql_fetch_object($s_escola)){
									$e_matricula = mysql_fetch_object(mysql_query($em="
												SELECT COUNT(*) as em FROM escolar_matriculas 
													WHERE periodo_id = '$periodo->id' 
													AND escola_id    = '$escola->escola_id' 
													AND tipo_matricula = 'MATRÍCULA' 
													AND pago = 'S'
													"));
													
									$er_matricula = mysql_fetch_object(mysql_query($em="
												SELECT COUNT(*) as erm FROM escolar_matriculas 
													WHERE periodo_id = '$periodo->id' 
													AND escola_id    = '$escola->escola_id' 
													AND tipo_matricula = 'REMATRÍCULA' 
																										AND pago = 'S'
")); 
									$total_e = $e_matricula->em + $er_matricula->erm;
								/*----------------------*/
								$em_nao = mysql_fetch_object(mysql_query($em="
												SELECT COUNT(*) as em_nao FROM escolar_matriculas 
													WHERE periodo_id = '$periodo->id' 
													AND escola_id    = '$escola->escola_id' 
													 
													AND pago = 'N'
													"));
					
?>
                <tr <?php echo $cl; ?> >
                	<td><blockquote><?php echo $escola->nome;?></blockquote></td>                   
                	<td width="50" align="center"><?php echo $e_matricula->em;?></td>                   
                	<td width="50" align="center" ><?php echo $er_matricula->erm?></td>
                	<td width="50" align="center"><?php echo $total_e?></td>
                    <td width="50" align="center"><?php echo $em_nao->em_nao?></td>
                </tr>

<?									
			if(!empty($_GET['curso_id'])){
				$filtro_c="AND c.id=".$_GET['curso_id'];
			}			
									$s_cursos = (mysql_query($t=" SELECT distinct(h.curso_id),c.nome FROM escolar_horarios as h, escolar_cursos as c WHERE h.curso_id=c.id  AND h.periodo_id='$periodo->id' AND escola_id='$escola->escola_id' AND   h.vkt_id='$vkt_id' $filtro_c"));	
									//echo $t."<br>";	
										while($curso=mysql_fetch_object($s_cursos)){
											$c_matricula = mysql_fetch_object(mysql_query("
												SELECT COUNT(*) as cm FROM escolar_matriculas 
													WHERE periodo_id = '$periodo->id' 
													AND escola_id    = '$escola->escola_id' 
													AND curso_id     = '$curso->curso_id'
													AND tipo_matricula = 'MATRÍCULA'
													AND pago = 'S'
													"));
											$cr_matricula = mysql_fetch_object(mysql_query("
												SELECT COUNT(*) as crm FROM escolar_matriculas 
													WHERE periodo_id = '$periodo->id' 
													AND escola_id    = '$escola->escola_id' 
													AND curso_id     = '$curso->curso_id'
													AND pago = 'S'
													AND tipo_matricula = 'REMATRÍCULA'
													"));
													$total_c = $c_matricula->cm + $cr_matricula->crm;
										/*-------------------------*/
										$cm_n = mysql_fetch_object(mysql_query("
												SELECT COUNT(*) as cm_n FROM escolar_matriculas 
													WHERE periodo_id = '$periodo->id' 
													AND escola_id    = '$escola->escola_id' 
													AND curso_id     = '$curso->curso_id'
													AND pago = 'N'
													"));
?>
                <tr <?php echo $cl; ?> >
                	<td ><blockquote><blockquote><strong><?php echo $curso->nome; ?></strong></blockquote></blockquote></td>                   
                	<td width="50" align="center"><?php echo $c_matricula->cm?></td>                   
                	<td width="50" align="center" ><?php echo $cr_matricula->crm?></td>
                    <td width="50" align="center"><?php echo $total_c?></td>
                    <td width="50" align="center"><?php echo $cm_n->cm_n?></td>
                </tr>

<?												
										$s_modulos =mysql_query($t =" SELECT distinct(h.modulo_id),m.nome FROM escolar_horarios as h, escolar_modulos  as m  WHERE  h.modulo_id=m.id AND h.periodo_id='$periodo->id' AND escola_id='$escola->escola_id' AND h.curso_id='$curso->curso_id' AND   h.vkt_id='$vkt_id' ");
											while($modulos=mysql_fetch_object($s_modulos)){
													$m_matricula = mysql_fetch_object(mysql_query("
												SELECT COUNT(*) as mm FROM escolar_matriculas 
													WHERE periodo_id = '$periodo->id' 
													AND escola_id    = '$escola->escola_id' 
													AND curso_id     = '$curso->curso_id'
													AND modulo_id    = '$modulos->modulo_id'
													AND tipo_matricula = 'MATRÍCULA'
													AND pago = 'S'
													"));
													
													$mr_matricula = mysql_fetch_object(mysql_query("
												SELECT COUNT(*) as mrm FROM escolar_matriculas 
													WHERE periodo_id = '$periodo->id' 
													AND escola_id    = '$escola->escola_id' 
													AND curso_id     = '$curso->curso_id'
													AND modulo_id    = '$modulos->modulo_id'
													AND pago = 'S'
													AND tipo_matricula = 'REMATRÍCULA'
													"));
												/*----------------------*/
												$total_m = $m_matricula->mm + $mr_matricula->mrm;
										$mm_n = mysql_fetch_object(mysql_query("
												SELECT COUNT(*) as mm_n FROM escolar_matriculas 
													WHERE periodo_id = '$periodo->id' 
													AND escola_id    = '$escola->escola_id' 
													AND curso_id     = '$curso->curso_id'
													AND modulo_id    = '$modulos->modulo_id'
													AND pago = 'N'
													"));
?>
                <tr <?php echo $cl; ?>  >
                	<td bgcolor="#CCCCCC"  ><blockquote><blockquote><blockquote><strong><?php echo $modulos->nome; ?></strong></blockquote></blockquote></blockquote></td>                   
                	<td width="50" align="center" bgcolor="#CCCCCC"><?php echo $m_matricula->mm?></td>                   
                	<td width="50" align="center" bgcolor="#CCCCCC"><?php echo $mr_matricula->mrm?></td>
                	<td width="50" align="center" bgcolor="#CCCCCC"><?php echo $total_m?></td>
                    <td width="50" align="center" bgcolor="#CCCCCC"><?php echo $mm_n->mm_n?></td>
                </tr>

<?												
														$s_horario = mq($t=" SELECT * FROM escolar_horarios WHERE modulo_id = '$modulos->modulo_id' AND periodo_id='$periodo->id' AND curso_id='$curso->curso_id' AND escola_id='$escola->escola_id' AND   vkt_id='$vkt_id' ");

														while($horarios=mf($s_horario)){
															$h_matricula = mysql_fetch_object(mysql_query("
																	SELECT COUNT(*) as hm FROM escolar_matriculas as m
																		WHERE 
																		 m.horario_id   = '$horarios->id'
																		AND m.tipo_matricula = 'MATRÍCULA'
																		AND m.pago = 'S'
															"));
															
															$hr_matricula = mysql_fetch_object(mysql_query("
																	SELECT COUNT(*) as hm FROM escolar_matriculas as m
																		WHERE 
																		 m.horario_id   = '$horarios->id'
																		AND m.tipo_matricula = 'REMATRÍCULA'
																		AND m.pago = 'S'

															"));
															$total_h = $h_matricula->hm + $hr_matricula->hm;
															$hm_n = mysql_fetch_object(mysql_query("
																	SELECT COUNT(*) as hm FROM escolar_matriculas as m
																		WHERE 
																		 m.horario_id   = '$horarios->id'
																		AND m.pago = 'N'
															"));

?>
                <tr >
                	<td  ><blockquote><blockquote><blockquote><blockquote><?php 
					 if(strlen($horarios->nome)>0){
						 echo $horarios->nome; 
					 }else{
					 	echo converte_numeros_comvirgula_em_dias_semanas($horarios->dias_semana ,$semana_abreviado)." ".substr($horarios->horario_inicio,0,5)." às ".substr($horarios->horario_fim ,0,5); 
					 }
					?></blockquote></blockquote></blockquote></blockquote></td>                   
                	<td width="50" align="center"><?php echo $h_matricula->hm;?></td>                   
                	<td width="50" align="center"><?php echo $hr_matricula->hm;?></td>
                	<td width="50" align="center"><?php echo $total_h?></td>
                    <td width="50" align="center"><?php echo $hm_n->hm?></td>
                </tr>

				<?
						if(!empty($_GET['de'])&&!empty($_GET['ate'])){
							$filtro_i = "AND idade_minima='".$_GET['de']."' AND idade_maxima='".$_GET['ate']."'";
						}
							$s_salas = mysql_query($t="SELECT * FROM escolar_salas 
							WHERE horario_id='$horarios->id' $filtro_i AND  vkt_id='$vkt_id' ");
							//echo $t;
							while($sala=mysql_fetch_object($s_salas)){
									$s_matricula = mysql_fetch_object(mysql_query($sm="
																	SELECT COUNT(*) as sm FROM escolar_matriculas as m
																		
																		WHERE 
																		 m.sala_id        = '$sala->id'
																		AND m.tipo_matricula = 'MATRÍCULA'
																		AND m.pago = 'S'
															"));
									$sr_matricula = mysql_fetch_object(mysql_query($sm="
																	SELECT COUNT(*) as sm FROM escolar_matriculas as m
																		
																		WHERE 
																		 m.sala_id        = '$sala->id'
																		AND m.tipo_matricula = 'REMATRÍCULA'
																		AND m.pago = 'S'
															"));
									$total_s = $s_matricula->sm + $sr_matricula->sm;
									
									$sm_n = mysql_fetch_object(mysql_query($sm="
																	SELECT COUNT(*) as sm FROM escolar_matriculas as m
																		
																		WHERE 
																		 m.sala_id        = '$sala->id'
																		AND m.pago = 'N'
															"));
				?>
                 <tr >
                	<td><blockquote><blockquote><blockquote><blockquote><blockquote><?php echo $sala->nome; ?></blockquote></blockquote></blockquote></blockquote></blockquote></td>
                    <td width="50" align="center"><?php echo $s_matricula->sm;?></td>                   
                	<td width="50" align="center"><?php echo $sr_matricula->sm; ?></td>
                    <td width="50" align="center"><?php echo $total_s; ?></td>
                	<td width="50" align="center"><?php echo $sm_n->sm?></td>
               	</tr>
                
				<?						
							} /*fecha while sala*/
													} /* fecha while horário */
											}/* fecha while módulos */
										 }
								    }
							}
            ?>	
            </tbody>
</table>
</body>
</html>