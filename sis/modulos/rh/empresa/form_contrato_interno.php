	<form onsubmit="return validaForm(this)" class="form_float" method="post" id="form_contrato_interno" enctype="multipart/form-data" target="carregador" style="display:none">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<input id='tipo_cadastro' name="tipo_cadastro" type="hidden" value="<? if($cliente_fornecedor->id>0)echo $cliente_fornecedor->tipo_cadastro; else echo "Jurídico"; ?>" />
	<input name="cliente_fornecedor_id" type="hidden" value="<?=$cliente_fornecedor->cliente_fornecedor_id?>" id="cliente_fornecedor_id3"/>
		<fieldset  id='campos_1' <? if($cliente_fornecedor->tipo_cadastro=="Físico")echo 'style="display:none"'; ?> >
			<legend>
				<a class="form2">Jur&iacute;dico</a>
                <a class="form2">S&oacute;cios</a>
                <a class="form2">Contrato Social</a>
                <a class="form2"><strong>Contrato Interno</strong></a>
                <a class="form2">Documentos</a>
				<a class="form2">Requerimento de Empresários</a>
               
			</legend>
			<div id="form_contrato">         
            <!--<label style="width:200px;">
        	Modelo de Contrato:
			<select name="modelo_id" id="modelo_id">
            	<option value=''></option>
				<?php
					$modelos = mysql_query($t="SELECT * FROM odontologo_contrato_modelo WHERE vkt_id = '$vkt_id'"); 
					//alert($contrato->contrato_modelo_id);
					while($modelo = mysql_fetch_object($modelos)){
						if($modelo->id == $contrato->contrato_modelo_id){
							$selected="selected='selected'";
						}
						echo "<option value='$modelo->id' $selected>$modelo->nome</option>";
						$selected='';
					}
				?>
            </select>
		</label >
        
        <!--<label style="width:200px;">
        <?php
			$cliente = mysql_fetch_object(mysql_query($t="SELECT * FROM cliente_fornecedor WHERE id = '$contrato->cliente_id' AND cliente_vekttor_id='$vkt_id'"));
		//alert($t);
		?>
        	Cliente:
			<input type='text' name="cliente" id="cliente" value="<?=$cliente->razao_social?>" retorno="focus|Digite o Cliente" valida_minlength='3' busca='modulos/odonto/contrato/busca_cliente.php,@r1,@r0-value>cliente_id|@r1-value>cliente,0'>
            <input type='hidden' name="cliente_id" id="cliente_id" value="<?=$contrato->cliente_id?>">
		</label >
        
        <label style="width:200px;">
        	Descriçao:
			<input type='text' name="nome" id="nome" value="<?=$contrato->nome?>">
		</label >-->
               
           
                <div style="clear:both"></div>
                 <div style="clear:both"></div>
         
        <label style="width:40px">
<select name="select"class="in"style="margin-right:5px; w"onchange="ti('fontsize',this.options[this.selectedIndex].value)"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>  </select>
</label>

<a onclick="ti2('bold',null)" href="#" class='btf bold'></a>
<a onclick="ti2('italic',null)" href="#" class='btf italic'></a>
<a onclick="ti2('underline',null)" href="#" class='btf underline'></a>

<a onclick="ti2('justifyleft',null)" href="#" class='btf justifyleft'></a>
<a onclick="ti2('justifycenter',null)" href="#" class='btf justifycenter'></a>
<a onclick="ti2('justifyright',null)" href="#" class='btf justifyright'></a>
<a onclick="ti2('justifyfull',null)" href="#" class='btf justifyfull'></a>

<a onclick="ti2('insertunorderedlist',null)" href="#" class='btf insertunorderedlist'></a>
<a onclick="ti2('insertorderedlist',null)" href="#" class='btf insertorderedlist'></a>
<div style="float:right;margin-right:210px;">
<!--<button type="button" style="margin-top:2px; "  title="Imprime este contrato" id="salvar_contrato">
	<img src="modulos/odonto/atendimento/img/save.png" height="17"/>
</button>-->
			
</div>
<div style="clear:both"></div>
<div id="texto">
 <label style="display:none">
		<textarea name="texto" cols="25" rows="29" id="tx_html2"  >
		<?php
			echo $contrato_interno->contrato;
		?>



        </textarea>
              </label >

       <iframe id='ed2' name='ed2' width="75%" style="height:300px; background:#FFF;  overflow:scroll;float:left" onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('tx_html2').value;" frameborder="0"class="edtx"></iframe>
</div>
        
        
        
        
          <div id="esquerda" style="float:right;overflow:auto">
        	
            <a href="#" onclick="ti2('InsertHTML',this.innerHTML) "><strong>@contratante_razaosocial</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti2('InsertHTML',this.innerHTML) "><strong>@contratante_cnpj</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti2('InsertHTML',this.innerHTML) "><strong>@contratante_endereco</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti2('InsertHTML',this.innerHTML) "><strong>@contratante_nomecontato</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti2('InsertHTML',this.innerHTML) "><strong>@contratante_cpf</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti2('InsertHTML',this.innerHTML) "><strong>@contratante_rg</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti2('InsertHTML',this.innerHTML) "><strong>@contratado_razaosocial</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti2('InsertHTML',this.innerHTML) "><strong>@contratado_cnpj</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti2('InsertHTML',this.innerHTML) "><strong>@contratado_endereco</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti2('InsertHTML',this.innerHTML) "><strong>@contratado_nomecontato</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti2('InsertHTML',this.innerHTML) "><strong>@contratado_cpf</strong></a>
            <div style="clear:both"></div>
              <a href="#" onclick="ti2('InsertHTML',this.innerHTML) "><strong>@contratado_rg</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti2('InsertHTML',this.innerHTML) "><strong>@valor_mensalidade</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti2('InsertHTML',this.innerHTML) "><strong>@valor_implantacao</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti2('InsertHTML',this.innerHTML) "><strong>@dia_implantacao</strong></a>
        </div>
        
       
        	
         </div>
         
                <!--<table cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:200px;">Cliente</td>
                        <td style="width:400px;">Descricao</td>
                        <td style="width:60px;">Imprimir</td>
                        <td align="center">Editar</td>                        
                    </tr>
                 </thead>
                 </table>-->
                 <div style="max-height:65px;overflow:auto">
                 <!--<table id="dados_contratos" cellpadding="0" cellspacing="0" width="100%">
                  <tbody>
                 <?php
				 	//$atestados = mysql_query($t="SELECT * FROM odontologo_atestados WHERE vkt_id='$vkt_id' AND cliente_fornecedor_id='$cliente_fornecedor->id' AND odontologo_atendimento_id = $atendimento_id");
					//echo $t;
					//while($atestado = @mysql_fetch_object($atestados)){
					$contratos = mysql_query($t="SELECT * FROM odontologo_contrato_cliente WHERE cliente_id='".$cliente_fornecedor->id."'"); 	
				 	while($contrato = mysql_fetch_object($contratos)){
				 ?>
                 	<tr id_contrato="<?=$contrato->id?>">
                        <td style="width:200px;"><?=$cliente_fornecedor->razao_social?></td>
                        <td style="width:400px;"><?=$contrato->nome?></td>
                        <td style="width:60px;" align="center"><button type="button" class="print_contrato" style="margin-top:2px; "  title="Imprime este contrato">
	<img src="../fontes/img/imprimir.png" />
</button></td>    
                        <td align="center"><button type="button" class="editar_contrato" style="margin-top:2px; "  title="Imprime este contrato">
	<img src="modulos/odonto/atendimento/img/edit.png" height="17"/>
</button></td>      
                    </tr>
                  <?php
					}
				  ?>
                 </tbody>
                </table>-->
                </div>
                <input name="salva_formulario_contrato" type="hidden" value="interno" />
                 <input name="contrato_id" id="contrato_id_interno" type="hidden" value="<?=$contrato_interno->id?>" />
                        
		</fieldset>      
        
        
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($cliente_fornecedor_id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
    <input name="action" type="button" value="Imprimir" id="imprimir_interno" style="float:left" />
	<?
	}
	?>
	<!--<input name="action" type="submit"  value="Salvar" style="float:right"  />-->
    <input name="action" type="button" id='botao_salvar' onclick="html_to_form('ed2','tx_html2'); setTimeout('document.getElementById(\'form_contrato_interno\').submit();',500)"  value="Salvar" style="float:right"  />
    	<div style="clear:both"></div>
	</div>
</form>