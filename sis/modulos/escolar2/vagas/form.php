<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="exibe_formulario" class="exibe_formulario"  style="top:30px; left:50px;">
<style>
label#responsavel:hover{ cursor:crosshair;}
</style>
<div id='aSerCarregado'>
<div style="width:850px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' id="fecha_form"></a>
    
    <span>Salas</span></div>
</div>
	<form onsubmit="return validaForm(this)" class="form_float"  method="post" enctype="multipart/form-data">

		<input type="hidden" id="aluno_id" name="aluno_id" value="<?=$_GET['aluno_id']; ?>" />

		<fieldset>
          <legend>
            <a onclick="aba_form(this,0)"><strong>Salas da Escola</strong></a>
          </legend>
			
            <div style="float:left; width:775px;">
           	 <div style="text-align:center;">

			  <strong><?=$escola->nome?> - <?=$periodo_letivo->nome?></strong>

              </div>
              	<input type="hidden" name="periodo_letivo_id" id="periodo_letivo_id" value="<?=$periodo_letivo->nome?>" />
                <input type="hidden" name="periodo_letivo_id2" id="periodo_letivo_id2" value="<?=$periodo_letivo->id?>" />
                <input type="hidden" name="escola_id" id="escola_id" value="<?=$_GET['escola_id']?>" />
              <div style="clear:both;"></div>
              
              <div style="text-align:center;"><strong ><?=$ensino->nome?> - <?=$serie->nome?> - <?=$horario->nome?></strong></div>
			  
			<div style="clear:both; height:5px;"></div>
             <div>
            
                <div style="clear:both;"></div>
                <div id="div_salas">
                
                <table cellpadding="0" cellspacing="0" style="width:100%;border-left:1px solid #CCC;">
              		<thead> 
                        <tr style="border-left:1px solid #999;">
                            <td width="60">Sala</td>
                            <td width="90">Cap. Máxima</td>
                            <td width="100" title="Capacidade Pedagógica">Cap. Pedagógica</td>
                            <td width="110">Nome Turma</td>
                            <? if($escola->cobrar==1){ ?>
                            <td width="80">R$ Matricula</td>
                            <td width="100">R$ Mensalidade</td>
                            <? } ?>
                            <td width="30">Ação</td>
                            <td>Horários aula</td>
                        </tr>
              		</thead>
                    <tbody id="lista_serie"></tbody>
                    
                    <tbody>
                    <?php
			   			$cont = 1;
						$c=1;
						while($sala = mysql_fetch_object($salas)){
							$a="flafson";
							$sala_reservada = mysql_query(
							$t="SELECT 
								* 
							FROM 
								escolar2_turmas 
							WHERE 
								sala_id=$sala->id AND 
								unidade_id=$escola->id AND 
								horario_id='".$_GET['horario_id']."' AND
								periodo_letivo_id='".$_GET['periodo_letivo_id']."'");
								
							if(mysql_num_rows($sala_reservada)>0){
								$exibe_menos = "style='display:block'";
								$turma = mysql_fetch_object($sala_reservada);
								$exibe_mais = "style='display:none'";
								$class_turma="tem_turma";
							}else{
								$exibe_mais = "style='display:block'";
								$exibe_menos = "style='display:none'";
								$turma='';
								$class_turma="";
							}
							
							$total++;
							if($total%2){$sel='al';}else{$sel='';}
			   			?>
                        <tr style="background:#FFF;" id="<?=$serie->id?>" data-rel="<?=$turma->id?>" class="<?=$class_turma?> <?=$sel?>">
                        	<td><?=$sala->nome?></td>
                            <td><?=$sala->capacidade_maxima?></td>
                            <td><?=$sala->capacidade_pedagogica?></td>
                            <td>
                            <label style="margin-bottom:4px;" >
								<input style="height:10px; width:100px;" type='text' class="nome_turma" name='nome_turma' id='nome_turma<?=$c?>' value='<?=$turma->nome?>'>
							</label>
                            </td>
                            <? if($escola->cobrar==1){ ?>
                            <td>
                            	<label style="margin-bottom:4px;" >
									<input style="height:10px; width:60px;" type='text' class="valor_matricula" name='valor_matricula' id='valor_matricula<?=$c?>' value='<?=moedaUsaToBR($turma->valor_matricula)?>' decimal="2">
							</label>
                            </td>
                            <td>
                            <label style="margin-bottom:4px;" >
								<input style="height:10px; width:60px;" type='text' class="valor_mensalidade" name='valor_mensalidade' id='valor_mensalidade<?=$c?>' value='<?=moedaUsaToBR($turma->valor_mensalidade)?>' decimal="2">
							</label>
                            </td>
                            <? } ?>
                            <td width="30">
                            <img src='../fontes/img/mais.png' width='18' height='18' class='adicionar_sala' f_escola_id='<?=$escola->id?>' f_serie_id='<?=$serie->id?>' f_sala_id='<?=$sala->id?>' 
                            f_horario_id='<?=$_GET['horario_id']?>' f_periodo_letivo_id='<?=$periodo_letivo->id?>' f_turma='<?=$c?>' <?=$exibe_mais?> />
                            <img src='../fontes/img/menos.png' width='18' height='18' class='retirar_sala' id="<?=$turma->id?>" <?=$exibe_menos?> />
                            </td>
                            <td>
                            	<input <?=$exibe_menos?> class="botao_cadastrar_turma" type="button" onclick="location.href='?tela_id=474&turma_id=<?=$turma->id?>'" value="cadastrar" />
                            	<span <?=$exibe_mais?> class="msg_cadastre_turma">Cadastre a turma</span>
                            </td>
                        </tr>
                   <?php
					   $c++;
					}
					?>
                    </tbody>
                </table>
                </div>
                               
                
             </div><br>

             </label>
             <div style="clear:both;"></div>
            </div>
		</fieldset>
		<!-- --><!-- --><!-- -->
      <!-- --><!-- -->

   	  <div style="width:100%; text-align:center" >
      <div style="clear:both"></div>
      </div>
    </form>
</div>
</div>
</div>
<script>top.openForm()</script>