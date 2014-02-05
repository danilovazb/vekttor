<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo empreendimento
include("_functions.php");
include("_ctrl.php"); 

$horas_dia = array("00:00","01:00","02:00","03:00","04:00","05:00",
				"06:00","07:00","08:00","09:00","10:00",
				"11:00","12:00","13:00","14:00","15:00",
				"16:00","17:00","18:00","19:00","20:00",
				"21:00","22:00","23:00");

?>
<link href="../../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:600px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Visita</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong>Informa&ccedil;&otilde;es</strong>
		</legend>
        
		<label style="width:70px;">
        Data
		<input type="text" name="data_visita" id="data_visita" valida_minlength="3" 
        retorno="focus|Informe a Data da Visita" mascara="__/__/____" sonumero="1" value="<? if(!empty($data)){echo DataUsaToBr($data);}?>" calendario="1"/>
        </label>
        
        <label style="width:200px;">
        Técnico
        <select name="tecnico_id" id="tecnico_id" valida_minlength="1" 
        retorno="focus|Selecione um técnico">
		<option value="">SELECIONE UM TÉCNICO</option>
		<?php
        	$tecnicos = mysql_query("SELECT * FROM rh_funcionario WHERE vkt_id='$vkt_id'");
			while($t=mysql_fetch_object($tecnicos)){
				if($tecnico_id==$t->id){
					$selected='selected=selected';
				}
				else{$selected='';}
				echo "<option value='$t->id' $selected>$t->nome</option>";
			
			}
		?>
        </select>
        </label>
        
        <label style="width:80px;">
        Hora Início
        <select name="hora_inicial" id="hora_inicial"
         
		<? 
			if($_GET['tecnico_id']<=0&&$agenda->id<=0){
				echo "disabled='disabled'";
			}
		?>        	
        />
        	<?
            	foreach($horas_dia as $hora){
						$aux=$hora.":00";
             		foreach($horas as $h){
						if(($aux>=$h['hi'])&&($aux<=$h['hf'])&&($agenda->id!=$h['id'])){
							$disabled="disabled=disabled";
							break;
					}
					
					if($aux==$agenda->hora_inicial){
						$selected="selected=selected";
					}
				}
				echo "<option $disabled $selected>$hora</option>";
				$disabled='';
				$selected='';
				}
			?>
            
        </select>
        </label>
        
        <label style="width:80px;">
        Hora Fim
        
		<select name="hora_final" id="hora_final" 
		<? 
			if(($_GET['tecnico_id']<=0)&&($agenda->id<=0)){
				echo "disabled='disabled'";
			}
		?>
        />
        	<?
            	foreach($horas_dia as $hora){
						$aux=$hora.":00";
             		foreach($horas as $h){
						if(($aux>=$h['hi'])&&($aux<=$h['hf'])&&($agenda->id!=$h['id'])){
							$disabled="disabled=disabled";
							break;
						}
					}
					
					if($aux==$agenda->hora_final){
						$selected="selected=selected";
					}
					echo "<option $disabled $selected>$hora</option>";
					$disabled='';
					$selected='';
				}
			?>
        </select>
        </label>
        
                
       <div style="clear:both"></div>
       <label style="width:150px;">
	   Status
	   <? if($agenda->id>0){ ?>       
        <select name="status_visita">
		<option <?php if($agenda->status_visita=='Pendente'){echo 'selected=selected';}?>>Pendente</option>
        <option <?php if($agenda->status_visita=='Cancelado'){echo 'selected=selected';}?>>Cancelado</option>
        <option <?php if($agenda->status_visita=='Visitado'){echo 'selected=selected';}?>>Visitado</option>
        </select>
          
      	<?php
		}else{
			echo "<input type='text' name='status_visita' value='Pendente' disabled='disabled'/>";
		}
      		$cliente = mysql_fetch_object(mysql_query("SELECT * FROM cliente_fornecedor WHERE id='$agenda->cliente_id'"));
		?>
      	</label>
        <label style="width:300px;">
        Cliente
		<input type="text" name="cliente" id="cliente" value="<?php echo $cliente->razao_social?>"
        valida_minlength="3" 
        retorno="focus|Informe nome do cliente"
        busca='modulos/ordem_servico/agenda_visita/busca_cliente.php,@r1 @r2,@r0-value>cliente_id|@r1-value>cliente|@r4-value>c_endereco|@r3-value>c_contato|@r5-value>tel_residencial|@r6-value>tel_comercial|@r8-value>p_bairro|@r9-value>p_cep|@r10-value>p_email|@r11-value>p_cidade|@r12-value>p_estado'/>
        <input type="hidden" id="cliente_id" name="cliente_id" value="<?php echo $agenda->cliente_id?>"/>
        </label>
        
        <div style="clear:both"></div>
        
        <label style="width:200px;">
        Pessoa p/contato
		<input type="text" name="c_contato" id="c_contato" readonly="readonly" value="<?php echo $cliente->nome_contato?>">
        </label>
        
        <label style="width:250px;">
        Endereco
		<input type="text"  id="c_endereco" name="c_endereco" readonly="readonly" value="<?php echo $cliente->endereco?>">
        </label>
        
        <label style="width:100px;">
        Tel. Residencial
		<input type="text" name="tel_residencial" id="tel_residencial" readonly="readonly" value="<?php echo $cliente->telefone1?>">
        </label>
        
        <label style="width:100px;">
        Tel. Comercial
		<input type="text" name="tel_comercial" id="tel_comercial" readonly="readonly" value="<?php echo $cliente->telefone2?>">
        </label>
        
        <label style="width:100px;">
        Bairro
		<input type="text" name="p_bairro" id="p_bairro" readonly="readonly" value="<?php echo $cliente->bairro?>">
        </label>
        
        <label style="width:100px;" readonly="readonly">
        CEP
		<input type="text" name="p_cep" id="p_cep" readonly="readonly" value="<?php echo $cliente->cep?>">
        </label>
        
        <label style="width:170px;">
        Email
		<input type="text" name="p_email" id="p_email" readonly="readonly" value="<?php echo $cliente->email?>">
        </label>
        
        <label style="width:100px;">
        Cidade
		<input type="text" name="p_cidade" id="p_cidade" readonly="readonly" value="<?php echo $cliente->cidade?>">
        </label>
        
        <label style="width:50px;">
        Estado
		<input type="text" name="p_estado" id="p_estado" readonly="readonly" value="<?php echo $cliente->estado?>">
        </label>
        
        <label style="width:240px;">
        	Motivo da Visita
        	<textarea rows="10" name="motivo_visita"><?php echo $agenda->motivo_visita?></textarea>
        </label>
        <label style="width:240px;">
        	Observaçoes Gerais
        	<textarea rows="10" name="obs"><?php echo $agenda->observacao?></textarea>
        </label>
        
	</fieldset>
	<input name="id" id="id" type="hidden" value="<?=$agenda->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($agenda->id > 0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<input type="button" value="Imprimir" onclick="window.open('modulos/ordem_servico/relatorios/form_visita.php?id=<?=$agenda->id?>','_BLANK')" />
<?
}else{
?>
<input type="checkbox" name="imp" id="imp" checked="checked" value="1"/>Imprimir ao salvar
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