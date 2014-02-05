<form onsubmit="return validaForm(this)" class="form_float" method="post" id="form_documentos" enctype="multipart/form-data" target="carregador" style="display:none;">
    <fieldset>
		<legend>
			 <a class="form2">Jurídico</a>
                <a class="form2">Sócios</a>
                <a class="form2">Contrato Social</a>
                <a class="form2">Contrato Interno</a>
                <a class="form2"><strong>Documentos</strong></a>  
                <a class="form2">Requerimento de Empresários</a>		
		</legend>
        
        <label style="width:250px;">
        		Descriçao
                <input type="text" name="documento_descricao" id="documento_descricao" />
        </label>
        
        <label style="width:300px;">
        		Arquivo
                <input type="file" name="documento_arquivo" id="documento_arquivo" />
        </label>
        
        <input type="button"  id="adicionar_documento" value="Adicionar Documento" style="margin-top:17px;"/>
        
        <div style="clear:both"></div>
        <div id='dados_documentos'>
       <div id='documentos_funcionario'>
<table  cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:250px;">Descriçao</td>
                        <td style="width:15px;">Download</td>
                         <td style="width:15px;">Remover</td>                     
                    </tr>
                 </thead>
                  <tbody>
                 <?php
				 	$documentos = mysql_query($t="SELECT * FROM   cliente_fornecedor_arquivo WHERE cliente_fornecedor_id='$cliente_fornecedor->id'");
					
					//echo $t;
					while($documento = @mysql_fetch_object($documentos)){
				 ?>
                 	<tr id_documento="<?=$documento->id?>">
                        <td style="width:250px;"><? if(empty($_GET['remove_documento'])||empty($_POST['acao2'])){ echo $documento->descricao;}else{echo utf8_encode($documento->descricao);}?></td>
                        <td style="width:15px;"><img src="../fontes/img/baixar.png" class="imprimir_documento_empresa"/></td>
                        <td style="width:15px;"><img src='../fontes/img/menos.png' id='remove_documento'></td>          
                    </tr>
                  <?php
					}
				  ?>
                 </tbody>
  </table>

  </div>
        </div>
        <input type="hidden" name="acao2" id="acao2" value="documento" />
        
        <input name="id" type="hidden" value="<?=$registro->id?>" />
        <input name="cliente_fornecedor_id" type="hidden" value="<?=$cliente_fornecedor->cliente_fornecedor_id?>" />
        
</fieldset>
	<div style="width:100%; text-align:center" >
	
	<div style="clear:both"></div>
	</div>
</form>