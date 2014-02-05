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
<div style="width:700px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Configuração de Cobrança</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" id="frmconfiguracao">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
		<input type='hidden' name="vkt_id" id="vkt_id" value="<?=$configuracao_cobranca->vkt_id?>">
	
   		<fieldset id="campos_0">
        	<legend>
             	 <a onclick="aba_form(this,0)"><strong>Dados do Banco</strong></a>
                 <a onclick="aba_form(this,1)">Email de Cobrança</a>
                 <a onclick="aba_form(this,2)">Email de Contas Vencidas</a>
                 <a onclick="aba_form(this,3)">SMS de Cobrança</a>
                 <a onclick="aba_form(this,4)">SMS de Contas Vencidas</a>
               
             </legend>
             <label style="width:100px;">
             	Banco:
                	<select name="banco" id="banco" valida_minlength="1" retorno="focus|Selecione um Banco">
<?
$qb= mysql_query("SELECT * FROM financeiro_contas WHERE cliente_vekttor_id='$vkt_id' order by preferencial DESC");
while($rb= mysql_fetch_object($qb)){
?>
						<option value="<?=$rb->id?>" <?php if($configuracao_cobranca->banco==$rb->id){ echo "selected='selected'";}?>><?=$rb->nome?></option>
<?
}
?>                   	</select>
             </label>            
             <div style="clear:both"></div>
             <label style="width:300px;">
             	Email de Envio:
                	<input type="text" name="email_envio" id="email_envio" value="<?=$configuracao_cobranca->email_envio?>" valida_minlength="1" retorno="focus|Digite o email de envio"> 	                  
             </label>
             
             <div style="clear:both"></div>
             
              <label style="width:300px;">
             	Nome de Envio:
                	<input type="text" name="nome_envio" id="nome_envio" value="<?=$configuracao_cobranca->nome_envio?>" valida_minlength="1" retorno="focus|Digite o nome de envio">
 	                  
             </label>
             
              <div style="clear:both"></div>
             
             <label style="width:110px;">
             	Multa por atraso
                	R$
                	<input type="text" name="multa_atraso" id="multa_atraso" value="<?php if(empty($configuracao_cobranca)){ echo '0,00';}else{echo moedaUsaToBr($configuracao_cobranca->multa_atraso);}?>" decimal="2" sonumero="1" style="text-align:right"> 	                  
             </label>
             
             <label style="width:110px;">
             	Mora Diária
                	 %
                	 <input type="text" name="mora_diaria" id="mora_diaria" value="<?php if(empty($configuracao_cobranca)){ echo '0,00';}else{echo moedaUsaToBr($configuracao_cobranca->mora_diaria);}?>" decimal="2" sonumero="1" style="text-align:right"> 	                  
             </label>
             
             <div style="clear:both"></div>
             
              <label style="width:300px">
             	Instrunções do Boleto
                	<textarea name="instruncoes_boleto" id="instruncoes_boleto" style="width:300px;height:100px;"><?php echo $configuracao_cobranca->instruncoes_boleto;?></textarea> 	                  
             </label>
             <div style="clear:both"></div>
             <span style="float:left">Enviar com</span>
             <label style="float:left;margin-left:12px; width:20px;">
            	 <input type="text" name="dias_antecedencia" id="dias_antecedencia" value="<?php if(empty($configuracao_cobranca)){ echo '1';}else{echo $configuracao_cobranca->dias_antecedencia;}?>" sonumero="1"/>
             </label>
             dia(s) de antecendência             
        </fieldset>
		
        <fieldset  id='campos_1' style="display:none">
				<legend>
                	<a onclick="aba_form(this,0)">Dados do Banco</a>
                 	<a onclick="aba_form(this,1)"><strong>Envio de Cobrança</strong></a>
                 	<a onclick="aba_form(this,2)">Contas Vencidas</a>   
                    <a onclick="aba_form(this,3)">SMS de Cobrança</a>
                 	<a onclick="aba_form(this,4)">SMS de Contas Vencidas</a>                                 
                </legend>
                
		<label>
		
        
        <div style="clear:both"></div>
		
             <label style="width:300px;">
        	Assunto:
			<input type='text' name="assunto_cobranca" id="assunto_cobranca" value="<?php echo $configuracao_cobranca->assunto_cobranca;?>" >
		</label >
                
        <div style="clear:both"></div>
        
        <textarea name="texto_envio_cobranca" id="texto_envio_cobranca" cols="300" rows="25" style="display:none">
         	<?php echo $configuracao_cobranca->texto_envio_cobranca;?>
	   	</textarea>
         </label >
         
        <div style="clear:both"></div>
         
        
        <label style="width:40px">
<select name="select"class="in"style="margin-right:5px" onchange="ti('fontsize',this.options[this.selectedIndex].value,'ed_texto_conbranca')"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>  </select>
</label>

<a onclick="ti('bold',null,'ed_texto_conbranca')" href="#" class='btf bold'></a>
<a onclick="ti('italic',null,'ed_texto_conbranca')" href="#" class='btf italic'></a>
<a onclick="ti('underline',null,'ed_texto_conbranca')" href="#" class='btf underline'></a>

<a onclick="ti('justifyleft',null,'ed_texto_conbranca')" href="#" class='btf justifyleft'></a>
<a onclick="ti('justifycenter',null,'ed_texto_conbranca')" href="#" class='btf justifycenter'></a>
<a onclick="ti('justifyright',null,'ed_texto_conbranca')" href="#" class='btf justifyright'></a>
<a onclick="ti('justifyfull',null,'ed_texto_conbranca')" href="#" class='btf justifyfull'></a>

<a onclick="ti('insertunorderedlist',null,'ed_texto_conbranca')" href="#" class='btf insertunorderedlist'></a>
<a onclick="ti('insertorderedlist',null,'ed_texto_conbranca')" href="#" class='btf insertorderedlist'></a>
<div style="clear:both"></div>
<div id="textarea_texto" style="display:none;width:100%">
        
  		</div>
        
<div id="frame_texto">
       <iframe id='ed_texto_conbranca' name='ed_texto_conbranca' width="70%" style="height:300px; background:#FFF;  overflow:scroll;float:left"  onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('texto_envio_cobranca').value;" frameborder="0"class="edtx">
       
       </iframe>
       <div id="esquerda" style="margin-left:20px;overflow:auto">
        	
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_texto_conbranca') "><strong>@valor</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_texto_conbranca') "><strong>@email_cliente</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_texto_conbranca') "><strong>@sacado_nome_cliente</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_texto_conbranca') "><strong>@codigo_linha_digitavel</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_texto_conbranca') "><strong>@data_vencimento</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_texto_conbranca') "><strong>@descricao_boleto</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_texto_conbranca') "><strong>@link_boleto</strong></a>
            <div style="clear:both"></div>
       </div>     
</div>
       <div style="clear:both"></div>

      			
		</fieldset>
        
        <fieldset  id='campos_2' style="display:none">
				<legend>
                	<a onclick="aba_form(this,0)">Dados do Banco</a>
                 	<a onclick="aba_form(this,1)">Envio de Cobrança</a>
                 	<a onclick="aba_form(this,2)"><strong>Contas Vencidas</strong></a> 
                    <a onclick="aba_form(this,3)">SMS de Cobrança</a>
                 	<a onclick="aba_form(this,4)">SMS de Contas Vencidas</a>                                     
                </legend>
                
              
                <label style="width:300px;">
        	Assunto:
			<input type='text' name="assunto_contas_vencidas" id="assunto_contas_vencidas" value="<?php echo $configuracao_cobranca->assunto_contas_vencidas;?>" >
		</label >
                
        <div style="clear:both"></div>
        
        <label style="width:40px">
<select name="select"class="in"style="margin-right:5px" onchange="ti('fontsize',this.options[this.selectedIndex].value,'ed_contas_vencidas')"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>  </select>
</label>

<a onclick="ti('bold',null,'ed_contas_vencidas')" href="#" class='btf bold'></a>
<a onclick="ti('italic',null,'ed_contas_vencidas')" href="#" class='btf italic'></a>
<a onclick="ti('underline',null,'ed_contas_vencidas')" href="#" class='btf underline'></a>

<a onclick="ti('justifyleft',null,'ed_contas_vencidas')" href="#" class='btf justifyleft'></a>
<a onclick="ti('justifycenter',null,'ed_contas_vencidas')" href="#" class='btf justifycenter'></a>
<a onclick="ti('justifyright',null,'ed_contas_vencidas')" href="#" class='btf justifyright'></a>
<a onclick="ti('justifyfull',null,'ed_contas_vencidas')" href="#" class='btf justifyfull'></a>

<a onclick="ti('insertunorderedlist',null,'ed_contas_vencidas')" href="#" class='btf insertunorderedlist'></a>
<a onclick="ti('insertorderedlist',null,'ed_contas_vencidas')" href="#" class='btf insertorderedlist'></a>
<div style="clear:both"></div>
<div id="textarea_texto" style="display:none;width:100%">
        <label>
		<textarea name="texto_contas_vencidas" id="texto_contas_vencidas" cols="300" rows="25">
         <?php echo $configuracao_cobranca->texto_contas_vencidas;?>
	   </textarea>
              </label >
  		</div>
        
<div id="frame_texto">
       <iframe id='ed_contas_vencidas' name='ed_contas_vencidas' width="70%" style="height:300px; background:#FFF;  overflow:scroll;float:left"  onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('texto_contas_vencidas').value;" frameborder="0"class="edtx">
       
       </iframe>
       <div id="esquerda" style="margin-left:20px;overflow:auto">
        	
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contas_vencidas') "><strong>@valor</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contas_vencidas') "><strong>@email_cliente</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contas_vencidas') "><strong>@sacado_email_cliente</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contas_vencidas') "><strong>@codigo_linha_digitavel</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contas_vencidas') "><strong>@data_vencimento</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contas_vencidas') "><strong>@descricao_boleto</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML,'ed_contas_vencidas') "><strong>@link_boleto</strong></a>
            <div style="clear:both"></div>            
       </div>     
</div>
       <div style="clear:both"></div>
                
		</fieldset>
       <fieldset  id='campos_3' style="display:none">
				<legend>
                	<a onclick="aba_form(this,0)">Dados do Banco</a>
                 	<a onclick="aba_form(this,1)">Envio de Cobrança</a>
                 	<a onclick="aba_form(this,2)">Contas Vencidas</a> 
                    <a onclick="aba_form(this,3)"><strong>SMS de Cobrança</strong></a>
                 	<a onclick="aba_form(this,4)">SMS de Contas Vencidas</a>                                     
                </legend>
              	<div style="clear:both"></div>
                <textarea name="sms_envio_cobranca" id="sms_envio_cobranca" rows="15" style="width:70%">
         			<?php echo $configuracao_cobranca->sms_envio_cobranca;?>
	   			</textarea>
		</fieldset>
        <fieldset  id='campos_4' style="display:none">
				<legend>
                	<a onclick="aba_form(this,0)">Dados do Banco</a>
                 	<a onclick="aba_form(this,1)">Envio de Cobrança</a>
                 	<a onclick="aba_form(this,2)">Contas Vencidas</a> 
                    <a onclick="aba_form(this,3)">SMS de Cobrança</a>
                 	<a onclick="aba_form(this,4)"><strong>SMS de Contas Vencidas</strong></a>                                     
                </legend>
              	<div style="clear:both"></div>
                <textarea name="sms_contas_vencidas" id="sms_contas_vencidas" rows="15" style="width:70%">
         			<?php echo $configuracao_cobranca->sms_contas_vencidas;?>
	   			</textarea>
		</fieldset> 
		<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	
	<input name="action" type="button" id='botao_salvar'  value="Salvar" style="float:right"  />
	<input name="salva_formulario_contrato_cliente" type="hidden" value="1" />    
    
	<div style="clear:both"></div>
	</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>