<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:270px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onclick='form_x(this)'></a>
    
    <span>CEF</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<a onclick="aba_form(this,0)"><strong>Informa&ccedil;&otilde;es</strong></a>
          
		</legend>
        
       <label>
            Selecione a Empresa
            <?php
				$empresas = mysql_query($t="SELECT * FROM rh_empresas e, cliente_fornecedor cf WHERE e.cliente_fornecedor_id=cf.id AND e.vkt_id='$vkt_id'");
			
			?>
            <select id='empresa_id' name="empresa_id"/>
           		<?
					while($empresa=mysql_fetch_object($empresas)){
						echo "<option value='$empresa->cliente_fornecedor_id'>$empresa->razao_social</option>";
					}
				?>
            </select>           
        </label>
        
        
                
	</fieldset>
	
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="gera_cef" id="gera_cef" type="button"  value="Gerar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>