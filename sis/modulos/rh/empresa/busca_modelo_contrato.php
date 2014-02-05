<?php
include('../../../_config.php');
include('../../../_functions_base.php');

global $vkt_id;

$id = $_POST['modelo_id'];
//$a = $_POST['acao'];

if($_POST['acao']=='busca_modelo'){
	$modelo = @mysql_fetch_object(mysql_query("SELECT * FROM odontologo_contrato_modelo WHERE id=".$id));
	echo utf8_encode($modelo->contrato);
}
if($_POST['acao']=='busca_contrato'){
	$modelo = @mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_contrato_cliente WHERE id=".$id));
	
	$texto_contrato = utf8_encode($modelo->html_contrato);	
		
	
	$modelos = mysql_query($t="SELECT * FROM odontologo_contrato_modelo WHERE vkt_id = $vkt_id"); 
	$cliente = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id = '$modelo->cliente_id' AND cliente_vekttor_id='$vkt_id'"));
	
	echo "<label style='width:200px;'>
        	Modelo de Contrato:
			<select name='modelo_id' id='modelo_id'>
            	<option value=''></option>					
	";				
	while($model = mysql_fetch_object($modelos)){
						
						
						
						if($model->id == $modelo->contrato_modelo_id){
							$selected="selected='selected'";
						}
						//alert($selected);
						echo "<option value='$model->id' $selected>".utf8_encode($model->nome)."</option>";
						$selected='';
	}
	
	
			
    echo "  </select>
		</label >
        
        
        
        <label style='width:200px;'>
        	Descricao:
			<input type='text' name='nome' id='nome' value='".$modelo->nome."'>
		</label >
          <label style='margin-left:40px;margin-top:18px;'>                
               
                </label>      
           
                <div style='clear:both'></div>
                 <div style='clear:both'></div>
         
        <label style='width:40px'>
<select name='select'class='in'style='margin-right:5px; w'onchange=\"ti('fontsize',this.options[this.selectedIndex].value)\"><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option>  </select>
</label>

<a onclick=\"ti('bold',null)\" href='#' class='btf bold'></a>
<a onclick=\"ti('italic',null)\" href='#' class='btf italic'></a>
<a onclick=\"ti('undeline',null)\" href='#' class='btf underline'></a>

<a onclick=\"ti('justifyleft',null)\" href='#' class='btf justifyleft'></a>
<a onclick=\"ti('justifycenter',null)\" href='#' class='btf justifycenter'></a>
<a onclick=\"ti('justifyright',null)\" href='#' class='btf justifyright'></a>
<a onclick=\"ti('justifyfull',null)\" href='#' class='btf justifyfull'></a>

<a onclick='ti('insertunorderedlist',null)' href='#' class='btf insertunorderedlist'></a>
<a onclick='ti('insertorderedlist',null)' href='#' class='btf insertorderedlist'></a>
<div style='float:right;margin-right:210px;'>
<button type='button' style='margin-top:2px;'  title='Salva as altera&ccedil;&otilde;es feitas neste contrato' id='salvar_contrato'>
	<img src='modulos/odonto/atendimento/img/save.png' height='17'/>
</button>
<button type='button' style='margin-top:2px;'  title='Cancela a edi&ccedil;&atilde;o atual deste contrato' id='cancelar_edicao_contrato'>
	<img src='modulos/odonto/atendimento/img/cancel.png' height='17'/>
</button>
			
</div>

<div style='clear:both'></div>
<div id='texto'>
 <label style='display:none'>
		<textarea name='texto' cols='25' rows='29' id='tx_html'  >

		".utf8_encode($modelo->html_contrato)."
		


        </textarea>
              </label >

       <iframe id='ed' name='ed' width='75%' style='height:300px; background:#FFF;  overflow:scroll;float:left' frameborder='0' class='edtx' onload=\"this.contentWindow.document.designMode='on';this.contentWindow.document.body.innerHTML=document.getElementById('tx_html').value; \"></iframe>
</div>
        
        
        
        
          <div id='esquerda' style='float:right;overflow:auto'>
        	
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML) \"><strong>@contratante_razaosocial</strong></a>
        	<div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML) \"><strong>@contratante_cnpj</strong></a>
        	<div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML) \"><strong>@contratante_endereco</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML) \"><strong>@contratante_nomecontato</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML) \"'><strong>@contratante_cpf</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML) \"><strong>@contratante_rg</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML) \"><strong>@contratado_razaosocial</strong></a>
        	<div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML) \"><strong>@contratado_cnpj</strong></a>
        	<div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML) \"><strong>@contratado_endereco</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML) \"><strong>@contratado_nomecontato</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML) \"><strong>@contratado_cpf</strong></a>
            <div style='clear:both'></div>
              <a href='#' onclick=\"ti('InsertHTML',this.innerHTML) \"><strong>@contratado_rg</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML) \"><strong>@valor_mensalidade</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML) \"><strong>@valor_implantacao</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML) \"><strong>@dia_implantacao</strong></a>
        </div>";
		echo "<div style='margin-top:65px;float:right;'>
			<input type='hidden' name='contrato_id' value='$modelo->id' id='contrato_id'/>
		</div>";
}
//echo $t;
?>