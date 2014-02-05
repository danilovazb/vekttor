<?php

//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

$q = mysql_query("SELECT *, DATE_FORMAT(horario_inicio, '%H:%i') horario_inicio, DATE_FORMAT(horario_fim, '%H:%i') horario_fim FROM escolar_horarios WHERE id = '{$_GET['horario_id']}'")or die(mysql_error());
$d = mysql_fetch_object($q);

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id="exibe_formulario" class="exibe_formulario"  style="top:30px; left:50px;">

<div id='aSerCarregado'>
    <div style="width:500px;">
    
        <div>
            <div class='t3'></div>
            <div class='t1'></div>
            <div class="dragme">
                <a class='f_x' onclick="form_x(this)"></a>        
                <span> Horário </span>
            </div>
        </div>
        
		<form onsubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data">

            <input name="horario_id" type="hidden" value="<?=$_GET['horario_id']; ?>" />
            
            <fieldset id="campos_1">
              <legend>
                     <a onclick="aba_form(this,0)"><strong>Horario / Turnos</strong></a>
                     <a onclick="aba_form(this,1)">Unidades e Cursos</a>
                </legend>
                
                
               <label style="width:250px;">
                Descrição
                	<input type="text" name="nome" value="<?=$d->nome?>" />
                </label>
                <div class="divisao_options" style="width:100%;">
           		  <span  class="titulo_options">Dias da Semana (Dias Letivos do Horario)</span>
                    
                    <?
					
					$dias = explode(",", $d->dias_semana);
					$total = count ($dias);
					
					for( $i = 0; $i < $total; $i++ ){
						$semana_selecionada[$dias[$i]]='checked="checked"' ;				
					}
						
					?>
                    
                    <label>
                          Dom<input type="checkbox" id="dom" name="semana[]" value="0" <?=$semana_selecionada[0]?>>
                    </label>
                    <label>
                          Seg<input type="checkbox" id="seg" name="semana[]" value="1" <?=$semana_selecionada[1]?>>
                    </label>      
                    <label>
                          Ter<input type="checkbox" id="ter" name="semana[]" value="2" <?=$semana_selecionada[2]?>>
                    </label>      
                    <label>
                          Qua<input type="checkbox" id="qua" name="semana[]" value="3" <?=$semana_selecionada[3]?>>
                    </label>     
                    <label>
                          Qui<input type="checkbox" id="qui" name="semana[]" value="4" <?=$semana_selecionada[4]?>>
                    </label>      
                    <label>
                          Sex<input type="checkbox" id="sex" name="semana[]" value="5" <?=$semana_selecionada[5]?>>
                    </label>      
                    <label>
                          Sab<input type="checkbox" id="sab" name="semana[]" value="6" <?=$semana_selecionada[6]?>>
                    </label>
                    
              </div>
              <label style="width:100px;">
                    Vagas
                  Rematricula
                      <input style="width:70px;" type="text" id="vagas_por_sala_rematricula" name="vagas_por_sala_rematricula" sonumero='1' valida_minlength="1" onkeyup="calcula_vagas()" retorno="focus|Coloque no mínimo 1 caracter" value="<?=$d->vagas_por_sala_rematricula ?>" />
                </label>
              <label style="width:85px;"> Vagas
                Matricula
                <input style="width:70px;"type="text" id="vagas_por_sala" onkeyup="calcula_vagas()" name="vagas_por_sala" sonumero='1' valida_minlength="1" retorno="focus|Coloque no m&iacute;nimo 1 caracter" value="<?=$d->vagas_por_sala ?>" />
              </label>
                   
                <label style="width:50px; " title='Total de Vagas'>
                    Total<br />
                    <strong id='vagas_total_horario'><?=$d->vagas_total_horario?></strong>
                    <input type="hidden" name="vagas_total_horario" id= 'inputvagas_total_horario' value="<?=$d->vagas_total_horario ?>" /> 
                  </label>
                                  <label style="width:70px;">
                    Alunos/Salas
                <input type="text" style="width:50px" id="qtde_salas" name="qtde_salas" onkeyup="calcula_vagas()" sonumero='1' valida_minlength="1" retorno="focus|Coloque no mínimo 1 caracter" value="<?=$d->qtde_salas ?>" />
                </label>
                 <label style="width:30px;">
          Salas<br />
                <strong id='total_salas_rematricula'><?=@(($d->vagas_por_sala_rematricula+$d->vagas_por_sala)/$d->qtde_salas)?></strong>
                </label>
                 
              <div style="clear:both"><strong>Informações Sobre as Aulas</strong></div>   
                <label style="width:70px;">
                    Data Inicio
                      <input type="text" id="data_aulas_inicio" name="data_aulas_inicio" mascara='__/__/____' calendario='1' sonumero='1' valida_data='1' retorno='focus|Data Simples' value="<?=dataUsaToBr($d->data_aulas_inicio); ?>" />
                </label>
                
                <label style="width:70px;">
                    Data Final
                      <input type="text" id="data_aulas_fim" name="data_aulas_fim" mascara='__/__/____' calendario='1' sonumero='1' valida_data='1' retorno='focus|Data Simples' value="<?=dataUsaToBr($d->data_aulas_fim); ?>" />
                </label>
             
                <label style="width:100px;">
                    Hor&aacute;rio In&iacute;cio
                      <input type="text" id="hora_inicio" name="horario_inicio" mascara='__:__' sonumero='1' value="<?=$d->horario_inicio; ?>" />
                </label>
                
                <label style="width:100px;">
                    Hor&aacute;rio Final
                      <input type="text" id="hora_fim" name="horario_fim" mascara='__:__' sonumero='1' value="<?=$d->horario_fim; ?>" />
                </label>
         <div style="clear:both"></div>        
                
          <label style="width:100px;">
                    Valor Integral
                      <input type="text" id="valor" name="valor" sonumero='1' valida_minlength="1" retorno="focus|Coloque no mínimo 1 caracter" value="<?=$d->valor ?>" />
                </label>
          <label style="width:100px;">
                    Valor Bolsista
                      <input type="text" id="valor_bolsista" name="valor_bolsista" sonumero='1' valida_minlength="1" retorno="focus|Coloque no mínimo 1 caracter" value="<?=$d->valor_bolsista ?>" />
                </label>
                                <label>
                	Período Letivo
                <select name="periodo_id">
                	<?
                    $qp = mq("select * from escolar_periodos WHERE vkt_id='$vkt_id'");
					while($p=mf($qp)){
						if($d->periodo_id == $p->id||$_GET[periodo_id]==$p->id){
							$sel = 'selected="selected"';
						}else{
							$sel = '';
						}
					?>
                	<option value="<?=$p->id?>" <?=$sel?>><?=$p->nome?></option>
                    <?
					}
                    ?>
                </select>
                </label>
                
                    </fieldset>
                    
                    <fieldset id="campos_2" style="display:none">
              <legend>
                     <a onclick="aba_form(this,0)">Horario / Turnos</a>
                     <a onclick="aba_form(this,1)"><strong>Unidades e Cursos</strong></a>
                </legend>
           		  <span  class="titulo_options" style=" font-size:11px; padding:10px;">Selecione os módulos das unidades que usarão esse horario, será criado um horario independente para cada um dos modulos selecionados</span>
<div style="height:450px; overflow:auto;">
      <?
      if($d->id<1){
	  ?>         
<div class="divisao_options" style="width:100%;">
<?
//vkt_id 	conta_id 	curso_id 	unidade_id 
$q_escolas = mq("SELECT distinct(unidade_id),e.nome FROM escolar_cursos_unidades_contas as u, escolar_escolas as e WHERE u.unidade_id=e.id AND u.vkt_id='$vkt_id'");
$info=0;
while($u=mf($q_escolas)){
	$info++;
?>
    <div class="divisao_options" style="width:300px; margin:0;"> <strong><?=$u->nome?></strong></div>
    <?
		$q_cursos = mq($q="SELECT distinct(curso_id),c.nome FROM escolar_cursos_unidades_contas as u, escolar_cursos as c WHERE u.curso_id=c.id AND u.unidade_id='$u->unidade_id'");
		while($c=mf($q_cursos)){
	?>
    <div class="divisao_options" style="width:300px; margin-left:35PX"> <?=$c->nome?><br />
    	<?
        $qm= mq("SELECT * FROM escolar_modulos WHERE curso_id='$c->curso_id'");
		while($m=mf($qm)){
		?>
        <label style="margin-bottom:3px;">
        <input type="checkbox" name="modulo_id[]" value="<?=$m->id?>,<?=$c->curso_id?>,<?=$u->unidade_id?>"><?=$m->nome?>
        </label>
        <?
		}
		?>
    </div>
    <?
		}
	?>
<?
}
if($info==0){
	echo "Vá em cursos e selecione uma conta para os cursos e escolas";
}
?>
</div>
<?
	  }else{
		  
		  ?>
		  <input type="hidden" name="modulo_id[]" value="<?=$d->modulo_id?>,<?=$d->curso_id?>,<?=$d->escola_id?>" />
		  <?
		  
		  }
?>
 </div>               
                
                

            </fieldset>
            
            <!--Fim dos fiels set-->
            <div style="width:100%; text-align:center" >
                <? if( $d->id > 0 ){ ?>
                <input name="action" type="submit" value="Excluir" style="float:left" />
		     <? } ?>
                <input name="action" type="submit"  value="Salvar" style="float:right" />
                <? if( $d->id > 0 ){ ?>
              <? } ?>
              <div style="clear:both"></div>
            </div>
    	</form>
	</div>
</div>
<script>
	top.openForm();
</script>
</div>