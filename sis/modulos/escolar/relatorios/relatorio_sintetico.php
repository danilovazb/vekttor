<?php

$tela = mysql_fetch_object ( mysql_query ( "SELECT * FROM sis_modulos WHERE id='{$_GET[tela_id]}'" ) );
$caminho = $tela->caminho;

include ("_functions.php");
//include ("_ctrl.php");


?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="conteudo">
<script>


function calcula_vagas(){
	vagas_por_sala 			   = document.getElementById("vagas_por_sala").value*1;
	vagas_por_sala_rematricula = document.getElementById("vagas_por_sala_rematricula").value*1;
	qtde_salas	  	 		   = document.getElementById("qtde_salas").value*1;// alunos por sala
		
	vagas_total =vagas_por_sala+vagas_por_sala_rematricula;
	
	qt_de_salas = vagas_total / qtde_salas;
	 // Salaas
	document.getElementById("vagas_total_horario").innerHTML =vagas_total;
	document.getElementById("inputvagas_total_horario").value =vagas_total;
	if(qt_de_salas!=Infinity){
		document.getElementById("total_salas_rematricula").innerHTML =qt_de_salas;
	}

}
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
        Barra de Navega��o
        ///////////////////////////////////////
    -->
    <div id="navegacao">
         <div id="some">�</div>
		<a href="#" class='s1'>
  			SISTEMA
		</a>
        <a href="./" class='s2'>Escolar</a>
        <a href="./?tela_id=<?=$_GET[tela_id]?>" class="navegacao_ativo">Vis&atilde;o Geral<span></span></a>
    </div>
    
    <!--
        ///////////////////////////////////////
        Barra de A��es
        ///////////////////////////////////////
    -->
    <div id="barra_info">
    <input type="button" value="Imprimir" onclick="window.open('<?=$caminho?>/relatorio_sintetico_print.php?periodo_id='+document.getElementById('periodo_id').value,'blank')" style="float:right; margin-top:3px;  margin-right:3px;" />
      <select name="periodo_id[]" class="periodo_id" id='periodo_id' style="margin-top:3px;" onchange="location='?tela_id=<?=$_GET[tela_id]?>&periodo_id='+this.value">
            	<option value="0">Selecione 1 Per�odo</option>
            	<?
				
				$q = mq("SELECT * FROM  escolar_periodos WHERE vkt_id='$vkt_id' ORDER BY nome");
				while($r=mf($q)){
						if($_GET[periodo_id]==$r->id){$s="selected='selected'";}else{$s='';}
				echo "<option $s value='$r->id'>$r->nome</option>";
					$periodo_id= $r->id;
				}
				
				?>
            </select>
    </div>
        
    <!--
        ///////////////////////////////////////
        Cabe�alho da tabela
        ///////////////////////////////////////
    -->
    <table cellpadding="0" cellspacing="0" width="100%">
        <thead>
            <tr>
                <td width="360">Horarios</td>
                <td width="90">Matricula</td>
                <td width="90">Rematricula</td>
                <td width="90">Total</td>
                <td width="90">N&atilde;o Pagos</td>
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
    
	  <script>resize()</script><!-- Isso � Necess�rio para a cria��o o resize -->
        <table cellpadding="0" cellspacing="0" width="100%">
            <tbody>
            
            <?php
			if(!empty($_GET['periodo_id'])){
				$filtro_p=" AND escolar_periodos.id=".$_GET['periodo_id'];
			}else{
				$filtro_p=" AND escolar_periodos.id='$periodo_id'";				
			}
			 $s_periodo = (mysql_query($t=" SELECT * FROM escolar_periodos WHERE vkt_id='$vkt_id' $filtro_p ORDER BY nome"));
			   //echo $t;  			
							while($periodo=mysql_fetch_object($s_periodo)){
					$p_matricula = mysql_fetch_object(mysql_query("SELECT COUNT(*) as pm FROM escolar_matriculas as m
																	WHERE 
																		m.periodo_id = '$periodo->id'
																	AND 
																		m.tipo_matricula = 'MATR�CULA'
																	AND 
																		m.pago = 'S'
																	
																		
																	"));
					$pr_matricula = mysql_fetch_object(mysql_query("SELECT COUNT(*) as pr FROM escolar_matriculas 
																	WHERE periodo_id = '$periodo->id'
																	AND 
																		tipo_matricula = 'REMATR�CULA'
																	AND 
																		pago = 'S'
																	"));
						$total_p = $p_matricula->pm + $pr_matricula->pr;
					
						$pm_n = mysql_fetch_object(mysql_query("SELECT COUNT(*) as pm_n FROM escolar_matriculas 
																	WHERE periodo_id = '$periodo->id'
																	AND pago = 'N'
																	"));
					
							//print_r($aluno); 
				
							/*---------------------*/
?>
                <tr onclick="location='?tela_id=230&periodo=<?=$periodo->id?>'" >
                	<td width="360"><?php echo $periodo->nome;?></td>                   
                	<td width="90"><?php echo $p_matricula->pm;?></td>                   
                	<td width="90"><?php echo $pr_matricula->pr;?></td>
                	<td width="90"><?php echo $total_p?></td>
                    <td width="90"><?php echo $pm_n->pm_n?></td>
                    <td>&nbsp;</td>
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
													AND tipo_matricula = 'MATR�CULA' 
													AND pago = 'S'
													"));
													
									$er_matricula = mysql_fetch_object(mysql_query($em="
												SELECT COUNT(*) as erm FROM escolar_matriculas 
													WHERE periodo_id = '$periodo->id' 
													AND escola_id    = '$escola->escola_id' 
													AND tipo_matricula = 'REMATR�CULA' 
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
                <tr <?php echo $cl; ?> onclick="location='?tela_id=230&periodo=<?=$periodo->id?>&escola=<?=$escola->escola_id?>'">
                	<td width="360"><blockquote><?php echo $escola->nome;?></blockquote></td>                   
                	<td width="90"><?php echo $e_matricula->em;?></td>                   
                	<td width="90" ><?php echo $er_matricula->erm?></td>
                	<td width="90"><?php echo $total_e?></td>
                    <td width="90"><?php echo $em_nao->em_nao?></td>
                    <td>&nbsp;</td>
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
													AND tipo_matricula = 'MATR�CULA'
													AND pago = 'S'
													"));
											$cr_matricula = mysql_fetch_object(mysql_query("
												SELECT COUNT(*) as crm FROM escolar_matriculas 
													WHERE periodo_id = '$periodo->id' 
													AND escola_id    = '$escola->escola_id' 
													AND curso_id     = '$curso->curso_id'
													AND tipo_matricula = 'REMATR�CULA'
													AND pago = 'S'
																										

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
                <tr <?php echo $cl; ?> onclick="location='?tela_id=230&periodo=<?=$periodo->id?>&escola=<?=$escola->escola_id?>&curso=<?=$curso->curso_id?>'"  >
                	<td width="360" ><blockquote><blockquote><strong><?php echo $curso->nome; ?></strong></blockquote></blockquote></td>                   
                	<td width="90"><?php echo $c_matricula->cm?></td>                   
                	<td width="90" ><?php echo $cr_matricula->crm?></td>
                    <td width="90"><?php echo $total_c?></td>
                    <td width="90"><?php echo $cm_n->cm_n?></td>
                	<td >&nbsp;</td>
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
													AND tipo_matricula = 'MATR�CULA'
													AND pago = 'S'
													"));
													
													$mr_matricula = mysql_fetch_object(mysql_query("
												SELECT COUNT(*) as mrm FROM escolar_matriculas 
													WHERE periodo_id = '$periodo->id' 
													AND escola_id    = '$escola->escola_id' 
													AND curso_id     = '$curso->curso_id'
													AND modulo_id    = '$modulos->modulo_id'
													AND tipo_matricula = 'REMATR�CULA'
													AND pago = 'S'
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
                <tr <?php echo $cl; ?> onclick="location='?tela_id=230&periodo=<?=$periodo->id?>&escola=<?=$escola->escola_id?>&curso=<?=$curso->curso_id?>&modulo=<?=$modulos->modulo_id?>'" >
                	<td width="360"  ><blockquote><blockquote><blockquote><strong><?php echo $modulos->nome; ?></strong></blockquote></blockquote></blockquote></td>                   
                	<td width="90"><?php echo $m_matricula->mm?></td>                   
                	<td width="90"><?php echo $mr_matricula->mrm?></td>
                	<td width="90"><?php echo $total_m?></td>
                    <td width="90"><?php echo $mm_n->mm_n?></td>
                    <td>&nbsp;</td>
               	</tr>

<?												
														$s_horario = mq($t=" SELECT * FROM escolar_horarios WHERE modulo_id = '$modulos->modulo_id' AND periodo_id='$periodo->id' AND curso_id='$curso->curso_id' AND escola_id='$escola->escola_id' AND   vkt_id='$vkt_id' ");
															//echo $t;
														while($horarios=mf($s_horario)){
															$h_matricula = mysql_fetch_object(mysql_query("
																	SELECT COUNT(*) as hm FROM escolar_matriculas as m
																		WHERE m.horario_id   = '$horarios->id'
																		AND m.tipo_matricula = 'MATR�CULA'
																		AND m.pago = 'S'
																		
																		AND m.periodo_id = '$horarios->periodo_id'
															"));
															
															$hr_matricula = mysql_fetch_object(mysql_query("
																	SELECT COUNT(*) as hm FROM escolar_matriculas as m
																		WHERE 
																		 m.horario_id   = '$horarios->id'
																		AND m.tipo_matricula = 'REMATR�CULA'
																		AND m.pago = 'S'
																		
																		AND m.periodo_id = '$horarios->periodo_id'

															"));
															$total_h = $h_matricula->hm + $hr_matricula->hm;
															$hm_n = mysql_fetch_object(mysql_query("
																	SELECT COUNT(*) as hm FROM escolar_matriculas as m
																		WHERE 
																		 m.horario_id   = '$horarios->id'
																		AND m.pago = 'N'
															"));

?>
                <tr onclick="location='?tela_id=230&periodo=<?=$periodo->id?>&escola=<?=$escola->escola_id?>&curso=<?=$curso->curso_id?>&modulo=<?=$modulos->modulo_id?>&horario=<?=$horarios->id?>'">
                	<td width="360"  ><blockquote><blockquote><blockquote><blockquote><?php 
					 if(strlen($horarios->nome)>0){
						 echo $horarios->nome; 
					 }else{
					 	echo converte_numeros_comvirgula_em_dias_semanas($horarios->dias_semana ,$semana_abreviado)." ".substr($horarios->horario_inicio,0,5)." �s ".substr($horarios->horario_fim ,0,5); 
					 }
					?></blockquote></blockquote></blockquote></blockquote></td>                   
                	<td width="90"><?php echo $h_matricula->hm;?></td>                   
                	<td width="90"><?php echo $hr_matricula->hm;?></td>
                	<td width="90"><?php echo $total_h?></td>
                    <td width="90"><?php echo $hm_n->hm?></td>
                    <td></td>
               	</tr>

				<?
						if(!empty($_GET['de'])&&!empty($_GET['ate'])){
							$filtro_i = "AND idade_minima='".$_GET['de']."' AND idade_maxima='".$_GET['ate']."'";
						}
							$s_salas = mysql_query($t="SELECT * FROM escolar_salas 
							WHERE horario_id='$horarios->id' $filtro_i AND  vkt_id='$vkt_id' ");
							
							
							
							while($sala=mysql_fetch_object($s_salas)){
									$s_matricula = mysql_fetch_object(mysql_query($sm="
																	SELECT COUNT(*) as sm FROM escolar_matriculas as m
																		
																		WHERE 
																		 m.sala_id        = '$sala->id'
																		AND m.tipo_matricula = 'MATR�CULA'
																		AND m.pago = 'S'
																		
																		AND m.periodo_id = '$periodo->id'
																		AND m.horario_id = '$horarios->id'
															"));
										//echo $sm;
									$sr_matricula = mysql_fetch_object(mysql_query($sm="
																	SELECT COUNT(*) as sm FROM escolar_matriculas as m
																		
																		WHERE 
																		 m.sala_id        = '$sala->id'
																		AND m.tipo_matricula = 'REMATR�CULA'
																		AND m.pago = 'S'
																		
																		AND m.periodo_id = '$periodo->id'
																		AND m.horario_id = '$horarios->id'
															"));
															
									$total_s = $s_matricula->sm + $sr_matricula->sm;
									
									$sm_n = mysql_fetch_object(mysql_query($sm="
																	SELECT COUNT(*) as sm FROM escolar_matriculas as m
																		
																		WHERE 
																		 m.sala_id        = '$sala->id'
																		AND m.pago = 'N'
															"));
				?>
                 <tr onclick="location='?tela_id=230&sala=<?=$sala->id?>&horario=<?=$horarios->id?>'">
                	<td width="360"><blockquote><blockquote><blockquote><blockquote><blockquote><?php echo $sala->nome." "; ?></blockquote></blockquote></blockquote></blockquote></blockquote></td>
                    <td width="90"><?php echo $s_matricula->sm;?></td>                   
                	<td width="90"><?php echo $sr_matricula->sm; ?></td>
                    <td width="90"><?php echo $total_s; ?></td>
                	<td width="90"><?php echo $sm_n->sm?></td>
                    <td></td>                   
               	</tr>
                
				<?						
							} /*fecha while sala*/
													} /* fecha while hor�rio */
											}/* fecha while m�dulos */
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
               <td width="100%">&nbsp;</td>
            </tr>
        </thead>
    </table>
    <script>
    $("tr:odd").addClass('al');
    </script>
</div>

<!--
    ///////////////////////////////////////
    Rodap�
    ///////////////////////////////////////
-->
<div id="rodape">

	
    
</div>