<form onsubmit="return validaForm(this)" class="form_float" method="post" id="form_requerimentos" enctype="multipart/form-data" target="carregador" style="display:none">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	
    <input id='tipo_cadastro' name="tipo_cadastro" type="hidden" value="<? if($cliente_fornecedor->id>0)echo $cliente_fornecedor->tipo_cadastro; else echo "Jurídico"; ?>" />
	<input name="cliente_fornecedor_id" id="cliente_fornecedor_id" type="hidden" value="<?=$cliente_fornecedor->cliente_fornecedor_id?>" />
		<fieldset  id='campos_1' <? if($cliente_fornecedor->tipo_cadastro=="Físico")echo 'style="display:none"'; ?> >
			<legend>
				<a class="form2">Jur&iacute;dico</a>
                <a class="form2">S&oacute;cios</a>
                <a class="form2">Contrato Social</a>
                <a class="form2">Contrato Interno</a>
                <a class="form2">Documentos</a>
				<a class="form2"><strong>Requerimento de Empres&aacute;rios</strong></a> 
			</legend>
			
            <div style="clear:both"></div>
            
            <label style="width:100px">
            	C&oacute;digo do Ato
            	<input type="text" name="codigo_ato1" id="codigo_ato1" value="<?=$cliente_fornecedor->codigo_ato1?>">
            </label>
             <label style="width:160px">
            	Descri&ccedil;&atilde;o do Ato
            	<input type="text" name="descricao_ato1" id="descricao_ato1" value="<?=$cliente_fornecedor->descricao_ato1?>">
            </label>
            <label style="width:100px">
            	C&oacute;digo do Evento
            	<input type="text" name="codigo_evento1" id="codigo_evento1" value="<?=$cliente_fornecedor->codigo_evento1?>">
            </label>
             <label style="width:150px">
            	Descri&ccedil;&atilde;o do Evento
            	<input type="text" name="descricao_evento1" id="descricao_evento1" value="<?=$cliente_fornecedor->descricao_evento1?>">
            </label>
             
             <div style="clear:both"></div>
            <label style="width:100px">
            	C&oacute;digo do Evento
            	<input type="text" name="codigo_evento2" id="codigo_evento2" value="<?=$cliente_fornecedor->codigo_evento2?>">
            </label>
             <label style="width:160px">
            	Descri&ccedil;&atilde;o do Evento
            	<input type="text" name="descricao_evento2" id="descricao_evento2" value="<?=$cliente_fornecedor->descricao_evento2?>">
            </label>
            <label style="width:100px">
            	C&oacute;digo do Evento
            	<input type="text" name="codigo_evento3" id="codigo_evento3" value="<?=$cliente_fornecedor->codigo_evento3?>">
            </label>
             <label style="width:150px">
            	Descri&ccedil;&atilde;o do Evento
            	<input type="text" name="descricao_evento3" id="descricao_evento3" value="<?=$cliente_fornecedor->descricao_evento3?>">
            </label>
             <div style="clear:both;"></div>
         	 <h5 style="color:#666">C&oacute;digo de Atividade econ&ocirc;mica</h5>
             	<div style="color:#666; float:left; font-size:12px;"> (CNAE FISCAL) </div>
                <div style="color:#666; float:right; padding-right:280px;font-size:11px; padding-top:8px;"> (DESCRI&Ccedil;&Atilde;O DO OBJETIVO) </div>
                <div style="clear:both;"></div>
                Atividade Principal<br/>
                <label style="width:150px;">
                    <label><input type="text" name="cnae_principal" id="cnae_principal" style="width:150px;" value="<?=$cliente_fornecedor->cnae_principal?>"></label>
                </label>
                 <label style="width:320px;">
                    <label><input type="text" name="objectivo_principal" id="objectivo_principal" style="width:400px;" value="<?=$cliente_fornecedor->objectivo_principal?>"></label>
                </label>
                <div style="clear:both;"></div>
                Atividade Secund&aacute;ria<br/>
                <label style="width:150px;">
                     <input type="text" name="cnae_secundaria_1" id="cnae_secundaria_1" value="<?=$cliente_fornecedor->cnae_secundaria_1?>">
                </label>
                <label style="width:320px;">
                    <label><input type="text" name="objectivo_secundaria_1" id="objectivo_secundaria_1" style="width:400px;" value="<?=$cliente_fornecedor->objectivo_secundaria_1?>"></label>
                </label>
                <div style="clear:both;"></div>
                 <label style="width:150px;">
                     <input type="text" name="cnae_secundaria_2" id="cnae_secundaria_2" value="<?=$cliente_fornecedor->cnae_secundaria_2?>">
                </label>
                <label style="width:320px;">
                    <label><input type="text" name="objectivo_secundaria_2" id="objectivo_secundaria_2" style="width:400px;" value="<?=$cliente_fornecedor->objectivo_secundaria_2?>"></label>
                </label>
                <div style="clear:both"></div>
             
            
   	
	  </fieldset>      
    <?
	if($cliente_fornecedor->cliente_fornecedor_id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
   
	<?
	}
	?>
	<input name="action" type="submit" id='botao_salvar' value="Salvar" style="float:right"  />
    <input name="acao2" type="hidden" value="requerimento"/>   
        
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	
	<div style="clear:both"></div>
	</div>
</form>