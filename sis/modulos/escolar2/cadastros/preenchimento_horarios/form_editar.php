<?
//Includes
include("../../../../_config.php");
include("../../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>

<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Cadastrar Professor</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<fieldset  id='campos_1' >
		<label>
            Professor<br />
            <?=$professor->nome?>
        </label>
        <label>
        
        	Matéria
            <select name="serie_has_materia_id">
            <?
            $materia_q=mysql_query("SELECT esm.id as id, em.nome as nome FROM escolar2_serie_has_materias as esm, escolar2_materias as em WHERE esm.vkt_id='$vkt_id' AND esm.serie_id='{$turma->serie_id}' AND em.id = esm.materia_id ORDER BY em.nome ASC"); 
			while($materia=mysql_fetch_object($materia_q)){
			?>
            	<option value="<?=$materia->id?>"><?=$materia->nome?></option>
            <? } ?>
            </select>
        </label>
        <div style="clear:both;"></div>
		 <div>
         <? 
		 $dias_semana=array('Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo');
		 
		 ?>
         	<table cellpadding="0" cellspacing="0" style="width:100%;border-left:1px solid #CCC;">
            	<thead>
                	<tr style="border-left:1px solid #999;">
                    <td style="padding-left:3px; padding-right:3px;">Tempo</td>
                    <? for($i=0;$i<count($dias_semana); $i++){ ?>
                    	<td width="85"><?=$dias_semana[$i]?></td>
                   <? } ?>
                    </tr>
                </thead>
                <tbody>
                	<? 
					$x=0;
					for($i=0;$i<$turma->qtd_materias;$i++){

					if($i%2==0){$c="al";}else{$c="";}
					?>
                    	<tr style="background:white;" class=" <?=$c?> ">
                        <td><?=$i+1?>º</td>
                        	<? 
							for($y=1;$y<=count($dias_semana);$y++){ 
								if($y==7){$dia=0;}//se for domingo, atribui 0 pro banco
								if($y!=0 && $y!=7){$dia=$y;}
							?>
                        	<td>
                            	<?
                                if($materias_horarios_professor[$dia][$i]){
									?>
                                    ocupado
									<?
                                }else{
								?>
                            	<input name="horario_dia[]" type="checkbox" value="<?=$i?>_<?=$dia?>" />
                                <?
								}
								?>
                           </td>
                            <? 
							} ?>
                        </tr>
                	<? } ?>
                </tbody>
            </table>
         </div>
         <input type="hidden" name="horario_id" value="<?=$turma->horario_id?>" />
         <input type="hidden" name="turma_id" value="<?=$turma->turma_id?>" />
         <input type="hidden" name="professor_id" value="<?=$professor->id?>" />
            
	</fieldset>
    
    
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	
	<input name="id" type="hidden" value="<?=$cargo->id?>"/>
    <input name="action" type="submit"  value="Salvar" style="float:right"  />
	<div style="clear:both"></div>
	</div>
    
    
</form>
</div>
</div>
</div>
<script>top.openForm()</script>