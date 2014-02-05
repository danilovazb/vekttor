<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_function.php");
include("_ctrl.php");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div>
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onclick="form_x(this)"></a>
    
    <span>Controle de Consumo</span></div>
    </div>
	<form onsubmit="return validaForm(this)" class="form_float" method="post">
    
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1'>
		<legend>
			<strong>Informações</strong>
		</legend>   
            
            <label style="width:120px;">
            <br/>
            	<select name="contrato_id">
                <option value="0">Contratos</option>
                 <?
                    $sql=mysql_query(" SELECT 
											*,cf.id as cf_id, 
											  cc.id as cc_id 
										FROM 
											cozinha_contratos cc
										JOIN cliente_fornecedor cf
										ON cf.id=cc.cliente_id
										WHERE vkt_id = '$vkt_id' ");
						while($r =mysql_fetch_object($sql)){
							if($controle_consumo->contrato_id == $r->cc_id){ $sel = 'selected="selected"';}else{$sel='';}
				 ?>
                    	<option <?=$sel?>  value="<?=$r->cc_id?>"><?=$r->razao_social?></option>
                 <?
						}
				 ?>
                </select>
            </label>
            
            <label style="width:90px;" >Dia
            	<?
                	if(isset($controle_consumo->data_cc))
						$data = dataUsaToBr($controle_consumo->data_cc);
					else
						$data = date('d/m/Y');
				?>
          		<input name="data" id="data" style="width:70px;" value="<?=$data?>" mascara='__/__/____' calendario='1' />
        	</label>
        <div style="clear:both; margin:8px;"></div>
        
        <div>
        	<table cellpadding="0" cellspacing="0" width="100%" >
				<thead>
   				  <tr >
                      <td width="200" >Prato</td>
                      <td width="90">Pedido</td>
                      <td width="90">Consumido</td>
        			</tr>
    			</thead>
			</table>
            
            <table  width="100%" border="0" cellpadding="0" cellspacing="0" >
            	<tbody>
   					<tr>
                      <td width="205">
                      <input readonly="readonly" type="text" name="campo[]" id="cafe" value="Café" style="height:11px; width:80px; font-size:12px" >
                      </td>
                      <td width="90" align="center">
                      <input type="text" name="pedido_cafe" size="5" style="height:11px; width:40px;" value="<?=$controle_consumo->pedido_cafe;?>"></td>
                      <td width="90" align="center">
                      <input type="text" name="consumido_cafe" size="5" value="<?=$controle_consumo->consumido_cafe;?>" style="height:11px; width:40px;"></td>

        			</tr>
        			<tr >
                      <td >
                      <input readonly="readonly" type="text" name="campo[]" id="almoco" value="Almoço" style="height:11px; width:80px; font-size:12px"></td>
                      <td width="90" align="center"><input type="text" name="pedido_almoco" size="5" value="<?=$controle_consumo->pedido_almoco;?>" style="height:11px; width:40px;"></td>
                      <td width="90" align="center"><input type="text" name="consumido_almoco" size="5" value="<?=$controle_consumo->consumido_almoco;?>" style="height:11px; width:40px;"></td>

        			</tr>
                    <tr>
                      <td>
                      <input readonly="readonly" type="text" name="lanche" id="lanche" value="Lanche" style="height:11px; width:80px; font-size:12px">
                      </td>
                      <td width="90" align="center">
                      <input type="text" name="pedido_lanche" size="5" value="<?=$controle_consumo->pedido_lanche;?>" style="height:11px; width:40px;"></td>
                      <td width="90" align="center"><input type="text" name="consumido_lanche" size="5" value="<?=$controle_consumo->consumido_lanche;?>" style="height:11px; width:40px;"></td>
        			</tr>
                    <tr>
                      <td >
                      <input readonly="readonly" type="text" name="campo[]" id="jantar" value="Jantar" style="height:11px; width:80px; font-size:12px">
                      </td>
                      <td width="90" align="center"><input type="text" name="pedido_jantar" size="5" value="<?=$controle_consumo->pedido_jantar;?>" style="height:11px; width:40px;"></td>
                      <td width="90" align="center"><input type="text" name="consumido_jantar" size="5" value="<?=$controle_consumo->consumido_jantar;?>" style="height:11px; width:40px;"></td>
        			</tr>
                    
                     <tr>
                      <td >
                      <input readonly="readonly" type="text" name="campo[]" id="seia" value="Ceia" style="height:11px; width:80px; font-size:12px">
                      </td>
                      <td width="90" align="center"><input type="text" name="pedido_seia" size="5" value="<?=$controle_consumo->pedido_seia;?>" style="height:11px; width:40px;"></td>
                      <td width="90" align="center"><input type="text" name="consumido_seia" size="5" value="<?=$controle_consumo->consumido_seia;?>" style="height:11px; width:40px;"></td>
        			</tr>
                 </tbody>
			</table>
            <table cellpadding="0" cellspacing="0" width="100%" >
              <thead>
                <tr >
                  <td width="200" >Total</td>
                  <td width="90">&nbsp;</td>
                  <td width="90">&nbsp;</td>
                </tr>
              </thead>
            </table>
        </div>
            
	</fieldset>
	<input type="hidden" name="id" id="id" value="<?=$controle_consumo->c_id;?>">	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($controle_consumo->c_id >0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<?
}
?>
<input name="action" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>