
	<form onsubmit="return validaForm(this)" class="form_float" method="post" id="form_socios" enctype="multipart/form-data" target="carregador" style="display:none">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	
    <input id='tipo_cadastro' name="tipo_cadastro" type="hidden" value="<? if($cliente_fornecedor->id>0)echo $cliente_fornecedor->tipo_cadastro; else echo "Jurídico"; ?>" />
	<input name="cliente_fornecedor_id" id="cliente_fornecedor_id" type="hidden" value="<?=$cliente_fornecedor->cliente_fornecedor_id?>" />
		<fieldset  id='campos_1' <? if($cliente_fornecedor->tipo_cadastro=="Físico")echo 'style="display:none"'; ?> >
			<legend>
				<a class="form2">Jur&iacute;dico</a>
                <a class="form2"><strong>S&oacute;cios</strong></a>
                <a class="form2">Contrato Social</a>
                <a class="form2">Contrato Interno</a>
                <a class="form2">Documentos</a>
                <a class="form2">Requerimento de Empresários</a>
				
                
			</legend>
			
            <div style="clear:both"></div>
            
            
            <button type="button" name="cad_cliente"   id="adicionar_socio" title="Cadastro de Clientes" rel="tip" style="float:right;margin-right:20px;"><img  src="../fontes/img/adm.png" style="float:right;" ></button>

            
           
            <label style="width:300px">
            	Busque uma pessoa física caso já esteja cadastrada no sistema
                <input type="text" id='busca_socio' name="socio" busca='modulos/rh/empresa/busca_socio.php,@r1,@r0-value>novo_socio|@r1-value>busca_socio,0' />
           		 <input type="hidden" name="novo_socio" id='novo_socio' /> 
            </label>
            
            <input type="button" id="adicionar_socio_empresa" value="Adicionar Socios a esta empresa" style="margin-top:17px;"/>
            
            
           
            
              <div style="clear:both"></div>
             <div id='dados_socios'>
             <?
             //require_once('tabela_socios.php'); 
			 ?>
             <div id='socios_interno'>
<table  cellpadding="0" cellspacing="0" width="100%">
                 <thead>
                 	<tr>
                    	<td style="width:200px;">Nome</td>
                        <td style="width:30px;">RG</td>
                        <td style="width:30px;">CPF</td>
                        
                        <td style="width:30px;">Imprimir</td>
                        <td style="width:30px;">Remover</td>                        
                    </tr>
                 </thead>
                  <tbody>
                 <?php
				 	$socios = mysql_query($t="SELECT * FROM  rh_empresa_has_socios ehs, cliente_fornecedor cf WHERE ehs.vkt_id='$vkt_id' AND ehs.empresa_id=cf.id AND ehs.empresa_id='$cliente_fornecedor->id'");
					$qtd_socios = mysql_num_rows($socios);
					//echo $t;
					while($socio = @mysql_fetch_object($socios)){
						$dados_socio = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$socio->socio_id'"));
						if($_POST['acao2']=='socio'||$_GET[associa_socio]==1||$_GET[remove_socio]==1){
							$nome_socio = utf8_encode($dados_socio->razao_social);
							$rg_socio = utf8_encode($dados_socio->rg);
							$cpf_socio=utf8_encode($dados_socio->cnpj_cpf);
						}else{
							$nome_socio = $dados_socio->razao_social;
							$rg_socio = $dados_socio->rg;
							$cpf_socio= $dados_socio->cnpj_cpf;
						}
				 ?>
                 	<tr id_socio="<?=$dados_socio->id?>">
                        <td style="width:200px;" class="edita_socio"><?=$nome_socio?></td>
                        <td style="width:30px;"><?=$rg_socio?></td>
                        <td style="width:30px;"><?=$cpf_socio ?></td>
                        <td style="width:30px;"><button id="imprimir_empresario" class="botao_imprimir"/><img src="../fontes/img/imprimir.png" /></button></td>
                        <td style="width:30px;"><img src='../fontes/img/menos.png' id='remove_socio'></td>          
                    </tr>
                  <?php
					}
				  ?>
                 </tbody>
  </table>
  <input type="hidden" name="qtd_socios" id="qtd_socios" value="<?=$qtd_socios?>"/>
  			</div>
      </div>
	  </fieldset>      
        
        
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	
	<div style="clear:both"></div>
	</div>
</form>