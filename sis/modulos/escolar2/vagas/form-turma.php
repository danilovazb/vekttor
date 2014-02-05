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
    
    <span>Turma</span></div>
</div>
	<form onsubmit="return validaForm(this)" class="form_float"   method="post" >

		<input type="hidden" name="turma_id" value="<?=$_GET["turma"]?>">
		
         <fieldset>
          <legend> <a onclick="aba_form(this,0)"><strong>Informações - Turma</strong></a> </legend>
			 
            <?php 
			  $turma = mysql_fetch_object(mysql_query($y=" 
			  SELECT *, turma.nome AS nome_turma,
			  ensino.nome AS nome_ensino, serie.nome AS nome_serie,
			  sala.nome AS nome_sala, horario.nome AS nome_horario 
			    FROM escolar2_turmas AS turma 
			  	JOIN escolar2_series AS serie ON serie.id = turma.serie_id
			    JOIN escolar2_ensino AS ensino ON ensino.id = serie.ensino_id
				JOIN escolar2_salas AS sala ON sala.id = turma.sala_id
				JOIN escolar2_horarios AS horario ON horario.id = turma.horario_id
				
			  	WHERE turma.id = '".$_GET['turma']."' 
				AND turma.horario_id = '".$_GET["horario"]."' 
			    AND turma.serie_id = '".$_GET["serie"]."' "));
			  
			?>  
             
            <label style="margin-top:3px; width:150px">Ensino
              <? echo "<div><h3> ".$turma->nome_ensino." </h3></div>"; ?>
            </label>
            <label style="margin-top:3px;">Série
              <? echo "<div><h3> ".$turma->nome_serie." </h3></div>"; ?>
            </label>
            
            <div style="clear:both;"></div>
			
            <label style="width:150px">Sala
              <? echo "<div><h3> ".$turma->nome_sala." </h3></div>"; ?>
            </label>
             <label>Horário
              <? echo "<div><h3> ".$turma->nome_horario." </h3></div>"; ?>
            </label>
             
            <div style="clear:both;"></div><br/>
           
           
           <label style="width:110px;">
           		Nome da turma
                <input type="text" name="nome_turma" value="<?=$turma->nome_turma?>">
           </label>
           
           <label style="width:110px;">
           		Valor Matrícula
                <input type="text" name="valor_matricula" sonumero="1" decimal="2" value="<?=moedaUsaToBr($turma->valor_matricula)?>">
           </label>
           
            <label style="width:110px;">
           		Valor Mebsalidade
                <input type="text" name="valor_mensalidade" sonumero="1" decimal="2" value="<?=moedaUsaToBr($turma->valor_mensalidade)?>">
           </label>
            
            
        
        </fieldset>
        
        <button type="button" onclick="location.href='?tela_id=474&turma_id=<?=$_GET["turma"]?>'">Organizar Professor</button>
        <input type="submit" style="float:right;" name="Cadastra_Turma" value="Atualizar">
        <input type="submit" name="action" style="float:right; margin-right:10px;" value="Excluir">
        <div style="clear:both"></div>
        
    </form>
</div>
</div>
</div>
<script>top.openForm()</script>