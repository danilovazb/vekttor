<?
//Includes
// configuração inicial do sistema
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");

include("_functions.php");
include("_ctrl.php"); 
$disabled="";
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:495px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Aula</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
    <input type="hidden" name="professor_as_turma_id" value="<?=$_GET["professor_as_turma"];?>">
    <input type="hidden" name="unidade_id" value="<?=$_GET["unidade_id"];?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
		<legend>
            <a onclick="aba_form(this,0)"><strong>Aula</strong> </a>
    		<a onclick="aba_form(this,1)">Texto  </a>
            <!--<a onclick="aba_form(this,2)"> Alunos </a>-->
          </legend>
        <input type="hidden" name="id" id="id" value="<?=$r->id?>">
        <input type="hidden" name="sala_materia" value="<?=$_GET['sala_materia']?>">
		<label style="width:300px;">Descriç&atilde;o
		  <input type="text" id='descricao' name="descricao" value="<?=$r->descricao?>" autocomplete='off' maxlength="80"/>
		</label>
        <div style="clear:both;"></div>
        	<label style="width:300px;">OBS:<br/>
            	<textarea name="obs" id="obs" cols="39" rows="5"><?php echo $r->observacao;?></textarea>
            </label> 
        <div style="clear:both;"></div>
        <label style="width:75px;">
        	Data<br/>
            <input type="text" name="data_aula" id="data_aula"  mascara="__/__/____" value="<?php if($r->data){ echo dataUsaToBr($r->data);} else{ echo date('d/m/Y');}?>" calendario='1'>
        </label>
           <?php
           $sql_bimestre = mysql_query($ty=" SELECT * FROM escolar2_periodos_avaliacao WHERE vkt_id = '$vkt_id' AND unidade_id = '".$_GET["unidade_id"]."'  ORDER BY id");
						
		   ?>
           <label> Periodo <br/>
        	<select name="periodo_id" id="periodo_id">
            <option value="0"> Selecione período: </option>
            	<?
                		
							while($r_bimestre=mysql_fetch_object($sql_bimestre)){
							 if($r->periodicidade_id == $r_bimestre->id){$sel =  'selected="selected"';} else {$sel='';}
				?>
            	          <option <?=$sel?>  value="<?=$r_bimestre->id?>"><?=$r_bimestre->nome;?></option>
            	<?
							}
				?>
            </select>
        </label>
	</fieldset>
    
    <fieldset id="campos_2" style="display:none">
		 <legend>
            <a onclick="aba_form(this,0)"> Aula  </a>
    		<a onclick="aba_form(this,1)"><strong>Texto</strong> </a>
            <!--<a onclick="aba_form(this,2)"> Alunos </a>-->
          </legend>
          <label style="width:400px">Texto da Aula<br/>
          		<textarea name="texto_aula" id="texto_aula" cols="30" rows="8"><?=$r->texto_aula?></textarea>
          </label>
     </fieldset>
      <fieldset id="campos_3" style="display:none">
		 <legend>
            <a onclick="aba_form(this,0)"> Aula  </a>
    		<a onclick="aba_form(this,1)"> Texto </a>
            <!--<a onclick="aba_form(this,2)"><strong>Alunos</strong> </a>-->
          </legend>
          <!-- Lista de alunos -->
          <div>
            <table cellpadding="0" cellspacing="0" width="100%">
                <thead>
                    <tr>
                       <td width="250">Aluno</td>
                       <td width="150">Observação</td>
                    </tr>
                </thead>
            <!--</table>-->
            <div id='dados'>
            <script>resize()</script><!-- Isso é Necessário para a criação o resize -->
            <!--<table cellpadding="0" cellspacing="0" width="100%" id="tabela_dados">-->
                <tbody>
             
                    <tr>
                       <td width="250"></td>
                       <td width="150"><input type="text" name="obs_aluno" id="obs_aluno"></td>
                    </tr>
              
                </tbody>
            </table>
          </div>
          
     </fieldset>
	
	
<!--Fim dos fiels set-->
<?php
	if($r->status == 2){
		$disabled = 'disabled="disabled"'; 	
	} 
?>
<div style="width:100%; text-align:center" >	
<?
if($r->id > 0){
?>
<input name="action" type="submit" <?=$disabled?> value="Excluir" style="float:left" />
<?
}
?>

<input name="action" type="submit" <?=$disabled?> value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>