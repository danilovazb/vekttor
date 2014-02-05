<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>
<style>
input,textarea{ display:block;}
</style>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:850px;height:400px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Contrato Cliente</span></div>
    </div>
	<form id='frmcontrato' class="form_float" method="post" enctype="multipart/form-data">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Contrato</strong>
		</legend>
        
		<label style="width:300px;">
        	Nome:
			<input type='text' name="nome" id="nome" value="<?=$contrato->nome?>" retorno="focus|Digite o Nome do Contrato" valida_minlength='3'>
		</label >
        
        <div style="clear:both"></div>
        <label style="display:none">
		<textarea name="texto" cols="25" rows="29" id="tx_html">
		<?php
			$contrato = mysql_fetch_object(mysql_query($t="SELECT * FROM odontologo_contrato_modelo WHERE id='".$_GET['id']."'"));
	
   			echo $contrato->contrato;

		?>



        </textarea>
              </label >
  
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
<a onclick="document.getElementById('divimagem').style.display='block'" href="#" title="Janela para inserir imagens"><img src="modulos/emailmarketing/emailmarketing/img/image_email.png" height="25"/></a>
<div style="clear:both"></div>

       <iframe id='ed' name='ed' width="75%" style="height:450px; background:#FFF; overflow:scroll;float:left" onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('tx_html').value;" frameborder="0" class="edtx" scrolling="yes"></iframe>

        
        
        
        
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
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_nome</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_ctps</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_cbo</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_remuneracao</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_cbo</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_hr_inicio</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_hr_fim</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_cargo</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@contratado_duracao</strong></a>
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
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@data_admissao</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@data_termino_contrato</strong></a>
        </div>
	</fieldset>
	<input name="id" id="id" type="hidden" value="<?=$contrato->id?>" />
	<input name="salva_formulario_contrato_cliente" type="hidden" value="1" />
	
<!--Fim dos fiels set-->
<?
	if($contrato->id>0){
?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
    <input name="action" type="button" value="Visualizar" id="Visualizar" style="float:left" />
<?
	}
?>

<div style="width:100%; text-align:center" >
<input name="action" type="button" id='botao_salvar' onclick="retorno = validaForm(frmcontrato);if(retorno!=false){ html_to_form(); setTimeout('document.getElementById(\'botao_salvar\').parentNode.parentNode.submit();',500)}"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
<div id="divimagem">
	<div class="t3"></div>
	<div class="t1"></div>
	<div class="dragme">
	<a class="f_x" onclick="this.parentNode.parentNode.style.display='none';"></a>
	<span>Imagem</span>
	</div>
	
    <label style="width:300px;margin-left:10%;">
     	<input type="file" name="imagem"/>
	</label >
    <div style="clear:both;margin-bottom:10px;"></div>
    <label style="width:300px;margin-left:10%;">
     	<input type="submit" name='action' value="Inserir Imagem" id="inserir_imagem"/>
	</label >
 	<div id="d_imagens">
	<?php
		$lista_imagens = mysql_query($t="SELECT * FROM modelo_contrato_imagens WHERE modelo_contrato_id='$contrato->id'");
		//alert($t);
		while($imagem = mysql_fetch_object($lista_imagens)){
			echo "<div style='height:70px;float:left;' id='$imagem->id'><img src='../upload/odonto/imagens_contrato/".$imagem->id.".".$imagem->extensao."' width='50' height='50' class='imagens'/><div style='clear:both'></div><a href='#' id='remover_imagem'>Remover</a></div>";
		}
	?>
    </div>
</div>

</form>
</div>
</div>
</div>
<script>
top.openForm();

</script>