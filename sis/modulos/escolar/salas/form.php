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
			<label style="width:90%">
            	Horário
                <select name="horario_id" id="horario_id" >
                	<? 
					
$s_periodo = (mysql_query(" SELECT * FROM escolar_periodos WHERE vkt_id='$vkt_id' ORDER BY inicio_aulas  "));
while($periodo=mysql_fetch_object($s_periodo)){
  echo "<option disabled='disabled' style='margin-left:0'>".$periodo->nome."</option>";
  $s_escola = (mysql_query($t="SELECT distinct(h.escola_id),e.nome FROM escolar_horarios as h, escolar_escolas as e WHERE h.escola_id =e.id AND h.periodo_id='$periodo->id'  AND h.vkt_id='$vkt_id' "));
  while($escola=mysql_fetch_object($s_escola)){
    echo "<option disabled='disabled' style='margin-left:10px'>".$escola->nome."</option>";
	$s_cursos = (mysql_query(" SELECT distinct(h.curso_id),c.nome FROM escolar_horarios as h, escolar_cursos as c WHERE h.curso_id=c.id  AND h.periodo_id='$periodo->id' AND escola_id='$escola->escola_id'"));		
	while($curso=mysql_fetch_object($s_cursos)){
	  echo "<option disabled='disabled' style='margin-left:20px'>".$curso->nome."</option>";
	  $s_modulos =mysql_query($t =" SELECT distinct(h.modulo_id),m.nome FROM escolar_horarios as h, escolar_modulos  as m  WHERE  h.modulo_id=m.id AND h.periodo_id='$periodo->id' AND escola_id='$escola->escola_id' AND h.curso_id='$curso->curso_id'");
	  while($modulos=mysql_fetch_object($s_modulos)){
		echo "<option disabled='disabled' style='margin-left:30px'>".$modulos->nome."</option>";
		$s_horario = mq($t=" SELECT * FROM escolar_horarios WHERE modulo_id = '$modulos->modulo_id' AND periodo_id='$periodo->id' AND curso_id='$curso->curso_id' AND escola_id='$escola->escola_id'");
		while($horarios=mf($s_horario)){
			if($sala->horario_id==$horarios->id){$select='selected=selected';}else{$select='';}
			echo "<option value=".$horarios->id." $select style='margin-left:40px'>".$horarios->nome."</option>";
		}
	  }
	}
  }
}
					
					
					
					
					/*
						while($horario=mysql_fetch_object($horarios)){
							print("<option value=".$horario->id." $select>".$horario->periodo." ".$horario->escola." ".$horario->curso." ".$horario->horario_inicio."-".$horario->horario_fim."</option>");
						}*/
					?>
                </select>
            </label>
         <div   style="clear:both"></div>
         
            <label style="width:294px; margin-right:23px; margin-left:">
				Nome
				<input  type="text" id='nome' name="nome" value="<?=$sala->nome?>" retorno="focus|Digite o nome corretamente" valida_minlength='3'/>
			</label>
             <label style="width:80px;">
				Idade Mínima
				<input type="text" id='idade_min' name="idade_min" retorno="focus|Digite a idade mínima" valida_minlength='1' value="<?=$sala->idade_minima?>" sonumero="1" size="4"/>
			</label>
            <label style="width:80px;">
				Idade Máxima
				<input type="text" id='idade_max' name="idade_max" value="<?=$sala->idade_maxima?>" retorno="focus|Digite a idade mínima" valida_minlength='1' sonumero="1" size="4"/>
			</label>
          
  </label>
		<div style="clear:both"></div>
			
            
		</fieldset>
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($sala->id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
    <?
	}
	?>
	<input name="action" type="submit"  value="Salvar" style="float:right;"  />
    <input name ="id" type="hidden" value="<?=$sala->id?>" />
	<?
	if($sala->id>0){
	?>
    	<input type="button" name="acao" value="Mostrar Alunos" style="float:right;" onclick="location.href='?tela_id=227&sala_id=<?=$sala->id?>'"/>
	<?
	}
	?>
    <div style="clear:both"></div>
	</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>