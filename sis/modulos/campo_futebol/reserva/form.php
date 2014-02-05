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
<div style="width:450px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Reserva</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" id="form_reserva_cadastro" method="post" autocomplete='off'>
    <input type="hidden" id='cliente_id' name="cliente_id" value="<?=$reserva->cliente_fornecedor_id?>" autocomplete='off' maxlength="44"/>
	<input type="hidden" name="conta_id" id="conta_id" value="<?=$configuracao->conta_id?>" />
    <!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong> Informações Reserva</strong>
		</legend>
		<label style="width:280px;">Cliente
		  <input type="text" id='cliente' name="cliente"  retorno='focus|Coloque no minimo 5 caracter' busca='modulos/campo_futebol/reserva/busca_cliente.php,@r1 @r2,@r0-value>cliente_id|@r1-value>cliente,0' value="<?=$reserva->razao_social?>"  maxlength="44" valida_minlength='3' />
		</label>
        <label style="width:50px;"><br/>
		  <button type="button" id="cad_cliente"> <img  src="../fontes/img/adm.png" > </button>
		</label><br/>
        
        <label style="width:100px;">Data
		  <input type="text" id='data_reserva' name="data_reserva" value="<? 
		  if(!empty($reserva->data_reserva))
		  	echo $reserva->data_reserva;
		  else
		  	echo date("d/m/Y");
		  ?>" calendario="1" autocomplete='off' maxlength="10"/>
		</label>
        
        <label style="width:120px;">
        	Tipo do Campo
        	<select name="tipo_campo" id="tipo_campo">
           		<option value="society">Para 7 pessoas</option>
                <option value="padrao">Para 11 pessoas</option>
            </select>
        </label>
        
            <!--modal Cadastra cliente -->
           <div style="position:absolute;  margin-top:30px;">
              <div class="modal" style="display:none">
              <div class="modal-header-2">
              	<a href="#" style="color:#CCC; font-weight:bold; float:right; padding:2px 6px;" class="modal_close">x</a>
                <span>Cadastro de Cliente</span>
              </div>
                    <div class="modal-body">
                    	<p>
                        	<div class="atl_natureza" style="padding:3px; height:30px;">
                            	<div style="float:left"><input type="radio" name="natureza" id="cpf" value="1" style="width:20px;">CPF</div>
                            	<div style="float:left"><input type="radio" name="natureza" id="cnpj" value="2" style="width:20px;">CNPJ</div>
                                <div style="margin-left:120px;">
                                	<select name="tipo" id="tipo" disabled="disabled">
                                    	<option value="Cliente">Cliente</option>
                                        <option value="Fornecedor">Fornecedor</option>
                                    </select>
                                </div>
                            </div>
                            <div style="clear:both;"></div>
                        	<div style=" float:left;"><label style="width:175px;">Nome<br/><input type="text" name="atl_nome" id="atl_nome" style="height:15px;" disabled="disabled"></label></div>
                            <div><label style="width:120px;">CNPJ/CPF <br/><input type="text" name="atl_cnpf_cpf" id="atl_cnpf_cpf" style="height:15px;" disabled="disabled"></label></div>      
                         </p>
                         <div><small style=" color:#999999; font-size:11px;">ap&oacute;s cadastro v&aacute; para tela clientes para completar as informa&ccedil;&otilde;es </small></div>
                    </div>
              <div class="modal-footer">
                <button type="button" name="atl_cadastrar" id="atl_cadastrar" disabled="disabled" >cadastrar</button>
              </div>
			</div>
    		</div><!--/.modal -->
        
        
        <div style="clear:both"></div>
        <div class="container_campos">
		   <?
              $sqlCampo = mysql_query(" SELECT * FROM campo_futebol WHERE vkt_id = '$vkt_id' ORDER BY id ASC ");
              while($campo=mysql_fetch_object($sqlCampo)){
				
				if( !empty($reserva->reserva_id) ){
					$itens = mysql_fetch_object( mysql_query($t=" SELECT * FROM ".TBL_ITEM_RESERVA." WHERE reserva_id = {$reserva->reserva_id} AND campo_id = {$campo->id} "));
					if($itens->id > 0){
						$checked = 'checked="checked"'; 	
					} else {
						$checked = '';
					}
				}
				  
           ?> 
          <input type="checkbox" id='campo' <?=$checked ?> name="campo[]" value="<?=$campo->id?>" />  <?=$campo->nome?> &nbsp; &nbsp;
          
		  <?php } ?>
        </div>
        
        
        <div style="clear:both"></div><br/>
    	
         
        <? 
		$tem_pgto_finalizado 	= mysql_query($a="SELECT * FROM financeiro_movimento WHERE cliente_id='$vkt_id' AND origem_id='$reserva->reserva_id' AND origem_tipo='reserva_campo' AND status='1' ORDER BY id");
		//echo $a;
		$c=1;
		while($tem_pgto=mysql_fetch_object($tem_pgto_finalizado)){
			$movimentacao_valor[$c] = $tem_pgto->valor_cadastro;
			$movimentacao_data[$c]  = $tem_pgto->data_info_movimento; 
			$c++;
		}
		//print_r($movimentacao_data);
		//print_r($movimentacao);
		
		//if(!mysql_num_rows($tem_pgto_finalizado)>0){
		?>
        <label style="width:130px; float:left;">Valor Total
		  <input type="text" id='valor_reserva' 
          name="valor_reserva" style="height:22px; font-size:16px; text-align:right; color:#777;" value="<?=moedaUsaToBr($reserva->valor_total)?>" readonly="readonly"/>
		</label>
        <?php
			$key = @array_search($reserva->valor,$movimentacao_valor);
			if($key>0){
				echo "<label style='font-weight:bold; font-size:14px; color:green;margin-top:20px;'>Pago em ".DataUsaToBr($movimentacao_data[$key])."</label>";
		?>
        <input type="hidden" id="efetivar_movimento2"  name="efetivar_movimento2" value="1" />
        <input type="hidden" id="data_info_movimento2" name="data_info_movimento2" value="<?=$movimentacao_data[$key]?>"/>
         <input type="hidden" id="pagou_total" name="pagou_total" value="1"/>
        <?php	
			}else{
		?>
         <label>Efetivar pagamento?
        	<input type="checkbox" id="efetivar_movimento2"  name="efetivar_movimento2" value="1" />
        </label>
                
        <div style="clear:both"></div>
        
        <label id="data_info_movimento_label2" style="width:80px; display:none;">Data do Pgto.
        	<input type="text" calendario='1' id="data_info_movimento2" name="data_info_movimento2" />
        </label>
        
        <label id="forma_pagamento2" style="display:none;width:150px;">
        Forma de pagamento
        	<select name="forma_pagamento_id2" id="forma_pagamento_id2">
            <? 
			$forma_pagamento_q=mysql_query("SELECT nome, id FROM financeiro_formas_pagamento WHERE vkt_id='$vkt_id'"); 
			while($forma=mysql_fetch_object($forma_pagamento_q)){
			?>
            	<option value="<?=$forma->id?>"><?=$forma->nome?></option>
            <?
			}
			?>
            </select>
        </label>
        
        <?php
			}
        ?>
        <div style="clear:both"></div>
        <label style="width:130px; float:left;">Valor Reserva
		  <input type="text" id='valor_entrada' 
          name="valor_entrada" style="height:22px; font-size:16px; text-align:right; color:#777;" value="<?=moedaUsaToBr($reserva->valor_da_reserva)?>" readonly="readonly"/>
		</label>
        <?php
			$key = @array_search($reserva->valor_reserva,$movimentacao_valor);
			
			if($key>0){
				echo "<label style='font-weight:bold; font-size:14px; color:green;margin-top:20px;'>Pago em ".DataUsaToBr($movimentacao_data[$key])."</label>";
		?>
        	<input type="hidden" id="efetivar_movimento"  name="efetivar_movimento" value="1" />
        	<input type="hidden" id="data_info_movimento" name="data_info_movimento" value="<?=$movimentacao_data[$key]?>"/>
             <input type="hidden" id="pagou_entrada" name="pagou_entrada" value="1"/>
        <?php
			}else{
		
		?>
          <label>Efetivar pagamento?
        	<input type="checkbox" id="efetivar_movimento"  name="efetivar_movimento" value="1" />
        </label>
        <div style="clear:both"></div>
     
        <label id="data_info_movimento_label" style="width:80px; display:none;">Data do Pgto.
        	<input type="text" calendario='1' id="data_info_movimento" name="data_info_movimento" />
        </label>
        
        <label id="forma_pagamento" style="display:none;width:150px;">
        Forma de pagamento
        	<select name="forma_pagamento_id" id="forma_pagamento_id">
            <? 
			$forma_pagamento_q=mysql_query("SELECT nome, id FROM financeiro_formas_pagamento WHERE vkt_id='$vkt_id'"); 
			while($forma=mysql_fetch_object($forma_pagamento_q)){
			?>
            	<option value="<?=$forma->id?>"><?=$forma->nome?></option>
            <?
			}
			?>
            </select>
        </label>
        <?php
			}
        ?>
        <div style="clear:both"></div>
        <label style="width:130px; float:left;">Valor Pendente
		  <input type="text" id='valor_pendente' 
          name="valor_pendente" style="height:22px; font-size:16px; text-align:right; color:#777;" value="<?=moedaUsaToBr(($reserva->valor_total-$reserva->valor_da_reserva))?>" readonly="readonly"/>
		</label>
       
        <? //}else{
			?>
            <!--<input type="hidden"  name="valor_reserva" style="height:22px; font-size:16px; text-align:right; color:#777;" value="<?=moedaUsaToBr($reserva->valor_da_reserva)?>" autocomplete='off' decimal="2" />
			-->
           
            <label style="font-weight:bold; font-size:14px; color:green;">
            
            
			<?php
			while($tem_pgto=mysql_fetch_object($tem_pgto_finalizado)){
				echo "R$: ".moedaUsaToBr($tem_pgto->valor_cadastro)?> Pago em <?=dataUsaToBr($tem_pgto->data_info_movimento)."<br>";
			}
			?> 
            </label>
            <?
		//}?>
        
        <div style="clear:both"></div>
        
        <div style="overflow:auto; height:150px; width:100%; float:left;">
        <table cellpadding="0" cellspacing="0" width="100%"> 
        	<thead>
            	<tr>
                	<td style="width:15%;">#</td>
                    <td style="width:20%;">Horário</td>
                    <td style="width:30%;" id="nome_cliente_table">Campo</td>
                    <td style="width:90%;" id="nome_cliente_table">Cliente </td>
                </tr>
            </thead>
            <tbody id="tbody_horarios">
             <? 
				for($i = 0; $i < 24; $i++){
					$j = $i <= 9 ? "0".$i : $i;
					
					if($i%2==0){$s="class='al'";}else{$s='';} 
					
					$horas = $j.":00";
					
					if( !empty($reserva->reserva_id) ){
						$sql_itens = mysql_query($t="  SELECT *,DATE_FORMAT(horario.data_hora, '%H:%i') AS hora FROM ".TBL_ITEM_RESERVA." AS horario 
						JOIN ".TBL_RESERVA." AS reserva ON reserva.id = horario.reserva_id
						WHERE horario.reserva_id = {$reserva->reserva_id} ");
						
						while($itens=mysql_fetch_array($sql_itens)){
							$horas_ocupadas[] = $itens["hora"];
							//Campos
							$campo = mysql_fetch_array( mysql_query(" SELECT * FROM campo_futebol WHERE id = ".$itens["campo_id"]."  "));
							$json[$itens["hora"]]['nome_campo'][]= $campo["nome"];
							
							//Cliente
							$cliente = mysql_fetch_array(mysql_query( " SELECT * FROM cliente_fornecedor WHERE id = ".$itens["cliente_fornecedor_id"]." " ));
							$json[$itens["hora"]]['cliente'][]= $cliente["razao_social"];		
						}
						
						if (@in_array($horas, $horas_ocupadas)) { 
   							
							 $campos_nome = implode("<br />",array_unique($json[$horas]['nome_campo']));
							 $cliente = implode("<br />",array_unique($json[$horas]['cliente']));
							 
							 $td = '<td style="color:#CCC;">
							 	<input type="checkbox" checked="checked" disabled id="horario_reserva" value="'.$horas.'">
								<input type="hidden" name="horario_reserva[]" value="'.$horas.'"/>
							</td>';
							 $td .= '<td style="color:#CCC;">'.$horas.'</td>';
							 $td .= '<td style="color:#CCC;">'.$campos_nome.'</td>';
							 $td .= '<td style="color:#CCC;">'.$cliente.'</td>';
							 	
						} else{
							 $td = '<td><input type="checkbox" id="horario_reserva" name="horario_reserva[]" value="'.$horas.'"></td>';
							 $td .= '<td>'.$horas.'</td>';
							 $td .= '<td></td>';
							 $td .= '<td></td>';
						}
						
					} else {
						$td = '<td><input type="checkbox" id="horario_reserva" name="horario_reserva[]" value="'.$horas.'"></td>';
						$td .= '<td>'.$horas.'</td>';
						$td .= '<td></td>';
						$td .= '<td></td>';
						
					}
					
			 ?>
            	<tr id="" <?=$s?> style="background:#FFF;">
                	<?=$td?>
                </tr>
            <?
				}
			?>
            </tbody>
        </table>
	    </div>
        
	</fieldset>
	<input name="id" type="hidden" value="<?=$reserva->reserva_id?>" />
    <?
	$verifica_pag=mq("SELECT * FROM financeiro_movimento WHERE cliente_id='$vkt_id' AND origem_id='<?=$reserva->reserva_id?>' AND origem_tipo='Reserva de campo de futebol' AND status='1' ");
	if($verifica_pag->id>0){
		$status_pagamento='pago';
	}else{
		$status_pagamento='pendente';
	}
	?>
	<input type="hidden" name="status_pagamento" value="<?=$status_pagamento?>" />
<!--Fim dos fiels set-->

    <div style="width:100%; text-align:center" >
    <? if($reserva->reserva_id > 0){ ?>
    <input name="action" type="submit" value="Excluir" style="float:left" />
    <? } 
    // if ( empty($reserva->reserva_id) ) {
    ?>
    <input name="action" type="submit"  value="Salvar" id="Salvar" style="float:right"  />
    <?
     //}
    ?>
    <div style="clear:both"></div>
    </div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>