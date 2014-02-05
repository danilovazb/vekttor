<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='aSerCarregado'>
<div style="width:800px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span> Informa&ccedil;&otilde;es da  Revenda</span></div>
    </div>
	<form onsubmit="return validaForm(this)" id="frmrevendda" class="form_float" method="post"  autocomplete='off' enctype="multipart/form-data">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
    
	<fieldset  id='campos_1'/>
			<legend>
				<a onclick="aba_form(this,0)"><strong>Cliente</strong></a>
				<a onclick="aba_form(this,1)">Pacotes</a>
                <a onclick="aba_form(this,2)">Usuário</a>
                 <a onclick="aba_form(this,3)">Revenda</a>
                 <a onclick="aba_form(this,4)">Contrato</a>
			</legend>

			<label style="width:294px; margin-right:23px;">
				Nome
				<input type="text" id='cliente_nome' onkeyup="document.getElementById('nome_usuario').value=this.value;document.getElementById('cliente_nome_fantasia').value=this.value" name="cliente_nome" value="<?=$cliente_vekttor->nome?>" valida_minlength='5' retorno='focus|Coloque no minimo 5 caracter'/>
                
			</label>
			<label style="width:294px;">
				Nome Fantasia
				<input type="text" id='cliente_nome_fantasia' name="cliente_nome_fantasia" value="<?=$cliente_vekttor->nome_fantasia?>" />
			</label>
            <label style="width:294px;">
				Nome Contato
				<!--<input type="text" id='cliente_nome_contato' name="cliente_nome_contato" value="<?=$cliente_vekttor->nome_fantasia?>" retorno="focus|Digite o campo Nome" valida_minlength='2'/>-->
                <input type="text" id='f_nome_contato' name="f_nome_contato" value="<?=$professor->nome_contato?>" retorno="focus|Digite o nome corretamente"validamin_length='3'/>
			</label>
			<label style="width:136px; margin-right:22px;">
				CNPJ
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
				<input type="text" id='cliente_cep' name="cliente_cep" value="<?=$cliente_fornecedor->cep?>" busca='modulos/vekttor/clientes/busca_endereco.php,@r0,@r0-value>cliente_cep|@r1-value>cliente_endereco|@r2-value>cliente_bairro|@r3-value>cliente_cidade|@r4-value>cliente_estado,0' autocomplete="off"/>
			</label>
			<label style="width:290px; margin-right:22px;">
				Endereco
				<input type="text" id='cliente_endereco' name="cliente_endereco" value="<?=$cliente_fornecedor->endereco?>" />
			</label>
            <div style="clear:both"></div>
            <label style="width:136px; margin-right:22px;">
				Bairro
				<input type="text" id='cliente_bairro' name="cliente_bairro" value="<?=$cliente_fornecedor->bairro?>" />
			</label>
			<label style="width:136px; margin-right:23px;">
				Cidade
				<input type="text" id='cliente_cidade' name="cliente_cidade" value="<?=$cliente_fornecedor->cidade?>" />
			</label>
			<label style="width:25px; margin-right:23px;">
				Estado
				<input type="text" id='cliente_estado' name="cliente_estado" value="<?=$cliente_fornecedor->estado?>"/>
			</label>
           	<div style="clear:both"></div>
            <input type="hidden" name="cliente_id" id="cliente_id" value="<?=$cliente_vekttor->id?>" />
            <input type="hidden" name="id_tipo" id="id_tipo" value="<?=$tipo_usuario->id?>" />
            <input type="hidden" name="cliente_fornecedor_id" id="cliente_fornecedor_id" value="<?=$cliente_fornecedor->id?>" />
            <label style="width:200px">Logomarca<input type="file" name="foto" id="foto" value="<?=$cliente_vekttor->img?>" /></label>
             <img src="<? if($cliente_vekttor->id>0)echo "modulos/vekttor/clientes/img/".$cliente_vekttor->id.".png"?>" width="10%" height="10%"/>
		</fieldset>
		<div style="display:block"></div>
        <fieldset  id='campos_2' style="display:none;" >
			<legend>
				<a onclick="aba_form(this,0)">Cliente</a>
				<a onclick="aba_form(this,1)"><strong>Pacotes</strong></a>
                <a onclick="aba_form(this,2)">Usuário</a>
                <a onclick="aba_form(this,3)">Revenda</a>
                <a onclick="aba_form(this,4)">Contrato</a>
			</legend>
          
            <div style="clear:both"></div>
         
         
         <table cellpadding="0" cellspacing="0" width="100%" >
                <thead>
                        <tr>
                          <td width="200">Pacote</td>
                          <td width="140">Valor Implantaçao(R$)</td>
                          <td width="140">Valor Mensalidade(R$)</td>
                          <td width="140">Valor Treinamento(R$)</td>
                          <td></td>                          
                        </tr>
               </thead>
			</table>
            
            <div style="height:150px;overflow:auto">
			<table cellpadding="0" cellspacing="0" width="100%" height="10%">
                <tbody id="tbody">
                	   <?php
					   	$pacotes = mysql_query("SELECT * FROM pacotes");
					   	$id_tipo_usuario = $tipo_usuario->id; 
						while($pacote = mysql_fetch_object($pacotes)){
							//seleciona_itens
							$iten  = mysql_query($t="SELECT * FROM  revenda_franquia_pacote WHERE pacote_id='$pacote->id' AND revendedor_id='$revenda->id'");
							$checked='';
							if(@mysql_num_rows($iten)>0){
								$checked="checked=checked";
							}
							
					   ?>
                        <tr>
                          <td width="200"><?=$pacote->nome?></td>
                          <td width="140"><?=moedaUsaToBr($pacote->valor_implantacao)?></td>
                          <td width="140"><?=moedaUsaToBr($pacote->valor_mensalidade)?></td>
                          <td width="140"><?=moedaUsaToBr($pacote->valor_treinamento)?></td>
                          <td> <input type="checkbox" name="pacote_id[]" value="<?=$pacote->id?>" <?php echo $checked;?>/> </td>                          
                        </tr>
                   		<?php
						 }
						?>
                </tbody>
             </table>
         	</div>
          
            
        </fieldset>
        
        <fieldset  id='campos_3' style="display:none;" >
			<legend>
				<a onclick="aba_form(this,0)">Cliente</a>
				<a onclick="aba_form(this,1)">Pacotes</a>
                <a onclick="aba_form(this,2)"><strong>Usuário</strong></a>
                <a onclick="aba_form(this,3)">Revenda</a>
                <a onclick="aba_form(this,4)">Contrato</a>
			</legend>
           	<label style="width:294px; margin-right:23px;">
				Nome
			<input type="text" id='nome_usuario' name="nome_usuario" value="<?=$usuario->nome?>" valida_minlength='1' retorno='focus|Coloque no minimo 1 caracter no campo Nome do Usuário'/>
            </label>
            <div style="clear:both"></div>
            <label style="width:135px; margin-right:23px;">
				Login
			<input type="login" id='login_usuario' name="login_usuario" value="<?=$usuario->login?>" valida_minlength='1' retorno='focus|Coloque no minimo 1 caracter no campo Login do Usuário'/>
            </label>
            <label style="width:135px; margin-right:23px;">
				Senha
			<input type="password" id='senha_usuario' name="senha_usuario" value="<?=$usuario->senha?>" valida_minlength='1' retorno='focus|Coloque no minimo 1 caracter no campo Senha do Usuário'/>
            </label>
             <input type="hidden" name="id_usuario" id="id_usuario" value="<?=$usuario->id?>" />
		</fieldset>
    <fieldset  id='campos_4' style="display:none;"/>
			<legend>
				<a onclick="aba_form(this,0)">Cliente</a>
				<a onclick="aba_form(this,1)">Pacotes</a>
                <a onclick="aba_form(this,2)">Usuário</a>
                <a onclick="aba_form(this,3)"><strong>Revenda</strong></a>
                <a onclick="aba_form(this,4)">Contrato</a>
			</legend>

		     <div style="clear:both"></div>
            <label style="width:85px; margin-right:23px;">
            	Implanta&ccedil;&atilde;o 
                	<input type="text" decimal="1" name="porcento_implantacao" id="porcento_implantacao" style="width:50px; float:left; text-align:right;" value="<?=$revenda->porcento_implantacao;?>" valida_minlength='1' retorno='focus|Digite um valor para o campo % Implantaçao'><div style="padding:4px 5px 0 0">&nbsp;%</div>
            </label>
            <label style="width:85px; margin-right:23px;">
            	Mensalidade
            		<input type="text" decimal="1" name="porcento_mensalidade" id="porcento_mensalidade" style="width:50px; float:left; text-align:right;" valida_minlength='1' retorno='focus|Digite um valor para o campo % Mensalidade' value="<?=$revenda->porcento_mensalidade;?>"><div style="padding:4px 5px 0 0">&nbsp;%</div>
            </label>
            <label style="width:85px; margin-right:23px;">
            	Negocia&ccedil;&atilde;o
            		<input type="text" decimal="1" name="porcento_negociacao" id="porcento_negociacao" style="width:50px; float:left; text-align:right;" valida_minlength='1' retorno='focus|Digite um valor para o campo % Negociacao' value="<?=$revenda->porcento_mensalidade;?>"><div style="padding:4px 5px 0 0">&nbsp;%</div>
            </label>
             <label style="width:85px; margin-right:23px;">
            	<input type="hidden" name="revendedor_id" id="revendedor_id" value="<?=$revenda->id?>">
            </label>
		</fieldset>
        
        <fieldset  id='campos_5' style="display:none;"/>
			<legend>
				<a onclick="aba_form(this,0)">Cliente</a>
				<a onclick="aba_form(this,1)">Pacotes</a>
                <a onclick="aba_form(this,2)">Usuário</a>
                <a onclick="aba_form(this,3)">Revenda</a>
                <a onclick="aba_form(this,4)"><strong>Contrato</strong></a>
			</legend>

			<label>
<textarea name="texto" cols="80" rows="29" id="tx_html" style="display:none">
<?php
	
	if(!empty($revenda->contrato)){
		$texto = $revenda->contrato;

		echo $texto;
	}else{
		$contrato = mysql_fetch_object(mysql_query("SELECT * FROM contrato_modelo_revendedora WHERE id='$vkt_id'"));
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
	</fieldset>
	
	
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
<?
	if($cliente_vekttor_id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
	<input type='button' value='Imprimir Contrato' onclick="window.open('modulos/revenda_vekttor/revenda/impressao_contrato.php?id=<?=$revenda->id?>','_BLANK')" style="float:left;"/>
	<?
	}
	?>
<input name="action" type="button" id='botao_salvar' onclick="retorno = validaForm(frmrevendda);if(retorno!=false){html_to_form(); setTimeout('document.getElementById(\'botao_salvar\').parentNode.parentNode.submit();',500)}" <?=$DisaPago?>  value="Salvar" style="float:right; display:inline"  />
<input name="salva_formulario_contrato_aluguel" type="hidden" value="1" />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
<script>top.openForm()</script>

