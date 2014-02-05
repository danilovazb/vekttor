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

	if(!empty($aula_id))
		$disabled='disabled="disabled"';

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
    
    <span>Aula </span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
    <input type="hidden" name="professor_as_turma_id" value="<?=$info_professor["professor_has_turma_id"]?>">
    <input type="hidden" name="unidade_id" value="<?=$info_professor["unidade_id"];?>" >
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
		<legend>
            <a onclick="aba_form(this,0)"><strong>Aula</strong> </a>
    		<a onclick="aba_form(this,1)">Texto</a>
            
			<? if( !empty($aula_id) ){?>
            <!--<a onclick="aba_form(this,2)">Arquivo</a>-->
            <? }?>
            
          </legend>
        
        <div style="width:100%; max-height:80px;">
        	
            <div><strong>Materia:</strong> <?=$nome_materia?></div>
            
        </div>
        
        <input type="hidden" name="id" id="id" value="<?=$r->id?>">
        <input type="hidden" name="sala_materia" value="<?=$_GET['sala_materia']?>">
		<input type="hidden" name="aula_id" id="aula_id" value="<?=$aula_id?>">
                
        <div class="container-aula" ><!--container-aula-->
        <br/>
        <label style="width:300px;">Descriç&atilde;o
		  <input type="text" id='descricao' name="descricao" value="<?=$info_aula->descricao?>" autocomplete='off' maxlength="80"/>
		</label>
        <div style="clear:both;"></div>
        	<label style="width:300px;">Observação:<br/>
            	<textarea name="obs" id="obs" cols="39" rows="5"><?php echo $info_aula->observacao;?></textarea>
            </label> 
        <div style="clear:both;"></div>
        <label style="width:75px;">
        	Data<br/>
            <input type="text" name="data_aula" id="data_aula" readonly="readonly"  mascara="__/__/____" value="<?php if($info_aula->data){ echo dataUsaToBr($info_aula->data);} else{ echo dataUsaToBr($data);}?>" >
        </label>
           <?php
           $sql_bimestre = mysql_query($ty=" SELECT * FROM escolar2_periodos_avaliacao WHERE vkt_id = '$vkt_id' AND unidade_id = '".$info_professor["unidade_id"]."'  ORDER BY id");
						
		   ?>
           <label> Periodo  <br/>
        	<select name="periodo_id" id="periodo_id">
            	<?php	
					while($r_bimestre=mysql_fetch_object($sql_bimestre)){
						if($info_aula->periodicidade_id == $r_bimestre->id){$sel =  'selected="selected"';} else {$sel='';}
				?>
            	          <option <?=$sel?>  value="<?=$r_bimestre->id?>"><?=$r_bimestre->nome;?></option>
            	<?
						}
				?>
            </select>
        </label>
        <br/>
       
           <div style="clear:both;"></div>
           
           <?
           	if( empty($aula_id) ){
		   ?>
           <div class="content-turmas-header"> Outras turmas para essa matéria </div>
           <div class="content-turmas"> 
              <?
              for($i=0; $i < count($array_horarios); $i++){
                  $array_turmas = retorna_turma_horario($array_horarios[$i]["id"],$serie_has_materia,$professor_id);	
              ?>
            <div class="body-turmas">
                <div> <?php echo $array_horarios[$i]["nome_horario"];?> </div>
                    
                <? for($j=0;$j < count($array_turmas);$j++){ 
                    //if( $info_aula->professor_as_turma_id == $array_turmas[$j]["professor_has_turma_id"]) { $sell = 'checked="checked"'; } else {$sell = '';}
                ?>
                    <div class="turma"> 
                        <input type="checkbox" <?=$sell?>  name="outras_turmas[]" id="outras_turmas" value="<?=$array_turmas[$j]["professor_has_turma_id"]?>"> 
                        <?php echo $array_turmas[$j]["nome_turma"]; ?>
                    </div>
                
                <?
                    }
                ?>
            </div>
            <?php
                }
            ?>
            </div>
           <?
			}
		   ?>
        </div>
        
        <?  if( !empty($aula_id) ){ ?>
        	 
            <div style="min-height:15px;">
    
            	<div style="float:left;padding:2px;"> <button type="button" id="clickFrequencia" style="width:90px;" class="frequencia lancar"> Frequ&ecirc;ncia </button>  </div>
            	
                <div style="float:left;padding:2px;"> <button type="button" id="clickObservacao" style="width:90px;" class="frequencia lancar"> Ocorr&ecirc;ncias </button>  </div>
                <div style="float:left;padding:2px;"> 
                <button type="button" rel="tip" id="arquivo" title=" Upload arquivo" onclick="location.href='?tela_id=286&aula=<?=$aula_id?>'" style="width:37px;" class="frequencia lancar"> 
                <span class="icon-upload"></span>  <span>&nbsp;</span> 
                </button>  
                </div>
                
            </div>  
            
			<? } ?>
        
        
        
	</fieldset>
    
    <fieldset id="campos_2" style="display:none">
		 <legend>
            <a onclick="aba_form(this,0)"> Aula  </a>
    		<a onclick="aba_form(this,1)"><strong>Texto</strong> </a>
            
			<? if( !empty($aula_id) ){?>
            <!--<a onclick="aba_form(this,2)">Arquivo</a>-->
            <? }?>
          
          </legend>
          <label style="width:400px">Texto da Aula<br/>
          		<textarea name="texto_aula" id="texto_aula" cols="30" rows="8"><?=$r->texto_aula?></textarea>
          </label>
     </fieldset>
      <fieldset id="campos_3" style="display:none">
		 <legend>
            <a onclick="aba_form(this,0)"> Aula  </a>
    		<a onclick="aba_form(this,1)"> Texto </a>
            
			<? if( !empty($aula_id) ){?>
            <!--<a onclick="aba_form(this,2)">Arquivo</a>-->
            <? }?>
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