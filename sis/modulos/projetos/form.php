<?
//Includes
// configuração inicial do sistema
include("../../_config.php");
// funções base do sistema
include("../../_functions_base.php");
// funções do modulo empreendimento
include("_function_projeto.php");
include("_ctrl_projeto.php"); 
pr($_POST);
?>
<style>
input,textarea{ display:block;}
</style>
<link href="../../../fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div style="width:400px">
<div>
	<div class='t3'></div>
	<div class='t1'></div>
    <div  class="dragme" >
	<a class='f_x' onClick="form_x(this)"></a>
    
    <span>Projeto</span></div>
    </div>
	<form onSubmit="return validaForm(this)" autocomplete='off' class="form_float" method="post">
	<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
	<fieldset  id='campos_1' >
		<legend>
			<strong id='escreve'>Informações</strong>
		</legend>
        <input type="hidden" name='cliente_fornecedor_id' id='cliente_fornecedor_id' value="<?=$c->id;?>" />
		<label style="width:311px;">
			Cliente
			  <input type="text" id='nome' busca='modulos/projetos/busca_clientes.php,@r0 @r2,@r1-value>cliente_fornecedor_id,0' autocomplete='off' name="nome" value="<?=$c->razao_social;?>" maxlength="44"  valida_minlength="3"  retorno='focus|Coloque no minimo 3 caracter' />
		</label>
        <label style="" > Nome do Projeto
        	<input name="nome_projeto" value="<?=$registro->nome; ?>" width="60px" />
        </label>
        
        <label style="width:100px;" >Tempo Estimado<input name="tempo" style="width:100px;" value="<?=$registro->tempo?>"  size="4" minlength="4" />(em horas)
          
        </label>
        
        <label style="width:100px;" >Data Limite
          <input name="data_limite" id="data_limite" style="width:100px;" value="<?=dataUsaToBr($registro->data_limite);  ?>" mascara='__/__/____' calendario='1' />
        </label>
        <label style="width:100px;" >Situação
          <select name="status" id='status'>
          <?
           $sti[$registro->status]='selected="selected"';
		   ?>
           	<option value="em andamento" <?=$sti['em andamento']?>>em andamento</option>
         	<option value="finalizado" <?=$sti['finalizado']?> >Finalizado</option>
          	<option value="excluido" <?=$sti['excluido']?>>Excluido</option>
          </select>
        </label>
        <label style="width:311px;">
          Descricao
          <textarea name="descricao" id="descricao"><?=$registro->descricao?></textarea>
		</label>
		
	</fieldset>
	<input name="id" type="hidden" value="<?=$registro->id?>" />
	
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<?
if($registro->id>0){
	if(mysql_num_rows(mysql_query("SELECT * FROM projetos_atividades WHERE projeto_id='{$registro->id}' AND situacao='0' "))>0){
		$alerta=":este projeto possui <a href='?tela_id=92&projeto_id={$registro->id}'>atividades</a> incompletas'";
	}else{
		$alerta='';
	}
	if($alerta== ''){
?>
		<input name="action" type="submit" value="Excluir" style="float:left" />	
<? 
}else{
	?>
<span id="alerta_atividades" style="color:red; font-size:12px; margin-left:-22px;"><?=$alerta?></span>
	<?
}
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