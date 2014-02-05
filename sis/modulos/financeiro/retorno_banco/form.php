<?php

//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");

?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div id='aSerCarregado'>
    <div style="width:400px;">
    
        <div>
            <div class='t3'></div>
            <div class='t1'></div>
            <div class="dragme">
                <a class='f_x' onclick="form_x(this)"></a>        
                <span>Escolas</span>
            </div>
        </div>
        
		<form onsubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data">
            
            <fieldset id="campos_1">
                <legend>
                    <strong>Importação de Arquivos</strong>
                </legend>
                
                <label style="width:100%; margin-right:23px;">
                    Arquivo
                    <input type="file" name="arquivo" id="arquivo" />
                </label>
                
                <label style="width:100%;">
                    Tipo
                    <!-- 
                    'inadimplentes','bolsista','clientes_geral','cef','bb'
                    -->
                    <select name="tipo">
                        <option value="bb">Arquivo Retorno BB</option>
                        <option value="Bradesco">Arquivo Retorno Bradesco</option>
                        <option value="cef">Arquivo Retorno CEF</option>
                    </select>
                </label>
                
            </fieldset>
            
            <!--Fim dos fiels set-->
            <div style="width:100%; text-align:center" >
                <input name="action" type="submit"  value="Importar" style="float:right" />
                
                <div style="clear:both"></div>
            </div>
    	</form>
	</div>
</div>
<script>
	top.openForm();
</script>