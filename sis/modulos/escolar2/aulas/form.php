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
<div style="width:500px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    <span>Gerenciamento - Aula</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
    <input type="hidden" name="id" value="<?=$id?>">
    <input type="hidden" name="exibe" id="exibe" value="<?=$exibe?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
		<fieldset  id='campos_2'>
			<legend>
            	<a onclick="aba_form(this,0)"><strong>Aula - Informa&ccedil;&otilde;es Gerais</strong></a>
                <a onclick="aba_form(this,1)">Ocorrências</a>
            </legend>
            
			<label>Status
            	<select name="status" id="status"  >
                	<option <? if($consulta->status == 1){echo 'selected="selected"';}?> value="1">Abrir</option>
                    <option <? if($consulta->status == 2){echo 'selected="selected"';}?> value="2">Finalizada</option>
                </select>
            </label>  
            <label style="width:75px;">Data Aula<br/>
            	<input type="text" name="dta_aula" id="dta_aula" value="<?=dataUsaToBr($consulta->data);?>" disabled="disabled">
            </label>         
           <div style="clear:both;"></div>
            
            <label>Turma<br/>
            	<input type="text" name="turma" style="width:183px;" value="<?=$turma->turma?>" disabled="disabled">
            </label>
            <label>Mat&eacute;ria<br/>
            	<input type="text" name="materia" style="width:183px;" value="<?=$result2->nome_materia?>" disabled="disabled">
            </label>
            <div style="clear:both;"></div>
            <label >Professor<br/>
            	<input type="text" name="professor" disabled="disabled" style="width:183px;" value="<?=$result3->nome_professor?>">
            </label>
            <label style="width:140px;">S&eacute;rie<br/>
            	<input type="text" name="curso" style="width:183px;" disabled="disabled"  value="<?=$serie->nome?>">
            </label>
            <div style="clear:both;"></div>
            <label style="width:388px;">Escola<br/>
            	<input type="text" name="escola" value="<?=$unidade->nome?>" disabled="disabled">
            </label>
            <div style="clear:both;"></div>
            <label>Descri&ccedil;&atilde;o<br/>
            	<textarea name="descricao" disabled="disabled"><?=$consulta->descricao?></textarea>
            </label>
           
            <label>Observa&ccedil;&atilde;o<br/>
            	<textarea name="observacao" id="observacao" disabled="disabled"><?=$turma->observacao?></textarea>
            </label>
            <div style="clear:both;"></div>
             <label style="width:345px;">Texto da Aula<br/>
            	<textarea name="texto_aula" cols="60" rows="5" disabled="disabled"><?=$turma->texto_aula?></textarea>
            </label>
        </fieldset>
        
        <fieldset  id='campos_2' style="display:none">
			<legend>
            	<a onclick="aba_form(this,0)">Aula - Informa&ccedil;&otilde;es Gerais</a>
                <a onclick="aba_form(this,1)"><strong>Ocorrências</strong></a>
            </legend>
            
			<table cellpadding="0" cellspacing="0" width="100%">
    			<thead>
    	 		<tr>
               <td width="50%">Aluno</td>
               <td width="50%">Ocorrências</td>
               <!--<td width="70">Per&iacute;odo</td>-->
               
         		</tr>
                </thead>
                <tbody>
                	
                	<?php
						$sql_ocorrencias = mysql_query("
						SELECT 
							*, eobs.observacao as obs_ocorrencia 
						FROM 
							escolar2_obs_aluno_aula eobs,
							escolar2_matriculas ema,
							escolar2_alunos ea
						WHERE 
							eobs.matricula_aluno_id = ema.id AND
							ema.aluno_id            = ea.id AND
							eobs.aula_id='$id'");echo mysql_error();
						$qtd_ocorrencias=0;
						while($ocorrencia = mysql_fetch_object($sql_ocorrencias)){
							if($qtd_ocorrencias%2==0){
								$color="#F1F5FA";
							}else{
								$color="#FFFFFF";
							}
							
					?>
               		<tr>
                    	<td width="50%" style="background-color:<?=$color?>" class="coluna_ocorrencia"><?=$ocorrencia->nome?></td>
                    	<td width="50%" style="background-color:<?=$color?>" class="coluna_ocorrencia"><?=$ocorrencia->obs_ocorrencia?></td>
                    </tr> 	
                    <?php
							$qtd_ocorrencias++;
							
						}
					?>
                </tbody>
                <thead>
    	 		<tr>
               <td colspan="2">Total de Ocorrencias: <?=$qtd_ocorrencias?></td>
               <!--<td width="70">Per&iacute;odo</td>-->
               
         		</tr>
    			</thead>
			</table>
        </fieldset>
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($bolsista->aluno_id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
	<?
	}
	?>
	<input name="action" type="submit"  value="Salvar" style="float:right"  />
	<div style="clear:both"></div>
	</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>