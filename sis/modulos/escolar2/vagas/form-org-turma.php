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
<div style="width:480px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a> <!-- ;location.href='?tela_id=460&escola_id=<?=$_GET['escola_id']?>&ano=<?=$_GET['ano']?> -->
    
    <span>Organização</span></div>
</div>
	<form onsubmit="return validaForm(this)" class="form_float" id="form_importar_periodo_letivo"  method="post" >

		
		<input type="hidden" name="horario_id" value="<?=$_GET["horario"]?>">
        <input type="hidden" name="serie_id" value="<?=$_GET["serie"]?>">
        <input type="hidden" name="escola_id" value="<?=trim($_GET['unidade'])?>">
        <input type="hidden" name="periodo_letivo_id" value="<?=trim($_GET["periodo_letivo"])?>">

         <fieldset>
          <legend>
            <a onclick="aba_form(this,0)"><strong>Organização de Turmas</strong></a>
          </legend>
			 
            <? 
			
			$serie =  mysql_fetch_object( mysql_query(" SELECT * FROM escolar2_series WHERE vkt_id = '$vkt_id' AND id = '".trim($_GET["serie"])."' ") );
			$ensino = mysql_fetch_object( mysql_query(" SELECT * FROM escolar2_ensino WHERE vkt_id = '$vkt_id' AND id = '".trim($_GET["ensino"])."' ") );
			$horario = mysql_fetch_object( mysql_query(" SELECT * FROM escolar2_horarios WHERE vkt_id = '$vkt_id' AND id = '".trim($_GET["horario"])."' ") );
			
			//salas ocupdas
			if( !empty($_GET['unidade']) ) { 
			 $sql_salas_ocupadas = mysql_query($y=" 
				  SELECT * FROM escolar2_turmas AS turma  
				  	WHERE turma.vkt_id = '$vkt_id'
					AND serie_id = '".$_GET["serie"]."' 
					AND horario_id = '".$_GET["horario"]."'
					AND periodo_letivo_id = '".$_GET["periodo_letivo"]."'
				  	AND turma.unidade_id = '".trim($_GET['unidade'])."' ");
			
			while($s_ocupadas = mysql_fetch_assoc($sql_salas_ocupadas)){
				$salas_ocupadas[] = $s_ocupadas["sala_id"]; 
			}
			
			
			//todas as salas
			$sql_sala = mysql_query(" SELECT * FROM escolar2_salas WHERE vkt_id = '$vkt_id' AND unidade_id = '".trim($_GET['unidade'])."'  ");
			while($t_salas = mysql_fetch_assoc($sql_sala)){
					$todas_salas[] = $t_salas; 
			}
			
			?>  
             
            <label style="margin-top:5px; width:140px;">Ensino
             <? echo "<div><h4>".$ensino->nome."</h4></div>";?>
            </label>
            
            <label style="margin-top:5px; width:120px;">Série
             <? echo "<div><h4>".$serie->nome."</h4></div>";?>
            </label>
            
            
             
            <label style="margin-top:5px;">Horário
             <? echo "<div><h4>".$horario->nome."</h4></div>";?>
            </label>
            
            <div style="clear:both;"></div>
			<label>Salas<br/>
            	<select name="sala_id" id="sala_id" style="width:120px;">
                 <? for($i=0; $i <count($todas_salas);$i++){
					 
					$disabled = in_array($todas_salas[$i]["id"], $salas_ocupadas) ? 'disabled="disabled"' : NULL;
					$salas_nome = in_array($todas_salas[$i]["id"], $salas_ocupadas) ? $todas_salas[$i]["nome"]." - Ocupado " : $todas_salas[$i]["nome"];
				
				 ?>
                	<option <?=$disabled?>  value="<?=$todas_salas[$i]["id"]?>"><?=$salas_nome?></option>
                <? } ?>
                </select>
              
            </label>
            
             <? } else echo "<div class='obs text-extra-combina-horario' style='display:block;font-size:12px;'><p><h3>Atenção!</h3>Selecione uma Unidade</p> </div>"; ?>
            <div style="clear:both;"></div>
           
           
           <label style="width:110px;">
           		Nome da turma
                <input type="text" name="nome_turma">
           </label>
           
           <label style="width:110px;">
           		Valor Matrícula
                <input type="text" name="valor_matricula" sonumero="1" decimal="2">
           </label>
           
            <label style="width:110px;">
           		Valor Mebsalidade
                <input type="text" name="valor_mensalidade" sonumero="1" decimal="2">
           </label>
            
            
        
        </fieldset>
        <input type="submit" style="float:right;" name="Cadastra_Turma" value="Salvar">
        <div style="clear:both"></div>
        
    </form>
</div>
</div>
</div>
<script>top.openForm()</script>