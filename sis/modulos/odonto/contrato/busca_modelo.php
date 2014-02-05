<?php
include('../../../_config.php');
include('../../../_functions_base.php');

global $vkt_id;

$id = $_POST['modelo_id'];
//$a = $_POST['acao'];
if($_POST['acao']=='inativa_contrato'){
	mysql_query($t="UPDATE odontologo_contrato_cliente SET status='0' WHERE id='$id'");
	alert($t);

}
if($_POST['acao']=='busca_modelo'){
	$modelo = @mysql_fetch_object(mysql_query("SELECT * FROM odontologo_contrato_modelo WHERE id=".$id));
	echo utf8_encode($modelo->contrato);
}
if($_POST['acao']=='busca_contrato'){
	$modelo = @mysql_fetch_object(mysql_query($t="SELECT * FROM  odontologo_contrato_cliente WHERE id=".$id));
	
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
<select name='select'class='in'style='margin-right:5px; w'onchange=\"ti('fontsize',this.options[this.selectedIndex].value,'ed_contrato')\"><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option>  </select>
</label>

<a onclick=\"ti('bold',null,'ed_contrato')\" href='#' class='btf bold'></a>
<a onclick=\"ti('italic',null,'ed_contrato')\" href='#' class='btf italic'></a>
<a onclick=\"ti('undeline',null,'ed_contrato')\" href='#' class='btf underline'></a>

<a onclick=\"ti('justifyleft',null,'ed_contrato')\" href='#' class='btf justifyleft'></a>
<a onclick=\"ti('justifycenter',null,'ed_contrato')\" href='#' class='btf justifycenter'></a>
<a onclick=\"ti('justifyright',null,'ed_contrato')\" href='#' class='btf justifyright'></a>
<a onclick=\"ti('justifyfull',null,'ed_contrato')\" href='#' class='btf justifyfull'></a>

<a onclick='ti('insertunorderedlist',null,'ed_contrato')' href='#' class='btf insertunorderedlist'></a>
<a onclick='ti('insertorderedlist',null,'ed_contrato')' href='#' class='btf insertorderedlist'></a>
<div style='float:right;margin-right:210px;'>
<button type='button' style='margin-top:2px;'  title='Salva as altera&ccedil;&otilde;es feitas neste contrato' id='salvar_contrato'>
	<img src='modulos/odonto/atendimento/img/save.png' height='17'/>
</button>
<button type='button' style='margin-top:2px;'  title='".utf8_encode('Começar novo contrato')."' id='novo_contrato'>
	<img src='modulos/odonto/atendimento/img/file.png' height='17'/>
</button>
<button type='button' style='margin-top:2px;'  title='Exclui este contrato' id='cancelar_edicao_contrato'>
	<img src='modulos/odonto/atendimento/img/cancel.png' height='17'/>
</button>
			
</div>

<div style='clear:both'></div>
<div id='texto'>
 <label style='display:none'>
		<textarea name='tx_contrato' cols='25' rows='29' id='tx_contrato'  >
		".utf8_encode($modelo->html_contrato)."
		</textarea>
              </label >

       <iframe id='ed_contrato' name='ed_contrato' width='75%' style='height:300px; background:#FFF;  overflow:scroll;float:left' frameborder='0' class='edtx' onload=\"this.contentWindow.document.designMode='on';this.contentWindow.document.body.innerHTML=document.getElementById('tx_contrato').value; \"></iframe>
</div>
        
        
        
        
          <div id='esquerda' style='float:right;overflow:auto'>
        	
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML,'ed_contrato') \"><strong>@contratante_razaosocial</strong></a>
        	<div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML,'ed_contrato') \"><strong>@contratante_cnpj</strong></a>
        	<div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML,'ed_contrato') \"><strong>@contratante_endereco</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML,'ed_contrato') \"><strong>@contratante_nomecontato</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML,'ed_contrato') \"'><strong>@contratante_cpf</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML,'ed_contrato') \"><strong>@contratante_rg</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML,'ed_contrato') \"><strong>@contratado_razaosocial</strong></a>
        	<div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML,'ed_contrato') \"><strong>@contratado_cnpj</strong></a>
        	<div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML,'ed_contrato') \"><strong>@contratado_endereco</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML,'ed_contrato') \"><strong>@contratado_nomecontato</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML,'ed_contrato') \"><strong>@contratado_cpf</strong></a>
            <div style='clear:both'></div>
              <a href='#' onclick=\"ti('InsertHTML',this.innerHTML,'ed_contrato') \"><strong>@contratado_rg</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML,'ed_contrato') \"><strong>@valor_mensalidade</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML,'ed_contrato') \"><strong>@valor_implantacao</strong></a>
            <div style='clear:both'></div>
            <a href='#' onclick=\"ti('InsertHTML',this.innerHTML,'ed_contrato') \"><strong>@dia_implantacao</strong></a>
        </div>";
		echo "<div style='margin-top:65px;float:right;'>
			<input type='hidden' name='contrato_id' value='$modelo->id' id='contrato_id'/>
		</div>";
}
//echo $t;
?>