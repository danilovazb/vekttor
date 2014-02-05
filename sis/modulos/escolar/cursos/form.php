<?php

//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div style="top:30px; left:50px;" class="exibe_formulario" id="exibe_formulario">
<div id='aSerCarregado'>
    <div style="width:650px;">
    
        <div>
            <div class='t3'></div>
            <div class='t1'></div>
            <div class="dragme">
                <a class='f_x' onclick="form_x(this)"></a>        
                <span>Curso</span>
            </div>
        </div>
        
		<form onsubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data">

            <input name="curso_id" type="hidden" value="<?php echo $_GET['curso_id']; ?>" />
            
            <fieldset id="campos_1">
                <legend>
                <?
                function menu_fild($linkado){
					$lk1[$linkado] = '<strong>';
					$lk2[$linkado] = '</strong>';
				?>
                     <a onclick="aba_form(this,0)"><?=$lk1[0]?>Cursos<?=$lk2[0]?></a>
                     <a onclick="aba_form(this,1)"><?=$lk1[1]?>Dados Adicionais<?=$lk2[1]?></a>
                     <a onclick="aba_form(this,2)"><?=$lk1[2]?>Dados Bancários<?=$lk2[2]?></a>
                 <?
				}
				menu_fild(0);
				 ?>
                </legend>
                
                <label style="width:250px; margin-right:23px;">
                    Nome
                    <input type="text" id="nome" name="nome" valida_minlength="5" retorno="focus|Coloque no minimo 5 caracteres" value="<?php echo $d->nome?>" />
                </label>
                <label style="width:70px;">
                	% de Faltas
                    <input type="text" id="perc_faltas" name="perc_faltas" sonumero='1' valida_minlength="1" retorno="focus|Preencha o campo % de Faltas" value="<?php echo $d->perc_faltas?>" />
                </label>
              <div style="width:300px; margin-right:23px;">
                    Modulos
                    <div id='multiplicador'>
                    
                    <?
					
					if(@mysql_result(mq("SELECT count(*) FROM escolar_modulos WHERE curso_id='$d->id' AND vkt_id='$vkt_id'"),0,0)==0){
						$q = "SELECT 1=1";	
					}else{
						$q="SELECT * FROM escolar_modulos WHERE curso_id='$d->id' AND vkt_id='$vkt_id'"	;
					}
					$q= mq($q);
                    while($m=mf($q)){
						$x++;
						if($x>1){
							$img='menos';	
							$class='remove';
						}else{
							$img='mais';	
							$class='adiciona';
						}
					?>
                    <label >
                    <input type="hidden"  name="modulo_id[]" value="<?=$m->id?>"/>
                    <input style="width:250px;" type="text"  name="modulo_nome[]" valida_minlength="5" retorno="focus|Coloque no minimo 5 caracteres" value="<?=$m->nome?>" /> 
                     
                     </label>
                     <img src="../fontes/img/<?=$img?>.png" width="18" height="18" class="<?=$class?>" modulo_id='<?=$m->id?>' />
					 <?
                     }
					 ?>
                </div>
              </div>
                
                 <label style="width: 100%; clear:both;">
                	Foto
                	<input type="file" name="file[]" />
                </label>
                <div style="clear:both;" id='img_curso' >
                <?
                if(strlen($d->extensao)>=3){
				?>
                <img src='modulos/escolar/cursos/img/<?=$d->id?>.<?=$d->extensao?>' height="100" /><br />
                <a href="#" class='remove_imagem' curso_id='<?=$d->id?>'>Remover</a>
                <?
				}
				?>
                </div>
          </fieldset>
                
            <fieldset id="campos_1" style="display:none">
                <legend>
                   <? menu_fild(1) ?>
               </legend>
                
                <label style="width:95%;">
                    Descri&ccedil;&atilde;o
                      <textarea rows="4" id="descricao" name="descricao"><?php echo $d->descricao; ?></textarea>
                </label>
                
                <label style="width:95%;">
                    Conte&uacute;do Program&aacute;tico
                      <textarea rows="4" id="conteudo_programatico" name="conteudo_programatico"><?php echo $d->conteudo_programatico; ?></textarea>
                </label>
                <label style="width:95%;">
                    Termos
                      <textarea rows="4" id="termos" name="termos"><?php echo $d->termos; ?></textarea>
                </label>
                
               
                
            </fieldset>
          <fieldset id="campos_2" style="display:none">
            <legend>
                   <? menu_fild(2) ?>
            </legend>
                                               <div class="divisao_options" style="width:100%;">
           		  <span  class="titulo_options"><strong>Unidades</strong></span>
   
                      
                    <?
					$q1 = mysql_query($q="SELECT * FROM escolar_escolas WHERE vkt_id='$vkt_id' ORDER BY nome");
					while ($d1 = mysql_fetch_object ($q1) ){
						$info_unidade_curso = mf(mq($q="SELECT * FROM escolar_cursos_unidades_contas WHERE curso_id='$d->id' AND unidade_id='$d1->id'"));
						if( $info_unidade_curso->conta_id>0){
							$selected = " checked=\"checked\"";
						}else{
							$selected = "";
						}
				  ?> <div>
                      <label style="width:100%; margin-right:23px; margin-bottom: 0px;">
                      
                      <input name='escola_id[]' class="undade_escolar" type='checkbox' value="<?=$d1->id?>" <?=$selected?>><?=$d1->nome?>
                      </label>
    
                    	<label style="width:150px; margin-left:30px;">
                      	<select <? if($info_unidade_curso->conta_id<1){echo 'disabled="disabled"' ;}?>   name="conta_id[]" id="conta_id[]" <?=$desabilita_finalizado?> >
                        <option value='0'  >Selecione 1 Conta</option> 
                  <?
                  $q= mysql_query($t ="select * from financeiro_contas WHERE  cliente_vekttor_id ='".$vkt_id."'order by preferencial DESC,nome");
                  while($r= mysql_fetch_object($q)){
                      
                    if($info_unidade_curso->conta_id==$r->id){$sel = "selected='selected'";}else{$sel = "";}
                        echo "<option value='$r->id' $sel >$r->nome   </option>";  
                    }
                  ?>
                    
                </select></label>
                <label style=" float:left; width:120px;">
                	<select name="centro_custo_id[]">
                    	<option>Centro de custo</option>
                        <? 
						$centro_custo_q=mysql_query("SELECT * FROM financeiro_centro_custo WHERE cliente_id='$vkt_id' AND plano_ou_centro='centro'"); 
						while($centro_custo=mysql_fetch_object($centro_custo_q)){
							if($info_unidade_curso->centro_custo_id==$centro_custo->id){$sel="selected='selected'";}else{$sel='';}
						?>
                        <option <?=$sel?> value="<?=$centro_custo->id?>"><?=$centro_custo->nome?></option>
                        <? } ?>
                    </select>
                </label>
                <label style=" float:left; width:120px;">
                	<select name="plano_conta_id[]">
                    	<option>Plano de conta</option>
                        <? 
						$plano_conta_q=mysql_query("SELECT * FROM financeiro_centro_custo WHERE cliente_id='$vkt_id' AND plano_ou_centro='plano'"); 
						while($plano_conta=mysql_fetch_object($plano_conta_q)){
							if($info_unidade_curso->plano_conta_id==$plano_conta->id){$sel="selected='selected'";}else{$sel='';}
						?>
                        <option <?=$sel?> value="<?=$plano_conta->id?>"><?=$plano_conta->nome?></option>
                        <? } ?>
                    </select>
                </label>
			</div>
			<?
						
					}
					?>
                   
                </div>
 
                              

</fieldset>        
            <!--Fim dos fiels set-->
            <div style="width:100%; text-align:center" >
                <?php if( $d->id > 0 ){ ?>
                <input name="action" type="submit" value="Excluir" style="float:left" />
                <?php } ?>
                <input name="action" type="submit" value="Salvar" style="float:right" />

                
              <div style="clear:both"></div>
            </div>
    	</form>
	</div>
</div>
<script>
	top.openForm();
</script></div>