<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
$TableDisplay = "style='display:none;'";
$valTableServico = "1";
$checkedPessoa = "checked='checked'";
include("_functions.php");
include("_ctrl.php");
$sqlRevenda = mysql_fetch_object(mysql_query("SELECT * FROM revenda_franquia WHERE cliente_vekttor_id = '$vkt_id'"));
$cliFornecedor = mysql_fetch_object(mysql_query(" SELECT * FROM cliente_fornecedor WHERE id = '$sqlRevenda->cliente_fornecedor_id'"));
if(!empty($usuarioTipo->nome)){
	$nomeusutipo = $usuarioTipo->nome;
} else{ $nomeusutipo = "Administrador1";}
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='aSerCarregado'>
<div style="width:780px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    <span>Venda</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" id="form_arquivo" method="post"  autocomplete='off' enctype="multipart/form-data" target="carregador">
 		<input type="hidden" name="venda_id" value="<?=$venda->id?>">
        <input type="hidden" name="cliente_vekttor_id" id="cliente_vekttor_id" value="<?=$cliente_vekttor->id?>">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset id="campos_1">
    	<legend>
				<a onclick="aba_form(this,0)"><strong>Cliente</strong></a>
                <a onclick="aba_form(this,1)">Venda</a>
                <a onclick="aba_form(this,2)">Pacotes</a>
                <a onclick="aba_form(this,3)">Servi&ccedil;o</a>
                <a onclick="aba_form(this,4)">Usu&aacute;rio</a>
                <a onclick="aba_form(this,5)">Contrato</a>
                <a onclick="aba_form(this,6)">Resumo</a>
		</legend>
        <input type="hidden" name="contato_id" id="contato_id" value="<? if((!$venda->revenda_contato_id>0)&&($_GET['contato_id']>0)){echo $_GET['contato_id'];}else{echo $venda->revenda_contato_id;}?>">
        
        		<?php
                	if($cliente_fornecedor->tipo_cadastro == "Jurídico")
						$editTipoJ = "checked='checked'";
					else if($cliente_fornecedor->tipo_cadastro == "Físico")
						$editTipoF = "checked='checked'";
				?>
        	<input type="radio" name="tipo_pessoa" id="tipo_pessoa" value="1" <?=$checkedPessoa?> <?=$editTipoJ?>>Jur&iacute;dica
            <input type="radio" name="tipo_pessoa" id="tipo_pessoa" value="2" <?=$editTipoF?>>F&iacute;sica
        
        <div style="clear:both; margin-top:10px;"></div>
        <label style="width:294px; margin-right:23px;">
				Nome
				<input type="text" id="cliente_nome" name="cliente_nome" busca='modulos/revenda_vekttor/venda/busca_contato.php,@r1,@r0-value>contato_id|@r1-value>cliente_nome|@r2-value>cliente_cnpj|@r3-value>cliente_nome_contato|@r4-value>cliente_endereco|@r5-value>cliente_telefone1|@r6-value>cliente_telefone2|@r8-value>cliente_bairro|@r9-value>cliente_cep|@r10-value>cliente_email|@r11-value>cliente_cidade|@r12-value>cliente_estado|@r13-value>cliente_nome_fantasia,0'  value="<? if(!$_GET['contato_id']>0){ echo $cliente_vekttor->nome;}else{echo $cliente_vekttor->nome_fantasia;}?>" />
			</label>  
			<label style="width:294px;">
				Nome Fantasia
				<input type="text" id="cliente_nome_fantasia" name="cliente_nome_fantasia" value="<?=$cliente_vekttor->nome_fantasia?>" />
			</label>
            <label style="width:294px;">
				Nome Contato
				<input type="text" id='cliente_nome_contato' name="cliente_nome_contato" value="<?=$cliente_vekttor->nome_fantasia?>" />
			</label>
			<label style="width:136px; margin-right:22px;">
				CNPJ/CPF
				<input type="text" id='cliente_cnpj' name="cliente_cnpj" value="<?=$cliente_vekttor->cnpj?>" mascara="__.___.___/____-__" sonumero='1' retorno='focus|Coloque o CNPJ corretamente!' />
			</label>
			<label style="width:194px; margin-right:23px;">
			Email
			<input type="text" id='cliente_email' name="cliente_email" value="<?=$cliente_fornecedor->email?>"  retorno="focus|Digite o email corretamente" valida_minlength='3' />
		</label>
            
		<label style="width:90px; margin-right:23px;">
			Telefone 1
			<input type="text" id='cliente_telefone1' name="cliente_telefone1" value="<?=$cliente_fornecedor->telefone1?>" mascara="(__)____-____" sonumero='1' valida_minlength='3' retorno='focus|Por favor, insira um telefone para contato' />
		</label>
		
        <label style="width:90px; margin-right:22px;">
			Telefone 2
			<input type="text" id='cliente_telefone2' name="cliente_telefone2" value="<?=$cliente_fornecedor->telefone2?>" mascara="(__)____-____" sonumero='1' />
		</label>
		
        <label style="width:90px; margin-right:23px;">
			Fax
			<input type="text" id='cliente_fax' name="cliente_fax" value="<?=$cliente_fornecedor->fax?>" mascara="(__)____-____" sonumero='1' />
		</label>
            <label style="width:136px; margin-right:23px;">
				CEP
				<input type="text" id='cliente_cep' name="cliente_cep" value="<?=$cliente_vekttor->cep?>" busca='modulos/vekttor/clientes/busca_endereco.php,@r0,@r0-value>cliente_cep|@r1-value>cliente_endereco|@r2-value>cliente_bairro|@r3-value>cliente_cidade|@r4-value>cliente_estado,0' autocomplete="off"/>
			</label>
			<label style="width:290px; margin-right:22px;">
				Endereco
				<input type="text" id='cliente_endereco' name="cliente_endereco" value="<?=$cliente_vekttor->endereco?>" />
			</label>
      		<div style="clear:both"></div>
            <label style="width:136px; margin-right:22px;">
				Bairro
				<input type="text" id='cliente_bairro' name="cliente_bairro" value="<?=$cliente_vekttor->bairro?>" />
			</label>
			<label style="width:136px; margin-right:23px;">
				Cidade
				<input type="text" id='cliente_cidade' name="cliente_cidade" value="<?=$cliente_vekttor->cidade?>" />
			</label>
			<label style="width:30px; margin-right:23px;">
				Estado
				<input type="text" id='cliente_estado' name="cliente_estado" maxlength="2" value="<?=$cliente_vekttor->estado?>"/>
			</label>      
        	<label>
            	Data Cadastro<br/>
                <input type="text" name="data_cadastro" id="data_cadastro" calendario="1" mascara="__/__/____" value="<?php
				 if($cliente_vekttor->data_cadastro != NULL){ echo dataUsaToBr($cliente_vekttor->data_cadastro);} else {echo date("d/m/Y");}?>" style="width:70px;">
            </label>
            <div style="clear:both;"></div>
            <label style="width:200px">Logomarca<input type="file" name="foto" id="foto" value="<?=$cliente_vekttor->img?>" /></label>
             <img src="<? if($cliente_vekttor->id>0)echo "modulos/vekttor/clientes/img/".$cliente_vekttor->id.".png"?>" width="10%" height="10%"/>
    </fieldset>
<!-- ABA VENDA -->    
    <fieldset id='campos_2' style="display:none;"/>
			<legend>
            	<a onclick="aba_form(this,0)">Cliente</a>
				<a onclick="aba_form(this,1)"><strong>Venda</strong></a>
                <a onclick="aba_form(this,2)">Pacotes</a>
                <a onclick="aba_form(this,3)">Servi&ccedil;o</a>
                <a onclick="aba_form(this,4)">Usu&aacute;rio</a>
                <a onclick="aba_form(this,5)">Contrato</a>
                <a onclick="aba_form(this,6)">Resumo</a>
			</legend>
            <div style="clear:both"></div>
            <label style="width:150px;">Vendedor
            	<?php
					$sql=mysql_query(" SELECT * FROM rh_funcionario WHERE cliente_vekttor_id = '$vkt_id'");
					if(!$_GET['contato_id']>0){
				?>
                <select name="vendedor_id" id="vendedor_id">
                	<option></option>
                	<?php
                    	
							while($vendedor= mysql_fetch_object($sql)){
									if($venda->vendedor_id == $vendedor->id){ $selc="selected='selected'";} else{$selc="";}
					?>
                	<option <?=$selc?>  value="<?=$vendedor->id?>"><?=$vendedor->nome?></option>
                	<?php
                    		}
					?>
                </select>
                <?php
					}else{
						$vendedor = mysql_fetch_object($sql);
						echo "<br><br>$vendedor->nome";
						echo "<input type='hidden' name='vendedor_id' id='vendedor_id' value='$vendedor->id'/>";
					}
				?>
            </label> 
			<label style="width:95px; margin-right:23px;">
				Data Vencimento<br/>
				<input type="text" id="diaVencimento" name="diaVencimento" style="width:80px;" mascara="__/__/____" calendario="1" value="<?php
				 if($venda->dia_vencimento != NULL){ echo dataUsaToBr($venda->dia_vencimento);} else {echo date("d/m/Y");}?>" />
			</label>
             <label style="width:100px;">
            	Data Negocia&ccedil;&atilde;o<br/>
                <input type="text" name="data_negociacao" id="data_negociacao" style="width:80px;" mascara="__/__/____" calendario="1" value="<?php
				 if($venda->data_negociacao != NULL){ echo dataUsaToBr($venda->data_negociacao);} else {echo date("d/m/Y");}?>"> 
            </label>
			<label style="width:136px; margin-right:22px;">
				Situa&ccedil;&atilde;o <?php $selSit = "selected='selected'"?>
					<select name="situacao" id="situacao" disabled="disabled">
                    	<option value="1" <?php if($venda->situacao_venda == '1'){echo "selected='selected'";}else{$selSit="";} ?> <?=$selSit?> >Ativo</option>
                        <option value="2" <?php if($venda->situacao_venda == '2'){echo "selected='selected'";}else{$selSit="";} ?>>Cancelado</option>
                    </select>
			</label>
            <div style="clear:both"></div> 
		</fieldset>
<!-- ABA PACOTES -->
        <fieldset id="campo_3" style="display:none">
        	<legend>
            	<a onclick="aba_form(this,0)">Cliente</a>
				<a onclick="aba_form(this,1)">Venda</a>
                <a onclick="aba_form(this,2)"><strong>Pacotes</strong></a>
                <a onclick="aba_form(this,3)">Servi&ccedil;o</a>
                <a onclick="aba_form(this,4)">Usu&aacute;rio</a>
                <a onclick="aba_form(this,5)">Contrato</a>
                <a onclick="aba_form(this,6)">Resumo</a>
			</legend>
            		<div>
                    	<p style=" padding:2px 0 0 10px;">Lista de todos os pacotes Vekttor</p>
                    </div>
                    <div style="clear:both"></div>
                    <div id="scroll-table">
                    <table cellpadding="0" cellspacing="0">
                        <thead>
                        <tr>
                        	<td class="coluna0"><span>Pacote</span></td>
                            <td class="coluna1"><span>Mensalidade</span></td>
                            <td class="coluna2"><span>Implanta&ccedil;&atilde;o</span></td>
                            <td class="coluna3"><span></span></td>
                        </tr>
                        </thead>
                    </table>
                    <div class="scrollContainer">
                    <table cellpadding="0" cellspacing="0"  id="tableItem">
                    	<tbody>
                        	<?php 
									$sqlPacote=mysql_query(" SELECT * FROM pacotes ");
									while($pacote=mysql_fetch_object($sqlPacote)){
										$cor++;
										if($cor%2){$sel='class="al"';}else{$sel='';}
							?>
                        	 <tr <?=$sel?>  bgcolor="#fff" id="<?=$pacote->id?>">
								<td class="coluna0"  style="text-transform:uppercase;"><span><?=$pacote->nome?></span></td>
                             	<td class="coluna1" id="mensal"><input type="hidden" name="valMensalPacote[]" id="valMensalPacote" disabled="disabled" value="<?=moedaUsaToBr($pacote->valor_mensalidade)?>"><span><?=moedaUsaToBr($pacote->valor_mensalidade)?></span></td>
                                <td class="coluna2" id="implantacao"><input type="hidden" name="valImplatPacote[]" id="valImplatPacote" disabled="disabled" value="<?=moedaUsaToBr($pacote->valor_implantacao)?>"><span><?=moedaUsaToBr($pacote->valor_implantacao)?></span></td>
                                <td class="coluna3">
                                	<span><input type="checkbox" <? if(sizeof($ArrayPacote) > 0 ){if(in_array($pacote->id,$ArrayPacote)){ echo "checked='checked'";}}?> name="pacote_id[]" id="pacote_id" value="<?=$pacote->id?>" ></span>
                                 </td>
                             </tr>
                        	<?php
									}
							?>
                        </tbody>
                    </table>
                    </div>
                    	<div>
                    		<table cellpadding="0" cellspacing="0" id="subtotal-foot">
                        		<tfoot>
                        			<td class="coluna0" style="text-align:right;"><span style="padding-right:10px;">Subtotal</span></td>
                            		<td class="coluna1"><span><?php if(!empty($val_mensalidade)) {echo moedaUsaToBr($val_mensalidade);}?></span></td>
                            		<td class="coluna2"><span><?php if(!empty($val_implantacao)) {echo moedaUsaToBr($val_implantacao);}?></span></td>
                            		<td class="coluna3"><span></span></td>
                        		</tfoot>
                    		</table>
                    	</div>
                        <div style="padding:3px;">
                                <div id="DelPacote" style="display:none"></div>
                                &nbsp;
                        </div>
                        <div>
                        	<!--<table cellpadding="0" cellspacing="0" id="total-foot">
                        		<tfoot>
                        			<td class="coluna0" colspan="2" style="text-align:right;"><span style="padding-right:10px;">Total</span></td>
                            		<td class="coluna2" colspan="2" style="width:33px;"><span><?if(!empty($totalPacote)){ echo moedaUsaToBr($totalPacote);}?></span></td>
                        		</tfoot>
                    		</table>-->
                        </div>                    
                    </div>
        </fieldset>
<!-- ABA SERVIÇOS -->
        <fieldset id="campo_4" style="display:none">
        	<legend>
            	<a onclick="aba_form(this,0)">Cliente</a>
				<a onclick="aba_form(this,1)">Venda</a>
                <a onclick="aba_form(this,2)">Pacotes</a>
                <a onclick="aba_form(this,3)"><strong>Servi&ccedil;o</strong></a>
                <a onclick="aba_form(this,4)">Usu&aacute;rio</a>
                <a onclick="aba_form(this,5)">Contrato</a>
                <a onclick="aba_form(this,6)">Resumo</a>
			</legend>
            <input type="hidden" id="valTableServico" value="<?=$valTableServico?>">
            <input type="hidden" name="servico_id" id="servico_id">
            <label style="width:200px">
            	Servi&ccedil;o <br/>
            	<input type="text" name="servico" id="servico" style="width:195px;" busca='modulos/revenda_vekttor/venda/busca_servico.php,@r0 ,@r1-value>servico_id|@r2-value>valor_normal|@r2-value>valor_unit|@r4-value>und_servico,0'>
            </label>
            <label style="width:200px;">
            	Observa&ccedil;&atilde;o
                <input type="text" name="obsItemServico" id="obsItemServico">
            </label>
            <label><br/>
            	<div style="margin-top:2px;"><img src="../fontes/img/mais.png" id="add-servico"></div>
            </label>
            <div style="clear:both"></div>
            <div id="scroll-table-servico" style="display:none" class="table-add">
            	<table cellpadding="0" cellspacing="0">
            		<thead>
                    	<tr>
                            <td class="coluna0"><span>Servi&ccedil;o</span></td>
                            <td class="coluna1"><span>Unidade</span></td>
                            <td class="coluna2"><span>Observa&ccedil;&atilde;o</span></td>
                            <td class="coluna3"><span>Valor</span></td>
                            <td class="coluna4"><span></span></td>
                    	</tr>
                    </thead>		
            	</table>
                <div class="scrollContainer">
                <table cellpadding="0" cellspacing="0" id="item-servico">
                	<tbody></tbody>
                </table>
                </div>
                	<div>
                        <table cellpadding="0" cellspacing="0" id="foot-total-servico">
                            <tfoot>
                                <tr>
                                    <td class="coluna0"><span></span></td>
                            		<td class="coluna1"><span></span></td>
                            		<td class="coluna2" style="text-align:right"><span style="padding-right:10px;">Total</span></td>
                            		<td class="coluna3"><span></span></td>
                            		<td class="coluna4"><span></span></td>
                                </tr>
                            </tfoot>		
                        </table>
                	</div>
            </div>
            
            <!-- TABELA PARA EDIÇAO -->
             <div  style="clear:both"></div>
            <div id="scroll-table-servico" <?=$TableDisplay?>>
            	<table cellpadding="0" cellspacing="0">
            		<thead>
                    	<tr>
                            <td class="coluna0"><span>Servi&ccedil;o</span></td>
                            <td class="coluna1"><span>Unidade</span></td>
                            <td class="coluna2"><span>Observa&ccedil;&atilde;o</span></td>
                            <td class="coluna3"><span>Valor</span></td>
                            <td class="coluna4"><span></span></td>
                    	</tr>
                    </thead>		
            	</table>
                <div class="scrollContainer">
                <table cellpadding="0" cellspacing="0" id="item-servico">
                	<tbody>
                    	<?php
                        		$sqlServico = mysql_query(" SELECT * FROM vekttor_venda_servico WHERE vekttor_venda_id = '$venda->id'");
								$valServico = mysql_fetch_object(mysql_query(" SELECT SUM(valor) AS totalServico FROM vekttor_venda_servico WHERE vekttor_venda_id = '$venda->id'"));
								$c=0;
									while($ItemS=mysql_fetch_object($sqlServico)){
											$servico = mysql_fetch_object(mysql_query(" SELECT * FROM servico  WHERE id = '$ItemS->servico_id'"));
											$cor++;
											if($cor%2){$sel='class="al"';}else{$sel='';}
						?>
                    	<tr <?=$sel?> bgcolor="#fff" id="<?=$ItemS->id?>">
                        	<td class="coluna0"><input type="hidden" name="item_id[]" value="<?=$ItemS->id?>" style="width:80px;">
                            <span><?=$servico->nome?></span></td>
                            <td class="coluna1"><span><?=$servico->und?></span></td>
                            <td class="coluna2"><span><input type="text" name="obsItemEditServico[]" value="<?=$ItemS->observacao?>" style="width:114px;height:13px;"></span></td>
                            <td class="coluna3"><span><?=moedaUsaToBr($ItemS->valor);?></span></td>
                            <td class="coluna4"><span><img src="../fontes/img/menos.png" id="menos-servico"></td>
                        </tr>
                        <?php
									$c++;
									}
						?>
                    </tbody>
                    <div id="DelServico" style="display:none"></div>
                </table>
                </div>
                	
                    <div>
                        <table cellpadding="0" cellspacing="0" id="foot-total-servico">
                            <tfoot>
                                <tr>
                                    <td class="coluna0"><span></span></td>
                            		<td class="coluna1"><span></span></td>
                            		<td class="coluna2" style="text-align:right"><span style="padding-right:10px;">Total</span></td>
                            		<td class="coluna3"><span><?=moedaUsaToBr($valServico->totalServico);?></span></td>
                            		<td class="coluna4"><span></span></td>
                                </tr>
                            </tfoot>		
                        </table>
                	</div>
            </div>
         </fieldset>
<!-- ABA USUÁRIO-->
        <fieldset id="campo_5" style="display:none;">
        		<legend>
            	<a onclick="aba_form(this,0)">Cliente</a>
				<a onclick="aba_form(this,1)">Venda</a>
                <a onclick="aba_form(this,2)">Pacotes</a>
                <a onclick="aba_form(this,3)">Servi&ccedil;o</a>
                <a onclick="aba_form(this,4)"><strong>Usu&aacute;rio</strong></a>
                <a onclick="aba_form(this,5)">Contrato</a>
                <a onclick="aba_form(this,6)">Resumo</a>
			</legend>
            <input type="hidden" name="usuarioID" value="<?=$usuario->id?>">
            <input type="hidden" name="id_usuario_tipo" id="id_usuario_tipo" value="<?=$usuarioTipo->id?>">
            <label style="width:285px; margin-right:23px;">
				Nome
			<input type="text" id="nome_usuario" name="nome_usuario" valida_minlength="3" retorno="focus|Digite um Usuario"  value="<?=$usuario->nome?>"/>
            </label>
            <label style="width:110px;">
            	Tipo Usuario
                <input type="text" name="nome_tipo_usuario" id="nome_tipo_usuario" readonly="readonly" value="<?=$nomeusutipo?>">
            </label>
            <div style="clear:both"></div>
            <label style="width:135px; margin-right:23px;">
				Login
			<input type="login" id='login_usuario' name="login_usuario" value="<?=$usuario->login?>"/>
            </label>
            <label style="width:135px; margin-right:23px;">
				Senha
			<input type="password" id='senha_usuario' name="senha_usuario" value="<?=$usuario->senha?>"/>
            </label>
             <input type="hidden" name="id_usuario" id="id_usuario" value="<?=$usuario->id?>" />
        </fieldset>
<!-- ABA CONTRATO -->
         <fieldset id="campo_6" style="display:none;">
        		<legend>
                    <a onclick="aba_form(this,0)">Cliente</a>
                    <a onclick="aba_form(this,1)">Venda</a>
                    <a onclick="aba_form(this,2)">Pacotes</a>
                    <a onclick="aba_form(this,3)">Servi&ccedil;o</a>
                    <a onclick="aba_form(this,4)">Usu&aacute;rio</a>
                    <a onclick="aba_form(this,5)"><strong>Contrato</strong></a>
                    <a onclick="aba_form(this,6)">Resumo</a>
				</legend>
                <?php
    				$id_progresso = md5(microtime() . rand());
   	 			?>
          		<input id="id_chave" type="hidden" name="UPLOAD_IDENTIFIER" value="<?php echo $id_progresso;?>" />
                
                <label>
<textarea name="texto" cols="80" rows="29" id="tx_html" style="display:none">
<?php
	
	if(!empty($venda->contrato)){
		$texto = $venda->contrato;
		echo $texto;
	}else{
		$contrato = mysql_fetch_object(mysql_query("SELECT * FROM contrato_modelo_cliente "));
		echo $contrato->contrato;
		
	}
?>
</textarea>
</label>
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

<div style="clear:both"></div>
 <iframe id='ed' name='ed' width="73%" style="height:345px; background:#FFF;  overflow:scroll" onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('tx_html').value;" frameborder="0" class="edtx"></iframe>
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
</div>
<div style="clear:both"></div>
<!--<label style="margin-top:16px;">
	<button type="button" name="action" id="anexar_arquivo">Anexar</button>
</label>-->
<input type="hidden" name="nomeFile" id="nomeFile">
<label>Anexar Contrato
	<input type="file" name="file" id="file" valida_minlength="3" retorno="focus|Informe um arquivo no contrato">
</label>

</fieldset>
<!-- ABA RESUMO -->
<fieldset id="campo_7" style="display:none;">
        		<legend>
            	<a onclick="aba_form(this,0)">Cliente</a>
				<a onclick="aba_form(this,1)">Venda</a>
                <a onclick="aba_form(this,2)">Pacotes</a>
                <a onclick="aba_form(this,3)">Servi&ccedil;o</a>
                <a onclick="aba_form(this,4)">Usu&aacute;rio</a>
                <a onclick="aba_form(this,5)">Contrato</a>
                <a onclick="aba_form(this,6)"><strong>Resumo</strong></a>
			</legend>
            <div style="clear:both;"></div>
            <label style="width:88px;">
				Implanta&ccedil;&atilde;o<br/>
                <input type="text" id="view_implantacao" name="view_implantacao" disabled="disabled" style="width:80px;text-align:right" value="<?=moedaUsaToBr($valImplantacao->totalImplantacao);?>" />
				<input type="hidden" id="val_implantacao" name="val_implantacao" style="width:80px;" value="<?=moedaUsaToBr($valImplantacao->totalImplantacao);?>" />
			</label>
            <label style="width:98px;">
				<!--Mensalidade<br>
                <input type="text" id="view_mensalidade" name="view_mensalidade" disabled="disabled" style="width:80px;" value="" />-->
				<input type="hidden" id="val_mensalidade" name="val_mensalidade" style="width:80px;" value="<?=$cliente_vendedor->bairro?>" />
			</label>
            <div style="clear:both"></div>
            <label>
            	Servi&ccedil;o<br/>
                <input type="text" name="view_servico" id="view_servico" style="width:80px;text-align:right" disabled="disabled" value="<?=moedaUsaToBr($valServico->totalServico);?>">
                <input type="hidden" name="val_servico" id="val_servico" style="width:80px;" value="<?=moedaUsaToBr($valServico->totalServico);?>">
            </label>
            <div style="clear:both;"></div>
            <label style="width:88px;">
				Desconto(-)<br/>
				<input type="text" decimal="2" id="val_desconto" name="val_desconto" style="width:80px;text-align:right" value="<?=moedaUsaToBr($venda->valor_desconto);?>" />
			</label>
            <label><br/>
            	<?php
					if(!empty($venda->valor_desconto)){
						$porcent = ($venda->valor_desconto / $venda->total ) * 100 ;
					}
                ?>
            	<input type="text" decimal="1" maxlength="4" name="porcentDesconto" id="porcentDesconto" style="width:50px; text-align:right" value="<?=substr(moedaUsaToBr($porcent),0,4);?>">%
            </label>
            
            <!-- VALOR TOTAL -->
            <div style="clear:both"></div>
            <label style="width:98px;">
				<strong>Total</strong><br/>
				<input type="text"  readonly="readonly" id="total_venda" name="total_venda" style="width:80px;text-align:right" value="<?=moedaUsaToBr($venda->total);?>" />
			</label>
            
            <!-- VALOR SUBTOTAL -->
            <div style="clear:both;"></div>
            <label>
            	<strong>Subtotal</strong><br/>
                <input type="text"  readonly="readonly" id="sub-total" name="sub-total" style="width:80px;text-align:right" value="<?=moedaUsaToBr($venda->subtotal);?>" />
            </label>
            
            
            
</fieldset>

		
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
<?
	if($venda->id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
    <input type='button' value='Imprimir Contrato' onclick="window.open('modulos/revenda_vekttor/venda/impressao_contrato.php?id=<?=$venda->id?>','_BLANK')" style="float:left;"/>
	<?
	}
	?>
<div id='vkt_barra' style="width:300px; display:none; height:20px; position:relative; border-radius:5px; border:1px solid #CCC; margin:5px; padding:1px; text-align:center; ">
                                <div id='vkt_barra_progresso' style="height:20px; text-align:center; border-radius:5px; width:0%; background:#093;">
                                </div>
                                <span style="position:absolute; width:300px; height:20px; line-height:20px;  top:0; left:0; font-weight:bold;"><span id="progresso">Carregando</span>%</span>
                        </div>
<input name="action" type="button" id='botao_salvar' onclick="html_to_form(); setTimeout('document.getElementById(\'botao_salvar\').parentNode.parentNode.submit();',500)" <?=$DisaPago?>  value="Salvar" style="float:right; display:inline"  />
<input name="salva_formulario_contrato_aluguel" type="hidden" value="1" />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
<script>top.openForm()</script>

