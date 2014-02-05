<?php
date_default_timezone_set('America/Manaus');
include("../../../../_config.php");
include("../../../../modulos/sysms/InstanceWindow.php");
$disponivel = $statusSMS->SMSCreditos($vkt_id);
			
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
	<form onSubmit="return validaForm(this)"  autocomplete='off' class="form_float" method="post" name="smsEnvia" id="smsEnvia" >
    <input type="hidden" name="vkt" value="<?php echo $vkt_id;?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<a onclick="aba_form(this,0)" id="aba_envia"><strong>Enviar SMS</strong></a>
    		<a id="aba_envia_unico">Enviar &Uacute;nico</a>
		</legend>
        <div id="inicio" style="#">
          <div style="margin:3px; padding:3px;">Mensagem</div>
          <div><label><textarea name="msg" id="msg" rows="5" cols="30"></textarea></label></div>
        </div>
        
        <div style="padding:5px; margin:5px;"> Grupos: </div>
        <div>
            <!-- SELECT GRUPO SOCIAL -->
              <label style="width:150px;">Grupo Social
                    <select name="grupo_social_id" id="grupo_social_id">
                    <option value="0">Todos</option>
                            <? 
                            $sqlSocial = mysql_query(" SELECT * FROM eleitoral_grupos_sociais WHERE vkt_id = '$vkt_id'"); 
                                while($grupo=mysql_fetch_object($sqlSocial)){
                            ?>
                        <option value="<?=$grupo->id?>"><?=$grupo->nome;?></option>
                            <?
                                }
                            ?>
                    </select>
              </label>
            <div style="clear:both"></div>
            <!-- SELECT BAIRRO -->
              <label style="width:150px;">Bairro
                    <select name="bairro" id="bairro">
                        <option value="0">Todos</option>
                        <?
                            $sqlBairro=mysql_query(" SELECT Distinct(bairro) FROM eleitoral_eleitores WHERE vkt_id = '$vkt_id' ");
                                while($bairro=mysql_fetch_object($sqlBairro)){
                        ?>
                        <option value="<?=$bairro->bairro?>"><?=$bairro->bairro?></option>
                        <?
                                }
                        ?>
                    </select>
              </label>
      		<div style="clear:both"></div>
        		<?
                	$eleitores = mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS qtd FROM eleitoral_eleitores WHERE vkt_id = '$vkt_id'"));
					$politicos = mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS qtd FROM eleitoral_politicos WHERE vkt_id = '$vkt_id'"));
					$colaboradores = mysql_fetch_object(mysql_query(" SELECT COUNT(id) AS qtd FROM eleitoral_colaboradores WHERE vkt_id = '$vkt_id'"));
				?>
            <div>
                <input type="checkbox" name="eleitor" class="items" value="1" id="grupo">Eleitores
                <span style="float:right">N&ordm;: <?=$eleitores->qtd; ?></span>
            </div>
            
            <div>
            	<input type="checkbox" name="politico" class="items" value="2" id="grupo">Pol&iacute;ticos
                <span style="float:right">N&ordm;: <?=$politicos->qtd?></span>
            </div>
        	<div>
            	<input type="checkbox" name="colaborador" class="items" value="3" id="grupo">Colaboradores
                <span style="float:right">N&ordm;: <?=$colaboradores->qtd?></span>
            </div>
            
        </div>  		
	</fieldset>
	<fieldset id="campos_2" style="display:none">
     <legend>
        <a onclick="aba_form(this,0)" id="aba_envia"> Enviar SMS </a>
        <a id="aba_envia_unico"> <strong>Enviar &Uacute;nico</strong>   </a>
      </legend>
      <input type="hidden" name="cliente_id" id="cliente_id">
        <label style="width:285px;">Eleitor
        	<input type="text" name="eleitor" id="eleitor" busca="modulos/eleitoral/eleitores/busca_eleitor.php,@r0,@r0-value>eleitor|@r1-value>cliente_id|@r2-value>celular_unico,0">
        </label>
    	<div style="clear:both"></div>
        <label style="width:120px;">Celular
        	<input type="text" name="celular_unico" id="celular_unico" style="background:#F2F2F2; color:#999;" readonly >
        </label>
        <div style="clear:both"></div>
        <label>Mensagem 
  			<textarea name="msg_unica" id="msg_unica" cols="25" rows="5"><?=$sms_edit->msg?></textarea>
        </label>
</fieldset>
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<div id="resultSMS" style="position:relative;background:#28C15E; display:none; margin:2px; padding:0px;"></div>


<button type="button" style="float:right" id="enviaAdd">Enviar 1</button>
<button type="button" style="float:right; display:none;" id="enviaUnic">Enviar 2</button>
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>