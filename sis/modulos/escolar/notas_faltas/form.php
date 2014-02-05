<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 
$curso = mysql_fetch_object(mysql_query("SELECT *, ec.nome as curso FROM escolar_cursos ec,
											escolar_salas es
										 WHERE 
										 	ec.id=es.curso_id AND
											es.horario_id = '".$_GET['horario_id']."'
											"));
$modulo = mysql_fetch_object(mysql_query("SELECT *,em.nome as modulo FROM escolar_modulos em,
											escolar_salas es
										 WHERE 
										 	em.id=es.modulo_id AND
											es.horario_id = '".$_GET['horario_id']."'
											"));
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:630px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Equipamentos</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" autocomplete='off'>
    <input type="hidden" name="id" id="id" value="<?=$equipamento->equipamento_id?>">
    
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
		 <legend>
            <a onclick="aba_form(this,0)"><strong>NOTAS</strong></a>
            <a onclick="aba_form(this,1)">FALTAS</a>
                		
         </legend>
         <?
		 	echo "<strong>Curso:</strong> ".$curso->curso."<br> <strong>Módulo:</strong> ".$modulo->modulo;
			$avaliacoes = mysql_query("SELECT 
															*, ea.id as av_id 
														FROM 
															escolar_avaliacao ea,
															escolar_sala_materia_professor smp,
															escolar_salas es
														WHERE
															ea.sala_materia_professor_id=smp.id AND
															smp.sala_id=es.id AND
															es.horario_id='".$_GET['horario_id']."' AND
															ea.vkt_id = '$vkt_id' 
															ORDER BY ea.id
													");
           	//echo $t;
		   ?>
		    
            <table cellpadding="0" cellspacing="0" width="100%" >
                 <thead>
                        <tr>
                          <td width="250">DESCRIÇAO DA AVALIAÇAO</td>
                          <td width="70">DATA</td>
                          <td width="70">NOTA</td>
                          
                          <td></td>                          
                        </tr>
               </thead>
			</table>
            <div style="height:150px;overflow:auto">
			<table cellpadding="0" cellspacing="0" width="100%" height="10%">
                <tbody id="tbody">
                	<?
						while($av = mysql_fetch_object($avaliacoes)){
							$nota_aluno = mysql_fetch_object(mysql_query($t="SELECT * FROM 
																			escolar_notas en,
																			escolar_avaliacao ava 
																		WHERE 
																			en.avaliacao_id=ava.id AND
																			ava.id=$av->av_id AND
																			en.matricula_aluno_id='".$_GET['aluno_id']."' AND
																			en.vkt_id = '$vkt_id'
																			
							"));
							//echo $t;
					?>
                    	<tr>
                    	<td width="250"><?=$av->descricao?></td>
						<td width="70"><?=DataUsaToBr($av->data)?></td>
                        <td width="70"><? if(!empty($nota_aluno)){ echo moedaUsaToBr($nota_aluno->nota);}else{ echo "0,00";}?></td>
                        <td></td>
                        </tr>
					<?
						}
					?>
                </tbody>
             </table>
             </div>
             <div id="excluir_item_produto"></div>
                        
            <table cellpadding="0" cellspacing="0" width="100%" >
            		<thead>
            			<tr>
							  <td width="250"></td>
							  <td width="70"><?=$total_qtd?></td>
                              <td width="70"><?=moedaUsaToBr($total_valor_aluguel_equipamento)?></td>
                              <td width="70"><?=moedaUsaToBr($total_locacao)?></td>
							  <td></td>
						</tr>
                      </thead> 
              </table>
       </fieldset>
		<fieldset style="display:none;">
		
            
            <legend>
            <a onclick="aba_form(this,0)">NOTAS</a>
            <a onclick="aba_form(this,1)"><strong>FALTAS</strong></a>
                		
         
         </legend>
    		
        
	
            <table cellpadding="0" cellspacing="0" width="100%" >
                 <thead>
                        <tr>
                          <td width="250">DESCRICAO AULA</td>
                          <td width="70">DATA</td>
                                                   
                          <td></td>                          
                        </tr>
               </thead>
			</table>
            			                        
            <table cellpadding="0" cellspacing="0" width="100%" >
            		<?php
						$faltas = mysql_query($t="SELECT * 
														FROM 
															escolar_frequencia_aula efa,
															escolar_aula ea,
															escolar_matriculas em,
															escolar_sala_materia_professor smp,
															escolar_salas es
														WHERE 
															efa.matricula_aluno_id = em.aluno_id AND
															efa.aula_id = ea.id AND
															ea.sala_materia_professor_id = smp.id AND
															smp.sala_id = es.id AND 
															efa.matricula_aluno_id='".$_GET['aluno_id']."' AND
															es.horario_id='".$_GET['horario_id']."' AND
															em.id='".$_GET['mat_id']."'
															AND presenca='0'");
						//echo $t;
					?>
                    <tbody id="tbody">
                    <?
            			while($a = mysql_fetch_object($faltas)){
                     		
						
					 ?>
                        <tr>
							  <td width="250"><?=$a->descricao?></td>
							  <td width="70"><?=DataUsaToBr($a->data)?></td>
                               
                              <td></td>
						</tr>
                      </tbody>
                   <?php
						}
						
				   ?> 
              </table>
              <table cellpadding="0" cellspacing="0" width="100%" >
            		<thead>
            			<tr>
							  <td width="250"></td>
							  <td width="70"></td>
                              <td width="70"><?=$total_item?></td>
                              <td width="70"><?=moedaUsaToBr($vlr_total_custo)?></td>                              
							  <td></td>
						</tr>
                      </thead> 
              </table>
       </fieldset>
       
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<input value="Fechar" type="button" style="float:right"/>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>