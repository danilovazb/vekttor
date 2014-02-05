<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:300px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>HORA EXTRA</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
        <?php
		  $q= mysql_query($t="SELECT *, cf.id as cliente_forencedor_id FROM 
		  rh_empresas re,
		  cliente_fornecedor cf 
		  WHERE 
		  re.cliente_fornecedor_id = cf.id AND
		  cf.tipo='Cliente' AND 
		  cf.tipo_cadastro='Jurídico' AND 
		  re.vkt_id ='$vkt_id' AND 
		  re.status='1' 
		  ORDER BY cf.razao_social");
       ?>
        <label style="width:200px;">
        	Empresa
			<select name="empresa_id" id="empresa_id" valida_minlength="2" retorno"focus|Selecione uma Empresa">
          	
            <option value="">Selecione uma Empresa</option>  	
            
            <?php
				while($r=mysql_fetch_object($q)){
					echo "<option value='$r->id'>$r->razao_social</option>";				
				}
			?>    
                
            </select>
        </label>
        
        <div style="clear:both"></div>
        
        <label style="width:90px;">
        	Selecione o Mês
			<select name="mes" id="mes">
            	
                <?
					$c=1;
					foreach($mes_extenso as $mes){
						echo "<option value='$c'>".$mes."</option>";
						$c++;
					}
				?>
                
            </select>
        </label>
        
        <label style="width:90px;">
        	Ano
			<input type="text" name="ano" id="ano" />
        </label>
              
	</fieldset>
	<input name="id" type="hidden" value="<?=$inss->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($inss->id > 0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input type="button" id="imprimir" value="Imprimir" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>