<label style="width:200px;">
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

<a onclick="ti('bold',null)" href="#" class='btf bold'></a>
<a onclick="ti('italic',null)" href="#" class='btf italic'></a>
<a onclick="ti('underline',null)" href="#" class='btf underline'></a>

<a onclick="ti('justifyleft',null)" href="#" class='btf justifyleft'></a>
<a onclick="ti('justifycenter',null)" href="#" class='btf justifycenter'></a>
<a onclick="ti('justifyright',null)" href="#" class='btf justifyright'></a>
<a onclick="ti('justifyfull',null)" href="#" class='btf justifyfull'></a>

<a onclick="ti('insertunorderedlist',null)" href="#" class='btf insertunorderedlist'></a>
<a onclick="ti('insertorderedlist',null)" href="#" class='btf insertorderedlist'></a>
<div style="float:right;margin-right:210px;">
<!--<button type="button" style="margin-top:2px; "  title="Imprime este contrato" id="salvar_contrato">
	<img src="modulos/odonto/atendimento/img/save.png" height="17"/>
</button>-->
			
</div>
<div style="clear:both"></div>
<div id="texto">
 <label style="display:none">
		<textarea name="texto" cols="25" rows="29" id="tx_html"  >
		<?php
			echo $contrato_social->contrato;
		?>



        </textarea>
              </label >

       <iframe id='ed' name='ed' width="75%" style="height:300px; background:#FFF;  overflow:scroll;float:left" onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('tx_html').value;" frameborder="0"class="edtx"></iframe>
</div>
        
        
        
        
          <div id="esquerda" style="float:right;overflow:auto">
        	
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_razaosocial</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_cnpj</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_endereco</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_nomecontato</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_cpf</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratante_rg</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_razaosocial</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_cnpj</strong></a>
        	<div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_endereco</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_nomecontato</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_cpf</strong></a>
            <div style="clear:both"></div>
              <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_rg</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@valor_mensalidade</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@valor_implantacao</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@dia_implantacao</strong></a>
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