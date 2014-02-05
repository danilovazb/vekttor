<?php
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php");
//pr($_POST);
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:800px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onClick="window.open('modulos/vekttor/item_menu/form.php?id=<?php echo $modulo->id;?>','carregador')"></a>
    
    <span>Tutorial</span></div>
    </div>
	<form onSubmit="return validaForm(this)" autocomplete='off' class="form_float" method="post" enctype="multipart/form-data" target="carregador" id="form_arquivo">
    
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1'>
		<?php
    		$id_progresso = md5(microtime() . rand());
    	?>

    	<input id="id_chave" type="hidden" name="UPLOAD_IDENTIFIER" value="<?php echo $id_progresso;?>" />

        <legend>
			<a onclick="aba_form(this,0)"><strong>Tutorial</strong></a>
                      
		</legend>
        	<label style="width:250px;">
				Modulo
                <input type="text" name="modulo_nome" id="modulo_nome" value="<?php echo $modulo->nome;?>" disabled="disabled"/>
                <input type="hidden" name="modulo_id" id="modulo_id" value="<?php echo $modulo->id;?>" />
			</label>      
       
        <label style="width:100px;">
			Ordem <input type="text" name="ordem" id="ordem" value="<?php echo $tutorial->sequencia?>"/>        
    	</label>
        
        <label style="width:300px;">
			Título <input type="text" name="titulo" id="titulo" value="<?php echo $tutorial->titulo?>"/>        
    	</label>
        <div style="clear:both"></div>
			<label style="display:none">
		<textarea name="texto" cols="27" rows="29" id="tx_html"  >
			<?php echo $tutorial->texto?>
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
<div style="clear:both"></div>

       <iframe id='ed' name='ed' width="100%" style="height:345px; background:#FFF;  overflow:scroll;float:left" onload="this.contentWindow.document.designMode='on'; this.contentWindow.document.body.innerHTML=document.getElementById('tx_html').value;" frameborder="0"class="edtx"></iframe>

        
        
        
        
    
        <?php echo "<strong>Tamanho máximo dos arquivos:</strong> ".ini_get('max_file_uploads')." MB";?>
        <div style="clear:both"></div>
        <label style="width:300px;">
			Arquivo 1<input type="file" name="arquivo1" id="arquivo1"/>
           	<br>
            <?php
				if(!empty($tutorial->extensao1)){
			?>
            <span id="sarquivo1">
			<?php echo "Arquivo ".substr($tutorial->extensao1,-3);?> <a href="#" onclick="document.getElementById('sarquivo1').style.display='none';window.open('modulos/vekttor/item_menu/deletararquivo.php?id=<?=$_GET['tutorial_id']?>&extensao=<?php echo $tutorial->extensao1?>&ordem=1','carregador');">Remover</a>
            </span>               
    		<?php
				}
			?>
        </label>			
		
         <label style="width:300px;">
        
			Arquivo 2<input type="file" name="arquivo2" id="arquivo2" />
         	<br>
            <?php
				if(!empty($tutorial->extensao2)){
			?>
            <span id="sarquivo2">
			<?php echo "Arquivo ".substr($tutorial->extensao2,-3);?> <a href="#" onclick="document.getElementById('sarquivo2').style.display='none';window.open('modulos/vekttor/item_menu/deletararquivo.php?id=<?=$_GET['tutorial_id']?>&extensao=<?php echo $tutorial->extensao2?>&ordem=2','carregador');">Remover</a>
            </span>               
    		<?php
				}
			?>
    	</label>
        <div style="clear:both"></div>
         <div id='vkt_barra' style="width:300px; display:none; height:20px; position:relative; border-radius:5px; border:1px solid #CCC; margin:5px; padding:1px; text-align:center; ">
                                <div id='vkt_barra_progresso' style="height:20px; text-align:center; border-radius:5px; width:0%; background:#093;">
                                </div>
                                <span style="position:absolute; width:300px; height:20px; line-height:20px;  top:0; left:0; font-weight:bold;"><span id="progresso">Carregando</span>%</span>
                        </div>
           
	</fieldset>
       
	<input name="id" type="hidden" value="<?php echo $_GET['tutorial_id']?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >


<input name="id_tutorial" type="hidden" value="<?=$vkt_id?>" />
<input name="salva_texto_html" type="hidden" value="1" />
<input name="action" type="button" id='botao_salvar' onclick="html_to_form(); setTimeout('document.getElementById(\'botao_salvar\').parentNode.parentNode.submit();',500);checaprogresso()"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>