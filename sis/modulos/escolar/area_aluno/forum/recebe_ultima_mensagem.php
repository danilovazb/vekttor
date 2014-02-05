<?php
include("../../../../_config.php");
$aluno_enviado = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_alunos WHERE id = '".$_SESSION['aluno']->id."' "));
			
			$acao = $_GET['acao'];
							
				
				if($acao == 'ultima'){
					global $vkt_id;
					$msg         = $_POST['msg'];
					$professor   = $_POST['professor'];
					$aluno       = $_POST['aluno'];
					$aula        = $_POST['aula'];
					$pergunta_id = $_POST['pergunta_id'];
					
					$data      = date('Y-m-d');
					$hora      = date('H:i:s');
			
			$sql_verifica = mysql_fetch_object(mysql_query($v=" SELECT * FROM escolar_forum 
																WHERE 
																	aula_id = '$aula' 
																AND 
																	status = '1' 
																AND 
																	vkt_id = '$vkt_id'	
																"));
			$pergunta = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_forum_pergunta WHERE id = '$sql_verifica->pergunta_id' AND vkt_id = '$vkt_id'"));
							if($sql_verifica->id > 0){
								
								mysql_query($cad=" INSERT INTO escolar_forum
												SET
													vkt_id       = '$vkt_id',
													aluno_id     = '$aluno',
													professor_id = '$professor',
													aula_id      = '$aula',      
													msg_id       = '".$sql_verifica->id."',
													pergunta_id  = '".$pergunta_id."',
													resposta     = '$msg',
													data_hora = '$data $hora',
													status = '2'");
									$ultimo_id = mysql_insert_id();
												
												if(empty($_SESSION['aluno']->id)){
													$professor_texto = " Professor ";
													$professor_forum = mysql_fetch_object(mysql_query($y="SELECT * FROM 
																												cliente_fornecedor as cf, escolar_professor as p
																											WHERE 
																												cf.id=p.cliente_fornecedor_id 
																											AND 
																												p.id = '".$professor."' "));
													$nome = "<strong>Prof. </strong>".substr($professor_forum->razao_social,0,10);  
												}
												
											/****/
											
											if(!empty($_SESSION['aluno']->id)){
													$nome =  substr($aluno_enviado->nome,0,13);
											} 
											
											/****/
											if(!empty($aluno_enviado->id) and !empty($aluno_enviado->extensao)){
												$caminho_foto = "background:url(modulos/escolar/alunos_inscritos/img/".$aluno_enviado->id.".".$aluno_enviado->extensao.") 50px; width:110px; height:140px; background-position:center;  box-shadow:1px 1px 1px #666;";
												//$caminho_foto = "modulos/escolar/alunos_inscritos/img/".$aluno_enviado->id.".".$aluno_enviado->extensao;
											} else{
												$caminho_foto = "background:url(modulos/escolar/area_aluno/forum/img/perfil-null.jpg); width:110px; height:140px; background-position:45%;  box-shadow:1px 1px 1px #666;";
												//$caminho_foto = "modulos/escolar/area_aluno/forum/img/perfil-null.jpg";
											}
												
										echo '
											   <tr>
												  <td>
													<div style="padding:4px; float:left;"><strong>Postada em :</strong> '.date('d/m/Y').' - '.date('H:i:s').' 
														<strong>'.$professor_texto.'</strong>
													</div>
												  </td>
											   </tr>          
											  <tr  class="pergunta">
														   <td style="border:1px solid #CCC;">
															<div style="float:left; width:140px; height:160px; border-right:1px solid #CDCDCD; padding:8px; margin:8px;">
																<div>
																<img src="modulos/escolar/area_aluno/forum/img/status_online.png">
																'.$nome.'
																</div>
																 <div style="'.$caminho_foto.'">&nbsp;</div>
																 <div style="padding:2px; padding-left:10px; font-size:11px; margin-left:12px;" id="'.$ultimo_id.'" class="excluir">Excluir Post</div>
															</div>
															<div style="padding:5px; float:left;">
															   <div style="border-bottom:1px solid #CDCDCD; padding-bottom:5px;">
																<strong id="pergunta_feita">
																	RE: '.iconv("iso-8859-1","UTF-8",$pergunta->pergunta).' 
																</strong> 
																
															   </div>
															   <div id="resposta" style="font-size:12px; padding-bottom:2px; padding-top:8px;">
																- '.$msg.'
															   </div>
															</div>
															</td>
											   </tr>';
						
							} /*else{
				
										($cad=" INSERT INTO escolar_forum
										SET
											vkt_id       = '$vkt_id',
											aluno_id     = '$aluno',
											professor_id = '$professor',
											aula_id      = '$aula',
											msg_id       = '',
											pergunta     = '$msg',
											resposta     = '',
											data_hora    = '$data $hora',
											status = '1'" );
										echo $cad;	
											
										if(empty($_SESSION['aluno']->id)){
													$professor_texto = " Professor "; 
												}
												
											/****/
											/*if(!empty($sql_verifica->aluno_id)){
												$aluno = mysql_fetch_object(mysql_query($a=" SELECT * FROM escolar_alunos WHERE id = '".$sql_verifica->aluno_id."' "));
											} else{
												$professor_forum = mysql_fetch_object(mysql_query($y="SELECT * FROM cliente_fornecedor as cf, escolar_professor as p
																											WHERE 
																												cf.id=p.cliente_fornecedor_id 
																											AND 
																												p.id = '".$sql_verifica->professor_id."' ")); 
											} 
											/****/
											/*if(!empty($forum->aluno_id)){
													$nome =  substr($aluno->nome,0,10);
											} 
											else{
													$nome = "<strong>Prof. </strong>".substr($professor_forum->razao_social,0,10); 
											}*/
											/****/
										
										
										
										
										
										
										/*echo '
											   <tr>
												  <td>
															<div style="padding:4px; float:left;"><strong>Postada em :</strong> '.date('d/m/Y').' - '.date('H:i:s').' </div>
												  </td>
											   </tr>          
											  <tr id="pergunta">
														   <td style="border:1px solid #CCC;">
															<div style="float:left; width:140px; height:160px; border-right:1px solid #CDCDCD; padding:8px; margin:8px;">
																<div>
																	<img src="modulos/escolar/area_aluno/forum/img/status_online.png">
																	'.$aluno_enviado->nome.'
																</div>
																 <div style="padding-top:2px"></div>
																<div style="background:url(modulos/escolar/alunos_inscritos/img/'.$aluno_enviado->id.'.'.$aluno_enviado->extensao.') 50px; width:110px; height:140px; background-position:center;  box-shadow:1px 1px 1px #666;">&nbsp;
																</div>
															</div>
															<div style="padding:5px; float:left;">
															   <div style="border-bottom:1px solid #CDCDCD; padding-bottom:5px;">
																<strong id="pergunta_feita">
																	'.$msg.' 
																</strong> 
																
															   </div>
															   <div id="resposta" style="font-size:12px; padding-bottom:2px; padding-top:8px;">
																- 
															   </div>
															</div>
															</td>
											   </tr>';
							}*/
				} /* Fim de IF*/
				
				if($acao == 'excluir_post'){
					$id = $_POST['id'];
					$sql_del = " DELETE FROM escolar_forum WHERE id = '$id' AND vkt_id = '$vkt_id' ";
					mysql_query($sql_del);	
					
				}
				if($acao == 'excluir_pergunta'){
							$id = $_POST['id'];	
							
					$sql_forum = mysql_fetch_object(mysql_query(" SELECT * FROM escolar_forum WHERE id = '$id' AND vkt_id = '$vkt_id'"));
					mysql_query(" DELETE FROM escolar_forum_pergunta WHERE id = '$sql_forum->pergunta_id'");
					mysql_query(" DELETE FROM escolar_forum WHERE id = '$sql_forum->id'");
					mysql_query(" DELETE FROM escolar_forum WHERE msg_id = '$sql_forum->id' AND status = '2'");
				}
   ?>