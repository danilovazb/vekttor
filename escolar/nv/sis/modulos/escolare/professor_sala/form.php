<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div style="width:710px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Salas</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
			
		<fieldset>
        	<legend><?=$sala->nome?></legend>
			<label>
            <strong>Escola: </strong><?php echo $sala->escola?>
                     
         	</label>
            <label style=" margin-right:23px; margin-left:">
				<strong>Curso: </strong><?php echo $sala->curso?>
			</label>
            <div style="clear:both"></div>
            <?
            	$modulo=mysql_fetch_object(mysql_query($t="SELECT * FROM escolar_modulos
														WHERE id=$sala->modulo_id"));
				//echo $t."<br>";
			?>
             <label style="margin-right:23px; margin-left:">
				<strong>Módulo: </strong><?php echo $modulo->nome?>
			</label>
             <label style="margin-right:23px; margin-left:">
				<strong>Horário: </strong><?php echo $sala->horario?>
			</label>
            <div style="clear:both"></div>
              <div style="width:500px; margin-right:23px;">
                  <table cellpadding="0" cellspacing="0" width="400">
                		<thead>
    						<tr>
                               <td width="200">Mat&eacute;ria</td>
                               <td width="150">Professor</td>
                               <td width="200">Aulas</td>
                               <td></td>
                             </tr>
                         </thead>
                
                         <tbody>
                    <?
					
					if(@mysql_result(mq("SELECT count(*) FROM escolar_materias WHERE modulo_id='$sala->modulo_id' AND  vkt_id='$vkt_id'"),0,0)==0){
						$q = "SELECT 1=1";	
					}else{
						$q="SELECT * FROM escolar_materias WHERE modulo_id='$sala->modulo_id' AND vkt_id='$vkt_id'"	;
					}
					$q= mq($q);
                    $c=0;
					while($m=mf($q)){
						$x++;
						echo "<tr>";
						echo "<td width=\"200\">";
						if(!empty($m->nome)){
							echo $m->nome;
					?>
                    <input type="hidden"  name="materia_id[]" id="materia_id<?=$c?>" value="<?=$m->id?>"/> 
                    <?
                   		echo "</td>";
						echo "<td width=\"150\">";
						$sal_mat_pro = @mysql_fetch_object(mysql_query(
							$t="SELECT *,esp.id as esp_id, p.id as p_id FROM escolar_sala_materia_professor esp																		                            INNER JOIN escolar_professor p ON esp.professor_id=p.id
							INNER JOIN cliente_fornecedor cf ON p.cliente_fornecedor_id=cf.id
							WHERE esp.sala_id=$sala->sala AND esp.materia_id=$m->id"
						));
						
					?>
                    <input style="width:250px;" type="text"  name="professor[]" 
                    id="professor<?=$c?>" value="<?=$sal_mat_pro->nome_contato?>" busca='modulos/escolar/professor_sala/busca_professor.php,@r0,@r0-value>professor<?=$c?>|@r1-value>professor_id<?=$c?>' autocomplete="off"/>
                      <input style="width:250px;" type="hidden" id="professor_id<?=$c?>" name="professor_id[]" value="<?=$sal_mat_pro->p_id?>"/>  
                     
                     
                     </label>
                     <input type="hidden" name="id[]" id="id<?=$c?>" value="<?=$sal_mat_pro->esp_id?>" />
                     
                     <div style="clear:both"></div>
                     <?
						
					 	echo "</td>";
						echo "<td width=\"75\"><input type='text' value='$sal_mat_pro->limite_aula' style=\"width:50px;\" name='limite_aula[]' sonumero='1'/></td>";
						echo "<td width=\"75\"> <img src='../fontes/img/menos.png' width='18' height='18' id='$c' onclick='limpaCampo($c);'/></td>";
						echo "</tr>";
						$c++;
						}
                     }
					
					 ?>
                     <input type="hidden" name="sala_id" id="sala_id" value="<?=$sala->sala?>" />
                
                    </tbody>
                </table>
                </div>
            
          
  </label>
		<div style="clear:both"></div>
			
            
		</fieldset>
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	
	<input name="action" type="submit"  value="Salvar" style="float:right;"  />
    
	
    <div style="clear:both"></div>
	</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>