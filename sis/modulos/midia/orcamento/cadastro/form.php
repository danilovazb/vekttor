<?
//Includes
// configuração inicial do sistema
include("../../../../_config.php");
// funções base do sistema
include("../../../../_functions_base.php");
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
<div style="width:1000px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Cadastro de Orçamento</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_0' >
		<legend> <span>Dados</span> </legend>
		
        <label style="width:100px;">N&ordm; Proposta <br/> &nbsp;
        	<div style="margin-top:-13px; margin-left:3px;"><b>00000001</b></div>
			<!--<input type="text" id='nome' name="nome" autocomplete='off' maxlength="30"/>-->
		</label>
        <input type="hidden" name="cliente_id" id="cliente_id" />
        <label>Cliente
			<input type="text" id='nome' name="nome" autocomplete='off' maxlength="30"/>    
		</label> 
        <label><br/>
        	<button type="button" id="btn-add-cliente" title="Cadastrar novo cliente" class="btn-add-cliente"><img  src="../fontes/img/adm.png" ></button>
        </label>
        
         <label>Descrição
			<input type="text" id='nome' name="nome" autocomplete='off' maxlength="30"/>
		 </label>
        
         <label style="width:90px;">Segundos do VT
			<input type="text" id='nome' name="nome" autocomplete='off' maxlength="30"/>
		 </label>
         <div style="clear:both"></div><br/>
        
        <label style="width:65px;">Painel <!-- Painel -->&nbsp;
          <select name="painel_id" id="painel_id">
              <option value="0">Painel</option>
              <option value="painel001">Painel0001</option>
          </select>
        </label>
        
         <label style="width:65px;">Plano <!-- Plano -->&nbsp;
            <select name="plano_id" id="plano_id">
                <option value="0">Plano</option>
                <option value="plano001">Plano0001</option>
            </select>
         </label>
        
        <label style="width:65px;">Tipo mídia<!-- Tipo mídia -->&nbsp;
          <select name="tipo_midia_id" id="tipo_midia_id">
              <option value="0">Tipo Mídia</option>
              <option value="midia001">Midia001</option>
          </select>
       	</label>
        
        <label style="width:55px;">Inserções
			<input type="text" id='insercao' name="insercao" sonumero="1" autocomplete='off' maxlength="20"/>
		</label>
        
        <label style="width:70px;">Valor
			<input type="text" id='valor' name="valor"decimal="2" autocomplete='off' maxlength="30"/>
		</label>
       
        <!--<div style="clear:both;"></div>-->
        
        <label style="width:80px;"><span><!--Período:--> de</span>
			<input type="text" id='periodo_inicio' name="periodo_inicio" calendario="1" autocomplete='off' maxlength="30"/>
		</label>
        <!--<label style="width:0;"><br/>à</label>-->
        <label style="width:80px;">à&nbsp;
			<input type="text" id='periodo_fim' name="periodo_fim" calendario="1" autocomplete='off' maxlength="30"/>
		</label>
        
        
        <label style="width:90px;">Frequência <!-- Frequência -->&nbsp;
          <select name="frequencia" id="frequencia">
              <option value="0">Frequência</option>
              <option value="diaria">Diária</option>
              <option value="mensal">Mensal</option>
              <option value="unitaria">Unitária</option>
          </select>
        </label>
        
       <label style="width:125px;">Observação
			<input type="text" id='observacao' name="observacao" autocomplete='off' maxlength="30"/>
	   </label>
       
       <label><br> &nbsp;
       		<img id="btn-dd-midia" class="img-add-midia" title="Adicionar" style="margin-top:1px;"  src="../fontes/img/mais.png" >
       </label>
       <div style="clear:both"></div><br/>
      
       
       <table cellpadding="0" cellspacing="0" width="97%">
       		<thead>
            	<tr>
                    <td style="width:180px">Painel</td>
                    <td style="width:150px">Plano</td>
                    <td style="width:45px;">Qtd</td>
                    <td style="width:70px;">Frequência</td>
                    <td style="width:50px;">Valor</td>
                    <td style="width:69px;">Valor total</td>
                    <td style="width:200px;">Obs</td>
                    <td style="width:50px;">Ação</td>
                </tr>
            </thead>
            <tbody></tbody>
       </table>
       
      <div class="div-table-list-painel">
       <table cellpadding="0" cellspacing="0" style="width:894px;" id="table-list-painel">
       		<tbody></tbody>
       </table>
     </div>  
    <br><br> 
    
    <div class="footer-left">
    
    <label style="width:380px;"> OBSERVAÇÃO
        <input type="text" name="obs" id="obs">
    </label>
    
    <label style="margin:2px 10px 4px"> <br/> Data Proposta </label>
    <label style="width:80px;"><br>
        <input type="text" name="data_proposta" id="data_proposta">
    </label>
    <div style="clear:both;"></div>
    <label style="width:90px;">Vendedor <!-- Vendedor -->&nbsp;
          <select name="vendedor_id" id="vendedor_id">
              <option value="0">Selecione</option>
              <option value="diaria">Diária</option>
              <option value="mensal">Mensal</option>
              <option value="unitaria">Unitária</option>
          </select>
    </label>
    
    <label style="width:90px;">Agência <!-- Vendedor -->&nbsp;
          <select name="agencia_id" id="agencia_id">
              <option value="0">Selecione</option>
              <option value="diaria">Diária</option>
              <option value="mensal">Mensal</option>
              <option value="unitaria">Unitária</option>
          </select>
    </label>
    
    <label style="width:90px;">Faturar <!-- Faturar -->&nbsp;
          <select name="faturar" id="faturar">
              <option value="agencia">Agência</option>
              <option value="cliente">Cliente</option>
          </select>
    </label>
    
    <label style="width:90px;"> <!-- Faturar -->&nbsp;
          <select name="faturar" id="faturar">
              <option value="liquido">Líquido</option>
              <option value="bruto">Bruto</option>
          </select>
    </label>
    
    
    <label style="margin:2px 10px 4px"> <br/> Validade </label>
    <label style="width:80px;"><br>
        <input type="text" name="data_proposta" id="data_proposta">
    </label>
    
    </div>
    
    <div class="footer-right">
    	
        <label style="width:118px;">Forma de Pagamento <!-- Forma de pagamento  -->
          <select name="forma_pagamento" id="forma_pagamento">
              <option value="agencia">Agência</option>
              <option value="cliente">Cliente</option>
          </select>
    	</label>
        
        <label style="width:100px;">Parcelas <!-- Parcelas  -->
          <select name="parcela" id="parcela">
              <option value="agencia">1x</option>
              <option value="cliente">2x</option>
          </select>
    	</label>
        
        <div style="clear:both;"></div>
        
         <label style="width:110px;">Desconto em (%)
        	<input type="text" name="data_proposta" id="data_proposta">
    	 </label>
         
         <label style="width:98px;">Desconto em (R$)
        	<input type="text" name="data_proposta" id="data_proposta">
    	 </label>
         <div style="clear:both"></div>
         
         <label style="width:112px;">Comissão de Agência
        	<input type="text" name="data_proposta" id="data_proposta">
    	 </label>
         
         <label style="width:130px;"><b>Valor da Proposta</b>
        	<input type="text" name="data_proposta" id="data_proposta">
    	 </label>
        
    </div>
       
	</fieldset>
	<input name="id" type="hidden" value="<?=$conta->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<? if($conta->id>0){ ?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<? } ?>

<input name="action" type="submit"  value="Salvar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>

</div>
</div>
</div>
<script>top.openForm()</script>