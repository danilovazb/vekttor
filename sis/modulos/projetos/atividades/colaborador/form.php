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

	
?>
<style>
input,textarea{ display:block;}
</style>

<link href="../../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:600px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Atividade</span></div>
    </div>
	<form onSubmit="return validaForm(this)" action="modulos/projetos/atividades/colaborador/form.php" autocomplete='off' class="form_float" method="post" name="atividade" id="atividade" target="carregador">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
    
		<legend>
			<strong id='escreve'>Projeto: <?=$p->nome?></strong>
		</legend>
        <input type="hidden" name="id" id="id" value="<?=$registro->id;?>" />
        
        <div>
        <span style="">
        <?=$a->nome ?>
        </span>
        <div style="clear:both; width:100%"></div>
          <span style="color:#333333; ">
	          <div style="float:left; width:54px;font-size:18px;"><? $estimado = substr($registro->tempo_estimado_horas,0,5); echo $estimado;?></div>
          
		  		<div style="float:left; width:437px;font-size:18px;"><strong><?=$registro->nome?></strong></div>
          </span>
          
          </div>
                  <div style="clear:both; width:100%"></div>

         <?
        if(strlen($registro->descricao)>0){
		?>
       <div style="color:#555; padding:5px; margin-top:14px; font-size:12px; background:#F4F1D6; border:1px solid #CDCDCD; border-radius:5px;">
           <?=nl2br($registro->descricao) ?>  

          </div>
          <?
		}
		  ?>
          
                  <label style="width:500px; margin-top:10px;">
          Deixe uma mensagem para o responsável 
          <textarea  style="height:100px;" name="comentario_executor" id="comentario_executor"><?=$registro->comentario_executor;?></textarea>
          
          
		</label>
        <label>
        <input type="checkbox" name="aguardando_resposta" value="1" style="display:inline; width:inherit" <? if($registro->situacao=='3'){echo"checked"; }?> /> 
       Colocar Atividade em Espera, depende de outra pessoa para ser executada, comente no campo acima 
       </label>
       <div style="clear:both; width:100%; height:10px;"></div>
        <input type="submit" value="Salvar" style="float:right">
                  <div style="clear:both; width:100%; height:20px;"></div>
         <div style="clear:both">
         <table width="100%">
         <tr>
           <td align="center"><strong>Data</strong></td>
         	<td align="center"><strong>Inicio</strong></td>
         	<td align="center"><strong>Fim</strong></td>
         	<td align="center"><strong>Tempo</strong></td>
         </tr>
         <?
         
		 $qt = mysql_query($t="SELECT 
		 *,
		 DATE_FORMAT(inicio,'%H:%i') AS i,
		 DATE_FORMAT(fim,'%H:%i') AS f,
		 DATE_FORMAT(fim,'%d/%m') AS d,
		 DATE_FORMAT(fim,'%w') AS s,
		 TIMEDIFF(fim,inicio) as t,
		 TIMEDIFF(now(),inicio) as t2
		 
		 
		  FROM projetos_atividades_tempo WHERE atividade_id ='$registro->id' AND usuario_id='$usuario_id'");
			$tempodecorrido =0;
		 while($rt= mysql_fetch_object($qt)){
		 
		 ?>
         <tr>
           <td align="center"><?=$semana_abreviado[$rt->s]?> <?=$rt->d?></td>
         	<td align="center"><?=$rt->i?></td>
         	<td align="center"><?=$rt->f?></td>
         	<td align="center"><?
           if($rt->fim!='0000-00-00 00:00:00'){
			   echo substr($rt->t,0,5);
			   $tempodecorrido += mysql_result(mysql_query("SELECT TIME_TO_SEC('$rt->t')"),0,0);
			  } else{
			   $tempodecorrido += mysql_result(mysql_query("SELECT TIME_TO_SEC('$rt->t2')"),0,0);

				echo substr($rt->t2,0,5);
			}
			?></td>
         </tr>
         <?
         }
		 ?>
         <tr>
           <td colspan="3" align="right"><strong>Total</strong></td>
           <td align="center"><strong><?=substr(mysql_result(mysql_query("SELECT SEC_TO_TIME($tempodecorrido)"),0,0),0,5);?></strong></td>
         </tr>
         </table>  
         <?
        if($registro->situacao==1){ 
		 ?>       
         Atividade concluida em 
		 <? if($registro->dias_concluidas>0){ 
		 		
		 ?> 
		      <strong><?=$registro->dias_concluidas;?></strong>   dias e 
         <? } ?>
		 <strong><?=substr($registro->horas_concluidas,0,5);?></strong> horas depois de ser cadastrada
         <?
		}
		 ?>
         </div> 
          
          
	</fieldset>
	<input name="id" type="hidden" value="<?=$registro->id?>" />
	<div style="font-size:10px; color:#777; text-align:right">
    Criado em <?=$registro->cadastro?> 
    <? if($registro->dias>1){ ?>
    há <strong><?=$registro->dias?></strong> dias  atrás
    <?
	}else{
	?>
    há <strong><?=substr($registro->horas,0,5);?></strong> horas atrás 
    <?
	}
	?>
    por <strong><?=$criador->nome?></strong>
    </div>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
  <div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>