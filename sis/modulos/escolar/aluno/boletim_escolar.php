<?php
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_function.php");
include("_ctrl.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Boletim Escolar</title>
<style>
.titulo_boletim{
	font-family:Verdana, Geneva, sans-serif;
	font-size:40px;
	margin-left:80px;	
}
td{padding:4px; padding-left:3px;}
td div{ border-bottom:1px solid #000;}
.cabecalho{background-color:#999999;}
.notas{
	border-collapse: collapse;
	border:#000;
}
.notas tr td{
	border:1px solid #000;
	font-size:10px;
	font-weight:bold;	
}
#box{
	border:solid 1px;
	height:110px;
	width:200px;
	float:right;
	margin-right:70px; 
    -moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	background-color:#CCCCCC;
	padding-left:20px;
	padding-top:20px;
	font-family:Verdana, Geneva, sans-serif;
	font-size:10px;
	font-weight:bold;
}
</style>
</head>

<body>
<div >
<?php
	foreach($alunos as $al){
		$aluno=selecionaAluno($al,$_GET['curso'],$_GET[periodo],$_GET[escola],$_GET[modulo],$_GET[horario]);
		$notas=selecionanota($al);
		
		if(mysql_num_rows($notas)>0){
			
?>
	<br>
	<div style="margin:0px auto;width:1000px;border-style:solid;" >
    				<div class="titulo_boletim" style="margin-left:200px;">
                    	<img src="marca-vekttor.png" alt="50%"/>
                    		<font face="Verdana, Geneva, sans-serif">Boletim Escolar</font>
                    </div>
                    <br>
                    <div style="width:900px">
                    	<table style="width:100%;text-align:left">
                        	<thead>
                            	<tr>
                            		<td width="595">Escola:<div style="float:right; width:540px;"><?=$aluno->escola?></div></td>
                                    <td>Ano Letivo:<div style="float:right; width:200px;"><?=$aluno->periodo?></div></td>
                                 </tr>
                            </thead>
                        </table>
                        <table style="width:100%;text-align:left">
                        	<thead>
                            	<tr>
                            		<td width="300">Aluno:<div style="float:right; width:280px;"><?=$aluno->aluno?></div></td>
                                    <td width="145">M�dulo:<div style="float:right; width:100px;"><?=$aluno->modulo?></div></td>
                                    <td width="195">Turma:<div style="float:right; width:165px;"><?=$aluno->sala?></div></td>
                                    <td width="145">Turno:<div style="float:right; width:115px;"><?=$aluno->horario?></div></td>
                                 </tr>
                            </thead>
                        </table>
                    </div>
                    
                    <div style="width:950px;height:250px;" align="center">
                    	<table class="notas" style="width:100%;">
                        	<tr align="center" class="cabecalho">
                            	<td rowspan="2" width="150">Disciplinas</td>
                                <?php
									
									//armazena os per�odos normais
									$periodos=array();
									$cont_p=0;
									
									//armazena os per�odos de recuperacao
									$periodos_r=array();
									$cont_r=0;
								
									//armazena as sala_materia_professor_id
									$sala_mat_pro=array();
									$cont_d=0;
																		
									while($nota=mysql_fetch_object($notas)){
										
										if(!in_array($nota->periodicidade_id,$periodos)&&$nota->recuperacao==0){
											$periodos[$cont_p]=$nota->periodicidade_id;
											$cont_p++;
										}
										
										if(!in_array($nota->periodicidade_id,$periodos_r)&&$nota->recuperacao==1){
											$periodos_r[$cont_r]=$nota->periodicidade_id;
											$cont_r++;
										}
																				
										if(!in_array($nota->sala_materia_professor_id,$sala_mat_pro)){
											$sala_mat_pro[$cont_d]=$nota->sala_materia_professor_id;
											$cont_d++;
										}
										
									}
									
									//escreve o nome dos per�odos normais
									foreach($periodos as $periodo){
										
										$p = mysql_fetch_object(mysql_query("SELECT * FROM escolar_periodicidade_avaliacao WHERE id=$periodo AND vkt_id='$vkt_id'"));
								   		
										echo "<td colspan='3' width='100'>$p->nome</td>";	
									}
								?>
                                <td colspan="3" width="100">M�DIA ANUAL</td>
                                
                                <?php
									//escreve o nome dos per�odos de recupera��o
									foreach($periodos_r as $periodo_r){
										
										$p = mysql_fetch_object(mysql_query("SELECT * FROM escolar_periodicidade_avaliacao WHERE id=$periodo_r AND vkt_id='$vkt_id'"));
								   		
										echo "<td colspan='1' width='100'> $p->nome </td>";
											
									}
									
									//exibe coluna daso haja per�odo de recupera��o
									if(!empty($periodos_r)){
										
										echo "<td colspan='1' width='100'>M�DIA FINAL</td>";
										
									}									
								?>
                                
                                <td>RESULTADO FINAL</td>
                                                                
                            </tr>
                            
                            <tr align="center">
                            <?php
                                //subcabecalho para periodos normais
								foreach($periodos as $periodo){
									echo "<td>M�dia</td>
                                			<td>N&deg; Faltas</td>
                                			<td>%Faltas</td>";
								}
								
								
								echo "<td>M�dia</td>
                                	<td>N&deg; Faltas</td>
                                	<td>%Faltas</td>";
								
								//subcabecalho para periodo de recupera��o
								foreach($periodos_r as $periodo_r){
									echo "<td>M�dia</td>";

								}//$periodos_r

								//exibe coluna daso haja per�odo de recupera��o
								if(!empty($periodos_r)){
									echo "<td>M�dia</td>";
								}	
								
								echo "<td>SITUA��O</td>
							    </tr>";
								//---------------------------------------------												
								
								foreach($sala_mat_pro as $materia){
								
									//Seleciona as mat�rias
									$mat=mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_materias em
																	INNER JOIN escolar_sala_materia_professor esp ON em.id=esp.materia_id
																	WHERE esp.id=$materia AND em.vkt_id='$vkt_id'"));
									echo "<tr height='30' align='center'>
                            				<td>$mat->nome</td>										
		                                  ";
										  
									//soma todas as m�dias
									$soma_medias=0;
									//soma a quantidade de m�dias
									$qtd_media=0;
									//soma tadas as faltas
									$soma_faltas=0;
									//somas todas as aulas
									$soma_aulas=0;				
									
									foreach($periodos as $periodo){
										//seleciona as notas de acordo com per�odo e mat�ria
										$nota=mysql_fetch_object(mysql_query($t="SELECT COUNT(en.nota) as qtd,SUM(en.nota) as nota FROM escolar_notas en
															INNER JOIN escolar_avaliacao ea ON en.avaliacao_id=ea.id
															WHERE ea.periodicidade_id=$periodo 
															AND ea.sala_materia_professor_id=$materia
															AND en.matricula_aluno_id=$aluno->idaluno
															AND en.vkt_id='$vkt_id'"));
										
										if($nota->qtd>0){
											echo "<td>".moedaUsaToBr($nota->nota/$nota->qtd)."</td>";
											$soma_medias+=$nota->nota/$nota->qtd;
											$qtd_media+=1;	
										}else{
											echo "<td>0</td>";
										}//$nota->qtd
										
										
										
										//seleciona a quantidade de aulas de acordo com per�odo e mat�ria
										$aulas = mysql_query($t="SELECT * FROM escolar_aula
																WHERE periodicidade_id=$periodo
																AND sala_materia_professor_id=$materia
																AND vkt_id='$vkt_id'
															");
										//echo $t."<br>";											
										//conta a quantidade e aulas e a quantidade de faltas do aluno
										$cont_aula=0;
										$cont_falta=0;
										while($aula=mysql_fetch_object($aulas)){
											//seleciona a presenca do aluno na aula
											$presenca = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_frequencia_aula WHERE aula_id=$aula->id
																	AND matricula_aluno_id=$aluno->idaluno
																	"));
											//echo $t."<br>";
											if($presenca->presenca==0){
												$cont_falta++;
											}//$presenca->presenca
											$cont_aula++;
										}
										$soma_aulas+=$cont_aula;
										$soma_faltas+=$cont_falta;
										
										//exibe quantidade de faltas
										echo "<td>".$cont_falta."</td>";
										
										//exibe porcentagem de faltas
										
										if($cont_aula!=0){
											echo "<td>".($cont_falta*100)/$cont_aula."</td>";
										}else{
											echo "<td>0</td>";
										}//$cont_aula
									}//$periodos
									
									
									$media_final = $soma_medias/$qtd_media;
									
									if($soma_aulas!=0){
										$media_faltas = ($soma_faltas*100)/$soma_aulas;
										
									}//$soma_aulas
									
									
									echo "<td>".moedaUsaToBr($media_final)."</td>";
									echo "<td>".$soma_faltas."</td>";
									echo "<td>".moedaUsaToBr($media_faltas)."</td>";
									
									//la�o para periodos de recuperacao
									foreach($periodos_r as $periodo_r){
										//seleciona as notas de recupera��o  deacordo com per�odo e mat�ria
										$nota_r=mysql_fetch_object(mysql_query($t="SELECT COUNT(en.nota) as qtd,SUM(en.nota) as nota FROM escolar_notas en
															INNER JOIN escolar_avaliacao ea ON en.avaliacao_id=ea.id
															WHERE ea.periodicidade_id=$periodo_r 
															AND ea.sala_materia_professor_id=$materia
															AND en.matricula_aluno_id=$aluno->idaluno
															AND en.vkt_id='$vkt_id'"));
										
										if(isset($nota_r->nota)){
											echo "<td>".moedaUsaToBr($nota_r->nota)."</td>";
											$media_final=($media_final+$nota_r->nota)/2;	
										}else{
											echo "<td>-</td>";
										}//$nota_r->nota
										
										echo "<td>".moedaUsaToBr($media_final)."</td>";
										
									}//$periodos									
									
									
									//seleciona a m�dia da escola
									$escola = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_escolas WHERE id=$aluno->escola_id AND vkt_id='$vkt_id'"));
									//seleciona a porcentagem de cursos
									$curso = mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_cursos WHERE id=$aluno->curso_id AND vkt_id='$vkt_id'"));
									
									if($media_final>=$escola->media&&$media_faltas<=$curso->perc_faltas){
										$situacao = "Aprovado";
									}else if($media_final<=$escola->media){
										$situacao = "Reprovado por nota";
									}else{
										$situacao = "Reprovado por falta";
									}//$media_final
																	
									echo "<td>$situacao</td>";
									echo "</tr>";
									
								}//$sala_mat_pro
								
								
							?>
                                            			
                        </table>
                    </div>
                    <!--<div style="width:1050px;">
                    	<table class="notas" width="700" style="float:left">
                        	<tr class="cabecalho">
                            	<td colspan="14" align="center">
                                	<font color="#FFFFFF">SISTEMA DE AVALIA�&Atilde;O</font>
                                </td>
                            </tr>
                            <tr align="center" class="cabecalho">
                            	<td colspan="3"><font color="#FFFFFF">1&deg; Bimestre</font></td>
                                <td colspan="3"><font color="#FFFFFF">2&deg; Bimestre</font></td>
                                <td colspan="3"><font color="#FFFFFF">3&deg; Bimestre</font></td>
                                <td colspan="3"><font color="#FFFFFF">4&deg; Bimestre</font></td>
                                                        
                            </tr>
                            <tr>
                            	<td width="10" align="center">Valor</td>
                                <td width="30"></td>
                                <td width="10" align="center">Pontua�&atilde;o M�nima</td>
                                <td width="10" align="center">Valor</td>
                                <td width="30"></td>
                                <td width="10" align="center">Pontua�&atilde;o M�nima</td>                       
                                <td width="10" align="center">Valor</td>
                                <td width="30"></td>
                                <td width="10" align="center">Pontua�&atilde;o M�nima</td>
                                <td width="10" align="center">Valor</td>
                                <td width="30"></td>
                                <td width="10" align="center">Pontua�&atilde;o M�nima</td>                                                            
                            </tr>
                           	<tr height="30">
                            	<td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>                       
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>                                                            
                            </tr>
                            
                        </table>
                        <div id="box">
                        	LEGENDA DO CAMPO SIT(SITUA�&Atilde;O)<br>
                            AP - APROVADO<br>
                            REP - REPROVADO<br>
                            RPP - REGIME DE PROGRESS&Atilde;O PARCIAL<br>
                            RPF - RECUPERA�&Atilde;O POR FALTA<br>
                            RF - RECUPERA�&Atilde;O FINAL<br>
                        </div>
                    </div>-->
    </div>
 <?php
		}//if(!empty($notas))
	}
 ?>
</div>
</body>
</html>
