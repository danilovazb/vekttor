<?
//Includes
// configuraçao inicial do sistema
include("../../../_config.php");
// funçoes base do sistema
include("../../../_functions_base.php");
// funçoes do modulo pedido eleitoral
include("_functions.php");
include("_ctrl.php");
print_r($_POST);
print_r($_GET);
?>
<link href="file://///10.0.1.22/htdocs/clientes/nv/fontes/css/sis.css" rel="stylesheet" type="text/css" />
<div>
<div id='aSerCarregado'>
<div>
<div>
<div class='t3'></div>
<div class='t1'></div>
<div class="dragme" >
<a class='f_x' onclick="form_x(this)"></a>Pedidos<span></span></div>
</div>
<form onsubmit="return validaForm(this)" class="form_float" method="post">
<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
  <fieldset id='campos_1' >
<legend>
<strong>Informacoes</strong>
</legend>
<label style="width:380px;">
   	Eleitor 
   	  <input type="text" name="eleitor_id" id='eleitor_id' value="<?=$pedido_q->eleitor_id?>"> 
	  <a href="<?= $caminho ?>modulos/eleitoral/eleitores/form_eleitor.php?tela_pedido=132" target="carregador" class="mais"></a>
      
</label>
<div style="clear:both">
<label style="width:100px;">
   	Data do Pedido
   	  <input type="text" id='data_pedido' readonly name="data_pedido" value="<? if($pedido_q->id<=0){echo date("d/m/Y");}else{echo DataUsaToBr($pedido_q->data_inicio);}?>"/> 
</label>
<label  style="width:150px">
   	Tipo de pedido <select name="tipo_contato" id="tipo_contato">
    	<option value="Normal">Normal</option>
        <option value="Pedido">Pedido</option>
        <option value="Reclamacao">Reclamacao</option>
	</select>
</label>
<label style="width:99px;">
   	Data do Retorno
   	  <input type="text" id='data_retorno' name="data_retorno" autocomplete='off' maxlength="44" mascara='__/__/____' calendario='1' 
      value="<?
	  if($pedido_q->id>0){
		  echo DataUsaToBr($pedido_q->data_retorno);
	  }else{
		 echo date("d/m/Y");}
	  ?>"/> 
</label>
<div style="clear:both"></div>
	Assunto/Solicitacao<br>
	<label style="width:380px;">
		<textarea name="solicitacao" id='solicitacao' style="height:80px;"><?= $pedido_q->solicitacao ?></textarea>
	</label>
<div style="clear:both"></div>
	Narrativa da Solucao/Motivo<br>
	<label style="width:380px;">
		<textarea name="narrativa_solucao" id='narrativa_solucao' style="height:80px;"><?= $pedido_q->solicitacao ?></textarea>
	</label>
<div style="clear:both"></div>
<label style="width:200px;">
   	Setor Responsavel<select name="setor_id" id="setor_id">
    	<?
        	$nomesetor='';
			$setor_q = mysql_query("SELECT * FROM eleitoral_setor");
			if($pedido_q->id>0){
				$nomesetor = mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_setor WHERE id='".$pedido_q->setor_id."'"));	
				echo $trace;	
		?>
        	<option value="<?= $pedido_q->setor_id?>"><?= $nomesetor->nome?></option>
        <?
			}
			
			while($setor=mysql_fetch_object($setor_q)){
				if($setor->id!=$nomesetor->id){
		?>
				
                <option value="<?= $setor->id?>"><?= $setor->nome?></option>	
		<?
				}
            }
		?>
        
	</select>
    <a href="<?= $caminho ?>modulos/eleitoral/cadastros/form_setor.php?tela_pedido=132" target="carregador" class="mais"></a>
</label>
<div style="clear:both"></div> 
<label style="width:380px;">
   	Coordenador 
   	  <input type="text" name="coordenador_id" id='coordenador_id' value="<?= $pedido_q->coordenador_id ?>">
       <a href="<?= $caminho ?>modulos/eleitoral/eleitores/form_eleitor.php?tela_pedido=132" target="carregador" class="mais"></a> 
</label>
    <div style="clear:both">
<label  style="width:150px">
   	Prioridade do pedido <select name="prioridade_pedido" id="prioridade_pedido">
    	<option value="alta" <? if($pedido_q->prioridade=="alta"){echo "selected";} ?>>Alta</option>
        <option value="media" <? if($pedido_q->prioridade=="media"){echo "selected";} ?>>Normal</option>
        <option value="baixa" <? if($pedido_q->prioridade=="baixa"){echo "selected";} ?>>Baixa</option>
	</select>
</label>
<?
	if($pedido_q->id>0){
?>
<label  style="width:150px">
   	Staus do pedido <select name="status_pedido" id="status_pedido">
		<option value="emandamento" <? if($pedido_q->status_pedido=="emandamento"){echo "selected";} ?>>Em andamento</option>
        <option value="resolvido" <? if($pedido_q->status_pedido=="resolvido"){echo "selected";} ?>>Resolvido</option>
	</select>
</label>
<?
	}
?>
</fieldset>
<input name="id" type="hidden" value="<?=$pedido_q->id?>" />

<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >
<!---------------------------------------------------Dados cadastrais----------------------->
<!--Fim dos fiels set-->

<div style="width:100%; text-align:center" >

<?
if($pedido_q->id>0){
?>
<input name="action" type="submit" value="Excluir" style="float:left" />
<input name="action" type="submit" value="Imprimir" style="float:left" />
<?
}
?>
<input name="action" type="submit" value="Salvar" style="float:right" />
<div style="clear:both"></div>
</div>
</form>
</div>
</div>
</div>
<script>top.openForm()</script>


