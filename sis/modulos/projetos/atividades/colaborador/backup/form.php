<?
//Includes
// configuraçao inicial do sistema
include("../../../../_config.php");
// funçoes base do sistema
include("../../../../_functions_base.php");
// funçoes do modulo empreendimento
include("_function_colaborador.php");
include("_ctrl_colaborador.php"); 
date_default_timezone_set('America/Manaus');
$tempo_final = substr($registro->tempo_finalizado_hora,0,5);
$data_inicio = substr($registro->data_hora_inicio,0,10);
$rd = 'none';

	if($registro->situacao == 0){
			$inicio = 'block';
			$fim = 'none';
			$disabled1 = '';
			$disabled2 = 'disabled="disabled"'; 
	}
	if($registro->situacao == 1){
			$inicio = 'none';
			$fim = 'block';
			$disabled1 = 'disabled="disabled"';
			$disabled2 = ''; 
	}
	if($registro->situacao == 2){
			$rd = 'display';
	} 
	if($registro->hora_inicio == '00:00'){
		$registro->hora_inicio = date("H:i");
	}
	if($registro->hora_fim == '00:00'){
		$registro->hora_fim = date("H:i");
	}
	
	if($data_inicio == '0000-00-00'){
		$date_inicio = date('d/m/Y');
	}else{
		$data_inicio = explode('-',$data_inicio);
			$date_inicio = $data_inicio[2].'/'.$data_inicio[1].'/'.$data_inicio[0];
	} 
	
	$hora1 = $registro->hora_fim;
	$hora2 = $registro->hora_inicio;
	
	/*if($tempo_final == '00:00'){
		$tempo_final = ($hora1-$hora2);
	}*/
	
?>
<style>
input,textarea{ display:block;}
</style>

<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Atividade</span></div>
    </div>
	<form onSubmit="return validaForm(this)" autocomplete='off' class="form_float" method="post" name="atividade" id="atividade">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
    
		<legend>
			<strong id='escreve'>Informa&ccedil;&otilde;es</strong>
		</legend>
        <input type="hidden" name="id" id="id" value="<?=$registro->id;?>" />
        
        <div id="inicio" style="display:<?=$inicio;?>">
        
        <div style="margin:5px; padding:5px;">
        <div style="display:<?=$rd?>"><input type="radio" name="rd" id="situ3"  value="0"> Parar</div>
            <!--<input type="hidden" name="situacao" id="v1" value="2">-->
        </div>
        
        <input type="hidden" name="situacao" id="v1" value="2" <?=$disabled1;?>>
        <label style="width:100px;" >Data Inicio
          <input name="data_inicio" id="data_inicio" style="width:70px;" value="<?=$date_inicio;?>" mascara='__/__/____' calendario='1' />
        </label>
        
        <label style="width:100px;" >Hora Inicio
        
          <input type="text" style="width:70px;" id="hora_inicio" name="hora_inicio" mascara="__:__" value="<?=$registro->hora_inicio;?>" title='Tempo Estimado' size="4" sonumero='1'  />
        </label>
        </div>
       
        <hr style="clear:both; color:#FFF; border:0.1px solid #CCC;display:<?=$rd?>; margin:2px;">
        <!--<input type="hidden" name="situacao" id="situacao" value="1" />-->
        
   <div id="fim" style="display:<?=$fim;?>">
        
        <div style="margin:5px; padding:5px;">
        <div style="display:<?=$rd?>"><input type="radio" id="situ2"> Finalizar</div>
        <!--<input type="hidden" name="situacao" id="v2" value="1">-->
        </div>
        
        <input type="hidden" name="situacao" id="v2" value="1" <?=$disabled2;?>>
        <label style="width:100px;" >Tempo Gasto
          <input name="tempo_gasto" id="tempo_gasto" <?=$disabled2?> style="width:70px;" mascara="__:__" title='Tempo Gasto' sonumero='1' size="4"  value="<?=$tempo_final;?>"  />
        </label>
                       
        <label style="width:100px;" >Data Final
          <input name="data_fim" id="data_fim" style="width:80px;" value="<?=date('d/m/Y'); ?>" mascara='__/__/____' calendario='1' <?=$disabled2;?> />
        </label>
        
        <label style="width:100px;" >Hora Final
        
          <input type="text" style="width:70px;" id="hora_fim" name="hora_fim" mascara="__:__" value="<?php echo $registro->hora_fim;?>" title='Tempo Estimado' size="4" sonumero='1'  />
          
        </label>
               
  </div>
             		
	</fieldset>
	<input name="id" type="hidden" value="<?=$registro->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($registro->id>0){
?>
<!--<input name="action" type="submit" value="Excluir" style="float:left" />-->
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