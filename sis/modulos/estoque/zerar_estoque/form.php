<?
//Includes
include("../../../_config.php");
include("../../../_functions_base.php");
include("_functions.php");
include("_ctrl.php");
?>

<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div style="width:600px">
<div id='aSerCarregado'>
<div>
<div >

	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Zerar Estoque</span></div>
    </div>
<form onsubmit="return validaForm(this)" class="form_float" method="post" enctype="multipart/form-data">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<a onclick="aba_form(this,0)"><strong>Zerar Estoque</strong></a>          
		</legend>
		<!--<label width style=" width:90px;">Codigo
        <input type="text" /></label>-->
        <label style="width:150px;">
			Selecione a unidade
			<select name="unidade_id" id="unidade_id" >
            <option></option>
			<?
            	$unidades = mysql_query("SELECT * FROM cozinha_unidades WHERE vkt_id='$vkt_id'");
				while($unidade = mysql_fetch_object($unidades)){
					echo "<option value='$unidade->id'>$unidade->nome</option>";
				}
			?>
            </select>
		</label>
       	
         <div style="clear:both"></div> 
        <input type="radio" name="modo" class="modo" value="inventario" checked="checked"/>Inventário
        <div style="clear:both"></div>
        <input type="radio" name="modo" class="modo" value="consumo" />Consumo
        
        <div style="clear:both"></div>
        
        <!--<div id="div_fornecedor" style="display:none;margin-top:10px;">
        	<label style="width:150px;">
			Selecione o Fornecedor
   			 <select id="fornecedor_id_filt" name="fornecedor_id_filt">
   			 <option value=""></option>
   			 <? 
			$fornecedores_q=mysql_query("SELECT * FROM cliente_fornecedor WHERE cliente_vekttor_id='$vkt_id' AND tipo='Fornecedor' ORDER BY razao_social ASC"); 
			while($fornecedor=mysql_fetch_object($fornecedores_q)){
			?>
    		<option value="<?=$fornecedor->id?>" <? if(isset($_GET['fornecedor_id_filt'])&&$_GET['fornecedor_id_filt']==$fornecedor->id){echo "selected=selected";}?>><?=$fornecedor->razao_social?></option>
    		<? } ?>
    		</select>
		</label>
        </div>-->
        
        
	</fieldset>   
    
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="action" type="submit"  value="Zerar Estoque" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>

</div>
</div>
</div>

<script>top.openForm()</script>