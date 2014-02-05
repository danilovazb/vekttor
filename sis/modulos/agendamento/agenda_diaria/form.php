<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Compromisso</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
  
    <input type="hidden" name="id"  value="<?=$agendamento->id?>" />
	<fieldset  id='campos_1'>
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
        <div style="clear:both; padding-top:5px;"></div>
		<label style="width:262px;">Cliente
        	<input type="text" name="cliente_razao" id="cliente_razao" value="<?php echo $cliente->nome_fantasia;?>" autocomplete="off" busca="modulos/agendamento/agenda_diaria/busca_cliente2.php,@r1,@r0-value>cliente_id|@r1-value>cliente_razao,0">
            <input type="hidden" name="cliente_id" id="cliente_id" value="<?php echo $cliente->id;?>">
        </label>
        <label style="width:32px;"><br/>
          	<button type="button" name="cad_cliente"  id="cad_cliente" title="Cadastro de Clientes" data-placement="left"  rel="tip" ><img  src="../fontes/img/adm.png" ></button>
        </label>
            <!-- modal -->
           <div style="position:absolute; left:133px; margin-top:50px;">
              <div class="modal" style="display:none">
              <div class="modal-header-2">
              	<a href="#" style="color:#CCC; font-weight:bold; float:right;" class="modal_close">x</a>
                <span>Cadastro de Cliente</span>
              </div>
                    <div class="modal-body">
                    	<p>
                        	<div class="atl_natureza" style="padding:3px;">
                            	<div style="float:left"><input type="radio" name="natureza" id="cpf" value="1" style="width:20px;">CPF</div>
                            	<div><input type="radio" name="natureza" id="cnpj" value="2" style="width:20px;">CNPJ</div>
                            </div>
                            <div style="clear:both;"></div>
                        	<div style=" float:left;"><label style="width:175px;">Nome<br/><input type="text" name="atl_nome" id="atl_nome" style="height:15px;" disabled="disabled"></label></div>
                            <div><label style="width:120px;">CNPJ/CPF <br/><input type="text" name="atl_cnpf_cpf" id="atl_cnpf_cpf" style="height:15px;" disabled="disabled"></label></div>      
                         </p>
                         <!--<button type="button" name="atl_cadastrar" id="atl_cadastrar" disabled="disabled" style="margin-top:8px;" >cadastrar</button>-->
                          <div><small style=" color:#999999; font-size:11px;">ap&oacute;s cadastro v&aacute; para tela cliente para completar as informa&ccedil;&otilde;es </small></div>
                    </div>
              <div class="modal-footer">
              	<!--<div style="padding:3px;"><span>ap&oacute;s o cadastro vá para tela cliente</span></div>999999-->
                <button type="button" name="atl_cadastrar" id="atl_cadastrar" disabled="disabled" >cadastrar</button>
               
              </div>
			</div>
    		</div>
        	<!-- fim modal -->
        <div style="clear:both"></div>
        <input type="hidden" name="agenda_id" id="agenda_id" value="<?=$agenda_id?>">
      
        <label style="width:311px;">Evento
          <textarea name="evento" id="evento"><?=$agendamento->nota_adicional;?></textarea>
		</label>
        <label style="width:80px;">Data Inicio
        	<input type="text" name="data_inicio" id="data_inicio" value="<?php if($data_inicio){ echo dataUsaToBr($data_inicio); } else { echo $dataEvento;} ?>">
        </label>
        <label style="width:65px;">Hora Inicio
        	<input type="text" name="hora_inicio" maxlength="5" id="hora_inicio" value="<?php if($hora_inicio){ echo substr($hora_inicio,0,5);} else{echo $hora_inicial;}?>">
        </label>
        <div style="clear:both;"></div>
        <label style="width:80px;">Data Fim
           <input type="text" name="data_fim" id="data_fim"  value="<?php if($data_fim){ echo  dataUsaToBr($data_fim);}else{echo $dataFinal;}?>">
        </label>
        <label style="width:58px;">Hora Fim
        	<input type="text" name="hora_fim" id="hora_fim"  value="<? if($hora_fim) {echo substr($hora_fim,0,5); } else {echo $hora_final;}?>">
        </label>
	</fieldset>
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($agendamento->id > 0){
?>
<!--<input name="button" type="button" value="Excluir" id="excluir_evento" style="float:left" />-->
<input name="action" type="submit" value="Excluir" style="float:left" />
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