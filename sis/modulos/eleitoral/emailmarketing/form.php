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
<div style="width:900px;">
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
        	Assunto do Email:
			  <input type='text' name="nome_envio" id="nome_envio" value="<?=$email->nome_envio?>" retorno="focus|Digite o Nome do Contrato" valida_minlength='3'>
		</label >
        
        <div style="clear:both"></div>
		
        <div style="clear:both"></div>
        <label style="width:300px;">Remetente :
			  <input type='text' name="email_envio" id="email_envio" value="<?=$email->email_envio?>" retorno="focus|Digite o Nome do Contrato" valida_minlength='3'>
		</label >
        
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
<a style="margin-left:20px;float:left;" title="Adicionar Link" rel="tip" id="adicionar_link"><img src="../fontes/img/link.png" height="32"/></a>
<div align="right">
<!--<input type="button" id="importar_noticias" value="importar_noticias"/>-->
<a onclick="document.getElementById('modo_edicao').value='texto';document.getElementById('textarea_texto').style.display='none';document.getElementById('ed').style.display='block';form_to_html();" href="#" title="Edita o email no modo texto"><img src="modulos/eleitoral/emailmarketing/img/text_email.png" height="25"/></a>
<a onclick="document.getElementById('modo_edicao').value='html';document.getElementById('ed').style.display='none';document.getElementById('textarea_texto').style.display='block';html_to_form();" href="#" title="Edita o email no modo html"><img src="modulos/eleitoral/emailmarketing/img/html.png" height="25"/></a>
<a onclick="document.getElementById('divimagem').style.display='block'" href="#" title="Janela para inserir imagens"><img src="modulos/emailmarketing/emailmarketing/img/image_email.png" height="25"/></a>
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
    <div style="clear:both"></div>
      <label style="width:150px;">Estado
       		<?php
             	$estados = mysql_query("SELECT DISTINCT(estado) FROM eleitoral_eleitores WHERE estado!='' AND estado!='null'");	
      		?>
			<select name="estado" id="estado">
            	<option value="">Todos</option>
                <?
                	while($estado=mysql_fetch_object($estados)){
				?>
                <option value="<?=$estado->estado?>"><?=$estado->estado?></option>
                <?
					}
				?>
            </select>
      </label>
      
      <div style="clear:both"></div>     
       <label style="width:150px;">Cidade
       		<?php
             	$cidades = mysql_query("SELECT DISTINCT(cidade) FROM eleitoral_eleitores WHERE cidade!=''");	
      		?>
			<select name="cidade" id="cidade">
            	<option value="">Todas</option>
                <?
                	while($cidade=mysql_fetch_object($cidades)){
				?>
                <option value="<?=$cidade->cidade?>"><?=$cidade->cidade?></option>
                <?
					}
				?>
            </select>
      </label>
      <div style="clear:both"></div>  
    <label>
        	Bairro
            <select name="bairro" id="bairro">
            <option value=""></option>
			<?php
				$bairros = mysql_query($t="SELECT DISTINCT(bairro) FROM eleitoral_eleitores WHERE vkt_id='$vkt_id' ORDER BY bairro");
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
     
     <label>
        	Sexo
            <select name="sexo" id="sexo">
            <option value=""></option>
			<option value="m">Masculino</option>
            <option value="f">Feminino</option>	                
            </select>
	</label >
     <div style="clear:both"></div>
     
    <label style="width:400px;">
    Selecione um grupo social
    <select id='grupo_social' name="grupo_social"/>
        <option></option>
    	<?php
			$grupos_sociais = mysql_query("SELECT * FROM eleitoral_grupos_sociais WHERE vkt_id='$vkt_id'");
			while($grupo_social = mysql_fetch_object($grupos_sociais)){
				if($email->grupo_social_id== $grupo_social->id){$s='selected="selected"';}else{$s='';}
        ?>
        	<option value="<?=$grupo_social->id?>" <?=$s?>><?=$grupo_social->nome?></option>
        <?php
			}
		?>
    </select>
  </label>
    <div style="clear:both"></div>
   <label style="width:85px;">Status do Voto
  <select name="status_voto" id="status_voto">
        <option></option>
        <option <? if($email->status_voto=='sim')echo "selected='selected'";?> value="sim">certo</option>
        <option <? if($email->status_voto=='nao')echo "selected='selected'";?> value="nao">nao</option>
        <option <? if($email->status_voto=='incerto')echo "selected='selected'";?> value="incerto">incerto</option>
        <option <? if($email->status_voto=='aberto')echo "selected='selected'";?> value="aberto">Em aberto</option>
      </select>
  </label>
          <div style="clear:both"></div> 
           <label style="width:300px;">
        	Limitar envio em :
			  <input name="limite" style="width:40px" type='text' id="limite" size="3" > e-mails
		</label >
          <div style="clear:both"></div> 
           <label style="width:300px;">
        	Envio de teste :
			  <input name="emailteste" style="width:120px" type='text' id="limite" > Será enviado somte para este email caso esteje preenchido
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
     	<input type="checkbox" name="enviar_email" value="1"/>Enviar Email
</label >
<input name="action" type="button" id='botao_salvar' onclick="if(document.getElementById('modo_edicao').value=='texto'){html_to_form();}else{form_to_html();} setTimeout('document.getElementById(\'botao_salvar\').parentNode.parentNode.submit();',500)"  value="Salvar" style="float:right"  />
<input type="hidden" name="modo_edicao" id="modo_edicao" value="texto" />
<div style="clear:both"></div>
</div>
<div id="divimagem">
	<div class="t3"></div>
	<div class="t1"></div>
	<div class="dragme">
	<a class="f_x" onclick="this.parentNode.parentNode.style.display='none';fechaDente()"></a>
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
		$lista_imagens = mysql_query($t="SELECT * FROM eleitoral_emailmarketing_imagens WHERE eleitoral_emailmarketing_id='$email->id'");
		//alert($t);
		while($imagem = mysql_fetch_object($lista_imagens)){
			echo "<div style='height:70px;float:left;' id='$imagem->id'><img src='modulos/eleitoral/emailmarketing/img/".$imagem->id.".".$imagem->extensao."' width='50' height='50' class='imagens'/><div style='clear:both'></div><a href='#' id='remover_imagem'>Remover</a></div>";
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