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
<div style="width:650px;">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>EmailMarketing</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data" target="" id="form_email">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset>
		<legend>
			<a onclick="aba_form(this,0)"><strong>EmailMarketing</strong></a>
            <a onclick="aba_form(this,1)">Filtros</a>
		</legend>
           <label style="width:300px;">
        	Título do Email:
			<input type='text' name="nome_envio" id="nome_envio" value="<?=$email->nome_envio?>" retorno="focus|Digite o Nome do Contrato" valida_minlength='3'>
		</label >
        
        <div style="clear:both"></div>
		
        <div style="clear:both"></div>
        <label style="width:300px;">
        	Remetente:
			<input type='text' name="email_envio" id="email_envio" value="<?=$email->email_envio?>" retorno="focus|Digite o Nome do Contrato" valida_minlength='3'>
		</label >
        
        <div style="clear:both"></div>
        
        <label style="width:40px">
<select name="select"class="in"style="margin-right:5px" onchange="ti('fontsize',this.options[this.selectedIndex].value)"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option>  </select>
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
<a ><img  src="fontes/img/link.png"/>1111</a>
<div align="right">
<a onclick="document.getElementById('textarea_texto').style.display='none';document.getElementById('ed').style.display='block';form_to_html();" href="#"><img src="modulos/emailmarketing/emailmarketing/img/text_email.png" height="25"/></a>
<a onclick="document.getElementById('ed').style.display='none';document.getElementById('textarea_texto').style.display='block';html_to_form();" href="#"><img src="modulos/emailmarketing/emailmarketing/img/html.png" height="25"/></a>
<a onclick="document.getElementById('divimagem').style.display='block'" href="#"><img src="modulos/emailmarketing/emailmarketing/img/image_email.png" height="25"/></a>
</div>
<div style="clear:both"></div>
<div id="textarea_texto" style="display:none;width:100%">
        <label>
		<textarea name="texto" id="tx_html" cols="300" rows="25">
		<?php
			echo $email->html
			

		?>
		
	   </textarea>
              </label >
  		</div>
<div id="frame_texto">
       <iframe id='ed' name='ed' width="100%" style="height:345px; background:#FFF;  overflow:scroll;float:left"  onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('tx_html').value;" frameborder="0"class="edtx"></iframe>
</div>
       <div style="clear:both"></div>

        
        
        
        <!--<div id="esquerda" style="float:right;overflow:auto">
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
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@valor_mensalidade</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@valor_implantacao</strong></a>
            <div style="clear:both"></div>
            <a href="#" onclick="ti('InsertHTML',this.innerHTML) "><strong>@dia_implantacao</strong></a>
        </div>-->
	</fieldset>
    <fieldset style="display:none">
		<legend>
			<a onclick="aba_form(this,0)">EmailMarketing</a>
            <a onclick="aba_form(this,1)"><strong>Filtros</strong></a>
		</legend>
        
	<label style="width:300px;">
        	Mes de Aniversario
            <select name="mes" id="mes">
				<option value=""></option>
                <option value="1" <?php if($email->mes_aniversario==1){echo "selected='selected'";}?>>JANEIRO</option>
                <option value="2" <?php if($email->mes_aniversario==2){echo "selected='selected'";}?>>FEVEREIRO</option>
                <option value="3" <?php if($email->mes_aniversario==3){echo "selected='selected'";}?>>MARÇO</option>
                <option value="4" <?php if($email->mes_aniversario==4){echo "selected='selected'";}?>>ABRIL</option>
                <option value="5" <?php if($email->mes_aniversario==5){echo "selected='selected'";}?>>MAIO</option>
                <option value="6" <?php if($email->mes_aniversario==6){echo "selected='selected'";}?>>JUNHO</option>
                <option value="7" <?php if($email->mes_aniversario==7){echo "selected='selected'";}?>>JULHO</option>
                <option value="8" <?php if($email->mes_aniversario==8){echo "selected='selected'";}?>>AGOSTO</option>
                <option value="9" <?php if($email->mes_aniversario==9){echo "selected='selected'";}?>>SETEMBRO</option>
                <option value="10" <?php if($email->mes_aniversario==10){echo "selected='selected'";}?>>OUTUBRO</option>
                <option value="11" <?php if($email->mes_aniversario==11){echo "selected='selected'";}?>>NOVEMBRO</option>
                <option value="12" <?php if($email->mes_aniversario==12){echo "selected='selected'";}?>>DEZEMBRO</option>
            </select>
	</label >
    <div style="clear:both"></div>
    <label style="width:300px;">
        	Bairro
            <select name="bairro" id="bairro">
            <option value=""></option>
			<?php
				$bairros = mysql_query($t="SELECT DISTINCT(bairro) FROM cliente_fornecedor WHERE cliente_vekttor_id='$vkt_id' ORDER BY bairro");
				//echo $t;
				while($b=mysql_fetch_object($bairros)){
					if($email->bairro==$b->bairro){
						$selected = "selected='selected'";
					}
					echo "<option value='$b->bairro' $selected>$b->bairro</option>";
					$selected='';
				}
			?>	                
            </select>
	</label >
    <div style="clear:both"></div>
    <label style="width:300px;">
        	Grupo
            <select name="grupo_id" id="grupo_id">
            <option value=""></option>
			<?php 
				$grupos = mysql_query("SELECT * FROM cliente_fornecedor_grupo WHERE vkt_id = '$vkt_id'");
				while($g=mysql_fetch_object($grupos)){
					if($email->grupo_id==$g->id){
						$selected = "selected='selected'";
					}
					echo "<option value='$g->id' $selected>$g->nome</option>";
					$selected='';
				}
			?>
            </select>
		</label >
       
        <div style="clear:both"></div> 
	</fieldset>
          
	<input name="id" id="id" type="hidden" value="<?=$email->id?>" />
    <input name="salva_formulario_contrato_cliente" id="salva_formulario_contrato_cliente" type="hidden" value="1" />
		
<!--Fim dos fiels set-->
<?
	if($email->id>0){
?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
<?
	}
?>

<div style="width:100%; text-align:center" >
<label style="width:300px;">
     	<input type="checkbox" name="enviar_email" value="1" checked="checked"/>Enviar Email
</label >
<input name="action" type="button" id='botao_salvar' onclick="html_to_form(); setTimeout('document.getElementById(\'botao_salvar\').parentNode.parentNode.submit();',500);document.getElementById('form_email').setAttribute('target','')"  value="Salvar" style="float:right"  />
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
    <div style="clear:both;"></div>
 	<div id="d_imagens">
	<?php
		$lista_imagens = mysql_query($t="SELECT * FROM emailmarketing_imagens WHERE emailmarketing_id='$email->id'");
		//alert($t);
		while($imagem = mysql_fetch_object($lista_imagens)){
			echo "<div style='height:70px;float:left;' id='$imagem->id'><img src='modulos/emailmarketing/emailmarketing/img/".$imagem->id.".".$imagem->extensao."' width='50' height='50' class='imagens'/><div style='clear:both'></div><a href='#' id='remover_imagem'>Remover</a></div>";
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