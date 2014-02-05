<?
//Includes
// configuração inicial do sistema
include("../../../_config.php");
// funções base do sistema
include("../../../_functions_base.php");
// funções do modulo pedido eleitoral
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
<form onsubmit="return validaForm(this)" class="form_float" method="post" autocomplete="off">
<!-- Sempre usar fieldset e nao esquecer de colocar o numero da legenda na funcao aba_form-->
  <fieldset id='campos_1' >
<legend>
<strong>Informacoes</strong>
</legend>
<?
	if($pedido_q->id>0){ 
		$eleitor_nome = mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_eleitores WHERE id='".$pedido_q->eleitor_id."'"));
    }
?>
<label style="width:380px;">
   	Eleitor<input name="eleitor_nome_busca" id="profissao_nome_busca" value="<?= $eleitor_nome->nome?>" busca='modulos/eleitoral/pedidos/busca_eleitor.php,@r0,@r1-value>eleitor_id,0' autocomplete="off" > 
	<input type="hidden" id="eleitor_id" name="eleitor_id" value="<? if($pedido_q->id>0){echo $pedido_q->eleitor_id;}?>"/>
   	 <!--<a href="<modulos/eleitoral/eleitores/form_eleitor.php?tela_pedido=132" target="carregador" class="mais"></a>-->
      
</label>
<div style="clear:both"></div>
<label style="width:100px;">
   	Data do Pedido
   	  <input type="text" id='data_pedido' readonly name="data_pedido" value="<? if($pedido_q->id<=0){echo date("d/m/Y");}else{echo DataUsaToBr($pedido_q->data_inicio);}?>"/> 
</label>
<label  style="width:150px">
   	Tipo de pedido <select name="tipo_pedido" id="tipo_pedido">
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
		<textarea name="narrativa_solucao" id='narrativa_solucao' style="height:80px;"><?= $pedido_q->narrativa_solucao?></textarea>
	</label>
<div style="clear:both"></div>
<label style="width:200px;">
   	Setor<select name="setor_id" id="setor_id">
    		<option value="0"></option>
		<?
        	$nomesetor='';
			$setor_q = mysql_query("SELECT * FROM eleitoral_setor WHERE vkt_id='$vkt_id'");
			while($setor=mysql_fetch_object($setor_q)){
				$coordenador=mysql_fetch_object(mysql_query("SELECT * FROM eleitoral_colaboradores WHERE id='{$setor->coordenador_id}' "))
		?>
				
                <option 
                onclick="document.getElementById('busca_coordenador_nome').value=this.getAttribute('title'); document.getElementById('coordenador_id').value=this.getAttribute('title2'); " title="<?=$coordenador->nome?>" title2="<?=$coordenador->id?>" value="<?= $setor->id?>" <? if($pedido_q->setor_id==$setor->id){ echo "selected='selected'";} ?>><?= $setor->nome?> </option>	
		<?
            }
		?>
        
	</select>
    <!--<a href="modulos/eleitoral/cadastros/form_setor.php?tela_pedido=132" target="carregador" class="mais"></a>-->
</label>
<div style="clear:both"></div> 
<label style="width:380px;">
   	Respons&aacute;vel
    <?
    if($pedido_q->id>0){
		$colaborador=mysql_fetch_object(mysql_query($trace="SELECT * FROM eleitoral_colaboradores WHERE id='".$pedido_q->coordenador_id."'"));
		//echo $trace;
	}
	?>
      <input type="text" name="busca_coordenador_nome" id='busca_coordenador_nome' onchange="document.getElementById('coordenador_id').value=this.getAttribute('title2')" readonly="readonly" value="<?= $colaborador->nome ?>"/>
      <input type="hidden" id="coordenador_id" name="coordenador_id" value="<?= $colaborador->id ?>" />
       <!--<a href="modulos/eleitoral/eleitores/form_eleitor.php?tela_pedido=132" target="carregador" class="mais"></a>--> 
</label>
    <div style="clear:both"></div>
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