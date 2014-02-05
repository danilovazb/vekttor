<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
$cliente = mysql_fetch_object(mysql_query("SELECT * FROM clientes_vekttor WHERE id='$vkt_id'"));
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div style="width:810px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Configuração de Relacionamento</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" id="frmconfiguracao">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
		<input type='hidden' name="id" id="id" value="<?=$configuracao_relacionamento->vkt_id?>">
	
   		<fieldset id="campos_0">
        	<legend>
             	 <a onclick="aba_form(this,0)"><strong>Configuração</strong></a>
                 <a onclick="aba_form(this,1)">Email Agendamento</a>
                 <a onclick="aba_form(this,2)">SMS Agendamento</a>
                 <a onclick="aba_form(this,3)">Email Aniversariante</a>
                 <a onclick="aba_form(this,4)">SMS Aniversariante</a>
                 <a onclick="aba_form(this,5)">Email Visita</a>
                 <a onclick="aba_form(this,6)">SMS Visita</a>
                                          
             </legend>
              <?php 
			 	if($configuracao_relacionamento->email_visita=='sim'){ $display="block";}else{$display="none";}
			 ?>
             <ul>
             <li>
             	Avisos de Agendamento
                	<ul style="list-style:none">
                    	<li>
                        	<input type="checkbox" name="email_agendamento" id="email_agendamento" <?php if($configuracao_relacionamento->email_agendamento=='sim'){ echo "checked='checked'";}?>/>Enviar Email Automaticamente
                        </li>
                        <li><input type="checkbox" name="sms_agendamento" id="sms_agendamento" <?php if($configuracao_relacionamento->sms_agendamento=='sim'){ echo "checked='checked'";}?>/>Enviar SMS Automaticamente</li>
                    </ul>
             </li>
             <li>
             	Lembrete de Aniversariantes
                	<ul style="list-style:none">
                    	<li>
                        	<input type="checkbox" name="email_aniversario" id="email_aniversario" <?php if($configuracao_relacionamento->email_aniversario=='sim'){ echo "checked='checked'";}?>/>Enviar Email Automaticamente
                        </li>
              			               
             			<li>
                         	
                        	<input type="checkbox" name="sms_aniversario" id="sms_aniversario" <?php if($configuracao_relacionamento->sms_aniversario=='sim'){ echo "checked='checked'";}?>/>
                        	Enviar SMS Automaticamente
                        	
                        </li>
                    </ul>
             </li>
             <li>
             	Lembrete de Visita
                	<ul style="list-style:none">
                    	<li>
                        <div style="float:left">
                        <input type="checkbox" name="email_visita" id="email_visita" <?php if($configuracao_relacionamento->email_visita=='sim'){ echo "checked='checked'";}?>/>
                        Enviar Email Automaticamente (A cada</div> 
                			<label style="float:left;width:30px;">
                				<input type="text" style="height:10px;margin-top:2px;margin-left:4px;" name="dias_envio_email_visita" id="dias_envio_email_visita" sonumero="1" value="<? if(empty($configuracao_relacionamento->dias_envio_email_visita)){echo 60;}else{ echo $configuracao_relacionamento->dias_envio_email_visita;}?>" />
             				</label>
                			dias)
                        </li>
                        <li>
                        <div style="clear:both"></div>
                        <div style="float:left;margin-top:-10px;">
                        <input type="checkbox" name="sms_visita" id="sms_visita" <?php if($configuracao_relacionamento->sms_visita=='sim'){ echo "checked='checked'";}?>/>
                        Enviar SMS Automaticamente (A cada</div> 
                			<label style="float:left;width:30px;margin-top:-10px;">
                				<input type="text" style="height:10px;margin-top:2px;margin-left:4px;" name="dias_envio_sms_visita" id="dias_envio_sms_visita" sonumero="1" value="<? if(empty($configuracao_relacionamento->dias_envio_sms_visita)){echo 60;}else{ echo $configuracao_relacionamento->dias_envio_sms_visita;}?>" />
             				</label>
                			<div style="float:left;margin-top:-10px;">dias)</div>
                        </li>
                    </ul>
             </li>
             <div style="clear:both"></div>
            
                          
        </fieldset>
		
        <fieldset  id='campos_1' style="display:none">
				<legend>
                	<a onclick="aba_form(this,0)">Configuração</a>
                    <a onclick="aba_form(this,1)"><strong>Email Agendamento</strong></a>
                    <a onclick="aba_form(this,2)">SMS Agendamento</a>
                    <a onclick="aba_form(this,3)">Email Aniversariante</a>
                    <a onclick="aba_form(this,4)">SMS Aniversariante</a>
                 	<a onclick="aba_form(this,5)">Email Visita</a>
                    <a onclick="aba_form(this,6)">SMS Visita</a>                                     
                </legend>
                <?php
					if(empty($configuracao_relacionamento->vkt_id)){
						$mensagem_email_agendamento = "
						Foi agendado uma consulta para o dia @dia/@mes/@ano @semana às @hora:@minuto 
						<br>
						no consultorio do @nome_agenda
					    <br>
						Atenciosamente,
						<br>
						$cliente->nome						
						";
					}else{
						$mensagem_email_agendamento = $configuracao_relacionamento->texto_email_agendamento;
					}
				?>
				<label style="width:300px;">
        	de:
			<input type='text' name="de_email_agendamento" id="de_email_agendamento" value="<?=$configuracao_relacionamento->de_email_agendamento?>" >
		</label >
                        
        <div style="clear:both"></div>
		
        <label style="width:300px;">
        	Assunto:
			<input type='text' name="assunto_email_agendamento" id="assunto_email_agendamento" value="<?=$configuracao_relacionamento->assunto_email_agendamento?>" >
		</label >
        
        <div style="clear:both"></div>
        
        
        <div style="clear:both"></div>
        
        <label style="width:40px">
<select name="select"class="in"style="margin-right:5px" onchange="ti('fontsize',this.options[this.selectedIndex].value,'ed_email_agendamento')"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>  </select>
</label>

<a onclick="ti('bold',null,'ed_email_agendamento')" href="#" class='btf bold'></a>
<a onclick="ti('italic',null,'ed_email_agendamento')" href="#" class='btf italic'></a>
<a onclick="ti('underline',null,'ed_email_agendamento')" href="#" class='btf underline'></a>

<a onclick="ti('justifyleft',null,'ed_email_agendamento')" href="#" class='btf justifyleft'></a>
<a onclick="ti('justifycenter',null,'ed_email_agendamento')" href="#" class='btf justifycenter'></a>
<a onclick="ti('justifyright',null,'ed_email_agendamento')" href="#" class='btf justifyright'></a>
<a onclick="ti('justifyfull',null,'ed_email_agendamento')" href="#" class='btf justifyfull'></a>

<a onclick="ti('insertunorderedlist',null,'ed_email_agendamento')" href="#" class='btf insertunorderedlist'></a>
<a onclick="ti('insertorderedlist',null,'ed_email_agendamento')" href="#" class='btf insertorderedlist'></a>
<div style="clear:both"></div>
<div id="textarea_texto" style="display:none;width:100%">
        <label>
		<textarea name="texto_email_agendamento" id="texto_email_agendamento" cols="300" rows="25">
         <?=$mensagem_email_agendamento?>
	   </textarea>
              </label >
  		</div>
        
<div id="frame_texto">
       <iframe id='ed_email_agendamento' name='ed_email_agendamento' width="100%" style="height:300px; background:#FFF;  overflow:scroll;float:left"  onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('texto_email_agendamento').value;" frameborder="0"class="edtx">
       </iframe>
</div>
       <div style="clear:both"></div>
		
      			
		</fieldset>
        
        <fieldset  id='campos_2' style="display:none">
				<legend>
                	<a onclick="aba_form(this,0)">Configuração</a>
                	<a onclick="aba_form(this,1)">Email Agendamento</a>
                    <a onclick="aba_form(this,2)"><strong>SMS Agendamento</strong></a>
                    <a onclick="aba_form(this,3)">Email Aniversariante</a>
                    <a onclick="aba_form(this,4)">SMS Aniversariante</a>
                 	<a onclick="aba_form(this,5)">Email Visita</a>
                    <a onclick="aba_form(this,6)">SMS Visita</a>                                      
                </legend>
                
              
                <label>
                	Mensagem
                	<textarea name="texto_sms_mensagem" cols="40" rows="10"><?=$configuracao_relacionamento->texto_sms_mensagem?></textarea>                   
                </label>
                
		</fieldset>
        <fieldset  id='campos_3' style="display:none">
				<legend>
                	<a onclick="aba_form(this,0)">Configuração</a>
                	<a onclick="aba_form(this,1)">Email Agendamento</a>
                    <a onclick="aba_form(this,2)">SMS Agendamento</a>
                    <a onclick="aba_form(this,3)"><strong>Email Aniversariante</strong></a>
                    <a onclick="aba_form(this,4)">SMS Aniversariante</a>
                 	<a onclick="aba_form(this,5)">Email Visita</a>
                    <a onclick="aba_form(this,6)">SMS Visita</a>                                       
                </legend>
                <?php
					if(empty($configuracao_relacionamento->vkt_id)){
						$mensagem_email_aniversariante = "
						Parabéns pelo seu aniversário querido @paciente.
						<br>
						Desejamos a você paz, saúde e felicidade.
					    <br>
						Atenciosamente,
						<br>
						$cliente->nome						
						";
					}else{
						$mensagem_email_aniversariante = $configuracao_relacionamento->texto_email_aniversariante;
					}
				?>
				<label style="width:300px;">
        	de:
			<input type='text' name="de_email_aniversariante" id="de_email_aniversariante" value="<?=$configuracao_relacionamento->de_email_aniversariante?>" >
		</label >
                        
        <div style="clear:both"></div>
		
        <label style="width:300px;">
        	Assunto:
			<input type='text' name="assunto_email_aniversariante" id="assunto_email_aniversariante" value="<?=$configuracao_relacionamento->assunto_email_aniversariante?>" >
		</label >
        
        <div style="clear:both"></div>
        
        
        <div style="clear:both"></div>
        
        <label style="width:40px">
<select name="select"class="in"style="margin-right:5px" onchange="ti('fontsize',this.options[this.selectedIndex].value,'ed_email_aniversariante')"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>  </select>
</label>

<a onclick="ti('bold',null,'ed_email_aniversariante')" href="#" class='btf bold'></a>
<a onclick="ti('italic',null,'ed_email_aniversariante')" href="#" class='btf italic'></a>
<a onclick="ti('underline',null,'ed_email_aniversariante')" href="#" class='btf underline'></a>

<a onclick="ti('justifyleft',null,'ed_email_aniversariante')" href="#" class='btf justifyleft'></a>
<a onclick="ti('justifycenter',null,'ed_email_aniversariante')" href="#" class='btf justifycenter'></a>
<a onclick="ti('justifyright',null,'ed_email_aniversariante')" href="#" class='btf justifyright'></a>
<a onclick="ti('justifyfull',null,'ed_email_aniversariante')" href="#" class='btf justifyfull'></a>

<a onclick="ti('insertunorderedlist',null,'ed_email_aniversariante')" href="#" class='btf insertunorderedlist'></a>
<a onclick="ti('insertorderedlist',null,'ed_email_aniversariante')" href="#" class='btf insertorderedlist'></a>
<div style="clear:both"></div>
<div id="textarea_texto" style="display:none;width:100%">
        <label>
		<textarea name="texto_email_aniversariante" id="texto_email_aniversariante" cols="300" rows="25">
        <?=$mensagem_email_aniversariante?>
       
	   </textarea>
              </label >
  		</div>
        
<div id="frame_texto">
       <iframe id='ed_email_aniversariante' name='ed_email_aniversariante' width="100%" style="height:300px; background:#FFF;  overflow:scroll;float:left"  onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('texto_email_aniversariante').value;" frameborder="0"class="edtx">
       </iframe>
</div>
       <div style="clear:both"></div>
		
      			
		</fieldset>
        
         <fieldset  id='campos_4' style="display:none">
				<legend>
                	<a onclick="aba_form(this,0)">Configuração</a>
                	<a onclick="aba_form(this,1)">Email Agendamento</a>
                    <a onclick="aba_form(this,2)">SMS Agendamento</a>
                    <a onclick="aba_form(this,3)">Email Aniversariante</a>
                    <a onclick="aba_form(this,4)"><strong>SMS Aniversariante</strong></a>
                 	<a onclick="aba_form(this,5)">Email Visita</a>
                    <a onclick="aba_form(this,6)">SMS Visita</a>                                      
                </legend>
                
                <div style="clear:both"></div>
                <label>
                	Mensagem
                	<textarea name="texto_sms_aniversario" cols="40" rows="10"><?=$configuracao_relacionamento->texto_sms_aniversario?></textarea>                   
                </label>
                
		</fieldset>
        <fieldset  id='campos_5' style="display:none">
				<legend>
                	<a onclick="aba_form(this,0)">Configuração</a>
                	<a onclick="aba_form(this,1)">Email Agendamento</a>
                    <a onclick="aba_form(this,2)">SMS Agendamento</a>
                    <a onclick="aba_form(this,3)">Email Aniversariante</a>
                    <a onclick="aba_form(this,4)">SMS Aniversariante</a>
                 	<a onclick="aba_form(this,5)"><strong>Email Visita</strong></a>
                    <a onclick="aba_form(this,6)">SMS Visita</a>                                       
                </legend>
                <?php
                if(empty($configuracao_relacionamento->vkt_id)){
						$mensagem_email_visita = "
						
						Olá @paciente, notamos que você não vai ao nosso consultório
						<br>
						há @dias, esperamos vê-lo em breve para continuar cuidando de
						<br>
						sua saúde bucal.
						Atenciosamente,
						$cliente->nome						
						";
					}else{
						$mensagem_email_visita = $configuracao_relacionamento->texto_email_visita;
					}
					?>
				<label style="width:300px;">
        	de:
			<input type='text' name="de_email_visita" id="de_email_visita" value="<?=$configuracao_relacionamento->de_email_visita?>" >
		</label >
                        
        <div style="clear:both"></div>
		
        <label style="width:300px;">
        	Assunto:
			<input type='text' name="assunto_email_visita" id="assunto_email_visita" value="<?=$configuracao_relacionamento->assunto_email_visita?>">
		</label >
        
        <div style="clear:both"></div>
        
        
        <div style="clear:both"></div>
        
        <label style="width:40px">
<select name="select"class="in"style="margin-right:5px" onchange="ti('fontsize',this.options[this.selectedIndex].value,'ed_email_visita')"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>  </select>
</label>

<a onclick="ti('bold',null,'ed_email_visita')" href="#" class='btf bold'></a>
<a onclick="ti('italic',null,'ed_email_visita')" href="#" class='btf italic'></a>
<a onclick="ti('underline',null,'ed_email_visita')" href="#" class='btf underline'></a>

<a onclick="ti('justifyleft',null,'ed_email_visita')" href="#" class='btf justifyleft'></a>
<a onclick="ti('justifycenter',null,'ed_email_visita')" href="#" class='btf justifycenter'></a>
<a onclick="ti('justifyright',null,'ed_email_visita')" href="#" class='btf justifyright'></a>
<a onclick="ti('justifyfull',null,'ed_email_visita')" href="#" class='btf justifyfull'></a>

<a onclick="ti('insertunorderedlist',null)" href="#" class='btf insertunorderedlist'></a>
<a onclick="ti('insertorderedlist',null)" href="#" class='btf insertorderedlist'></a>
<div style="clear:both"></div>
<div id="textarea_texto" style="display:none;width:100%">
        <label>
		<textarea name="texto_email_visita" id="texto_email_visita" cols="300" rows="25">
        <?=$mensagem_email_visita?>
       
	   </textarea>
              </label >
  		</div>
        
<div id="frame_texto">
       <iframe id='ed_email_visita' name='ed_email_visita' width="100%" style="height:300px; background:#FFF;  overflow:scroll;float:left"  onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('texto_email_visita').value;" frameborder="0"class="edtx">
       </iframe>
</div>
       <div style="clear:both"></div>
		
      			
		</fieldset>
         <fieldset  id='campos_6' style="display:none">
				<legend>
                	<a onclick="aba_form(this,0)">Configuração</a>
                	<a onclick="aba_form(this,1)">Email Agendamento</a>
                    <a onclick="aba_form(this,2)">SMS Agendamento</a>
                    <a onclick="aba_form(this,3)">Email Aniversariante</a>
                    <a onclick="aba_form(this,4)">SMS Aniversariante</a>
                 	<a onclick="aba_form(this,5)">Email Visita</a>
                    <a onclick="aba_form(this,6)"><strong>SMS Visita</strong></a>                                      
                </legend>
                
                <div style="clear:both"></div>
                <label>
                	Mensagem
                	<textarea name="texto_sms_visita" cols="40" rows="10"><?=$configuracao_relacionamento->texto_sms_visita?></textarea>                   
                </label>
                
		</fieldset>
		<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	
	<input name="action" type="button" id='botao_salvar' onclick="retorno = validaForm(frmconfiguracao);if(retorno!=false){html_to_form(); setTimeout('document.getElementById(\'botao_salvar\').parentNode.parentNode.submit();',500)}"  value="Salvar" style="float:right"  />
	<input name="salva_formulario_contrato_cliente" type="hidden" value="1" />    
    
	<div style="clear:both"></div>
	</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>