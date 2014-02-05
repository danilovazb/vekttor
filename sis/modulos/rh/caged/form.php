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
    
    <span>CAGED</span></div>
    </div>
	<form onSubmit="return validaForm(this)" class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<a onclick="aba_form(this,0)"><strong>Informa&ccedil;&otilde;es</strong></a>
          
		</legend>
        
       <label>
            Mês
            <select id='mes' name="mes"/>
           		<?
					foreach($mes_abreviado as $mes => $m){
						echo "<option value='$mes'>$m</option>";
					}
				?>
            </select>           
        </label>
        
        <label style="width:30px;">
            Ano
            <input type="text" id='ano' name="ano" value="<?=date("Y")?>"/>
           	           
        </label>
        
        <div style="clear:both"></div>
       	<label style="width:120px;">
            Alteração Autorizado
            <select id='alteracao_autorizado' name="alteracao_autorizado"/>
            	<option value="1">Nada a Alterar</option>
                <option value="2">Alterar Dados Cadastrais</option>
            </select>           	           
        </label>
        
        <div style="clear:both"></div>
       	<label style="width:120px;">
            Alteração Estabelecimento
            <select id='alteracao_estabelecimento' name="alteracao_estabelecimento"/>
            	<option value="1">Nada a atualizar</option>
                <option value="2">Alterar dados cadastrais</option>
                <option value="3">Encerramento de Atividades</option>
            </select>           	           
        </label>
                
	</fieldset>
	
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<input name="gera_caged" id="gera_caged" type="button"  value="Gerar" style="float:right"  />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>