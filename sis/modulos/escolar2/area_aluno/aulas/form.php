<?
//Includes
include("../../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");


function exibe_icone($extensao = NULL){
	
	$array_icon = array( "pdf" => "file-pdf.png", "imagem" =>"arquivo.png", "file" => "file-pdf.png", "video" => "video_run.png", "default" => "clip-small.png" );
	
	$format_arquivo_pdf = array("pdf");
	$format_arquivo = array("doc","docx","xls","xlsx","csv");
	$format_imagem = array("jpeg","jpg","png","bitmap","bmp","gif","tiff","svg");
	$format_video  = array("flv","avi","wmv","wma","mp3","mp4","rm","3gp");
	
	  if (in_array($extensao, $format_imagem)) 
		  $icon = $array_icon["imagem"]; 
	  
	  else if(in_array($extensao,$format_video))
	  	  $icon = $array_icon["video"];
		
	  else if(in_array($extensao,$format_arquivo))
	  	  $icon = $array_icon["file"];
		  
	  else if(in_array($extensao,$format_arquivo_pdf))
	  	  $icon = $array_icon["pdf"];
	  
	  else 
	  	  $icon = $array_icon["default"];
	  
	  echo $icon;
	
}

?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;">
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Informações Aula </span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
    
	<fieldset>
		<legend>
          	<a onclick="aba_form(this,0)"><strong>Aula</strong> </a>
    		<a onclick="aba_form(this,1)"> Arquivos  </a>
         </legend>
       <label>
       	 <strong>Professor:</strong> <?=$professor->nome?>
       </label>
        <div style="clear:both;"></div>
       <label>
       		Descrição 
            <input type="text" readonly="readonly" value="<?=$aula_info->descricao?>">
       </label>
       <div style="clear:both;"></div>
	   <label>Observação geral
       		<textarea rows="8" cols="25"><?=$aula_info->observacao?></textarea>
       </label>	    
	</fieldset>
    
    <fieldset id="campos_2" style="display:none">
    	<legend>
          	<a onclick="aba_form(this,0)"> Aula </a>
    		<a onclick="aba_form(this,1)"> <strong>Arquivos</strong>  </a>
         </legend>
         
         <table cellpadding="0" cellspacing="0" width="100%" style="border-left:1px solid #CCC;">
         	<thead>
            	<tr >
                	<td width="30"></td>
                    <td width="150">Observação</td>
                    <td width="50"></td>
                </tr>
            </thead>
            <!-- -->
            <tbody>
            	<?php
                	$sql = mysql_query(" SELECT * FROM escolar2_upload WHERE aula_id = '".trim($_GET["aula_id"])."' "); 
					while($upload=mysql_fetch_object($sql)){
						$total++;
						if($total%2){$sel='class="al"';}else{$sel='';}
				?>
            	<tr <?=$sel?> style="background:#FFF;">
                	<td width="30"><span style="float:left;"><img src="../fontes/img/<?=exibe_icone(strtolower($upload->extensao))?>">&nbsp;</span></td>
                    <td width="150"><?=$upload->observacao?></td>
                    <td width="50"><a href="<? echo '../'.$upload->localizacao.$upload->arquivo;?>" target="_blank">Baixar</a></td>
                </tr>
                <?php
					}
				?>
            </tbody>
            
         </table>
         
    </fieldset>
    
	<!--Fim dos fiels set-->
	<div style="width:100%; text-align:center" >
	<?
	if($cargo->id>0){
	?>
	<input name="action" type="submit" value="Excluir" style="float:left" />
	<?
	}
	?>
	<input name="id" type="hidden" value="<?=$cargo->id?>"/>
    <input name="action" type="submit"  value="Salvar" disabled="disabled"  style="float:right;visibility:hidden;"  />
	<div style="clear:both"></div>
	</div>
    
    
</form>
</div>
</div>
</div>
<script>top.openForm()</script>