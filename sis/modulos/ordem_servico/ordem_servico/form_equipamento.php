<div id='exibe_formulario' class='exibe_formulario'  style="top:30px; left:50px;width:610px ">
<div id='aSerCarregado'>
  <div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div class="dragme" > <a class='f_x' id="close_form_os_equipamento"></a><span>Adicionar Equipamento</span></div> 
  </div>
	<form  id="form_equipamento_cadastro" class="form_float"  method="post" >
    <input type="hidden" name="equipamento_id" id="equipamento_id">
    <input type="hidden" name="os_id" id="os_id">
	<fieldset>
		 
        <legend>
          <a onclick="aba_form(this,0)"> <strong>Equipamento</strong> </a>
          <a onclick="aba_form(this,1)"> Histórico </a>
        </legend>
               
        <label style="width:150px;">
			Nº de Série
			 <input type="text" id='numero_serie' name="numero_serie"   />
		</label>
        <label style="width:250px;">
			Equipamento
			<input type="text" class="ca" id='equipamento' name="equipamento" busca='modulos/ordem_servico/ordem_servico/busca_equipamento_os.php,@r0 ,@r1-value>equipamento_id|@r2-value>modelo|@r3-value>marca|@r4-value>numero_serie,0' value=""   />
		</label>
        <label style="width:160px;">
			Modelo
			 <input type="text" class="ca" id='modelo' name="modelo"   />
		</label>
        <label style="width:150px;">
			Marca
			 <input type="text" class="ca" id='marca' name="marca" busca='modulos/ordem_servico/ordem_servico/busca_marca_equipamento.php,@r0,0'   />
		</label>
        <div style="clear:both;"></div>
        <label style="width:320px;">Estado Equipamento
        	<input type="text" class="ca" name="estado_equipamento" id="estado_equipamento">
        </label>
        <div style="clear:both;"></div>
        <label> Solicitação / Defeito
         <textarea cols="28" class="ca" name="solicitacao_defeito" id="solicitacao_defeito"></textarea>
        </label>
        
         <div style="clear:both;"></div> 
        <label> Diagnóstico / Laudo
         <textarea cols="28" class="ca" name="diagnostico_laudo" id="diagnostico_laudo"></textarea>
        </label>           
    </fieldset>
    
     <fieldset id="campos_2" style="display:none">
		 <legend>
            <a onclick="aba_form(this,0)"> Equipamento </a>
    		<a onclick="aba_form(this,1)"> <strong>Histórico</strong>   </a>
          </legend>
          <div class="table-historico"></div>
          <span class="historio-ativo"></span>
      </fieldset>
    
    <div id="action">
  		<button type="button" name="cadEquipamento" id="cadEquipamento" style="float:right;"> Adicionar </button>
    </div>
   <div style="clear:both"></div>
</form>
</div>
</div>