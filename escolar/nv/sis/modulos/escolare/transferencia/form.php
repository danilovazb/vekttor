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
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Transferencia</span></div>
</div>
	<form onsubmit="return validaForm(this)" class="form_float"  method="post" enctype="multipart/form-data">

		<input  disabled="disabled"  type="hidden" id="aluno_id" name="aluno_id" value="<?=$_GET['aluno_id']; ?>" />

		<fieldset <? if(1==2){ ?> style="display:none"<? }?>>
          <legend>
            <a onclick="aba_form(this,0)"><strong>Dados da Transferencia</strong></a>
          </legend>
			
            <div style="float:left; width:650px;">
           	
			<label style="width:478px;">
				Nome 
				<input  disabled="disabled"  type="text" id="nome" name="nome" value="<?=$d->nome; ?>" />
			</label>
            <label style="width:120px;">
				Data de Nascimento
				<input  disabled="disabled"  type="text" id="data_nascimento" name="data_nascimento" mascara="__/__/____" sonumero="1" value="<?=dataUsaToBr($d->data_nascimento); ?>" />
			</label>
            
            
            <div style="clear:both"></div>
             <div>
            	<strong>Escola, S&eacute;rie Atual</strong><br/>
             </div>
             <label class='lb_periodo_id'>
               Periodo
               <select name="periodo_id[]" class="periodo_id" 
valida_valor='1,99999999'  retorno='focus|Selecione um período'>
            	<option value="0">Selecione 1 Opção</option>
            	<?
				
				$q = mq($t="SELECT p.* FROM escolar_horarios as h, escolar_periodos as p WHERE p.vkt_id='$vkt_id' AND h.periodo_id=p.id group by h.periodo_id ORDER BY p.inicio_aulas ");
				
				while($r=mf($q)){
					if($r->id==$matricula->periodo_id){$s='selected="selected"';}else{$s='';}
					echo "<option value='$r->id' $s>$r->nome</option>";
				}
				
				?>
            </select>
            <?
           // echo $t;
			?>
          </label>
            
            <label class='lb_escola_id' style="width:150px">
            
Escola
<select name="escola_id[]" class='escola_id' valida_valor='1,99999999' retorno='focus|Selecione uma escolas'>
<option value="0" >Selecione 1 Unidade Antes</option>
</select>            </label>
            
            <label class='lb_curso_id' style="width:150px">
Ensino
<select name="curso_id[]" class='curso_id' valida_valor='1,99999999' retorno='focus|Selecione um Curso'>
<option value="0">Selecione 1 Escola Antes</option>
</select>
            </label>
            
            <label class='lb_modulo_id'  style="width:150px">
Série
<select name="modulo_id[]" class='modulo_id' valida_valor='1,99999999' retorno='focus|Selecione um Módulo'>
<option value="0">Selecione 1 Curso Antes</option>
</select>
            </label>
            <label class='lb_horario_id' >
Hor&aacute;rios
<select name="horario_id[]" class='horario_id' valida_valor='1,99999999' retorno='focus|Selecione um Horario'>
<option value="0">Selecione 1 M&oacute;dulo Antes</option>
</select> 
            </label>



            <div style="clear:both"></div>
             <div>
            	<strong>Transferencia</strong><br/>
             </div>
             <label class='lb_periodo_id'>
               Periodo
               <select name="periodo_id[]" class="periodo_id" 
valida_valor='1,99999999'  retorno='focus|Selecione um período'>
            	<option value="0">Selecione 1 Opção</option>
            	<?
				
				$q = mq($t="SELECT p.* FROM escolar_horarios as h, escolar_periodos as p WHERE p.vkt_id='$vkt_id' AND h.periodo_id=p.id group by h.periodo_id ORDER BY p.inicio_aulas ");
				
				while($r=mf($q)){
					if($r->id==$matricula->periodo_id){$s='selected="selected"';}else{$s='';}
					echo "<option value='$r->id' $s>$r->nome</option>";
				}
				
				?>
            </select>
            <?
           // echo $t;
			?>
          </label>
            
            <label class='lb_escola_id' style="width:150px">
            
Escola
<select name="escola_id[]" class='escola_id' valida_valor='1,99999999' retorno='focus|Selecione uma escolas'>
<option value="0" >Selecione 1 Unidade Antes</option>
</select>            </label>
            
            <label class='lb_curso_id' style="width:150px">
Ensino
<select name="curso_id[]" class='curso_id' valida_valor='1,99999999' retorno='focus|Selecione um Curso'>
<option value="0">Selecione 1 Escola Antes</option>
</select>
            </label>
            
            <label class='lb_modulo_id'  style="width:150px">
Série
<select name="modulo_id[]" class='modulo_id' valida_valor='1,99999999' retorno='focus|Selecione um Módulo'>
<option value="0">Selecione 1 Curso Antes</option>
</select>
            </label>
            <label class='lb_horario_id' >
Hor&aacute;rios
<select name="horario_id[]" class='horario_id' valida_valor='1,99999999' retorno='focus|Selecione um Horario'>
<option value="0">Selecione 1 M&oacute;dulo Antes</option>
</select> 
            </label>

            
            <label class="lb_sala_id">

Salas
<select name="sala_id[]" class='sala_id' >
<option value="0">Selecione 1 Curso Antes</option>
</select>
            </label>




             <div style="clear:both;"></div>
            </div>
            <div style="width:120px;float:left; height:160px;border:1px solid #999; background:#FFF; overflow:hidden">
            
            		<div style="clear:both; padding:2px;" id='img_curso' >
                <?
                if(strlen($d->extensao)>=3){
				?>
                <img src='modulos/escolar/alunos_inscritos/img/<?=$d->id?>.<?=$d->extensao?>' height="100" /><br />
                <?
				}
				?>
                </div>
            
            </div>
    <?
                if(strlen($d->extensao)>=3){
				?>
                <a href="#" onclick="this.style.display='none'" class='remove_imagem' aluno_id='<?=$d->id?>'>Remover</a>
                   <?
				}
				?>
         		</fieldset>
		
      
      
      <!-- -->
      
      <!-- -->
      
       <!-- -->
      <!-- -->
      
       <!-- -->
      
      
      
   
      
        
        <div style="width:100%; text-align:center" >
        <input type="button" value="Imprimir" onclick="window.open('modulos/escolare/alunos_inscritos/impressao_aluno.php?id=<?=$_GET['aluno_id']?>','_BLANK')">
        <div style="clear:both"></div>
        </div>
    </form>
</div>
</div>
</div>
<script>top.openForm()</script>
<? if(strlen($d->senha)<1){echo "<script>top.newPass('senha')</script>";} ?>