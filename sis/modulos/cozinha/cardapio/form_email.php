<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
global $vkt_id;
?>
<script></script>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />

<div>
<div id='aSerCarregado'>
<div style="width:600px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
   
    <span>Enviar Email</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" id="form_email">
	<input type="hidden" name="filtro_inicio" id="filtro_inicio" value=<?=$_GET['filtro_inicio']?> />
	<input type="hidden" name="filtro_fim" id="filtro_fim" value=<?=$_GET['filtro_fim']?> />
    <!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Enviar Email</strong>
		</legend>
        <label style="width:300px;">
        	de:
			<input type='text' name="de" id="de" value="<?=$email->email_envio?>" retorno="focus|Digite o Nome ou Email do Remetente" valida_minlength='3'>
		</label >
        <label style="width:300px;">
        	Para:
			<input type='text' name="para" id="para" value="<?=$email->email_envio?>" retorno="focus|Digite o email do destinatário" valida_minlength='3'>
		</label >
                
        <div style="clear:both"></div>
		
        <label style="width:300px;">
        	Assunto:
			<input type='text' name="assunto" id="assunto" value="<?=$email->nome_envio?>" retorno="focus|Digite o Assunto do Email" valida_minlength='3'>
		</label >
        
        <div style="clear:both"></div>
        
        
        <div style="clear:both"></div>
        
        <label style="width:40px">
<select name="select"class="in"style="margin-right:5px" onchange="ti('fontsize',this.options[this.selectedIndex].value)"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>  </select>
</label>

<a onclick="ti('bold',null)" href="#" class='btf bold'></a>
<a onclick="ti('italic',null)" href="#" class='btf italic'></a>
<a onclick="ti('underline',null)" href="#" class='btf underline'></a>

<a onclick="ti('justifyleft',null)" href="#" class='btf justifyleft'></a>
<a onclick="ti('justifycenter',null)" href="#" class='btf justifycenter'></a>
<a onclick="ti('justifyright',null)" href="#" class='btf justifyright'></a>
<a onclick="ti('justifyfull',null)" href="#" class='btf justifyfull'></a>

<a onclick="ti('insertunorderedlist',null)" href="#" class='btf insertunorderedlist'></a>
<a onclick="ti('insertorderedlist',null)" href="#" class='btf insertorderedlist'></a>
<div style="clear:both"></div>
<div id="textarea_texto" style="display:none;width:100%">
        <label>
		<textarea name="texto" id="tx_html" cols="300" rows="25">
        <br><br><br><br><br>
        
       
	   </textarea>
              </label >
  		</div>
        
<div id="frame_texto">
       <iframe id='ed' name='ed' width="100%" style="height:300px; background:#FFF;  overflow:scroll;float:left"  onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('tx_html').value;" frameborder="0"class="edtx">
       </iframe>
</div>
       <div style="clear:both"></div>
		
         <div id="link_cardapio">
        	<a target="_blank" href="<?="http://vkt.srv.br/~nv/cardapio_palatare.php?vkt_id=".base64_encode($vkt_id)."&contrato_id=".base64_encode($_GET['contrato_id'])."&filtro_inicio=".base64_encode($_GET[filtro_inicio])."&filtro_fim=".base64_encode($_GET[filtro_fim])?>"> 
				Clique para ver o cardápio 
        	</a>
		</div>
    </fieldset>
    
    <input type="hidden" name="contrato_id" value="<?=$_GET[contrato_id]?>" />
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<!--<input name="action" type="submit"  value="Enviar" style="float:right"  />-->
<input name="salva_formulario_contrato_cliente" id="salva_formulario_contrato_cliente" type="hidden" value="1" />

<input name="action" type="button" id='botao_salvar' onclick="html_to_form(); setTimeout('document.getElementById(\'botao_salvar\').parentNode.parentNode.submit();',500);document.getElementById('form_email').setAttribute('target','')"  value="Enviar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>

</div>
</div>
</div>

<script>top.openForm()</script>